<?php
    //echo $_GET['sbu'];
    date_default_timezone_set("Asia/Bangkok");
    try 
    {                
        include('include/db_Conn.php');
        
        //$aIRS_Name = array('DC-211', 'DC-311', 'DC-411', 'DC-441', 'DC-611', 'DC-622');
        $aIRS_Name = array('DC-211-P', 'DC-211', 'DC-311-P', 'DC-311', 'DC-411-P', 'DC-411', 'DC-441-P', 'DC-441', 'DC-611-P', 'DC-611', 'DC-622-P', 'DC-622');

        $aIRW_Name = array('DC-9011-P', 'DC-9011', 'DC-9021-P', 'DC-9021', 'DC-9031-P', 'DC-9031', 'DC-9041-P', 'DC-9041', 'DC-9051-P', 
        'DC-9051', 'DC-9061-P', 'DC-9061', 'DC-9071-P', 'DC-9071', 'DC-9081-P', 'DC-9081', 'DC-9091-P', 'DC-9091', 
        'FA-9014-P', 'FA-9014', 'FA-9024-P', 'FA-9024', 'FA-9034-P', 'FA-9034', 'FA-9044-P', 'FA-9044',
        'FA-9054-P', 'FA-9054','FA-9064-P', 'FA-9064','FA-9074-P', 'FA-9074');

        //$aUU_Name = array('DC-101', 'DC-111', 'DC-121', 'DC-122', 'DC-124', 'DC-141', 'DC-151', 'DC-161', 'DC-181', 'DC-191' );
        $aUU_Name = array('DC-101-P', 'DC-101', 'DC-111-P', 'DC-111', 'DC-121-P', 'DC-121', 'DC-122-P', 'DC-122', 'DC-124-P', 'DC-124', 
        'DC-141-P', 'DC-141', 'DC-151-P', 'DC-151', 'DC-161-P', 'DC-161', 'DC-181-P', 'DC-181', 'DC-191-P', 'DC-191', 'FA-191-P', 'FA-191' );
        
        $aRx_Name = array();
        
        $keyWord = ['IRS','IRW','UU']; // the word you wanna to find
        foreach($keyWord as $key)
        {
            if (strpos($_GET['sbu'], $key) > 0)
            {
                switch($key)
                {
                    case 'IRS':
                        foreach ($aIRS_Name as $value) 
                        {                        
                            array_push($aRx_Name, $value);
                        }
                        break;
                    case 'IRW':
                        foreach ($aIRW_Name as $value) 
                        {                        
                            array_push($aRx_Name, $value);
                        }
                        break;
                    case 'UU':
                        foreach ($aUU_Name as $value)
                        {                        
                            array_push($aRx_Name, $value);
                        }
                        break;
                }
            }
        }

        // Returning array
        $events = array();

        for ($nI=0; $nI<=(sizeof($aRx_Name)-1); $nI++)
        {
            //echo $nI . "<br>";
            $strSql = "SELECT * ";
            //$strSql .= "FROM events ";
            $strSql .= "FROM tpdt_trn_pd_sch ";
            $strSql .= "WHERE [RX No] = '" . $aRx_Name[$nI] . "' ";
            $strSql .= "AND [pd status] ='O' ";
            $strSql .= "AND [actual start date] <= '" . date('Y-m-d') . "' ";
            //echo $strSql . "<br>";
    
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
            $statement->execute();  
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";
            
            if ($nRecCount > 0)
            {
                $ds = $statement->fetch(PDO::FETCH_NAMED);

                //print_r($ds);

                $e = array();                
                //$e['id'] = $nI+1;
                $e['id'] = $nI;
                $e['rx_no'] = $aRx_Name[$nI];
                //date_default_timezone_set("Asia/Bangkok");
                $datetime1 = new DateTime(date('Y-m-d H:i:s'));
                $datetime2 = new DateTime($ds['Actual start date'] . " " . $ds['Actual start time']);
                $interval = $datetime1->diff($datetime2);
                //echo $interval->format('%h')." Hours ".$interval->format('%i')." Minutes";
                $e['runtime'] = $interval->format('%d') . "d " . $interval->format('%h')." h ".$interval->format('%i')." m";
                $e['qty'] = number_format($ds['Order quantity'],0,'.',',');                
                $e['eventColor'] = 'black';
            }
            else
            {
                $e = array();
                //$e['id'] = $nI+1;
                $e['id'] = $nI;
                $e['rx_no'] = $aRx_Name[$nI];
                $e['runtime'] = '-';
                $e['qty'] = '-';
                $e['eventColor'] = 'black';
            }
            array_push($events, $e);            
        }
        // Output json for our calendar
        echo json_encode($events);
        //exit();        
    } 
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }

?>