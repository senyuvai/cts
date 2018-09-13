@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">Firma Eğitimcileri</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-4">
                    <div class="panel">
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="{{url('firmaegitimciler/add')}}">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Eğitimci Ekle</h3>
                                </div>

                                <div class="form-group">
                                    <label>Eğitimci Adı</label>
                                    <span class="help">e.g. "{{language_data('Software Engineer')}}"</span>
                                    <input type="text" class="form-control" required name="firmaegitimci">
                                </div>

                                <div class="form-group">
                                    <label>Firma</label>
                                    <select class="selectpicker form-control" data-live-search="true" name="egitimfirma">
                                        @foreach($egitimfirmalari as $d)
                                            <option value="{{$d->id}}">{{$d->egitimfirma}}</option>
                                         @endforeach
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
                            <h3 class="panel-title">Tüm Eğitimciler</h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 10%;">{{language_data('SL')}}#</th>
                                    <th style="width: 35%;">Eğitimci Adı</th>
                                    <th style="width: 30%;">Firma</th>
                                    <th style="width: 25%;">Aksiyonlar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($firmaegitimciler as $d)
                                <tr>
                                    <td data-label="SL">{{$d->id}}</td>
                                    <td data-label="Designation"><p>{{$d->firmaegitimci}}</p></td>
                                    <td data-label="Department"><p>{{$d->egitimfirma_name->egitimfirma}}</p></td>
                                    <td>

                                        <a class="btn btn-success btn-xs" href="#" data-toggle="modal" data-target=".modal_edit_firmaegitimci_{{$d->id}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>
                                        @include('admin.modal-edit-firmaegitimci')

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


            /*For Delete Designation*/
            $(".cdelete").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/firmaegitimciler/delete/" + id;
                    }
                });
            });

        });
    </script>
@endsection
