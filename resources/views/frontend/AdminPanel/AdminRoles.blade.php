@extends('frontend.AdminPanel.AdminLayout')


@section('admincontect')
    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">eMail</th>
                    <th scope="col">Yetkilendir</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$user->username}}</td>
                    <td>{{$user->email}}</td>
                    <td>@can('give admin and moderator permission')
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" data-id='{{$user->id}}' id="admin" autocompleted=""
                                       @if($user->hasRole('admin'))
                                       checked
                                    @endif
                                >
                                <label class="form-check-label" for="isadmin">Admin</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" data-id='{{$user->id}}'  id="moderator" autocompleted=""
                                       @if($user->hasRole('moderator'))
                                       checked
                                    @endif
                                >
                                <label class="form-check-label" for="ismod">Moderator</label>
                            </div>
                        @endcan
                        @can('give editor permission')
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" data-id='{{$user->id}}'  id="editor" autocompleted=""
                                @if($user->hasRole('editor'))
                                    checked
                                    @endif
                                    >
                                <label class="form-check-label" for="iseditor">Editor</label>
                            </div>
                        @endcan
                        </td>
                </tr>
                @endforeach
                </tbody>
            </table>

            <br>

        </div>
    </div>

    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="spinner-border text-secondary mx-2" role="status">
                    </div>
                    <span>Loading...</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.form-check-input').click(function() {
            $('#myModal').modal({backdrop:'static', keyboard:false});
            $("#myModal").modal('show');
            let roletype = $(this).attr('id');
            let user_id = $(this).attr('data-id');
            let added;
            if ($(this).is(':checked')) {
                console.log('denemechecked'+$(this).attr('id')+$(this).attr('data-id'));
                added = 1;
            }
            else{
                console.log('denemenotcheck'+$(this).attr('id')+$(this).attr('data-id'));
                added = 0;
            }
            $.ajax({
                url: "{{route('api.setrole')}}",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    roletype:roletype,
                    user_id:user_id,
                    added:added
                },
                success:function(response){
                    console.log(response);
                    setTimeout(function() {
                        delaySuccess();
                    }, 1000);
                    if(response) {
                        $('.success').text(response.success);
                    }
                },
            });
        });

        function delaySuccess() {
            $("#myModal").modal('hide');
        }
    </script>
@endsection
