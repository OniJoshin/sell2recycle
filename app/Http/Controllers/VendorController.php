<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        return view('dashboard.vendor'); // or admin/user
    }
}
