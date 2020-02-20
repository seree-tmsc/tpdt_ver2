<?php
    //echo substr($_GET['sbu'], 0, strlen($_GET['sbu'])-1);
    //echo $_GET['sbu'];

    try 
    {   
        include('include/db_Conn.php');
        $aTmp_Name = array('DC-211', 'DC-211-A', 'DC-311', 'DC-311-A', 'DC-411', 'DC-411-A', 'DC-441', 'DC-441-A', 
        'DC-611', 'DC-611-A', 'DC-622', 'DC-622-A',
        'DC-9011', 'DC-9011-A', 'DC-9021', 'DC-9021-A', 'DC-9031', 'DC-9031-A', 'DC-9041', 'DC-9041-A', 'DC-9051', 
        'DC-9051-A', 'DC-9061', 'DC-9061-A', 'DC-9071', 'DC-9071-A', 'DC-9081', 'DC-9081-A', 'DC-9091', 'DC-9091-A',
        'FA-9014', 'FA-9014-A', 'FA-9024', 'FA-9024-A', 'FA-9034', 'FA-9034-A', 'FA-9044', 'FA-9044-A',
        'FA-9054', 'FA-9054-A','FA-9064', 'FA-9064-A','FA-9074', 'FA-9074-A',
        'DC-101', 'DC-101-A', 'DC-111', 'DC-111-A', 'DC-121', 'DC-121-A', 'DC-122', 'DC-122-A', 'DC-124', 'DC-124-A', 
        'DC-141', 'DC-141-A', 'DC-151', 'DC-151-A', 'DC-161', 'DC-161-A', 'DC-181', 'DC-181-A', 'DC-191', 'DC-191-A',
        'FA-191', 'FA-191-A');
        
        $aIRS_Name = array('DC-211', 'DC-211-A', 'DC-311', 'DC-311-A', 'DC-411', 'DC-411-A', 'DC-441', 'DC-441-A', 'DC-611', 'DC-611-A', 'DC-622', 'DC-622-A');
                
        $aIRW_Name = array('DC-9011', 'DC-9011-A', 'DC-9021', 'DC-9021-A', 'DC-9031', 'DC-9031-A', 'DC-9041', 'DC-9041-A', 'DC-9051', 
        'DC-9051-A', 'DC-9061', 'DC-9061-A', 'DC-9071', 'DC-9071-A', 'DC-9081', 'DC-9081-A', 'DC-9091', 'DC-9091-A',
        'FA-9014', 'FA-9014-A', 'FA-9024', 'FA-9024-A', 'FA-9034', 'FA-9034-A', 'FA-9044', 'FA-9044-A',
        'FA-9054', 'FA-9054-A','FA-9064', 'FA-9064-A','FA-9074', 'FA-9074-A');

        $aUU_Name = array('DC-101', 'DC-101-A', 'DC-111', 'DC-111-A', 'DC-121', 'DC-121-A', 'DC-122', 'DC-122-A', 'DC-124', 'DC-124-A', 
        'DC-141', 'DC-141-A', 'DC-151', 'DC-151-A', 'DC-161', 'DC-161-A', 'DC-181', 'DC-181-A', 'DC-191', 'DC-191-A', 'FA-191', 'FA-191-A');
        
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
        // ตรวจสอบข้อมูล Array $aRx_Name
        // print_r($aRx_Name);
        // echo "<br>";

        $strSql = "SELECT * ";
        $strSql .= "FROM tpdt_trn_pd_sch T ";
        $strSql .= "JOIN tpdt_mas_pd_data M ON M.pd_code = T.[Material Number] ";
        $strSql .= "LEFT JOIN tpdt_trn_blowdown B ON B.Pd_Order = T.[Order] ";

        $keyWord = ['IRS','IRW','UU']; // the word you wanna to find
        $nElement = 1;                                                
        foreach($keyWord as $key)
        {                                                    
            if (strpos($_GET['sbu'], $key) > 0)
            {
                if($nElement == 1)
                {
                    $strSql .= "WHERE ((pd_sbu ='" . $key . "') " ;                    
                }
                else
                {
                    $strSql .= "OR (pd_sbu ='" . $key . "') " ;
                }
                $nElement += 1;
            }
        }
        $strSql .= ") ";

        $strSql .= "ORDER BY [Order] ";
        //echo $strSql;
        
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";

        if ($nRecCount >0)
        {
            // Returning array
            $events = array();
            
            /*--------------------------------------------------------------*/
            /*--  Create Graph to show from start time until currect time --*/
            /*--------------------------------------------------------------*/
            date_default_timezone_set("Asia/Bangkok");
            $e = array();
            $e['id'] = 'bg1';
            $e['rendering'] = 'background';
            $e['start'] = date('Y-m-d H:i');
            $e['backgroundColor'] = 'red';
            array_push($events, $e);

            // Fetch results
            $nI = 0;
            while ($ds = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $nI++; 
                /* ------------------------------ */
                /* --- Drawing Planning Chart --- */
                /* ------------------------------ */
                switch ($ds['Pd Status'])
                {
                    // --- Start Production แล้ว
                    case 'O':
                        $e = array();
                        //$e['id'] = array_search($ds['RX No'], $aRx_Name);
                        $e['id'] = $ds['Order'];                
                        //$e['id'] = $ds['RX No'];
                        //$e['id'] = array_search($ds['RX No'], $aRx_Name);
                        //$e['resourceId'] = $ds['Order'];
                        $e['resourceId'] = array_search($ds['RX No'], $aRx_Name);
                        $e['start'] = date('Y-m-d H:i:s', strtotime($ds['Basic start date'] . " " . $ds['Basic start time']));                
                        $e['end'] = date('Y-m-d H:i:s', strtotime($ds['Basic finish date'] . " " . $ds['Basic finish time']));

                        // -- กำหนดเงือนไข การแสดง Tile + Color ระหว่าง WS กับ Order  ปกติ
                        if(substr($ds['Order'], 8, 2) == 'WS')
                        {
                            $e['title'] = '-WS--' . $ds["Material description"] . ' ---[' . $ds["Material Number"] . ' ' . $ds["Batch"] . ' ' . $ds["Order quantity"] . "]" ;
                            $e['backgroundColor'] = 'Blue';
                            $e['textColor'] = 'White';
                        }
                        else
                        {
                            $e['title'] = '1.(Starting) ' . $ds["Material description"] . ' ---[' . $ds["Material Number"] . ' ' . $ds["Batch"] . ' ' . $ds["Order quantity"] . "]" ;
                            $e['backgroundColor'] = 'Yellow';
                            $e['textColor'] = 'Black';
                        }
                        // ตรวจสอบข้อมูล Array $e
                        // echo $nI . " ";
                        // echo $ds['Order'] . "<br>";
                        // print_r($e);
                        // echo "<br>";
        
                        // Merge the event array into the return array
                        array_push($events, $e);
                        break;

                    // --- Finish Production แล้ว
                    case 'C':
                        $e = array();
                        //$e['id'] = array_search($ds['RX No'], $aRx_Name);
                        $e['id'] = $ds['Order'];                
                        //$e['id'] = $ds['RX No'];
                        //$e['id'] = array_search($ds['RX No'], $aRx_Name);
                        //$e['resourceId'] = $ds['Order'];
                        $e['resourceId'] = array_search($ds['RX No'], $aRx_Name);
                        $e['start'] = date('Y-m-d H:i:s', strtotime($ds['Basic start date'] . " " . $ds['Basic start time']));
                        $e['end'] = date('Y-m-d H:i:s', strtotime($ds['Basic finish date'] . " " . $ds['Basic finish time']));

                        //  กำหนดรายละเอียด Tile + Color ที่แตกต่าง ระหว่าง WS และ Order ธรรมดา
                        if(substr($ds['Order'], 8, 2) == 'WS')
                        {
                            $e['title'] = '-WS-- ' . $ds["Material description"] . ' ---[' . $ds["Material Number"] . ' ' . $ds["Batch"] . ' ' . $ds["Order quantity"] . "]" ;
                            $e['backgroundColor'] = 'DimGray';
                            $e['textColor'] = 'Silver';
                        }
                        else
                        {
                            $e['title'] = '1.(Finished) ' . $ds["Material description"] . ' ---[' . $ds["Material Number"] . ' ' . $ds["Batch"] . ' ' . $ds["Order quantity"] . "]" ;
                            $e['backgroundColor'] = 'Gainsboro';
                            $e['textColor'] = 'Gray';
                        }
                        // ตรวจสอบข้อมูล Array $e
                        // echo $nI . " ";
                        // echo $ds['Order'] . "<br>";
                        // print_r($e);
                        // echo "<br>";
        
                        // Merge the event array into the return array
                        array_push($events, $e);
                        break;
                    
                    // --- Release แล้ว
                    default:
                        $e = array();
                        //$e['id'] = array_search($ds['RX No'], $aRx_Name);
                        $e['id'] = $ds['Order'];                
                        //$e['id'] = $ds['RX No'];
                        //$e['id'] = array_search($ds['RX No'], $aRx_Name);
                        //$e['resourceId'] = $ds['Order'];
                        $e['resourceId'] = array_search($ds['RX No'], $aRx_Name);
                        $e['start'] = date('Y-m-d H:i:s', strtotime($ds['Basic start date'] . " " . $ds['Basic start time']));
                        $e['end'] = date('Y-m-d H:i:s', strtotime($ds['Basic finish date'] . " " . $ds['Basic finish time']));

                        // -- กำหนดเงือนไข การแสดง Tile + Color ระหว่าง WS กับ Order  ปกติ
                        if(substr($ds['Order'], 8, 2) == 'WS')
                        {
                            $e['title'] = 'WS---'. $ds["Material description"] . ' ---[' . $ds["Material Number"] . ' ' . $ds["Batch"] . ' ' . $ds["Order quantity"] . "]" ;
                            $e['backgroundColor'] = 'Azure';
                            $e['textColor'] = 'Black';
                        }
                        else
                        {
                            $e['title'] = '1.(Planning) ' . $ds["Material description"] . ' ---[' . $ds["Material Number"] . ' ' . $ds["Batch"] . ' ' . $ds["Order quantity"] . "]" ;
                            $e['backgroundColor'] = 'lightyellow';
                            $e['textColor'] = 'Black';
                        }
                        // ตรวจสอบข้อมูล Array $e
                        // echo $nI . " ";
                        // echo $ds['Order'] . "<br>";
                        // print_r($e);
                        // echo "<br>";
        
                        // Merge the event array into the return array
                        array_push($events, $e);
                        break;
                }

                /* ------------------------------*/
                /* --- Drawing Actual Chart  --- */
                /* ------------------------------*/
                switch($ds['Pd Status'])
                {
                    // --- Start Production แล้ว
                    case 'O':
                        /* -------------------------------------------*/
                        /* --- Drawing Actual Chart But Not Complete --- */
                        /* -------------------------------------------*/
                        $e = array();
                        $e['id'] = $ds['Order'].'-A';
                        //$e['id'] = $ds['RX No'];
                        //$e['id'] = array_search($ds['RX No'], $aRx_Name);
                        //$e['resourceId'] = $ds['Order'];
                        $e['resourceId'] = array_search($ds['RX No'].'-A', $aRx_Name);
                        $e['start'] = date('Y-m-d H:i:s', strtotime($ds['Actual start date'] . " " . $ds['Actual start time']));
                        $e['end'] = date('Y-m-d H:i:s');

                        //  กำหนดรายละเอียด Tile + Color ที่แตกต่าง ระหว่าง WS และ Order ธรรมดา
                        if(substr($ds['Order'], 8, 2) == 'WS')
                        {
                            $e['title'] = 'W/S--' . $ds["Material description"] . ' ---[' . $ds["Material Number"] . ' ' . $ds["Batch"] . ' ' . $ds["Order quantity"] . "]" ;
                            $e['backgroundColor'] = 'PaleGreen';
                            $e['textColor'] = 'Black';
                        }
                        else
                        {
                            $e['title'] = '2.(On going) ' . $ds["Material description"] . ' ---[' . $ds["Material Number"] . ' ' . $ds["Batch"] . ' ' . $ds["Order quantity"] . "]" ;
                            $e['backgroundColor'] = 'PaleGreen';
                            $e['textColor'] = 'Black';
                        }
                        //print_r($e);

                        // Merge the event array into the return array
                        array_push($events, $e);
                        break;
                        
                    // --- Finish Production แล้ว
                    case 'C':
                        /* ------------------------*/
                        /* --- Actual Complete --- */
                        /* ------------------------*/
                        $e = array();
                        $e['id'] = $ds['Order'].'-A';
                        //$e['id'] = $ds['RX No'];
                        //$e['id'] = array_search($ds['RX No'], $aRx_Name);
                        //$e['resourceId'] = $ds['Order'];

                        // -- Actual chart กำหนดให้ไปใส่ภายใน ช่อง RX-P แต่ใน Array กำหนดเป็น -A
                        $e['resourceId'] = array_search($ds['RX No'].'-A', $aRx_Name);
                        $e['start'] = date('Y-m-d H:i:s', strtotime($ds['Actual start date'] . " " . $ds['Actual start time']));
                        $e['end'] = date('Y-m-d H:i:s', strtotime($ds['Actual finish date'] . " " . $ds['Actual finish time']));
                        $e['title'] = '2.(Complete) ' . $ds["Material description"] . ' ---[' . $ds["Material Number"] . ' ' . $ds["Batch"] . ' ' . $ds["Order quantity"] . "]" ;

                        $AS = date('Y-m-d H:i', strtotime($ds['Actual start date'] . ' ' . $ds['Actual start time']));
                        $BS = date('Y-m-d H:i', strtotime($ds['Basic start date'] . ' ' . $ds['Basic start time']));
                        $AF = date('Y-m-d H:i', strtotime($ds['Actual finish date'] . ' ' . $ds['Actual finish time']));
                        $BF = date('Y-m-d H:i', strtotime($ds['Basic finish date'] . ' ' . $ds['Basic finish time']));

                        $diffA = (strtotime($AF) - strtotime($AS))/60/60;
                        $diffB = (strtotime($BF) - strtotime($BS))/60/60;
                        //echo 'diffA=' . $diffA . '<br>';
                        //echo 'diffB' . $diffB . '<br>';

                        if( $diffA > $diffB)
                        {
                            if(substr($ds['Order'], 8, 2) == 'WS')
                            {
                                $e['backgroundColor'] = 'DarkRed';
                                $e['textColor'] = 'White';
                            }
                            else
                            {
                                //$e['backgroundColor'] = 'red';
                                $e['backgroundColor'] = 'Salmon';
                                $e['textColor'] = 'white';
                            }
                        }
                        else
                        {
                            if(substr($ds['Order'], 8, 2) == 'WS')
                            {
                                $e['backgroundColor'] = 'DarkRed';
                                $e['textColor'] = 'White';
                            }
                            else
                            {
                                $e['backgroundColor'] = 'Salmon';
                                $e['textColor'] = 'White';
                            }
                        }

                        //print_r($e);
                        // Merge the event array into the return array
                        array_push($events, $e);
                        
                        
                        // -------------------------------------
                        // --- สร้าง Chart สำหรับ Monitor Blowdown
                        // -------------------------------------
                        if($ds['Pd_Status'] == 'O')
                        {
                            $e = array();
                            $e['id'] = $ds['Order'].'-BD';
                            $e['resourceId'] = array_search($ds['RX_No'].'-A', $aRx_Name);
                            $e['start'] = date('Y-m-d H:i:s', strtotime($ds['StartDateBD'] . " " . $ds['StartTimeBD']));
                            $e['end'] = date('Y-m-d H:i:s');
    
                            //  กำหนดรายละเอียด Tile + Color ที่แตกต่าง ระหว่าง WS และ Order ธรรมดา
                            $e['title'] = '3.(Blowdown) ' . $ds["Material description"] . ' ---[' . $ds["Material Number"] . ' ' . $ds["Batch"] . ' ' . $ds["Order quantity"] . "]" ;
                            $e['backgroundColor'] = 'Lime';
                            $e['textColor'] = 'Darkgreen';
                            //print_r($e);
    
                            // Merge the event array into the return array
                            array_push($events, $e);
                        }
                        break;
                }                
            }
            // Output json for our calendar
            echo json_encode($events);
            //exit();
        }
        else
        {
            echo "Error ...! Data not found ...!";
        }
    } 
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }

?>