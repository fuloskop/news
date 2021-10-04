@extends('frontend.AdminPanel.AdminLayout')


@section('admincontect')
    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-center">User</th>
                    <th scope="col" class="text-center">Mesaj</th>
                    <th scope="col" class="text-center">Durum</th>
                    <th scope="col" class="text-center">Cevap</th>
                    <th scope="col">Yetkilendir</th>
                </tr>
                </thead>
                <tbody>
                @foreach($DeleteAccountRequests as $DeleteAccountRequest)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td class="text-center">@if(is_null($DeleteAccountRequest->user_id))
                            Deleted_User
                        @else
                            {{$DeleteAccountRequest->user->username}}
                        @endif
                    </td>
                    <td class="text-center">{{$DeleteAccountRequest->body}}</td>
                    <td class="text-center"><span class="badge bg-primary">{{$DeleteAccountRequest->request_status}}</span></td>
                    <td class="text-center">{{$DeleteAccountRequest->answer}}</td>
                    <td>
                        @if($DeleteAccountRequest->request_status == "accepted")

                            <button type="button" class="btn btn-primary" disabled>
                                İşlemi Bitir
                            </button>
                            @else
                            <a href="{{route('AdminAcctDelReqShow',$DeleteAccountRequest->id)}}">
                                <button type="button" class="btn btn-primary" >
                                    İşlemi Bitir
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
