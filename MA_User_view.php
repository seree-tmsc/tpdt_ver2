<?php
    $emp_Code = $_POST['id'];
    //echo $emp_Code;

    include('include/db_Conn.php');

    $strSql = "SELECT *, cast(user_pwd as varchar) as 'pwd' ";
    $strSql .= "FROM TPDT_MAS_Users_ID ";
    $strSql .= "WHERE emp_code ='" . $emp_Code . "' ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();
    
    $cOutput = "<div class='table-responsive'>";
    $cOutput .= "<table class='table table-bordered' style='background-color: Azure; color: navy; border:2px solid blue;'>";

    if ($nRecCount == 1)
    {
        $ds = $statement->fetch(PDO::FETCH_NAMED);
        $cOutput .= "<tr><td style='width:30%; border:1px solid blue;'><label>Code</label></td> <td style='border:1px solid blue;'>" . $ds['emp_code'] . "</td></tr>";
        $cOutput .= "<tr><td style='border:1px solid blue;'><label>e-Mail</label></td> <td style='border:1px solid blue;'>" . $ds['user_email'] . "</td></tr>";
        $cOutput .= "<tr><td style='border:1px solid blue;'><label>Password</label></td> <td style='border:1px solid blue;'>" . $ds['pwd'] . "</td></tr>";
        $cOutput .= "<tr><td style='border:1px solid blue;'><label>User Type</label></td> <td style='border:1px solid blue;'>" . $ds['user_type'] . "</td></tr>";
        $cOutput .= "<tr><td style='border:1px solid blue;'><label>My Team</label></td> <td style='border:1px solid blue;'>" . $ds['user_myteam'] . "</td></tr>";
        $cOutput .= "<tr><td style='border:1px solid blue;'><label>Created Date</label></td> <td style='border:1px solid blue;'>" . $ds['user_create_date'] . "</td></tr>";
        $cOutput .= "</table>";
        $cOutput .= "</div>";
    }
    echo $cOutput;
?>