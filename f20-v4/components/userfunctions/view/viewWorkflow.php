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
    if(!($_SESSION['user_type'] == $GLOBALS['admin_type'])){
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
        $workflowID = mysqli_real_escape_string($db_conn, $_POST['workflowID']);

        //User chooses to remove workflow.
        if(isset($_POST['remove'])) {
            $sql = "UPDATE f20_app_table SET ASID = 3 WHERE AID = '$workflowID'";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Removed " . $workflowID . "</p></div>");
            } 
            else {
                echo("<div class='w3-panel w3-margin w3-red'><p>Error removing record: " . $db_conn->error . "</p></div>");
            }
        }
        else {
            //Find all data related to the workflow.
            $sql = "SELECT * FROM f20_app_table
                        JOIN f20_app_type_table
                            ON f20_app_table.ATID = f20_app_type_table.ATID
                        JOIN f20_app_status_table
                            ON f20_app_table.ASID = f20_app_status_table.ASID
                        JOIN f20_user_table
                            ON f20_app_table.UID = f20_user_table.UID
                        WHERE f20_app_table.AID = '$workflowID'";
            $query = mysqli_query($db_conn, $sql);
            $row = mysqli_fetch_array($query);
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-search"></i>  Admin View Tool</b></h5>
</header>

<!-- Workflow Information -->
<div id="workflowForm" class="w3-card-4 w3-padding w3-margin">
    <div class="w3-right" id="actionButtons">
        <button type="button" class="w3-button w3-blue" name="editWorkflow" style="margin-right: 5px;" onclick="enableEdit()">Edit</button>
        <button type="button" class="w3-button w3-red" name="removeWorkflow" onclick="removeEntry('<?php echo $workflowID ?>')">Remove</button>
    </div>

    <h5>Workflow:</h5>
    <form method="post" action="./dashboard?content=view&contentType=workflow">
        <label for="workflowID" class="w3-input">Workflow ID:</label>
        <input id="workflowID" name="workflowID" type="text" class="w3-input" value="<?php echo $workflowID; ?>" readonly>
        <label for="workflowTitle" class="w3-input">Title:</label>
        <input id="workflowTitle" name="workflowTitle" type="text" class="w3-input" value="<?php echo $row['4']; ?>" readonly>
        <label for="initiator" class="w3-input">Initiator:</label>
        <input id="initiator" name="initiator" type="text" class="w3-input" value="<?php echo $row['user_name'] . " (" . $row['user_email'] . ")"; ?>" readonly>
        <label for="workflowPriority" class="w3-input">Priority:</label>
        <input id="workflowPriority" name="workflowPriority" type="text" class="w3-input" value="<?php echo $row['9']; ?>" readonly>
        <label for="status" class="w3-input">Status:</label>
        <input id="status" name="status" type="text" class="w3-input" value="<?php echo $row['title']; ?>" readonly>
        <label for="created" class="w3-input">Created:</label>
        <input id="created" name="created" type="text" class="w3-input" value="<?php echo $row['created']; ?>" readonly>
        <label for="deadline" class="w3-input">Deadline:</label>
        <input id="deadline" name="deadline" type="text" class="w3-input" value="<?php echo $row['deadline']; ?>" readonly>
        <br>
        <div id="editButtons" style="display: none;">
            <button type="submit" class="w3-button w3-blue" name="saveWorkflowChanges">Save</button>
            <button type="button" class="w3-button w3-red" onclick="disableEdit()">Cancel</button>
        </div>
    </form>
</div>

<!-- Order and status -->
<div class="w3-card-4 w3-padding w3-margin">
    <!-- Display Visualizer -->
    <h5>Order and Status:</h5>
    <?php
        //The instructions field comes from the app_table and determines what order the
        //participants recieve the workflow in.
        $order = $row['instructions'];
        $order = explode("=>", $order);
        for($i = 0; $i < sizeof($order); ++$i) {
            //When printing the workflow visualizer, the first thing to print is the skeleton.
            if($i == 0) {
    ?>
                <div class="circleList" id="circleList">
                    <div class="circle" id="participant<?php echo $i + 1; ?>"><strong><?php echo $i + 1; ?></strong></div>
                </div>
                <div class="labelList" id="labelList">
                    <div class="usertype"><?php echo $order[$i]; ?></div>
                </div>
    <?php
            }
            //For the remaining participants in the visualizer we expand using DOM and JS.
            else {
    ?>
            <script>
                document.getElementById('circleList').innerHTML += "<div class='line'></div><div class='circle' id='participant<?php echo $i + 1; ?>'><?php echo $i + 1; ?></div>";
                document.getElementById('labelList').innerHTML += "<div class='spacer'></div><div id='labelContainer' class='userType'><?php echo $order[$i]; ?></div>";
            </script>
    <?php
            }
        }
        $sql = "SELECT * FROM f20_app_details_table
                    JOIN f20_step_table
                        ON f20_app_details_table.SID = f20_step_table.SID
                    JOIN f20_user_table
                        ON f20_step_table.UID = f20_user_table.UID
                    WHERE AID = $workflowID";
        $query = mysqli_query($db_conn, $sql);
            
        while($row = mysqli_fetch_array($query)) {
            //If the step's status is 1 (Approved) then the visualizer for that step should be lawngreen.
            if($row['SSID'] == '1') {
                echo("<script>
                    document.getElementById('participant" . $row['step_order'] . "').style.backgroundColor = 'lawngreen';
                </script>");
            }
            //If the step's status is 2 (In-progress) then the visualizer for that step should be cyan.
            else if($row['SSID'] == '2') {
                echo("<script>
                    document.getElementById('participant" . $row['step_order'] . "').style.backgroundColor = 'cyan';
                </script>");
            }
            //If the step's status is 3 (Rejected) then the visualizer for that step should be red.
            else if($row['SSID'] == '3') {
                echo("<script>
                    document.getElementById('participant" . $row['step_order'] . "').style.backgroundColor = 'red';
                </script>");
            }
        }
    ?>
    <h5>Participants:</h5>
    <form>
    <?php 
        for($i = 0; $i < sizeof($order); ++$i) {
            echo("<label for='' class='w3-input'>" . $order[$i] . "</label>");
            echo("<input type='text' class='w3-input' readonly>");
        }
    ?>
    </form>
</div>


<!-- Modal Pop-up to warn of deletion -->
<div id="warningHolder" class="w3-modal w3-center">
    <div class="w3-modal-content">
        <div class="w3-container w3-orange">
            <p>Warning!!</p>
            <p>'Removing' a workflow will change its status to terminated!<br>A user with the appropriate permission will then need to restart the workflow.</p>
            <p>Are you sure?
                <br>
                <form method="post" action="./dashboard.php?content=view&contentType=workflow">
                    <input id="removeData" name="workflowID" type="hidden">
                    <button class="w3-button w3-red" type="submit" name="remove">Yes</button>
                    <button class="w3-button w3-black" type="button" onclick="document.getElementById('warningHolder').style.display='none'">No</button>
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