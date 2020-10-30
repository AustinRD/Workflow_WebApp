<?php include_once('./components/userfunctions/settings/settings.php') ?>

<!-- Change Password Form -->
<div class="w3-card-4 w3-padding w3-margin">
    <h5>Change Password</h5>
    <form method="post">
        <label class="w3-input" for="currentPassword">Current Password:</label>
        <input class="w3-input" name="currentPassword" type="password">
        <label class="w3-input" for="newPassword">New Password:</label>
        <input class="w3-input" name="newPassword" type="password">
        <label class="w3-input" for="confirmPassword">Confirm New Password:</label>
        <input class="w3-input" name="confirmPassword" type="password">
        <br>
        <button class="w3-button w3-black">Save</button>
    </form>
</div>