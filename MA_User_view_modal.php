<div class="modal fade" id="view_modal" tabindex="-1" role="dialog">
    <!--<div class="modal-dialog modal-lg" role="document">-->
    <div class="modal-dialog role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">MODE : View Data</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-5 control-label">Employee Code : </label>
                        <div class="col-lg-3">                                
                            <input type="text" id="viewEmpCode" class='form-control' disabled>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-5 control-label">e-Mail : </label>
                        <div class="col-lg-4">
                            <input type="email" id="viewEmail" class='form-control' disabled>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-5 control-label">User Type : </label>
                        <div class="col-lg-4">
                            <select class="form-control" id="viewUserType" name="edituserType" disabled>
                                <option value="U">User</option>
                                <option value="P">Power User</option>
                                <option value="A">Administrator</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-5 control-label">My Team : </label>
                        <div class="col-lg-3">
                            <input type="text" id="viewMyTeam" class='form-control' disabled>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-5 control-label">Created Date : </label>
                        <div class="col-lg-4">
                            <input type="date" id="viewCreatedDate" name='editcreatedDate' class='form-control' value="<?php echo date('Y-m-d'); ?>" disabled>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>