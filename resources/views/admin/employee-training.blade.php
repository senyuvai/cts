@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
    {!! Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"> ÇALIŞAN EĞİTİMİ</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">TÜM ÇALIŞAN EĞİTİMLERİ</h3>
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#add-new-training"><i class="fa fa-plus"></i>Çalışanlara Eğitim Ekle</button>
                            <br>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                 	<th style="width: 20%;">Eğitim Adı</th>
									  <th style="width: 20%;">Başlangıç<br />Bitiş Tarih</th>
									  <th style="width: 20%;">Eğitmen / Firma</th>
									  <th style="width: 15%;">Eğitim Yeri</th>
                                    <th style="width: 25%;" class="text-right">{{language_data('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($emp_training as $et)
                                    <tr>
										<td data-label="Training From"><p>{{$et->employeetrainingdetail_getir->trainingdetail_name}}</p></td>
                                      <td data-label="Training From"><p>{{get_date_format($et->training_from)}}</p><p>{{get_date_format($et->training_to)}}</p></td>
                                        <td data-label="Training To">{{$et->employeetrainingtrainer_getir->first_name}} {{$et->employeetrainingtrainer_getir->last_name}}</td>
										 <td data-label="Training To">{{$et->training_location}}</td>
                                        <td data-label="Actions" class="text-right">
											                                            <a class="btn btn-primary btn-xs" href="{{url('training/view-applicant/'.$et->id)}}"><i class="fa fa-list"></i> Eğitimi Alanlar</a>

                                            <a class="btn btn-success btn-xs" href="{{url('training/view-employee-training/'.$et->id)}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>
                                            <a href="#" class="btn btn-danger btn-xs cdelete" id="{{$et->id}}"><i class="fa fa-trash"></i> {{language_data('Delete')}}</a>
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
            <div class="modal fade" id="add-new-training" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Çalışanlara Eğitim Ekle</h4>
                        </div>
                        <form class="form-some-up" role="form" method="post" action="{{url('training/post-new-training')}}">
                            <div class="modal-body">



                                <div class="form-group">
                                    <label>ÇALIŞAN ve/veya ÇALIŞANLAR</label>
                                    <select class="form-control selectpicker" multiple data-live-search="true" name="employee[]">
                                        @foreach($employee as $e)
                                            <option value="{{$e->id}}">{{$e->fname}} {{$e->lname}} ({{$e->employee_code}})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>ALDIĞI EĞİTİM</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="trainingdetail">
                                        @foreach($trainingdetails as $t)
                                            <option value="{{$t->id}}">{{$t->trainingdetail_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>EĞİTİMCİ</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="trainer">
                                        @foreach($trainers as $t)
                                            <option value="{{$t->id}}">{{$t->first_name}} {{$t->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>EĞİTİM YERİ</label>
                                    <input type="text" class="form-control" name="training_location">
                                </div>


                                

                                <div class="form-group">
                                    <label>EĞİTİM BAŞLANGIÇ TARİHİ</label>
                                    <input type="text" class="form-control datePicker" name="training_from">
                                </div>

                                <div class="form-group">
                                    <label>EĞİTİM BİTİŞ TARİHİ</label>
                                    <input type="text" class="form-control datePicker" name="training_to">
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
    {!! Html::script("assets/libs/wysihtml5x/wysihtml5x-toolbar.min.js")!!}
    {!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}
    {!! Html::script("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.js")!!}
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
                        window.location.href = _url + "/training/delete-employee-training/" + id;
                    }
                });
            });


        });
    </script>
@endsection
