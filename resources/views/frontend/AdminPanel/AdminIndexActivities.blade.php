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
                @foreach($activities as $activity)

                    <tr>
                        <th scope="row">{{$activity->id}}</th>
                        <td class="text-center">@if(is_null($activity->user_id))
                                Deleted_User
                            @else
                                {{$activity->user->username}}({{$activity->role_type}})
                            @endif
                        </td>
                        <td class="text-center">{{$activity->message}}</td>
                        <td class="text-center">
                            <span class="badge
                            @if($activity->status=="activity")
                                bg-primary
                            @elseif($activity->status=="info")
                                bg-info
                            @elseif($activity->status=="warning")
                                bg-warning
                            @else
                                bg-danger
                            @endif">{{$activity->status}}</span></td>
                        <td class="text-center">{{$activity->ip}}</td>
                        <td class="text-center">{{$activity->user_agent}}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>

            <br>
            {{$activities->links("pagination::bootstrap-4")}}
        </div>
    </div>
@endsection

@section('script')
@endsection
