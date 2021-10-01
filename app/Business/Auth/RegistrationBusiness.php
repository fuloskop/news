<?php

namespace App\Business\Auth;

use Illuminate\Support\Facades\Hash;
use App\Repositories\Auth\RegistrationRepository;


class RegistrationBusiness
{
    protected $RegistrationRepository;

    public function __construct(RegistrationRepository $RegistrationRepository)
    {
        $this->RegistrationRepository = $RegistrationRepository;
    }

    public function hashpassword($pass)
    {
        $pass = Hash::make($pass);
        return $pass;
    }

    public function store($data)
    {
        $data['password'] =  $this->hashpassword($data['password']);
        return $this->RegistrationRepository->store($data);
    }


}
