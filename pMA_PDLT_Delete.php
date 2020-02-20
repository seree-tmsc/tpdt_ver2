<?php
    try
    {        
        /*
        echo $_POST["pd_code"] . "<br>";
        */

        include('include/db_Conn.php');
        $strSql = "DELETE FROM tpdt_mas_pd_data ";
        $strSql .= "WHERE `pd_code`='" . $_POST["pd_code"] . "' ";        
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