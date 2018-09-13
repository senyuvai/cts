@extends('master')


{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">Sağlık Raporu Düzenle</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            @include('notification.notify')
            <div class="row">

                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-body">
                            <form role="form" action="{{url('saglik/saglik-edit-post')}}" method="post" enctype="multipart/form-data">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Çalışan Sağlık Raporu Düzenle</h3>
                                </div>

								<div class="form-group">
                                    <label>Rapor No</label>
                                    <input type="text" class="form-control" required="" name="rapor_no" value="{{$saglik->rapor_no}}">
                                </div>

                              <div class="form-group">
                                    <label>Raporlu Çalışan</label>
                                    <select name="emp_name" class="form-control selectpicker" data-live-search="true">
                                        @foreach($employee as $e)
                                            <option value="{{$e->id}}" @if($saglik->purchase_by==$e->id) selected @endif>{{$e->fname}} {{$e->lname}} ({{$e->employee_code}})</option>
                                        @endforeach
                                    </select>
                                </div>
								<div class="form-group">
                                    <label>Rapor Tarihi</label>
                                    <input type="text" class="form-control datePicker" required="" name="rapor_tarih" value="{{$saglik->rapor_tarih}}">
                                </div>
								<div class="form-group">
                                    <label>İşe Başlama Tarihi</label>
                                    <input type="text" class="form-control datePicker" required="" name="ise_bas_tar" value="{{$saglik->ise_bas_tar}}">
                                </div>

								 <div class="form-group m-none">
                                    <label for="e20">Rapor Türü</label>
                                    <select name="rapor_tur" class="form-control selectpicker">
                                        <option value="Hastalik" @if($saglik->rapor_tur=='Hastalik') selected @endif>Hastalik</option>
                                        <option value="IsKazasi"  @if($saglik->rapor_tur=='IsKazasi') selected @endif>IsKazasi</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Select Document')}}</label>
                                    <div class="input-group input-group-file">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                {{language_data('Browse')}} <input type="file" class="form-control" name="saglik_raporu">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly="">
                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$saglik->id}}" name="cmd">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-edit"></i> {{language_data('Update')}} </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection

{{--External Style Section--}}
@section('script')
    {!! Html::script("assets/libs/moment/moment.min.js")!!}
    {!! Html::script("assets/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")!!}
    {!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}
@endsection
