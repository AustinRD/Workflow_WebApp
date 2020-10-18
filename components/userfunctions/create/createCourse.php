<!-- 
    This file is for the creation of courses work may be needed:
    1. Add fields for assigning instructors?
    2. May need database work.
-->

<?php 
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    
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

<!-- Create Course -->
<div id="courseForm" class="w3-card-4 w3-padding w3-margin">
    <h5>Create Course</h5>
    <form method="post" action="./dashboard.php?content=create&contentType=course">
        <label for="deptCode">Department</label>
        <select id="deptCode" name="deptCode" class="w3-input" required>
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