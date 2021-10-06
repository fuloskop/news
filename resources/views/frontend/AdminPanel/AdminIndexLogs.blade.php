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
                @foreach($logs as $log)
                <tr>
                    <th scope="row">{{$log->id}}</th>
                    <td class="text-center">@if(is_null($log->user_id))
                            Deleted_User
                        @else
                            {{$log->user->username}}
                        @endif
                    </td>
                    <td class="text-center">{{$log->message}}</td>
                    <td class="text-center">
                        <span class="badge
                        @if($log->status=="activity")
                            bg-primary
                        @elseif($log->status=="info")
                            bg-info
                        @elseif($log->status=="warning")
                            bg-warning
                        @else
                            bg-danger
                        @endif">{{$log->status}}</span></td>
                    <td class="text-center">{{$log->ip}}</td>
                    <td class="text-center">{{$log->user_agent}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>

            <br>

        </div>
        {{$logs->links("pagination::bootstrap-4")}}
    </div>
@endsection

@section('script')
@endsection
