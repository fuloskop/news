<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use App\Models\DeleteAccountRequest;
use App\Models\User;

class AdminRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllUsers()
    {
        return User::all();
    }

    public function getAllAccountDeleteRequest()
    {
        return DeleteAccountRequest::all();
    }

    public function getUsersById($id)
    {
        return User::findOrFail($id);
    }

    public function getAccountDeleteRequestById($id)
    {
        return DeleteAccountRequest::findOrFail($id);
    }

    public function getAccountDeleteRequestEnd($data,$id)
    {
        $RequestToEnded =  $this->getAccountDeleteRequestById($id);

        if($data['request_status']=='accepted'){
            $DeleteUser =$this->getUsersById($RequestToEnded->user_id);
            $data['answer'] = $data['answer']." Username = $DeleteUser->username";
            $RequestToEnded->update($data);
            $this->DestroyUser($DeleteUser);
        }
        else{
            $RequestToEnded->update($data);
        }
    }

    public function DestroyUser(User $user)
    {
        $user->delete();
    }

    public function getAllEditorUsers()
    {
        return User::role('editor')->get();
    }

    public function getAllCategories()
    {
        return Category::all();
    }
}
