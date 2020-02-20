<?php    
    /*
    echo $_POST['editpdOrdNo'] . "  ";
    echo $_POST['editmatCode'] . "  ";
    echo $_POST['editmatName'] . "  ";
    echo $_POST["editlotNo"] . "  ";
    echo $_POST["pdVersion"] . "  ";
    echo $_POST["mrpController"] . "  ";
    echo $_POST["editorderQuantity"] . "  ";    
    echo $_POST["basicStartDate"] . "  ";
    echo $_POST["basicStartTime"] . "  ";
    echo $_POST["rxNo"] . "  ";
    echo $_POST["editwsStartDate"] . "  ";
    echo $_POST["editwsStartTime"] . "  ";
    echo $_POST["wsFinishDate"] . "  ";
    echo $_POST["wsFinishTime"] . "  ";
    */

    try
    {
        include('include/db_Conn.php');
        $strSql = "UPDATE tpdt_trn_coois ";
        $strSql .= "SET [Delete flag] = 'Y' ";
        $strSql .= "WHERE [Order] = '" . $_POST['editpdOrdNo'] . "' ";
        //echo $strSql;

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
        if ($nRecCount == 1)
        {            
            //echo "Insert data complete!";

            $strSql = "INSERT INTO tpdt_trn_pd_sch ";
            $strSql .= "VALUES(";
            $strSql .= "'" . $_POST["editpdOrdNo"] . "',";
            $strSql .= "'RB11',";
            $strSql .= "'" . $_POST["editmatCode"] . "',";
            $strSql .= "'" . $_POST["editmatName"] . "',";
            $strSql .= "'" . $_POST["editlotNo"] . "',";
            $strSql .= "'" . $_POST["pdVersion"] . "',";
            $strSql .= "'" . $_POST["mrpController"] . "',";
            $strSql .= "'PP01',";
            $strSql .= "" . $_POST["editorderQuantity"] . ",";
            $strSql .= "'KG',";
            $strSql .= "'" . $_POST["basicStartDate"] . "',";
            //$strSql .= "'" . date('Y/m/d',strtotime($_POST["editbasicStartDate"])) . "', '')";
            $strSql .= "'" . $_POST["basicStartTime"] . "',";
            //$strSql .= "'" . date('H:i',strtotime($_POST["editbasicStartTime"])) . "', '')";
            $strSql .= "'" . $_POST["editbasicFinishDate"] . "',";
            //$strSql .= "'" . date('Y/m/d',strtotime($_POST["editbasicFinishDate"])) . "', '')";
            $strSql .= "'" . $_POST["editbasicFinishTime"] . "',";
            //$strSql .= "'" . date('H:i',strtotime($_POST["editbasicFinishTime"])) . "', '')";
            $strSql .= "'P',";
            $strSql .= "'" . $_POST["rxNo"] . "',";
            $strSql .= "'',";
            $strSql .= "'',";
            $strSql .= "'',";
            $strSql .= "'',";        
            $strSql .= "'',";
            $strSql .= "0,";
            $strSql .= "'',";
            $strSql .= "'',";
            $strSql .= "'',";
            $strSql .= "'')";
            //echo $strSql;
    
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();  
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";
            if ($nRecCount == 1)
            {            
                echo "Insert Production Data Into Table -- tpdt_trn_pd_sch -- complete ...!";

                $strSql = "INSERT INTO tpdt_trn_pd_sch ";
                $strSql .= "VALUES(";
                $strSql .= "'" . $_POST["editpdOrdNo"] . "-WS',";
                $strSql .= "'RB11',";
                $strSql .= "'" . $_POST["editmatCode"] . "',";
                $strSql .= "'" . $_POST["editmatName"] . "',";
                $strSql .= "'" . $_POST["editlotNo"] . "',";
                $strSql .= "'" . $_POST["pdVersion"] . "',";
                $strSql .= "'" . $_POST["mrpController"] . "',";
                $strSql .= "'PP01',";
                $strSql .= "" . $_POST["editorderQuantity"] . ",";
                $strSql .= "'KG',";
                $strSql .= "'" . $_POST["editwsStartDate"] . "',";
                //$strSql .= "'" . date('Y/m/d',strtotime($_POST["editbasicStartDate"])) . "', '')";
                $strSql .= "'" . $_POST["editwsStartTime"] . "',";
                //$strSql .= "'" . date('H:i',strtotime($_POST["editbasicStartTime"])) . "', '')";
                $strSql .= "'" . $_POST["wsFinishDate"] . "',";
                //$strSql .= "'" . date('Y/m/d',strtotime($_POST["editbasicFinishDate"])) . "', '')";
                $strSql .= "'" . $_POST["wsFinishTime"] . "',";
                //$strSql .= "'" . date('H:i',strtotime($_POST["editbasicFinishTime"])) . "', '')";
                $strSql .= "'P',";
                $strSql .= "'" . $_POST["rxNo"] . "',";
                $strSql .= "'',";
                $strSql .= "'',";
                $strSql .= "'',";
                $strSql .= "'',";        
                $strSql .= "'',";
                $strSql .= "0,";
                $strSql .= "'',";
                $strSql .= "'',";
                $strSql .= "'',";
                $strSql .= "'')";
                //echo $strSql;
        
                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();  
                $nRecCount = $statement->rowCount();
                //echo $nRecCount . "<br>";

                if ($nRecCount == 1)
                {
                    echo "Insert WS Data Into Table -- tpdt_trn_pd_sch -- complete ...!";
                }
                else
                {
                    echo "Error! Cannot Insert WS Data Into Table -- tpdt_trn_pd_sch -- ...!";
                }
            }
            else
            {                   
                echo "Error! Cannot Insert Production Data Into Table -- tpdt_trn_pd_sch -- ...!";
            }
        }
        else
        {
            echo "Error! Cannot Update Table -- tpdt_trn_coois -- ... !";
        }
    }
    catch(PDOException $e)
    {        
        echo substr($e->getMessage(),0,105) ;
    }
?>