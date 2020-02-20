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
        $strSql .= "why_process_delay='', ";
        $strSql .= "process_delay_remark='', ";
        $strSql .= "why_start_delay='', ";
        $strSql .= "start_delay_remark='', ";
        $strSql .= "[actual quantity]= 0 ";
        $strSql .= "WHERE [order]='" . substr($_POST['order_no'],0,10). "' ";
        //echo $strSql;

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
        if ($nRecCount == 1)
        {         
            echo "Washing process finish complete!";
        }
        else
        {
            echo "Error! Cannot finish washing process!";
        }
    }
    catch(PDOException $e)
    {     
        echo substr($e->getMessage(),0,105) ;
    }
?>