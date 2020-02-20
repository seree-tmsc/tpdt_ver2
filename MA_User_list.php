<?php
try {
    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM TPDT_MAS_Users_ID ";
    $strSql .= "ORDER BY user_type, emp_code ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare($strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $statement->execute();
    $nRecCount = $statement->rowCount();
    if ($nRecCount > 0) 
    {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover' id='myTable'>";
        //echo "<thead style='background-color:green; color:lime'>";
        echo "<thead>";

        echo "<tr class='success'>";
        echo "<th style='width:10%;' class='text-center'>Code</th>";
        echo "<th style='width:15%;'>First Name</th>";
        echo "<th style='width:25%;'>Last Name</th>";
        echo "<th style='width:20%;'>e-Mail</th>";
        echo "<th style='width:5%;' class='text-center'>Type</th>";
        echo "<th style='width:15%;' class='text-center'>Created Date</th>";
        echo "<th style='width:10%;' class='text-center'>Mode</th>";
        echo "</tr>";

        echo "</thead>";
        echo "<tbody>";

        $nI = 1;

        ob_start();

        while ($ds = $statement->fetch(PDO::FETCH_NAMED)) {
            $strSql = "SELECT * ";
            $strSql .= "FROM Emp_Main ";
            $strSql .= "WHERE emp_code ='" . $ds['emp_code'] . "' ";
            //echo $strSql . "<br>";

            $statement2 = $conn2->prepare($strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement2->execute();
            $nRecCount2 = $statement2->rowCount();

            echo "<tr>";
            echo "<td class='text-center'>" . $ds['emp_code'] . "</td>";

            if ($nRecCount2 == 1) 
            {
                $ds2 = $statement2->fetch(PDO::FETCH_NAMED);
                echo "<td>" . $ds2['emp_tfname'] . "</td>";
                echo "<td>" . $ds2['emp_tlname'] . "</td>";
            } 
            else 
            {
                echo "<td>-</td>";
                echo "<td>-</td>";
            }
            echo "<td>" . $ds['user_email'] . "</td>";
            echo "<td class='text-center'>" . $ds['user_type'] . "</td>";
            echo "<td class='text-center'>" . $ds['user_create_date'] . "</td>";
            echo "<td class='text-center'>";
            echo "<a href='#' class='view_data' emp_code='" . $ds['emp_code'] . "'>";
            echo "<span class='fa fa-sticky-note-o fa-lg'>" . "&nbsp&nbsp" . "</span>";
            echo "</a>";
            echo "<a href='#' class='edit_data' emp_code='" . $ds['emp_code'] . "'>";
            echo "<span class='fa fa-pencil-square-o fa-lg'>" . "&nbsp&nbsp" . "</span>";
            echo "</a>";
            echo "<a href='#' class='delete_data' emp_code='" . $ds['emp_code'] . "'>";
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
        echo "<script> alert('Warning! No Data ! ... ); window.location.href='pMain.php'; </script>";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
