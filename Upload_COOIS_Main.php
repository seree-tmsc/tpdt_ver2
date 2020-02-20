<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php require_once("include/library.php"); ?>
</head>

<?php
include_once "function_For_Upload.php";
?>

<body>
    <div class="container">
        <br>
        <div class="panel panel-info">
            <div class="panel-heading">
                <?php echo "File name is " . $_FILES["param_fileCSV"]["name"]; ?>
                <?php echo "/ Data was uploaded by ... " . $_POST['param_email']; ?>
            </div>

            <div class="panel-body">
                <?php
                /*-----------------------------------------------------*/
                /* --- Process 1. upload csv file to server folder --- */
                /*-----------------------------------------------------*/
                $lPass = upload_to_server_folder();


                /*-------------------------------------------*/
                /* --- Process 2. check number of column --- */
                /*-------------------------------------------*/
                if ($lPass == true) {
                    $lPass = check_number_of_column(12);
                }


                /*------------------------------------------*/
                /* --- Process 3. check name of columnn --- */
                /*------------------------------------------*/
                if ($lPass == true) {
                    $lPass = check_name_of_column(array(
                        "order", "planning plant", "material number",
                        "material description", "batch", "mrp controller", "order type", "order quantity (gmein)",
                        "unit of measure (=gmein)", "basic start date", "basic finish date", "production version"
                    ));
                }


                /*---------------------------------*/
                /* --- Process 4. Vefiray data --- */
                /*---------------------------------*/
                if ($lPass == true) {
                    /*-- array 2 element / check field name 'material no' and field name 'batch' in DB --*/
                    $aVerifyField = array("pd_ord_no", "material_code", "batch");
                    /*-- array 2 element / check column 2 [material number] and column 4 [batch] in CSV file --*/
                    $aVerifyData = array(0, 2, 4,);
                    $cTableName = "trans_history_upload_coois";
                    $lPass = verify_data($aVerifyField, $aVerifyData, $cTableName);
                }


                /*--------------------------------*/
                /* --- Process 5. Upload data --- */
                /*--------------------------------*/
                if ($lPass == true) {
                    $lPass = upload_COOIS_to_database();
                }

                //print_r($lPass);

                if ($lPass[0] == false) {
                    if (sizeof($lPass[1]) > 0) {
                        echo sizeof($lPass[1]) . "<br>";
                        foreach ($lPass[1] as $key => $value) {
                            echo "ARRAY[" . $key . "] " . "MEMBER -1 =" . $value[0] . " / MEMBER -2 = " . $value[1] . "<br>";
                        }

                        $lPass = Insert_Trans_History_Upload_COOIS($lPass[1], $_POST['param_email']);
                    }
                } else {
                    $lPass = Insert_Trans_History_Upload_COOIS($lPass[1], $_POST['param_email']);
                }
                ?>
            </div>
        </div>

        <button type="submit" style="float: right; margin:2px;" class="btn btn-success" onclick="javascript:window.location.href='Main.php';return false;">
            Main Page
        </button>
    </div>
</body>

</html>