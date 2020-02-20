<?php
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
        if($user_user_type == "A" or $user_user_type == "P")
        {
?>
        <!DOCTYPE html>
        <html>
            <head>                
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>TMSC TPDT System V.2</title>
                <link rel="icon" type="image/png"  href="images/tmsc-logo-64x32.png">

                <?php require_once("include/library.php"); ?>    
            </head>

            <body>
                <div class="container">      
                    <br>                    
                    <?php require_once("include/submenu_navbar.php"); ?>
                    <div style='width:600px'>
                    <h3 style="text-align:center; color:Tomato;">Each month Capacity of product group</h3>
                    <br>

                    <canvas id="myChart" ></canvas>
                    </div>
                    <script src="../Chart.js-2.9.3/dist/Chart.js"></script>
                    <script>
                        var ctx = document.getElementById('myChart').getContext('2d');

                        var stackedBar = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Jan-20', 'Feb-20', 'Mar-20', 'Apr-20', 'May-20', 'Jun-20', 'Jul-20', 'Aug-20', 'Sep-20', 'Oct-20', 'Nov-20', 'Dec-20'],
                                datasets: [{
                                    label: 'ACRYLAX',
                                    data: [1200, 1900, 3000, 500, 2000, 3500,2200],
                                    borderColor: '#66FFFF',
                                    backgroundColor: '#66FFFF',
                                    borderWidth: 1
                                },{
                                    label: 'VINYLAX',
                                    data: [1500, 1200, 500, 1000, 700, 800,1800],
                                    borderColor: '#66FF33',
                                    backgroundColor: '#66FF33'
                                },{
                                    label: 'WS',
                                    data: [1000, 900, 700, 1500, 900, 900,2500],
                                    borderColor: '#6699FF',
                                    backgroundColor: '#6699FF'
                                }]
                            },
                            options: {
                                scales: {
                                    xAxes: [{
                                        stacked: true   
                                    }],
                                    yAxes: [{
                                        stacked: true
                                    }]
                                }
                            }

            
                        });
                    </script>

                </div>

                <script>
                
                </script>
            </body>
        </html>
<?php
        }
        else
        {
            echo "<script> alert('You are not authorization for this menu ... Please contact your administrator'); window.location.href='pMain.php'; </script>";
        }
    }
?>