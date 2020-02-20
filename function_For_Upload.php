<?php
    function upload_to_server_folder()
    {
        try
        {   
            echo "<label>Process 1. Upload to temps folder. </label><br>";

            date_default_timezone_set("Asia/Bangkok"); 
            move_uploaded_file($_FILES["param_fileCSV"]["tmp_name"], "temps/".$_FILES["param_fileCSV"]["name"]);

            echo "Folder location is ../temps/".$_FILES["param_fileCSV"]["name"] . "<br>";

            $lPass = true;
        }
        catch(Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $lPass = false;
        }
        
        if ($lPass == true)
        {
            echo "<label style='color:green'>... Pass ....</label>" . "<br><br>";
        }
        else
        {
            echo "<label style='color:red'>... Error ...</label>" . "<br><br>";
        }
        return $lPass;
    }

    function check_number_of_column($nColumn)
    {
        try
        {
            echo $nColumn . "<br>";

            $lPass = true;
            echo "<label>Process 2. Check Number of Column. [" . $nColumn . " Columns.]</label><br>";
            //echo "Folder location is ../temps/".$_FILES["param_fileCSV"]["name"] . "<br>";

            $objCSV = fopen("temps/" . $_FILES["param_fileCSV"]["name"], "r");
    
            if (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE)
            {
                echo "Number of Columns = " . sizeof($objArr) . " columns <br>";
                
                for($i = 0; $i < sizeof($objArr); $i++)
                {
                    echo ($i+1) . " " . $objArr[$i] . "<br>";
                }

                if (sizeof($objArr) <> $nColumn)
                {
                    $lPass = false;
                }
            }
            else
            {
                $lPass = false;
            }
            fclose($objCSV);
        }
        catch (Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $lPass = false;
        }

        if ($lPass == true)
        {
            echo "<label style='color:green'>... Pass ....</label>" . "<br><br>";
        }
        else
        {
            echo "<label style='color:red'>... Error ...</label>" . "<br><br>";
        }
        return $lPass;
    }

    function check_name_of_column($aColumnName)
    {
        try
        {
            //setlocale ( LC_ALL, 'en_US.UTF-8' );
            //setlocale(LC_ALL, 'th_TH');
            //setlocale(LC_ALL, 'th_TH.utf-8');
            //setlocale ( LC_ALL, 'Thai' );

            $lPass = true;
            echo "<label>Process 3. Check Name of Column. </label><br>";
            //echo "Folder location is ../temps/".$_FILES["param_fileCSV"]["name"] . "<br>";
            $objCSV = fopen("temps/" . $_FILES["param_fileCSV"]["name"], "r");
    
            if (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE)
            {
                //echo "Number of Columns = " . sizeof($objArr) . " columns <br>";

                foreach ($objArr as $key => $value)
                {
                    echo "Column " . ($key+1) . " / " . "Column Name is '" . strtolower($value) . "' <br>";
                    switch ($key) 
                    {
                        case 0:
                            echo strlen($value) . " " . substr($value, 0, 1) . " ". substr($value, 1, 1) . " " . substr($value, 2, 1) . " ". substr($value, 3, 1) . "<br>";

                            //echo substr($value, 0, strlen($value)) . "<br>";
                            //echo strtolower(substr($value, 0, strlen($value))) . "<br>";

                            //echo substr($value,3,strlen($value)) . "<br>";
                            //echo strtolower(substr($value,3,strlen($value))) . "<br>";
                            /*
                            if(  strtolower(substr($value,3,strlen($value))) != $aColumnName[0])
                            {
                                echo strlen($value) . "<br>";
                                echo substr($value,3,strlen($value)) . "<br>";
                                echo strtolower(substr($value,3,strlen($value))) . "<br>";
                                echo "<label style='color:red'>... Error - Column " .  ($key+1) . "</label>" . "<br><br>";
                                $lPass = false;
                            }
                            */
                            break;
                        case 1:
                            if( strtolower($value) != $aColumnName[1])
                            {
                                echo "<label style='color:red'>... Error - Column " .  ($key+1) . "</label>" . "<br><br>";
                                $lPass = false;
                            }
                            break;
                        case 2:
                            if( strtolower($value) != $aColumnName[2])
                            {
                                echo "<label style='color:red'>... Error - Column " .  ($key+1) . "</label>" . "<br><br>";
                                $lPass = false;
                            }
                            break;
                        case 3:
                            if( strtolower($value) != $aColumnName[3])
                            {
                                echo "<label style='color:red'>... Error - Column " .  ($key+1) . "</label>" . "<br><br>";
                                $lPass = false;
                            }
                            break;
                        case 4:
                            if( strtolower($value) != $aColumnName[4])
                            {
                                echo "<label style='color:red'>... Error - Column " .  ($key+1) . "</label>" . "<br><br>";
                                $lPass = false;
                            }
                            break;
                        case 5:
                            if( strtolower($value) != $aColumnName[5])
                            {
                                echo "<label style='color:red'>... Error - Column " .  ($key+1) . "</label>" . "<br><br>";
                                $lPass = false;
                            }
                            break;
                        case 6:
                            if( strtolower($value) != $aColumnName[6])
                            {
                                echo "<label style='color:red'>... Error - Column " .  ($key+1) . "</label>" . "<br><br>";
                                $lPass = false;
                            }
                            break;
                        case 7:
                            if( strtolower($value) != $aColumnName[7])
                            {
                                echo "<label style='color:red'>... Error - Column " .  ($key+1) . "</label>" . "<br><br>";
                                $lPass = false;
                            }
                            break;
                    }
                }
            }
            else
            {
                $lPass = false;
            }
            fclose($objCSV);
        }
        catch (Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $lPass = false;
        }

        if ($lPass == true)
        {
            echo "<label style='color:green'>... Pass ....</label>" . "<br><br>";
        }
        else
        {
            echo "<label style='color:red'>... Error ...</label>" . "<br><br>";
        }
        return $lPass;
    }

    function verify_data($aVerifyField, $aVerifyData, $cTableName)
    {
        try
        {
            $lPass = true;
            $nCurRow = 0;
            echo "<label>Process 4. Verify data in History Table</label><br>";
            //echo "Folder location is ../temps/".$_FILES["param_fileCSV"]["name"] . "<br>";

            $objCSV = fopen("temps/" . $_FILES["param_fileCSV"]["name"], "r");

            while (($objArr = fgetcsv($objCSV, 10000, ",")) !== FALSE)
            {
                $lPass = true;
                $nCurRow += 1;
                //echo "Verify Record No. " . $nCurRow . " " . "<br>";

                if($nCurRow > 1)
                {                    
                    include('include/db_Conn.php');
                    $strSql = "SELECT * ";
                    $strSql .= "FROM " . $cTableName . " ";
                    switch(count($aVerifyField))                    
                    {
                        case 1:
                            $strSql .= "WHERE " . $aVerifyField[0] . "='" . $objArr[$aVerifyData[0]] . "' " ;
                            break;
                        case 2:
                            $strSql .= "WHERE " . $aVerifyField[0] . "='" . $objArr[$aVerifyData[0]] . "' " ;
                            $strSql .= "AND " . $aVerifyField[1] . "='" . $objArr[$aVerifyData[1]] . "' " ;
                            break;
                        case 3:
                            $strSql .= "WHERE " . $aVerifyField[0] . "='" . $objArr[$aVerifyData[0]] . "' " ;
                            $strSql .= "AND " . $aVerifyField[1] . "='" . $objArr[$aVerifyData[1]] . "' " ;
                            $strSql .= "AND " . $aVerifyField[2] . "='" . $objArr[$aVerifyData[2]] . "' " ;
                            break;
                    }                    
                    echo $strSql . "<br>";
                
                    $statement = $conn->prepare($strSql,array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                    $statement->execute();
                    $nRecCount = $statement->rowCount();
                    
                    if ($nRecCount == 1)
                    {                            
                        echo "<label style='color:red'>... Error Porcess #4 ... Production Order No. = ". $objArr[$aVerifyData[0]] . " ... User used to uploaded this data already !" . "</label><br>";
                        $lPass = false;
                        break;
                    }                                  
                }
                else
                {
                    $lPass = false;
                }
            }
            if ($lPass == true)
            {
                echo "End Of File ..." . "<br>";
            }
            fclose($objCSV);
        }
        catch (Exception $e)
        {
            echo $strSql . "<br>";
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $lPass = false;
        }
        
        if ($lPass == true)
        {
            echo "<label style='color:green'>... Pass ....</label>" . "<br><br>";
        }
        else
        {
            echo "<label style='color:red'>... Error ...</label>" . "<br><br>";
        }
        
        return $lPass;
    }
    
    function upload_COOIS_to_database()
    {
        try
        {
            $lPass = true;
            $nCurRec = 0;
            $aPdOrdNo = array();
            $currentPdOrdNo = '';

            echo "<label>Process 5. Upload CSV file from server folder to Database Server</label><br>";
            //echo "Folder location is ../temps/".$_FILES["param_fileCSV"]["name"] . "<br>";

            $objCSV = fopen("temps/" . $_FILES["param_fileCSV"]["name"], "r");
            while (($objArr = fgetcsv($objCSV, 10000, ",")) !== FALSE)
            {
                $nCurRec +=1;
                //echo $nCurRec . "<br>";
                //echo $objArr[1] . "<br>";

                if($nCurRec > 1)
                {
                    if ($currentPdOrdNo != $objArr[0])
                    {
                        if (! in_array($objArr[0], $aPdOrdNo))
                        {
                            $aTmpArray = array();               
                            array_push($aTmpArray, $objArr[0]);
                            array_push($aTmpArray, $objArr[2]);
                            array_push($aTmpArray, $objArr[4]);
                            //echo "'20".substr($objArr[9],6,2)."/".substr($objArr[9],3,2)."/".substr($objArr[9],0,2). "'";
                            //array_push($aTmpArray, "20".substr($objArr[9],6,2)."/".substr($objArr[9],3,2)."/".substr($objArr[9],0,2));

                            //echo $objArr[9] ;
                            array_push($aTmpArray, $objArr[9]);

                            array_push($aPdOrdNo, $aTmpArray);
                            $currentPdOrdNo = $objArr[0];                            
                        }
                    }
                
                    include('include/db_Conn.php');
                    $strSql = "INSERT INTO tpdt_trn_coois ";
                    $strSql .= "VALUES (";
                    $strSql .= "'".$objArr[0]."',";
                    $strSql .= "'".$objArr[1]."',";
                    $strSql .= "'".$objArr[2]."',";
                    $strSql .= "'".$objArr[3]."',";
                    $strSql .= "'".$objArr[4]."',";
                    $strSql .= "'".$objArr[11]."',";
                    $strSql .= "'".$objArr[5]."',";
                    $strSql .= "'".$objArr[6]."',";
                    $strSql .= "".str_replace(',','',$objArr[7]).",";
                    $strSql .= "'".$objArr[8]."',";
                    //$strSql .= "'20".substr($objArr[9],6,2)."/".substr($objArr[9],3,2)."/".substr($objArr[9],0,2). "',";
                    $strSql .= "'" . $objArr[9] . "',";
                    $strSql .= "'',";
                    //$strSql .= "'20".substr($objArr[10],6,2)."/".substr($objArr[10],3,2)."/".substr($objArr[10],0,2). "',";
                    $strSql .= "'" . $objArr[10] . "',";
                    $strSql .= "'',";                    
                    $strSql .= "'N',";
                    $strSql .= "'')";
                    echo $nCurRec-1 . ". " . $strSql . "<br>";
                    
                    $statement = $conn->prepare($strSql);
                    $statement->execute();
                }
            }
            fclose($objCSV);
        }        
        catch (Exception $e)
        {
            echo $strSql . "<br>";            
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $lPass = false;
        }        

        if ($lPass == true)
        {
            echo "<label style='color:green'>... Pass ....Upload data = ". ($nCurRec-1) . " Records </label>" . "<br><br>";
            /*
            sort($aInv_Date);
            print_r(array_values($aInv_Date));
            */
        }
        else
        {
            echo "<label style='color:red'>... Error ...</label>" . "<br><br>";
        }
        
        $returnResult[0] =$lPass;
        $returnResult[1] =$aPdOrdNo;

        return $returnResult;
    }
    
    function Insert_Trans_History_Upload_COOIS($aData, $user_email) 
    {
        try
        {
            $lPass = true;
            $nCurRec = 0;
            echo "<label>Process 6. Insert data into transaction history table</label><br>";

            sort($aData);
            //print_r(array_values($aData));
            //echo $user_email;
            
            foreach ($aData as $keyPdOrdNo =>$valuePdOrdNo)
            {
                $nCurRec += 1;
                echo $nCurRec . ". " ;
                //echo $valueMatlot ;

                include('include/db_Conn.php');
    
                $strSql = "INSERT INTO trans_history_upload_coois ";
                $strSql .= "VALUES(";
                $strSql .= "'" . $aData[$keyPdOrdNo][0] . "',";
                $strSql .= "'" . $aData[$keyPdOrdNo][1] . "',";
                $strSql .= "'" . $aData[$keyPdOrdNo][2] . "',";
                $strSql .= "'" . date('Y/m/d H:i:s') . "',";
                $strSql .= "'" . $aData[$keyPdOrdNo][3] . "',";
                $strSql .= "'" . $user_email . "')";
                echo $strSql . "<br>";
            
                $statement = $conn->prepare($strSql,array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();
                //$nRecCount = $statement->rowCount();
            }
        }
        catch(PDOException $e)
        {
            $lPass = false;
            echo $strSql . "<br>";
            echo $e->getMessage() . "<br>";          
        }

        if ($lPass == true)
        {
            echo "<label style='color:green'>... Pass ....Insert data = ". $nCurRec ." Items Into Trans History </label>" . "<br><br>";
        }
        else
        {            
            echo "<label style='color:red'>... Error ...</label>" . "<br><br>";
        }

        return $lPass;
    }
?>