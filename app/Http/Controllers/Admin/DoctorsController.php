<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Exports\MainExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class DoctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $doctors = $user->hasRole('admin') ?
                    Doctor::all() :
                    $user->pharmacy->doctors;

        return view('admin.doctors.index', [
            'doctors' => $doctors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pharmacies = Pharmacy::all();

        return view('admin.doctors.create', [
            'pharmacies' => $pharmacies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'string'],
            'password_confirmation' => ['required'],
            'national_id' => ['integer', 'unique:users,national_id'],
            'mobile_number' => ['string'],
            'gender' => ['required', 'string'],
            'date_of_birth' => ['date'],
            'pharmacy' => ['required', 'integer']
        ]);

        if ($request->input('password') === $request->input('password_confirmation')) {
            // if ($request->file('image')) {
            //     $name = $request->file('image')->getClientOriginalName();
            //     $path = $request->file('image')->store('public/images');
            // }

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'national_id' => $request->input('national_id'),
                'gender' => $request->input('gender'),
                'date_of_birth' => $request->input('date_of_birth'),
                'mobile_number' => $request->input('mobile_number'),
                // 'profile_image' => $path
            ]);
            $user->assignRole('doctor');

            Doctor::create([
                'user_id' => $user->id,
                'pharmacy_id' => $request->input('pharmacy')
            ]);
            
            Session::flash('message', [
                'type' => 'success',
                'message' => 'Doctor created successfully!'
            ]);
    
            return redirect()->route('admin.doctors.index');
        }

        return back()->withErrors([
            'password' => 'yyyyy'
        ])->onlyInput('password');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $pharmacies = Pharmacy::all();
        $users = User::all();

        return view('admin.doctors.edit', [
            'doctor' => $doctor,
            'pharmacies' => $pharmacies,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'user' => ['required', 'integer'],
            'pharmacy' => ['required', 'integer']
        ]);

        if ($request->input('user') != $doctor->user->id) {
            $oldUser = User::find($doctor->user->id);
            $oldUser->removeRole('doctor');
            $oldUser->assignRole('user');

            $newUser = User::find($request->input('user'));
            $userRoleNames = array_values((array) $newUser->getRoleNames())[0];

            if (
                in_array('pharmacy', $userRoleNames) ||
                in_array('doctor', $userRoleNames) ||
                in_array('admin', $userRoleNames)
            ) {
                return back()->withErrors([
                    'user' => 'This owner already has a role.'
                ])->onlyInput('user');
            }

            $newUser->assignRole('doctor');
        }

        $doctor->update([
            'user_id' => $request->input('user'),
            'pharmacy_id' => $request->input('pharmacy')
        ]);

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Doctor (' . $doctor->user->name . ') updated successfully!'
        ]);

        return redirect()->route('admin.doctors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $user = User::find($doctor->user->id);
        $user->removeRole('doctor');
        $user->assignRole('user');

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Doctor (' . $user->name . ') deleted successfully!'
        ]);

        $doctor->delete();
        return back();
    }

    /**
     * Ban and unban doctors with laravel ban.
     */
    public function ban(Doctor $doctor)
    {
        if ($doctor->isBanned()) {
            $doctor->unban();
        } else {
            $doctor->ban();
        }

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Doctor (' . $doctor->user->name . ') ' .
                ($doctor->isBanned() ? 'unbanned' : 'banned') .
                ' successfully!'
        ]);

        return back();
    }

    /**
     * Transport doctors database table to excel file.
     */
    public function export()
    {
        $doctors = array_map(function ($doctor) {
            return [
                $doctor->id,
                $doctor->user->name,
                $doctor->user->email,
                $doctor->user->national_id,
                $doctor->pharmacy->name,
                $doctor->isBanned() ? 'banned' : 'active',
                $doctor->created_at
            ];
        }, [...Doctor::all()]);

        $headings = [
            'ID',
            'Name',
            'Email',
            'National ID',
            'Pharmacy',
            'Status',
            'Created at'
        ];

        $export = new MainExport([$doctors], $headings);

        return Excel::download($export, 'doctors.xlsx');
    }
}
