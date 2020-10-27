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
        <div class="w3-right"><h3><?php echo $r;?></h3></div>
        <div class="w3-clear"><h5>Active</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&contentType=new'">
    <div class="w3-container w3-teal w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-bell w3-xxxlarge"></i></div>
        <div class="w3-right"><h3>1</h3></div>
        <div class="w3-clear"><h5>New</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&contentType=start'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
        <div class="w3-right"><h3>&nbsp;</h3></div>
        <div class="w3-clear"><h5>Start</h5></div>
    </div>
    </div>
</div>

<!-- Feed -->
<div class="w3-panel" id="activityFeed">
    <h5>Feed</h5>
    <table class="w3-table w3-striped w3-white">
        <tr>
        <td><i class="fa fa-share-alt w3-text-green w3-large"></i></td>
        <td>New workflow request from Jared Huberman.</td>
        <td><i>5 mins</i></td>
    </tr>
    <tr>
        <td><i class="fa fa-check w3-text-green w3-large"></i></td>
        <td>Transfer Credit Application Approved.</td>
        <td><i>10 mins</i></td>
    </tr>
    <tr>
        <td><i class="fa fa-exclamation-triangle w3-text-yellow w3-large"></i></td>
        <td>Fieldwork Application Needs Review.</td>
        <td><i>14 mins</i></td>
    </tr>
    <tr>
        <td><i class="fa fa-share-alt w3-text-green w3-large"></i></td>
        <td>New workflow request from Brandon Turner.</td>
        <td><i>20 mins</i></td>
    </tr>
    <tr>
        <td><i class="fa fa-times w3-text-red w3-large"></i></td>
        <td>Internship Application Denied.</td>
        <td><i>2 Days</i></td>
    </tr>
    </table>
</div>