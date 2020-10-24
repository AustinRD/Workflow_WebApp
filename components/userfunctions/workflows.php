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
    <div class="w3-quarter" onClick="openForm('startWF')">
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


<!-- Start Workflow -->
<div class="w3-card-4 w3-margin w3-padding" id="startWF" style="display:none;">
    <h5>Start Workflow</h5>

    <form method="get" action="./dashboard.php">
        <input type="hidden" name="content" value="workflows">
        <label for="workflowSelect">Workflow Type:</label>
        <!-- Populate the Select with the list of available workflows for this user -->
        <!-- Will be hardcoded until custom workflows are implemented -->
        <select name="workflowSelect" class="w3-input">
            <option value="internship">Internship/Fieldwork (General)</option>
            <option value="transferCred">Transfer Credit Evaluation (Not Implemented)</option>
        </select>
        <br>
        <button class="w3-button w3-teal" type="submit" name="startWorkflow">Start</button>
    </form>

    <!-- If the user selected and submitted a workflow to start -->
    <?php
        if(isset($_GET['startWorkflow'])) {
            if($_GET['workflowSelect'] == 'internship') {
    ?>
                <form method="post" action="./dashboard.php?content=workflows">
                    <label for="studentEmail">Student's Email</label>
                    <input type="email" name="studentEmail" class="w3-input">
                    <label for="course">Course</label>
                    <input type="text" name="course" class="w3-input">
                    <label for="semester">Semester</label>
                    <input type="text" name="semester" class="w3-input">
                    <label for="gradeMethod">Grade Method</label>
                    <select name="gradeMethod" class="w3-input">
                        <option value="">Letter Grades</option>
                        <option value="">Pass/Fail</option>
                    </select>
                    <br>
                    <button class="w3-button w3-teal" type="submit" name="startInternshipWF">Start</button>
                </form>
    <?php
            }
        }
    ?>

<!-- Hardcoded handler for starting the internship application. -->
<?php
    if (isset($_POST['startInternship'])) { //handles Application submit button
        $type = mysqli_real_escape_string($db_conn, $_POST['utype']);
        $sem = mysqli_real_escape_string($db_conn, $_POST['sem']);
        $grademode = mysqli_real_escape_string($db_conn, $_POST['gm']);
        $sem = explode(" ", $sem);
        $type = explode(" ", $type);
        $semester = $sem[0];
        $year = $sem[1];
        $dept = $type[0];
        $course = $type[1];

        $fwid = bin2hex(random_bytes(32));  //duplication is unlikely with this one. 1 in 20billion apparently
        $newappsql = "INSERT INTO f20_application_info(fw_id, dept_code, course_number, student_email, semester, year,grade_mode) VALUES ('$fwid','$dept', '$course','$appemail', '$semester', '$year', '$grademode');"; ///get department code
        $newutilsql = "INSERT INTO f20_application_util(fw_id, progress, rejected, assigned_to, assigned_when) VALUES ('$fwid', '-1', '0', 'student', 'CURRENT_TIMESTAMP');";
        $insql = mysqli_query($db_conn, $newappsql);
        if (mysqli_errno($db_conn) == 0) {
            $insql = mysqli_query($db_conn, $newutilsql);
            if (mysqli_errno($db_conn) == 0) {
                header('Location: ./createapplication.php?applicationsuccess=true');
            }
        }
    }
?>


</div>


<script>
function openForm(formID)
{
    closeForm('newWF');
    closeForm('activeWF');
    closeForm('startWF');
    document.getElementById(formID).style.display = "block";
}
function closeForm(formID)
{
    document.getElementById(formID).style.display = "none";
}
</script>