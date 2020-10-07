<?php
  //Starting a session.
  if(!isset($_SESSION)) {
    session_start();
  }
  if(!isset($_SESSION['user_type'])){
    header("Location: ./index.php");
  }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Settings</title>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>

<body class="w3-light-grey">
    <?php include_once('./components/header.php'); ?>
    <?php include_once('./components/sidebar.php'); ?>
    
    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
        <hr>
        <!-- Settings container -->
        <div class="w3-container w3-center w3-card-4 w3-light-grey w3-margin">
            <h2 class="w3-center"><b><i class="fa fa-cog"></i>  Settings</b></h2>
            <p class="w3-bar">
                <button class="w3-button w3-black w3-round-xlarge"><i class="fa fa-user w3-xxlarge"></i><br>My<br>Account</button>
                <button class="w3-button w3-black w3-round-xlarge" onClick="openForm('changePassword')"><i class="fa fa-user w3-xxlarge"> </i><br>Change<br>Password</button>
                <button class="w3-button w3-black w3-round-xlarge" onClick="openForm('changeEmail')"><i class="fa fa-user w3-xxlarge"></i><br>Change<br>Email</button>
                <button class="w3-button w3-black w3-round-xlarge"><i class="fa fa-cog w3-xxlarge"></i><br>Other</button>
            </p>
        </div>

        <center>
        <!-- My Account Form -->
        <div id="myAccount" style="display:none;">
            <h4 class="w3-center"><b><i class="fa fa-cog"></i>  My Account</b></h2>
            <hr>
            <form class="w3-padding w3-display-middle w3-light-grey w3-round-xlarge" method="post">
                <!-- Name -->
                <!-- First Name -->
                <div class="w3-row w3-section">
                    <div class="w3-half"><label>First Name:<label></div>
                    <div class="w3-half"><input class="w3-input w3-border" name="currentPassword" type="password"></div>
                </div>

                <!-- Middle Inital -->
                <div class="w3-row w3-section">
                    <div class="w3-half"><label>Middle Initial:<label></div>
                    <div class="w3-half"><input class="w3-input w3-border" name="newPassword" type="password"></div>
                </div>

                <!-- Last Name -->
                <div class="w3-row w3-section">
                    <div class="w3-half"><label>Last Name:<label></div>
                    <div class="w3-half"><input class="w3-input w3-border" name="confirmPassword" type="password"></div>
                </div>

                <!-- Contact Information -->
                <!-- Phone Number -->
                <div class="w3-row w3-section">
                    <div class="w3-half"><label>Last Name:<label></div>
                    <div class="w3-half"><input class="w3-input w3-border" name="confirmPassword" type="password"></div>
                </div>

                <!-- Address -->
                <div class="w3-row w3-section">
                    <div class="w3-half"><label>Last Name:<label></div>
                    <div class="w3-half"><input class="w3-input w3-border" name="confirmPassword" type="password"></div>
                </div>

                <p class="w3-center">
                    <button class="w3-btn w3-section w3-black w3-ripple">Save</button>
                    <button class="w3-btn w3-section w3-black w3-ripple" type="button" onClick="closeForm('changePassword')">Cancel</button>
                </p>
            </form>
        </div>

        <!-- Change Password Form -->
        <div id="changePassword" style="display:none;">
            <form class="w3-card-4 w3-light-grey w3-round-large w3-margin w3-padding" method="post" style="width:100%; max-width: 330px;">
                <h4 class="w3-center"><b><i class="fa fa-cog"></i>  Change Password</b></h2>
                <!-- Current Password -->
                <div class="w3-row w3-section">
                    <label class="w3-left">Current Password:</label>
                    <input class="w3-input w3-border" name="currentPassword" type="password">
                </div>

                <!-- New Password -->
                <div class="w3-row w3-section">
                    <label class="w3-left">New Password:</label>
                    <input class="w3-input w3-border" name="newPassword" type="password">
                </div>

                <!-- Confirm New Password -->
                <div class="w3-row w3-section">
                    <label class="w3-left">Confirm New Password:</label>
                    <input class="w3-input w3-border" name="confirmPassword" type="password">
                </div>

                <p class="w3-center">
                    <button class="w3-btn w3-section w3-black w3-ripple">Save</button>
                    <button class="w3-btn w3-section w3-black w3-ripple" type="button" onClick="closeForm('changePassword')">Cancel</button>
                </p>
            </form>
        </div>

        <!-- Change Email form -->
        <div id="changeEmail" style="display: none;">
            <form class="w3-card-4 w3-light-grey w3-round-large w3-margin w3-padding" method="post" style="width:100%; max-width: 330px;">
                <h4 class="w3-center"><b><i class="fa fa-cog"></i>  Change Email</b></h2>
                <!-- Current Email -->
                <div class="w3-row w3-section">
                    <label>Current Email:</label>
                    <input class="w3-input w3-border" name="currentEmail" type="email">
                </div>

                <!-- New Email -->
                <div class="w3-row w3-section">
                    <label>New Email:</label>
                    <input class="w3-input w3-border" name="newEmail" type="email">
                </div>

                <!-- Confirm New Email -->
                <div class="w3-row w3-section">
                    <label>Confirm New Email:</label>
                    <input class="w3-input w3-border" name="confirmEmail" type="email">
                </div>

                <p class="w3-center">
                    <button class="w3-btn w3-section w3-black w3-ripple">Save</button>
                    <button class="w3-btn w3-section w3-black w3-ripple" type="button" onClick="closeForm('changeEmail')">Cancel</button>
                </p>
            </form>
        </div>

        <?php include_once('./components/footer.php'); ?>
    </div>
    <!-- End page content -->
</body>
</html>

<script>
function openForm(formName)
{
    //Hiding opened forms/settings buttons before opening selected.
    closeForm("changeEmail");
    closeForm("changePassword");

    //Opening selected button/form.
    document.getElementById(formName).style.display = "block";
}
function closeForm(formName)
{
    document.getElementById(formName).style.display = "none";
}
</script>