<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class MedicinesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicines = Medicine::latest()->get();

        return view('admin.medicines.index', [
            'medicines' => $medicines
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.medicines.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:medicines,name'],
            'description' => ['required', 'string'],
            'price' => ['required', 'string'],
            'category' => ['required', 'integer']
        ]);

        Medicine::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => ((float) $request->input('price')) * 100,
            'category_id' => $request->input('category'),
            'image_path' => ''
        ]);

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Medicine (' . $request->input('name') . ') created successfully!'
        ]);

        return redirect()->route('admin.medicines.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        $categories = Category::all();

        return view('admin.medicines.edit', [
            'medicine' => $medicine,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'string'],
            'category' => ['required', 'integer']
        ]);

        $medicine->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => ((float) $request->input('price')) * 100,
            'category_id' => $request->input('category')
        ]);

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Medicine (' . $request->input('name') . ') updated successfully!'
        ]);

        return redirect()->route('admin.medicines.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        Session::flash('message', [
            'type' => 'success',
            'message' => 'Medicine (' . $medicine->name . ') deleted successfully!'
        ]);

        $medicine->delete();
        return back();
    }

    /**
     * Transport doctors database table to excel file.
     */
    public function export()
    {
        $medicines = array_map(function ($medicine) {
            return [
                $medicine->id,
                $medicine->image_path,
                $medicine->name,
                $medicine->description,
                ($medicine->price / 100) . '$',
                $medicine->category_id,
                $medicine->created_at
            ];
        }, [...Medicine::all()]);

        $headings = [
            'ID',
            'Image',
            'Name',
            'Description',
            'Price',
            'Category',
            'Created at'
        ];

        $export = new MainExport([$medicines], $headings);

        return Excel::download($export, 'medicines.xlsx');
    }
}
