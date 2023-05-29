<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Exports\MainExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class DoctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();

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
        $users = User::all();

        return view('admin.doctors.create', [
            'pharmacies' => $pharmacies,
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user' => ['required', 'integer'],
            'pharmacy' => ['required', 'integer']
        ]);

        $user = User::find($request->input('user'));
        $userRoleNames = array_values((array) $user->getRoleNames())[0];

        if (
            in_array('pharmacy', $userRoleNames) || 
            in_array('doctor', $userRoleNames) || 
            in_array('admin', $userRoleNames)
        ) {
            return back()->withErrors([
                'user' => 'This owner already has a role.'
            ])->onlyInput('user');
        }

        $user->assignRole('doctor');

        Doctor::create([
            'user_id' => $request->input('user'),
            'pharmacy_id' => $request->input('pharmacy')
        ]);

        return redirect()->route('admin.doctors.index');
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
                $doctor->status,
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
