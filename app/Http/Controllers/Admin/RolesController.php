<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();

        return view('admin.roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('admin.roles.create', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'name' => ['required', 'string', 'unique:roles,name']
        ]);

        $role = Role::create($attrs);
        $role->syncPermissions($request->input('permissions'));

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Role (' . $request->input('name') . ') created successfully!'
        ]);

        return redirect()->route('admin.roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $permissionNames = array_values((array) $role->getPermissionNames())[0];

        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'permissionNames' => $permissionNames
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $attrs = $request->validate([
            'name' => ['required', 'string']
        ]);

        $role->update($attrs);
        $role->permissions()->detach();
        $role->syncPermissions($request->input('permissions'));

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Role (' . $request->input('name') . ') updated successfully!'
        ]);

        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        Session::flash('message', [
            'type' => 'success',
            'message' => 'Role (' . $role->name . ') deleted successfully!'
        ]);

        $role->delete();
        return back();
    }

    /**
     * Transport roles database table to excel file.
     */
    public function export()
    {
        $roles = array_map(function ($role) {
            return [
                $role->id,
                $role->name,
                $role->created_at
            ];
        }, [...Role::all()]);

        $headings = [
            'ID',
            'Name',
            'Created at'
        ];

        $export = new MainExport([$roles], $headings);

        return Excel::download($export, 'roles.xlsx');
    }
}
