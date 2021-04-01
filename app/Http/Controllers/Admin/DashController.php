<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashController extends Controller
{
    public function show()
    {
        // Get data from the database
        return view('admin.dash', ['title' => 'Admin Dashboard']);
    }
}
