<!-- 
    This file is for the creation of departments work may be needed:
    1. Organization
    2. May need database work.
-->

<?php
    include_once('./components/userfunctions/create/create.php');
    include_once('./backend/db_connector.php');
    if (isset($_POST['departmentCreate'])) {
        include_once('./backend/config.php');
        //Loading the page title and action buttons.

        $deptName = mysqli_real_escape_string($db_conn, $_POST['deptName']);
        $deptCode = mysqli_real_escape_string($db_conn, $_POST['deptCode']);
        $deanEmail = mysqli_real_escape_string($db_conn, $_POST['deanEmail']);
        $chairEmail = mysqli_real_escape_string($db_conn, $_POST['chairEmail']);
        $secretaryEmail = mysqli_real_escape_string($db_conn, $_POST['secretaryEmail']);

        $insertDeptSQL = "INSERT INTO f20_academic_dept_info (dept_code, dept_name, dean_email, chair_email, secretary_email) VALUES ('$deptCode', '$deptName', '$deanEmail', '$chairEmail', '$secretaryEmail')";
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
        <select id="deanEmail" name="deanEmail" class="w3-input" required>
            <option value="">Please select a valid user.</option>
            <?php
                $sql = "SELECT * FROM f20_user_table WHERE URID = 4";
                $deptquery  = mysqli_query($db_conn, $sql);
                while ($result = mysqli_fetch_array($deptquery)) {
                    $deanEmail = $result['user_email'];
                    echo("<option value=" . $deanEmail . ">" . $deanEmail . "</option>");
                }
            ?>
        </select>
        <br>
        <label for="chairEmail">Chair Email</label>
        <select id="chairEmail" name="chairEmail" class="w3-input" required>
            <option value="">Please select a valid user.</option>
            <?php
                $sql = "SELECT * FROM f20_user_table WHERE URID = 5";
                $deptquery  = mysqli_query($db_conn, $sql);
                while ($result = mysqli_fetch_array($deptquery)) {
                    $deanEmail = $result['user_email'];
                    echo("<option value=" . $deanEmail . ">" . $deanEmail . "</option>");
                }
            ?>
        </select>
        <br>
        <label for="secretaryEmail">Secretary Email</label>
        <select id="secretaryEmail" name="secretaryEmail" class="w3-input" required>
            <option value="">Please select a valid user.</option>
            <?php
                $sql = "SELECT * FROM f20_user_table WHERE URID = 6";
                $deptquery  = mysqli_query($db_conn, $sql);
                while ($result = mysqli_fetch_array($deptquery)) {
                    $deanEmail = $result['user_email'];
                    echo("<option value=" . $deanEmail . ">" . $deanEmail . "</option>");
                }
            ?>
        </select>
        
        <!-- The following is hidden for our final Presentation [Not Implemented] 
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
        -->
        <br>
        <button name="departmentCreate" type="submit" class="w3-button w3-teal">Create Department</button>
    </form>
</div>