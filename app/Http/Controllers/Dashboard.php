<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    //
    public function admin(Request $request)
    {
        $role = $request->session()->get('role');
        if ($role == 1) {
            return view('admin/dashvoard');
        }
    }
}
