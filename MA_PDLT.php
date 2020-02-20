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
        if($user_user_type == "A" || $user_user_type == "P")
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
                <?php require_once("MA_PDLT_Script.php"); ?>
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
                            <?php include "MA_PDLT_List.php"; ?>
                        </div>
                        <h1>Load Data Complete!</h1>
                    </div>
                    <!-- ----------------------------------- -->
                    <!-- End content page -->
                </div>  
                <!-- End Body page -->
                
                <!-- Logout Modal-->
                <?php require_once("include/modal_logout.php"); ?>

                <!-- Change Password Modal-->
                <?php require_once("include/modal_chgpassword.php"); ?>
                        
                <!-- Modal - Insert Record -->
                <?php require_once("MA_PDLT_Insert_Modal.php"); ?>                

                <!-- Modal - View Record -->
                <?php //require_once("pMA_PDLT_View_Modal.php"); ?>

                <!-- Modal - Insert Record -->
                <?php require_once("MA_PDLT_Edit_Modal.php"); ?>                

                <script>
                    //--------------------------
                    // javascript for side-menu
                    //--------------------------
                    $(document).ready(function () {
                        $('#myTable').DataTable({
                            paging: false,
                            bFilter: false,
                            ordering: false,
                            searching: true,
                            dom: 't' // This shows just the table
                        });

                        // Setup - add a text input to each footer cell
                        var nColNo = 1;
                        $('#myTable thead th').each( function () 
                            {
                                if(nColNo <= 5)
                                {
                                    var title = $(this).text();
                                    $(this).html( '<input type="text" placeholder="Search '+title+'" style="width:100%;" />' );
                                }
                                nColNo = nColNo + 1;
                            });
                        
                        // DataTable
                        var table = $('#myTable').DataTable();
                        
                        // Apply the search
                        table.columns().every( function () 
                        {
                            var that = this;
                    
                            $( 'input', this.header() ).on( 'keyup change', function () 
                            {
                                if ( that.search() !== this.value ) 
                                {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            });
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