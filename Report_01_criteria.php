<?php
    include_once('include/chk_Session.php');
    if($user_email == "")
    {
        echo "<script> 
                alert('Warning! Please Login!'); 
                window.location.href='login.php'; 
            </script>";
    }
    else
    {
        if($user_user_type == "A" or $user_user_type == "P")
        {
?>
        <!DOCTYPE html>
        <html>
            <head>                
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>TMSC TPDT System V.2</title>
                <link rel="icon" type="image/png"  href="images/tmsc-logo-64x32.png">

                <?php require_once("include/library.php"); ?>    
            </head>

            <body>                
                <div class="container">
                    <br>                    
                    <?php require_once("include/submenu_navbar.php"); ?>

                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4">                                                        
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    Report-A
                                </div>

                                <div class="panel-body">
                                    <form method='post' action='Report_01_main.php' target='_blank'>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-lg-5 control-label">Production Order : </label>
                                                <div class="col-lg-7">                                
                                                    <input type="text" name="pd_ord" id='pd_ord' class='form-control'>
                                                </div>
                                            </div>
                                        </div>                                        

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