@extends('frontend.AdminPanel.AdminLayout')


@section('admincontect')
    <div class="col-md-12  mt-4">
        <form method="POST" action="@if(!isset($category))
            {{route('Category.store')}}
            @else
            {{route('Category.update',$category->id)}}
            @endif
            " >

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
                <input class="form-control" name="name" rows="4" maxlength="150" value="@if(!isset($category)){{old('name')}}@else{{$category->name}}@endif">
                <label class="form-label" style="margin-left: 0px">Yeni Kategori:</label>
            </div>

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
