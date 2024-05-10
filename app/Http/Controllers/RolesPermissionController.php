<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionController extends Controller
{

    public function show()
    {
        $roles = Role::all();

        return view('roles_and_permission.index', compact('roles'));
    }

    //
    public function addPermissions(Request $request)
    {
        $permissions = [
            'Browse Story',
            'Purchase Story',
            'Rate Story',
            'Create Story',
            'Sale Story',
            'Moderate Story',
            'Manage User',
            'Manage roles and permission'
        ];

        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }
    }

    public function createRole()
    {
        $permissions = Permission::all();

        // $users = User::select('type')->get();
        $userTypes = User::distinct()->pluck('type')->toArray();

        return view('roles_and_permission.create-role', compact('permissions', 'userTypes'));
    }

    //Give permission and role

    public function create(Request $request)
    {
        $role = Role::create(['name' => $request->name]);

        foreach ($request->permission as $permission) {

            $role->givePermissionTo($permission);
        }

        foreach ($request->types as $type) {

            $userType = User::where('type', $type)->first();

            if ($userType) {

                $userType->assignRole($role->name);
            }
        }

        return redirect('dashboard/roles-and-permission');
    }


    public function editRole($id)
    {
        $role = Role::where('id', $id)
            ->with('permissions', 'users')
            ->first();
        $permissions = Permission::all();
        $users = User::select('type')->get();

        return view('roles_and_permission.edit-role', compact('role', 'permissions', 'users'));
    }

    public function updateRole(Request $request)
    {
        $role = Role::where('id', $request->id)->first();
        $role->name = $request->name;
        $role->update();

        $role->syncPermissions($request->permission);

        DB::table('model_has_roles')->where('role_id', $request->id)->delete();

        // foreach ($request->users as $user) {
        //     $user = User::find($user);
        //     $user->assignRole($role->name);
        // }

        return redirect('dashboard/roles-and-permission');
    }

    public function delete($id)
    {
        Role::where('id', $id)->delete();

        return redirect('dashboard/roles-and-permission');
    }
}
