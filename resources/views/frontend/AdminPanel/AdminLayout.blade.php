@extends('frontend.layout')


@section('content')


    <div class="d-flex align-items-start">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a href="{{route('AdminRoles')}}" class="nav-link text-center">
            Yetki Düzenleme
            </a>
            <a href="{{route('AdminAcctDelReqIndex')}}" class="nav-link text-center">
            Hesap Silme Onayı
            </a>
            <a href="{{route('Category.index')}}" class="nav-link text-center">
                Kategori Düzenle
            </a>
            <a href="{{route('AdminChangeEditorCateg.index')}}" class="nav-link text-center">
                Yazarlara Kategori Atama
            </a>
            <a href="{{route('Activities.index')}}" class="nav-link text-center">
                Kullanıcı Aktivite Takibi
            </a>
            @can('access logs')
            <a href="{{route('Logs.index')}}" class="nav-link text-center">
                Logs
            </a>
            @endcan
            @can('start stop maintenance')
                <a href="{{route('Maintenance.show')}}" class="nav-link text-center">
                    Bakım Modu
                </a>
            @endcan

        </div>


        <div class="tab-content m-2 container" id="v-pills-tabContent" style="background-color: #424242;">
            @yield('admincontect')

        </div>
    </div>
@endsection
