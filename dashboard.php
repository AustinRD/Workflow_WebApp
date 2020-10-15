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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- The workflows page requires the custom styles for the status bar -->
    <link rel="stylesheet" href="css/workflowProgress.css">
</head>
<style>
    html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>

<body class="w3-light-grey">
    <?php include_once('./components/header.php'); ?>
    <?php include_once('./components/sidebar.php'); ?>
    
    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
    <?php
        if($_GET['content'] == "home")
        {
            include_once('./backend/config.php');
            switch ($_SESSION['user_type']) {
                case $GLOBALS['student_type']:
                    include_once("./components/dashboard/student.php");
                    break;
                case $GLOBALS['admin_type']:
                    include_once("./components/dashboard/admin.php");
                    break;
                case $GLOBALS['secretary_type']:
                    include_once("./components/dashboard/secretary.php");
                    break;
                case $GLOBALS['chair_type']:
                    include_once("./components/dashboard/chair.php");
                    break;
                case $GLOBALS['dean_type']:
                    include_once("./components/dashboard/dean.php");
                    break;
                case $GLOBALS['instructor_type']:
                    include_once("./components/dashboard/instructor.php");
                    break;
                case $GLOBALS['employer_type']:
                    include_once("./components/dashboard/employer.php");
                    break;
                case $GLOBALS['recreg_type']:
                    include_once("./components/dashboard/recreg.php");
                    break;
            }
        }
        else if($_GET['content'] == "search")
        {
            include_once("./components/userfunctions/search.php");
        }
        else if($_GET['content'] == "create")
        {
            include_once("./components/userfunctions/create.php");
        }
        else if($_GET['content'] == "messages")
        {
            include_once("./components/userfunctions/messages.php");
        }
        else if($_GET['content'] == "workflows")
        {
            include_once("./components/userfunctions/workflows.php");
        }
        else if($_GET['content'] == "view")
        {
            if($_GET['contentType'] == "user")
            {
                include_once("./components/userfunctions/view/viewUser.php");
            }
            if($_GET['contentType'] == "workflow")
            {
                include_once("./components/userfunctions/view/viewWorkflow.php");
            }
            if($_GET['contentType'] == "department")
            {
                include_once("./components/userfunctions/view/viewDepartment.php");
            }
            if($_GET['contentType'] == "course")
            {
                include_once("./components/userfunctions/view/viewCourse.php");
            }
        }
        else if($_GET['content'] == "viewWorkflow")
        {
            include_once("./components/userfunctions/viewWorkflow.php");
        }
    ?>
        <?php include_once('./components/footer.php'); ?>
    </div>
    <!-- End page content -->
</body>
</html>