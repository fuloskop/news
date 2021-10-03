@extends('frontend.AdminPanel.AdminLayout')


@section('admincontect')
    <div class="col-md-12  mt-4">
        <form method="POST" action="" >
            <p>
               Düzenleyeceği Kategorileri Düzenelenecek Kişi :   {{$user->username}}
            </p>


            @foreach($AllCategories as $Category)
                <p>
                    <div class="form-check m-5">
                        <input class="form-check-input" type="checkbox" value="{{$Category->id}}" id="flexCheckDefault"
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
                </p>

                @endforeach


            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{session('success')}}
                </div>
        @endif


        <!-- Message input -->
            <div class="form-outline mb-4">
                <textarea class="form-control" name="answer" rows="4" maxlength="150"></textarea>
                <label class="form-label" style="margin-left: 0px">Cevabınız...</label>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <!-- Submit button -->
            <button type="submit" name="request_status" value="accepted" class="btn btn-success btn-lg mb-4">
                Onayla
            </button>
            <button type="submit" name="request_status" value="denied" class="btn btn-danger btn-lg mb-4">
                Reddet
            </button>
        </form>
    </div>

@endsection

@section('script')


@endsection
