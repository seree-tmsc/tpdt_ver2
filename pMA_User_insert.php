<?php
    /*
    echo $_POST['empCode'];
    echo $_POST["eMail"];
    echo $_POST["userType"];
    echo $_POST["createdDate"];
    */

    try
    {
        include('include/db_Conn.php');
        $strSql = "INSERT INTO TPDT_Mas_Users_Id ";
        $strSql .= "VALUES(";
        $strSql .= "'" . $_POST["empCode"] . "',";
        $strSql .= "'" . $_POST["eMail"] . "',";
        $strSql .= "'" . base64_encode($_POST["empCode"] . '@1234') . "',";
        $strSql .= "'" . $_POST["userType"] . "',";
        $strSql .= "'" . date('Y/m/d',strtotime($_POST["createdDate"])) . "', '')";        
        //echo $strSql;

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
        if ($nRecCount == 1)
        {            
            echo "Insert data complete!";
        }
        else
        {                   
            echo "Error! Cannot insert data!";            
        }        
    }
    catch(PDOException $e)
    {        
        echo substr($e->getMessage(),0,105) ;
    }
?>