<div class="modal fade modal_edit_firmaegitimci_{{$d->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{language_data('Edit')}} Firma Eğitimci</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{url('firmaegitimciler/update')}}" method="post">

                <div class="modal-body">

                    <div class="form-group">
                        <label>Eğitimci Adı:</label>
                        <input type="text" class="form-control" required="" name="firmaegitimci" value="{{$d->firmaegitimci}}">
                    </div>

                    <br>
                    <br>
                    <div class="form-group">
                        <label>Firma : </label>
                        <select class="selectpicker form-control" data-live-search="true" name="egitimfirma">
                            @foreach($egitimfirmalari as $des)
                                <option value="{{$des->id}}" @if($d->did==$des->id) selected @endif >{{$des->egitimfirma}}</option>
                            @endforeach
                        </select>
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

