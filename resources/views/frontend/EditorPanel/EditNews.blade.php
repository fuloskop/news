@extends('frontend.EditorPanel.EditorLayout')

@section('head')
@endsection

@section('editorcontect')
    <div class="col-md-12  mt-4">
        <form method="POST" action="{{route('Editor.updatenews',$news->id)}}" >
            <div class="row">
                <div class="col-md-5">
                    Haber Yapma Yetkiniz Olan Kategoriler :
                </div>
                <div class="col-md-5">
                    <select class="form-select" name="category_id" aria-label="Default select example">
                        @foreach($Categories as $Category)
                        <option name="category_id" value="{{$Category->id}}" @if($Category->id==$news->category_id) selected @endif>{{$Category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @hasanyrole('moderator|admin')
                <input type="hidden" name="author_id" value="{{$news->author_id}}" />
            @endhasanyrole

            <div class="form-outline mb-4 mt-4">
                <input type="text" name="title" class="form-control" value="{{$news->title}}">
                <label class="form-label" style="margin-left: 0px">Haber Başlığı :</label>
            </div>

        <!-- Message input -->
            <div class="form-outline mb-4">
                <textarea class="ckeditor form-control" name="wysiwyg-editor" rows="4" maxlength="150">{{$news->body}}</textarea>
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
                <input class="form-check-input" type="checkbox" id="ispublish" @if($news->published_at)!=null) checked @endif>
                <label class="form-check-label" for="">Yayınlansın mı ? </label>
            </div>


            <div class="form-outline mb-4 mt-4" id="datepicker" hidden>
                <span> Yayınlanma tarihi :</span>
                <input type="date" id="start" name="published_at"
                       value="@if($news->published_at!=null){{\Carbon\Carbon::parse($news->published_at)->format('Y-m-d')}}@else {{\Carbon\Carbon::now()->toDateString()}} @endif"
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
            filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
    <script>
        $( document ).ready(function() {
            if ($('.form-check-input').is(':checked')) {
                $('#start').val('{{\Carbon\Carbon::parse($news->published_at)->format('Y-m-d')}}')
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
