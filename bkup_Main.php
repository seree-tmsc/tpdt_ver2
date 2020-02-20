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
        <title>TMSC TPDT System V.2</title>
        <link rel="icon" type="image/png" href="images/tmsc-logo-64x32.png">

        <style>
            /*
            .table-hover tbody tr:hover td,
            .table-hover tbody tr:hover th {
                background-color: mediumseagreen;
                color: white;
                font-weight: bold;
            }            
            tbody tr td,
            tbody tr th {
                background-color: darkgreen;
                color: white;
            }
            thead tr th {
                background-color: springgreen;
                color: darkgreen;
                font-weight: bold;
            }
            */
        </style>

        <?php
        require_once("include/library.php");
        /* --------------------- */
        /* Setp 0. Call Function */
        /* --------------------- */
        include_once "function_Graph.php";
        ?>
    </head>

    <!--<body style='background-color:black;'>-->

    <body>
        <!-- Begin Body page -->
        <div class="container">
            <br>
            <!-- Begin Static navbar -->
            <?php require_once("include/menu_navbar.php"); ?>
            <!-- End Static navbar -->

            <!-- row #1 -->
            <div class="row">
                <!------------------------------------------------>
                <!-- Production Planning Upload History [COOIS] -->
                <!-- Show COOIS ---------------------------------->
                <!------------------------------------------------>
                <div class="col-lg-8">
                    <div class="col-lg-12 panel panel-default">
                        <div class="panel-header" style="text-align:center;">
                            <h3><span>Production Planning Upload History [COOIS]</span></h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class='table-responsive'>
                            <table class='table table-bordered table-hover' id='myTable' style='width:100%;'>
                                <thead>
                                    <tr class='success'>
                                        <th class='text-center'>SBU</th>
                                        <th class='text-center'>Uploaded Date</th>
                                        <th class='text-center'>Uploaded By</th>
                                        <th class='text-center'>Basic Start Date</th>
                                        <th class='text-center'># Trans.</th>
                                        <th class='text-center'>Mode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    /*------------------------------*/
                                    /*--- Query Transaction Data ---*/
                                    /*------------------------------*/
                                    include_once('include/db_Conn.php');
                                    $strSql = "SELECT DISTINCT TOP 30 upload_date, upload_by, basic_start_date, count(pd_ord_no) as 'qty' ";
                                    $strSql .= "FROM trans_history_Upload_coois T ";
                                    $strSql .= "JOIN tpdt_mas_pd_data M ON M.pd_code = T.material_code ";

                                    $keyWord = ['IRS', 'IRW', 'UU']; // the word you wanna to find
                                    $nElement = 1;
                                    foreach ($keyWord as $key) {
                                        if (strpos($user_sbu, $key) > 0) {
                                            if ($nElement == 1) {
                                                $strSql .= "WHERE (M.pd_sbu ='" . $key . "') ";
                                            } else {
                                                $strSql .= "OR (M.pd_sbu ='" . $key . "') ";
                                            }
                                            $nElement += 1;
                                        }
                                    }

                                    $strSql .= "GROUP BY upload_date, upload_by, basic_start_date ";
                                    $strSql .= "ORDER BY upload_date DESC, upload_by, basic_start_date DESC ";
                                    //echo $strSql . "<br>";

                                    $statement = $conn->prepare($strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                    $statement->execute();
                                    //$result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    $nRecCount = $statement->rowCount();

                                    if ($nRecCount > 0) {
                                        while ($ds = $statement->fetch(PDO::FETCH_NAMED)) {
                                    ?>
                                            <tr>
                                                <td class='text-center'><?php echo $user_sbu; ?></td>
                                                <td class='text-center'><?php echo date("d/M/Y", strtotime($ds['upload_date'])); ?></td>
                                                <td><?php echo $ds['upload_by']; ?></td>
                                                <td class='text-center'><?php echo date("d/M/Y", strtotime($ds['basic_start_date'])); ?></td>
                                                <td class='text-center'><?php echo $ds['qty']; ?></td>
                                                <td class='text-center'>
                                                    <a href="COOIS_List.php?mode=1&sbu=<?php echo $user_sbu; ?>&basic_start_date=<?php echo $ds['basic_start_date']; ?>">
                                                        <span class='fa fa-list fa-lg'></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td class='text-center'>No data</td>
                                            <td class='text-center'>-</td>
                                            <td class='text-center'>-</td>
                                            <td class='text-center'>-</td>
                                            <td class='text-center'>-</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!--------------------------------->
                <!-- Production Planning Release -->
                <!-- Show Remaining COOIS --------->
                <!--------------------------------->
                <div class="col-lg-4">
                    <div class="col-lg-12 panel panel-default">
                        <div class="panel-header" style="text-align:center;">
                            <h3><span>Production Planning Release</span></h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class='table-responsive'>
                            <table class='table table-bordered table-hover' id='myTable2' style='width:100%;' align="center">
                                <thead>
                                    <tr class='success'>
                                        <th class='text-center'>B.Start Date</th>
                                        <th class='text-center'>#R.Trans.</th>
                                        <th class='text-center'>Mode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    /*------------------------------*/
                                    /*--- Query Transaction Data ---*/
                                    /*------------------------------*/
                                    include_once('include/db_Conn.php');
                                    $strSql = "SELECT TOP 20 [Basic start date], count(*) as 'qty' ";
                                    $strSql .= "FROM tpdt_trn_coois T ";
                                    $strSql .= "JOIN tpdt_mas_pd_data M ON M.pd_code = T.[Material Number] ";
                                    $strSql .= "WHERE [Delete flag] = 'N' ";

                                    $keyWord = ['IRS', 'IRW', 'UU']; // the word you wanna to find
                                    $nElement = 1;
                                    foreach ($keyWord as $key) {
                                        if (strpos($user_sbu, $key) > 0) 
                                        {
                                            if ($nElement == 1) 
                                            {
                                                $strSql .= "AND ((M.pd_sbu ='" . $key . "') ";
                                            } 
                                            else 
                                            {
                                                $strSql .= "OR (M.pd_sbu ='" . $key . "') ";
                                            }
                                            $nElement += 1;
                                        }
                                    }
                                    $strSql .= ") ";

                                    $strSql .= "GROUP BY [Basic start date] ";
                                    $strSql .= "ORDER BY [Basic start date] DESC";
                                    //echo $strSql . "<br>";

                                    $statement = $conn->prepare($strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                    $statement->execute();
                                    //$result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    $nRecCount = $statement->rowCount();

                                    if ($nRecCount > 0) 
                                    {
                                        while ($ds = $statement->fetch(PDO::FETCH_NAMED)) {
                                    ?>
                                            <tr>
                                                <td class='text-center'><?php echo date("d/M/Y", strtotime($ds['Basic start date'])); ?></td>
                                                <td class='text-center'><?php echo $ds['qty']; ?></td>
                                                <td class='text-center'>
                                                    <!--<a href="pCOOIS_List.php?basic_start_date=<?php //echo $ds['Basic start date'];
                                                                                                    ?>" target='_blank'>-->
                                                    <a href="COOIS_List.php?mode=2&sbu=<?php echo $user_sbu; ?>&basic_start_date=<?php echo $ds['Basic start date']; ?>">
                                                        <span class='fa fa-list fa-lg'></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } 
                                    else 
                                    {
                                        ?>
                                        <tr>
                                            <td class='text-center'>No data</td>
                                            <td class='text-center'></td>
                                            <td class='text-center'></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- row #2 Graph comparison -->
            <div class="row">
                <div class="col-lg-7">
                    <!------------------------>
                    <!-- BAR CHART BY MONTH -->
                    <!------------------------>
                    <!--<div class="panel panel-yellow">-->
                    <div class="col-lg-12 panel panel-default">
                        <div class="panel-header" style="text-align:center;">
                            <h3><span>Comparison Production Quantity By Month [Planning /Actual]</span></h3>
                            <div class="clearfix"></div>
                        </div>

                        <div class="panel-body">
                            <?php
                            $aData1 = get_Data_From_Pd_Ord_By_Month($user_sbu);
                            /*
                            echo json_encode($aData1[0]) . "<br>";
                            echo json_encode($aData1[1]) . "<br>";                                        
                            echo json_encode($aData1['labels']) . "<br>";
                            echo json_encode($aData1['data1s']) . "<br>";
                            echo json_encode($aData1['data2s']) . "<br>";
                            */
                            ?>
                            <canvas id="barChart1" height="150px"></canvas>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>

                <div class="col-lg-5">
                    <!----------------->
                    <!-- DONUT CHART -->
                    <!----------------->
                    <!--<div class="panel panel-orange">-->
                    <div class="col-lg-12 panel panel-default">
                        <div class="panel-header" style="text-align:center;">
                            <h3><span>Act.Production QTY By PD.Grp [<?php echo date('M/Y'); ?>]</span></h3>
                            <div class="clearfix"></div>
                        </div>

                        <div class="panel-body">
                            <?php
                            $aData2 = get_Data_From_Pd_Ord_By_Grp($user_sbu);
                            //echo json_encode($aData2[0]) . "<br>";
                            //echo json_encode($aData2[1]) . "<br>";
                            //cho json_encode($aData['labels']) . "<br>";
                            //echo json_encode($aData['datas']) . "<br>";
                            ?>
                            <canvas id="barChart2" height="222px"></canvas>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>

            <!-- row #3 Graph Top 20 -->
            <div class="row">
                <div class="col-lg-12">
                    <!-------------------------->
                    <!-- BAR CHART BY PRODUCT -->
                    <!-------------------------->
                    <div class="col-lg-12 panel panel-default">
                        <div class="panel-header" style="text-align:center;">
                            <h3><span>Top 20 Actual Production Quantity By Product [<?php echo date('Y'); ?>]</span></h3>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="panel-body">
                            <?php
                            $aData3 = get_Data_From_Pd_Ord_Top_20($user_sbu);
                            //echo json_encode($aData3[0]) . "<br>";
                            //echo json_encode($aData3[1]) . "<br>";
                            //cho json_encode($aData3['labels']) . "<br>";
                            //echo json_encode($aData3['datas']) . "<br>";
                            ?>
                            <canvas id="barChart3" height="120px"></canvas>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>

            <!-- row #4 Graph Capccity by Rx -->
            <div class="row">
                <div class="col-lg-12">
                    <!-------------------------->
                    <!-- BAR CHART BY PRODUCT -->
                    <!-------------------------->
                    <br>
                    <div class="col-lg-12 panel panel-default">                        
                        <div class="panel-header" style="text-align:center;">
                            <h3><span>Actual Production Capacity By Reactor [<?php echo date('Y'); ?>]</span></h3>
                            <div class="clearfix"></div>
                        </div>


                        <div class="panel-body">
                            <?php
                            $aData5 = get_Data_From_Pd_Ord_By_Rx($user_sbu);
                            //echo json_encode($aData3[0]) . "<br>";
                            //echo json_encode($aData3[1]) . "<br>";
                            //cho json_encode($aData3['labels']) . "<br>";
                            //echo json_encode($aData3['datas']) . "<br>";
                            ?>
                            <canvas id="barChart5" height="120px"></canvas>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- End content page -->
        </div>
        <!-- End Body page -->

        <!-- Logout Modal-->
        <?php require_once("include/modal_logout.php"); ?>

        <!-- Change Password Modal-->
        <?php require_once("include/modal_chgpassword.php"); ?>

        <script>
            //--------------------------
            // javascript for side-menu
            //--------------------------
            $(document).ready(function() {
                $('#myTable').dataTable({
                    searching: false,
                    bSort : false,
                    order: [ [ 1, 'desc' ], [ 3, 'desc' ] ]
                });

                $('#myTable2').dataTable({
                    searching: false,
                    bSort : false,
                    order: [ 0, 'desc' ],
                    "bInfo": false,
                });
            });

            var ctx = document.getElementById("barChart1");
            var barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($aData1['labels']); ?>,
                    datasets: [{
                            label: 'Qty [Tons]',
                            data: <?php echo json_encode($aData1['data1s'], JSON_NUMERIC_CHECK); ?>,
                            backgroundColor: 'rgba(99, 132, 0, 0.6)',
                            borderColor: 'darkgreen',
                            borderWidth: 1,
                        },
                        {
                            label: 'Act-Qty [Tons]',
                            data: <?php echo json_encode($aData1['data2s'], JSON_NUMERIC_CHECK); ?>,
                            backgroundColor: 'lightgreen',
                            borderColor: 'green',
                            borderWidth: 1,
                        }
                    ],
                },
                options: {
                    legend: {
                        display: false
                    },

                    scales: {
                        xAxes: [{
                            categoryPercentage: 0.9,
                            barPercentage: 1.0
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },

                    /*
                    title: {
                        display: true,
                        text: 'Monthly PO by Basic Start Date',
                    },                            
                    legend: {
                        display: true,
                        labels: {
                            fontColor: 'black'                                    
                        },
                        position: 'right',
                    },
                    */
                    //events: ['click']
                }
            });

            var ctx = document.getElementById("barChart2");
            var barChart = new Chart(ctx, {
                type: 'doughnut',
                //type: 'pie',
                data: {
                    labels: <?php echo json_encode($aData2['labels']); ?>,
                    datasets: [{
                        label: 'Qty [Tons]',
                        data: <?php echo json_encode($aData2['datas'], JSON_NUMERIC_CHECK); ?>,
                        backgroundColor: ["indigo", "cornflowerblue", "blue", "green", "yellow", "orange", "red", "maroon", "magenta", "pink", "plum",
                            "peru", "peachpuff", "papayawhip", "palegreen", "sandybrown", "slategray"
                        ],
                        //borderColor: ["#3cba9f","#c45850","#3e95cd"],
                        borderColor: "black",
                        borderWidth: 0.5
                    }]
                },
                options: {
                    title: {
                        display: false,
                        //text: 'Yearly Production Order By Prodcut Group',
                    },
                    legend: {
                        display: true,
                        labels: {
                            fontColor: 'black'
                        },
                        position: 'right',
                    },
                    //events: ['click']
                }
            });

            var ctx = document.getElementById("barChart3");
            var barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($aData3['labels']); ?>,
                    datasets: [{
                        label: 'Qty [Tons]',
                        data: <?php echo json_encode($aData3['datas'], JSON_NUMERIC_CHECK); ?>,
                        backgroundColor: [
                            'rgb(255, 159, 64, 0.2)',
                            'rgb(255, 159, 64, 0.2)',
                            'rgb(255, 159, 64, 0.2)',
                            'rgb(255, 159, 64, 0.2)',
                            'rgb(255, 159, 64, 0.2)',
                            'rgb(255, 159, 64, 0.2)',
                            'rgb(255, 159, 64, 0.2)',
                            'rgb(255, 159, 64, 0.2)',
                            'rgb(255, 159, 64, 0.2)',
                            'rgb(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 0, 0, 1)',
                            'rgb(255, 0, 0, 1)',
                            'rgb(255, 0, 0, 1)',
                            'rgb(255, 0, 0, 1)',
                            'rgb(255, 0, 0, 1)',
                            'rgb(255, 0, 0, 1)',
                            'rgb(255, 0, 0, 1)',
                            'rgb(255, 0, 0, 1)',
                            'rgb(255, 0, 0, 1)',
                            'rgb(255, 0, 0, 1)',
                            'black',
                            'black',
                            'black',
                            'black',
                            'black',
                            'black',
                            'black',
                            'black',
                            'black',
                            'black'
                        ],
                        borderWidth: 0.5
                    }]
                },

                options: {
                    scales: {
                        xAxes: [{
                            ticks: {
                                autoSkip: false,
                                fontColor: 'blue'
                                /*
                                callback: function(value, index, values) {
                                    return new moment(value).format('DD MMM');
                                }
                                */
                            },
                            gridLines: {
                                display: true,
                                //drawBorder: false,
                                //zeroLineColor: 'rgba(255, 255, 0, 1)',
                                //color: 'red',
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                /*
                                beginAtZero:true,
                                min: 50,
                                max: 190,
                                stepSize: 10
                                */
                                fontColor: 'blue'
                            }
                        }],
                    },
                    title: {
                        display: false,
                        //text: 'Top 20 Quantity Production Weekly Report',
                    },
                }
            });

            var ctx = document.getElementById("barChart5");
            var barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($aData5['labels']); ?>,
                    datasets: [{
                        label: 'Qty [Tons]',
                        data: <?php echo json_encode($aData5['datas'], JSON_NUMERIC_CHECK); ?>,
                        backgroundColor: 'rgb(0, 191, 255, 0.2)',
                        borderColor: 'rgb(0, 0, 255, 1)',
                        borderWidth: 0.5,                        
                    }]
                },

                options: {
                    scales: {
                        xAxes: [{
                            ticks: {
                                autoSkip: false,
                                fontColor: 'blue'
                                /*
                                callback: function(value, index, values) {
                                    return new moment(value).format('DD MMM');
                                }
                                */
                            },
                            gridLines: {
                                display: true,
                                //drawBorder: false,
                                //zeroLineColor: 'rgba(255, 255, 0, 1)',
                                //color: 'red',
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                /*
                                beginAtZero:true,
                                min: 50,
                                max: 190,
                                stepSize: 10
                                */
                                fontColor: 'blue'
                            }
                        }],
                    },
                    title: {
                        display: false,
                        text: 'Actual Production Capacity By Reactor',
                    },
                    responsive:true,
                    chartArea: {
                        backgroundColor: 'red',
                    }
                }
            });
        </script>
    </body>

    </html>
<?php
}
?>