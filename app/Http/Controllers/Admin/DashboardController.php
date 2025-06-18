<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Solo administradores');
            }

            return view('admin.dashboard');
    }
}