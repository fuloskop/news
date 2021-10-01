<?php

namespace App\Http\Repositories\Auth;

use App\Models\User;

class LoginRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function checklogin($userdata)
    {
        return auth()->attempt($userdata);
    }
}
