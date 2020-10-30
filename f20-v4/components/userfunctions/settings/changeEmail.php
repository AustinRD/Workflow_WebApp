<?php include_once('./components/userfunctions/settings/settings.php') ?>

<!-- Change Email form -->
<div class="w3-card-4 w3-padding w3-margin">
    <h5>Change Email</h5>
    <form method="post">
        <label class="w3-input" for="currentEmail">Current Email:</label>
        <input class="w3-input" name="currentEmail" type="email" value="<?php echo $_SESSION['user_email']; ?>">
        <label class="w3-input" for="newEmail">New Email:</label>
        <input class="w3-input" name="newEmail" type="email">
        <label class="w3-input" for="confirmEmail">Confirm New Email:</label>
        <input class="w3-input" name="confirmEmail" type="email">
        <br>
        <button class="w3-button w3-black">Save</button>
    </form>
</div>