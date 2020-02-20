<?php
    /*
    echo "1." . $_POST['parameditPdCode']; 
    echo "2." . $_POST['editPdLt']; 
    */
    
    try
    {
        include('include/db_Conn.php');        

        $strSql = "UPDATE tpdt_mas_pd_data SET ";
        $strSql .= "`pd_lead_time` = " . $_POST["editPdLt"] . ", ";
        $strSql .= "`pd_sbu` = '" . $_POST["editPdSbu"] . "', ";
        $strSql .= "`pd_group` = '" . $_POST["editPdGroup"] . "' ";
        $strSql .= "WHERE `pd_code` = '" . $_POST["parameditPdCode"] . "' ";
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