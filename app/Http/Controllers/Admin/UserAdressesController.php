<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddressRequest;
use App\Models\Governorate;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class UserAdressesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userAddresses = UserAddress::all();

        return view('admin.user_addresses.index', [
            'userAddresses' => $userAddresses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $governorates = Governorate::all();

        return view('admin.user_addresses.create', [
            'users' => $users,
            'governorates' => $governorates
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserAddressRequest $request)
    {
        $attrs = $request->all();

        $attrs['user_id'] = $attrs['user'];
        $attrs['governorate_id'] = $attrs['governorate'];
        unset($attrs['user']);
        unset($attrs['governorate']);

        UserAddress::create($attrs);

        Session::flash('message', [
            'type' => 'success',
            'message' => 'User Address (' . $request->input('street_name') . ') created successfully!'
        ]);

        return redirect()->route('admin.user_addresses.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserAddress $userAddress)
    {
        $users = User::all();
        $governorates = Governorate::all();

        return view('admin.user_addresses.edit', [
            'userAddress' => $userAddress,
            'users' => $users,
            'governorates' => $governorates
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserAddressRequest $request, UserAddress $userAddress)
    {
        $attrs = $request->all();

        $attrs['user_id'] = $attrs['user'];
        $attrs['governorate_id'] = $attrs['governorate'];
        unset($attrs['user']);
        unset($attrs['governorate']);

        $userAddress->update($attrs);

        Session::flash('message', [
            'type' => 'success',
            'message' => 'User Address (' . $request->input('street_name') . ') updated successfully!'
        ]);

        return redirect()->route('admin.user_addresses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAddress $userAddress)
    {
        Session::flash('message', [
            'type' => 'success',
            'message' => 'User Address (' . $userAddress->street_name . ') deleted successfully!'
        ]);

        $userAddress->delete();
        return back();
    }

    /**
     * Transport pharmacies database table to excel file.
     */
    public function export()
    {
        $userAddresses = array_map(function ($userAddress) {
            return [
                $userAddress->id,
                $userAddress->flat_number,
                $userAddress->floor_number,
                $userAddress->building_number,
                $userAddress->street_name,
                $userAddress->area_id,
                $userAddress->user->name,
                $userAddress->governorate->name,
                $userAddress->created_at
            ];
        }, [...UserAddress::all()]);

        $headings = [
            'ID',
            'Flat Number',
            'Floor Number',
            'Building Number',
            'Street Name',
            'Area ID',
            'User',
            'Governorate',
            'Created at'
        ];

        $export = new MainExport([$userAddresses], $headings);

        return Excel::download($export, 'user_addresses.xlsx');
    }
}
