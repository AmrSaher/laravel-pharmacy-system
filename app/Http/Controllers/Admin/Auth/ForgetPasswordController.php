<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    public function create()
    {
        return view('auth.forget-password');
    }
}
