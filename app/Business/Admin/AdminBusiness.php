<?php

namespace App\Business\Admin;

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

       $DeleteAccountRequest = $this->AdminRepository->getAccountDeleteRequestEnd($data,$id);
        //dd($DeleteAccountRequest);

    }

    public function getUsersById($id)
    {
        return $this->AdminRepository->getUsersById($id);
    }

}
