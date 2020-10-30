<?php 
    //Including the action panel for navigation of the settings page.
    include_once('./components/userfunctions/settings/settings.php');

    //If the user has submitted the form to change the password.
    if(isset($_POST['changePassword'])) {
        //Gathering input from the forms.
        $userEmail = $_SESSION['user_email'];
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        

        //Make the connection to the database and send the update sql.
        include_once('./backend/db_connector.php');
        //Determine if the current password the user entered is correct.
        $sql = "SELECT * FROM f20_user_table WHERE user_email = '$userEmail' AND user_password = '$currentPassword'";
        $result = mysqli_query($db_conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            $sql = "UPDATE f20_user_table SET user_password = $newPassword WHERE user_email = '$userEmail' AND user_password = '$currentPassword'";
            if($db_conn -> query($sql) === TRUE) {
                echo("<div class='w3-card w3-margin w3-padding w3-green'>Password successfully changed.</div>");
            }
            else {
                echo("<div class='w3-card w3-margin w3-padding w3-red'>Error changing password. " . $db_conn->error . "</div>");
            }
            $db_conn->close();
        }
        else {
            echo("<div class='w3-card w3-margin w3-padding w3-red'>Current Password does not match entered Password, please try again.</div>");
        }
    }
?>

<!-- Change Password Form -->
<div class="w3-card-4 w3-padding w3-margin">
    <h5>Change Password</h5>
    <form method="post">
        <label class="w3-input" for="currentPassword">Current Password:</label>
        <input class="w3-input" name="currentPassword" type="password" required>
        <label class="w3-input" for="newPassword">New Password:</label>
        <input class="w3-input" name="newPassword" id="newPassword" type="password" required>
        <label class="w3-input" for="confirmPassword">Confirm New Password:</label>
        <input class="w3-input" name="confirmPassword" id="confirmPassword" type="password" onkeyup="comparePasswords();" required>
        <div class="w3-card w3-margin w3-padding w3-red" id="errorMessage" style="display: none;">
        </div>
        <br>
        <button class="w3-button w3-black" type="submit" name="changePassword" id="changePassword" disabled>Change</button>
    </form>
</div>

<script>
    function comparePasswords() {
        var newPassword = document.getElementById('newPassword').value;
        var confirmPassword = document.getElementById('confirmPassword').value;
        
        if(newPassword != confirmPassword) {
            document.getElementById('errorMessage').style.display = "block";
            document.getElementById('errorMessage').innerText = "Passwords do not match.";
            document.getElementById('changePassword').disabled = true;

        }
        else {
            document.getElementById('errorMessage').style.display = "none";
            document.getElementById('changePassword').disabled = false;
        }
    }
</script>