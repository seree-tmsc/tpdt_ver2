<?php
    try
    {
        //echo $_POST["id"] . "<br>";

        include('include/db_Conn.php');

        $strSql = "DELETE FROM TPDT_MAS_Users_Id ";
        $strSql .= "WHERE emp_code='" . $_POST["id"] . "' ";
        //echo $strSql . "<br>";
    
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();

        $nRecCount = $statement->rowCount();
        echo $nRecCount . "<br>";
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();        
    }
?>