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
        include_once('./backend/db_connector.php');
        //Get all user input.
        $workflowID = mysqli_real_escape_string($db_conn, $_POST['workflowID']);
        $title = mysqli_real_escape_string($db_conn, $_POST['workflowTitle']);
        $initiator = mysqli_real_escape_string($db_conn, $_POST['initiator']);
        $priority = mysqli_real_escape_string($db_conn, $_POST['priority']);
        $status = mysqli_real_escape_string($db_conn, $_POST['status']);
        $created = mysqli_real_escape_string($db_conn, $_POST['created']);
        $deadline = mysqli_real_escape_string($db_conn, $_POST['deadline']);

        $sql = "UPDATE f20_app_table 
                    SET ASID = $status,
                    ATID = '$priority',
                    `UID` = $initiator,
                    title = '$title',
                    created = '$created',
                    deadline = '$deadline'                     
                WHERE AID = $workflowID";
        if ($db_conn->query($sql) === TRUE) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Edited this Workflow.</p></div>");
        } 
        else {
            echo("<div class='w3-panel w3-margin w3-red'><p>Error updating the workflow: " . $db_conn->error . "</p></div>");
        }
    }
    //User chooses to remove workflow.
    if(isset($_POST['remove'])) {
        include_once('./backend/db_connector.php');
        $workflowID = mysqli_real_escape_string($db_conn, $_POST['workflowID']);

        $sql = "UPDATE f20_app_table SET ASID = 3 WHERE AID = '$workflowID'";
        if ($db_conn->query($sql) === TRUE) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Terminated this Workflow</p></div>");
        } 
        else {
            echo("<div class='w3-panel w3-margin w3-red'><p>Error removing record: " . $db_conn->error . "</p></div>");
        }
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

<br>

<!-- Workflow Information -->
<div id="workflowForm" class="w3-card-4 w3-padding w3-margin">
    <div class="w3-right" id="actionButtons">
        <button type="button" class="w3-button w3-blue" name="editWorkflow" style="margin-right: 5px;" onclick="enableEdit()">Edit</button>
        <button type="button" class="w3-button w3-red" name="removeWorkflow" onclick="removeEntry('<?php echo $workflowID ?>')">Remove</button>
    </div>

    <h5>Workflow:</h5>
    <form method="post" action="./dashboard.php?content=view&contentType=workflow">
        <!-- Workflow ID, never displayed to the user but here for when the user submits the form to edit or remove. -->
        <input id="workflowID" name="workflowID" type="hidden" class="w3-input" value="<?php echo $workflowID; ?>" readonly>

        <label for="workflowTitle" class="w3-input">Title:</label>
        <input id="workflowTitle" name="workflowTitle" type="text" class="w3-input" value="<?php echo $row['4']; ?>" readonly>

        <!-- A select field so the user can only choose to edit the workflow from the list of available options -->
        <label for="initiator" class="w3-input">Initiator:</label>
        <select name="initiator" id="initiator" class="w3-input" disabled>
            <option value="<?php echo $row['3']; ?>"><?php echo $row['user_name'] . " (" . $row['user_email'] . ")"; ?></option>
        </select>

        <!-- A select field so the user can only choose to edit the workflow from the list of available options -->
        <label for="priority" class="w3-input">Priority:</label>
        <select name="priority" id="priority" class="w3-input" disabled>
            <option value="<?php echo $row['2']; ?>"><?php echo $row['9']; ?></option>
            <?php
                $sql = "SELECT * FROM f20_app_type_table";
                $query = mysqli_query($db_conn, $sql);
                while($status = mysqli_fetch_array($query)) {
                    echo("<option value='" . $status['ATID'] . "'>" . $status['title'] . "</option>");
                };
            ?>
        </select>

        <!-- A select field so the user can only choose to edit the workflow from the list of available options -->
        <label for="status" class="w3-input">Status:</label>
        <select name="status" id="status" class="w3-input" disabled>
            <option value="<?php echo $row['1']; ?>"><?php echo $row['title']; ?></option>
            <?php
                $sql = "SELECT * FROM f20_app_status_table";
                $query = mysqli_query($db_conn, $sql);
                while($status = mysqli_fetch_array($query)) {
                    echo("<option value='" . $status['ASID'] . "'>" . $status['title'] . "</option>");
                };
            ?>
        </select>

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
    ?>
    <h5>Participants:</h5>
    <form>
    <?php 
        for($i = 0; $i < sizeof($order); ++$i) {
            echo("<label for='" . $order[$i] . "' class='w3-input'>" . $order[$i] . "</label>");
            echo("<input type='text' id='" . $order[$i] . $i . "' class='w3-input' readonly>");
        }
    ?>
    </form>
    <?php
        $sql = "SELECT * FROM f20_app_details_table
                    JOIN f20_step_table
                        ON f20_app_details_table.SID = f20_step_table.SID
                    JOIN f20_step_details_table
                        ON f20_step_table.SID = f20_step_details_table.SID
                    JOIN f20_user_table
                        ON f20_step_details_table.UID = f20_user_table.UID
                    WHERE AID = $workflowID";
        $query = mysqli_query($db_conn, $sql);
        
        //Changing the color of the step visualizer based on the status of each step.
        //And loading the participant information into their respective forms.
        $i=0;
        while($row = mysqli_fetch_array($query)) {    
            echo("<script>
                    document.getElementById('" . $order[$i] . $i . "').value='" . $row['user_name'] . " (" . $row['user_email'] . ")'
                </script>");
            $i++;

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
            inputs[i].disabled=false;
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

        //Disable the select fields.
        document.getElementById("status").disabled = true;
        document.getElementById("priority").disabled = true;

        //Hide the save and cancel buttons.
        document.getElementById("editButtons").style.display = "none";
        //Show the edit and remove buttons.
        document.getElementById("actionButtons").style.display = "inline-block";
    }
</script>

<?php 
    }
?>