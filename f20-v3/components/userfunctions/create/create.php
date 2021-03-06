<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <?php 
        if($_SESSION['user_type'] == 'admin') {
            echo("<h5><b><i class='fa fa-plus'></i>  Admin Create Tool</b></h5>");
        }
        else if($_SESSION['user_type'] == 'crc') {
            echo("<h5><b><i class='fa fa-plus'></i>  CRC Create Tool</b></h5>");
        }
        else if($_SESSION['user_type'] == 'recreg') {
            echo("<h5><b><i class='fa fa-plus'></i>  Rec-Reg Create Tool</b></h5>");
        }
        else if($_SESSION['user_type'] == 'dean') {
            echo("<h5><b><i class='fa fa-plus'></i>  Dean Create Tool</b></h5>");
        }
        else if($_SESSION['user_type'] == 'chair') {
            echo("<h5><b><i class='fa fa-plus'></i>  Chair Create Tool</b></h5>");
        }
        else if($_SESSION['user_type'] == 'secretary') {
            echo("<h5><b><i class='fa fa-plus'></i>  Secretary Create Tool</b></h5>");
        }
        else if($_SESSION['user_type'] == 'faculty') {
            echo("<h5><b><i class='fa fa-plus'></i>  Faculty Create Tool</b></h5>");
        }
        else{
            echo("<div class='w3-card w3-red w3-margin w3-padding'>You do not have access to this feature</div>");
            exit();
        }
    ?>
</header>

<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=create&contentType=workflow'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Workflow</h5></div>
    </div>
    </div>

    <!-- Department Creation only available to Admin -->
    <?php if($_SESSION['user_type'] == 'admin') { ?>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=create&contentType=department'">
    <div class="w3-container w3-teal w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-building w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Department</h5></div>
    </div>
    </div>
    <?php } ?>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=create&contentType=course'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-book w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Course</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=create&contentType=user'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>User</h5></div>
    </div>
    </div>
</div>