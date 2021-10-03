@extends('frontend.EditorPanel.EditorLayout')


@section('editorcontect')
    <div class="col-md-12  mt-4">
        <form method="POST" action="" >
            <div class="row">
                <div class="col-md-5">
                    Haber Yapma Yetkiniz Olan Kategoriler :
                </div>
                <div class="col-md-5">
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        @foreach($AvailableCategories as $AvailableCategory)
                        <option name="category_id" value="{{$AvailableCategory->id}}">{{$AvailableCategory->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>



        <!-- Message input -->
            <div class="form-outline mb-4">
                <textarea class="form-control" name="answer" rows="4" maxlength="150"></textarea>
                <label class="form-label" style="margin-left: 0px">Cevabınız...</label>
            </div>

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

            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-lg mb-4">
                Gönder
            </button>
        </form>
    </div>
@endsection

@section('script')
@endsection
