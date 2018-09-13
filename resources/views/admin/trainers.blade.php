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
            <h2 class="page-title">{{language_data('Trainers')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('Trainers')}}</h3>
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#add-new-trainer"><i class="fa fa-plus"></i> {{language_data('Add New Trainer')}}</button>
                            <br>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 20%;">Eğitmen</th>
                                    <th style="width: 15%;">Firması</th>
                                    <th style="width: 10%;">Mail Adresi</th>
                                    <th style="width: 15%;">Telefon Numarası</th>
									<th style="width: 15%;">Firma Adresi</th>
                                    <th style="width: 25%;" class="text-right">{{language_data('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($trainers as $d)
                                    <tr>
                                        <td data-label="Name"><p>{{$d->first_name}}</p></td>
                                        <td data-label="Email"><p>{{$d->organization}}</p></td>
                                        <td data-label="Designation"><p>{{$d->email_address}}</p></td>
                                        <td data-label="Organization"><p>{{$d->phone}}</p></td>
										<td data-label="Organization"><p>{{$d->address}}</p></td>
                                        <td data-label="Actions" class="text-right">
											
											                                            <a class="btn btn-primary btn-xs" href="#" data-toggle="modal" data-target=".modal_set_training_trainer_details_{{$d->id}}"><i class="fa fa-list"></i> Verdiği Eğitimler</a>
										                                        @include('admin.modal-see-details-trainer')

											<a class="btn btn-success btn-xs" href="{{url('training/view-trainers-info/'.$d->id)}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>
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
            <div class="modal fade" id="add-new-trainer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{language_data('Add New Trainer')}}</h4>
                        </div>
                        <form class="form-some-up" role="form" method="post" action="{{url('training/post-new-trainer')}}">
                            <div class="modal-body">
							<div class="row">
							 <div class="col-md-6">
                                <div class="form-group">
                                    <label>Eğitimci Adı Soyadı</label>
                                    <input type="text" class="form-control" required="" name="first_name">
                                </div>
								<div class="form-group">
                                    <label>EMail Adresi</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                
								 </div>
								
							 <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Firması</label>
                                    <input type="text" class="form-control" required="" name="organization">
                                </div>

                                <div class="form-group">
                                    <label>Telefon Numarası</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>

							 </div>
								
							 </div>
<div class="form-group">
                                    <label>Firma Adresi</label>
                                    <input type="text" class="form-control" name="address">
                                </div>
								<div class="form-group">
                                    <label>Eğitimci Hakkında</label>
                                    <textarea class="textarea-wysihtml5 form-control" name="trainer_expertise"></textarea>
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
                        window.location.href = _url + "/training/delete-trainer/" + id;
                    }
                });
            });


        });
    </script>
@endsection
