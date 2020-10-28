<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Session Expired, Please sign in again.</p></div>";
        exit();
    }
    //User is not an admin.
    if(!($_SESSION['user_type'] == 'admin')){
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! You do not have permission to access this information.</p></div>";
        exit();
    }
    //User returned to the page after submitting changes.
    if(isset($_POST['saveWorkflowChanges'])) {
        
    }
    //Workflow ID was not sent to the page.
    if(!isset($_POST['workflowID'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No workflow ID recieved</p></div>";
        exit();
    }
    
    else {
        include_once('./backend/util.php');
        include_once('./backend/db_connector.php');

        //Gather data passed to this page.
        $workflow = mysqli_real_escape_string($db_conn, $_POST['workflowID']);

        //User chooses to remove workflow.
        if(isset($_POST['remove'])) {
            $sql = "DELETE FROM f20_application_info WHERE fw_id = '$workflow'";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Removed " . $workflow . "</p></div>");
            } 
            else {
                echo("<div class='w3-panel w3-margin w3-red'><p>Error removing record: " . $db_conn->error . "</p></div>");
            }
        }
        else {
            //Find all data related to the workflow.
            $sql = "SELECT * FROM f20_application_info WHERE fw_id = '$workflow'";
            $query = mysqli_query($db_conn, $sql);
            $row = mysqli_fetch_assoc($query);
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-search"></i>  Admin View Tool</b></h5>
</header>

<!-- Workflow Information -->
<div id="workflowForm" class="w3-card-4 w3-padding w3-margin">
    <div class="w3-right" id="actionButtons">
        <button type="button" class="w3-button w3-blue" name="editWorkflow" style="margin-right: 5px;" onclick="enableEdit()">Edit</button>
        <button type="button" class="w3-button w3-red" name="removeWorkflow" onclick="removeEntry('<?php echo $workflow ?>')">Remove</button>
    </div>

    <h5>Workflow:</h5>
    <form method="post" action="./dashboard?content=view&contentType=workflow">
        <label for="wfID">Workflow ID:</label>
        <input id="wfID" name="wfID" type="text" class="w3-input" value="<?php echo $workflow; ?>" readonly>
        <br>
        <label for="workflowType">Type:</label>
        <input id="workflowType" name="workflowType" type="text" class="w3-input" value="<?php echo $row['project_name']; ?>" readonly>
        <br>
        <label for="initiator">Initiator:</label>
        <input id="initiator" name="initiator" type="email" class="w3-input" value="<?php echo $row['student_email']; ?>" readonly>
        <br>
        <label for="dept">Department:</label>
        <input id="dept" name="dept" type="text" class="w3-input" value="<?php echo $row['dept_code']; ?>" readonly>
        <br>
        <label for="course">Course:</label>
        <input id="course" name="course" type="text" class="w3-input" value="<?php echo $row['course_number']; ?>" readonly>
        <br>
        <label for="semester">Semester:</label>
        <input id="semester" name="semester" type="text" class="w3-input" value="<?php echo $row['semester']; ?>" readonly>
        <br>
        <label for="year">Year:</label>
        <input id="year" name="year" type="text" class="w3-input" value="<?php echo $row['year']; ?>" readonly>
        <br>
        <label for="credit">Credit:</label>
        <input id="credit" name="credit" type="text" class="w3-input" value="<?php echo $row['academic_credits']; ?>" readonly>
        <br>
        <label for="hours">Hours:</label>
        <input id="hours" name="hours" type="text" class="w3-input" value="<?php echo $row['hours_per_wk']; ?>" readonly>
        <br>
        <label for="grade">Grade Mode:</label>
        <input id="grade" name="grade" type="text" class="w3-input" value="<?php echo $row['grade_mode']; ?>" readonly>
        <br>
        <div id="editButtons" style="display: none;">
            <button type="submit" class="w3-button w3-blue" name="saveWorkflowChanges">Save</button>
            <button type="button" class="w3-button w3-red" onclick="disableEdit()">Cancel</button>
        </div>
    </form>
</div>

<!-- Assigned Users -->
<div class="w3-card-4 w3-padding w3-margin">
    <!-- Display user emails -->
    <h5>Assigned To:</h5>
    <label for="studentEmail">Student:</label>
    <input id="studentEmail" name="studentEmail" type="text" class="w3-input" value="<?php echo $row['student_email']; ?>" readonly>
    <br>
    <label for="instructorEmail">Instructor:</label>
    <input id="instructorEmail" name="instructorEmail" type="text" class="w3-input" value="<?php echo $row['instructor_email']; ?>" readonly>
    <br>
    <label for="deanEmail">Dean:</label>
    <input id="deanEmail" name="deanEmail" type="email" class="w3-input" value="" readonly>
    <br>
    <label for="chairEmail">Chair:</label>
    <input id="chairEmail" name="chairEmail" type="text" class="w3-input" value="" readonly>
    <br>
    <label for="secretaryEmail">Secretary:</label>
    <input id="secretaryEmail" name="secretaryEmail" type="text" class="w3-input" value="" readonly>
    <br>
    <label for="employerEmail">Employer:</label>
    <input id="employerEmail" name="employerEmail" type="text" class="w3-input" value="<?php echo $row['employer_email']; ?>" readonly>
    <br>
    <label for="crcEmail">CRC:</label>
    <input id="crcEmail" name="crcEmail" type="text" class="w3-input" value="" readonly>
    <br>
    <label for="recregEmail">Rec-Reg:</label>
    <input id="recregEmail" name="recregEmail" type="text" class="w3-input" value="" readonly>
    <br>
    <!-- Display Visualizer -->
    <h5>Order and Status:</h5>
</div>


<!-- Modal Pop-up to warn of deletion -->
<div id="warningHolder" class="w3-modal w3-center">
    <div class="w3-modal-content">
        <div class="w3-container w3-red">
            <p>Warning!!</p>
            <p>A 'Remove' can not be undone!</p>
            <p>Are you sure?
                <br>
                <form method="post" action="./dashboard.php?content=view&contentType=workflow">
                    <input id="removeData" name="workflowID" type="hidden">
                    <button type="submit" name="remove">Yes</button>
                    <button type="button" onclick="document.getElementById('warningHolder').style.display='none'">No</button>
                </form>
            </p>
        </div>
    </div>
</div>

<!-- Remove from database Script -->
<script>
    function removeEntry(workflow)
    {
        //Display the warning modal.
        document.getElementById('warningHolder').style.display='block';
        //Replace hidden input data to prepare for if the user chooses to submit.
        document.getElementById('removeData').value = workflow;
    }
</script>

<!-- Enable/Disable table editing Script -->
<script>
    function enableEdit()
    {
        //Disable readonly on inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=false;
        }
        //Hide the edit and remove buttons.
        document.getElementById("actionButtons").style.display = "none";
        //Show the save and cancel buttons.
        document.getElementById("editButtons").style.display = "inline-block";
    }
    function disableEdit()
    {
        //Re-enable readonly on all inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=true;
        }
        //Hide the save and cancel buttons.
        document.getElementById("editButtons").style.display = "none";
        //Show the edit and remove buttons.
        document.getElementById("actionButtons").style.display = "inline-block";
    }
</script>

<?php }
    }
?>