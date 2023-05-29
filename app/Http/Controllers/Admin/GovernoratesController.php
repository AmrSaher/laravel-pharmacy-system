<?php

namespace App\Http\Controllers\Admin;

use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class GovernoratesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $governorates = Governorate::all();

        return view('admin.governorates.index', [
            'governorates' => $governorates
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.governorates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:governorates,name']
        ]);

        Governorate::create([
            'name' => $request->input('name')
        ]);

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Governorate created successfully!'
        ]);

        return redirect()->route('admin.governorates.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Governorate $governorate)
    {
        return view('admin.governorates.edit', [
            'governorate' => $governorate
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Governorate $governorate)
    {
        $request->validate([
            'name' => ['required', 'string']
        ]);

        $governorate->update([
            'name' => $request->input('name')
        ]);

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Governorate (' . $governorate->name . ') updated successfully!'
        ]);

        return redirect()->route('admin.governorates.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Governorate $governorate)
    {
        Session::flash('message', [
            'type' => 'success',
            'message' => 'Governorate (' . $governorate->name . ') deleted successfully!'
        ]);

        $governorate->delete();
        return back();
    }
}
