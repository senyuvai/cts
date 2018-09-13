@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">Raporlar</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Tüm Sağlık Raporu Alan Çalışanlar</h3>
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#add-new-saglik"><i class="fa fa-plus"></i> Rapor Ekle</button>
                            <br>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
									<th style="width: 15%;">Adı Soyadı</th>
                                    <th style="width: 15%;">Rapor Tarihi</th>
                                    <th style="width: 25%;" class="text-right">{{language_data('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($saglik as $d)
                                    <tr>
										 <td data-label="item name"><p>{{$d->employee_info->fname}} {{$d->employee_info->lname}}</p></td>
                                        <td data-label="purchase to"><p>{{get_date_format($d->rapor_tarih)}}</p></td>
                                        

                                        <td data-label="Actions" class="text-right">

                                            @if($d->saglik_raporu != '')
                                            <a class="btn btn-complete btn-xs" href="{{url('saglik/download-saglik-raporu/'.$d->id)}}"><i class="fa fa-download"></i> Rapor İndir</a>
                                            @endif
                                            <a class="btn btn-success btn-xs" href="{{url('saglik/edit/'.$d->id)}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>
                                            <a href="#" class="btn btn-danger btn-xs cdelete" id="{{$d->id}}"><i class="fa fa-trash"></i> {{language_data('Delete')}}</a>
                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>


            <!-- Modal -->
            <div class="modal fade" id="add-new-saglik" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Sağlık Raporu Ekle</h4>
                        </div>
                        <form class="form-some-up" role="form" method="post" action="{{url('saglik/post-new-saglik')}}" enctype="multipart/form-data">
                            <div class="modal-body">


                                <div class="form-group">
                                    <label>Raporu Alan Çalışan</label>
                                    <select name="emp_name" class="form-control selectpicker" data-live-search="true">
                                        @foreach($employee as $e)
                                            <option value="{{$e->id}}">{{$e->fname}} {{$e->lname}} ({{$e->employee_code}})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Rapor Tarihi</label>
                                    <input type="text" class="form-control datePicker" required="" name="rapor_tarih">
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
                            </div>

                            <div class="modal-footer">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                                <button type="submit" class="btn btn-primary">{{language_data('Add')}}</button>
                            </div>
                        </form>
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
    {!! Html::script("assets/libs/data-table/datatables.min.js")!!}
    {!! Html::script("assets/js/bootbox.min.js")!!}

    <script>
        $(document).ready(function () {
            /*For DataTable*/
            $('.data-table').DataTable();

            /*For Delete Job Info*/
            $(".cdelete").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/saglik/delete-saglik/" + id;
                    }
                });
            });


        });
    </script>
@endsection
