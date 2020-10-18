<?php
    //Resuming the session.
    if(!isset($_SESSION)) { 
        session_start(); 
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        header('Location: ./index.php');
    }
?>

<html>
<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Using w3.css for easy to use css framework -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <!-- Using font-awesome CDN for icons, if icons ever break update this link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- The workflows page requires the custom styles for the status bar -->
    <link rel="stylesheet" href="css/workflowProgress.css">
</head>
<style>
    html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>

<body class="w3-light-grey">
    <!-- Header Component -->
    <?php include_once('./components/header.php'); ?>
    <!-- Sidebar/Navigation Component -->
    <?php include_once('./components/sidebar.php'); ?>
    
    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
        <!-- A file that handles displaying the appropriate content 
            based on the user permission and get requests -->
        <?php include_once('./backend/contentRouter.php'); ?>

        <!-- Footer Component -->
        <?php include_once('./components/footer.php'); ?>
    </div>
    <!-- End page content -->
</body>
</html>