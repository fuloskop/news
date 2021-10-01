<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Services\Auth\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $LoginService;

    public function __construct(LoginService $LoginService)
    {
        $this->LoginService = $LoginService;
    }

    public function index()
    {
        return view('frontend.register.register');
    }

    public function login(LoginUserRequest $request)
    {
        if($this->LoginService->login($request->only('email', 'password'))){
            return redirect()->route('home');
        }

        return back()->withErrors('E-mail veya şifre yanlış!');
    }
}
