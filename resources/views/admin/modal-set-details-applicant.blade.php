<div class="modal fade modal_set_training_applicant_details_{{$d->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{language_data('Change Status')}}</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{url('training/set-applicant-details')}}" method="post" enctype="multipart/form-data">

                <div class="modal-body">

                  
					
					 <div class="form-group">
                        <label>Sertifika Numarası: </label>
                     <input type="text" class="form-control" required="" name="employee_training_document_number" value="{{$d->employee_training_document_number}}">
                    </div>
					  <div class="form-group">
                        <label>Notu: </label>
                     <input type="text" class="form-control" required="" name="employee_training_grade" value="{{$d->employee_training_grade}}">
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
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="cmd" value="{{$d->id}}">
                    <input type="hidden" name="training_id" value="{{$d->training_id}}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{language_data('Update')}}</button>
                </div>

            </form>
        </div>
    </div>

</div>
