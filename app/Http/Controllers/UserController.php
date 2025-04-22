<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Auth;

class UserController extends Controller
{
    public function index(){

        $user = Auth::user();
        $users = User::withTrashed()->paginate(10);
        $role = $user->getRoleNames()->first() ?? 'User';
        $roles = Role::all();
        
        return view('pages.users.index', [
            'roleName' => ucfirst($role),
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function create(){

        $roles = Role::all();
        $permissions = Permission::all();

        return view('pages.users.create',[
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request)
    {
        dd($request);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        
        $role = $user->roles->first();
        $userPermissions = collect($user->permissions)
        ->pluck('name')
        ->merge(optional($role)->permissions->pluck('name'))
        ->unique()
        ->toArray();

        $userRole = $user->roles->pluck('name')->first();
        
        return view('pages.users.edit', compact('user', 'roles', 'permissions', 'userPermissions', 'userRole'));
    }

    public function update(Request $request)
    {
        dd($request);
    }

    public function destroy($id)
    {
        $userToDelete = User::findOrFail($id);
        
        $userToDelete->deleted_by = Auth::id();
        $userToDelete->save();
        
        $userToDelete->delete();
        
        return redirect()->back()->with('success', 'User has been deleted successfully');
    }
    
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restored_by = Auth::id();
        $user->restore();
        
        return redirect()->route('users.index')
            ->with('success', 'User has been restored successfully');
    }
}
