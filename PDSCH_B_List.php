<?php
//echo $_POST['param_dDate'];

include_once('include/chk_Session.php');
if ($user_email == "") {
    echo "<script> 
                alert('Warning! Please Login!'); 
                window.location.href='login.php'; 
            </script>";
} else {
    if ($user_user_type == "A" || $user_user_type == "P") {
?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>TMSC TPDT System V.1.0</title>
            <link rel="icon" type="image/png" href="images/tmsc-logo-64x32.png">

            <?php
            require_once("include/library.php");
            ?>
        </head>

        <!--<body style='background-color:black;'>-->

        <body>
            <!-- Begin Body page -->
            <div class="container">
                <br>
                <!-- Begin Static navbar -->
                <?php require_once("include/submenu_navbar.php"); ?>
                <!-- End Static navbar -->

                <!-- Begin content page-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class='table-responsive'>
                            <table class='table table-bordered table-hover' id='myTable' style='width:100%;' align="center">
                                <thead>
                                    <tr class='success'>
                                        <th class='text-center' style='width:8%;'>B.Start Date</th>
                                        <th class='text-center' style='width:5%;'>B.Start Time</th>
                                        <th class='text-center' style='width:8%;'>B.Finish Date</th>
                                        <th class='text-center' style='width:5%;'>B.Finish Time</th>
                                        <th class='text-center' style='width:23%;'>Material Name</th>
                                        <th class='text-center' style='width:16%;'>Material Code</th>
                                        <th class='text-center' style='width:8%;'>Lot No.</th>
                                        <th class='text-center' style='width:8%;'>Bacth Size</th>
                                        <th class='text-center' style='width:8%;'>RX No.</th>
                                        <th class='text-center' style='width:6%;'>Order</th>
                                        <th class='text-center' style='width:5%;'>Mode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    /*---------------------------------------*/
                                    /*--- Query Prodcuttion schedule data ---*/
                                    /*---------------------------------------*/
                                    include_once('include/db_Conn.php');

                                    $strSql = "SELECT * ";
                                    $strSql .= "FROM tpdt_trn_pd_sch T ";
                                    $strSql .= "JOIN tpdt_mas_pd_data M ON M.pd_code = T.[Material Number] ";
                                    $strSql .= "WHERE [Pd status] = ' ' ";
                                    $strSql .= "AND [Basic start date] = '" . $_POST['param_dDate'] . "' ";

                                    $keyWord = ['IRS', 'IRW', 'UU']; // the word you wanna to find
                                    $nElement = 1;
                                    foreach ($keyWord as $key) {
                                        if (strpos($user_sbu, $key) > 0) {
                                            if ($nElement == 1) {
                                                $strSql .= "AND ((M.pd_sbu ='" . $key . "') ";
                                            } else {
                                                $strSql .= "OR (M.pd_sbu ='" . $key . "') ";
                                            }
                                            $nElement += 1;
                                        }
                                    }
                                    $strSql .= ") ";

                                    //$strSql .= "ORDER BY `Order` ";
                                    $strSql .= "ORDER BY [Basic start date], [Material description], Batch ";
                                    //echo $strSql . "<br>";

                                    $statement = $conn->prepare($strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                    $statement->execute();
                                    $nRecCount = $statement->rowCount();

                                    if ($nRecCount > 0) {
                                        while ($ds = $statement->fetch(PDO::FETCH_NAMED)) {
                                    ?>
                                            <tr>
                                                <td class='text-center'><?php echo date("d/M/Y", strtotime($ds['Basic start date'])); ?></td>
                                                <td class='text-center'><?php echo date("H:i", strtotime($ds['Basic start time'])); ?></td>

                                                <td class='text-center'><?php echo date("d/M/Y", strtotime($ds['Basic finish date'])); ?></td>
                                                <td class='text-center'><?php echo date("H:i", strtotime($ds['Basic finish time'])); ?></td>

                                                <td><?php echo $ds['Material description']; ?></td>
                                                <td><?php echo $ds['Material Number']; ?></td>
                                                <td class='text-center'><?php echo $ds['Batch']; ?></td>

                                                <td class='text-right'><?php echo number_format($ds['Order quantity'], 2, '.', ','); ?></td>
                                                <td class='text-center'><?php echo $ds['RX No']; ?></td>

                                                <td><?php echo $ds['Order']; ?></td>

                                                <td class='text-center'>
                                                    <a href="#" class="edit_pdsch_data" order="<?php echo $ds['Order']; ?>">
                                                        <span class='fa fa-pencil-square-o fa-lg'></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <!--<td class='text-center'>No data</td>-->
                                            <h3>No Data !</h3>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End content page -->
            </div>
            <!-- End Body page -->


            <!--------------------------------------------->
            <!-- Insert / Edit Production schedule Modal -->
            <!--------------------------------------------->
            <div class="modal fade" id="edit_pdsch_modal" tabindex="-1" role="dialog">
                <!--<div class="modal-dialog modal-lg" role="document">-->
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Edit Production Schedule Data :</h4>
                        </div>

                        <div class="modal-body" id="detail">
                            <form method='post' id='insert-pdsch-form'>
                                <!--
                                    <input type="hidden" id="editpdOrdNo" name="editpdOrdNo">
                                    <input type="hidden" id="editpdVersion" name="editpdVersion">
                                    <input type="hidden" id="editbatchSize" name="editbatchSize">
                                    <input type="hidden" id="editmrpController" name="editmrpController">
                                    -->

                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>Material Code</label>
                                        <input type="text" id="matCode" class='form-control' disabled>

                                    </div>

                                    <div class="col-lg-8">
                                        <label>Material Name</label>
                                        <input type="text" id="matName" class='form-control' disabled>

                                    </div>

                                    <div class="col-lg-4">
                                        <label>Order No.</label>
                                        <input type="text" id="pdOrdNo" class='form-control' disabled>
                                        <input type="hidden" id="editpdOrdNo" name="editpdOrdNo">
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Lot No.</label>
                                        <input type="text" id="lotNo" class='form-control' disabled>

                                    </div>

                                    <div class="col-lg-3">
                                        <label>RX-No.</label>
                                        <select id='rxNo' name="rxNo" class="form-control" required>

                                            <?php
                                            $keyWord = ['IRS', 'IRW', 'UU']; // the word you wanna to find
                                            $nElement = 1;
                                            $cStrValue = '';

                                            foreach ($keyWord as $key) {
                                                echo $nElement;
                                                if (strpos($user_sbu, $key) > 0) {
                                                    switch ($key) {
                                                        case 'IRS':
                                                            $cStrValue .= "<option value='DC-211'>DC-211</option>";
                                                            $cStrValue .= "<option value='DC-311'>DC-311</option>";
                                                            $cStrValue .= "<option value='DC-411'>DC-411</option>";
                                                            $cStrValue .= "<option value='DC-441'>DC-441</option>";
                                                            $cStrValue .= "<option value='DC-611'>DC-611</option>";
                                                            $cStrValue .= "<option value='DC-622'>DC-622</option>";
                                                            break;
                                                        case 'IRW':
                                                            $cStrValue .= "<option value='DC-9011'>DC-9011</option>";
                                                            $cStrValue .= "<option value='DC-9021'>DC-9021</option>";
                                                            $cStrValue .= "<option value='DC-9031'>DC-9031</option>";
                                                            $cStrValue .= "<option value='DC-9041'>DC-9041</option>";
                                                            $cStrValue .= "<option value='DC-9051'>DC-9051</option>";
                                                            $cStrValue .= "<option value='DC-9061'>DC-9061</option>";
                                                            $cStrValue .= "<option value='DC-9071'>DC-9071</option>";
                                                            $cStrValue .= "<option value='DC-9081'>DC-9081</option>";
                                                            $cStrValue .= "<option value='DC-9091'>DC-9091</option>";
                                                            $cStrValue .= "<option value='FA-9014'>FA-9014</option>";
                                                            $cStrValue .= "<option value='FA-9024'>FA-9024</option>";
                                                            $cStrValue .= "<option value='FA-9034'>FA-9034</option>";
                                                            $cStrValue .= "<option value='FA-9044'>FA-9044</option>";
                                                            $cStrValue .= "<option value='FA-9054'>FA-9054</option>";
                                                            $cStrValue .= "<option value='FA-9064'>FA-9064</option>";
                                                            $cStrValue .= "<option value='FA-9074'>FA-9074</option>";
                                                            break;
                                                        case 'UU':
                                                            $cStrValue .= "<option value='DC-101'>DC-101</option>";
                                                            $cStrValue .= "<option value='DC-111'>DC-111</option>";
                                                            $cStrValue .= "<option value='DC-121'>DC-121</option>";
                                                            $cStrValue .= "<option value='DC-122'>DC-122</option>";
                                                            $cStrValue .= "<option value='DC-124'>DC-124</option>";
                                                            $cStrValue .= "<option value='DC-141'>DC-141</option>";
                                                            $cStrValue .= "<option value='DC-151'>DC-151</option>";
                                                            $cStrValue .= "<option value='DC-161'>DC-161</option>";
                                                            $cStrValue .= "<option value='DC-181'>DC-181</option>";
                                                            $cStrValue .= "<option value='DC-191'>DC-191</option>";
                                                            $cStrValue .= "<option value='FA-191'>FA-191</option>";
                                                            break;
                                                    }
                                                    $nElement += 1;
                                                }
                                            }
                                            echo $cStrValue;
                                            ?>

                                        </select>
                                    </div>

                                    <div class="col-lg-2">
                                        <label>PD-LT</label>
                                        <input type="number" id="pdLeadTime" class='form-control' disabled>

                                    </div>

                                    <div class="col-lg-4">
                                    </div>

                                    <div class="col-lg-4">
                                        <label>Basic Start Date</label>
                                        <input type="date" id="basicStartDate" class='form-control' disabled>

                                    </div>

                                    <div class="col-lg-4">
                                        <label>Basic Start Time</label>
                                        <input type="time" id="basicStartTime" class='form-control' disabled>
                                    </div>

                                    <div class="col-lg-4">
                                    </div>

                                    <div class="col-lg-4">
                                        <label>Basic Finish Date</label>
                                        <input type="date" id="basicFinishDate" class='form-control' disabled>

                                    </div>

                                    <div class="col-lg-4">
                                        <label>Basic Finsh Time</label>
                                        <input type="time" id="basicFinishTime" class='form-control' disabled>

                                    </div>
                                </div>

                                <!----------------------------------------------------------->
                                <!-- area for revise basic start date and basic start time -->
                                <!----------------------------------------------------------->
                                <div class="row">
                                    <br><br>

                                    <div class="col-lg-4">
                                    </div>

                                    <div class="col-lg-4 text-danger">
                                        <label>Revise - Basic Start Date</label>
                                        <input type="date" id="revbasicStartDate" name="revbasicStartDate" class='form-control' requite>
                                    </div>

                                    <div class="col-lg-4 text-danger">
                                        <label>Revise - Basic Start Time</label>
                                        <input type="time" id="revbasicStartTime" name="revbasicStartTime" class='form-control' required>
                                    </div>

                                    <div class="col-lg-4">
                                    </div>

                                    <div class="col-lg-4 text-danger">
                                        <label>Revise - Basic Finish Date</label>
                                        <input type="date" id="revbasicFinishDate" class='form-control' disabled>
                                        <input type="hidden" id="editrevbasicFinishDate" name="editrevbasicFinishDate">
                                    </div>

                                    <div class="col-lg-4 text-danger">
                                        <label>Revise - Basic Finish Time</label>
                                        <input type="time" id="revbasicFinishTime" class='form-control' disabled>
                                        <input type="hidden" id="editrevbasicFinishTime" name="editrevbasicFinishTime">
                                    </div>
                                </div>

                                <div class="row">
                                    <br>
                                    <div class="col-lg-10">
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="submit" id='insert' class='btn btn-success'>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!--
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btnClose" data-dismiss="modal">Close</button>
                            </div>
                            -->
                    </div>
                </div>
            </div>


            <script type="text/javascript">
                $(document).ready(function() {
                    /*
                    $('.btnClose').click(function(){
                        //alert('.btn-clode');
                        $('#insert-form')[0].reset();
                    })
                    */

                    /* attach a submit handler to the form */
                    $("#insert-pdsch-form").submit(function(event) {
                        //alert("You are submitting insert form");

                        /* stop form from submitting normally */
                        event.preventDefault();

                        console.log($(this).serialize());

                        $.ajax({
                            url: "PDSCH_B_Insert.php",
                            method: "post",
                            data: $('#insert-pdsch-form').serialize(),

                            beforeSend: function() {
                                $('#insert').val('Insert...')
                            },

                            success: function(data) {
                                if (data == '') {
                                    $('#insert-pdsch-form')[0].reset();
                                    $('#iedit_pdsch_modal').modal('hide');
                                    location.reload();
                                } else {
                                    alert(data);
                                    location.reload();
                                }
                            }
                        });

                    });

                    $('.edit_pdsch_data').click(function() {
                        alert('You are clicking Edit COOIS Data !');

                        var pd_ord_no = $(this).attr("order");
                        $.ajax({
                            url: "PDSCH_B_Fetch.php",
                            method: "post",
                            data: {
                                pd_ord_no: pd_ord_no
                            },
                            dataType: "json",
                            success: function(data) {
                                //console.log(data['Material Number']);
                                //console.log(data['Material description']);
                                //console.log(data['Production Version']);
                                //console.log(data['Order quantity']);
                                //console.log(data['pd_lead_time']);
                                console.log(data['Basic start date']);
                                console.log(data['Basic start time'].replace(".0000000", ""));
                                console.log(data['Basic finish date']);
                                console.log(data['Basic finish time'].replace(".0000000", ""));

                                $('#matCode').val(data['Material Number']);
                                $('#matName').val(data['Material description']);
                                $('#pdOrdNo').val(data['Order']);
                                $('#editpdOrdNo').val(data['Order']);
                                $('#lotNo').val(data['Batch']);
                                $('#rxNo').val(data['RX No']);
                                $('#pdLeadTime').val(data['pd_lead_time']);

                                $('#basicStartDate').val(data['Basic start date']);
                                $('#basicStartTime').val( data['Basic start time'].replace(".0000000", "") );
                                $('#basicFinishDate').val(data['Basic finish date']);
                                $('#basicFinishTime').val( data['Basic finish time'].replace(".0000000", "") );

                                $('#revbasicStartDate').val(data['Basic start date']);
                                $('#revbasicStartTime').val( data['Basic start time'].replace(".0000000", "") );

                                $('#edit_pdsch_modal').modal('show');
                            }
                        });
                    });

                    $('.view_data').click(function() {
                        /*
                        var code = $(this).attr("emp_code");
                        $.ajax({
                            url: "pMA_User_view.php",
                            method: "post",
                            data: {id: code},
                            success: function(data){
                                $('#detail').html(data);
                                $('#view_modal').modal('show');
                            }
                        });
                        */
                    });

                    $('.delete_data').click(function() {
                        /*
                        var code = $(this).attr("emp_code");            
                        var lConfirm = confirm("Do you want to delete this record?");
                        if (lConfirm)
                        {                
                            $.ajax({
                                url: "pMA_User_delete.php",
                                method: "post",
                                data: {id: code},
                                success: function(data){
                                    location.reload();
                                }
                            });  
                        }
                        */
                    });

                    /*------------------------------------------------------------ */
                    /*-- calculate basic finish start date and basic finish time --*/
                    /*------------------------------------------------------------ */
                    //$("#revbasicStartTime").keyup(function()
                    $("#revbasicStartTime").change(function() {
                        var startTime = new Date($('#revbasicStartDate').val() + 'T' + $('#revbasicStartTime').val());
                        //alert(startTime);
                        var pdlt = parseFloat($('#pdLeadTime').val())
                        //alert(pdlt);
                        startTime.setHours(startTime.getHours() + pdlt);
                        //alert(startTime);
                        Y = startTime.getFullYear();
                        //alert(Y);
                        M = startTime.getMonth() + 1;
                        M = ("0" + M).slice(-2);
                        //alert(M);
                        D = startTime.getDate();
                        D = ("0" + D).slice(-2);
                        //alert(D);
                        var stopDate = Y + '-' + M + '-' + D;

                        Hr = startTime.getHours();
                        Hr = ("0" + Hr).slice(-2);
                        //alert(Hr);
                        Min = startTime.getMinutes();
                        Min = ("0" + Min).slice(-2);
                        //alert(Min);
                        var stopTime = Hr + ':' + Min;

                        $("#revbasicFinishDate").attr('value', stopDate);
                        $("#revbasicFinishTime").attr('value', stopTime);

                        $("#editrevbasicFinishDate").attr('value', stopDate);
                        $("#editrevbasicFinishTime").attr('value', stopTime);
                    });
                });
            </script>

        </body>

        </html>
<?php
    } else {
        echo "<script> alert('You are not authorization for this menu ... Please contact your administrator!'); window.location.href='pMain.php'; </script>";
    }
}
?>