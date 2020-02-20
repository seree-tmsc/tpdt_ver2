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
                <input type="hidden" name='paramEnt_By' value=<?php echo $user_emp_code;?>>
                <div class="modal-body">
                    <!--<input type="hidden" id="parameditempCode" name="parameditempCode">-->
                    <div class="form-group">
                        <div class="col-lg-6">
                        </div>                        
                        <div class="col-lg-3">
                            <label>Last Enter Date:</label>
                            <input type="text" id="editEntDate" class='form-control' disabled>
                        </div>
                        <div class="col-lg-3">
                            <label>Revise Date:</label>
                            <input type="text" value=<?php echo date('d/M/y');?> class='form-control' disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-3">
                            <label>Material Code:</label>
                            <input type="text" id="editPdCode" class='form-control' disabled>
                            <input type="hidden" id="parameditPdCode" name="parameditPdCode">
                        </div>
                        <div class="col-lg-7">
                            <label>Material Name:</label>
                            <input type="text" id="editPdName" class='form-control' disabled>                            
                        </div>
                        <div class="col-lg-2">
                            <label style="display: block; text-align: center;">PDLT [Hrs.]:</label>
                            <input type="number" id="editPdLt" name ='editPdLt' class='form-control'>                            
                        </div>                        
                    </div>

                    <div class="form-group">
                        <div class="col-lg-2">
                            <label style="display: block; text-align: center;">SBU:</label>
                            <select class="form-control" id ="editPdSbu" name="editPdSbu" required>
                                <option value="IRS">IRS</option>
                                <option value="IRW">IRW</option>
                                <option value="UU">UU</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label style="display: block; text-align: center;">Product Group:</label>
                            <select class="form-control" id="editPdGroup" name="editPdGroup" required>
                                <option value="Acrylax">Acrylax</option>
                                <option value="Almatex">Almatex</option>
                                <option value="Estar">Estar</option>
                                <option value="Flexible foam">Flexible foam</option>
                                <option value="Isocyanate blend">Isocyanate blend</option>
                                <option value="Olester">Olester</option>
                                <option value="Other">Other</option>
                                <option value="Polyester">Polyester</option>
                                <option value="Pre-polymer">Pre-polymer</option>
                                <option value="Refrigerator">Refrigerator</option>
                                <option value="Repack">Repack</option>
                                <option value="Rigid foam">Rigid foam</option>
                                <option value="UVAN">UVAN</option>
                                <option value="Vinylax">Vinylax</option>
                                <option value="WS">WS</option>
                            </select>

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