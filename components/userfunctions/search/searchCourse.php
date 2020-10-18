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

<!-- Course Search -->
<div id="courseSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=create&contentType=course'">Create Course</button>
    <h5>Course Search</h5>
    <p>You may search by Course Number or Department</p>
    <input type="text" id="courseInput" onkeyup="search('courseTable', 'courseInput')"></input>
    <table id="courseTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th class="w3-center">Department</th>
            <th class="w3-center">Course Number</th>
            <th class="w3-center">Actions </th>
        </tr>
        <?php
            $sql = "SELECT * FROM f20_course_numbers";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $dept = $row['dept_code'];
                $courseNumber = $row['course_number'];
                $id = $row['id'];
        ?>
        <tr>
            <td><?php echo $dept; ?></td>
            <td><?php echo $courseNumber; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=course">
                    <input type="hidden" name="department" value="<?php echo $dept;?>">
                    <input type="hidden" name="courseNumber" value="<?php echo $courseNumber;?>">
                    <button type="submit" name="viewCourse" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>