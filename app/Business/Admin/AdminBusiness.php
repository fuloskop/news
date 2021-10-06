<?php

namespace App\Business\Admin;

use App\Models\User;
use App\Repositories\Admin\AdminRepository;


class AdminBusiness
{
    protected $AdminRepository;
    protected $logger;

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
        $RequestToEnded =  $this->getAccountDeleteRequestById($id);
        if($data['request_status']=='accepted'){
            $DeleteUser =$this->getUsersById($RequestToEnded->user_id);
            $data['answer'] = $data['answer']." Username = $DeleteUser->username";
            $this->AdminRepository->getAccountDeleteRequestEnd($RequestToEnded,$data);
            $this->destroyUser($DeleteUser);
        }else{
            $this->AdminRepository->getAccountDeleteRequestEnd($RequestToEnded,$data);
        }

    }

    public function destroyUser(User $user)
    {
        $this->AdminRepository->DestroyUser($user);
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
        return $user->hasRole('editor');
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

    public function assignRole($id,$role)
    {
        $user = $this->getUsersById($id);
        $this->AdminRepository->assignRole($user,$role);
    }

    public function removeRole($id,$role)
    {
        $user = $this->getUsersById($id);
        $this->AdminRepository->removeRole($user,$role);
        $this->removeAllCategories($user);
    }

    public function removeAllCategories($user)
    {
        $this->AdminRepository->detachCategories($user);
    }

    public function assignCategory($id,$category_id)
    {
        $user = $this->getUsersById($id);
        $this->AdminRepository->attachCategory($user,$category_id);
    }

    public function removeCategory($id,$category_id)
    {
        $user = $this->getUsersById($id);
        $this->AdminRepository->detachCategory($user,$category_id);
    }

    public function getAllLogs()
    {
        return $this->AdminRepository->getAllLogs();
    }

    public function getAllActivities()
    {
        $user = auth()->user();
        $activity =  $this->AdminRepository->getAllActivities();

        return $activity->latest()->get();
    }

}
