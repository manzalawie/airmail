<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\ArabicPdfExportService;
use Elibyy\TCPDF\Facades\TCPDF;

use Auth;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $users = User::withTrashed();
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $users->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Role filter
        if ($request->has('role') && $request->input('role') != 'all') {
            $role = $request->input('role');
            $users->whereHas('roles', function($query) use ($role) {
                $query->where('name', $role);
            });
        }

        if ($request->has('export')) {
            $usersQuery = $users->get();
            
            if ($request->export == 'pdf') {
                $pdfService = new ArabicPdfExportService();
                return $pdfService->exportUsers($usersQuery);
            }
            if ($request->export == 'excel') {
                return Excel::download(new UsersExport($usersQuery), 'users-list.xlsx');
            }
        }
        
        $users = $users->paginate(10);
        $role = $user->getRoleNames()->first() ?? 'User';
        $roles = Role::all();
        
        return view('pages.users.index', [
            'roleName' => ucfirst($role),
            'users' => $users,
            'roles' => $roles,
            'filters' => [
                'search' => $request->input('search', ''),
                'role' => $request->input('role', 'all')
            ]
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

    public function update(Request $request , $id)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'national_id' => 'required|string|size:14|regex:/^[0-9]+$/',
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'name_ar' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20|regex:/^[0-9]+$/',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ];

        $messages = [
            'national_id.size' => __('messages.national_id_size'),
            'national_id.regex' => __('messages.national_id_regex'),
            'phone.regex' => __('messages.phone_regex'),
            'password.confirmed' => __('messages.password_confirmed'),
        ];

        $validatedData = $request->validate($rules, $messages);

        $user = User::findOrFail($id);
        $newRole = $request->role;
        $selectedPermissions = $request->permissions ?? [];


        $updateData = $request->only(['name', 'national_id', 'username', 'name_ar', 'phone', 'address']);

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $user->update($updateData);
        
        $this->syncRoleAndPermissions($user, $newRole, $selectedPermissions);
        
        return redirect()->back()->with('success', __('messages.user_updated'));
    }

    public function destroy($id)
    {
        $userToDelete = User::findOrFail($id);
        
        $userToDelete->deleted_by = Auth::id();
        $userToDelete->save();
        
        $userToDelete->delete();
        
        return redirect()->back()->with('success', __('messages.user_deleted'));
    }
    
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restored_by = Auth::id();
        $user->restore();
        
        return redirect()->route('users.index')
            ->with('success', __('messages.user_restored'));
    }

    protected function syncRoleAndPermissions(User $user, string $newRole, array $selectedPermissions)
    {
        $currentRole = $user->role;
        
        $newRolePermissions = Role::where('name', $newRole)->first()
                            ->permissions->pluck('name')->toArray();

        $currentDirectPermissions = $user->getDirectPermissions()
                                    ->pluck('name')
                                    ->toArray();

        $permissionsToRemove = array_diff($currentDirectPermissions, $selectedPermissions);

        $finalPermissions = array_unique(array_merge(
            $newRolePermissions,
            $selectedPermissions
        ));

        if ($currentRole !== $newRole) {
            $user->syncRoles([$newRole]);
        }

        if (!empty($permissionsToRemove)) {
            $user->revokePermissionTo($permissionsToRemove);
        }

        $user->syncPermissions($finalPermissions);
    }

    public function getDirectPermissions()
    {
        return $this->permissions()->whereDoesntHave('roles', function($q) {
            $q->where('name', $this->role);
        })->get();
    }
}
