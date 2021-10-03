<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
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
        $deleteduser = \App\Models\User::factory()->create([
            'username' => 'Deleted_User',
            'email' => 'Deleted_User',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'can comment']);
        Permission::create(['name' => 'delete own comment']);
        Permission::create(['name' => 'access admin panel']);
        Permission::create(['name' => 'give admin and moderator permission']);
        Permission::create(['name' => 'give editor permission']);
        Permission::create(['name' => 'access editor panel']);
        Permission::create(['name' => 'create news']);


        $admin_role = Role::create(['name' => 'admin']);
        $admin_role->givePermissionTo('can comment');
        $admin_role->givePermissionTo('delete own comment');
        $admin_role->givePermissionTo('access admin panel');
        $admin_role->givePermissionTo('give admin and moderator permission');
        $admin_role->givePermissionTo('give editor permission');
        $admin_role->givePermissionTo('access editor panel');
        $admin_role->givePermissionTo('create news');

        $mod_role = Role::create(['name' => 'moderator']);
        $mod_role->givePermissionTo('can comment');
        $mod_role->givePermissionTo('delete own comment');
        $mod_role->givePermissionTo('access admin panel');
        $mod_role->givePermissionTo('give editor permission');
        $mod_role->givePermissionTo('access editor panel');
        $mod_role->givePermissionTo('create news');

        $editor_role = Role::create(['name' => 'editor']);
        $editor_role->givePermissionTo('access editor panel');
        $editor_role->givePermissionTo('create news');


        $user_role = Role::create(['name' => 'user']);
        $user_role->givePermissionTo('can comment');
        $user_role->givePermissionTo('delete own comment');

        $user = \App\Models\User::factory()->create([
            'username' => 'fuloskop',
            'email' => 'muvaffaki@hotmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $user->assignRole($admin_role);


    }
}
