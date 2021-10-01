<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Business\Auth\RegistrationBusiness;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    private $RegistrationBusiness;


    public function __construct(RegistrationBusiness $RegistrationBusiness)
    {
        $this->RegistrationBusiness = $RegistrationBusiness;
    }

    public function index()
    {
        return view('frontend.register.register');
    }

    public function store(StoreUserRequest $request)
    {

        $this->RegistrationBusiness->store($request->only('email','username', 'password'));

        return redirect()->route('login.index');
    }

}
