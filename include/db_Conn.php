<?php
    $srv = 'SEREE-PC17\TMSCSQLEXP1';
    $usr = 'sa';
    $pwd = 'password@1';
    $db = 'tpdt_webapp';
    $conn = new PDO("sqlsrv:server=$srv; Database=$db", $usr, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /*
    $srv = 'localhost';
    $db = 'pd_webapp';
    $usr = 'root';
    $pwd = '';    
    $conn = new PDO("mysql:host={$srv}; dbname={$db}", $usr, $pwd);    
    //$conn->exec("set names utf8");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    */
    
    $srv2 = 'SEREE-PC17\TMSCSQLEXP1';
    $usr2 = 'sa';
    $pwd2 = 'password@1';    
    $db2 = 'web_training';
    $conn2 = new PDO("sqlsrv:server=$srv2; Database=$db2", $usr2, $pwd2);
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
?>