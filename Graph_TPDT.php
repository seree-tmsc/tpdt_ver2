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
            <title>TMSC TPDT System V.1.0</title>
            <link rel="icon" type="image/png" href="images/tmsc-logo-64x32.png">

            <?php require_once("include/library_TPDT.php"); ?>
            <script>
                $(document).ready(function() {
                    //console.log( "ready!" );

                    /*-----------------------------------*/
                    /*-- Refresh screen every 1 minute --*/
                    /*-----------------------------------*/
                    //setTimeout(function(){window.location.reload(1);}, 60000);

                    // -- Initial blowdown parameter
                    $('#chkOption input[type="checkbox"]').prop('checked', false);
                    $('select#rxNo').prop('disabled', true);
                    $('#startDateBD').prop('disabled', true);
                    $('#startTimeBD').prop('disabled', true);

                    // -- Listening event for form submit of pd_open_moal --
                    $("#pd_open_form").submit(function(event) {
                        /* stop form from submitting normally */
                        event.preventDefault();

                        console.log($(this).serialize());
                        $.ajax({
                            url: "change_pd_status_to_open.php",
                            method: "post",
                            data: $('#pd_open_form').serialize(),
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

                    // -- Listening event for form submit of pd_close_moal --
                    $("#pd_close_form").submit(function(event) {
                        /* stop form from submitting normally */
                        event.preventDefault();

                        console.log($(this).serialize());
                        if($('#chkOption input[type="checkbox"]').prop("checked") == true)
                        {
                            alert('BD');
                            $.ajax({
                                url: "change_pd_status_to_blowdown.php",
                                method: "post",
                                data: $('#pd_close_form').serialize(),
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
                        }
                        else
                        {
                            alert('PD');
                            $.ajax({
                                url: "change_pd_status_to_close.php",
                                method: "post",
                                data: $('#pd_close_form').serialize(),
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
                        }
                    });
                    
                    // -- Listening event for form submit of ws_open_moal --
                    $("#ws_open_form").submit(function(event) {
                        /* stop form from submitting normally */
                        event.preventDefault();

                        console.log($(this).serialize());
                        $.ajax({
                            url: "change_pd_status_to_open.php",
                            method: "post",
                            data: $('#ws_open_form').serialize(),
                            success: function(data) {
                                if (data == '') {
                                    $('#ws_open_form')[0].reset();
                                    $('#ws_open_modal').modal('hide');
                                    location.reload();
                                } else {
                                    alert(data);
                                    location.reload();
                                }
                            }
                        });
                    });

                    // -- Listening event for form submit of ws_close_moal --
                    $("#ws_close_form").submit(function(event) {
                        /* stop form from submitting normally */
                        event.preventDefault();

                        console.log($(this).serialize());
                        $.ajax({
                            url: "change_ws_status_to_close.php",
                            method: "post",
                            data: $('#ws_close_form').serialize(),
                            success: function(data) {
                                if (data == '') {
                                    $('#ws_close_form')[0].reset();
                                    $('#ws_close_modal').modal('hide');
                                    location.reload();
                                } else {
                                    alert(data);
                                    location.reload();
                                }
                            }
                        });
                    });

                    // -- Listensing check box event --
                    $('#chkOption input[type="checkbox"]').click(function(){
                        if($(this).prop("checked") == true){
                            $('select#rxNo').prop('disabled', false);
                            $('#startDateBD').prop('disabled', false);
                            $('#startTimeBD').prop('disabled', false);
                            $('#pd_close_actual_qty').val(0);
                            $('#pd_close_actual_qty').prop('disabled', true);
                        }
                        else if($(this).prop("checked") == false){
                            $('select#rxNo')[0].selectedIndex = 0;
                            $('select#rxNo').prop('disabled', true);
                            $('#startDateBD').prop('disabled', true);
                            $('#startTimeBD').prop('disabled', true);
                            $('#pd_close_actual_qty').prop('disabled', false);
                        }
                    });
                });

                // --- Create Gantt Chart
                $(function() {
                    // document ready            
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

                    cCurTimeStart = cCurYear + "-" + cCurMonth + "-" + cCurDay + " " + cCurHour.toString() + ':' + cCurMin.toString();

                    $('#calendar').fullCalendar({
                        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                        themeSystem: 'jquery-ui',
                        nowIndicator: true,
                        locale: 'th',
                        lang: 'th',

                        //height: 700,
                        //now: cCurTimeStart,

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
                            right: 'timelineDay, timeline2Day,timeline3Day,timeline7Day',
                        },

                        buttonText: {
                            timelineDay: '1 Day | 10 min',
                            timeline2Day: '2 Day',
                            timeline3Day: '3 Day',
                            timeline7Day: '7 Day',
                            today: 'Today',
                        },

                        customButtons: {
                            myCustomButton: {
                                //text: 'custom button',
                                text: 'Refresh Page',
                                click: function() {
                                    //alert('You clicked the custom button!');
                                    window.location.reload();
                                },
                            }
                        },

                        /* ----------- */
                        /* -- VIEW --- */
                        /* ----------- */
                        defaultView: 'timelineDay',
                        views: {
                            timelineDay: {
                                slotWidth: 7,
                                slotDuration: '00:10'
                            },
                            timeline2Day: {
                                type: 'timeline',
                                duration: {
                                    days: 2
                                },
                                slotDuration: '03:00'
                            },
                            timeline3Day: {
                                type: 'timeline',
                                duration: {
                                    days: 3
                                },
                                slotDuration: '06:00'
                            },
                            timeline7Day: {
                                type: 'timeline',
                                duration: {
                                    days: 7
                                },
                                slotDuration: '06:00'
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

                        eventMouseover: function(event, jsEvent, view) {
                            switch (event.title.substring(0, 5)) {
                                case '1.(Pl':
                                    $(this).css('color', 'green');
                                    $(this).css('background', 'yellow');
                                    $(this).css('cursor', 'pointer');
                                    break;
                                case '1.(St':
                                    break;
                                case '1.(Fi':
                                    break;
                                case '2.(On':
                                    $(this).css('color', 'White');
                                    $(this).css('background', 'DarkGreen');
                                    $(this).css('cursor', 'pointer');
                                    break;
                                case '2.(Co':
                                    break;
                                case '3.(Bl':
                                    $(this).css('color', 'Lime');
                                    $(this).css('background', 'Darkgreen');
                                    $(this).css('cursor', 'pointer');
                                    break;
                                case 'WS---':
                                    $(this).css('color', 'white');
                                    $(this).css('background', 'DodgerBlue');
                                    $(this).css('cursor', 'pointer');
                                    break;
                                case 'W/S--':
                                    $(this).css('color', 'white');
                                    $(this).css('background', 'DarkGreen');
                                    $(this).css('cursor', 'pointer');
                                    break;
                                default:
                                    break;
                            }
                        },

                        eventMouseout: function(event, jsEvent, view) {
                            switch (event.title.substring(0, 5)) {
                                case '1.(Pl':
                                    $(this).css('color', 'black');
                                    $(this).css('background', 'lightyellow');
                                    break;
                                case '1.(St':
                                    break;
                                case '1.(Fi':
                                    break;
                                case '2.(On':
                                    $(this).css('color', 'Black');
                                    $(this).css('background', 'PaleGreen');
                                    break;
                                case '2.(Co':
                                    break;
                                case '3.(Bl':
                                    $(this).css('color', 'Darkgreen');
                                    $(this).css('background', 'Lime');
                                    break;
                                case 'WS---':
                                    $(this).css('color', 'Black');
                                    $(this).css('background', 'Azure');
                                    break;
                                case 'W/S--':
                                    $(this).css('color', 'Black');
                                    $(this).css('background', 'PaleGreen');
                                    break;
                                default:
                                    break;
                            }
                        },
                        
                        eventClick: function(event, jsEvent, view, resource) {
                            console.log(event);
                            console.log(jsEvent);
                            console.log(view);
                            console.log(event.id);

                            switch (event.title.substring(0, 5)) {
                                case '1.(Pl':
                                    console.log(event.id);
                                    $("#pd_open_order_no").val(event.id);
                                    $("#param_pd_open_order_no").val(event.id);

                                    var nFirstPosition = event.title.indexOf('---[') + 4;

                                    $("#pd_open_mat_name").val(event.title.substring(0, nFirstPosition - 4));

                                    $("#pd_open_mat_code").val(event.title.substring(nFirstPosition, nFirstPosition + 18));
                                    $("#param_pd_open_mat_code").val(event.title.substring(nFirstPosition, nFirstPosition + 18));

                                    var nLastPosition = event.title.indexOf(' ', nFirstPosition + 19);
                                    console.log(nFirstPosition + 19);
                                    console.log(nLastPosition);

                                    $('#pd_open_lot_no').val(event.title.substring(nFirstPosition + 19, nLastPosition));
                                    $('#param_pd_open_lot_no').val(event.title.substring(nFirstPosition + 19, nLastPosition));

                                    $('#pd_open_modal').modal('show');
                                    break;
                                case '1.(St':
                                    break;
                                case '1.(Fi':
                                    break;
                                case '2.(On':
                                    console.log(event.id);
                                    $("#pd_close_order_no").val(event.id);
                                    $("#param_pd_close_order_no").val(event.id);

                                    var nFirstPosition = event.title.indexOf('---[') + 4;

                                    $("#pd_close_mat_name").val(event.title.substring(12, nFirstPosition - 4));

                                    $("#pd_close_mat_code").val(event.title.substring(nFirstPosition, nFirstPosition + 18));
                                    $("#param_pd_close_mat_code").val(event.title.substring(nFirstPosition, nFirstPosition + 18));

                                    var nLastPosition = event.title.indexOf(' ', nFirstPosition + 19);
                                    console.log(nFirstPosition + 19);
                                    console.log(nLastPosition);

                                    $('#pd_close_lot_no').val(event.title.substring(nFirstPosition + 19, nLastPosition));
                                    $('#param_pd_close_lot_no').val(event.title.substring(nFirstPosition + 19, nLastPosition));

                                    $('#pd_close_plan_qty').val(parseInt(event.title.substring(nLastPosition + 1, event.title.length - 4)));
                                    $('#param_pd_close_plan_qty').val(parseInt(event.title.substring(nLastPosition + 1, event.title.length - 4)));

                                    $('#pd_close_actual_qty').val(0);
                                    console.log(parseInt(event.title.substring(nLastPosition + 1, event.title.length - 4)));

                                    $('#pd_close_modal').modal('show');
                                    break;
                                case '2.(Co':
                                    break;
                                case '3.(Bl':
                                    alert('Case 3.Blowdown');
                                    break;
                                case 'WS---':
                                    console.log(event.id);
                                    $("#ws_open_order_no").val(event.id);
                                    $("#param_ws_open_order_no").val(event.id);

                                    var nFirstPosition = event.title.indexOf('---[') + 4;

                                    $("#ws_open_mat_name").val(event.title.substring(0, nFirstPosition - 4));

                                    $("#ws_open_mat_code").val(event.title.substring(nFirstPosition, nFirstPosition + 18));
                                    $("#param_ws_open_mat_code").val(event.title.substring(nFirstPosition, nFirstPosition + 18));

                                    var nLastPosition = event.title.indexOf(' ', nFirstPosition + 19);
                                    console.log(nFirstPosition + 19);
                                    console.log(nLastPosition);

                                    $('#ws_open_lot_no').val(event.title.substring(nFirstPosition + 19, nLastPosition));
                                    $('#param_ws_open_lot_no').val(event.title.substring(nFirstPosition + 19, nLastPosition));

                                    $('#ws_open_modal').modal('show');
                                    break;
                                case 'W/S--':
                                    console.log(event.id);
                                    $("#ws_close_order_no").val(event.id);
                                    $("#param_ws_close_order_no").val(event.id);

                                    var nFirstPosition = event.title.indexOf('---[') + 4;

                                    $("#ws_close_mat_name").val(event.title.substring(0, nFirstPosition - 4));

                                    $("#ws_close_mat_code").val(event.title.substring(nFirstPosition, nFirstPosition + 18));
                                    $("#param_ws_close_mat_code").val(event.title.substring(nFirstPosition, nFirstPosition + 18));

                                    var nLastPosition = event.title.indexOf(' ', nFirstPosition + 19);
                                    console.log(nFirstPosition + 19);
                                    console.log(nLastPosition);

                                    $('#ws_close_lot_no').val(event.title.substring(nFirstPosition + 19, nLastPosition));
                                    $('#param_ws_close_lot_no').val(event.title.substring(nFirstPosition + 19, nLastPosition));

                                    $('#ws_close_modal').modal('show');
                                    break;
                                default:
                                    break;
                            }
                        },

                        /*-----------------------------------*/
                        /*-- control Grantt Chart By Mouse --*/
                        /*-----------------------------------*/
                        editable: false,
                        /*
                        eventDrop: function(event, delta, revertFunc) 
                        {
                            alert(event.title + " was dropped on " + event.start.format());
                            if (!confirm("Are you sure about this change?")) 
                            {
                                revertFunc();                                
                            }
                        }
                        */

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

            <!-- Modal pd_open_moal สำหรับการบันทึก รายละเอียด การเริ่มต้น การผลิต -->
            <div class="modal fade" id="pd_open_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style='background-color: Silver; color: Black;'>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Start Production:</h4>
                        </div>

                        <form class="form-horizontal" role="form" id='pd_open_form' method='post'>
                            <div class="modal-body" id="pd_open_detail">
                                <input type="hidden" name="mat_code" id="param_pd_open_mat_code">
                                <input type="hidden" name="lot_no" id="param_pd_open_lot_no">
                                <input type="hidden" name="order_no" id="param_pd_open_order_no">

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
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Order No.:</label>
                                        <input type="text" id="pd_open_order_no" class="form-control" disabled>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Lot No.:</label>
                                        <input type="text" id="pd_open_lot_no" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Actual Start Date:</label>
                                        <input type="date" name="actual_start_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Actual Start Time:</label>
                                        <input type="time" name="actual_start_time" class="form-control" value="<?php echo date('H:i'); ?>" required>
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

            <!-- Modal pd_close_moal สำหรับการบันทึก รายละเอียด การสิ้นสุด การผลิต-->
            <div class="modal fade" id="pd_close_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style='background-color: SeaGreen; color: Lime;'>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Finish Production:</h4>
                        </div>

                        <form class="form-horizontal" role="form" id='pd_close_form' method='post'>
                            <div class="modal-body">
                                <input type="hidden" name="order_no" id="param_pd_close_order_no">
                                <input type="hidden" name="mat_number" id="param_pd_close_mat_code">
                                <input type="hidden" name="lot_no" id="param_pd_close_lot_no">
                                <input type="hidden" name="order_qty" id="param_pd_close_plan_qty">

                                <!-- #1 Row -->
                                <div class="form-group">
                                    <div class="col-lg-2">
                                        <label style="display: block; text-align: center;">Order No.:</label>
                                        <input type="text" id="pd_close_order_no" class="form-control" disabled>
                                    </div>
                                    <div class="col-lg-3">
                                        <label style="display: block; text-align: center;">Material Code:</label>
                                        <input type="text" id="pd_close_mat_code" class="form-control" disabled>
                                    </div>
                                    <div class="col-lg-5">
                                        <label style="display: block; text-align: center;">Material Name:</label>
                                        <input type="text" id="pd_close_mat_name" class="form-control" disabled>
                                    </div>
                                    <div class="col-lg-2">
                                        <label style="display: block; text-align: center;">P-Qty:</label>
                                        <input type="number" id="pd_close_plan_qty" name="pd_close_plan_qty" class="form-control" disabled>
                                    </div>
                                </div>
                                <!-- #2 Row -->
                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <label style="display: block; text-align: center;">Lot No.:</label>
                                        <input type="text" id="pd_close_lot_no" class="form-control" disabled>
                                    </div>
                                    <div class="col-lg-2">
                                        <label style="display: block; text-align: center;">Status:</label>
                                        <input type="text" class='form-control' style='color: red; text-align: center;' value='C' disabled>
                                        <input type="hidden" name="pd_status" value='C'>
                                    </div>
                                    <div class="col-lg-3">
                                        <label style="display: block; text-align: center;">Act.Finish-Date:</label>
                                        <input type="date" name="actual_finish_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="col-lg-2">
                                        <label style="display: block; text-align: center;">Act.Finish-Time:</label>
                                        <input type="time" name="actual_finish_time" class="form-control" value="<?php echo date('H:i'); ?>" required>
                                    </div>
                                    <div class="col-lg-2">
                                        <label style="display: block; text-align: center;">Act-Qty:</label>
                                        <input type="number" id="pd_close_actual_qty" name="pd_close_actual_qty" class="form-control">
                                    </div>
                                </div>
                                <!-- #3 Row -->
                                <div class="form-group">
                                    <div class="col-lg-2">
                                        <label style="display: block; ">P-T Delay:</label>
                                        <select name="why_process_delay" class="form-control">
                                            <option value="not delay">Not delay</option>
                                            <option value="man">Man</option>
                                            <option value="machine">Machine</option>
                                            <option value="process">Process</option>
                                            <option value="unknow">Unknow</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; ">Please specific more detail:</label>
                                        <input type="text" name="process_delay_remark" class="form-control">
                                    </div>
                                    <div class="col-lg-2">
                                        <label style="display: block; ">S-T Delay:</label>
                                        <select name="why_start_delay" class="form-control">
                                            <option value="not delay">Not delay</option>
                                            <option value="man">Man</option>
                                            <option value="machine">Machine</option>
                                            <option value="process">Process</option>
                                            <option value="unknow">Unknow</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; ">Please specific more detail:</label>
                                        <input type="text" name="start_delay_remark" class="form-control">
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <!-- #4 Row Blowdown -->
                                <div class="form-group">
                                    <div class="col-lg-2">
                                    </div>
                                    <div class="col-lg-3">
                                        <label style="display: block; text-align: left;">Option:</label>
                                        <label class="checkbox-inline" id='chkOption'><input type="checkbox" value="">Blowdown</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <label style="display: block; text-align: center;">Rx No.:</label>
                                        <!--<label>RX-No.</label>-->
                                        <select id='rxNo' name="rxNo" class="form-control">
                                        <option value=''></option>

                                            <?php
                                            $keyWord = ['IRS', 'IRW', 'UU']; // the word you wanna to find
                                            $nElement = 1;
                                            $cStrValue = '';

                                            foreach ($keyWord as $key) {
                                                echo $nElement;
                                                if (strpos($user_sbu, $key) > 0) {
                                                    switch ($key) {
                                                        case 'IRS':
                                                            break;
                                                        case 'IRW':
                                                            $cStrValue .= "<option value='FA-9014'>FA-9014</option>";
                                                            $cStrValue .= "<option value='FA-9024'>FA-9024</option>";
                                                            $cStrValue .= "<option value='FA-9034'>FA-9034</option>";
                                                            $cStrValue .= "<option value='FA-9044'>FA-9044</option>";
                                                            $cStrValue .= "<option value='FA-9054'>FA-9054</option>";
                                                            $cStrValue .= "<option value='FA-9064'>FA-9064</option>";
                                                            $cStrValue .= "<option value='FA-9074'>FA-9074</option>";
                                                            break;
                                                        case 'UU':
                                                            break;
                                                    }
                                                    $nElement += 1;
                                                }
                                            }
                                            echo $cStrValue;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label style="display: block; text-align: center;">Start-Date BD.:</label>
                                        <input type="date" id='startDateBD' name='startDateBD' class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <div class="col-lg-2">
                                        <label style="display: block; text-align: center;">Start-Time BD.:</label>
                                        <input type="time" id='startTimeBD' name='startTimeBD' class="form-control" value="<?php echo date('H:i'); ?>">
                                    </div>
                                </div>
                            </div>                            
                            <!-- #8 Row ปุ่ม update / Cancel -->
                            <div class="modal-footer">
                                <button type="submit" id='insert' class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-close btn-danger" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal ws_open_moal -->
            <div class="modal fade" id="ws_open_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style='background-color: Silver; color: Black;'>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Start Washing Time:</h4>
                        </div>

                        <form class="form-horizontal" role="form" id='ws_open_form' method='post'>
                            <div class="modal-body" id="ws_open_detail">
                                <input type="hidden" name="mat_code" id="param_ws_open_mat_code">
                                <input type="hidden" name="lot_no" id="param_ws_open_lot_no">
                                <input type="hidden" name="order_no" id="param_ws_open_order_no">

                                <div class="form-group">
                                    <div class="col-lg-7">
                                        <label style="display: block; text-align: center;">Material Name:</label>
                                        <input type="text" id="ws_open_mat_name" class="form-control" disabled>
                                    </div>
                                    <div class="col-lg-5">
                                        <label style="display: block; text-align: center;">Material Code:</label>
                                        <input type="text" id="ws_open_mat_code" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Order No.:</label>
                                        <input type="text" id="ws_open_order_no" class="form-control" disabled>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Lot No.:</label>
                                        <input type="text" id="ws_open_lot_no" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Actual Start Date:</label>
                                        <input type="date" name="actual_start_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Actual Start Time:</label>
                                        <input type="time" name="actual_start_time" class="form-control" value="<?php echo date('H:i'); ?>" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">WS Status:</label>
                                        <input type="text" class='form-control' style='color: red; text-align: center;' value='O' disabled>
                                        <input type="hidden" name="pd_status" value='O'>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" id='ws-open' class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-close btn-danger" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal ws_close_moal -->
            <div class="modal fade" id="ws_close_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style='background-color: Silver; color: Black;'>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Finish Washing Time:</h4>
                        </div>

                        <form class="form-horizontal" role="form" id='ws_close_form' method='post'>
                            <div class="modal-body" id="ws_close_detail">
                                <input type="hidden" name="mat_code" id="param_ws_close_mat_code">
                                <input type="hidden" name="lot_no" id="param_ws_close_lot_no">
                                <input type="hidden" name="order_no" id="param_ws_close_order_no">

                                <div class="form-group">
                                    <div class="col-lg-7">
                                        <label style="display: block; text-align: center;">Material Name:</label>
                                        <input type="text" id="ws_close_mat_name" class="form-control" disabled>
                                    </div>
                                    <div class="col-lg-5">
                                        <label style="display: block; text-align: center;">Material Code:</label>
                                        <input type="text" id="ws_close_mat_code" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Order No.:</label>
                                        <input type="text" id="ws_close_order_no" class="form-control" disabled>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Lot No.:</label>
                                        <input type="text" id="ws_close_lot_no" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Actual Finish Date:</label>
                                        <input type="date" name="actual_finish_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">Actual Finish Time:</label>
                                        <input type="time" name="actual_finish_time" class="form-control" value="<?php echo date('H:i'); ?>" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label style="display: block; text-align: center;">WS Status:</label>
                                        <input type="text" class='form-control' style='color: red; text-align: center;' value='C' disabled>
                                        <input type="hidden" name="pd_status" value='C'>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" id='ws-close' class="btn btn-success">Update</button>
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