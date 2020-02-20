<?php    
    /*
    echo $_POST['editpdOrdNo'] . "  ";
    echo $_POST['editmatCode'] . "  ";
    echo $_POST['editmatName'] . "  ";
    echo $_POST["editlotNo"] . "  ";
    echo $_POST["editpdVersion"] . "  ";
    echo $_POST["editmrpController"] . "  ";
    echo $_POST["editbatchSize"] . "  ";    
    echo $_POST["editbasicStartDate"] . "  ";
    echo $_POST["basicStartTime"] . "  ";
    echo $_POST["rxNo"] . "  ";
    */
        
    try
    {
        include('include/db_Conn.php');
        $strSql = "UPDATE tpdt_trn_pd_sch ";
        $strSql .= "SET `Actual start date` = '" . $_POST['revactualStartDate'] . "', ";
        $strSql .= "`Actual start time` = '" . $_POST['revactualStartTime'] . "' ";
        $strSql .= "WHERE `Order` = '" . $_POST['editpdOrdNo'] . "' ";
        //echo $strSql;

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
        if ($nRecCount == 1)
        {            
            echo "Update production schedule data completely !";
        }
        else
        {
            echo "Error! Cannot update production schedule data !";
        }
    }
    catch(PDOException $e)
    {        
        echo substr($e->getMessage(),0,105) ;
    }    
?>