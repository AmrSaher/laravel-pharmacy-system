<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $pharmaciesCount = count(Pharmacy::all());
        $doctorsCount = count(Doctor::all());
        $usersCount = count(User::all());
        $ordersCount = 10;

        return view('admin.index', [
            'pharmaciesCount' => $pharmaciesCount,
            'doctorsCount' => $doctorsCount,
            'usersCount' => $usersCount,
            'ordersCount' => $ordersCount
        ]);
    }
}
