@extends('frontend.layout')


@section('content')

    <div>
        <div class="card" >
            <div class="card-body">
                <div class="row">
                    <h2 class="card-title col-sm-8">{{$news->title}}</h2>
                </div>
                <p class="card-text">{!!$news->body!!}</p>

                <div class="card-footer">
                    <p>Created and edited By <strong> {{ $news->Author->username }}</strong> at {{ \Carbon\Carbon::parse($news->updated_at)->diffForHumans()}} in <strong>{{$news->Category->name}}</strong></p>
                </div>
            </div>
        </div>
        <div class="card mt-2" >
            <div class="card-body">
                <form action="{{ route('Comment.store') }}" method="POST">
                    <div class="form-outline mb-3">
                        <textarea class="form-control" name="body" rows="4"></textarea>
                        <label class="form-label" style="margin-left: 0px">Yorum Yap : </label>
                    </div>
                    <input type="hidden" name="news_id" value="{{$news->id}}" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-check m-2">
                        <input class="form-check-input" type="checkbox" name="is_hidden" value="1"/>
                        <label class="form-check-label" >
                            Nickimi gizle.
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">
                        Gönder
                    </button>
                </form>
            </div>
        </div>
            @foreach($news->comments->reverse() as $comment)
                <div class="card mt-2 mb-2">
                    <div class="card-body" style="display: flex;flex-wrap: wrap;">
                        <div class="card-title "  style=" flex: 50%; ">
                            @if($comment->is_hidden)
                                <strong><h5>Anonymous</h5></strong>
                            @else
                                @if(is_null($comment->user_id))
                                    <strong><h5>Deleted_User</h5></strong>
                                @else
                                    <strong><h5>{{$comment->user->username}}</h5></strong>
                                @endif
                            @endif
                        </div>
                        @if(auth()->user()->hasanyrole('moderator|admin') || auth()->user()->id == $comment->user_id)
                        <a type="button flex" class="btn btn-danger" href="{{route('Comment.destroy',$comment->id)}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                            </svg>
                            Sil
                        </a>
                        @endif
                        <div class="card-text m-1" style=" flex: 50%; ">
                            {{$comment->body}}
                        </div>
                        <div class="card-subtitle mt-1"  style=" flex: 50%; ">
                            <small>{{$comment->created_at}}</small>
                        </div>

                    </div>
                </div>

            @endforeach


    </div>
@endsection
