<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">MODE : Edit Data</h4>
            </div>

            <form class="form-horizontal" role="form" id='edit-form' method='post'>
                <div class="modal-body" id="edit_detail">
                    <input type="hidden" id="parameditempCode" name="parameditempCode">

                    <div class="form-group">
						<label class="col-lg-5 control-label">Employee Code : </label>
						<div class="col-lg-3">
                            <!--<input id="textinput" name="textinput" type="text" class="form-control input-md">-->
                            <input type="text" id="editempCode" class='form-control' disabled>
							<!--<span class="help-block">หมายเลข NCR</span>-->
						</div>
                    </div>
                    
                    <div class="form-group">
						<label class="col-lg-5 control-label">e-Mail : </label>
						<div class="col-lg-4">
                            <input type="email" id="editeMail" class='form-control' disabled>
						</div>
                    </div>
                    
                    <div class="form-group">
						<label class="col-lg-5 control-label">User Type : </label>
						<div class="col-lg-4">
                            <select class="form-control" id="edituserType" name="edituserType">
                                <option value="U">User</option>
                                <option value="P">Power User</option>
                                <option value="A">Administrator</option>
                            </select>
						</div>
                    </div>

                    <div class="form-group">
						<label class="col-lg-5 control-label">My Team : </label>
						<div class="col-lg-3">
                            <input type="text" id="editMyTeam" class='form-control' disabled>
						</div>
                    </div>
                    
                    <div class="form-group">
						<label class="col-lg-5 control-label">Created Date : </label>
						<div class="col-lg-4">
                            <input type="date" id="editcreatedDate" name='editcreatedDate' class='form-control' value="<?php echo date('Y-m-d'); ?>" disabled>
						</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id='insert' class="btn btn-success">Edit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>