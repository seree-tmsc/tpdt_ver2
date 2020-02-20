<?php
    /*
    echo "1.".$_POST["order_no"];
    echo "1.".$_POST["mat_code"];
    echo "2.".$_POST["lot_no"];
    echo "3.".$_POST['pd_status'];
    echo "4.".$_POST['actual_startdate'];
    echo "5.".$_POST['actual_starttime'];    
    echo "6.".$_POST['why_delay'];
    echo "7.".$_POST['remark'];
    */

    try
    {
        include('include/db_Conn.php');
        
        $strSql = "UPDATE tpdt_trn_pd_sch SET ";
        $strSql .= "[pd status]='" . $_POST["pd_status"] . "', ";
        $strSql .= "[actual finish date]='" . $_POST["actual_finish_date"] . "', ";
        $strSql .= "[actual finish time]='" . $_POST["actual_finish_time"] . "', ";
        $strSql .= "why_process_delay='" . $_POST["why_process_delay"] . "', ";
        $strSql .= "process_delay_remark='" . $_POST["process_delay_remark"] . "', ";
        $strSql .= "why_start_delay='" . $_POST["why_start_delay"] . "', ";
        $strSql .= "start_delay_remark='" . $_POST["start_delay_remark"] . "', ";
        $strSql .= "[actual quantity]=" . $_POST["pd_close_actual_qty"] . " ";
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