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
    if(!($_SESSION['user_type'] == 'admin')){
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! You do not have permission to access this information.</p></div>";
        exit();
    }
    //Department ID was not sent to the page.
    if(!isset($_POST['department'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No department recieved</p></div>";
        exit();
    }
    else {
        include_once('./backend/util.php');
        include_once('./backend/db_connector.php');
        //Gather data passed to this page.
        $department = mysqli_real_escape_string($db_conn, $_POST['department']);

        //User chose to remove entry.
        if(isset($_POST['remove'])) {
            $sql = "DELETE FROM f20_academic_dept_info WHERE dept_code = '$department'";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Removed " . $department . "</p></div>");
            } 
            else {
                echo("<div class='w3-panel w3-margin w3-red'><p>Error removing record: " . $db_conn->error . "</p></div>");
            }
        }
        else {
            //Find all data related to the department.
            $sql = "SELECT * FROM f20_academic_dept_info WHERE dept_code = '$department'";
            $query = mysqli_query($db_conn, $sql);
            $dept = mysqli_fetch_assoc($query);
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-search"></i>  Admin View Tool</b></h5>
</header>

<!-- Department Information -->
<div id="departmentForm" class="w3-card-4 w3-padding w3-margin">
    <div class="w3-right" id="actionButtons">
        <button type="button" class="w3-button w3-blue" name="departmentCreate" style="margin-right: 5px;" onclick="enableEdit()">Edit</button>
        <button type="button" class="w3-button w3-red" name="departmentCreate" onclick="removeEntry('department', '<?php echo $department ?>')">Remove</button>
    </div>

    <h5>Department:</h5>
    <form method="post" action="./dashboard?content=view&contentType=department">
        <label for="wfID">Department Name:</label>
        <input id="wfID" name="wfID" type="text" class="w3-input" value="<?php echo $dept['dept_name']; ?>" readonly>
        <br>
        <label for="type">Department Code:</label>
        <input id="banner" name="banner" type="text" class="w3-input" value="<?php echo $department; ?>" readonly>
        <br>
        <label for="initiator">Dean:</label>
        <input id="initiator" name="initiator" type="email" class="w3-input" value="<?php echo $dept['dean_email']; ?>" readonly>
        <br>
        <label for="banner">Chair:</label>
        <input id="banner" name="banner" type="text" class="w3-input" value="<?php echo $dept['chair_email']; ?>" readonly>
        <br>
        <label for="type">Secretary:</label>
        <input id="banner" name="banner" type="text" class="w3-input" value="<?php echo $dept['secretary_email']; ?>" readonly>
        <br>
        <div id="editButtons" style="display: none;">
            <button type="submit" class="w3-button w3-blue" name="departmentCreate">Save</button>
            <button type="button" class="w3-button w3-red" onclick="disableEdit()">Cancel</button>
        </div>
    </form>
</div>

<!-- Courses -->
<div id="courseList" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=create'">Create Course</button>
    <h5>Course List</h5>
    <p>You may search by Course Number or Department</p>
    <input type="text" id="courseInput" onkeyup="search('courseTable', 'courseInput')"></input>
    <table id="courseTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th class="w3-center">Title</th>
            <th class="w3-center">Number</th>
            <th class="w3-center">Section</th>
            <th class="w3-center">Instructor</th>
            <th class="w3-center">Actions</th>
        </tr>
        <?php
            //Find all courses related to the department.
            $sql = "SELECT * FROM f20_course_numbers WHERE dept_code = '$department'";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $courseNumber = $row['course_number'];
        ?>
        <tr>
            <td></td>
            <td><?php echo $courseNumber;?></td>
            <td></td>
            <td></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=course">
                    <input type="hidden" name="department" value="<?php echo $department;?>">
                    <input type="hidden" name="courseNumber" value="<?php echo $courseNumber;?>">
                    <button type="submit" name="viewCourse" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- Instructors -->


<!-- Modal Pop-up to warn of deletion -->
<div id="warningHolder" class="w3-modal w3-center">
    <div class="w3-modal-content">
        <div class="w3-container w3-red">
            <p>Warning!!</p>
            <p>A 'Remove' can not be undone!</p>
            <p>Are you sure?
                <br>
                <form method="post" action="./dashboard.php?content=view&contentType=department">
                    <input id="removeType" name="removeType" type="hidden">
                    <input id="removeData" name="department" type="hidden">
                    <button type="submit" name="remove">Yes</button>
                    <button type="button" onclick="document.getElementById('warningHolder').style.display='none'">No</button>
                </form>
            </p>
        </div>
    </div>
</div>

<!-- Remove from database Script -->
<script>
    function removeEntry(entryType, entry)
    {
        //Display the warning modal.
        document.getElementById('warningHolder').style.display='block';
        //Replace hidden input data to prepare for if the user chooses to submit.
        document.getElementById('removeType').value = entryType;
        document.getElementById('removeData').value = entry;
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