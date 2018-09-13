@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">Sgk</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            @include('notification.notify')
            <div class="row">

                <div class="col-lg-4">
                    <div class="panel">
                        <div class="panel-body">
                            <form class="" role="form" action="{{url('sgklar/add')}}" method="post">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> SGK Tanımı Ekle</h3>
                                </div>

                                <div class="form-group">
                                    <label>Sgk Ünvanı</label>
                                    <span class="help">e.g. "Beden İşçisi"</span>
                                    <input type="text" class="form-control" required name="sgk_name">
                                </div>
								 <div class="form-group">
                                    <label>Sgk Kodu</label>
                                    <span class="help">e.g. "9622.02"</span>
                                    <input type="text" class="form-control" required name="sgk_kodu">
                                </div>

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> Ekle </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Tüm SGK Tanımları</h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 10%;">No#</th>
                                    <th style="width: 35%;">SGK Ünvanı</th>
								  <th style="width: 30%;">SGK Kodu</th>
                                    <th style="width: 25%;">Aksiyonlar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sgklar as $d)
                                <tr>
                                    <td data-label="SL">{{$d->id}}</td>
                                    <td data-label="Sgk"><p>{{$d->sgk_name}}</p></td>
									   <td data-label="Sgk"><p>{{$d->sgk_kodu}}</p></td>
                                    <td>
                                        <a class="btn btn-success btn-xs" href="#" data-toggle="modal" data-target=".modal_edit_sgk_{{$d->id}}"><i class="fa fa-edit"></i>Düzenle</a>
                                        @include('admin.modal-edit-sgk')


                                        <a href="#" class="btn btn-danger btn-xs cdelete" id="{{$d->id}}"><i class="fa fa-trash"></i> Sil</a>

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


            /*For Delete sgk*/
            $(".cdelete").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/sgklar/delete/" + id;
                    }
                });
            });


        });
    </script>
@endsection
