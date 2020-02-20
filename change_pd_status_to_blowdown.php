<?php
    echo $_POST['rxNo'] . "<br>";
    echo $_POST['startDateBD'] . "<br>";
    echo $_POST['startTimeBD'] . "<br>";
    echo $_POST["order_qty"] . "<br>";

    try
    {
        include('include/db_Conn.php');

        // -------------------------------------------------------------
        // -- Update การใช้งาน RX ว่าจบแล้ว ได้เวลาการใช้ RX Delay หรือไม่อย่างไร 
        // -------------------------------------------------------------
        $strSql = "UPDATE tpdt_trn_pd_sch SET ";
        $strSql .= "[pd status]='" . $_POST["pd_status"] . "', ";
        $strSql .= "[actual finish date]='" . $_POST["actual_finish_date"] . "', ";
        $strSql .= "[actual finish time]='" . $_POST["actual_finish_time"] . "', ";
        $strSql .= "why_process_delay='" . $_POST["why_process_delay"] . "', ";
        $strSql .= "process_delay_remark='" . $_POST["process_delay_remark"] . "', ";
        $strSql .= "why_start_delay='" . $_POST["why_start_delay"] . "', ";
        $strSql .= "start_delay_remark='" . $_POST["start_delay_remark"] . "', ";
        $strSql .= "[actual quantity]=NULL ";
        $strSql .= "WHERE [material number]='" . $_POST["mat_number"] . "' ";
        $strSql .= "AND batch='" . trim($_POST["lot_no"]) . "' ";
        $strSql .= "AND [order]='" . substr($_POST['order_no'],0,7). "' ";
        //echo $strSql . "<br>";
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
        if ($nRecCount == 1)
        {         
            echo "Finish production complete!";
            
            // ----------------------------------------------------------------------
            // -- Insert การใช้งาน Blowdown Process / Intermediate tank / Operation 20
            // ----------------------------------------------------------------------
            $strSql = "INSERT INTO tpdt_trn_blowdown(Pd_Order, Material_Number, Batch_No, Order_Quantity, RX_No, StartDateBD, StartTimeBD, PD_Status) ";
            $strSql .= "VALUES(";
            $strSql .= "'" . substr($_POST['order_no'],0,7). "', ";
            $strSql .= "'" . $_POST["mat_number"] . "', ";
            $strSql .= "'" . trim($_POST["lot_no"]) . "', ";
            $strSql .= "" . trim($_POST["order_qty"]) . ", ";
            $strSql .= "'" . trim($_POST["rxNo"]) . "', ";
            $strSql .= "'" . $_POST["startDateBD"] . "', ";
            $strSql .= "'" . $_POST["startTimeBD"] . "', ";
            $strSql .= "'O')";
            echo $strSql . "<br>";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();  
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";
            if ($nRecCount == 1)
            {
                echo "Start blowdown process complete!";
            }
            else
            {
                echo "start blowdown process fail!";
            }
        }
        else
        {
            echo "Error! Cannot finish production status!";
        }
    }
    catch(PDOException $e)
    {     
        echo substr($e->getMessage(),0,105) ;
    }
?>