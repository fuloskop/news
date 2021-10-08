@extends('frontend.EditorPanel.EditorLayout')

@section('head')
@endsection

@section('editorcontect')
    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-center">Yazarı</th>
                    <th scope="col" class="text-center">Haber Başlığı</th>
                    <th scope="col" class="text-center">Yayın Tarihi</th>
                    <th scope="col" class="text-center">Yetkilendir</th>
                </tr>
                </thead>
                <tbody>
                @foreach($news as $theNews)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td class="text-center">@if(is_null($theNews->author_id))
                            Deleted_User
                        @else
                            {{$theNews->Author->username}}
                        @endif</td>
                    <td class="text-center">{!!   strlen($theNews->title)<50 ? $theNews->title : (substr($theNews->title, 0, 45)."...") !!}</td>
                    <td class="text-center">@if(is_null($theNews->published_at))
                            Yayınlanma tarihi yok.
                        @else
                            {{  Carbon\Carbon::parse($theNews->published_at)->diffForHumans()}}
                        @endif</td>
                    <td class="text-center">
                        @if((isset($theNews->published_at) && \Carbon\Carbon::yesterday() > \Carbon\Carbon::parse($theNews->published_at)) && !auth()->user()->hasPermissionTo('manage old news') )

                            <button type="button" class="btn btn-primary" disabled>
                                Haber Düzenle
                            </button>

                            <button type="button" class="btn btn-danger" disabled>
                                Haber Sil
                            </button>

                        @else
                            <a href="{{route('Editor.editenews',$theNews->id)}}">
                                <button type="button" class="btn btn-primary" >
                                    Haber Düzenle
                                </button>
                            </a>
                            <a href="{{route('Editor.destroynews',$theNews->id)}}">
                                <button type="button" class="btn btn-danger" >
                                    Haber Sil
                                </button>
                            </a>
                        @endif

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
