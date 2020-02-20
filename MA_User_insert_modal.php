<div class="modal fade" id="insert_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">MODE : Insert Data</h4>
            </div>

            <form class="form-horizontal" role="form" id='insert-form' method='post'>
                <div class="modal-body" id="insert_detail">

                    <div class="form-group">
						<label class="col-lg-5 control-label">Employee Code : </label>
						<div class="col-lg-4">
                            <input type="text" name="empCode" class='form-control' required>
							<span class="help-block">รหัสพนักงาน [XX-999]</span>
						</div>
                    </div>
                    <div class="form-group">
						<label class="col-lg-5 control-label">e-Mail : </label>
						<div class="col-lg-4">
                            <input type="email" name='eMail' class='form-control' required>
							<span class="help-block">e-Mail [xxxxxxxxx@tmsc.co.th]</span>
						</div>
                    </div>
                    <div class="form-group">
						<label class="col-lg-5 control-label">User Type : </label>
						<div class="col-lg-4">                            
                            <select class="form-control" name="userType" required>
                                <option value="U">User</option>
                                <option value="P">Power User</option>
                                <option value="A">Administrator</option>
                            </select>
                            <span class="help-block">ประเภทผู้ใช้งาน</span>
						</div>
                    </div>
                    <div class="form-group">
						<label class="col-lg-5 control-label">My Team : </label>
						<div class="col-lg-4">
                            <input type="text" name="myTeam" class='form-control' required>
							<span class="help-block">SBU ที่ต้องการใช้งาน [IRS,IRW,UU];</span>
						</div>
                    </div>
                    <div class="form-group">
						<label class="col-lg-5 control-label">Employee Code : </label>
						<div class="col-lg-4">
                            <input type="date" class='form-control' value="<?php echo date('Y-m-d'); ?>" disabled>                            
							<span class="help-block">วันที่สร้าง User-ID</span>
                        </div>
                        <input type="hidden" name='createdDate' value="<?php echo date('Y-m-d'); ?>">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" id='insert' class="btn btn-success">Insert</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>