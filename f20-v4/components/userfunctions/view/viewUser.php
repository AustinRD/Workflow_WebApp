<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Session Expired, Please sign in again.</p></div>";
        exit();
    }
    //User is not an admin or secretary.
    if(!($_SESSION['user_type'] == $GLOBALS['admin_type']) && !($_SESSION['user_type'] == $GLOBALS['secretary_type'])){
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! You do not have permission to access this information.</p></div>";
        exit();
    }
    //User Email was not sent to the page.
    if(!isset($_POST['UID'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No user recieved</p></div>";
        exit();
    }
    else {
        include_once('./backend/util.php');
        include_once('./backend/db_connector.php');

        //Gather data passed to this page.
        $UID = mysqli_real_escape_string($db_conn, $_POST['UID']);

        //User chooses to remove user.
        if(isset($_POST['remove'])) {
            $sql = "UPDATE f20_user_table SET USID = 3 WHERE `UID` = '$UID'";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Terminated User.</p></div>");
            } 
            else {
                echo("<div class='w3-panel w3-margin w3-red'><p>Error terminating user: " . $db_conn->error . "</p></div>");
            }
        }
        else if(isset($_POST['saveUserChanges'])) {
            //Gather all input form fields.
            $UID = mysqli_real_escape_string($db_conn, $_POST['UID']);
            $userRole = mysqli_real_escape_string($db_conn, $_POST['type']);
            $userStatus = mysqli_real_escape_string($db_conn, $_POST['status']);
            $userName = mysqli_real_escape_string($db_conn, $_POST['name']);
            $userEmail = mysqli_real_escape_string($db_conn, $_POST['userEmail']);
            $userPassword = mysqli_real_escape_string($db_conn, $_POST['password']);
                
            $sql = "UPDATE f20_user_table 
                        SET `URID` = $userRole,
                        `USID` = $userStatus,
                        `user_name` = '$userName',
                        `user_email` = '$userEmail',
                        `user_password` = '$userPassword'
                        WHERE `UID` = '$UID'";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Updated User.</p></div>");
            } 
            else {
                echo("<div class='w3-panel w3-margin w3-red'><p>Error updating user: " . $db_conn->error . "</p></div>");
            }
        }
        else {
            //Find all data related to the user.
            $sql = "SELECT * FROM f20_user_table
                        JOIN f20_user_role_table 
                            ON f20_user_table.URID = f20_user_role_table.URID
                        JOIN f20_user_status_table
                            ON f20_user_table.USID = f20_user_status_table.USID
                        WHERE `UID` = '$UID'";
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
        <button type="button" class="w3-button w3-red" name="removeUser" onclick="removeEntry('<?php echo $row['UID'] ?>')">Remove</button>
    </div>

    <h5>User:</h5>
    <form method="post" action="./dashboard.php?content=view&contentType=user">
        <input name="UID" id="UID" type="hidden" value="<?php echo $row['UID']; ?>">
        <label class="w3-input" for="name">Name</label>
        <input class="w3-input" id="name" name="name" type="text" value="<?php echo $row['user_name']; ?>" readonly>
        <label class="w3-input" for="userEmail">Email</label>
        <input class="w3-input" id="userEmail" name="userEmail" type="email" value="<?php echo $row['user_email']; ?>" readonly>
        <label class="w3-input" for="username">Username:</label>
        <input class="w3-input" id="username" name="username" type="text" value="<?php echo $row['user_login_name']; ?>" readonly>
        <label class="w3-input" for="password">Password:</label>
        <input class="w3-input" id="password" name="password" type="text" value="<?php echo $row['user_password']; ?>" readonly>
        <label class="w3-input" for="status">User Status</label>
        <select class="w3-input" id="status" name="status">
            <option value="<?php echo $row['USID']; ?>"><?php echo $row['user_status']; ?></option>
            <?php
                $sql = "SELECT * FROM f20_user_status_table";
                $query = mysqli_query($db_conn, $sql);
                while ($statusrow = mysqli_fetch_assoc($query)) {
                    echo("<option value='" . $statusrow['USID'] . "'>" . $statusrow['user_status'] . "</option>");
                }
            ?>
        </select>
        <label class="w3-input" for="type">User Type</label>
        <select class="w3-input" id="type" name="type" readonly>
            <option value="<?php echo $row['URID']; ?>"><?php echo $row['user_role_title']; ?></option>
            <?php
                $sql = "SELECT * FROM f20_user_role_table";
                $query = mysqli_query($db_conn, $sql);
                while ($rolerow = mysqli_fetch_assoc($query)) {
                    echo("<option value='" . $rolerow['URID'] . "'>" . $rolerow['user_role_title'] . "</option>");
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

<!-- Workflows -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <h5>Workflows:</h5>
    <form method="post" action="./dashboard?content=view&contentType=user">
    <?php
        $user_email = $_SESSION['user_email'];
        $sql = "SELECT * FROM f20_application_info WHERE student_email = '$user'";
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

                include('./components/userfunctions/workflowProgress.php');

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
            echo('<div class="w3-row w3-card-4 w3-margin w3-center w3-red">'
                    . '<p>No Workflows Found!</p></div>');
        }
    ?>
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
                    <input id="removeData" name="UID" type="hidden">
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