<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\PharmacyRequest;
use App\Models\Governorate;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class PharmaciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pharmacies = Pharmacy::with('user')->get();

        return view('admin.pharmacies.index', [
            'pharmacies' => $pharmacies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $governorates = Governorate::all();

        return view('admin.pharmacies.create', [
            'users' => $users,
            'governorates' => $governorates
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PharmacyRequest $request)
    {
        $request->validate([
            'name' => ['unique:pharmacies,name']
        ]);

        $user = User::find($request->input('owner'));
        $userRoleNames = array_values((array) $user->getRoleNames())[0];

        if (
            in_array('pharmacy', $userRoleNames) || 
            in_array('doctor', $userRoleNames) || 
            in_array('admin', $userRoleNames)
        ) {
            return back()->withErrors([
                'owner' => 'This owner already has a role.'
            ])->onlyInput('owner');
        }

        $user->assignRole('pharmacy');

        Pharmacy::create([
            'name' => $request->input('name'),
            'priority' => $request->input('priority'),
            'user_id' => $request->input('owner'),
            'governorate_id' => $request->input('governorate')
        ]);

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Pharmacy created successfuly!'
        ]);

        return redirect()->route('admin.pharmacies.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pharmacy $pharmacy)
    {
        $users = User::all();
        $governorates = Governorate::all();

        return view('admin.pharmacies.edit', [
            'pharmacy' => $pharmacy,
            'users' => $users,
            'governorates' => $governorates
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PharmacyRequest $request, Pharmacy $pharmacy)
    {
        $pharmacy->update([
            'name' => $request->input('name'),
            'priority' => $request->input('priority'),
            'user_id' => $request->input('owner'),
            'governorate_id' => $request->input('governorate')
        ]);

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Pharmacy (' . $pharmacy->name . ') updated successfully!'
        ]);

        return redirect()->route('admin.pharmacies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy)
    {
        $user = User::find($pharmacy->user->id);
        $user->removeRole('pharmacy');
        $user->assignRole('user');

        $doctors = $pharmacy->doctors;
        foreach ($doctors as $doctor) {
            $doctorUser = User::find($doctor->user->id);
            $doctorUser->removeRole('doctor');
            $doctorUser->assignRole('user');
        }

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Pharmacy (' . $pharmacy->name . ') deleted successfully!'
        ]);

        $pharmacy->delete();
        return back();
    }

    /**
     * Transport pharmacies database table to excel file.
     */
    public function export()
    {
        $pharmacies = array_map(function ($pharmacy) {
            return [
                $pharmacy->id,
                $pharmacy->name,
                $pharmacy->priority,
                $pharmacy->user->name,
                $pharmacy->governorate->name,
                $pharmacy->created_at
            ];
        }, [...Pharmacy::all()]);

        $headings = [
            'ID',
            'Name',
            'Priority',
            'Owner',
            'Governorate',
            'Created at'
        ];

        $export = new MainExport([$pharmacies], $headings);

        return Excel::download($export, 'pharmacies.xlsx');
    }
}