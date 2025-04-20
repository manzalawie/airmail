<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Auth;

class UserController extends Controller
{
    public function index(){

        $user = Auth::user();
        $users = User::paginate(10);
        $role = $user->getRoleNames()->first() ?? 'User';
        $roles = Role::all();
        
        return view('pages.users.index', [
            'roleName' => ucfirst($role),
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
