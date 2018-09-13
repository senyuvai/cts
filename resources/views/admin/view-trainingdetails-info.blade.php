@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">Eğitim Detayı ve Bu eğitimi Almayanlar</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            @include('notification.notify')
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-body p-none m-b-12">
						<table class="table table-no-border table-condensed">
							<form class="" role="form" action="{{url('training/post-trainingdetail-update-info')}}" method="post">
							<tbody>
								<div class="row">
								<tr>
									<td><strong class="help-split">Eğitim Adı:</strong><input type="text" class="form-control" required="" name="trainingdetail_name" value="{{$trainingdetail->trainingdetail_name}}">
</td>
									<td><strong class="help-split">Eğitim Süresi(h):</strong><input type="number" class="form-control" required="" name="trainingdetail_hour" value="{{$trainingdetail->trainingdetail_hour}}"></td>
									<td><strong class="help-split">Eğitim Açıklama:</strong><input type="text" class="form-control" required="" name="trainingdetail_aciklama" value="{{$trainingdetail->trainingdetail_aciklama}}"></td>

								</tr>
									</div>
								  
							</tbody>
								 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$trainingdetail->id}}" name="cmd">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-edit"></i> {{language_data('Update')}} </button>
								</form>
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
                            <h3 class="panel-title">Bu Eğitimi ALmayanlar</h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table table-no-border table-condensed">
                               <tbody>
								  @foreach($notintrainings as $d)
                                       <p>{{$d->emp_id}}</p>
                                 
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
    {!! Html::script("assets/libs/moment/moment.min.js")!!}
    {!! Html::script("assets/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")!!}
    {!! Html::script("assets/libs/wysihtml5x/wysihtml5x-toolbar.min.js")!!}
    {!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}
    {!! Html::script("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}
@endsection
