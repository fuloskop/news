@extends('frontend.AdminPanel.AdminLayout')


@section('admincontect')
    <div class="col-md-12  mt-4">
        <form method="POST" action="" >
            <p>
               Düzenleyebileceği Kategorileri Düzenelenen Kişi :   {{$user->username}}
            </p>


            @foreach($AllCategories as $Category)
                    <div class="form-check m-3">
                        <input class="form-check-input" type="checkbox" data-id='{{$user->id}}' value="{{$Category->id}}" id="{{$Category->id}}"
                        @foreach($user->categories as $userCategory)
                            @if($userCategory->id==$Category->id)
                                checked
                            @endif
                        @endforeach
                        >
                        <label class="form-check-label" for="flexCheckDefault">
                            {{$Category->name}}
                        </label>
                    </div>
                @endforeach


        </form>
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
            let category_id= $(this).attr('value');
            let user_id = $(this).attr('data-id');
            let added;
            if ($(this).is(':checked')) {
                console.log('denemechecked'+$(this).attr('value')+$(this).attr('data-id'));
                added = 1;
            }
            else{
                console.log('denemenotcheck'+$(this).attr('value')+$(this).attr('data-id'));
                added = 0;
            }
            $.ajax({
                url: "{{route('api.seteditorcateg')}}",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    category_id:category_id,
                    user_id:user_id,
                    added:added
                },
                success:function(response){
                    setTimeout(function() {
                        delaySuccess();
                    }, 1000);
                    console.log(response);
                    if(response) {
                        $('.success').text(response.success);
                        $("#myModal").modal('hide');
                    }
                    $("#myModal").modal('hide');
                },
                complete:function(response) {
                    console.log("SEMPRE FUNFA!");
                    $("#myModal").modal('hide');
                }
            });

        });

        function delaySuccess() {
            $("#myModal").modal('hide');
        }
    </script>

@endsection
