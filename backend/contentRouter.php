<!-- File for redirection to the appropriate content based on get requests. -->
<?php
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
    else if($_GET['content'] == "search") {
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
    else if($_GET['content'] == "create") {
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
    else if($_GET['content'] == "workflows") {
        include_once("./components/userfunctions/workflows.php");
    }
    else if($_GET['content'] == "view") {
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
    else if($_GET['content'] == "settings") {
        include_once("./components/userfunctions/settings.php");
    }
?>