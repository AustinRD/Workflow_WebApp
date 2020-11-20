<!-- This file displays the action panel and content header for the search page.
It is also responsible for changing the action bar based on the content selected. --> 

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <?php
        //Display the correct page title based on user type.
        //Display access denied if they don't have permission to view this page.
        if($_SESSION['user_type'] == $GLOBALS['admin_type']) {
            echo("<h5><b><i class='fa fa-search'></i>  Admin Search Tool</b></h5>");
        }
        else if($_SESSION['user_type'] == $GLOBALS['crc_type']) {
            echo("<h5><b><i class='fa fa-search'></i>  CRC Search Tool</b></h5>");
        }
        else if($_SESSION['user_type'] == $GLOBALS['recreg_type']) {
            echo("<h5><b><i class='fa fa-search'></i>  Rec-Reg Search Tool</b></h5>");
        }
        else if($_SESSION['user_type'] == $GLOBALS['dean_type']) {
            echo("<h5><b><i class='fa fa-search'></i>  Dean Search Tool</b></h5>");
        }
        else if($_SESSION['user_type'] == $GLOBALS['chair_type']) {
            echo("<h5><b><i class='fa fa-search'></i>  Chair Search Tool</b></h5>");
        }
        else if($_SESSION['user_type'] == $GLOBALS['secretary_type']) {
            echo("<h5><b><i class='fa fa-search'></i>  Secretary Search Tool</b></h5>");
        }
        else if($_SESSION['user_type'] == $GLOBALS['faculty_type']) {
            echo("<h5><b><i class='fa fa-search'></i>  Faculty Search Tool</b></h5>");
        }
        else{
            echo("<div class='w3-card w3-red w3-margin w3-padding'>You do not have access to this feature</div>");
            exit();
        }
    ?>
</header>


<?php 
    if(isset($_GET['contentType']) 
        && ($_GET['contentType'] == 'workflows'
        || $_GET['contentType'] == 'workflow' 
        || $_GET['contentType'] == 'workflowtemplate'
        || $_GET['contentType'] == 'workflowTemplate' 
        || $_GET['contentType'] == 'step'
        || $_GET['contentType'] == 'steps'
        || $_GET['contentType'] == 'steptemplates'
        || $_GET['contentType'] == 'stepTemplate')) {
?>
        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=search&contentType=workflows'">
                <div class="w3-container w3-blue w3-padding-16 w3-border">
                    <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                    <div class="w3-clear"><h5>Workflow</h5></div>
                </div>
            </div>

            <?php if($_SESSION['user_type'] == $GLOBALS['admin_type']) { ?>
            <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=search&contentType=workflowtemplate'">
                <div class="w3-container w3-blue w3-padding-16 w3-border ">
                    <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                    <div class="w3-clear"><h5>Workflow Template</h5></div>
                </div>
            </div>
            <?php } ?>

            <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=search&contentType=steps'">
                <div class="w3-container w3-blue w3-padding-16 w3-border">
                    <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                    <div class="w3-clear"><h5>Step</h5></div>
                </div>
            </div>

            <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=search&contentType=steptemplates'">
                <div class="w3-container w3-blue w3-padding-16 w3-border">
                    <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                    <div class="w3-clear"><h5>Step Template</h5></div>
                </div>
            </div>
        </div>
<?php
    }
    else {
?>
        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=search&contentType=workflows'">
                <div class="w3-container w3-blue w3-padding-16 w3-border">
                    <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                    <div class="w3-clear"><h5>Workflow</h5></div>
                </div>
            </div>

            <?php if($_SESSION['user_type'] == $GLOBALS['admin_type']) { ?>
            <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=search&contentType=department'">
                <div class="w3-container w3-blue w3-padding-16 w3-border ">
                    <div class="w3-left"><i class="fa fa-building w3-xxxlarge"></i></div>
                    <div class="w3-clear"><h5>Department</h5></div>
                </div>
            </div>
            <?php } ?>

            <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=search&contentType=course'">
                <div class="w3-container w3-blue w3-padding-16 w3-border">
                    <div class="w3-left"><i class="fa fa-book w3-xxxlarge"></i></div>
                    <div class="w3-clear"><h5>Course</h5></div>
                </div>
            </div>

            <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=search&contentType=user'">
                <div class="w3-container w3-blue w3-padding-16 w3-border">
                    <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                    <div class="w3-clear"><h5>User</h5></div>
                </div>
            </div>
        </div>
<?php

    }
?>