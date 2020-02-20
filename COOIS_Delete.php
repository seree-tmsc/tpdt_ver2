<?php
    try
    {
        echo $_POST["pd_ord_no"] . "<br>";

        include('include/db_Conn.php');
        $strSql = "DELETE FROM tpdt_trn_coois ";
        $strSql .= "WHERE [Order]='" . $_POST["pd_ord_no"] . "' ";
        //echo $strSql . "<br>";
    
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();

        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";

        $strSql = "DELETE FROM trans_history_upload_coois ";
        $strSql .= "WHERE [pd_ord_no]='" . $_POST["pd_ord_no"] . "' ";
        //echo $strSql . "<br>";
    
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();

        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();
    }
?>