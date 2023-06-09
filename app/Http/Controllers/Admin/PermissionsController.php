<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('admin.permissions.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'name' => ['required', 'string', 'unique:permissions,name']
        ]);

        Permission::create($attrs);

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Permission (' . $request->input('name') . ') created successfully!'
        ]);

        return redirect()->route('admin.permissions.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $attrs = $request->validate([
            'name' => ['required', 'string']
        ]);

        $permission->update($attrs);

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Permission (' . $request->input('name') . ') updated successfully!'
        ]);

        return redirect()->route('admin.permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        Session::flash('message', [
            'type' => 'success',
            'message' => 'Permission (' . $permission->name . ') deleted successfully!'
        ]);

        $permission->delete();
        return back();
    }

    /**
     * Transport permissions database table to excel file.
     */
    public function export()
    {
        $permissions = array_map(function ($permission) {
            return [
                $permission->id,
                $permission->name,
                $permission->created_at
            ];
        }, [...Permission::all()]);

        $headings = [
            'ID',
            'Name',
            'Created at'
        ];

        $export = new MainExport([$permissions], $headings);

        return Excel::download($export, 'permissions.xlsx');
    }
}
