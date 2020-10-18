<!--

-->

<?php
    
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-search"></i>  Admin Search Tool</b></h5>
</header>

<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=search&contentType=workflow'">
    <div class="w3-container w3-blue w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Workflow</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=search&contentType=department'">
    <div class="w3-container w3-blue w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-building w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Deparment</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=search&contentType=course'">
    <div class="w3-container w3-blue w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-book w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Course</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=search&contentType=user'">
    <div class="w3-container w3-blue w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>User</h5></div>
    </div>
    </div>
</div>

<!-- Workflow Search -->
<div id="workflowSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='.'">Start Workflow</button>
    <h5>Workflow Search</h5>
    <p>You may search by ID</p>
    <input id="workflowInput" type="text" onkeyup="search('workflowTable', 'workflowInput')"></input>
    <table id="workflowTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th>Initiator Email</th>
            <th>Course</th>
            <th>Semester</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php
            $sql = "SELECT f20_application_info.student_email, concat(f20_application_info.semester, ' ', f20_application_info.year) 
            AS semyear, concat(f20_application_info.dept_code, ' ', course_number) 
            AS Course, f20_application_info.instructor_email, assigned_to, f20_application_info.fw_id 
            FROM f20_application_info INNER JOIN f20_application_util ON f20_application_info.fw_id = f20_application_util.fw_id";

            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_array($query)) {
                $initEmail = $row['student_email'];
                $course = $row['Course'];
                $semester = $row['semyear'];
                $status = $row['assigned_to'];
                $wfID = $row['fw_id'];
        ?>
        <tr>
            <td><?php echo $initEmail; ?></td>
            <td><?php echo $course; ?></td>
            <td><?php echo $semester; ?></td>
            <td><?php echo $status; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=workflow">
                    <input type="hidden" name="workflowID" value="<?php echo $wfID;?>">
                    <button type="submit" name="viewWorkflow" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>