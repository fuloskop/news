<?php

namespace App\Http\Repositories\Auth;

use App\Models\User;

class RegistrationRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function store($data)
    {
        $user = User::create($data);

        return $user->fresh;
    }
}
