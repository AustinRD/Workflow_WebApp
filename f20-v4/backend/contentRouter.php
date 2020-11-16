<!-- File for redirection to the appropriate content based on get requests. -->
<?php
    //If the content requested is the home/dashboard.
    if($_GET['content'] == "home") {
        include_once('./components/dashboard/header.php');
        include_once('./components/dashboard/actionpanel.php');
        include_once('./components/dashboard/feed.php');
        include_once('./components/dashboard/recentworkflows.php');
        include_once('./components/dashboard/recentmessages.php');
    }
    //If the content requested is the search page.
    else if($_GET['content'] == "search") {
        //If the user requested the a specific section of the search page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "user") {
                include_once("./components/userfunctions/search/searchUser.php");
            }
            else if($_GET['contentType'] == "workflows") {
                include_once("./components/userfunctions/search/searchWorkflow.php");
            }
            else if($_GET['contentType'] == "workflowtemplate") {
                include_once("./components/userfunctions/search/searchWorkflowTemplates.php");
            }
            else if($_GET['contentType'] == "department") {
                include_once("./components/userfunctions/search/searchDepartment.php");
            }
            else if($_GET['contentType'] == "course") {
                include_once("./components/userfunctions/search/searchCourse.php");
            }
            else if($_GET['contentType'] == "steps") {
                include_once("./components/userfunctions/search/searchSteps.php");
            }
            else if($_GET['contentType'] == "steptemplates") {
                include_once("./components/userfunctions/search/searchStepTemplates.php");
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
			if($_GET['contentType'] == "message") {
                include_once("./components/userfunctions/create/createMessage.php");
            }
        }
        else {
            include_once("./components/userfunctions/create/create.php");
        }
    }
    else if($_GET['content'] == "messages") {
        include_once("./components/userfunctions/messages.php");
    }
    else if($_GET['content'] == "files") {
        include_once("./components/userfunctions/files.php");
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
		if($_GET['contentType'] == "message") {
            include_once("./components/userfunctions/view/viewMessage.php");
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