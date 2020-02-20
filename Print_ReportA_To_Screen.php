<?php
    try
    {
        include_once('include/chk_Session.php');
        if($user_email == "")
        {
            echo "<script> 
                    alert('Warning! Please Login!'); 
                    window.location.href='login.php'; 
                </script>";
        }
        else
        {
            //date_default_timezone_set("Asia/Bangkok");
            require_once('include/db_Conn.php');
            /* ------------------------------------------------------------------------ */
            /* --- ตรวจสอบข้อมูลจาก COA_SalesData เช่น เลขที่ PO / ปริมาณการสั่งซื้อ / เป็นต้น --- */
            /* ------------------------------------------------------------------------ */
            $strSql = "SELECT * ";
            $strSql .= "FROM tpdt_trn_pd_sch T ";
            $strSql .= "JOIN tpdt_mas_pd_data M ";
            $strSql .= "ON M.[pd_code] = T.[Material Number] ";
            $strSql .= "WHERE [Pd Status] = 'C' ";
            $strSql .= "AND Month([Actual finish date]) =" . $_POST['nMonth'] . " "; 
            $strSql .= "AND YEar([Actual finish date]) =" . $_POST['nYear'] . " "; 


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


            $strSql .= "ORDER BY [pd_group], [Material Number], [Order] ";
            //echo $strSql . "<br>";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
            $statement->execute();  
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . " records <br>";

            if ($nRecCount > 0)
            {   
                /*----------------------------------*/
                /*--- Initial Important Library --- */
                /*----------------------------------*/                
                // import library
                require("../vendors/fpdf16/fpdf.php");

                /*------------------------------*/
                /*-- creat class for all page --*/
                /*------------------------------*/
                class PDF extends FPDF
                {
                    // Page header
                    function Header()
                    {
                        // set margin
                        $this->SetMargins(5,0);
                        $this->SetAutoPageBreak(true, 15);

                        // Logo                                                
                        $this->Image('images/tmsc-new-logo-long1.gif', 98, 6, 100);                        

                        $aMonth = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
                        //assign font                                        
                        $this->SetFont('Arial','B',12);
                        $this -> SetY(18);
                        $this -> SetX(0);
                        //คำสั่งสำหรับขึ้นบรรทัดใหม่
                        //cell(width, height, text, border, in, align, fill, link)
                        $this->Cell( 0, 10, 'Production Monthly Report', 0, 0, 'C');                        
                        $this -> SetY(25);
                        $this -> SetX(0);
                        $this->Cell( 0, 10, 'For : '. $aMonth[$_POST['nMonth']-1] . ' / '. $_POST['nYear'], 0, 0, 'C');
                        //คำสั่งสำหรับขึ้นบรรทัดใหม่
                        $this->Ln();
                        //$this->Cell( 0, 0, '', 1, 0, 'C');
                        $this->Ln();                        
                        $this->SetFont('Arial','',10);
                        $this->SetFillColor(255,102,102);
                        $this->Cell( 25, 10, '', 0, 0, 'C');
                        $this->Cell( 30, 10, 'Pd_Group', 1, 0, 'C', true);
                        $this->Cell( 18, 10, 'Order', 1, 0, 'C', true);
                        $this->Cell( 40, 10, 'Material Code', 1, 0, 'C', true);
                        $this->Cell( 50, 10, 'Material Name', 1, 0, 'C', true);
                        $this->Cell( 18, 10, 'Lot No.', 1, 0, 'C', true);
                        $this->Cell( 22, 10, 'Plan.Qty.', 1, 0, 'C', true);
                        $this->Cell( 16, 10, 'PD-LT', 1, 0, 'C', true);
                        $this->Cell( 22, 10, 'Act.Qty', 1, 0, 'C', true);
                        $this->Cell( 16, 10, 'PD-T', 1, 0, 'C', true);
                        //$this->Cell( 56, 10, 'Comment', 1, 0, 'C', true);
                        $this->Ln();

                        /*
                        // Arial bold 15
                        $this->SetFont('Arial','B',15);
                        // Move to the right
                        $this->Cell(80);
                        // Title
                        $this->Cell(30,10,'Title',1,0,'C');
                        // Line break
                        $this->Ln(20);
                        */
                    }                    
                    
                    // Page footer
                    function Footer()
                    {
                        // Position at 1.5 cm from bottom
                        $this->SetY(-15);
                        // Arial italic 8
                        $this->SetFont('Arial','I',8);                        
                        // Print current and total page numbers
                        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'L');
                        $tDate = date('d/M/Y - H:i');                        
                        $this->Cell(0, 10, 'Print Date : '.$tDate, 0, 0, 'R');
                    }
                }
                
                // creat instant
                $pdf=new PDF('L', 'mm', 'A4');
                $pdf->AliasNbPages();

                //add page
                $pdf->AddPage();


                /*-------------------*/
                /*--- Print Body --- */
                /*-------------------*/                
                $pdf->SetFont('Arial','',10);
                $nCurRow = 0;
                $nTotAmtPlan = 0;
                $nTotAmtAct = 0;
                $nGTotAmtPlan = 0;
                $nGTotAmtAct = 0;
                $cCurGroup = '';

                while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                {
                    $nCurRow += 1;
                    if( $nCurRow == 1)
                    {
                        $cCurGroup = $ds['pd_group'];
                    }                    

                    /*--------------------------*/
                    /*-- Print Sub Total LIne --*/
                    /*--------------------------*/
                    if($cCurGroup != $ds['pd_group'])
                    {
                        $pdf->SetFillColor(204,255,229);
                        $pdf->Cell( 25, 10, '', 0, 0, 'C');
                        $pdf->Cell( 88, 10, $cCurGroup, 1, 0, 'C', true);
                        $pdf->Cell( 68, 10, 'Sub Total', 1, 0, 'C', true);
                        $pdf->Cell( 22, 10, number_format($nTotAmtPlan, 2, '.', ','), 1, 0, 'R', true);
                        $pdf->Cell( 16, 10, '', 1, 0, 'L', true);
                        $pdf->Cell( 22, 10, number_format($nTotAmtAct, 2, '.', ','), 1, 0, 'R', true);
                        //$pdf->Cell( 72, 10, '', 1, 0, 'L', true);
                        $pdf->Cell( 16, 10, '', 1, 0, 'L', true);
                        $pdf->Ln();

                        $cCurGroup = $ds['pd_group'];
                        $nTotAmtPlan = 0;
                        $nTotAmtAct = 0;
                    }
                    /*-----------------------*/
                    /*-- Print Normal Line --*/
                    /*-----------------------*/
                    $nTotAmtPlan += $ds['Order quantity'];
                    $nTotAmtAct += $ds['Actual quantity'];
                    $nGTotAmtPlan += $ds['Order quantity'];
                    $nGTotAmtAct += $ds['Actual quantity'];

                    //$pdf->Cell( 21, 10, date('d/m/Y', strtotime($ds['Actual finish date'])), 0, 0, 'L');
                    //$pdf->Cell( 11, 10, date('H:i', strtotime($ds['Actual finish time'])), 0, 0, 'L');
                    $pdf->Cell( 25, 10, '', 0, 0, 'C');
                    $pdf->Cell( 30, 10, $ds['pd_group'], 1, 0, 'L');
                    $pdf->Cell( 18, 10, $ds['Order'], 1, 0, 'C');
                    $pdf->Cell( 40, 10, $ds['Material Number'], 1, 0, 'L');
                    $pdf->Cell( 50, 10, $ds['Material description'], 1, 0, 'L');
                    $pdf->Cell( 18, 10, $ds['Batch'], 1, 0, 'C');
                    $pdf->Cell( 22, 10, number_format($ds['Order quantity'], 2, '.', ','), 1, 0, 'R');
                    $pdf->Cell( 16, 10, number_format($ds['pd_lead_time'],2,':',','), 1, 0, 'R');
                    $pdf->Cell( 22, 10, number_format($ds['Actual quantity'], 2, '.', ','), 1, 0, 'R');

                    $dteStart = new DateTime($ds['Actual start date'] . ' '. substr($ds['Actual start time'], 0, 5));
                    $dteFinish = new DateTime($ds['Actual finish date'] . ' '. substr($ds['Actual finish time'], 0, 5));
                    $dteDiff = $dteStart->diff($dteFinish);
                    $pdf->Cell( 16, 10, $dteDiff->format("%H:%I"), 1, 0, 'R');
                    

                    $pdf->Ln();
                    $pdf->SetFillColor(128,128,128);
                    //$pdf->Cell( 232, 10, '', 1, 0, 'L');
                    $pdf->Cell( 25, 10, '', 0, 0, 'C');
                    $pdf->Cell( 30, 10, '', 1, 0, 'L');
                    $pdf->Cell( 58, 10, 'Why process delay', 1, 0, 'L');
                    $pdf->Cell( 50, 10, $ds['Why_process_delay'], 1, 0, 'L');
                    $pdf->Cell( 40, 10, 'Why start delay', 1, 0, 'L');                    
                    $pdf->Cell( 54, 10, $ds['Why_start_delay'], 1, 0, 'L');

                    $pdf->Ln();
                }
                /*--------------------------*/
                /*-- Print Sub Total Line --*/
                /*--------------------------*/
                $pdf->SetFillColor(204,255,229);
                $pdf->Cell( 25, 10, '', 0, 0, 'C');
                $pdf->Cell( 88, 10, $cCurGroup, 1, 0, 'C', true);
                $pdf->Cell( 68, 10, 'Sub Total', 1, 0, 'C', true);
                $pdf->Cell( 22, 10, number_format($nTotAmtPlan, 2, '.', ','), 1, 0, 'R', true);
                $pdf->Cell( 16, 10, '', 1, 0, 'L', true);
                $pdf->Cell( 22, 10, number_format($nTotAmtAct, 2, '.', ','), 1, 0, 'R', true);
                //$pdf->Cell( 72, 10, '', 1, 0, 'L', true);
                $pdf->Cell( 16, 10, '', 1, 0, 'L', true);
                $pdf->Ln();

                /*----------------------------*/
                /*-- Print Grand Total Line --*/
                /*----------------------------*/
                $pdf->SetFillColor(255,229,204);
                $pdf->Cell( 25, 10, '', 0, 0, 'C');
                $pdf->Cell( 88, 10, '', 1, 0, 'C', true);
                $pdf->Cell( 68, 10, 'Grand Total', 1, 0, 'C', true);
                $pdf->Cell( 22, 10, number_format($nGTotAmtPlan, 2, '.', ','), 1, 0, 'R', true);
                $pdf->Cell( 16, 10, '', 1, 0, 'L', true);
                $pdf->Cell( 22, 10, number_format($nGTotAmtAct, 2, '.', ','), 1, 0, 'R', true);
                //$pdf->Cell( 72, 10, '', 1, 0, 'L', true);
                $pdf->Cell( 16, 10, '', 1, 0, 'L', true);
                $pdf->Ln();


                /*---------------------*/
                /*--- Print Footer --- */
                /*---------------------*/
                //print to output
                $pdf->Output();
            }
            else
            {
                echo "<script> alert('Error! ... Not Found Production Schedule Data ! ...'); window.close(); </script>";
            }
        }
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();
    }
?>