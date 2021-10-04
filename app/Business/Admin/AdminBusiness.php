<?php

namespace App\Business\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Admin\AdminRepository;


class AdminBusiness
{
    protected $AdminRepository;

    public function __construct(AdminRepository $AdminRepository)
    {
        $this->AdminRepository = $AdminRepository;
    }

    public function getAllUsers()
    {
        return $this->AdminRepository->getAllUsers();
    }

    public function getAllAccountDeleteRequest()
    {
        return $this->AdminRepository->getAllAccountDeleteRequest();
    }

    public function getAccountDeleteRequestById($id)
    {
        return $this->AdminRepository->getAccountDeleteRequestById($id);
    }

    public function getAccountDeleteRequestEnd($data,$id)
    {
        /*
        if($data['request_status']=='accepted'){
            $data = array_merge($data, ['user_id' => 1]);
        }
        */

       $this->AdminRepository->getAccountDeleteRequestEnd($data,$id);
        //dd($DeleteAccountRequest);

    }

    public function getUsersById($id)
    {
        return $this->AdminRepository->getUsersById($id);
    }

    public function  getAllEditorUsers()
    {
        return $this->AdminRepository->getAllEditorUsers();
    }

    public function isEditor(User $user)
    {
        if(!$user->hasRole('editor')){
            return false;
        }
        return true;
    }

    public function getAllCategories()
    {
        return $this->AdminRepository->getAllCategories();
    }

    public function storeOrUpdateCategory($data, &$id=null)
    {
        $this->AdminRepository->storeOrUpdateCategory($data, $id);
    }

    public function getCategoryById($id)
    {
        return $this->AdminRepository->getCategoryById($id);
    }

    public function destroyCategotyById($id)
    {
        $category = $this->getCategoryById($id);
        $this->AdminRepository->DestroyCategory($category);
    }
}
