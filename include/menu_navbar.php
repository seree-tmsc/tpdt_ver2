<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img src="images/tmsc-logo-96x48.png" style="display: block;margin-left: auto;margin-right: auto;">
            <!--<img src="images/tmsc-logo-96x48.png" alt="user image" class="offline">-->
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="Main.php">
                        <span class="fa fa-home fa-lg" style="color:ForestGreen"></span>
                        Home
                    </a>
                </li>
            </ul>

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-cloud-upload fa-lg" style="color:blue"></span>
                        Uploading
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="Upload_COOIS_Criteria.php">
                                <span class="fa fa-cloud-upload" style="color:DeepSkyBlue"></span>
                                Upload Data from GSE [COOIS]
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-wrench fa-lg" style="color:blue"></span>
                        Maintaining
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="MA_PDLT.php">
                                <span class='fa fa-wrench' style="color:DeepSkyBlue"></span>
                                Maintaining Production Lead Time
                            </a>
                        </li>
                        <li class="divider">
                        <li>
                            <a href="PDSCH_B_Criteria.php">
                                <span class='fa fa-wrench' style="color:DeepSkyBlue"></span>
                                Rev. Basic Start Time [Rev. Planning Start Time]
                            </a>
                        </li>
                        <li>
                            <a href="PDSCH_A_Criteria.php">
                                <span class='fa fa-wrench' style="color:DeepSkyBlue"></span>
                                Rev. Actual Start Time
                            </a>
                        </li>
                        <li>
                            <a href="PDSCH_AF_Criteria.php">
                                <span class='fa fa-wrench' style="color:DeepSkyBlue"></span>
                                Rev. Actual Finish Time
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-area-chart fa-lg" style="color:blue"></span>
                        Monitoring
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="Graph_TPDT.php" target="_blank">
                                <span class='fa fa-area-chart' style="color:DeepSkyBlue"></span>
                                Traking Production Time Daily
                            </a>
                        </li>
                        <li>
                            <a href="Graph_TPDT_By_Month.php" target="_blank">
                                <span class='fa fa-area-chart' style="color:DeepSkyBlue"></span>
                                Traking Production Time Monthly
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-newspaper-o fa-lg" style="color:blue"></span>
                        Reporting & Graph
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="Print_ReportA.php">
                                <span class='fa fa-newspaper-o' style="color:DeepSkyBlue"></span>
                                Production Monthly Report
                            </a>
                        </li>
                        <li class="divider">
                        <li>
                            <a href="Report_01_criteria.php">
                                <span class='fa fa-newspaper-o' style="color:DeepSkyBlue"></span>
                                Detail of production order
                            </a>
                        </li>
                        <li class="divider">
                        <li>
                            <a href="Graph_EachMCapOfProductGroup.php">
                                <span class='fa fa-newspaper-o' style="color:DeepSkyBlue"></span>
                                Graph #1 Each month Capacity of product group
                            </a>
                        </li>

                    </ul>


                </li>
            </ul>

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-cog fa-spin fa-lg" style="color:blue"></span>
                        Setting
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="MA_User.php">
                                <span class='fa fa-users' style="color:DeepSkyBlue"></span>
                                Maintain User-ID
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo $user_picture ?>" style="margin-top: -10px; border-radius: 50%;">
                        Login as ... <?php //echo date('d / M / Y - H:i');
                                        ?>
                        <!--<br>-->
                        <?php echo $_SESSION["ses_email"]; ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" data-toggle="modal" data-target="#chgpasswordModal">
                                <span class='fa fa-pencil-square-o fa-lg' style="color:PeachPuff"></span>
                                Change Password
                            </a>
                        </li>
                        <li class="divider">
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#logoutModal">
                                <span class="fa fa-sign-out fa-lg" style="color:Crimson"></span>
                                logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>