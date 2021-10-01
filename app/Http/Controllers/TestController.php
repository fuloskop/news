<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TestController extends Controller
{
    //

    public function test()
    {


        $user = auth()->user();
        //$admin = "admin";
        //$user->assignRole($admin);

        //$role = Role::create(['name' => 'user']);
        //$permission = Permission::create(['name' => 'can comment']);
        //$role->givePermissionTo($permission);

        //$editor_role = Role::create(['name' => 'editor']);

        //$user->assignRole('user');

        return $user->getPermissionsViaRoles();
    }
}
