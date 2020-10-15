<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        header('Location: ./index.php');
    }

    include_once('./backend/db_connector.php');
    include_once('./backend/util.php')
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-share-alt"></i>  Workflow Dashboard</b></h5>
</header>

<?php
    //Query to determine the number of active applications for this user.
    $user_email = $_SESSION['user_email'];
    $sql  = "SELECT * FROM f20_application_info WHERE student_email = '$user_email'";
    $qsql  = mysqli_query($db_conn, $sql);
    $r = mysqli_num_rows($qsql);
?>

<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" onClick="openForm('activeWF')">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right"><h3><?php echo $r;?></h3></div>
        <div class="w3-clear"><h5>Active</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onClick="openForm('newWF')">
    <div class="w3-container w3-teal w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-bell w3-xxxlarge"></i></div>
        <div class="w3-right"><h3>1</h3></div>
        <div class="w3-clear"><h5>New</h5></div>
    </div>
    </div>
    <div class="w3-quarter">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
        <div class="w3-right"><h3>&nbsp;</h3></div>
        <div class="w3-clear"><h5>Start</h5></div>
    </div>
    </div>
</div>

<!-- Feed -->
<div class="w3-panel">
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

<!-- Active Workflows -->
<div class="w3-container" id="activeWF" style="display:none;">
    <h5>Active Workflows</h5>
    <!-- Getting the current user's workflows from the database and printing them in a preview. -->
    <?php
        $user_email = $_SESSION['user_email'];
        $sql = "SELECT * FROM f20_application_info WHERE student_email = '$user_email'";
        $query = mysqli_query($db_conn, $sql);

        if ($query) {
            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                echo('<div class="w3-row w3-card-4 w3-margin">'
                        .'<div class="w3-quarter w3-border" style="height: 90px; padding-left: 10px;">'
                        . '<p>Type: '
                        . $row['project_name']
                        . '<br>Semester: '
                        . $row['semester'] . ' '
                        . $row['year'])
                        . '<br>Status: '
                        . 'Denied'
                        . '</p></div>';

                include('workflowProgress.php');

                echo('<div class="w3-quarter w3-center w3-padding-24 w3-border" style="height: 90px;">'
                        . '<form action="./dashboard.php?content=viewWorkflow" method="post" >'
                        . '<input type="hidden" name="wfID" value="'
                        . $row['fw_id']
                        . '"></input>'
                        . '<button class="w3-button w3-teal" type="submit">View</button>'
                        . '</div></div>');
            }
        }
        else {
            echo('<div class="w3-row w3-card-4 w3-margin">'
                    . '<p>No Workflows Found!</p></div>');
        }
    ?>
</div>

<!-- New Workflows -->
<div class="w3-container" id="newWF" style="display:none;">
    <h5>New Workflows</h5>
    <ul class="w3-ul w3-card-4 w3-white">
    <?php
        $user_email = $_SESSION['user_email'];
        $sql = "SELECT * FROM f20_application_info WHERE student_email = '$user_email'";
        $query = mysqli_query($db_conn, $sql);

        if ($query) {
            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                echo('<li class="w3-padding-16">Type: '
                        . $row['project_name']
                    . '</li>');
            }
        }
        else {
            echo('<li class="w3-padding-16">
                <span class="w3-xlarge">No workflows found.</span>
            </li>');
        }
    ?>
    </ul>
</div>

<script>
function openForm(formID)
{
    closeForm('newWF');
    closeForm('activeWF');
    document.getElementById(formID).style.display = "block";
}
function closeForm(formID)
{
    document.getElementById(formID).style.display = "none";
}
</script>