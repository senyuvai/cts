<div class="modal fade modal_edit_sgk_{{$d->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">SGK Ünvanı Düzenle</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{url('sgklar/update')}}" method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <label>SGK Ünvanı :</label>
                        <input type="text" class="form-control" required="" name="sgk_name" value="{{$d->sgk_name}}">
                    </div>

                </div>
				<div class="modal-body">
                    <div class="form-group">
                        <label>SGK Kodu :</label>
                        <input type="text" class="form-control" required="" name="sgk_kodu" value="{{$d->sgk_kodu}}">
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="cmd" value="{{$d->id}}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{language_data('Update')}}</button>
                </div>

            </form>
        </div>
    </div>

</div>

