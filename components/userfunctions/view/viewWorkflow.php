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

        //User chose to remove entry.
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
        <button type="button" class="w3-button w3-blue" name="workflowCreate" style="margin-right: 5px;" onclick="enableEdit()">Edit</button>
        <button type="button" class="w3-button w3-red" name="workflowCreate" onclick="removeEntry('workflow', '<?php echo $workflow ?>')">Remove</button>
    </div>

    <h5>Workflow:</h5>
    <form method="post" action="./dashboard?content=view&contentType=workflow">
        <label for="wfID">Workflow ID:</label>
        <input id="wfID" name="wfID" type="text" class="w3-input" value="<?php echo $workflow; ?>" readonly>
        <br>
        <label for="type">Type</label>
        <input id="banner" name="banner" type="text" class="w3-input" value="<?php echo $row['project_name']; ?>" readonly>
        <br>
        <label for="initiator">Initiator:</label>
        <input id="initiator" name="initiator" type="email" class="w3-input" value="<?php echo $row['student_email']; ?>" readonly>
        <br>
        <label for="banner">Department:</label>
        <input id="banner" name="banner" type="text" class="w3-input" value="<?php echo $row['dept_code']; ?>" readonly>
        <br>
        <label for="type">Course:</label>
        <input id="banner" name="banner" type="text" class="w3-input" value="<?php echo $row['course_number']; ?>" readonly>
        <br>
        <label for="type">Semester:</label>
        <input id="banner" name="banner" type="text" class="w3-input" value="<?php echo $row['semester']; ?>" readonly>
        <br>
        <label for="type">Year:</label>
        <input id="banner" name="banner" type="text" class="w3-input" value="<?php echo $row['year']; ?>" readonly>
        <br>
        <div id="editButtons" style="display: none;">
            <button type="submit" class="w3-button w3-blue" name="workflowCreate">Save</button>
            <button type="button" class="w3-button w3-red" onclick="disableEdit()">Cancel</button>
        </div>
    </form>
</div>

<!-- Assigned Users -->


<!-- Modal Pop-up to warn of deletion -->
<div id="warningHolder" class="w3-modal w3-center">
    <div class="w3-modal-content">
        <div class="w3-container w3-red">
            <p>Warning!!</p>
            <p>A 'Remove' can not be undone!</p>
            <p>Are you sure?
                <br>
                <form method="post" action="./dashboard.php?content=view&contentType=workflow">
                    <input id="removeType" name="removeType" type="hidden">
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
    function removeEntry(entryType, entry)
    {
        //Display the warning modal.
        document.getElementById('warningHolder').style.display='block';
        //Replace hidden input data to prepare for if the user chooses to submit.
        document.getElementById('removeType').value = entryType;
        document.getElementById('removeData').value = entry;
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