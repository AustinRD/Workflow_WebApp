<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Session Expired, Please sign in again.</p></div>";
        exit();
    }

    //Data ID was not sent to the page.
    if(!isset($_POST['dataID'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No data recieved</p></div>";
        exit();
    }
    else {
        include_once('./backend/util.php');
        include_once('./backend/db_connector.php');
	
	$dataID = mysqli_real_escape_string($db_conn, $_POST['dataID']);
	

        //Gather data passed to this page.
        $userEmail = mysqli_real_escape_string($db_conn, $_POST['dataID']);

        //User chooses to delete file.
        if(isset($_POST['remove'])) {
            $sql = "UPDATE f20_user_table SET USID = 3 WHERE user_email = '$userEmail'";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Terminated " . $userEmail . "</p></div>");
            } 
            else {
                echo("<div class='w3-panel w3-margin w3-red'><p>Error erasing data: " . $db_conn->error . "</p></div>");
            }
        }
        else if(isset($_POST['saveUserChanges'])) {
            //Gather all input form fields.
            $dataType = mysqli_real_escape_string($db_conn, $_POST['type']);
            $dataStatus = mysqli_real_escape_string($db_conn, $_POST['status']);
            $owner = mysqli_real_escape_string($db_conn, $_POST['name']);                
            $sql = "UPDATE f20_data_T 
                        SET `data_owner` = $owner,
                        `dataStatus_id` = $dataStatus,
                        `dataType_id` = '$dataType'
			JOIN f20_dataType_T 
                            ON f20_data_T.dataType_id = f20_dataType_T.dataType_id
                        JOIN f20_dataStatus_T
                            ON f20_data_T.dataStatus_id = f20_dataStatus_T.dataStatus_id
                        WHERE `data_owner` = '$owner'";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Updated " . $owner . "</p></div>");
            } 
            else {
                echo("<div class='w3-panel w3-margin w3-red'><p>Error updating data: " . $db_conn->error . "</p></div>");
            }
        }
        else {
            //Find all data related to the user.
            $sql = "SELECT * FROM f20_data_T JOIN f20_dataType_T ON f20_data_T.dataType_id = f20_dataType_T.dataType_id JOIN f20_dataStatus_T ON f20_data_T.dataStatus_id = f20_dataStatus_T.dataStatus_id WHERE data_id = '$dataID'";
            $query = mysqli_query($db_conn, $sql);
            $row = mysqli_fetch_assoc($query);
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-search"></i>  Admin View Tool</b></h5>
</header>

<!-- User Information -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <div class="w3-right" id="actionButtons">
        <button type="button" class="w3-button w3-blue" name="editUser" style="margin-right: 5px;" onclick="enableEdit()">Edit</button>
        <button type="button" class="w3-button w3-red" name="removeUser" onclick="removeEntry('<?php echo $userEmail ?>')">Remove</button>
    </div>

    <h5>File:</h5>
    <form method="post" action="./dashboard.php?content=view&contentType=user">
        <label class="w3-input" for="owner">Owner</label>
        <input class="w3-input" id="owner" name="name" type="text" value="<?php echo $row['data_owner']; ?>" readonly>
	<label class="w3-input" for="modifier">Data Modifier</label>
        <input class="w3-input" id="modifier" name="name" type="text" value="<?php echo $row['data_modifier']; ?>" readonly>
        <label class="w3-input" for="status">Data Status</label>
        <select class="w3-input" id="status" name="status">
            <option value="<?php echo $row['dataStatus_title']; ?>"><?php echo $row['dataStatus_title']; ?></option>
            <?php
                $sql = "SELECT * FROM f20_dataStatus_T";
                $query = mysqli_query($db_conn, $sql);
                while ($statusrow = mysqli_fetch_assoc($query)) {
                    echo("<option value='" . $statusrow['dataStatus_title'] . "'>" . $statusrow['dataStatus_title'] . "</option>");
                }
            ?>
        </select>
        <label class="w3-input" for="type">Data Type</label>
        <select class="w3-input" id="type" name="type" readonly>
            <option value="<?php echo $row['dataType_title']; ?>"><?php echo $row['dataType_title']; ?></option>
            <?php
                $sql = "SELECT * FROM f20_dataType_T";
                $query = mysqli_query($db_conn, $sql);
                while ($typerow = mysqli_fetch_assoc($query)) {
                    echo("<option value='" . $typerow['dataType_title'] . "'>" . $typerow['dataType_title'] . "</option>");
                }
            ?>
        </select>
        <br>
        <div id="editButtons" style="display: none;">
            <button type="submit" class="w3-button w3-blue" name="saveUserChanges">Save</button>
            <button type="button" class="w3-button w3-red" onclick="disableEdit()">Cancel</button>
        </div>
    </form>
</div>

<!-- Modal Pop-up to warn of deletion -->
<div id="warningHolder" class="w3-modal w3-center">
    <div class="w3-modal-content">
        <div class="w3-container w3-orange">
            <p>Warning!!</p>
            <p>'Removing' a user will terminate their account.</p>
            <p>Are you sure this is what you want to do?
                <br>
                <form method="post" action="./dashboard.php?content=view&contentType=user">
                    <input id="removeData" name="userEmail" type="hidden">
                    <button class="w3-button w3-red" type="submit" name="remove">Yes</button>
                    <button class="w3-button w3-black" type="button" onclick="document.getElementById('warningHolder').style.display='none'">No</button>
                </form>
            </p>
        </div>
    </div>
</div>

<!-- Remove from database Script -->
<script>
    function removeEntry(user)
    {
        //Display the warning modal.
        document.getElementById('warningHolder').style.display='block';
        //Replace hidden input data to prepare for if the user chooses to submit.
        document.getElementById('removeData').value = user;
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