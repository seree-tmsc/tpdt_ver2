<?php
include_once('include/chk_Session.php');
if ($user_email == "") 
{
    echo "<script> 
                alert('Warning! Please Login!'); 
                window.location.href='login.php'; 
            </script>";
} 
else 
{
    if ($user_user_type == "A" or $user_user_type == "P") 
    {
?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>TMSC TPDT System V.2</title>
            <link rel="icon" type="image/png" href="images/tmsc-logo-64x32.png">

            <?php require_once("include/library.php"); ?>
        </head>

        <body>
            <div class="container">
                <br>
                <?php require_once("include/submenu_navbar.php"); ?>

                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4">
                        <div class="panel panel-success" id="panel-header">
                            <div class="panel-heading">
                                Criteria
                            </div>

                            <div class="panel-body">
                                <form method='post' action='PDSCH_AF_List.php'>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label>Actual Finish Date</label>
                                            <input type="date" value="<?php echo date('Y-m-d'); ?>" name="param_dDate" class='form-control'>
                                        </div>
                                    </div>
                                    <!--
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label>Select Month</label>
                                                <select id ='nMonth' name="nMonth" class="form-control" required>
                                                    <option value="1">Jan</option>
                                                    <option value="2">Feb</option>
                                                    <option value="3">Mar</option>
                                                    <option value="4">Apr</option>
                                                    <option value="5">May</option>
                                                    <option value="6">Jun</option>
                                                    <option value="7">Jul</option>
                                                    <option value="8">Aug</option>
                                                    <option value="9">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>                                            
                                                </select>
                                            </div>                                    
                                            <div class="col-lg-6">
                                                <label>Select Year</label>
                                                <select id ='nYear' name="nYear" class="form-control" required>
                                                    <option value="<?php //echo date('Y');
                                                                    ?>"><?php //echo date('Y')
                                                                                                ?></option>
                                                    <option value="<?php //echo date('Y')-1;
                                                                    ?>"><?php //echo date('Y')-1
                                                                                                ?></option>
                                                    <option value="<?php //echo date('Y')-2;
                                                                    ?>"><?php //echo date('Y')-2
                                                                                                ?></option>
                                                </select>
                                            </div>                                            
                                        </div>
                                        -->

                                    <div class="row">
                                        <br>
                                        <div class="col-lg-9">
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="submit" id='insert' class='btn btn-success'>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>

            </script>
        </body>

        </html>
<?php
    } 
    else 
    {
        echo "<script> alert('You are not authorization for this menu ... Please contact your administrator'); window.location.href='pMain.php'; </script>";
    }
}
?>