<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\RegistrationService;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    private $RegistrationService;


    public function __construct(RegistrationService $RegistrationService)
    {
        $this->RegistrationService = $RegistrationService;
    }

    public function index()
    {
        return view('frontend.register.register');
    }

    public function store(StoreUserRequest $request)
    {

        $this->RegistrationService->store($request->only('email','username', 'password'));

        return redirect()->route('login.index');
    }

}
