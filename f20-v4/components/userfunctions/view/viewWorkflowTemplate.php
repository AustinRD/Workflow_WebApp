<?php
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/search/search.php');
    
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
    if(isset($_POST['saveTemplateChanges'])) {
        include_once('./backend/db_connector.php');
        //Get all user input.
        $templateID = mysqli_real_escape_string($db_conn, $_POST['templateID']);
        $title = mysqli_real_escape_string($db_conn, $_POST['templateTitle']);
        $status = mysqli_real_escape_string($db_conn, $_POST['status']);

        $sql = "UPDATE f20_app_template_table 
                    SET TSID = '$status',
                    title = '$title'                     
                WHERE ATPID = '$templateID'";

        if ($db_conn->query($sql) === TRUE) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Edited this Workflow.</p></div>");
        } 
        else {
            echo("<div class='w3-panel w3-margin w3-red'><p>Error updating the workflow: " . $db_conn->error . "</p></div>");
        }
    }
    //User chooses to remove workflow template.
    if(isset($_POST['remove'])) {
        include_once('./backend/db_connector.php');
        $templateID = mysqli_real_escape_string($db_conn, $_POST['templateID']);

        $sql = "UPDATE f20_app_template_table SET TSID = 3 WHERE ATPID = '$templateID'";
        if ($db_conn->query($sql) === TRUE) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Deleted this Template.</p></div>");
        } 
        else {
            echo("<div class='w3-panel w3-margin w3-red'><p>Error removing this template: " . $db_conn->error . "</p></div>");
        }
    }
    //Workflow Template ID was not sent to the page.
    if(!isset($_POST['templateID'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No workflow template ID recieved</p></div>";
        exit();
    }
    else {
        include_once('./backend/util.php');
        include_once('./backend/db_connector.php');

        //Gather data passed to this page.
        $templateID = mysqli_real_escape_string($db_conn, $_POST['templateID']);
        
        //Find all data related to the workflow template.
        $sql = "SELECT * FROM f20_app_template_table
                    JOIN f20_template_status_table
                        ON f20_app_template_table.TSID = f20_template_status_table.TSID
                    WHERE f20_app_template_table.ATPID = '$templateID'";
        $query = mysqli_query($db_conn, $sql);
        $row = mysqli_fetch_array($query);
?>

<!-- Workflow Information -->
<div id="workflowForm" class="w3-card-4 w3-padding w3-margin">
    <div class="w3-right" id="actionButtons">
        <button type="button" class="w3-button w3-blue" name="editWorkflow" style="margin-right: 5px;" onclick="enableEdit()">Edit</button>
        <button type="button" class="w3-button w3-red" name="removeWorkflow" onclick="removeEntry('<?php echo $templateID ?>')">Remove</button>
    </div>

    <h5>Workflow Template:</h5>
    <form method="post" action="./dashboard.php?content=view&contentType=workflowTemplate">
        <input id="templateID" name="templateID" type="hidden" class="w3-input" value="<?php echo $templateID; ?>" readonly>

        <label for="templateTitle" class="w3-input">Template Title:</label>
        <input id="templateTitle" name="templateTitle" type="text" class="w3-input" value="<?php echo $row['2']; ?>" readonly>
        
        <!-- A select field so the user can only choose to edit the workflow from the list of available options -->
        <label for="status" class="w3-input">Status:</label>
        <select name="status" id="status" class="w3-input" disabled>
            <option value="<?php echo $row['1']; ?>"><?php echo $row['title']; ?></option>
            <?php
                $sql = "SELECT * FROM f20_template_status_table";
                $query = mysqli_query($db_conn, $sql);
                while($status = mysqli_fetch_array($query)) {
                    echo("<option value='" . $status['TSID'] . "'>" . $status['title'] . "</option>");
                };
            ?>
        </select>

        <br>
        <div id="editButtons" style="display: none;">
            <button type="submit" class="w3-button w3-blue" name="saveTemplateChanges">Save</button>
            <button type="button" class="w3-button w3-red" onclick="disableEdit()">Cancel</button>
        </div>
    </form>
</div>

<!-- Order and status -->
<div class="w3-card-4 w3-padding w3-margin">
    <!-- Display Visualizer -->
    <h5>Step Order:</h5>
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
    <div>
        <br>
        <!-- Link for the Add step button should take the user to the page for creating steps. -->
        <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='.'">Add Step</button>
        <h5>Step Templates:</h5>
        <br>
        <table id="workflowTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
            <tr>
                <th>Step Number</th>
                <th>Title</th>
                <th>File</th>
                <th>Action</th>
            </tr>
            <?php
                $sql = "SELECT * FROM f20_app_template_details_table 
                            JOIN f20_step_template_table
                                ON f20_app_template_details_table.STPID = f20_step_template_table.STPID
                        WHERE ATPID = $templateID";
                $query = mysqli_query($db_conn, $sql);
                
                while ($row = mysqli_fetch_array($query)) {
                    $stepTemplateID = $row['STPID'];
                    $stepNumber = $row['step_order'];
                    $title = $row['title'];
                    $file = $row['location'];
            ?>
            <tr>
                <td><?php echo $stepNumber; ?></td>
                <td><?php echo $title; ?></td>
                <td><?php echo $file; ?></td>
                <td>
                    <form method="post" action="./dashboard.php?content=view&contentType=stepTemplate">
                        <input type="hidden" name="stepTemplateID" value="<?php echo $stepTemplateID;?>">
                        <button type="submit" name="viewStepTemplate" class="w3-button w3-blue">View</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<!-- Modal Pop-up to warn of deletion -->
<div id="warningHolder" class="w3-modal w3-center">
    <div class="w3-modal-content">
        <div class="w3-container w3-orange">
            <p>Warning!!</p>
            <p>'Removing' a workflow template will change its status to deleted!<br>A user with the appropriate permission will then need to reactivate the workflow template.</p>
            <p>Are you sure?
                <br>
                <form method="post" action="./dashboard.php?content=view&contentType=workflowTemplate">
                    <input id="removeData" name="templateID" type="hidden">
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

        //Hide the save and cancel buttons.
        document.getElementById("editButtons").style.display = "none";
        //Show the edit and remove buttons.
        document.getElementById("actionButtons").style.display = "inline-block";
    }
</script>

<?php
    }
?>