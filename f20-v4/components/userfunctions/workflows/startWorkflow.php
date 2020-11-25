<?php
    //Loads the action bar so the user can navigate between pages.
    include_once('./components/userfunctions/workflows/workflows.php')
?>

<script>
    //Hides the currently hardcoded Feed from workflows.php
    document.getElementById('activityFeed').style.display = 'none';
</script>

<!-- If the user selected and submitted a workflow to start -->
<?php
    if(isset($_GET['startWorkflow'])) {
        if($_GET['workflowSelect'] == 'internship') {
            include_once('./steps/0000000001.php');
        }
    }

    else {
?>
        <!-- Start Workflow -->
        <div class="w3-card-4 w3-margin w3-padding">
            <h5>Start Workflow</h5>

            <form id="workflowSelectForm" method="get" action="./dashboard.php">
                <!-- These hidden input fields are needed to get the user back to this page. -->
                <input type="hidden" name="content" value="workflows">
                <input type="hidden" name="contentType" value="start">
                
                <!-- Populate the Select with the list of available workflows for this user -->
                <!-- Will be hardcoded until custom workflows are implemented -->
                <label for="workflowSelect">Workflow Type:</label>
                <select name="workflowSelect" class="w3-input">
                    <option value="internship">Internship/Fieldwork (General)</option>
                    <option value="transferCred">Transfer Credit Evaluation (Not Implemented)</option>
                </select>
                <br>
                <button class="w3-button w3-teal" type="submit" name="startWorkflow">Start</button>
            </form>
        </div>
<?php
    }
?>

