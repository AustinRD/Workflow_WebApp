<?php
    //Loads the action bar so the user can navigate between pages.
    include_once('./components/userfunctions/workflows/workflows.php')
?>

<script>
    //Hides the currently hardcoded Feed from workflows.php
    document.getElementById('activityFeed').style.display = 'none';
</script>

<!-- Start Workflow -->
<div class="w3-card-4 w3-margin w3-padding">
    <h5>Start Workflow</h5>

    <form id="workflowSelectForm" method="get" action="./dashboard.php">
        <!-- These hidden input fields are needed to get the user back to this page. -->
        <input type="hidden" name="content" value="workflows">
        <input type="hidden" name="contentType" value="start">
        
        <!-- Populate the Select with the list of available workflows for this user -->
        <!-- Will be hardcoded until custom workflows are implemented -->
        <label for="workflowSelect">Workflow Type:</label>
        <select name="workflowSelect" class="w3-input">
            <option value="internship">Internship/Fieldwork (General)</option>
            <option value="transferCred">Transfer Credit Evaluation (Not Implemented)</option>
        </select>
        <br>
        <button class="w3-button w3-teal" type="submit" name="startWorkflow">Start</button>
    </form>

    <!-- If the user selected and submitted a workflow to start -->
    <?php
        if(isset($_GET['startWorkflow'])) {
            if($_GET['workflowSelect'] == 'internship') {
    ?>
                <!-- After the user selects the type of application we hide the selection form. -->
                <script>
                    document.getElementById('workflowSelectForm').style.display = 'none';
                </script>


                <!-- This form is specficically for the internship application and may be adapted for
                        custom workflows in the future -->
                <form method="post" action="./dashboard.php?content=workflows&contentType=start">
                    <label for="studentEmail">Student's Email</label>
                    <input type="email" name="studentEmail" class="w3-input">
                    
                    <!-- Function to show the courses available in a selected department. -->
                    <script>
                        function showCourse(str) {
                            if (str == "") {
                                document.getElementById("course").innerHTML = "";
                                return;
                            } 
                            else {
                                var xmlhttp = new XMLHttpRequest();
                                xmlhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        document.getElementById("course").innerHTML = this.responseText;
                                    }
                                };
                                xmlhttp.open("GET","./backend/getCourse.php?q="+str,true);
                                xmlhttp.send();
                            }
                        }
                    </script>

                    <!-- Select field for the department -->
                    <label for="department">Department</label>
                    <select class="w3-input" name="department" id="department" onchange="showCourse(this.value)">
                        <option value="">Select a department:</option>
                        <?php 
                            $sql = "SELECT * FROM `f20_academic_dept_info`";
                            $query = mysqli_query($db_conn, $sql);
                            if ($query) {
                                while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                                    echo("<option value='" . $row['dept_code'] . "'>" . $row['dept_name'] . "</option>");
                                }
                            }
                        ?>
                    </select>

                    <label for="course">Course</label>
                    <select class="w3-input" name="course" id="course">
                        <option value="">Select a course:</option>
                    </select>

                    <label for="semester">Semester</label>
                    <select class= "w3-input" name="semester" id="semester">
                        <option value="">Select a semester:</option>
                        <option value="Fall">Fall</option>
                        <option value="Spring">Spring</option>
                        <option value="Summer">Summer</option>
                        <option value="Winter">Winter</option>
                    </select>
                    <label for="semester">Year</label>
                    <input type="text" name="year" class="w3-input">
                    <label for="gradeMethod">Grade Method</label>
                    <select name="gradeMethod" class="w3-input">
                        <option value="">Select a grade method:</option>
                        <option value="Letter Grades">Letter Grades</option>
                        <option value="Pass/Fail">Pass/Fail</option>
                    </select>
                    <br>
                    <button class="w3-button w3-teal" type="submit" name="startInternshipWF">Start</button>
                </form>
    <?php
            }
        }
    ?>
</div>

<!-- Handler for starting the old internship application. -->
<?php
    if (isset($_POST['startInternshipWF'])) {
        $studentEmail = mysqli_real_escape_string($db_conn, $_POST['studentEmail']);
        $department = mysqli_real_escape_string($db_conn, $_POST['department']);
        $course = mysqli_real_escape_string($db_conn, $_POST['course']);
        $semester = mysqli_real_escape_string($db_conn, $_POST['semester']);
        $year = mysqli_real_escape_string($db_conn, $_POST['year']);
        $gradeMethod = mysqli_real_escape_string($db_conn, $_POST['gradeMethod']);

        $fwid = bin2hex(random_bytes(32));  //duplication is unlikely with this one. 1 in 20billion apparently
        $newappsql = "INSERT INTO f20_application_info(fw_id, dept_code, course_number, student_email, semester, year, grade_mode) 
                        VALUES ('$fwid','$department', '$course','$studentEmail', '$semester', '$year', '$gradeMethod');";
        
        $newutilsql = "INSERT INTO f20_application_util(fw_id, progress, rejected, assigned_to, assigned_when) 
                        VALUES ('$fwid', '-1', '0', 'student', 'CURRENT_TIMESTAMP');";

        $insql = mysqli_query($db_conn, $newappsql);

        if (mysqli_errno($db_conn) == 0) {

            $insql = mysqli_query($db_conn, $newutilsql);
            if (mysqli_errno($db_conn) == 0) {
                echo("<div class='w3-card w3-green w3-margin w3-padding'>Application Successfully Started.</div>");
            }
            else {
                echo("<div class='w3-card w3-red w3-margin w3-padding'>Error starting application utility.</div>");
            }
        }
        else {
            echo("<div class='w3-card w3-red w3-margin w3-padding'>Error starting application.</div>");
        }
    }
?>