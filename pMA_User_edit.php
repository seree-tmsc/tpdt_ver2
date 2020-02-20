<?php
    /*
    echo "1." . $_POST['parameditempCode'];    
    echo " 2." . $_POST["edituserType"];
    */

    try
    {
        include('include/db_Conn.php');        
        $strSql = "UPDATE TPDT_Mas_Users_Id SET ";        
        $strSql .= "user_type='" . $_POST["edituserType"] . "' ";
        $strSql .= "WHERE emp_Code='" . $_POST["parameditempCode"] . "' ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
        if ($nRecCount == 1)
        {         
            echo "Edit data complete!";
        }
        else
        {
            echo "Error! Cannot edit data!";
        }    
    }
    catch(PDOException $e)
    {     
        echo substr($e->getMessage(),0,105) ;
    }
?>