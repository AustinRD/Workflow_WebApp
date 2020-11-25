<?php
    //Connect database.
    include_once('./backend/db_connector.php');
    include_once('./backend/util.php');
    
    //The sql statement will need to be changed under the new database architecture.
    $user_email = $_SESSION['user_email'];
    $user_type = $_SESSION['user_type'];

    $sql = "SELECT * FROM f20_application_util WHERE assigned_to = '$user_type'";
    $qsql  = mysqli_query($db_conn, $sql);
    $r = mysqli_num_rows($qsql);

    /* Query to determine the number of active applications for this user.
    $user_email = $_SESSION['user_email'];
    $sql  = "SELECT * FROM f20_application_info WHERE student_email = '$user_email'";
    $qsql  = mysqli_query($db_conn, $sql);
    $r = mysqli_num_rows($qsql); */
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-share-alt"></i>  Workflow Dashboard</b></h5>
</header>

<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&contentType=active'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Active</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&contentType=new'">
    <div class="w3-container w3-teal w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-bell w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>New</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&contentType=completed'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-check w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Completed</h5></div>
    
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&contentType=start'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Start</h5></div>
    </div>
    </div>
</div>

<!-- Feed could go here when implemented to fill the content of the page -->