@extends('frontend.AdminPanel.AdminLayout')

@section('admincontect')
    <form action="" method="POST">
        <div class="tab-pane fade show active m-5" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="row">
                <div class="col-6 border text-center pt-4 pb-4"> Bakım Modu : </div>
                <div class="col-6 border text-center pt-4 pb-4"> @if($MaintenanceMode)<span class="text-warning">Bakım Modu Aktif!</span>
                    @else
                        <span class="text-success">Bakım Modu Kapalı.</span>
                    @endif</div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="row border pt-5 pb-5">
                <div class="col-2"></div>
                <div class="col-8 text-center">
                    @if($MaintenanceMode)
                        <button class="btn btn-block btn-danger" type="submit" name="mode" value="0">Bakım Modunu Kapat!</button>
                    @else
                        <button class="btn btn-block btn-success" type="submit" name="mode" value="1">Bakım Modunu Başlat!</button>
                    @endif
                </div>
                <div class="col-2"></div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>
    </form>
@endsection
