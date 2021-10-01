<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Business\Auth\LoginBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private $LoginBusiness;

    public function __construct(LoginBusiness $LoginBusiness)
    {
        $this->LoginBusiness = $LoginBusiness;
    }

    public function index()
    {
        return view('frontend.register.register');
    }

    public function login(LoginUserRequest $request)
    {
        if($this->LoginBusiness->login($request->only('email', 'password'))){
            return redirect()->route('home');
        }

        return back()->withErrors('E-mail veya şifre yanlış!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
