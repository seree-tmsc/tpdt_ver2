<?php
    $short_text = $_POST['short_text'];
    $supplier_name = $_POST['supplier_name'];    

    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM QSIS_TRN_OTH ";                
    $strSql .= "WHERE [Short Text] ='" . $short_text . "' ";
    $strSql .= "AND [Supplier_Name] ='" . $supplier_name . "' ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();
    
    $cOutput = "<div class='table-responsive'>";
    $cOutput .= "<table class='table table-bordered' style='background-color: Azure; color: navy; border:2px solid blue;'>";

    if ($nRecCount == 1)
    {
        $ds = $statement->fetch(PDO::FETCH_NAMED);
        $cOutput .= "<tr><td style='width:30%; border:1px solid blue;'><label>Document Date</label></td> <td style='border:1px solid blue;'>" . $ds['Enter Date'] . "</td></tr>";
        $cOutput .= "<tr><td style='border:1px solid blue;'><label>Short Text</label></td> <td style='border:1px solid blue;'>" . $ds['Short Text'] . "</td></tr>";        
        $cOutput .= "<tr><td style='border:1px solid blue;'><label>Unit Price</label></td> <td style='border:1px solid blue;'>" . $ds['Order Price'] . "</td></tr>";
        $cOutput .= "<tr><td style='border:1px solid blue;'><label>Quantity</label></td> <td style='border:1px solid blue;'>" . $ds['Order Quantity'] . "</td></tr>";
        $cOutput .= "<tr><td style='border:1px solid blue;'><label>Amount</label></td> <td style='border:1px solid blue;'>" . $ds['Order Amount'] . "</td></tr>";
        $cOutput .= "<tr><td style='border:1px solid blue;'><label>Supplier Name</label></td> <td style='border:1px solid blue;'>" . $ds['Supplier_Name'] . "</td></tr>";
        $cOutput .= "<tr><td style='border:1px solid blue;'><label>Enter By</label></td> <td style='border:1px solid blue;'>" . $ds['Enter By'] . "</td></tr>";
        $cOutput .= "</table>";
        $cOutput .= "</div>";
    }
    echo $cOutput;
?>