@extends('frontend.layout')


@section('content')
    <div class="col-md-12  mt-4">
        <form method="POST" action="{{route('store.delacount')}}" >
            <p>
                Hesabınızı silmek istemeniz bizi derinden üzdü.
                Gene de kendimizi geliştirmemiz açısından nedeninizi yazarsanız talebinizi gerçekleştirebiliriz.
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
                <textarea class="form-control" name="body" rows="4" maxlength="150"></textarea>
                <label class="form-label" style="margin-left: 0px">Talebinzi yazınız...</label>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">
                Send
            </button>
        </form>
    </div>


@endsection
