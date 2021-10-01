<?php

namespace App\Business\Auth;

use Illuminate\Support\Facades\Hash;
use App\Repositories\Auth\LoginRepository;


class LoginBusiness
{
    protected $LoginRepository;

    public function __construct(LoginRepository $LoginRepository)
    {
        $this->LoginRepository = $LoginRepository;
    }


    public function login($data)
    {
        return $this->LoginRepository->checklogin($data);
    }


}
