<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PharmaciesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\PharmacyRequest;
use App\Models\Governorate;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
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

        Pharmacy::create([
            'name' => $request->input('name'),
            'priority' => $request->input('priority'),
            'owner_id' => $request->input('owner'),
            'governorate_id' => $request->input('governorate')
        ]);

        User::find($request->input('owner'))->assignRole('pharmacy');

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
            'owner_id' => $request->input('owner'),
            'governorate_id' => $request->input('governorate')
        ]);

        return redirect()->route('admin.pharmacies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy)
    {
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
                $pharmacy->created_at->diffForHumans(),
                $pharmacy->updated_at->diffForHumans()
            ];
        }, [...Pharmacy::all()]);

        $export = new PharmaciesExport([$pharmacies]);

        return Excel::download($export, 'pharmacies.xlsx');
    }
}
