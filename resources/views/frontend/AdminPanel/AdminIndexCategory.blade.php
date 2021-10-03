@extends('frontend.AdminPanel.AdminLayout')


@section('admincontect')

    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="panel-body">
            <div class="d-flex flex-row-reverse">
                <div class="p-2">
                    <a href="{{route('Category.create')}}" class="btn btn-success btn-lg mb-4">
                        + Yeni Kategori Ekle
                    </a>
                </div>
            </div>

            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-center">Kategori Adı</th>
                    <th scope="col" class="text-center">Düzenle</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <th scope="row">{{$category->id}}</th>
                        <td class="text-center">{{$category->name}}</td>
                        <td class="text-center">
                            <a href="{{route('Category.edit',$category->id)}}">
                                <button type="button" class="btn btn-primary me-4" >
                                    Kategori Düzenle
                                </button>
                            </a>
                            <a href="{{route('Category.destroy',$category->id)}}">
                                <button type="button" class="btn btn-danger" >
                                    Kategori Sil
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
