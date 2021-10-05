@extends('frontend.layout')


@section('content')

    <div>
        @forelse($news as $theNews)
            <div class="card p-2 m-2">
                <div class="card-body p-2">
                    <div class="card-title  ">
                        <h5><a href="{{route('News.show', $theNews->id)}}">{{ $theNews->title }}</a> @hasanyrole('admin|moderator') Editor_name = {{ $theNews->Author->username }} @endhasanyrole</h5>
                    </div>

                    <p class="card-text ">{!!strlen($theNews->body)<100 ? $theNews->body : (substr($theNews->body, 0, 300)."...<a href =".route('News.show', $theNews->id)."> Devamını oku </a>") !!}</p>
                </div>
            </div>
        @empty
            <div class="card p-2 m-2">
                <div class="card-body p-2">
                    <div class="card-title  ">
                        <h5>Hiç haberimiz yok.</h5>
                    </div>
                </div>
            </div>
        @endforelse

        {{$news->links("pagination::bootstrap-4")}}
    </div>
@endsection
