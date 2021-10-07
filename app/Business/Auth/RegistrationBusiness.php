<?php

namespace App\Business\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Auth\RegistrationRepository;


class RegistrationBusiness
{
    protected $RegistrationRepository;

    const USER_DEFAULT_ROLE= "user";

    public function __construct(RegistrationRepository $RegistrationRepository)
    {
        $this->RegistrationRepository = $RegistrationRepository;
    }

    public function hashpassword($pass)
    {
        $pass = Hash::make($pass);
        return $pass;
    }

    public function giveuserperm(User $user)
    {
        $user->assignRole(self::USER_DEFAULT_ROLE);
    }

    public function store($data)
    {

        $data['password'] =  $this->hashpassword($data['password']);
        $this->giveuserperm($this->RegistrationRepository->store($data));

    }


}
