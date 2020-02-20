<div class="modal fade" id="insert_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style='background-color: SeaGreen; color: Lime;'>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Insert Mode: [Insert by <?php echo $user_emp_code;?>]</h4>
            </div>
            
            <form class="form-horizontal" role="form" id='insert-form' method='post'>
                <div class="modal-body" id="insert_detail">                    
                    <div class="form-group">
                        <input type="hidden" value='<?php echo $user_emp_code;?>' name='ent_by'>
                        <div class="col-lg-9">
                        </div>
                        <div class="col-lg-3">
                            <label style="display: block; text-align: center;">Enter Date:</label>
                            <input type="date" name ="ent_date" class='form-control' value="<?php echo date('Y-m-d'); ?>" disabled>
                        </div>                        
                    </div>

                    <div class="form-group">                        
                        <div class="col-lg-5">
                            <label style="display: block; text-align: left;">Short Text:</label>
                            <input type="text" name ='short_text' class='form-control' required>
                            <!--<textarea name="short_text" cols="50" rows="4" required></textarea>-->
                        </div>                        
                        <div class="col-lg-2">
                            <label style="display: block; text-align: right;">Unit Price:</label>
                            <input type="number" id= "price" name ='price' class='form-control' required style='text-align: right;' step=".01">
                        </div>
                        <div class="col-lg-2">
                            <label style="display: block; text-align: right;">Quantity:</label>
                            <input type="number" id="quantity" name ='quantity' class='form-control' required style='text-align: right;'>
                        </div>
                        <div class="col-lg-3">
                            <label style="display: block; text-align: right;">Amount:</label>                            
                            <input type="text" id="amount" name ='amount' class='form-control' required style='color: red; text-align: right;' value=0 disabled>
                        </div>                        
                    </div>

                    <div class="form-group">                        
                        <div class="col-lg-5">
                            <label>Supplier Name:</label>
                            <input type="text" name ='supplier_name' class='form-control' required>
                        </div>
                    </div>
                </div>                        
                
                <div class="modal-footer">
                    <button type="submit" id='insert' class="btn btn-success">Insert</button>
                    <button type="button" class="btn btn-close btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>            
        </div>
    </div>
</div>