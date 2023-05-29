<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['requird', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'string'],
            'password_confirmation' => ['required'],
            'national_id' => ['integer'],
            'mobile_number' => ['integer'],
            'gender' => ['required', 'string'],
            'date_of_birth' => ['date']
        ]);

        if ($request->input('password') === $request->input('password_confirmation')) {
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'national_id' => $request->input('national_id'),
                'gender' => $request->input('gender'),
                'date_of_birth' => $request->input('date_of_birth'),
                'mobile_number' => $request->input('mobile_number')
            ]);

            return redirect()->route('admin.users.index');
        }

        return back()->withErrors([
            'password' => 'yyyyy'
        ])->onlyInput('password');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['requird', 'string'],
            'email' => ['required', 'email'],
            'password' => ['min:6', 'string'],
            'national_id' => ['integer'],
            'mobile_number' => ['integer'],
            'gender' => ['required', 'string'],
            'date_of_birth' => ['date']
        ]);

        $main_params = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'national_id' => $request->input('national_id'),
            'gender' => $request->input('gender'),
            'mobile_number' => $request->input('mobile_number'),
            'date_of_birth' => $request->input('date_of_birth')
        ];

        if (is_null($request->input('password'))) {
            $user->update($main_params);
        } else {
            if ($request->input('password') === $request->input('password_confirmation')) {
                $user->update([
                    ...$main_params,
                    'password' => $request->input('password')
                ]);
            } else {
                return back()->withErrors([
                    'password' => 'yyyyy'
                ])->onlyInput('password');
            }
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }

    /**
     * Transport users database table to excel file.
     */
    public function export()
    {
        $users = array_map(function ($user) {
            return [
                $user->id,
                $user->name,
                $user->email,
                $user->national_id,
                $user->gender,
                $user->date_of_birth,
                $user->mobile_number,
                $user->created_at
            ];
        }, [...User::all()]);

        $headings = [
            'ID',
            'Name',
            'Email',
            'National ID',
            'Gender',
            'Date of birth',
            'Mobile number',
            'Created at'
        ];

        $export = new MainExport([$users], $headings);

        return Excel::download($export, 'users.xlsx');
    }
}
