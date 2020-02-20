<?php
try {
    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM tpdt_mas_pd_data ";
    $strSql .= "ORDER BY pd_name ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare($strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $statement->execute();
    $nRecCount = $statement->rowCount();
    if ($nRecCount > 0) 
    {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover' id='myTable'>";
        echo "<thead>";

        echo "<tr class='success'>";
        //echo "<th style='width:5%;' class='text-center'>No.</th>";            
        echo "<th style='width:20%;' class='text-center'>Material Code</th>";
        echo "<th style='width:40%;' class='text-center'>Material Description</th>";
        echo "<th style='width:10%;' class='text-center'>SBU</th>";
        echo "<th style='width:10%;' class='text-center'>Group</th>";
        echo "<th style='width:10%;' class='text-center'>PD-LT</th>";
        echo "<th style='width:10%;' class='text-center'>Mode</th>";
        echo "</tr>";

        echo "</thead>";
        echo "<tbody>";

        $nI = 1;

        ob_start();

        while ($ds = $statement->fetch(PDO::FETCH_NAMED)) {
            echo "<tr>";
            //echo "<td class='text-right'>" . $nI . "</td>";                
            echo "<td>" . $ds['pd_code'] . "</td>";
            echo "<td>" . $ds['pd_name'] . "</td>";
            echo "<td>" . $ds['pd_sbu'] . "</td>";
            echo "<td>" . $ds['pd_group'] . "</td>";
            echo "<td class='text-center'>" . $ds['pd_lead_time'] . "</td>";

            echo "<td class='text-center'>";
            /*
                echo "<a href='#' class='view_data' pd_code='" . $ds['pd_code'] . "' >";
                echo "<span class='fa fa-sticky-note-o fa-lg'>" . "&nbsp&nbsp" . "</span>";
                echo "</a>";
                */
            echo "<a href='#' class='edit_data' pd_code='" . $ds['pd_code'] . "'>";
            echo "<span class='fa fa-pencil-square-o fa-lg'>" . "&nbsp&nbsp" . "</span>";
            echo "</a>";
            echo "<a href='#' class='delete_data' pd_code='" . $ds['pd_code'] . "'>";
            echo "<span class='fa fa-trash-o fa-lg'></span>";
            echo "</a>";
            echo "</td>";
            echo "</tr>";

            $nI++;
        }
        ob_end_flush();

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } 
    else 
    {
        echo "Data not found ...!";
        //echo "<script> alert('Warning! No Data ! ... ); window.location.href='pMain.php'; </script>";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
