<?php
    /*
    echo "1.".$_POST["order_no"];
    echo "1.".$_POST["mat_code"];
    echo "2.".$_POST["lot_no"];
    echo "3.".$_POST['pd_status'];
    echo "4.".$_POST['actual_startdate'];
    echo "5.".$_POST['actual_starttime'];
    */

    try
    {
        include('include/db_Conn.php');
        
        $strSql = "UPDATE tpdt_trn_pd_sch SET ";
        $strSql .= "[pd status]='" . $_POST["pd_status"] . "', ";
        $strSql .= "[actual start date]='" . $_POST["actual_start_date"] . "', ";
        $strSql .= "[actual start time]='" . $_POST["actual_start_time"] . "' ";
        $strSql .= "WHERE [material number]='" . $_POST["mat_code"] . "' ";
        $strSql .= "AND batch='" . trim($_POST["lot_no"]) . "' ";
        $strSql .= "AND [pd status]='' ";
        $strSql .= "AND [order]='" . $_POST['order_no']. "' ";
        //echo $strSql;

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
        if ($nRecCount == 1)
        {         
            echo "Starting production completely!...";
        }
        else
        {
            echo "Error!... Cannot starting production status ... Because this production order started already!";
        }
    }
    catch(PDOException $e)
    {     
        echo substr($e->getMessage(),0,105) ;
    }
?>