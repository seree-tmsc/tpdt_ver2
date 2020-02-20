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
    if ($user_user_type == "A") 
    {
?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>TMSC TPDT System V.2</title>

            <?php require_once("include/library.php"); ?>
            <?php require_once("MA_COOIS_Script.php"); ?>
        </head>

        <!--<body style='background-color:black;'>-->

        <body style='background-color:LightSteelBlue;'>
            <!-- Begin Body page -->
            <div class="container">
                <br>
                <!-- Begin Static navbar -->
                <?php require_once("include/menu_navbar.php"); ?>
                <!-- End Static navbar -->

                <!-- Begin content page-->
                <!-- ----------------------------------- -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-inline">
                            <div class="pull-right">
                                <button class="btn btn-success" data-toggle="modal" data-target="#insert_modal">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    Insert
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p></p>
                        <!--<h5>User Data:</h5>-->
                        <?php include "pMA_COOIS_List.php"; ?>
                    </div>
                </div>
                <!-- ----------------------------------- -->
                <!-- End content page -->
            </div>
            <!-- End Body page -->

            <!-- Left slide menu -->
            <?php
            /*
                    if(strtoupper($_SESSION["ses_user_type"]) == 'A')
                    {                                                
                        require_once("include/menu_admin.php");
                    }
                    */
            ?>
            <!-- End Left slide menu -->


            <!-- Logout Modal-->
            <?php require_once("include/modal_logout.php"); ?>

            <!-- Change Password Modal-->
            <?php require_once("include/modal_chgpassword.php"); ?>

            <!-- Modal - Insert Record -->
            <?php require_once("pMA_COOIS_Insert_Modal.php"); ?>

            <!-- Modal - View Record -->
            <?php require_once("pMA_COOIS_View_Modal.php"); ?>

            <!-- Modal - Insert Record -->
            <?php require_once("pMA_COOSI_Edit_Modal.php"); ?>

            <script>
                //--------------------------
                // javascript for side-menu
                //--------------------------
                $(document).ready(function() {
                    /*
                    $('#right-slide').BootSideMenu({
                        side: "right",
                        pushBody: false,
                        duration:1000,
                        width:'20%'
                    });
                    */

                    /*
                    var table = $('#myTable').DataTable();
                    $('#column3_search').on( 'keyup', function () {
                        table
                            .columns(1)
                            .search(this.value)
                            .draw();
                    } );
                    */

                    $('#myTable').DataTable({
                        "searching": false,
                    });
                });
            </script>
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