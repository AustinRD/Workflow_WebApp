<?php include_once('./components/userfunctions/settings/settings.php') ?>

<div class="w3-card-4 w3-padding w3-margin">
    <h5>My Account</h5>
    <form method="post">
        <label class="w3-input" for="userName">Full Name:</label>
        <input class="w3-input" type="text" value="<?php echo $_SESSION['user_name']; ?>"></input>
        <label class="w3-input" for="userEmail">Email</label>
        <input class="w3-input" type="text"></input>
    </form>
</div>