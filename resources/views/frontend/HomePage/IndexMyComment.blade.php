@extends('frontend.layout')


@section('content')
    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

        <div class="row mb-3">
            <div class="col-5 text-center"><a href="{{route('Oldnews.index')}}"> <button class="btn btn-lg btn-primary" type="submit">Okuduğum Haberler</button></a></div>
            <div class="col-2"></div>
            <div class="col-5 text-center"><a href="{{route('Comments.index')}}"> <button class="btn btn-lg btn-primary" type="submit">Yazdığım Yorumlar</button></a></div>
        </div>

        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col" class="text-center">Yorum İçeriği</th>
                    <th scope="col" class="text-center">Haber Başlığı</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $comment)
                <tr>
                    <td class="col-6 text-center">{{$comment->body}}</td>
                    <td class="col-6 text-center">{{$comment->news->title}}</td>
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
