@extends('frontend.AdminPanel.AdminLayout')

@section('head')
@endsection

@section('admincontect')
    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-center">Kullanıcı</th>
                    <th scope="col" class="text-center">Email</th>
                    <th scope="col" class="text-center">Yetkilendir</th>
                </tr>
                </thead>
                <tbody>
                @foreach($AllEditors as $Editor)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td class="text-center">{{$Editor->username}}</td>
                    <td class="text-center">{{$Editor->email}}</td>
                    <td class="text-center">
                        <a href="{{route('AdminChangeEditorCateg.show',$Editor->id)}}">
                            <button type="button" class="btn btn-primary" >
                                Kategori Ayarla
                            </button>
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

            <br>

        </div>
    </div>
@endsection

@section('script')
@endsection
