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
            <link rel="icon" type="image/png" href="images/tmsc-logo-64x32.png">

            <?php require_once("include/library.php"); ?>
        </head>
        
        <body>
            
            <div class="container">
                <br>

                <!-- Menu -->
                <?php require_once("include/submenu_navbar.php"); ?>
                
                <!-- ปุ่ม Insert -->
                <div class="row">
                    <div class="col-lg-12">
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
                
                <!-- Table -->
                <div class="row">
                    <div class="col-lg-12">
                        <p></p>
                        <?php include "MA_User_list.php"; ?>
                    </div>
                </div>

            </div>

            <!-- Modal - Insert Record -->
            <?php require_once("MA_User_insert_modal.php"); ?>

            <!-- Modal - View Record -->
            <?php require_once("MA_User_view_modal.php"); ?>

            <!-- Modal - Insert Record -->
            <?php require_once("MA_User_edit_modal.php"); ?>

            <script>
                //--------------------------
                // javascript for side-menu
                //--------------------------
                $(document).ready(function() {
                    $('#myTable').DataTable({
                        /*
                        paging: false,
                        bFilter: false,
                        ordering: false,
                        searching: true,
                        dom: 't' // This shows just the table
                        */
                    });

                    $('.btnClose').click(function() {
                        $('#insert-form')[0].reset();
                    })

                    /* attach a submit handler to the form */
                    $("#insert-form").submit(function(event) {
                        /* stop form from submitting normally */
                        event.preventDefault();

                        console.log($(this).serialize());
                        $.ajax({
                            url: "MA_User_insert.php",
                            method: "post",
                            data: $('#insert-form').serialize(),
                            success: function(data) {
                                if (data == '') {
                                    $('#insert-form')[0].reset();
                                    $('#insert_modal').modal('hide');
                                    location.reload();
                                } else {
                                    alert(data);
                                    location.reload();
                                }
                            }
                        });
                    });

                    $("#edit-form").submit(function(event) {
                        /* stop form from submitting normally */
                        event.preventDefault();

                        console.log($(this).serialize());
                        $.ajax({
                            url: "pMA_User_edit.php",
                            method: "post",
                            data: $('#edit-form').serialize(),
                            success: function(data) {
                                if (data == '') {
                                    $('#edit-form')[0].reset();
                                    $('#edit_modal').modal('hide');
                                    location.reload();
                                } else {
                                    alert(data);
                                    location.reload();
                                }
                            }
                        });
                    });

                    $('.view_data').click(function() {
                        var code = $(this).attr("emp_code");
                        $.ajax({
                            url: "MA_User_fetch.php",
                            method: "post",
                            data: {
                                id: code
                            },
                            dataType: "json",
                            success: function(result) {
                                $('#viewEmpCode').val(result.emp_code);
                                $('#viewEmail').val(result.user_email);
                                $('#viewUserType').val(result.user_type);
                                $('#viewMyTeam').val(result.user_myteam);
                                $('#viewCreatedDate').val(result.user_create_date);
                                
                                $('#view_modal').modal('show');
                            }
                        });
                    });

                    $('.edit_data').click(function() {
                        var code = $(this).attr("emp_code");
                        $.ajax({
                            url: "MA_User_fetch.php",
                            method: "post",
                            data: {
                                id: code
                            },
                            dataType: "json",
                            success: function(result) {
                                $('#parameditempCode').val(result.emp_code);
                                $('#editempCode').val(result.emp_code);
                                $('#editeMail').val(result.user_email);
                                $('#edituserType').val(result.user_type);
                                $('#editMyTeam').val(result.user_myteam);
                                $('#editcreatedDate').val(result.user_create_date);

                                $('#edit_modal').modal('show');
                            }
                        });
                    });

                    $('.delete_data').click(function() {
                        var code = $(this).attr("emp_code");
                        var lConfirm = confirm("Do you want to delete this record?");
                        if (lConfirm) {
                            $.ajax({
                                url: "MA_User_delete.php",
                                method: "post",
                                data: {
                                    id: code
                                },
                                success: function(data) {
                                    alert('Delete Data alreay!');
                                    location.reload();
                                }
                            });
                        }
                    });
                })
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