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
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-plus"></i>  Admin Create Tool</b></h5>
</header>

<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" onclick="openForm('workflowForm');">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Workflow</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="openForm('departmentForm');">
    <div class="w3-container w3-teal w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-building w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Deparment</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="openForm('courseForm');">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-book w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Course</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="openForm('userForm');">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>User</h5></div>
    </div>
    </div>
</div>

<?php
    if (isset($_POST['courseCreate'])) {
        $deptCode = mysqli_real_escape_string($db_conn, $_POST['deptCode']);
        $class = mysqli_real_escape_string($db_conn, $_POST['classnumber']);

        $insertclass = "INSERT INTO f20_course_numbers (dept_code, course_number) VALUES ('$deptCode', '$class')";
        $insertclassquery = mysqli_query($db_conn, $insertclass);

        //Database insert success
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Course Successfully Created.</p></div>");
        } 
        //Database detected duplicate entry
        else if (mysqli_errno($db_conn) == 1062) {  
            echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create Course - Duplicate Found.</p></div>");
        }
    }
    //Below needs work - implement user creation, add password(generate random or make user pick) and name field to database.
    else if (isset($_POST['userCreate'])) {
        $userName = mysqli_real_escape_string($db_conn, $_POST['name']);
        $userEmail = mysqli_real_escape_string($db_conn, $_POST['email']);
        $bannerID = mysqli_real_escape_string($db_conn, $_POST['banner']);
        $userType = mysqli_real_escape_string($db_conn, $_POST['type']);
        $userPass = mysqli_real_escape_string($db_conn, $_POST['pswd']);

        $insertUser = "INSERT INTO f20_userpass (email, passcode, profile_type, verified, first_time) 
                            VALUES ('$userEmail', '$userPass', '$userType', 1, 0)";
        $insertUserQuery = mysqli_query($db_conn, $insertUser);

        //Database insert success
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-panel w3-margin w3-green'><p>User Successfully Created.</p></div>");
        } 
        //Database detected duplicate entry
        else if (mysqli_errno($db_conn) == 1062) {  
            echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create User - Duplicate Found.</p></div>");
        }
    }
    else if (isset($_POST['workflowCreate'])) {
        //Needs Implementation

        //Database insert success
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Course Successfully Created.</p></div>");
        } 
        //Database detected duplicate entry
        else if (mysqli_errno($db_conn) == 1062) {  
            echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create Course - Duplicate Found.</p></div>");
        }
        else {
            echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create Course.</p></div>");

        }
    }
    else if (isset($_POST['departmentCreate'])) {
        $deptName = mysqli_real_escape_string($db_conn, $_POST['deptName']);
        $deptCode = mysqli_real_escape_string($db_conn, $_POST['deptCode']);
        $deanEmail = mysqli_real_escape_string($db_conn, $_POST['deanEmail']);
        $chairEmail = mysqli_real_escape_string($db_conn, $_POST['chairEmail']);
        $secretaryEmail = mysqli_real_escape_string($db_conn, $_POST['secretaryEmail']);

        $insertDeptSQL = "INSERT INTO f20_academic_dept_info (dept_code, dept_name, dean_email, secretary_email) VALUES ('$deptCode', '$deptName', '$deanEmail', '$secretaryEmail')";
        $insertDeptQuery = mysqli_query($db_conn, $insertDeptSQL);

        //Database insert success
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Department Successfully Created.</p></div>");
            $defaultWorkflow = array(0 => 'Student', 1 => 'Instructor', 2 => 'Employer', 3 => 'Chair', 4 => 'Dean', 5 => 'Records&Registration');
            $defaultWorkflow = serialize($defaultWorkflow);
            $insertWorkflowSQL = "INSERT INTO f20_workflow_order(dept_code, workflow) VALUES ('$deptCode','$defaultWorkflow')";
            $insertWorkflowQuery = mysqli_query($db_conn, $insertWorkflowSQL);
        } 
        //Database detected duplicate entry
        else if (mysqli_errno($db_conn) == 1062) {  
            echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create Department - Duplicate Found.</p></div>");
        }
    }
?>

<!-- Create Workflow -->
<div id="workflowForm" class="w3-card-4 w3-padding w3-margin" style="display: none;">
    <h5>Create Workflow</h5>
    <form method="post">
        <input type="text"></input>
        <button type="submit" name="workflowCreate">Create</button>
    </form>    
</div>

<!-- Create Department -->
<div id="departmentForm" class="w3-card-4 w3-padding w3-margin" style="display: none;">
    <h5>Create Department</h5>
    <form method="POST">
        <label for="deptName">Department Name</label>
        <input id="deptName" name="deptName" type="text" class="w3-input">
        <br>
        <label for="deptCode">Department Code</label>
        <input id="deptCode" name="deptCode" maxlength='3' type="text" class="w3-input">
        <br>
        <label for="deanEmail">Dean Email</label>
        <input id="deanEmail" name="deanEmail" type="email" class="w3-input">
        <br>
        <label for="chairEmail">Chair Email</label>
        <input id="chairEmail" name="chairEmail" type="text" class="w3-input">
        <br>
        <label for="secretaryEmail">Secretary Email</label>
        <input id="secretaryEmail" name="secretaryEmail" type="text" class="w3-input">
        
        <p><Strong>Permissions</Strong></p>
            <p>Instructors:<br>
                <input name="perm1" id="perm1_0" type="checkbox" class="w3-check">
                <label for="perm1_0" class="custom-control-label">modify course info</label>
                <input name="perm1" id="perm1_1" type="checkbox" class="w3-check">
                <label for="perm1_1" class="custom-control-label">modify project info</label>
                <input name="perm1" id="perm1_2" type="checkbox" class="w3-check">
                <label for="perm1_2" class="custom-control-label">modify employer info</label></p>
            <p>Employers:<br>
                <input name="perm2" id="perm2_0" type="checkbox" class="w3-check">
                <label for="perm2_0" class="custom-control-label">modify project info</label>
                <input name="perm2" id="perm2_1" type="checkbox" class="w3-check">
                <label for="perm2_1" class="custom-control-label">modify learning objectives</label></p>
            <p>Department Chairs:<br>
                <input name="perm3" id="perm3_0" type="checkbox" class="w3-check">
                <label for="perm3_0" class="custom-control-label">modify course info</label>
                <input name="perm3" id="perm3_1" type="checkbox" class="w3-check">
                <label for="perm3_1" class="custom-control-label">modify project info</label>
                <input name="perm3" id="perm3_2" type="checkbox" class="w3-check">
                <label for="perm3_2" class="custom-control-label">modify employer info</label>
                <input name="perm3" id="perm3_3" type="checkbox" class="w3-check">
                <label for="perm3_3" class="custom-control-label">modify learning objectives</label></p>
        
        <p><Strong>Email Settings</Strong></p>
            <p>Students:<br>
                <input name="em1" id="em1_0" type="checkbox" class="w3-check">
                <label for="em1_0" class="custom-control-label">receive email updates</label>
                <input name="em1" id="em1_1" type="checkbox" class="w3-check">
                <label for="em1_1" class="custom-control-label">receive reminder emails</label></p>
            <p>Instructors:<br>
                <input name="em2" id="em2_0" type="checkbox" class="w3-check">
                <label for="em2_0" class="custom-control-label">receive email updates</label>
                <input name="em2" id="em2_1" type="checkbox" class="w3-check">
                <label for="em2_1" class="custom-control-label">receive rejection emails</label>
                <input name="em2" id="em2_2" type="checkbox" class="w3-check">
                <label for="em2_2" class="custom-control-label">receive reminder emails</label></p>
            <p>Department Chairs:<br>
                <input name="em3" id="em3_0" type="checkbox" class="w3-check">
                <label for="em3_0" class="custom-control-label">receive email updates</label>
                <input name="em3" id="em3_1" type="checkbox" class="w3-check">
                <label for="em3_1" class="custom-control-label">receive rejection emails</label>
                <input name="em3" id="em3_2" type="checkbox" class="w3-check">
                <label for="em3_2" class="custom-control-label">receive reminder emails</label></p>
            <p>Deans:<br>
                <input name="em4" id="em4_0" type="checkbox" class="w3-check">
                <label for="em4_0" class="custom-control-label">recieve email updates</label>
                <input name="em4" id="em4_1" type="checkbox" class="w3-check">
                <label for="em4_1" class="custom-control-label">receive rejection emails</label>
                <input name="em4" id="em4_2" type="checkbox" class="w3-check">
                <label for="em4_2" class="custom-control-label">receive reminder emails</label></p>
        <button name="departmentCreate" type="submit" class="w3-button w3-teal">Create Department</button>
    </form>
</div>

<!-- Create Course -->
<div id="courseForm" class="w3-card-4 w3-padding w3-margin" style="display: none;">
    <h5>Create Course</h5>
    <form method="post" action="./dashboard.php?content=create">
        <label for="type">Department</label>
        <select id="type" name="deptCode" class="w3-input" required>
            <?php
                $sql = "SELECT * FROM f20_academic_dept_info ORDER BY dept_code ASC";
                $deptquery  = mysqli_query($db_conn, $sql);
                $r = mysqli_num_rows($deptquery);
                if ($r > 0) {
                    while ($result = mysqli_fetch_assoc($deptquery)) {
                        $deptCode = $result['dept_code'];
                        echo("<option value=" . $deptCode . ">" . $deptCode . "</option>");
                    }
                }
            ?>
        </select>
        <br>
        <label for="classnumber">Class number:</label>
        <input id="classnumber" name="classnumber" type="text" class="w3-input" maxlength="3" size="3" required />
        <br>
        <button type="submit" class="w3-button w3-teal" name="courseCreate">Create</button>
    </form>
</div>

<!-- Create User -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin" style="display: none;">
    <h5>Create User</h5>
    <form method="post" action="./dashboard.php?content=create">
        <label for="name">Name</label>
        <input id="name" name="name" type="text" class="w3-input" required>
        <br>
        <label for="email">Email Address</label>
        <input id="email" name="email" placeholder="@newpaltz.edu" type="email" class="w3-input" required>
        <br>
        <label for="pswd">Password</label>
        <input id="pswd" name="pswd" type="password" class="w3-input" required>
        <br>
        <label for="banner">Banner ID</label>
        <input id="banner" name="banner" type="text" class="w3-input" required>
        <br>
        <label for="type">User Type</label>
        <select id="type" name="type" class="w3-input" required>
            <option value="admin">Admin</option>
            <option value="recreg">Records & Registration</option>
            <option value="crc">Career Resource Center</option>
            <option value="dean">Dean</option>
            <option value="chair">Department Chair</option>
            <option value="secretary">Secretary</option>
            <option value="student">Student</option>
            <option value="employer">Employer</option>
            <option value="instructor">Faculty [Advisor/Instructor]</option> 
        </select>
        <br>
        <button type="submit" class="w3-button w3-teal" name="userCreate">Create</button>
    </form>
</div>

<!-- Showing/Hiding Create Forms -->
<!-- A later version of this application will use PHP to load the forms -->
<script>
    function openForm(formID)
    {
        closeForm('workflowForm');
        closeForm('departmentForm');
        closeForm('courseForm');
        closeForm('userForm');
        document.getElementById(formID).style.display = "block";
    }
    function closeForm(formID)
    {
        document.getElementById(formID).style.display = "none";
    }
</script>