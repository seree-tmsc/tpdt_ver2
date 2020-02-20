<?php
    try
    {        
        include('include/db_Conn.php');

        $strSql = "SELECT * ";
        $strSql .= "FROM tpdt_trn_coois ";        
        $strSql .= "ORDER BY `Order` ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        if ($nRecCount >0)
        {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-hover' id='myTable'>";        
            echo "<thead style='background-color:CornflowerBlue;'>";
            echo "<tr>";
            echo "<th style='width:4%;' class='text-center'>No.</th>";
            echo "<th style='width:6%;' class='text-center'>Order</th>";
            echo "<th style='width:18%;' class='text-center'>Material COde</th>";
            echo "<th style='width:25%;' class='text-center'>Material Description</th>";
            echo "<th style='width:8%;' class='text-center'>Lot No.</th>";
            echo "<th style='width:8%;' class='text-center'>Batch Size</th>";
            echo "<th style='width:8%;' class='text-center'>BS-Date</th>";
            echo "<th style='width:6%;' class='text-center'>BS-Time</th>";
            echo "<th style='width:7%;' class='text-center'>RX No.</th>";
            echo "<th style='width:10%;' class='text-center'>Mode</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            $nI =1;

            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {                
                echo "<tr>";
                echo "<td class='text-right'>" . $nI . "</td>";
                echo "<td>" . $ds['Order'] . "</td>";
                echo "<td>" . $ds['Material Number'] . "</td>";
                echo "<td>" . $ds['Material description'] . "</td>";
                echo "<td class='text-center'>" . $ds['Batch'] . "</td>";
                echo "<td class='text-right'>" . number_format($ds['Order quantity'], 0, '.', ',') . "</td>";
                echo "<td class='text-center'>" . Date('d/M/y',strtotime($ds['Basic start date'])) . "</td>";
                echo "<td class='text-center'>" . Date('H:i',strtotime($ds['Basic start time'])) . "</td>";
                echo "<td class='text-center'>" . $ds['RX No'] . "</td>";

                echo "<td class='text-center'>";
                echo "<a href='#' class='view_data' order='" . $ds['Order'] . "' >";
                echo "<span class='fa fa-sticky-note-o fa-lg'>" . "&nbsp&nbsp" . "</span>";
                echo "</a>";
                echo "<a href='#' class='edit_data' order='" . $ds['Order'] . "'>";
                echo "<span class='fa fa-pencil-square-o fa-lg'>" . "&nbsp&nbsp" . "</span>";
                echo "</a>";
                echo "<a href='#' class='delete_data' order='" . $ds['Order'] . "'>";
                echo "<span class='fa fa-trash-o fa-lg'></span>";
                echo "</a>";                            
                echo "</td>";
                echo "</tr>"; 

                $nI++;
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }
        else
        {
            echo "Data not found ...!";
            //echo "<script> alert('Warning! No Data ! ... ); window.location.href='pMain.php'; </script>";
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
?>    