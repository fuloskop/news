<?php

namespace App\Http\Controllers;

use App\Logger\Contact\LoggerInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TestController extends Controller
{
    protected $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function test(Request $request)
    {

        //Artisan::call('down');


        //$this->logger->error('deneme');

        //$user->categories()->attach(6);

        //$user = auth()->user();

        //$user->subCategories()->attach(1);
       // $user->subCategories()->attach(2);

        //$admin = "admin";
        //$user->assignRole($admin);
        //Permission::create(['name' => 'start stop maintenance']);
        //$role = Role::create(['name' => 'user']);
        //$permission = Permission::create(['name' => 'can comment']);
        //$role->givePermissionTo($permission);
        //$role = Role::findByName('admin');
        //$permission = Permission::create(['name' => 'access logs']);
        //$role->givePermissionTo('edit articles');
        //$role->givePermissionTo('start stop maintenance');
        //$editor_role = Role::create(['name' => 'editor']);

        //$user->assignRole('user');
/*
        $arrayistenen = ['user', 'editor'];

        $subcategoryidarray = array();
        foreach ($user->subCategories as $subCategory){
            $subcategoryidarray[] = $subCategory->pivot->category_id;
        }
**/
        //$roles = $user->getAllPermissions();
        //dd($request->is('test'));


        if(auth()->user()){
            return 1;
        }

        return 2;
    }
}
