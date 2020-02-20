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
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TMSC Traking Production Time System v.0.1</title>

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
            <!------------------>
            <!-- Graph for IR -->
            <!------------------>
            <div class="row">
                <!----------------------------------->
                <!-- show status of remainin COOIS -->
                <!----------------------------------->
                <div class="col-lg-12">
                    <div class='table-responsive'>
                        <table class='table table-bordered table-hover' id='myTable' style='width:100%;' align="center">
                            <thead>
                                <tr class='success'>
                                    <th class='text-center'>No.</th>
                                    <th class='text-center'>Order</th>
                                    <th class='text-center'>Material Code</th>
                                    <th class='text-center'>Material Name</th>
                                    <th class='text-center'>Lot No.</th>
                                    <th class='text-center'>Bacth Size</th>
                                    <?php
                                    if ($_GET['mode'] == 2) 
                                    {
                                        echo "<th class='text-center'>B.S.Date</th>";
                                        echo "<th class='text-center'>B.S.Time</th>";
                                        //echo "<th class='text-center'>RX No.</th>";
                                        echo "<th class='text-center'>Pd-Group</th>";
                                        echo "<th class='text-center'>Mode</th>";
                                        //echo "<th class='text-center'>Delete</th>";
                                    } 
                                    else 
                                    {
                                        echo "<th class='text-center'>SBU</th>";
                                        echo "<th class='text-center'>Pd-Group</th>";
                                        echo "<th class='text-center'>PD-LT</th>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                /*-------------------*/
                                /*--- Query COOIS ---*/
                                /*-------------------*/
                                include_once('include/db_Conn.php');
                                //echo $_GET['basic_start_date'] . "<br>";

                                $strSql = "SELECT * ";
                                $strSql .= "FROM tpdt_trn_coois T ";
                                $strSql .= "JOIN tpdt_mas_pd_data M ON M.pd_code = T.[Material Number] ";
                                switch ($_GET['mode']) {
                                        /*--- Show all coois data for specific date ---*/
                                    case 1:
                                        $strSql .= "WHERE [Basic start date] = '" . $_GET['basic_start_date'] . "' ";
                                        break;
                                        /*--- Show only remaining coois data for specific date ---*/
                                    case 2:
                                        $strSql .= "WHERE [Delete flag] = 'N' ";
                                        $strSql .= "AND [Basic start date] = '" . $_GET['basic_start_date'] . "' ";
                                        break;
                                }

                                $keyWord = ['IRS', 'IRW', 'UU']; // the word you wanna to find
                                $nElement = 1;
                                foreach ($keyWord as $key) {
                                    if (strpos($user_sbu, $key) > 0) {
                                        if ($nElement == 1) {
                                            $strSql .= "AND ((pd_sbu ='" . $key . "') ";
                                        } else {
                                            $strSql .= "OR (pd_sbu ='" . $key . "') ";
                                        }
                                        $nElement += 1;
                                    }
                                }

                                $strSql .= ") ";
                                //$strSql .= "ORDER BY `Order` ";
                                $strSql .= "ORDER BY pd_sbu, pd_group, [Material description], Batch ";
                                //echo $strSql . "<br>";

                                $statement = $conn->prepare($strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                $statement->execute();
                                //$result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                $nRecCount = $statement->rowCount();

                                if ($nRecCount > 0) {
                                    $nRow = 0;
                                    while ($ds = $statement->fetch(PDO::FETCH_NAMED)) {
                                ?>
                                        <tr>
                                            <td class='text-right'><?php echo $nRow += 1; ?></td>
                                            <td><?php echo $ds['Order']; ?></td>
                                            <td><?php echo $ds['Material Number']; ?></td>
                                            <td><?php echo $ds['Material description']; ?></td>
                                            <td class='text-center'><?php echo $ds['Batch']; ?></td>
                                            <td class='text-right'><?php echo number_format($ds['Order quantity'], 2, '.', ','); ?></td>

                                            <?php
                                            /*-- mode = 2 is for modify data --*/
                                            if ($_GET['mode'] == 2) 
                                            {                                                
                                                echo "<td class='text-center'>" . date("d/M/Y", strtotime($ds['Basic start date'])) . "</td>";
                                                echo "<td class='text-center'>" . date("H:i", strtotime($ds['Basic start time'])) . "</td>";
                                                //echo "<td class='text-center'>" . $ds['RX No'] . "</td>";
                                                 echo "<td>" . $ds['pd_group'] . "</td>";
                                                echo "<td class='text-center'>";
                                                // echo "<a href='#' class='edit_coois_data' order= " . $ds['Order'] . ">";
                                                // echo "<span class='fa fa-pencil-square-o fa-lg'>" . "&nbsp&nbsp" . "</span>";
                                                // echo "</a>";
                                                // echo "<a href='#' class='delete_coois_data' order= " . $ds['Order'] . ">";
                                                // echo "<span class='fa fa-trash-o fa-lg'></span>";
                                                // echo "</a>";
                                                echo "</td>";
                                                /*
                                                if($nRow == 1)
                                                {
                                                    echo "<td class='text-center'>";
                                                    echo "<a href='#' class='deleteByDate_coois_data' bStartDate= " . $ds['Basic start date'] . ">";
                                                    echo "<span class='fa fa-trash fa-lg'></span>";                                                                        
                                                    echo "</a>";
                                                    echo "</td>";
                                                }
                                                else
                                                {
                                                    echo "<td class='text-center'>";
                                                    echo "</td>";
                                                }
                                                */
                                            } 
                                            else 
                                            {
                                                echo "<td class='text-center'>" . $ds['pd_sbu'] . "</td>";
                                                echo "<td>" . $ds['pd_group'] . "</td>";
                                                echo "<td class='text-center'>" . $ds['pd_lead_time'] . "</td>";
                                            }
                                            ?>
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

        <!------------------------------>
        <!-- Release COOIS Data Modal -->
        <!------------------------------>
        <div class="modal fade" id="update_coois_modal" tabindex="-1" role="dialog">
            <!--<div class="modal-dialog modal-lg" role="document">-->
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Release COOIS Data :</h4>
                    </div>

                    <form class="form-horizontal" role="form" id='update-coois-form' method='post'>
                        <div class="modal-body" id="detail">
                            
                            <input type="hidden" id="pdVersion" name="pdVersion">
                            <input type="hidden" id="mrpController" name="mrpController">

                            <div class="form-group">
                                <div class="col-lg-2">
                                    <label>order</label>
                                    <input type="text" id="pdOrdNo" class='form-control' disabled>
                                    <input type="hidden" id="editpdOrdNo" name="editpdOrdNo">
                                </div>
                                <div class="col-lg-3">
                                    <label>Material Code</label>
                                    <input type="text" id="matCode" class='form-control' disabled>
                                    <input type="hidden" id="editmatCode" name="editmatCode">
                                </div>
                                <div class="col-lg-5">
                                    <label>Material Name</label>
                                    <input type="text" id="matName" class='form-control' disabled>
                                    <input type="hidden" id="editmatName" name="editmatName">
                                </div>
                                <div class="col-lg-2">
                                    <label>Lot No.</label>
                                    <input type="text" id="lotNo" class='form-control' disabled>
                                    <input type="hidden" id="editlotNo" name="editlotNo">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-2">
                                    <label>PD-LT</label>
                                    <input type="number" id="pdLeadTime" class='form-control' style="text-align: right;" disabled>
                                    <input type="hidden" id="editpdLeadTime" name="editpdLeadTime">
                                </div>

                                <div class="col-lg-3">
                                    <label>Basic Start Date</label>
                                    <input type="date" id="basicStartDate" name="basicStartDate" class='form-control'>
                                    <!--<input type="hidden" id="editbasicStartDate" name="editbasicStartDate">-->
                                </div>

                                <div class="col-lg-2">
                                    <label>Basic Start Time</label>
                                    <input type="time" id="basicStartTime" name="basicStartTime" class='form-control'>
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
                                    <label>Order Quantity</label>
                                    <input type="number" id="orderQuantity" class='form-control' style="text-align: right;" disabled>
                                    <input type="hidden" id="editorderQuantity" name="editorderQuantity">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <div class="col-lg-2">
                                    <label style="display: block; text-align: left;">Option1:</label>
                                    <label class="checkbox-inline" id='chkOption1'><input type="checkbox" value="">Blowdown</label>
                                </div>
                                <div class="col-lg-3">
                                    <label>Basic Finish Date</label>
                                    <input type="date" id="basicFinishDate" class='form-control' value="<?php echo date('Y-m-d'); ?>" disabled>
                                    <input type="hidden" id="editbasicFinishDate" name="editbasicFinishDate">
                                </div>

                                <div class="col-lg-2">
                                    <label>Basic Finsh Time</label>
                                    <input type="time" id="basicFinishTime" class='form-control' value="<?php echo date('H:i'); ?>" disabled>
                                    <input type="hidden" id="editbasicFinishTime" name="editbasicFinishTime">
                                </div>

                                <div class="col-lg-3">
                                    <label>BD.Finish Date</label>
                                    <input type="date" id="blowdownFinishDate" class='form-control' value="<?php echo date('Y-m-d');?>" disabled>
                                    <input type="hidden" id="editblowdownFinishDate" name="editblowdownFinishDate">
                                </div>

                                <div class="col-lg-2">
                                    <label>BD.Finish Time</label>
                                    <input type="time" id="blowdownFinishDate" class='form-control' value="<?php echo date('H:i'); ?>" disabled>
                                    <input type="hidden" id="editblowdownFinishTime" name="editblowdownFinishTime">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <div class="col-lg-2">
                                        <label style="display: block; text-align: left;">Option2:</label>
                                        <label class="checkbox-inline" id='chkOption2'><input type="checkbox" value="">Washing</label>
                                    </div>
                                <div class="col-lg-3">
                                    <label>WS Start Date</label>
                                    <input type="date" id="wsStartDate" name="wsStartDate" class='form-control' value="<?php echo date('Y-m-d'); ?>" disabled>
                                    <input type="hidden" id="editwsStartDate" name="editwsStartDate">
                                </div>

                                <div class="col-lg-2">
                                    <label>WS Start Time</label>
                                    <input type="time" id="wsStartTime" name="wsStartTime" class='form-control' value="<?php echo date('H:i'); ?>" disabled>
                                    <input type="hidden" id="editwsStartTime" name="editwsStartTime">
                                </div>

                                <div class="col-lg-3">
                                    <label>WS Finish Date</label>
                                    <input type="date" id="wsFinishDate" name="wsFinishDate" class='form-control' value="<?php echo date('Y-m-d');?>" disabled>
                                </div>

                                <div class="col-lg-2">
                                    <label>WS Finish Time</label>
                                    <input type="time" id="wsFinishTime" name="wsFinishTime" class='form-control' value="<?php echo date('H:i'); ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">                            
                            <button type="submit" id='update' class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-close btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!---------------->
        <!-- javaScript -->
        <!---------------->
        <script type="text/javascript">
            $(document).ready(function() {
                // -- creat button in last column
                var mode = <?php echo $_GET['mode']; ?>;
                if(mode == 1)
                {
                    var table1 = $('#myTable').DataTable({
                                    "searching": false,
                                    });
                }
                else
                {
                    var table1 = $('#myTable').DataTable({
                                    "searching": false,
                                    "columnDefs": [ {"targets": -1, 
                                                    "data": null, 
                                                    "defaultContent": 
                                                    "<button id='btnR'><span class='fa fa-pencil-square-o fa-lg'></span></button>&nbsp&nbsp&nbsp<button id='btnD'><span class='fa fa-trash-o fa-lg'></span></button>"} ]
                                    });
                }

                // -- listening on Click event of button in last column
                $('#myTable tbody').on('click', 'button', function () {                    
                    var data = table1.row( $(this).parents('tr') ).data();
                    //alert( "ID = " + data[0] +" / Material = "+ data[3] );

                    if($(this)[0].id  == 'btnR')
                    {
                        alert('RELEASE');

                        //var pd_ord_no = $(this).attr("order");
                        $.ajax({
                            url: "COOIS_Fetch.php",
                            method: "post",
                            data: {
                                pd_ord_no: data[1]
                            },
                            dataType: "json",
                            success: function(result) {
                                $('#pdVersion').val(result['Production Version']);
                                $('#mrpController').val(result['MRP controller']);

                                $('#matCode').val(result['Material Number']);
                                $('#editmatCode').val(result['Material Number']);

                                $('#matName').val(result['Material description']);
                                $('#editmatName').val(result['Material description']);

                                $('#pdOrdNo').val(result['Order']);
                                $('#editpdOrdNo').val(result['Order']);

                                $('#lotNo').val(result['Batch']);
                                $('#editlotNo').val(result['Batch']);

                                $('#rxNo').val(result['RX No']);

                                $('#pdLeadTime').val(result['pd_lead_time']);
                                $('#editpdLeadTime').val(result['pd_lead_time']);

                                $('#basicStartDate').val(result['Basic start date']);
                                $('#basicStartTime').val(result['Basic start time']);

                                $('#orderQuantity').val(result['Order quantity']);
                                $('#editorderQuantity').val(result['Order quantity']);

                                $('#update_coois_modal').modal('show');
                            },
                        })
                    }
                    else
                    {
                        //var pd_ord_no = $(this).attr("order");
                        var lConfirm = confirm("Do you want to delete this record?");
                        if (lConfirm) {
                            $.ajax({
                                url: "COOIS_Delete.php",
                                method: "post",
                                data: {
                                    pd_ord_no: data[1]
                                },
                                success: function(result) {
                                    location.reload();
                                }
                            });
                        }
                    }
                } );

                $('.btnClose').click(function() {
                    alert('.btn-clode');
                    $('#insert-form')[0].reset();
                });

                // -- Submit From  in Update-Coois-Modal
                $("#update-coois-form").submit(function(event) {
                    /* stop form from submitting normally */
                    event.preventDefault();

                    console.log($(this).serialize());

                    $.ajax({
                        url: "COOIS_Update.php",
                        method: "post",
                        data: $('#update-coois-form').serialize(),

                        beforeSend: function() {
                            $('#update').val('Updating...')
                        },

                        success: function(result) {
                            if (result == '') {
                                $('#update-coois-form')[0].reset();
                                $('#update_coois_modal').modal('hide');
                                location.reload();
                            } else {
                                alert(result);
                                location.reload();
                            }
                        }
                    });
                });


                $('.view_data').click(function() {
                    alert('You are running .view_data');
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

                $('.deleteByDate_coois_data').click(function() {
                    alert('You are running .deleteBuDate_coois_data');

                    var bStartDate = $(this).attr("bStartDate");
                    var lConfirm = confirm("Do you want to delete all record?");
                    if (lConfirm) {
                        $.ajax({
                            url: "pCOOIS_DeleteByDate.php",
                            method: "post",
                            data: {
                                bStartDate: bStartDate
                            },
                            success: function(data) {
                                location.reload();
                            }
                        });
                    }

                });

                /*------------------------------------------------------------ */
                /*-- calculate basic finish start date and basic finish time --*/
                /*------------------------------------------------------------ */
                //$("#basicStartTime").keyup(function()
                $("#basicStartTime").change(function() {
                    //alert('You are running #basicStartTime');

                    var startTime = new Date($('#basicStartDate').val() + 'T' + $('#basicStartTime').val());
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

                    $("#basicFinishDate").attr('value', stopDate);
                    $("#editbasicFinishDate").attr('value', stopDate);
                    $("#wsStartDate").attr('value', stopDate);
                    $("#editwsStartDate").attr('value', stopDate);
                    $("#wsFinishDate").attr('value', stopDate);

                    $("#basicFinishTime").attr('value', stopTime);
                    $("#editbasicFinishTime").attr('value', stopTime);
                    $("#wsStartTime").attr('value', stopTime);
                    $("#editwsStartTime").attr('value', stopTime);
                    $("#wsFinishTime").attr('value', stopTime);
                });
            });
        </script>

    </body>

    </html>
<?php
}
?>