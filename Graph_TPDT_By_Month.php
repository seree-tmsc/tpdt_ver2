<?php
//date_default_timezone_set("Asia/Bangkok"); 
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
    if ($user_user_type == "A" or $user_user_type == "P" or $user_user_type == "U") 
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

            <?php require_once("include/library_TPDT.php"); ?>
            
            <script>
                $(document).ready(function() {
                    //console.log( "ready!" );            
                    //setTimeout(function(){window.location.reload(1);}, 60000);

                    /* attach a submit handler to the form */
                    $("#pd_close_form").submit(function(event) {
                        /* stop form from submitting normally */
                        event.preventDefault();

                        console.log($(this).serialize());
                        $.ajax({
                            url: "close_pd_status.php",
                            method: "post",
                            data: $('#pd_close_form').serialize(),
                            /*
                            beforeSend:function()
                            {
                                $('#insert').val('Insert...')
                            },
                            */
                            success: function(data) {
                                if (data == '') {
                                    $('#pd_close_form')[0].reset();
                                    $('#pd_close_modal').modal('hide');
                                    location.reload();
                                } else {
                                    alert(data);
                                    location.reload();
                                }
                            }
                        });
                    });

                    $("#pd_open_form").submit(function(event) {
                        /* stop form from submitting normally */
                        event.preventDefault();

                        console.log($(this).serialize());
                        $.ajax({
                            url: "open_pd_status.php",
                            method: "post",
                            data: $('#pd_open_form').serialize(),
                            /*
                            beforeSend:function()
                            {
                                $('#insert').val('Insert...')
                            },
                            */
                            success: function(data) {
                                if (data == '') {
                                    $('#pd_open_form')[0].reset();
                                    $('#pd_open_modal').modal('hide');
                                    location.reload();
                                } else {
                                    alert(data);
                                    location.reload();
                                }
                            }
                        });
                    });
                });


                $(function() { // document ready            
                    var d = new Date();
                    //console.log(d);

                    cCurDay = '' + d.getDate();
                    if (cCurDay.length < 2) cCurDay = '0' + cCurDay;
                    cCurMonth = '' + (d.getMonth() + 1);
                    if (cCurMonth.length < 2) cCurMonth = '0' + cCurMonth;
                    cCurYear = d.getFullYear();
                    cCurHour = '' + d.getHours();
                    if (cCurHour.length < 2) cCurHour = '0' + cCurHour;
                    cCurMin = '' + d.getMinutes();
                    if (cCurMin.length < 2) cCurMin = '0' + cCurMin;
                    //console.log(cCurMIn);

                    //cCurDate = cCurYear+"-"+cCurMonth+"-"+cCurDay;
                    //cCurTime = cCurHour.toString()+':'+cCurMin.toString();            
                    //cCurTimeStart = cCurDate + 'T' + cCurTime;                        

                    //cCurTimeStart = cCurYear+"-"+cCurMonth+"-"+cCurDay + " " + cCurHour.toString()+':'+cCurMin.toString();
                    cCurTimeStart = cCurYear + "-" + cCurMonth + "-" + '01' + " " + cCurHour.toString() + ':' + cCurMin.toString();

                    $('#calendar').fullCalendar({
                        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                        themeSystem: 'jquery-ui',
                        //nowIndicator: true,                
                        locale: 'th',
                        lang: 'th',

                        //height: 700,
                        now: cCurTimeStart,

                        //editable: true, // enable draggable events
                        aspectRatio: 2,
                        scrollTime: '00:00:00',
                        //minTime: '08:00:00',
                        contentHeight: 'auto',
                        defaultTimedEventDuration: '00:01:00',

                        /* ------------- */
                        /* -- HEADER --- */
                        /* ------------- */
                        titleFormat: 'D MMMM YYYY',
                        header: {
                            left: 'prev,today,next, myCustomButton',
                            center: 'title',
                            right: 'timeline31Day,timeline15Day',
                        },

                        buttonText: {
                            timeline31Day: '1 Month',
                            timeline15Day: '15 Day',
                            today: 'Today',
                        },

                        customButtons: {
                            myCustomButton: {
                                text: 'Refresh Page',
                                click: function() {
                                    window.location.reload();
                                    //alert('You clicked the custom button!');
                                },
                            }
                        },

                        /* ----------- */
                        /* -- VIEW --- */
                        /* ----------- */
                        defaultView: 'timeline31Day',
                        views: {
                            timeline15Day: {
                                type: 'timeline',
                                duration: {
                                    days: 15
                                },
                                slotDuration: '12:00'
                            },
                            timeline31Day: {
                                type: 'timeline',
                                duration: {
                                    days: 31
                                },
                                slotDuration: '6:00'
                            },
                        },

                        /* --------------- */
                        /* -- RESOURCE --- */
                        /* --------------- */
                        resourceAreaWidth: '18%',
                        resourceLabelText: "Reactor Information",
                        resourceColumns: [{
                                labelText: 'Rx-No.',
                                field: 'rx_no',
                                width: '60px'
                            },
                            {
                                labelText: 'Run-Time',
                                field: 'runtime',
                                width: '80px'
                            },
                            {
                                labelText: 'Qty.',
                                field: 'qty',
                                width: '50px'
                            }
                        ],

                        resources: 'createResource.php?sbu=<?php echo $user_sbu; ?>',

                        events: 'createEvent.php?sbu=<?php echo $user_sbu; ?>',
                    });
                });
            </script>

            <style>
                body {
                    margin: 0;
                    padding: 0;
                    font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
                    font-size: 14px;
                }

                #calendar {
                    /*max-width: 1024px;*/
                    width: 95%;
                    margin: 20px auto;
                }
            </style>
        </head>

        <body>
            <div id="calendar"></div>

            <div class="modal fade" id="pd_open_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style='background-color: Silver; color: Black;'>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Open Production:</h4>
                        </div>

                        <form class="form-horizontal" role="form" id='pd_open_form' method='post'>
                            <div class="modal-body" id="pd_open_detail">
                                <input type="hidden" name="mat_code" id="param_pd_open_mat_code">
                                <input type="hidden" name="lot_no" id="param_pd_open_lot_no">

                                <div class="form-group">
                                    <div class="col-lg-7">
                                        <label style="display: block; text-align: center;">Material Name:</label>
                                        <input type="text" id="pd_open_mat_name" class="form-control" disabled>
                                    </div>
                                    <div class="col-lg-5">
                                        <label style="display: block; text-align: center;">Material Code:</label>
                                        <input type="text" id="pd_open_mat_code" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-8">
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Lot No.:</label>
                                        <input type="text" id="pd_open_lot_no" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Actual Start Date:</label>
                                        <input type="date" name="actual_startdate" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Actual Start Time:</label>
                                        <input type="time" name="actual_starttime" class="form-control" value="<?php echo date('H:i:s'); ?>" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Production Status:</label>
                                        <input type="text" class='form-control' style='color: red; text-align: center;' value='O' disabled>
                                        <input type="hidden" name="pd_status" value='O'>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" id='insert' class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-close btn-danger" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="pd_close_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style='background-color: SeaGreen; color: Lime;'>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Close Production:</h4>
                        </div>

                        <form class="form-horizontal" role="form" id='pd_close_form' method='post'>
                            <div class="modal-body">
                                <input type="hidden" name="mat_code" id="param_pd_close_mat_code">
                                <input type="hidden" name="lot_no" id="param_pd_close_lot_no">

                                <div class="form-group">
                                    <div class="col-lg-7">
                                        <label style="display: block; text-align: center;">Material Name:</label>
                                        <input type="text" id="pd_close_mat_name" class="form-control" disabled>
                                    </div>
                                    <div class="col-lg-5">
                                        <label style="display: block; text-align: center;">Material Code:</label>
                                        <input type="text" id="pd_close_mat_code" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-8">
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Lot No.:</label>
                                        <input type="text" id="pd_close_lot_no" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Actual End Date:</label>
                                        <input type="date" name="actual_enddate" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Actual End Time:</label>
                                        <input type="time" name="actual_endtime" class="form-control" value="<?php echo date('H:i:s'); ?>" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Production Status:</label>
                                        <input type="text" class='form-control' style='color: red; text-align: center;' value='C' disabled>
                                        <input type="hidden" name="pd_status" value='C'>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" id='insert' class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-close btn-danger" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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