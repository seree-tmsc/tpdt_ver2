<?php
    date_default_timezone_set("Asia/Bangkok");
    
    session_start();
    if (!isset($_SESSION['ses_email']) or !isset($_SESSION['ses_user_type']) or !isset($_SESSION['ses_emp_code']) or !isset($_SESSION['ses_sbu']))
    {
        $user_emp_code = "";
        $user_email = "";
        $user_user_type = "";
        $user_picture = "";
        $user_sbu = "";
    }
    else
    {
        $user_emp_code = $_SESSION['ses_emp_code'];
        $user_email = $_SESSION['ses_email'];
        $user_user_type = $_SESSION['ses_user_type'];
        $user_picture = $_SESSION['ses_user_picture'];
        $user_sbu = $_SESSION['ses_sbu'];
    }
?>