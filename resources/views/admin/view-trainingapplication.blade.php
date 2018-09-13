@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">EĞİTİME KATILANLARIN DETAYLARI</h2>
        </div>
		<div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
					<div class="panel-heading p-b-none">
						<h3>Eğitim Detayları<br><small></small></h3>
					</div>
					<div class="panel-body p-none m-b-12">
						<table class="table table-no-border table-condensed">
							<tbody>
								<tr>
									<td><strong class="help-split">Eğitim No:</strong>#{{$emp_training->id}}</td>
									<td><strong class="help-split">Eğitim Adı:</strong>{{$emp_training->employeetrainingdetail_getir->trainingdetail_name}}</td>
									<td><strong class="help-split">Tarih Aralığı:</strong>{{$emp_training->training_from}}/{{$emp_training->training_to}}</td>
								</tr>
								<tr>
									<td><strong class="help-split">Geç. Süre:</strong></td>
									<td><strong class="help-split">Eğitmen:</strong>{{$emp_training->employeetrainingdetail_getir->trainingdetail_name}}</td>
									<td><strong class="help-split">Eğitim Yeri:</strong>{{$emp_training->training_location}}</td>
								</tr>
								
							</tbody>
						</table>
					</div>
				</div>
                    </div>
                </div>

            </div>

        <div class="p-30 p-t-none p-b-none">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">KATILIMCILAR</h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 10%;">Resim</th>
									<th style="width: 20%;">Çalışan Adı</th>
									<th style="width: 20%;">Sertifika Numarası</th>
									<th style="width: 20%;">Notu</th>
                                    
                                    <th style="width: 30%;">{{language_data('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($trainingapplicants as $d)
                                <tr>
                                    <td data-label="SL">  @if($d->trainingemployee_getir->avatar!='')
                                            <img src="<?php echo asset('assets/employee_pic/'.$employee->avatar); ?>" alt="Profile Page" width="50px" height="50px">
                                        @else
                                            <img src="<?php echo asset('assets/employee_pic/user.png');?>" alt="Profile Page" width="50px" height="50px">
                                        @endif</td>
                                    <td data-label="SL">{{$d->trainingemployee_getir->fname}} <br />{{$d->trainingemployee_getir->employee_code}}</td>
									<td data-label="SL">{{$d->employee_training_document_number}}</td>
									<td data-label="SL">{{$d->employee_training_grade}}</td>
                                    <td data-label="Actions">
@if($d->employee_training_document != '')
                                            <a class="btn btn-complete btn-xs" href="{{url('training/download-training-document/'.$d->id)}}"><i class="fa fa-download"></i>Döküman İndir</a>
                                            @endif
   <a class="btn btn-success btn-xs" href="#" data-toggle="modal" data-target=".modal_set_training_applicant_details_{{$d->id}}"><i class="fa fa-edit"></i> Bilgi Ekle / Düzenle</a>
										                                        @include('admin.modal-set-details-applicant')



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
			
			

        </div>
		
    </section>

@endsection

{{--External Style Section--}}
@section('script')
    {!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}
    {!! Html::script("assets/libs/data-table/datatables.min.js")!!}
    {!! Html::script("assets/js/bootbox.min.js")!!}

    <script>
        $(document).ready(function () {
            /*For DataTable*/
            $('.data-table').DataTable();

            /*For Delete Application Info*/
            $(".cdelete").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/jobs/delete-application/" + id;
                    }
                });
            });
				
				
        });
    </script>
@endsection
