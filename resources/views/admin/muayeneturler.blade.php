@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">Muayene Türler</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            @include('notification.notify')
            <div class="row">

                <div class="col-lg-4">
                    <div class="panel">
                        <div class="panel-body">
                            <form class="" role="form" action="{{url('muayeneturler/add')}}" method="post">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Muayene Türü Ekle</h3>
                                </div>

                                <div class="form-group">
                                    <label>Muayene Türü Adı</label>
                                    <input type="text" class="form-control" required name="muayenetur">
                                </div>
								 <div class="form-group">
                                    <label>Geçerlilik Süresi</label>
                                <select class="selectpicker form-control" name="gecerlilik_suresi">
                                                        
												 <option value="6 Ay">6 Ay</option>
												 <option value="1 Yıl">1 Yıl</option> 
												<option value="2 Yıl">2Yıl</option>
												</select>
</div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('All Departments')}}</h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 10%;">{{language_data('SL')}}#</th>
                                    <th style="width: 40%;">Muayene Türü</th>
									<th style="width: 15%;">Geçerlilik Süresi</th>
                                    <th style="width: 35%;">{{language_data('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($muayeneturler as $d)
                                <tr>
                                    <td data-label="SL">{{$d->id}}</td>
                                    <td data-label="Department"><p>{{$d->muayenetur}}</p></td>
                                   <td data-label="Department"><p>{{$d->gecerlilik_suresi}}</p></td>
									
									<td>
                                        <a class="btn btn-success btn-xs" href="#" data-toggle="modal" data-target=".modal_edit_muayenetur_{{$d->id}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>


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
        $(document).ready(function(){
            $('.data-table').DataTable();


            /*For Delete Department*/
            $(".cdelete").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/muayeneturler/delete/" + id;
                    }
                });
            });


        });
    </script>
@endsection
