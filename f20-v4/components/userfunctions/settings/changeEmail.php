<?php 
    //Including the action panel for navigation of the settings page.
    include_once('./components/userfunctions/settings/settings.php');

    //If the user has submitted the form to change the email.
    if(isset($_POST['changeEmail'])) {
        //Gathering input from the forms.
        $currentEmail = $_POST['currentEmail'];
        $newEmail = $_POST['newEmail'];
        

        //Make the connection to the database and send the update sql.
        include_once('./backend/db_connector.php');
        //Determine if the current email the user entered is correct.
        $sql = "SELECT * FROM f20_user_table WHERE user_email = '$currentEmail'";
        $result = mysqli_query($db_conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            $sql = "UPDATE f20_user_table SET user_email = $newEmail WHERE user_email = '$currentEmail'";
            if($db_conn -> query($sql) === TRUE) {
                echo("<div class='w3-card w3-margin w3-padding w3-green'>Email successfully changed.</div>");
            }
            else {
                echo("<div class='w3-card w3-margin w3-padding w3-red'>Error changing email. " . $db_conn->error . "</div>");
            }
            $db_conn->close();
        }
        else {
            echo("<div class='w3-card w3-margin w3-padding w3-red'>Current Email not found, please check your input and try again.</div>");
        }
    }
?>

<!-- Change Email form -->
<div class="w3-card-4 w3-padding w3-margin">
    <h5>Change Email</h5>
    <form method="post">
        <label class="w3-input" for="currentEmail">Current Email:</label>
        <input class="w3-input" name="currentEmail" id="currentEmail" type="email" value="<?php echo $_SESSION['user_email']; ?>" readonly>
        <label class="w3-input" for="newEmail">New Email:</label>
        <input class="w3-input" name="newEmail" id="newEmail" type="email" required>
        <label class="w3-input" for="confirmEmail">Confirm New Email:</label>
        <input class="w3-input" name="confirmEmail" id="confirmEmail" type="email" onkeyup="compareEmails()" required>
        <div class="w3-card w3-margin w3-padding w3-red" id="errorMessage" style="display: none;">
        </div>
        <br>
        <button class="w3-button w3-black" type="submit" name="changeEmail" id="changeEmail" disabled>Change</button>
    </form>
</div>

<script>
    function compareEmails() {
        var newEmail = document.getElementById('newEmail').value;
        var confirmEmail = document.getElementById('confirmEmail').value;
        
        if(newEmail != confirmEmail) {
            document.getElementById('errorMessage').style.display = "block";
            document.getElementById('errorMessage').innerText = "Emails do not match.";
            document.getElementById('changeEmail').disabled = true;
        }
        else {
            document.getElementById('errorMessage').style.display = "none";
            document.getElementById('changeEmail').disabled = false;
        }
    }
</script>