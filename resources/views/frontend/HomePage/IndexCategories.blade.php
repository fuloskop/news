@extends('frontend.layout')


@section('content')

    <div class="row">
        @foreach($categories as $category)
            <div class="card p-2 m-2 col-1">
                <div class="card-body p-2">
                    <div class="form-check card-title">
                        <input class="form-check-input" type="checkbox" id="{{$category->id}}" value="" @foreach($userSubCategories as $userSubCategory)
                                @if($userSubCategory->pivot->category_id == $category->id)
                                    checked
                                    @break
                                @endif
                            @endforeach/>
                        <label class="form-check-label" for="{{$category->id}}">
                            Abone
                        </label>
                    </div>
                </div>
            </div>
            <div class="card p-2 m-2 col-10">
                <div class="card-body p-2">
                    <div class="card-title">
                        <h5><a href="{{route('News.IndexByCategory', $category->id)}}">{{ $category->name }}</a></h5>
                    </div>
                </div>
            </div>
        @endforeach
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
            let category_id = $(this).attr('id');
            let added;
            if ($(this).is(':checked')) {
                console.log('denemechecked'+$(this).attr('id'));
                added = 1;
            }
            else{
                console.log('denemenotcheck'+$(this).attr('id'));
                added = 0;
            }
            $.ajax({
                url: "{{route('api.setsubcateg')}}",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    category_id:category_id,
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
