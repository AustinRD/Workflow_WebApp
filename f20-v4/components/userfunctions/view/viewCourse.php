<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Session Expired, Please sign in again.</p></div>";
        exit();
    }
    //User is not an admin.
    if(!($_SESSION['user_type'] == $GLOBALS['admin_type'])){
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! You do not have permission to access this information.</p></div>";
        exit();
    }
    //Course ID was not sent to the page.
    if(!isset($_POST['courseNumber'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No course recieved</p></div>";
        exit();
    }
    else {
        include_once('./backend/util.php');
        include_once('./backend/db_connector.php');

        //Gather data passed to this page.
        $department = mysqli_real_escape_string($db_conn, $_POST['department']);
        $courseNumber = mysqli_real_escape_string($db_conn, $_POST['courseNumber']);

        //User chooses to remove entry.
        if(isset($_POST['remove'])) {
            $sql = "DELETE FROM f20_course_numbers WHERE dept_code = '$department' AND course_number = '$courseNumber'";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Removed " . $department . $courseNumber . "</p></div>");
            } 
            else {
                echo("<div class='w3-panel w3-margin w3-red'><p>Error removing record: " . $db_conn->error . "</p></div>");
            }
        }
        else {
            //Find all data related to the course.
            $sql = "SELECT * FROM f20_course_numbers WHERE dept_code = '$department' AND course_number = '$courseNumber'";
            $query = mysqli_query($db_conn, $sql);
            $row = mysqli_fetch_assoc($query);
?>

<!-- Department Information -->
<div id="departmentForm" class="w3-card-4 w3-padding w3-margin">
    <div class="w3-right" id="actionButtons">
        <button type="button" class="w3-button w3-blue" name="editCourse" style="margin-right: 5px;" onclick="enableEdit()">Edit</button>
        <button type="button" class="w3-button w3-red" name="removeCourse" onclick="removeEntry('<?php echo $courseNumber; ?>', '<?php echo $department; ?>')">Remove</button>
    </div>

    <h5>Course:</h5>
    <form method="post" action="./dashboard?content=view&contentType=course">
        <label for="courseTitle">Course Title:</label>
        <input id="courseTitle" name="courseTitle" type="text" class="w3-input" value="" readonly>
        <br>
        <label for="dept">Department:</label>
        <input id="dept" name="dept" type="text" class="w3-input" value="<?php echo $department; ?>" readonly>
        <br>
        <label for="courseNum">Course Number:</label>
        <input id="courseNum" name="courseNum" type="text" class="w3-input" value="<?php echo $courseNumber; ?>" readonly>
        <br>
        <label for="section">Section:</label>
        <input id="section" name="section" type="text" class="w3-input" value="" readonly>
        <br>
        <label for="instructor">Instructor:</label>
        <input id="instructor" name="instructor" type="text" class="w3-input" value="" readonly>
        <br>
        <div id="editButtons" style="display: none;">
            <button type="submit" class="w3-button w3-blue" name="saveCourseChanges">Save</button>
            <button type="button" class="w3-button w3-red" onclick="disableEdit()">Cancel</button>
        </div>
    </form>
</div>

<!-- Instructor -->


<!-- Modal Pop-up to warn of deletion -->
<div id="warningHolder" class="w3-modal w3-center">
    <div class="w3-modal-content">
        <div class="w3-container w3-red">
            <p>Warning!!</p>
            <p>A 'Remove' can not be undone!</p>
            <p>Are you sure?
                <br>
                <form method="post" action="./dashboard.php?content=view&contentType=course">
                    <input id="department" name="department" type="hidden">
                    <input id="courseNumber" name="courseNumber" type="hidden">
                    <button type="submit" name="remove">Yes</button>
                    <button type="button" onclick="document.getElementById('warningHolder').style.display='none'">No</button>
                </form>
            </p>
        </div>
    </div>
</div>

<!-- Remove from database Script -->
<script>
    function removeEntry(courseNumber, department)
    {
        //Display the warning modal.
        document.getElementById('warningHolder').style.display='block';
        //Replace hidden input data to prepare for if the user chooses to submit.
        document.getElementById('courseNumber').value = courseNumber;
        document.getElementById('department').value = department;
    }
</script>

<!-- Enable/Disable table editing Script -->
<script>
    function enableEdit()
    {
        //Disable readonly on inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=false;
        }
        //Hide the edit and remove buttons.
        document.getElementById("actionButtons").style.display = "none";
        //Show the save and cancel buttons.
        document.getElementById("editButtons").style.display = "inline-block";
    }
    function disableEdit()
    {
        //Re-enable readonly on all inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=true;
        }
        //Hide the save and cancel buttons.
        document.getElementById("editButtons").style.display = "none";
        //Show the edit and remove buttons.
        document.getElementById("actionButtons").style.display = "inline-block";
    }
</script>

<?php }
    }
?>