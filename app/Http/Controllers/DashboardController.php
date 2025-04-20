<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->getRoleNames()->first() ?? 'User';
        
        return view('dashboard', [
            'roleName' => ucfirst($role),
            'userName' => $user->name
        ]);
    }
}
