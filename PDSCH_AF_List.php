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
    if ($user_user_type == "A" || $user_user_type == "P") 
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
                                        <th class='text-center' style='width:8%;'>A.Start Date</th>
                                        <th class='text-center' style='width:5%;'>A.Start Time</th>
                                        <th class='text-center' style='width:8%;'>A.Finish Date</th>
                                        <th class='text-center' style='width:5%;'>A.Finish Time</th>
                                        <th class='text-center' style='width:23%;'>Material Name</th>
                                        <th class='text-center' style='width:16%;'>Material Code</th>
                                        <th class='text-center' style='width:8%;'>Lot No.</th>
                                        <th class='text-center' style='width:8%;'>Bacth Size</th>
                                        <th class='text-center' style='width:8%;'>Act.Qty</th>
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
                                    $strSql .= "WHERE [Pd status] = 'C' ";
                                    $strSql .= "AND [Actual finish date] = '" . $_POST['param_dDate'] . "' ";

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

                                    $strSql .= "ORDER BY [Order] ";
                                    //echo $strSql . "<br>";

                                    $statement = $conn->prepare($strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                    $statement->execute();
                                    $nRecCount = $statement->rowCount();

                                    if ($nRecCount > 0) {
                                        while ($ds = $statement->fetch(PDO::FETCH_NAMED)) {
                                    ?>
                                            <tr>
                                                <td class='text-center'><?php echo date("d/M/Y", strtotime($ds['Actual start date'])); ?></td>
                                                <td class='text-center'><?php echo date("H:i", strtotime($ds['Actual start time'])); ?></td>

                                                <td class='text-center'><?php echo date("d/M/Y", strtotime($ds['Actual finish date'])); ?></td>
                                                <td class='text-center'><?php echo date("H:i", strtotime($ds['Actual finish time'])); ?></td>

                                                <td><?php echo $ds['Material description']; ?></td>
                                                <td><?php echo $ds['Material Number']; ?></td>
                                                <td class='text-center'><?php echo $ds['Batch']; ?></td>
                                                <td class='text-right'><?php echo number_format($ds['Order quantity'], 2, '.', ','); ?></td>
                                                <td class='text-right text-danger'><?php echo number_format($ds['Actual quantity'], 2, '.', ','); ?></td>
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
                                            <td class='text-center'>No data</td>
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
                                        <select id='rxNo' name="rxNo" class="form-control" disabled>
                                            <option value="DC-211">DC-211</option>
                                            <option value="DC-311">DC-311</option>
                                            <option value="DC-411">DC-411</option>
                                            <option value="DC-441">DC-441</option>
                                            <option value="DC-611">DC-611</option>
                                            <option value="DC-622">DC-622</option>
                                            <option value="-">-</option>
                                            <option value="DC-9011">DC-9011</option>
                                            <option value="DC-9021">DC-9021</option>
                                            <option value="DC-9031">DC-9031</option>
                                            <option value="DC-9041">DC-9041</option>
                                            <option value="DC-9051">DC-9051</option>
                                            <option value="DC-9061">DC-9061</option>
                                            <option value="DC-9071">DC-9071</option>
                                            <option value="DC-9081">DC-9081</option>
                                            <option value="DC-9091">DC-9091</option>
                                            <option value="FA-9014">FA-9014</option>
                                            <option value="FA-9024">FA-9024</option>
                                            <option value="FA-9034">FA-9034</option>
                                            <option value="FA-9044">FA-9044</option>
                                            <option value="FA-9054">FA-9054</option>
                                            <option value="FA-9064">FA-9064</option>
                                            <option value="FA-9074">FA-9074</option>
                                            <option value="-">-</option>
                                            <option value="DC-101">DC-101</option>
                                            <option value="DC-111">DC-111</option>
                                            <option value="DC-121">DC-121</option>
                                            <option value="DC-122">DC-122</option>
                                            <option value="DC-124">DC-124</option>
                                            <option value="DC-141">DC-141</option>
                                            <option value="DC-151">DC-151</option>
                                            <option value="DC-161">DC-161</option>
                                            <option value="DC-181">DC-181</option>
                                            <option value="DC-191">DC-191</option>
                                            <option value="FA-191">FA-191</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-2">
                                        <label>PD-LT</label>
                                        <input type="number" id="pdLeadTime" class='form-control' disabled>
                                    </div>

                                    <div class="col-lg-4">
                                    </div>

                                    <div class="col-lg-4">
                                        <label>Actual Start Date</label>
                                        <input type="date" id="actualStartDate" class='form-control' disabled>
                                    </div>

                                    <div class="col-lg-4">
                                        <label>Actual Start Time</label>
                                        <input type="time" id="actualStartTime" class='form-control' disabled>
                                    </div>

                                    <div class="col-lg-4">
                                    </div>

                                    <div class="col-lg-4">
                                        <label>Actual Finish Date</label>
                                        <input type="date" id="actualFinishDate" class='form-control' disabled>
                                    </div>

                                    <div class="col-lg-4">
                                        <label>Actual Finish Time</label>
                                        <input type="time" id="actualFinishTime" class='form-control' disabled>
                                    </div>

                                    <div class="col-lg-8">
                                    </div>

                                    <div class="col-lg-4">
                                        <label>Batch Size</label>
                                        <input type="number" id="actualBatchSize" name="actualBatchSize" class='form-control' disabled>
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
                                        <label>Revise - Actual Finish Date</label>
                                        <input type="date" id="revactualFinishDate" name="revactualFinishDate" class='form-control' required>
                                    </div>

                                    <div class="col-lg-4 text-danger">
                                        <label>Revise - Actual Finish Time</label>
                                        <input type="time" id="revactualFinishTime" name="revactualFinishTime" class='form-control' required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-8">
                                    </div>

                                    <div class="col-lg-4 text-danger">
                                        <label>Actual Quantity</label>
                                        <input type="number" id="actualQuantity" name="actualQuantity" class='form-control' required>
                                    </div>
                                </div>

                                <!--Submit btn -->
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
                            url: "pPDSCH_AF_Insert.php",
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
                        //alert('You are clicking Edit COOIS Data !');                            

                        var pd_ord_no = $(this).attr("order");
                        $.ajax({
                            url: "PDSCH_B_Fetch.php",
                            method: "post",
                            data: {
                                pd_ord_no: pd_ord_no
                            },
                            dataType: "json",
                            success: function(data) {
                                console.log(data['Material Number']);
                                console.log(data['Material description']);
                                console.log(data['Production Version']);
                                console.log(data['Order quantity']);
                                console.log(data['pd_lead_time']);

                                $('#matCode').val(data['Material Number']);
                                $('#matName').val(data['Material description']);
                                $('#pdOrdNo').val(data['Order']);
                                $('#editpdOrdNo').val(data['Order']);
                                $('#lotNo').val(data['Batch']);
                                $('#rxNo').val(data['RX No']);
                                $('#pdLeadTime').val(data['pd_lead_time']);

                                $('#actualStartDate').val(data['Actual start date']);
                                $('#actualStartTime').val( data['Actual start time'].replace(".0000000", "") );

                                $('#actualFinishDate').val(data['Actual finish date']);
                                $('#actualFinishTime').val( data['Actual finish time'].replace(".0000000", "") );

                                $('#revactualFinishDate').val(data['Actual finish date']);
                                $('#revactualFinishTime').val( data['Actual finish time'].replace(".0000000", "") );

                                $('#actualBatchSize').val(data['Order quantity']);
                                $('#actualQuantity').val(data['Actual quantity']);

                                $('#edit_pdsch_modal').modal('show');
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