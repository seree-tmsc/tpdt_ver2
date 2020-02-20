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
        <div class="container">
            <br>

            <?php require_once("include/menu_navbar.php"); ?>

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
        </div>

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
        </script>
    </body>

    </html>
<?php
}
?>