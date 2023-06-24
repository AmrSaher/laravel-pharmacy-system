<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Exports\MainExport;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();

        return view('admin.orders.index', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'precription' => ['required']
        ]);

        if ($request->file('precription')) {
            $name = $request->file('precription')->getClientOriginalName();
            $path = $request->file('precription')->store('public/precriptions');
        }

        $user = Auth::user();
        $userAddress = UserAddress::where('user_id', $user->id)
            ->where('is_main', true)
            ->first();
        
        if (is_null($userAddress)) {
            return back()->withErrors([
                'precription' => 'Please create your user address.'
            ])->onlyInput('precription');
        }

        Order::create([
            'status' => 'New',
            'user_id' => $user->id,
            'user_address_id' => $userAddress->id,
            'precription' => 'ss'
        ]);

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Order created successfuly!'
        ]);

        return redirect()->route('admin.orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $doctors = Doctor::all();
        $statuses = [
            'New',
            'Processing',
            'WaitingForUserConfirmation',
            'Canceled',
            'Confirmed',
            'Delivered'
        ];

        return view('admin.orders.edit', [
            'order' => $order,
            'doctors' => $doctors,
            'statuses' => $statuses
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'string']
        ]);

        $order->update([
            'doctor_id' => $request->input('doctor') ?? 'null',
            'status' => $request->input('status')
        ]);

        Session::flash('message', [
            'type' => 'success',
            'message' => 'Order (' . $order->id . ') updated successfully!'
        ]);

        return redirect()->route('admin.orders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        Session::flash('message', [
            'type' => 'success',
            'message' => 'Order (' . $order->id . ') deleted successfully!'
        ]);

        $order->delete();
        return back();
    }

    /**
     * Transport orders database table to excel file.
     */
    public function export()
    {
        $orders = array_map(function ($order) {
            return [
                $order->id,
                $order->created_at
            ];
        }, [...Order::all()]);

        $headings = [
            'ID',
            'Created at'
        ];

        $export = new MainExport([$orders], $headings);

        return Excel::download($export, 'orders.xlsx');
    }
}
