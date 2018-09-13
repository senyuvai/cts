@extends('master')


{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
@endsection



@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('View Profile')}}</h2>
        </div>
        <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-body p-t-20">
                            <div class="clearfix">
                                <div class="pull-left m-r-30">
                                    <div class="thumbnail m-b-none">

                                        @if($employee->avatar!='')
                                            <img src="<?php echo asset('assets/employee_pic/'.$employee->avatar); ?>" alt="Profile Page" width="200px" height="200px">
                                        @else
                                            <img src="<?php echo asset('assets/employee_pic/user.png');?>" alt="Profile Page" width="200px" height="200px">
                                        @endif
                                    </div>
                                </div>
								
								<h3 class="bold font-color-1">{{$employee->fname}} {{$employee->lname}} - (( {{$employee->gercek_statu}} ))</h3>
								  <div class="row">
                                    <div class="col-md-4">
									   <div class="form-group">
										   <label style="width:150px;"><b>Kimlik Numarası </b></label>                   
											<label>{{$employee->employee_code}}</label>
										   <br />    
										   <label style="width:150px;"><b>Departman / Ünvan </b></label>                   
										<label>{{$employee->department_name->department}} / {{$employee->designation_name->designation}}</label>
										   <br />  
										  

										    
										      <label style="width:150px;"><b>Katılış Tarihi </b></label>                   
											<label></label>
										   <br /> 
										      <label style="width:150px;"><b>Ayrılış Tarihi</b></label>                   
											<label>{{$employee->dol}}</label>
										   <br /> 
										     <label style="width:150px;"><b>Güncel Adresi</b></label>                   
											<label>{{$employee->pre_address}}</label>
										   <br /> 
									</div>
                                  </div>
									  
								 <div class="col-md-4">
									   <div class="form-group">
										      <label style="width:150px;"><b>Doğum Tarihi : </b></label>                   
											<label>{{$employee->dob}}</label>
										   <br /> 
                                  	     <label style="width:150px;"><b>Ana / Baba Adı</b></label>                   
											<label>{{$employee->mother_name}} / {{$employee->father_name}}</label>
										   <br />    
										   <label style="width:150px;"><b>Kan Grubu</b></label>                   
											<label>{{$employee->kan_grubu}}</label>
										   <br />    
										   <label style="width:150px;"><b>GSM Numarası</b></label>                   
											<label>{{$employee->phone}}</label>
										   <br />  
										   <label style="width:150px;"><b>Daimi Adresi </b></label>                   
											<label>{{$employee->per_address}}</label>
										   <br /> 

	                                </div>
										   
                                  </div>
								</div>
								
								
								
								
								
								
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        
        <div class="p-30 p-t-none p-b-none">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#personal_details" aria-controls="home" role="tab" data-toggle="tab">{{language_data('Personal Details')}}</a></li>
                        <li role="presentation"><a href="#bank_information" aria-controls="profile" role="tab" data-toggle="tab">{{language_data('Bank Info')}}</a></li>
                        <li role="presentation"><a href="#document" aria-controls="messages" role="tab" data-toggle="tab">{{language_data('Document')}}</a></li>
                        <li role="presentation"><a href="#change-picture" aria-controls="settings" role="tab" data-toggle="tab">{{language_data('Change Picture')}}</a></li>
							<li role="presentation"><a href="#acil-durum-iletisim" aria-controls="profile" role="tab" data-toggle="tab">Yakınlık ve Acil Durum İletişim</a></li>						
						<li role="presentation"><a href="#yillik_izin" aria-controls="profile" role="tab" data-toggle="tab">Yıllık İzin </a></li>
						<li role="presentation"><a href="#deneme" aria-controls="profile" role="tab" data-toggle="tab">Eğitim</a></li>
						<li role="presentation"><a href="#yeni-muayene" aria-controls="profile" role="tab" data-toggle="tab">Yenimuayene</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content panel p-20">


                        {{--Personal Details--}}

                        <div role="tabpanel" class="tab-pane active" id="personal_details">
                            <form role="form" method="post" action="{{url('employees/post-employee-personal-info')}}">
								 <h3 style="text-align: center;border-bottom: 2px solid black;width: 100%;">Çalışma Detayları</h3>

								<div class="row">
								<div class="col-md-3">
									    <div class="form-group">
                                            <label>{{language_data('First Name')}}</label>
                                            <input type="text" class="form-control" required="" value="{{$employee->fname}}" name="fname">
                                        </div>
									
									<div class="form-group">
                                            <label for="el3">{{language_data('Department')}}</label>
                                            <select class="selectpicker form-control" data-live-search="true" name="department" id="department_id">
                                                <option>{{language_data('Select Department')}}</option>
                                                @foreach($department as $d)
                                                    <option value="{{$d->id}}" @if($employee->department==$d->id) selected @endif>  {{$d->department}}</option>
                                                @endforeach
                                            </select>
										
										
                                        </div>
									
									<div class="form-group">
                                            <label>{{language_data('Username')}}</label>
                                            <span class="help">e.g. "employee" ({{language_data('Unique For every User')}})</span>
                                            <input type="text" class="form-control" required name="username" value="{{$employee->user_name}}">
                                        </div>
									
									</div>
									<div class="col-md-3">
										
									 <div class="form-group">
                                            <label>{{language_data('Last Name')}}</label>
                                            <input type="text" class="form-control" value="{{$employee->lname}}" name="lname">
                                        </div>
									
									<div class="form-group">
                                            <label for="el3">{{language_data('Designation')}}</label>
                                            <select class="selectpicker form-control" data-live-search="true" name="designation" id="designation">
                                                <option value="{{$employee->designation}}">{{$employee->designation_name->designation}}</option>
                                            </select>
                                        </div>
										<div class="form-group">
                                    <label>SGK</label>
                                    <select class="selectpicker form-control" name="tax" data-live-search="true">
                                    @foreach($tax as $t)
                                        <option value="{{$t->id}}" @if($employee->tax_id==$t->id) selected @endif>{{$t->tax_name}}</option>
                                    @endforeach
                                    </select>
                                </div>
										
									</div>
									
									<div class="col-md-3">
										<div class="form-group">
                                            <label>{{language_data('Employee Code')}}</label>
                                            <span class="help"></span>
                                            <input type="text" class="form-control" required name="employee_code" value="{{$employee->employee_code}}">
                                        </div>
										<div class="form-group">
                                    <label>SGK Ünvanı</label>
                                    <select class="selectpicker form-control" name="sgk" data-live-search="true">
                                    @foreach($sgk as $t)
                                        <option value="{{$t->id}}" @if($employee->sgk_id==$t->id) selected @endif>{{$t->sgk_name}}</option>
                                    @endforeach
                                    </select>
                                </div>
										<div class="form-group">
                                            <label>Ayrılış Tarihi</label>
                                            <input type="text" class="form-control datePicker" name="ayrilis_tarihi" value="{{get_date_format($employee->ayrilis_tarihi)}}">
                                        </div>
									
									
									</div>
									

                                        
										

                                      
									<div class="col-md-3">
									  <div class="form-group">
                                            <label>{{language_data('User Role')}}</label>
                                            <select class="selectpicker form-control" data-live-search="true" name="role">
                                                    <option value="0" @if($employee->role_id=='0') selected @endif>{{language_data('Employee')}}</option>
                                                @foreach($role as $r)
                                                    <option value="{{$r->id}}" @if($employee->role_id==$r->id) selected @endif>{{$r->role_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
										
										 <div class="form-group">
                                            <label>{{language_data('Date Of Join')}}</label>
                                            <input type="text" class="form-control datePicker" required="" name="doj" value="{{get_date_format($employee->doj)}}">
                                        </div>
										<div class="form-group">
                                            <label>Statü</label>
                                            <select class="selectpicker form-control" data-live-search="true" name="gercek_statu">
                                                <option value="Aktif" @if($employee->gercek_statu=='Aktif') selected @endif>Aktif</option>
                                                <option value="Pasif" @if($employee->gercek_statu=='Pasif') selected @endif>Pasif</option>
                                            </select>
                                        </div>
										
									</div>
									</div>
                                <div class="row">
								 <h3 style="text-align: center;border-bottom: 2px solid black;width: 100%;">Diğer Detaylar</h3>
									<div class="col-md-3">
								    <div class="form-group">
                                            <label>{{language_data('Email')}}</label>
                                            <span class="help"></span>
                                            <input type="email" class="form-control" required name="email" value="{{$employee->email}}">
                                        </div>
 <div class="form-group">
                                            <label>{{language_data('Phone Number')}}</label>
                                            <input type="text" class="form-control"  value="{{$employee->phone}}" name="phone">
                                        </div>
                                            <div class="form-group">
                                            <label>{{language_data('Alternative Phone')}}</label>
                                            <input type="text" class="form-control"  value="{{$employee->phone2}}" name="phone2">
                                        </div>


                                


                                    </div>




                                    <div class="col-md-3">

							              

                                         <div class="form-group">
                                            <label>{{language_data('Present Address')}}</label>
                                            <textarea class="form-control" rows="6" name="pre_address">{{$employee->pre_address}}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>{{language_data('Permanent Address')}}</label>
                                            <textarea class="form-control" rows="6" name="per_address">{{$employee->per_address}}</textarea>
                                        </div>

                                        
                                    </div>
									
                                    <div class="col-md-3">
    <div class="form-group">
                                            <label>{{language_data('Father Name')}}</label>
                                            <input type="text" class="form-control"  value="{{$employee->father_name}}" name="father_name">
                                        </div>



                                        <div class="form-group">
                                            <label>{{language_data('Mother Name')}}</label>
                                            <input type="text" class="form-control"  value="{{$employee->mother_name}}" name="mother_name">
                                        </div>

                                        <div class="form-group">
                                            <label>{{language_data('Date Of Birth')}}</label>
                                            <input type="text" class="form-control datePicker" name="dob" value="{{get_date_format($employee->dob)}}">
                                        </div>
										         
								<div class="form-group">
                                    <label>Lisans</label>
                                    <select class="selectpicker form-control" name="lisans">
                                        <option value="Belirtilmemis" @if($employee->lisans=='Belirtilmemis') selected @endif>Belirtilmemis</option>
                                   <option value="İlkokul" @if($employee->lisans=='İlkokul') selected @endif>İlkokul</option>                                   <option value="Ortaokul" @if($employee->lisans=='Ortaokul') selected @endif>Ortaokul</option>
                                   <option value="Lise" @if($employee->lisans=='Lise') selected @endif>Lise</option>
                                   <option value="Lisans" @if($employee->lisans=='Lisans') selected @endif>Lisans</option>
								  <option value="Yüksek Lisans" @if($employee->lisans=='Yüksek Lisans') selected @endif>Yüksek Lisans</option>
                                   <option value="Doktora" @if($employee->lisans=='Doktora') selected @endif>Doktora</option>
                                    </select>
                                </div>  

                                    </div>
								
								
                                    <div class="col-md-3">
									<div class="form-group">
                                    <label>{{language_data('Gender')}}</label>
                                    <select class="selectpicker form-control" name="gender">
                                        <option value="Male" @if($employee->gender=='Male') selected @endif>{{language_data('Male')}}</option>
                                   <option value="Female" @if($employee->gender=='Female') selected @endif>{{language_data('Female')}}</option>
                                    </select>
                                </div>
										<div class="form-group">
                                    <label>Medeni Hali</label>
                                    <select class="selectpicker form-control" name="medeni_hali_son">
                             <option value="Belirtilmemis" @if($employee->medeni_hali_son=='Belirtilmemis') selected @endif>Belirtilmemis</option>
                              <option value="Evli" @if($employee->medeni_hali_son=='Evli') selected @endif>Evli</option>
								  <option value="Bekar" @if($employee->medeni_hali_son=='Bekar') selected @endif>Bekar</option>
                                    </select>
                                </div>
											<div class="form-group">
                                    <label>Kan Grubu</label>
                                    <select class="selectpicker form-control" name="kan_grubu">
                             <option value="Belirtilmemis" @if($employee->kan_grubu=='Belirtilmemis') selected @endif>Belirtilmemis</option>
                               <option value="0-" @if($employee->kan_grubu=='0-') selected @endif>0 Rh(-)</option>       
												 <option value="0+" @if($employee->kan_grubu=='0+') selected @endif>0 Rh(+)</option>
												 <option value="A-" @if($employee->kan_grubu=='A-') selected @endif>A Rh(-)</option>
												 <option value="A+" @if($employee->kan_grubu=='A+') selected @endif>A Rh(+)</option>
												 <option value="B-" @if($employee->kan_grubu=='B-') selected @endif>B Rh(-)</option>
												 <option value="B+" @if($employee->kan_grubu=='B+') selected @endif>B Rh(+)</option>
												 <option value="AB-" @if($employee->kan_grubu=='AB-') selected @endif>AB Rh(-)</option> 
										<option value="AB+" @if($employee->kan_grubu=='AB+') selected @endif>AB Rh(+)</option>
												</select>
                                </div>
										<div class="form-group">
                                    <label>Çocuk Sayısı</label>
                                    <select class="selectpicker form-control" name="cocuk_sayisi">
                                        <option value="Belirtilmemis" @if($employee->cocuk_sayisi=='Belirtilmemis') selected @endif>Belirtilmemis</option>
                                   <option value="1" @if($employee->cocuk_sayisi=='1') selected @endif>1</option>                                   <option value="2" @if($employee->gender=='2') selected @endif>2</option>
                                   <option value="3" @if($employee->cocuk_sayisi=='3') selected @endif>3</option>
                                   <option value="4" @if($employee->cocuk_sayisi=='4') selected @endif>4</option>
								  <option value="5" @if($employee->cocuk_sayisi=='5') selected @endif>5</option>
                                   <option value="6" @if($employee->cocuk_sayisi=='6') selected @endif>6</option>
									 <option value="7+" @if($employee->cocuk_sayisi=='7+') selected @endif>7+</option>

                                    </select>
                                </div> 
									</div>
                                
									<div class="col-md-12">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" value="{{$employee->id}}" name="cmd">
                                        <input style="width: 100%;text-transform: uppercase;" type="submit" value="( {{$employee->fname}} {{$employee->lname}} ) Personel Bilgilerini Güncelle" class="btn btn-success">

                                    </div>
                                </div>


                            </form>

                        </div>

<div role="tabpanel" class="tab-pane" id="deneme">
                            
	<div class="row">
                                <div class="col-lg-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">ALINANxx EĞİTİMLER</h3>
											
										 <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#add-new-training"><i class="fa fa-plus"></i> Yeni Eğitim Ekle</button><br />
    </div>
                                        <div class="panel-body p-none">
                                            <table class="table data-table table-hover table-ultra-responsive">
                                                <thead>
                                                <tr>
                                                    <th style="width: 25%;">Eğitim Adı</th>
                                                    <th style="width: 25%;">Eğitim Tarih Aralığı</th>
													<th style="width: 25%;">Eğitmen</th>
													<th style="width: 25%;">Eğitim Yeri</th>
													<th style="width: 25%;">Sertifika No</th>
													<th style="width: 25%;">Notu</th>
													<th style="width: 5%;" class="text-right"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($denemeid as $ba)
                                                    <tr>
                                                        <td data-label="Bank Name">{{$ba->employeetraining_getir->employeetrainingdetail_getir->trainingdetail_name}}</td>
														<td>{{$ba->employeetraining_getir->training_from}}<br />{{$ba->employeetraining_getir->training_to}}</td>														 
														<td data-label="Bank Name">{{$ba->employeetraining_getir->employeetrainingtrainer_getir->first_name}} {{$ba->employeetraining_getir->employeetrainingtrainer_getir->last_name}}<br />{{$ba->employeetraining_getir->employeetrainingtrainer_getir->organization}}</td>
														 <td data-label="Bank Name">{{$ba->employeetraining_getir->training_location}}</td>
														 <td data-label="Bank Name">Sertifika No Gel</td>
														 <td data-label="Bank Name">{{$ba->employee_training_grade}}</td>
                                                       <td class="text-right">
                                               <a href="#" data-toggle="modal" data-target="#add-new-employeetraininggrade" data-placement="top" title="Not Yükle" class="btn btn-complete btn-xs employeetrainingid" id="{{$ba->id}}">Belge İndir</a>
														   <a href="#" data-toggle="modal" data-target="#add-new-employeetraininggrade" data-placement="top" title="Not Yükle" class="btn btn-complete btn-xs employeetrainingid" id="{{$ba->id}}">Bilgi Ekle</a>

														   <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteBankAccount" id="{{$ba->id}}"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
							
	
			
							<div class="modal fade" id="add-new-training" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Eğitim Ekle</h4>
                        </div>
                        <form class="form-some-up" role="form" method="post" action="{{url('employee/add-employee-training')}}">
                            <div class="modal-body">

					<div class="row">
								<div class="col-md-12">

                  					<div class="form-group">
                                    <label>Eğitim Firması</label>
						
						<select class="selectpicker form-control" data-live-search="true" name="training_id" id="training_id">											   				 <option>Lütfen Eğitim Seçiniz</option>
									
                                                @foreach($trainings as $d)
                                                    <option value="{{$d->id}}">{{$d->id}} </option>
                                                @endforeach
                                            </select>
                                </div>	
									
												<div class="form-group">
                                                    <label>Sertifika Numarası</label>
                                                    <input type="text" class="form-control" required name="employee_training_document_number">
                                                </div>
									
										<div class="form-group">
                                                    <label>Notu</label>
                                                    <input type="text" class="form-control" required name="employee_training_grade">
                                                </div>
									
									<div class="form-group">
                                    <label>{{language_data('Select Document')}}</label>
                                    <div class="input-group input-group-file">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                  {{language_data('Browse')}} <input type="file" class="form-control" name="employee_training_document">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly="">
                                    </div>
                                </div>
									
  </div>
									
												
                                    </div>
						</div>
								
                            <div class="modal-footer">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
								 <input type="hidden" value="{{$employee->id}}" name="cmd">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                                <button type="submit" class="btn btn-primary">{{language_data('Add')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

						
						
						
						
						
						<div role="tabpanel" class="tab-pane" id="yeni-muayene">                          
	<div class="row">
                            <div class="col-lg-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Yapılan Muayeneler</h3>
										 <button class="btn btn-success btn-sm pull-right" data-target="muayene"><i class="fa fa-plus"></i> Yeni Muayene Ekle</button><br />
    </div>
                                        <div class="panel-body p-none">
                                            <table class="table data-table table-hover table-ultra-responsive">
                                                <thead>
                                                <tr>
                                                    <th style="width: 25%;">Muayene Türü</th>
													<th style="width: 25%;">Rapor Numası</th>
                                                    <th style="width: 25%;">İşe Giriş Muayene Tar</th>
													<th style="width: 25%;">Rapor Tarihi</th>
													<th style="width: 25%;">Doktor</th>
													<th style="width: 25%;">Not</th>
                                                    <th style="width: 5%;" class="text-right"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($emp_muayene as $ba)
                                                    <tr>
                                                        <td data-label="Bank Name"></td>
                                                        <td data-label="Bank Name">{{$ba->rapor_no}}</td>
                                                        <td data-label="Bank Name">{{$ba->ise_bas_tar}}</td>
                                                        <td data-label="Bank Name">{{$ba->rapor_tarih}}</td>
                                                        <td data-label="Bank Name">{{$ba->doktor}}</td>
														<td data-label="Bank Name">{{$ba->not}}</td>

                                                       <td class="text-right">
                                              
														   <a href="#" data-toggle="modal" data-target="#add-new-employeetraininggrade" data-placement="top" title="Not Yükle" class="btn btn-complete btn-xs employeetrainingid" id="{{$ba->id}}">Not Ekle</a>

														   <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteBankAccount" id="{{$ba->id}}"><i class="fa fa-trash"></i></a>
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
						
						
                        <div role="tabpanel" class="tab-pane" id="bank_information">
                            <div class="row">

                                <div class="col-lg-3">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <form class="" role="form" method="post" action="{{url('employee/add-bank-account')}}">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"> {{language_data('Add Bank Account')}}</h3>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{language_data('Bank Name')}}</label>
                                                    <span class="help">e.g. "United State Bank"</span>
                                                    <input type="text" class="form-control" required name="bank_name">
                                                </div>

                                                <div class="form-group">
                                                    <label>{{language_data('Branch Name')}}</label>
                                                    <span class="help">e.g. "Washington Branch"</span>
                                                    <input type="text" class="form-control" required name="branch_name">
                                                </div>

                                                <div class="form-group">
                                                    <label>{{language_data('Account Name')}}</label>
                                                    <span class="help">e.g. "Abul Kashem Shamim"</span>
                                                    <input type="text" class="form-control" required name="account_name">
                                                </div>

                                                <div class="form-group">
                                                    <label>{{language_data('Account Number')}}</label>
                                                    <span class="help">e.g. "1015463115661214"</span>
                                                    <input type="text" class="form-control" required name="account_number">
                                                </div>

                                                <div class="form-group">
                                                    <label>{{language_data('IFSC Code')}}</label>
                                                    <input type="text" class="form-control" name="ifsc_code">
                                                </div>

                                                <div class="form-group">
                                                    <label>{{language_data('PAN Number')}}</label>
                                                    <input type="text" class="form-control" name="pan_number">
                                                </div>

                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-9">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">{{language_data('All Bank Accounts')}}</h3>
                                        </div>
                                        <div class="panel-body p-none">
                                            <table class="table data-table table-hover table-ultra-responsive">
                                                <thead>
                                                <tr>
                                                    <th style="width: 25%;">{{language_data('Bank Name')}}</th>
                                                    <th style="width: 20%;">{{language_data('Branch')}}</th>
                                                    <th style="width: 20%;">{{language_data('Account Name')}}</th>
                                                    <th style="width: 10%;">{{language_data('Account No')}}</th>
                                                    <th style="width: 10%;">{{language_data('IFSC Code')}}</th>
                                                    <th style="width: 10%;">{{language_data('PAN No')}}</th>
                                                    <th style="width: 5%;" class="text-right"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($bank_accounts as $ba)
                                                    <tr>
                                                        <td data-label="Bank Name">{{$ba->bank_name}}</td>
                                                        <td data-label="Branch Name"><p>{{$ba->branch_name}}</p></td>
                                                        <td data-label="Account Name"><p>{{$ba->account_name}}</p></td>
                                                        <td data-label="Account No"><p>{{$ba->account_number}}</p></td>
                                                        <td data-label="IFSC Code"><p>{{$ba->ifsc_code}}</p></td>
                                                        <td data-label="PAN No"><p>{{$ba->pan_no}}</p></td>
                                                        <td class="text-right">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteBankAccount" id="{{$ba->id}}"><i class="fa fa-trash"></i></a>
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
						
						
						
						
						
						<div role="tabpanel" class="tab-pane" id="yillik_izin">
                            <div class="row">

                                <div class="col-lg-3">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <form class="" role="form" method="post" action="{{url('employee/add-yillik-izin')}}">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"> Yıllık İzin Ekle</h3>

												
												</div>

                                                <div class="form-group">
                                                    <label>İzin Başlangıç Tarihi</label>
													 <input type="text" class="form-control datePicker" name="izin_bas_tar">
                                                </div>

                                                <div class="form-group">
                                                    <label>İzin Bitiş Tarihi</label>
													 <input type="text" class="form-control datePicker" name="izin_bit_tar">
                                                </div>

                                                <div class="form-group">
                                                    <label>İzin Gün Süresi</label>
													<input type="number" class="form-control" required name="gun_sure">
                                                </div>

                                                <div class="form-group">
                                                    <label>İmza Durumu</label>
										<select class="selectpicker form-control" name="imza_durum">
                             <option value="Var">Var</option>
                              <option value="Yok">Yok</option>
											</select>                                           
												</div>

                                                <div class="form-group">
                                                    <label>İzin Türü / Not</label>
                                                    <input class="form-control" rows="6" name="izin_turu_not">
                                                </div>

                                                

                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-9">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">KULLANILAN YILLIK İZİNLER</h3>
										 <div class="row">
									<div class="col-md-4">
											Toplam Hak Kazanılan İzin : <b> {{$kullanilacak_izin_gunu}} </b>
																			</div>	<div class="col-md-4">
Kullanılan İzin: {{$izin_kullanilan_gun_sayisi}} </div>	<div class="col-md-4">Kalan İzin Gün Sayısı: 														{{$kalan_izin_gun_sayisi}}
										</div>
											</div>
    </div>
                                        <div class="panel-body p-none">
                                            <table class="table data-table table-hover table-ultra-responsive">
                                                <thead>
                                                <tr>
                                                    <th style="width: 15%;">Başlangıç Tarihi</th>
                                                    <th style="width: 15%;">Bitiş Tarihi</th>
                                                    <th style="width: 10%;">Süre/Gün</th>
                                                    <th style="width: 10%;">İmza Durum</th>
                                                    <th style="width: 45%;">İzin Türü / Not</th>
                                                    <th style="width: 5%;" class="text-right"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($yillik_izinler as $ba)
                                                    <tr>
                                                        <td data-label="Bank Name">{{$ba->izin_bas_tar}}</td>
                                                        <td data-label="Branch Name"><p>{{$ba->izin_bit_tar}}</p></td>
                                                        <td data-label="Account Name"><p>{{$ba->gun_sure}}</p></td>
                                                        <td data-label="Account No"><p>{{$ba->imza_durum}}</p></td>
                                                        <td data-label="IFSC Code"><p>{{$ba->izin_turu_not}}</p></td>
                                                        <td class="text-right">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteYillikIzin" id="{{$ba->id}}"><i class="fa fa-trash"></i></a>
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
						
						

						
						
						
						<div role="tabpanel" class="tab-pane" id="acil-durum-iletisim">
                            <div class="row">

                                <div class="col-lg-3">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <form class="" role="form" method="post" action="{{url('employee/add-acil-durum')}}">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"> İletişim Bilgisi Ekle</h3>
                                                </div>

                                                <div class="form-group">
                                                    <label>Yakınlık Derecesi</label>
                                                    <span class="help">Ör: "Eşi"</span>
                                                    <input type="text" class="form-control" required name="yakinlik_derecesi">
                                                </div>

                                                <div class="form-group">
                                                    <label>Adı Soyadı</label>
                                                    <span class="help">Ör: "İbrahim ŞENYUVA"</span>
                                                    <input type="text" class="form-control" required name="yak_ad_soyad">
                                                </div>

                                                <div class="form-group">
                                                    <label>TC Kimlik Numarası</label>
                                                    <span class="help">Bilinmiyor ise 11 tane 0</span>
                                                    <input type="text" class="form-control" required name="yak_tckn">
                                                </div>
												 <div class="form-group">
                                                    <label>GSM Numarası</label>
                                                    <span class="help">Ör: "5xxxxxxxxxx"</span>
                                                    <input type="text" class="form-control" required name="yak_gsm">
                                                </div>
												
												<div class="form-group">
                                                    <label>GSM Numarası</label>
                                                    <span class="help">Ör: "5xxxxxxxxxx"</span>
                                                    <input type="text" class="form-control" required name="yak_dog_tar">
                                                </div>
												<div class="form-group">
                                                    <label>Doğum Yeri</label>
                                                    <span class="help">Ör: "KONAK"</span>
                                                    <input type="text" class="form-control" required name="yak_dog_yer">
                                                </div>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-9">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">TÜM AKRABA VE ACİL DURUM İLETİŞİM BİLGİLERİ</h3>
                                        </div>
                                        <div class="panel-body p-none">
                                            <table class="table data-table table-hover table-ultra-responsive">
                                                <thead>
                                                <tr>
                                                    <th style="width: 15%;">Yakınlık Derecesi</th>
                                                    <th style="width: 30%;">Adı Soyadı</th>
                                                    <th style="width: 10%;">Kimlik Numarası</th>
													<th style="width: 10%;">GSM</th>
                                                    <th style="width: 15%;">Doğum Tarihi</th>
                                                    <th style="width: 15%;">Doğum Yeri</th>
													<th style="width: 5%"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                 @foreach($acil_durumlar as $ad)
                                                    <tr>
                                                        <td data-label="Yakınlık Derecesi">{{$ad->yakinlik_derecesi}}</td>
                                                        <td data-label="Adı Soyadı">{{$ad->yak_ad_soyad}}</td>
                                                        <td data-label="Yakınlık Derecesi">{{$ad->yak_tckn}}</td>
                                                        <td data-label="Yakınlık Derecesi">{{$ad->yak_gsm}}</td>
                                                        <td data-label="Yakınlık Derecesi">{{$ad->yak_dog_tar}}</td>
                                                        <td data-label="Yakınlık Derecesi">{{$ad->yak_dog_yer}}</td>
                                                        <td class="text-right">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteAcilDurum" id="{{$ad->id}}"><i class="fa fa-trash"></i></a>
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
					
					
						
						
						
                        <div role="tabpanel" class="tab-pane" id="document">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <form class="" role="form" method="post" action="{{url('employee/add-document')}}" enctype="multipart/form-data">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"> {{language_data('Add Document')}}</h3>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{language_data('Document Name')}}</label>
                                                    <span class="help">e.g. "Resume, Joining Letter etc"</span>
                                                    <input type="text" class="form-control" required name="document_name">
                                                </div>

                                                <div class="form-group">

                                                    <label>{{language_data('Select Document')}}</label>
                                                    <div class="input-group input-group-file">
                                                            <span class="input-group-btn">
                                                                <span class="btn btn-primary btn-file">
                                                                    {{language_data('Browse')}} <input type="file" class="form-control" name="file">
                                                                </span>
                                                            </span>
                                                        <input type="text" class="form-control" readonly="">
                                                    </div>
                                                </div>

                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-9">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">{{language_data('All Documents')}}</h3>
                                        </div>
                                        <div class="panel-body p-none">
                                            <table class="table data-table table-hover table-ultra-responsive">
                                                <thead>
                                                <tr>
                                                    <th style="width: 65%;">{{language_data('Document Name')}}</th>
                                                    <th style="width: 35%;" class="text-right">{{language_data('Actions')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($employee_doc as $ed)
                                                    <tr>
                                                        <td data-label="Document Name">{{$ed->file_title}}</td>
                                                        <td class="text-right">
                                                            <a href="{{url('employee/download-employee-document/'.$ed->id)}}" class="btn btn-success btn-xs"><i class="fa fa-download"></i> {{language_data('Download')}}</a>
                                                            <a href="#" class="btn btn-danger btn-xs deleteEmployeeDoc" id="{{$ed->id}}"><i class="fa fa-trash"></i> {{language_data('Delete')}}</a>
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

						
						
						
						
						
                        <div role="tabpanel" class="tab-pane" id="change-picture">
                            <form role="form" action="{{url('employees/update-employee-avatar')}}" method="post" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-4">

                                        <div class="form-group input-group input-group-file">
                                                <span class="input-group-btn">
                                                    <span class="btn btn-primary btn-file">
                                                        {{language_data('Browse')}} <input type="file" class="form-control" name="image">
                                                    </span>
                                                </span>
                                            <input type="text" class="form-control" readonly="">
                                        </div>

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" value="{{$employee->id}}" name="cmd">
                                        <input type="submit" value="{{language_data('Update')}}" class="btn btn-primary">

                                    </div>

                                </div>

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
    {!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}
    {!! Html::script("assets/libs/moment/moment.min.js")!!}
    {!! Html::script("assets/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")!!}
    {!! Html::script("assets/libs/wysihtml5x/wysihtml5x-toolbar.min.js")!!}
    {!! Html::script("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.js")!!}
    {!! Html::script("assets/libs/data-table/datatables.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}
    {!! Html::script("assets/js/bootbox.min.js")!!}

    <script>
        $(document).ready(function () {

            /*For DataTable*/
            $('.data-table').DataTable();


            /*For Designation Loading*/
            $("#department_id").change(function () {
                var id = $(this).val();
                var _url = $("#_url").val();
                var dataString = 'dep_id=' + id;
                $.ajax
                ({
                    type: "POST",
                    url: _url + '/employee/get-designation',
                    data: dataString,
                    cache: false,
                    success: function ( data ) {
                        $("#designation").html( data).removeAttr('disabled').selectpicker('refresh');
                    }
                });
            });
			
			$("#egitimfirma_id").change(function () {
                var id = $(this).val();
                var _url = $("#_url").val();
                var dataString = 'egitimfirma_id=' + id;
                $.ajax
                ({
                    type: "POST",
                    url: _url + '/employee/get-firmaegitimci',
                    data: dataString,
                    cache: false,
                    success: function ( data ) {
                        $("#firmaegitimci").html( data).removeAttr('disabled').selectpicker('refresh');
                    }
                });
            });
			



            /*For Delete Bank Account*/
            $(".deleteBankAccount").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-bank-account/" + id;
                    }
                });
            });

			
			  /*For Delete Acil Durum*/
            $(".deleteAcilDurum").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-acil-durum/" + id;
                    }
                });
            });
			 /*For Delete Yillik Izin*/
            $(".employeetrainingid").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-yillik-izin/" + id;
                    }
                });
            });
			
			  /*For Delete Yillik Izin*/
            $(".deleteYillikIzin").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-yillik-izin/" + id;
                    }
                });
            });
			
			
			  /*For Delete Yillik Izin*/
            $(".deleteSaglikDurumu").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-saglik-durumu/" + id;
                    }
                });
            });
			
            /*For Delete Employee Doc*/
            $(".deleteEmployeeDoc").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-employee-doc/" + id;
                    }
                });
            });


        });
		

    </script>

@endsection
