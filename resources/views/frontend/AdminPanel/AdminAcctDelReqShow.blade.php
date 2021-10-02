@extends('frontend.AdminPanel.AdminLayout')


@section('admincontect')
    <div class="col-md-12  mt-4">
        <form method="POST" action="{{route('AdminAcctDelReqUpdate',$DeleteAccountRequest->id)}}" >
            <p>
               Hesabını silmek isteyen kişi :  {{$DeleteAccountRequest->User->username}}
            </p>
            <p>
                Hesabını silme nedeni :  {{$DeleteAccountRequest->body}}
            </p>
            <p>
                Silme talebinin durumu :  {{$DeleteAccountRequest->request_status}}
            </p>

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
