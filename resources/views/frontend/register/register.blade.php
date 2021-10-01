<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login V20</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/booratstp/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href={{asset('css/register.css')}}>
</head>
<body>


<div class="login-reg-panel">
    <div class="login-info-box">
        <h2>Have an account?</h2>
        <p>Lorem ipsum dolor sit amet</p>
        <label id="label-register" for="log-reg-show">Login</label>
        <input type="radio" name="active-log-panel" id="log-reg-show" @if (Request::path() == 'login')
        checked="checked"
        @endif
        >
    </div>

    <div class="register-info-box">
        <h2>Don't have an account?</h2>
        <p>Lorem ipsum dolor sit amet</p>
        <label id="label-login" for="log-login-show">Register</label>
        <input type="radio" name="active-log-panel" id="log-login-show" @if (Request::path() == 'register')
        checked="checked"
            @endif
        >
    </div>

    <div class="white-panel">
        <form action="{{route('login')}}" method="post">
        <div class="login-show">
            @csrf
            <h2>LOGIN</h2>
            <input type="text" name="email" placeholder="Email" value="{{ old('email') }}">
            <input type="password" id="password" name="password" placeholder="Password">
            <input class="button" type="submit" value="Login">
            <a href="">Forgot password?</a>

        </div>
        </form>
        <form action="{{route('register.store')}}" method="post">
        <div class="register-show">
            @csrf
            <h2>REGISTER</h2>

            <input type="text" name="email" placeholder="Email" value="{{ old('email') }}">
            <input type="text" name="username" placeholder="Username" value="{{ old('username') }}">
            <input type="password" id="password" name="password" placeholder="Password">
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">

            <input class="button" type="submit"  value="Register">
        </div>
        </form>
    </div>

</div>
@if ($errors->any())
    <div class="myAlert-bottom">
        <div id="moo" class="alert alert-danger alert-dismissible" role="alert" auto-close="30000">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><ul>
    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
    @endforeach
            </ul>
        </div>
    </div>
@endif

<script src="{{asset('js/register.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
