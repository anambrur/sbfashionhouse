<div id="viewModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-lebel="Colse">
                    <span aria-hidden="true"> &times;</span>
                </button>
                <h3 class="modal-title">Add Unit</h3>
            </div>
            <div class="modal-body">
                <form data-toggle="validator">
                    <div class="form-group">
                        {{ Form::label('title', 'Name', array('class' => 'requiredStar')) }}
                        {!! Form::text('title', null, ['class' => 'form-control title', 'required', 'placeholder' =>'Name']); !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('actual_name', 'Actual Name', array('class' => 'requiredStar')) }}
                        {!! Form::text('actual_name', null, ['class' => 'form-control actual_name', 'placeholder' =>'Actual Name', 'required']); !!}
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-success', 'id' => 'unit_submit'])!!}
                <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
