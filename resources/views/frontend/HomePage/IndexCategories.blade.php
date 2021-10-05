@extends('frontend.layout')


@section('content')

    <div>
        @foreach($categories as $category)
            <div class="card p-2 m-2">
                <div class="card-body p-2">
                    <div class="card-title">
                        <h5><a href="{{route('News.IndexByCategory', $category->id)}}">{{ $category->name }}</a></h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
