@extends('frontend.EditorPanel.EditorLayout')

@section('head')
@endsection

@section('editorcontect')
    <div class="col-md-12  mt-4">
        <form method="POST" action="{{route('Editor.storenews')}}" >
            <div class="row">
                <div class="col-md-5">
                    Haber Yapma Yetkiniz Olan Kategoriler :
                </div>
                <div class="col-md-5">
                    <select class="form-select" name="category_id" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        @foreach($AvailableCategories as $AvailableCategory)
                        <option name="category_id" value="{{$AvailableCategory->id}}">{{$AvailableCategory->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-outline mb-4 mt-4">
                <input type="text" name="title" class="form-control" value="{{old('title')}}">
                <label class="form-label" style="margin-left: 0px">Haber Başlığı :</label>
            </div>

        <!-- Message input -->
            <div class="form-outline mb-4">
                <textarea class="ckeditor form-control" name="wysiwyg-editor" rows="4" maxlength="150">{{old('wysiwyg-editor')}}</textarea>
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

            <div class="form-check form-switch mb-4">
                <input class="form-check-input" type="checkbox" id="ispublish" @if(old('published_at')!=null) checked @endif>
                <label class="form-check-label" for="">Yayınlansın mı ?</label>
            </div>


            <div class="form-outline mb-4 mt-4" id="datepicker" hidden>
                <span> Yayınlanma tarihi :</span>
                <input type="date" id="start" name="published_at"
                       value="@if(old('published_at')!=null) {{old('published_at')}} @else {{\Carbon\Carbon::now()->toDateString()}} @endif"
                       min="{{\Carbon\Carbon::now()->toDateString()}}" max="2030-12-31">
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
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
    <script type="text/javascript">
        CKEDITOR.replace('wysiwyg-editor', {
            removePlugins: 'sourcearea',
            removeButtons: 'Source',
            filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
    <script>
        $( document ).ready(function() {
            if ($('.form-check-input').is(':checked')) {
                $('#start').val('{{old('published_at')}}')
                $('#datepicker').attr("hidden",false);
            }else{
                $('#datepicker').attr("hidden",true);
                $('#start').val(null)
            }
        });

        $('.form-check-input').click(function() {
        if ($(this).is(':checked')) {
            $('#start').val('{{\Carbon\Carbon::now()->toDateString()}}')
            $('#datepicker').attr("hidden",false);
        }
        else{
            $('#datepicker').attr("hidden",true);
            $('#start').val(null)
        }
        });
    </script>

@endsection
