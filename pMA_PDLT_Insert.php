<?php
    /*
    echo $_POST['pd_code'] . "<br>";    
    */

    try
    {
        include('include/db_Conn.php');

        $strSql = "INSERT INTO tpdt_mas_pd_data ";
        $strSql .= "VALUES(";    
        $strSql .= "'" . $_POST["Pd_Code"] . "',";
        $strSql .= "'" . $_POST["Pd_Name"] . "',";
        $strSql .= "'" . $_POST["Pd_Sbu"] . "',";
        $strSql .= "'" . $_POST["Pd_Group"] . "',";
        $strSql .= "" . $_POST["Pd_Lt"] . ",";
        $strSql .= "'" . date('Y/m/d') . "',";
        $strSql .= "'" . $_POST["Enter_By"] . "') ";
        //echo $strSql ;

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