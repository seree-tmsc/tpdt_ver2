<?php
    function calculate_record_of_me2l()
    {        
        try
        {
            include('include/db_Conn.php');

            $strSql = "SELECT COUNT(*) as 'TotalRecord' ";
            $strSql .= "FROM QSIS_TRN_ME2L ";
            //echo $strSql . "<br>";
    
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            //print_r($result);

            $nRecCount = $statement->rowCount();
            if ($nRecCount == 1)
            {
                $nRecord = $result[0]['TotalRecord'];
            }
            else
            {
                $nRecord = 0;
            }
        } 
        catch (Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $nRecord = 0;
        }    
        return $nRecord;
    }

    function calculate_record_of_oth()
    {        
        try
        {
            include('include/db_Conn.php');

            $strSql = "SELECT COUNT(*) as 'TotalRecord' ";
            $strSql .= "FROM QSIS_TRN_OTH ";
            //echo $strSql . "<br>";
    
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            //print_r($result);

            $nRecCount = $statement->rowCount();
            if ($nRecCount == 1)
            {
                $nRecord = $result[0]['TotalRecord'];
            }
            else
            {
                $nRecord = 0;
            }
        } 
        catch (Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $nRecord = 0;
        }    
        return $nRecord;
    }

    function calculate_number_of_supplier()
    {        
        try
        {
            include('include/db_Conn.php');
            $strSql = "DELETE FROM tmp_QSIS_TRN_PCDATA ";
            //echo $strSql . "<br>";
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));            
            $statement->execute();

            $strSql = "INSERT INTO tmp_QSIS_TRN_PCDATA ";
            $strSql .= "SELECT * FROM QSIS_TRN_OTH ";
            //echo $strSql . "<br>";
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();
            
            $strSql = "INSERT INTO tmp_QSIS_TRN_PCDATA ";
            $strSql .= "([Enter Date], [Document No], Item, [Short Text], ";
            $strSql .= "[Order Quantity], [Order Price], [Order Amount], Supplier_Code, Supplier_Name) ";
            $strSql .= "SELECT [Document Date], [Purchasing Document], Item, [Short Text], ";
            $strSql .= "[Order Quantity], [Net price], [Net Order Value], Supplier_Code, Supplier_Name ";
            $strSql .= "FROM QSIS_TRN_ME2L ";
            //echo $strSql . "<br>";
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();

            $strSql = "SELECT supplier_name ";
            $strSql .= "FROM tmp_QSIS_TRN_PCDATA ";
            $strSql .= "GROUP BY supplier_name ";
            $strSql .= "ORDER BY supplier_name ";            
            //echo $strSql . "<br>";
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();
            
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            //print_r($result);

            $nRecCount = $statement->rowCount();            
        } 
        catch (Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $nRecCount = 0;
        }

        $aSupplierData = array();
        array_push($aSupplierData, $aSupplierData['Sup_Qty']=$nRecCount, $aSupplierData['Sup_Dataset']=$result);

        return $aSupplierData;
    }

    function get_Data_From_DB()
    {
        try
        {
            include('include/db_Conn.php');
            $strSql = "DELETE FROM tmp_QSIS_TRN_PCDATA ";
            //echo $strSql . "<br>";
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));            
            $statement->execute();

            $strSql = "INSERT INTO tmp_QSIS_TRN_PCDATA ";
            $strSql .= "SELECT * FROM QSIS_TRN_OTH ";
            //echo $strSql . "<br>";
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();
            
            $strSql = "INSERT INTO tmp_QSIS_TRN_PCDATA ";
            $strSql .= "([Enter Date], [Document No], Item, [Short Text], ";
            $strSql .= "[Order Quantity], [Order Price], [Order Amount], Supplier_Code, Supplier_Name) ";
            $strSql .= "SELECT [Document Date], [Purchasing Document], Item, [Short Text], ";
            $strSql .= "[Order Quantity], [Net price], [Net Order Value], Supplier_Code, Supplier_Name ";
            $strSql .= "FROM QSIS_TRN_ME2L ";
            //echo $strSql . "<br>";
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();

            $strSql = "SELECT YEAR([Enter Date]) as 'cYear', MONTH([Enter Date]) as 'cMonth', SUM([Order Amount]) as 'AMT' ";
            $strSql .= "FROM tmp_QSIS_TRN_PCDATA ";
            $strSql .= "GROUP BY YEAR([Enter Date]), MONTH([Enter Date]) ";
            $strSql .= "ORDER BY YEAR([Enter Date]), MONTH([Enter Date]) ";            
            //echo $strSql . "<br>";
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();            
            $nRecCount = $statement->rowCount();
            if($nRecCount > 0)
            {
                $aLabels = array();
                $aDatas = array();
                $aMonthName = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

                while ($ds = $statement->fetch(PDO::FETCH_BOTH))
                {
                    $cLabel = $ds['cYear'] . "-" . $aMonthName[$ds['cMonth']-1];

                    array_push($aLabels, $cLabel);
                    array_push($aDatas, round($ds['AMT']/1000000, 2));
                }
            }            
            else
            {
                echo "Out of Data!";
            }
        } 
        catch (Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";            
        }

        $aAllData = array();
        array_push($aAllData, $aAllData['labels']=$aLabels, $aAllData['datas']=$aDatas);
                
        //echo json_encode($aAllData);

        return $aAllData;
    }    



    function get_Data_From_Pd_Ord_By_Month($user_sbu)
    {
        try
        {
            include('include/db_Conn.php');

            $strSql = "SELECT YEAR([basic start date]) as 'cYear', MONTH([basic start date]) as 'cMonth', "; 
            $strSql .= "SUM([Order quantity]) as 'PQty' ";
            $strSql .= "FROM tpdt_trn_coois T ";
            $strSql .= "JOIN tpdt_mas_pd_data M ON M.pd_code = T.[Material Number] ";
            $strSql .= "WHERE YEAR([basic start date]) = YEAR(GETDATE()) ";
            //$strSql .= "AND MONTH([basic start date]) = MONTH(CURDATE()) ";
            //$strSql .= "AND WEEK([basic start date]) <= WEEK(CURDATE()) ";
            //$strSql .= "AND WEEK([basic start date]) >= WEEK(CURDATE())-3 ";
            
            $keyWord = ['IRS','IRW','UU']; // the word you wanna to find
            $nElement = 1;            
            foreach($keyWord as $key)
            {
                if (strpos($user_sbu, $key) > 0)
                {
                    if($nElement == 1)
                    {
                        $strSql .= "AND ((M.pd_sbu ='" . $key . "') " ;
                    }
                    else
                    {
                        $strSql .= "OR (M.pd_sbu ='" . $key . "') " ;
                    }
                    $nElement += 1;     
                }                                                    
            }
            $strSql .= ") ";

            $strSql .= "GROUP BY YEAR([basic start date]), MONTH([basic start date]) ";
            $strSql .= "ORDER BY YEAR([basic start date]), MONTH([basic start date]) ";            
            //echo $strSql . "<br>";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();            
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";

            if($nRecCount > 0)
            {
                $aLabels = array();
                $aData1s = array();
                $aData2s = array();
                //$aMonthName = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

                while ($ds = $statement->fetch(PDO::FETCH_BOTH))
                {
                    //print_r($ds);
                    $dDate = new DateTime($ds['cYear'] . '/' . $ds['cMonth'] . '/01');
                    //echo $dDate->format('M-Y');
                    $cLabel = $dDate->format('M-Y');
                    array_push($aLabels, $cLabel);
                    array_push($aData1s, round($ds['PQty']/1000, 2));


                    $strSql = "SELECT SUM([Actual quantity]) as 'AQty' ";
                    $strSql .= "FROM tpdt_trn_pd_sch T ";
                    $strSql .= "JOIN tpdt_mas_pd_data M ON M.pd_code = T.[Material Number] ";
                    $strSql .= "WHERE YEAR([basic start date]) = YEAR(GETDATE()) ";
                    $strSql .= "AND MONTH([basic start date]) = " . $ds['cMonth'] . " ";
                    
                    $keyWord = ['IRS','IRW','UU']; // the word you wanna to find
                    $nElement = 1;            
                    foreach($keyWord as $key)
                    {
                        if (strpos($user_sbu, $key) > 0)
                        {
                            if($nElement == 1)
                            {
                                $strSql .= "AND ((M.pd_sbu ='" . $key . "') " ;
                            }
                            else
                            {
                                $strSql .= "OR (M.pd_sbu ='" . $key . "') " ;
                            }
                            $nElement += 1;     
                        }                                                    
                    }
                    $strSql .= ") ";                    
                    //echo $strSql . "<br>";

                    $statement1 = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                    $statement1->execute();            
                    $nRecCount1 = $statement1->rowCount();
                    //echo $nRecCount . "<br>";
                    if($nRecCount1 == 1)
                    {
                        $ds1 = $statement1->fetch(PDO::FETCH_BOTH);
                        array_push($aData2s, round($ds1['AQty']/1000, 2));
                    }
                    else
                    {
                        array_push($aData2s, 0);
                    }                    
                }
            }            
            else
            {
                echo "Out of Data!";
            }
        } 
        catch (Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";            
        }

        $aAllData = array();
        array_push($aAllData, $aAllData['labels']=$aLabels, $aAllData['data1s']=$aData1s, $aAllData['data2s']=$aData2s);
                
        //echo json_encode($aAllData);

        return $aAllData;
    }

    function get_Data_From_Pd_Ord_By_Grp($user_sbu)
    {
        try
        {
            include('include/db_Conn.php');

            $strSql = "SELECT M.pd_sbu, M.pd_group, SUM(T.[Actual quantity]) as 'Qty' ";
            $strSql .= "FROM tpdt_trn_pd_sch T ";
            $strSql .= "JOIN tpdt_mas_pd_data M ON M.pd_code = T.[Material Number] ";
            $strSql .= "WHERE YEAR(T.[Basic start date]) = YEAR(GETDATE()) ";
            
            $keyWord = ['IRS','IRW','UU']; // the word you wanna to find
            $nElement = 1;            
            foreach($keyWord as $key)
            {
                if (strpos($user_sbu, $key) > 0)
                {
                    if($nElement == 1)
                    {
                        $strSql .= "AND ((M.pd_sbu ='" . $key . "') " ;
                    }
                    else
                    {
                        $strSql .= "OR (M.pd_sbu ='" . $key . "') " ;
                    }
                    $nElement += 1;     
                }                                                    
            }

            $strSql .= ") ";
            $strSql .= "GROUP BY M.pd_sbu, M.pd_group ";
            $strSql .= "ORDER BY M.pd_sbu, M.pd_group ";
            //$strSql .= "LIMIT 20";
            //echo $strSql . "<br>";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();            
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";

            if($nRecCount > 0)
            {
                $aLabels = array();
                $aDatas = array();
                //$aMonthName = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

                while ($ds = $statement->fetch(PDO::FETCH_BOTH))
                {
                    //print_r($ds);                    
                    $cLabel = $ds['pd_group'];                    

                    array_push($aLabels, $cLabel);
                    array_push($aDatas, round($ds['Qty']/1000, 2));
                }
            }            
            else
            {
                echo "Out of Data!";
            }
        } 
        catch (Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";            
        }

        $aAllData = array();
        array_push($aAllData, $aAllData['labels']=$aLabels, $aAllData['datas']=$aDatas);
                
        //echo json_encode($aAllData);

        return $aAllData;
    }

    function get_Data_From_Pd_Ord_Top_20($user_sbu)
    {
        try
        {
            include('include/db_Conn.php');

            $strSql = "SELECT TOP 20 [Material description], SUM([Actual quantity]) as 'Qty' "; 
            $strSql .= "FROM tpdt_trn_pd_sch T ";
            $strSql .= "JOIN tpdt_mas_pd_data M ON M.pd_code = T.[Material Number] ";
            $strSql .= "WHERE YEAR([basic start date]) = YEAR(GETDATE()) ";
            
            $keyWord = ['IRS','IRW','UU']; // the word you wanna to find
            $nElement = 1;            
            foreach($keyWord as $key)
            {
                if (strpos($user_sbu, $key) > 0)
                {
                    if($nElement == 1)
                    {
                        $strSql .= "AND ((M.pd_sbu ='" . $key . "') " ;
                    }
                    else
                    {
                        $strSql .= "OR (M.pd_sbu ='" . $key . "') " ;
                    }
                    $nElement += 1;     
                }                                                    
            }

            $strSql .= ") ";
            $strSql .= "GROUP BY [Material description] ";
            $strSql .= "ORDER BY Qty DESC ";
            //echo $strSql . "<br>";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();            
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";

            if($nRecCount > 0)
            {
                $aLabels = array();
                $aDatas = array();
                //$aMonthName = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

                while ($ds = $statement->fetch(PDO::FETCH_BOTH))
                {
                    //print_r($ds);                    
                    $cLabel = $ds['Material description'];                    

                    array_push($aLabels, $cLabel);
                    array_push($aDatas, round($ds['Qty']/1000, 2));
                }
            }            
            else
            {
                echo "Out of Data!";
            }
        } 
        catch (Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";            
        }

        $aAllData = array();
        array_push($aAllData, $aAllData['labels']=$aLabels, $aAllData['datas']=$aDatas);
                
        //echo json_encode($aAllData);

        return $aAllData;
    }

    function get_Data_From_Pd_Ord_By_Rx($user_sbu)
    {
        try
        {
            include('include/db_Conn.php');

            $strSql = "SELECT M.pd_sbu, T.[RX No], SUM(T.[Actual quantity]) as 'Qty' ";
            $strSql .= "FROM tpdt_trn_pd_sch T ";
            $strSql .= "JOIN tpdt_mas_pd_data M ON M.pd_code = T.[Material Number] ";
            $strSql .= "WHERE YEAR(T.[Basic start date]) = YEAR(GETDATE()) ";
            
            $keyWord = ['IRS','IRW','UU']; // the word you wanna to find
            $nElement = 1;            
            foreach($keyWord as $key)
            {
                if (strpos($user_sbu, $key) > 0)
                {
                    if($nElement == 1)
                    {
                        $strSql .= "AND ((M.pd_sbu ='" . $key . "') " ;
                    }
                    else
                    {
                        $strSql .= "OR (M.pd_sbu ='" . $key . "') " ;
                    }
                    $nElement += 1;     
                }                                                    
            }

            $strSql .= ") ";
            $strSql .= "GROUP BY M.pd_sbu, T.[RX No] ";
            $strSql .= "ORDER BY M.pd_sbu, T.[RX No] ";
            //echo $strSql . "<br>";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();            
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";

            if($nRecCount > 0)
            {
                $aLabels = array();
                $aDatas = array();
                //$aMonthName = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

                while ($ds = $statement->fetch(PDO::FETCH_BOTH))
                {
                    //print_r($ds);
                    $cLabel = $ds['RX No'];

                    array_push($aLabels, $cLabel);
                    array_push($aDatas, round($ds['Qty']/1000, 2));
                }
            }            
            else
            {
                echo "Out of Data!";
            }
        } 
        catch (Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";            
        }

        $aAllData = array();
        array_push($aAllData, $aAllData['labels']=$aLabels, $aAllData['datas']=$aDatas);
                
        //echo json_encode($aAllData);

        return $aAllData;
    }
?>