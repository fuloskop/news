<?php

namespace App\Http\Services\Auth;

use Illuminate\Support\Facades\Hash;
use App\Http\Repositories\Auth\LoginRepository;


class LoginService
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
