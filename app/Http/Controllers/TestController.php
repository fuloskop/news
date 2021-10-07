<?php

namespace App\Http\Controllers;

use App\Logger\Contact\LoggerInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TestController extends Controller
{
    protected $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function test()
    {

        //$this->logger->error('deneme');

        //$user->categories()->attach(6);

        $user = auth()->user();

        //$user->subCategories()->attach(1);
       // $user->subCategories()->attach(2);

        //$admin = "admin";
        //$user->assignRole($admin);

        //$role = Role::create(['name' => 'user']);
        //$permission = Permission::create(['name' => 'can comment']);
        //$role->givePermissionTo($permission);
        //$role = Role::findByName('admin');
        //$permission = Permission::create(['name' => 'access logs']);
        //$role->givePermissionTo('edit articles');

        //$editor_role = Role::create(['name' => 'editor']);

        //$user->assignRole('user');

        $arrayistenen = ['user', 'editor'];

        $subcategoryidarray = array();
        foreach ($user->subCategories as $subCategory){
            $subcategoryidarray[] = $subCategory->pivot->category_id;
        }


        return $subcategoryidarray;
    }
}
