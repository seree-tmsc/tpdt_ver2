<?php
    //$emp_Code = $_POST['pd_ord_no'];    

    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM tpdt_trn_coois T ";
    $strSql .= "JOIN tpdt_mas_pd_data M ";
    $strSql .= "ON M.[pd_code] = T.[Material Number] ";
    $strSql .= "WHERE [Order] ='" . $_POST['pd_ord_no'] . "' ";
    //echo $strSql . "<br>";    

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();

    if ($nRecCount == 1)
    {
        $ds = $statement->fetch(PDO::FETCH_NAMED);
        echo json_encode($ds);
    }
?>