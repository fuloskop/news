<?php

namespace App\Repositories\Auth;

use App\Models\User;

class RegistrationRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function giveuserperm(User $user)
    {
        $user->assignRole('user');
    }

    public function store($data)
    {
        $user = User::create($data);
        $this->giveuserperm($user);
        return $user->fresh;
    }
}
