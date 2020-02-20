<?php
    include_once('include/chk_Session.php');
    if (isset($_POST['btn_submit']))
    {        
        try
        {
            require_once('include/db_Conn.php');
            //$conn = new PDO("sqlsrv:server=$srv; Database=$db", $usr, $pwd);
            //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $strSql = "SELECT * ";
            $strSql .= "FROM TPDT_MAS_Users_ID ";
            $strSql .= "WHERE user_email='" . $user_email . "' ";
            //echo $strSql."<br>";
            
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
            $statement->execute();  
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";

            if ($nRecCount == 1)
            {
                $ds = $statement->fetch(PDO::FETCH_NAMED);
                
                echo trim(base64_decode($ds['user_pwd'])) . "<br>";
                echo trim($_POST['param_curpwd']) . "<br>";
                

                if (trim(base64_decode($ds['user_pwd'])) == trim($_POST['param_curpwd']))
                {
                    if ( trim($_POST['param_newpwd']) == trim($_POST['param_confnewpwd']) )
                    {
                        $strSql = "UPDATE TPDT_MAS_Users_ID SET ";
                        $strSql .= "user_pwd = '" . base64_encode( $_POST['param_newpwd']) . "' ";
                        $strSql .= "WHERE user_email='" . $user_email . "' ";
                        //echo $strSql."<br>";
                        
                        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
                        $statement->execute();  
                        $nRecCount = $statement->rowCount();

                        if ($nRecCount == 1)
                        {
                            echo "<script>
                                    alert('Change password complete!');
                                    window.location.href='pMain.php';
                                </script>";
                        }
                        else
                        {
                            echo "<script>
                                    alert('Error... Cannot update!');                            
                                </script>";                                
                        }
                    }
                    else
                    {
                        echo "<script>
                                alert('Error... New Password not macth!');
                                window.location.href='pMain.php';
                            </script>";    
                    }
                }
                else
                {
                    echo "<script>
                            alert('Error... Current Password not correct!');
                            window.location.href='pMain.php';
                        </script>";
                }
            }
            else
            {
                echo "<script>
                        alert('Error... Data not sound!');
                        window.location.href='pMain.php';
                    </script>";
            }

        }
        catch(PDOException $e)
        {
            echo "<script> 
                    alert('Error!" . substr($e->getMessage(),70,105) . " '); 
                    window.location.href='pMain.php';
                </script>";
        }
    }
    /*
    else
    {        
        header("Location: hris_main.php");
    }
    */
?>