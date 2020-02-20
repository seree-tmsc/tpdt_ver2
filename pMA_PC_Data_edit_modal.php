<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <!--<div class="modal-content" style='background-color: rgb(178, 231, 247);'>-->
        <div class="modal-content">
            <div class="modal-header" style='background-color: rgb(8, 188, 243);color: navy;'>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Mode : [Update by <?php echo $user_emp_code;?>]</h4>
            </div>
            
            <form class="form-horizontal" role="form" id='edit-form' method='post'>
                <!--<div class="modal-body" id="edit_detail">-->
                <div class="modal-body">
                    <!--<input type="hidden" id="parameditempCode" name="parameditempCode">-->
                    <div class="form-group">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-3">
                            <label>Revise Date:</label>
                            <input type="text" value=<?php echo date('d/M/y');?> class='form-control' disabled>
                        </div>
                        <div class="col-lg-3">
                            <label>Enter Date:</label>
                            <input type="text" id="editEntDate" class='form-control' disabled>
                        </div>
                    </div>

                    <div class="form-group">                        
                        <div class="col-lg-5">
                            <label style="display: block; text-align: center;">Short Text:</label>
                            <input type="text" id="editShortText" name ='short_text' class='form-control' disabled>
                            <!--<textarea name="short_text" cols="50" rows="4" required></textarea>-->
                        </div>
                        <div class="col-lg-2">
                            <label style="display: block; text-align: right;">Quantity:</label>
                            <input type="number" id="editQty" name ='quantity' class='form-control' required>
                        </div>
                        <div class="col-lg-2">
                            <label style="display: block; text-align: right;">Unit Price:</label>
                            <input type="number" id="editUprice" name ='price' class='form-control' required>
                        </div>
                        <div class="col-lg-3">
                            <label style="display: block; text-align: right;">Amount:</label>
                            <input type="number" id="editAmt" name ='amount' class='form-control' disabled>
                        </div>
                    </div>

                    <div class="form-group">                        
                        <div class="col-lg-5">
                            <label>supplier:</label>
                            <input type="text" id="editsupName" name ='supplier_name' class='form-control' disabled>
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