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
        if($user_user_type == "A")
        {
?>        
        <!DOCTYPE html>
        <html>
            <head>                
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>TMSC TPDT System V.1.0</title>
                <link rel="icon" type="image/png"  href="images/tmsc-logo-64x32.png">

                <?php require_once("include/library.php"); ?>
            </head>

            <body>
                <!-- Begin Body page -->
                <div class="container">
                    <br>
                    <!-- Begin Static navbar -->
                    <?php require_once("include/submenu_navbar.php"); ?>
                    <!-- End Static navbar -->

                    <!-- Begin content page-->
                    <!-- ----------------------------------- -->
                    <div class="row">
                        <div class="col-md-12">
                            <p></p>
                            <?php
                                $pd_ord = $_POST['pd_ord'];
                                include "Report_01_list.php"; 
                            ?>
                        </div>
                    </div>
                    <!-- ----------------------------------- -->
                    <!-- End content page -->
                </div>  
                <!-- End Body page -->

            </body>
        </html>
<?php
        }
        else
        {
            echo "<script> alert('You are not authorization for this menu ... Please contact your administrator!'); window.location.href='pMain.php'; </script>";
        }
    }
?>