<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'access admin panel']);
        Permission::create(['name' => 'give admin and moderator permission']);
        Permission::create(['name' => 'give editor permission']);
        Permission::create(['name' => 'manage editor categories']);
        Permission::create(['name' => 'access editor panel']);
        Permission::create(['name' => 'create news']);
        Permission::create(['name' => 'create news without category']);
        Permission::create(['name' => 'manage comments']);
        Permission::create(['name' => 'access logs']);
        Permission::create(['name' => 'access user and editor activities']);
        Permission::create(['name' => 'access all activities']);
        Permission::create(['name' => 'access all news']);
        Permission::create(['name' => 'access all categories']);
        Permission::create(['name' => 'manage old news']);

        $user_role = Role::create(['name' => 'user']);

        $editor_role = Role::create(['name' => 'editor']);
        $editor_role->syncPermissions($user_role->permissions);
        $editor_role->givePermissionTo('access editor panel');
        $editor_role->givePermissionTo('create news');


        $mod_role = Role::create(['name' => 'moderator']);
        $mod_role->syncPermissions($editor_role->permissions);
        $mod_role->givePermissionTo('access admin panel');
        $mod_role->givePermissionTo('give editor permission');
        $mod_role->givePermissionTo('manage editor categories');
        $mod_role->givePermissionTo('create news without category');
        $mod_role->givePermissionTo('manage comments');
        $mod_role->givePermissionTo('access user and editor activities');
        $mod_role->givePermissionTo('access all news');
        $mod_role->givePermissionTo('access all categories');



        $admin_role = Role::create(['name' => 'admin']);
        $admin_role->syncPermissions($mod_role->permissions);
        $admin_role->givePermissionTo('give admin and moderator permission');
        $admin_role->givePermissionTo('access all activities');
        $admin_role->givePermissionTo('access logs');
        $admin_role->givePermissionTo('manage old news');



        $user = \App\Models\User::factory()->create([
            'username' => 'fuloskop',
            'email' => 'muvaffaki@hotmail.com',
            'password' => Hash::make('password'), // password
        ]);
        $user->assignRole($admin_role);

        $user1 = \App\Models\User::factory()->create([
            'username' => 'moderator',
            'email' => 'moderator@hotmail.com',
            'password' => Hash::make('password'), // password
        ]);
        $user1->assignRole($mod_role);

        $user2 = \App\Models\User::factory()->create([
            'username' => 'editor',
            'email' => 'editor@hotmail.com',
            'password' => Hash::make('password'), // password
        ]);
        $user2->assignRole($editor_role);
    }
}
