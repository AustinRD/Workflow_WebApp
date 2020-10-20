<!-- 
    This file is for the creation of departments work may be needed:
    1. Organization
    2. May need database work.
-->

<?php
    if (isset($_POST['departmentCreate'])) {
        include_once('./backend/config.php');
        include_once('./backend/db_connector.php');
        
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

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-plus"></i>  Admin Create Tool</b></h5>
</header>

<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=create&contentType=workflow'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Workflow</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=create&contentType=department'">
    <div class="w3-container w3-teal w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-building w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Deparment</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=create&contentType=course'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-book w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Course</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=create&contentType=user'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>User</h5></div>
    </div>
    </div>
</div>

<!-- Create Department -->
<div id="departmentForm" class="w3-card-4 w3-padding w3-margin">
    <h5>Create Department</h5>
    <form method="POST" action="./dashboard.php?content=create&contentType=department">
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