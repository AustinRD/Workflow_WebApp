<!-- File for redirection to the appropriate content based on get requests. -->
<?php
    //If the content requested is the home/dashboard.
    if($_GET['content'] == "home") {
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
            case $GLOBALS['faculty_type']:
                include_once("./components/dashboard/faculty.php");
                break;
            case $GLOBALS['employer_type']:
                include_once("./components/dashboard/employer.php");
                break;
            case $GLOBALS['recreg_type']:
                include_once("./components/dashboard/recreg.php");
                break;
            case $GLOBALS['crc_type']:
                include_once("./components/dashboard/crc.php");
                break;
        }
    }
    //If the content requested is the search page.
    else if($_GET['content'] == "search") {
        //If the user requested the a specific section of the search page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "user") {
                include_once("./components/userfunctions/search/searchUser.php");
            }
            if($_GET['contentType'] == "workflow") {
                include_once("./components/userfunctions/search/searchWorkflow.php");
            }
            if($_GET['contentType'] == "department") {
                include_once("./components/userfunctions/search/searchDepartment.php");
            }
            if($_GET['contentType'] == "course") {
                include_once("./components/userfunctions/search/searchCourse.php");
            }
        }
        else {
            include_once("./components/userfunctions/search/search.php");
        }
    }
    //If the content requested is the create page.
    else if($_GET['content'] == "create") {
        //If the user requested the a specific section of the create page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "user") {
                include_once("./components/userfunctions/create/createUser.php");
            }
            if($_GET['contentType'] == "workflow") {
                include_once("./components/userfunctions/create/createWorkflow.php");
            }
            if($_GET['contentType'] == "department") {
                include_once("./components/userfunctions/create/createDepartment.php");
            }
            if($_GET['contentType'] == "course") {
                include_once("./components/userfunctions/create/createCourse.php");
            }
        }
        else {
            include_once("./components/userfunctions/create/create.php");
        }
    }
    else if($_GET['content'] == "messages") {
        include_once("./components/userfunctions/messages.php");
    }
    //If the content requested is the workflows page.
    else if($_GET['content'] == "workflows") {
        //If the user requested the a specific section of the workflows page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "active") {
                include_once("./components/userfunctions/workflows/activeWorkflows.php");
            }
            if($_GET['contentType'] == "new") {
                include_once("./components/userfunctions/workflows/newWorkflows.php");
            }
            if($_GET['contentType'] == "start") {
                include_once("./components/userfunctions/workflows/startWorkflow.php");
            }
        }
        else {
            include_once("./components/userfunctions/workflows/workflows.php");
        }
    }
    //If the content requested is the view page.
    else if($_GET['content'] == "view") {
        //If the user requested the a specific section of the view page.
        if($_GET['contentType'] == "user") {
            include_once("./components/userfunctions/view/viewUser.php");
        }
        if($_GET['contentType'] == "workflow") {
            include_once("./components/userfunctions/view/viewWorkflow.php");
        }
        if($_GET['contentType'] == "department") {
            include_once("./components/userfunctions/view/viewDepartment.php");
        }
        if($_GET['contentType'] == "course") {
            include_once("./components/userfunctions/view/viewCourse.php");
        }
    }
    else if($_GET['content'] == "viewWorkflow") {
        include_once("./components/userfunctions/viewWorkflow.php");
    }
    else if($_GET['content'] == "startInternApp") {
        include_once("./components/userfunctions/workflows/internAppStart.php");
    }
    else if($_GET['content'] == "settings") {
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == 'myAccount') {
                include_once("./components/userfunctions/settings/viewProfile.php");
            }
            if($_GET['contentType'] == 'changeEmail') {
                include_once("./components/userfunctions/settings/changeEmail.php");
            }
            if($_GET['contentType'] == 'changePassword') {
                include_once("./components/userfunctions/settings/changePassword.php");
            }
        }
        else {
            include_once("./components/userfunctions/settings/settings.php");
        }
    }
?>