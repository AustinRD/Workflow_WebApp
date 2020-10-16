<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        header('Location: ./index.php');
    }
    //User is not an admin.
    if(!($_SESSION['user_type'] == 'admin')){
        header('Location: ./index.php');
    }
    include_once('./backend/util.php');
    include_once('./backend/db_connector.php');
    
    //Gather data passed to this page.
    $user = mysqli_real_escape_string($db_conn, $_POST['userEmail']);

    //Find all data related to the user.
    $sql = "SELECT * FROM " . $GLOBALS['accounts'] . " WHERE email = '$user'";
    $query = mysqli_query($db_conn, $sql);
    $row = mysqli_fetch_assoc($query);

    $userName = "Users Name";
    $userType = $row['profile_type'];
    $lastAccess = $row['last_access'];
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-search"></i>  Admin View Tool</b></h5>
</header>

<!-- User Information -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <button type="button" class="w3-button w3-red w3-right" name="userCreate">Remove</button>
    <button type="button" class="w3-button w3-blue w3-right" name="userCreate" style="margin-right: 5px;">Edit</button>
    
    <h5>User:</h5>
    <form method="post" action="./dashboard?content=view&contentType=user">
        <label for="name">Name</label>
        <input id="name" name="name" type="text" class="w3-input" value="<?php echo $userName; ?>" readonly>
        <br>
        <label for="email">Email Address</label>
        <input id="email" name="userEmail" type="email" class="w3-input" value="<?php echo $user; ?>" readonly>
        <br>
        <label for="banner">Banner ID</label>
        <input id="banner" name="banner" type="text" class="w3-input" readonly>
        <br>
        <label for="type">User Type</label>
        <select id="type" name="type" class="w3-input" readonly>
            <option value="<?php echo $userType; ?>" selected><?php echo $userType; ?></option>
            <option value="admin">Admin</option>
            <option value="recreg">Records &amp; Registration</option>
            <option value="crc">Career Resource Center</option>
            <option value="dean">Dean</option>
            <option value="chair">Department Chair</option>
            <option value="secretary">Secretary</option>
            <option value="student">Student</option>
            <option value="employer">Employer</option>
            <option value="instructor">Faculty [Advisor/Instructor]</option> 
        </select>
        <br>
        <div id="editButtons" style="display: none;">
            <button type="submit" class="w3-button w3-blue" name="userCreate">Save</button>
            <button type="button" class="w3-button w3-red" >Cancel</button>
        </div>
    </form>
</div>

<!-- Workflows -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <h5>Workflows:</h5>
    <form method="post" action="./dashboard?content=view&contentType=user">
    <?php
        $user_email = $_SESSION['user_email'];
        $sql = "SELECT * FROM f20_application_info WHERE student_email = '$user'";
        $query = mysqli_query($db_conn, $sql);

        if ($query) {
            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                echo('<div class="w3-row w3-card-4 w3-margin">'
                        .'<div class="w3-quarter w3-border" style="height: 90px; padding-left: 10px;">'
                        . '<p>Type: '
                        . $row['project_name']
                        . '<br>Semester: '
                        . $row['semester'] . ' '
                        . $row['year'])
                        . '<br>Status: '
                        . 'Denied'
                        . '</p></div>';

                include('./components/userfunctions/workflowProgress.php');

                echo('<div class="w3-quarter w3-center w3-padding-24 w3-border" style="height: 90px;">'
                        . '<form action="./dashboard.php?content=viewWorkflow" method="post" >'
                        . '<input type="hidden" name="wfID" value="'
                        . $row['fw_id']
                        . '"></input>'
                        . '<button class="w3-button w3-teal" type="submit">View</button>'
                        . '</div></div>');
            }
        }
        else {
            echo('<div class="w3-row w3-card-4 w3-margin">'
                    . '<p>No Workflows Found!</p></div>');
        }
    ?>
    </form>
</div>