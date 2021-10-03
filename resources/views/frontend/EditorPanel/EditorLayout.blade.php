@extends('frontend.layout')


@section('content')


    <div class="d-flex align-items-start">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a href="{{route('Editor.createnews')}}">
            <button class="nav-link btn-lg" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Haber Oluştur</button>
            </a>
            <a href="{{route('AdminAcctDelReqIndex')}}">
            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Haberlerimi Düzenle</button>
            </a>
        </div>


        <div class="tab-content m-2 container" id="v-pills-tabContent" style="background-color: #424242;">
            @yield('editorcontect')

        </div>
    </div>
@endsection
