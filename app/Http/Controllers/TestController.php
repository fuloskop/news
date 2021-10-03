<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TestController extends Controller
{
    //

    public function test()
    {


        $user = User::find(13);

        //$user->categories()->attach(6);



        //$admin = "admin";
        //$user->assignRole($admin);

        //$role = Role::create(['name' => 'user']);
        //$permission = Permission::create(['name' => 'can comment']);
        //$role->givePermissionTo($permission);

        //$editor_role = Role::create(['name' => 'editor']);

        //$user->assignRole('user');

        return $user->categories;
    }
}
