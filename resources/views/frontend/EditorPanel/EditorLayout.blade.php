@extends('frontend.layout')


@section('content')


    <div class="d-flex align-items-start">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a href="{{route('Editor.createnews')}}" class="nav-link text-center">
                Haber Oluştur
            </a>
            <a href="{{route('Editor.indexnews')}}" class="nav-link text-center">
                Haberlerimi Düzenle
            </a>
        </div>


        <div class="tab-content m-2 container" id="v-pills-tabContent" style="background-color: #424242;">
            @yield('editorcontect')

        </div>
    </div>
@endsection


