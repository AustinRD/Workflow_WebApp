<?php
    //Resume session.
    if(!isset($_SESSION))
    {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        header('Location: ./index.php');
    }

    //Connect database.
    include_once('./backend/db_connector.php');
    include_once('./backend/util.php');

    //Check if a workflow ID was sent to the page.
    if (isset($_POST['wfID'])) {
        $wfID = $_POST['wfID'];
        $studentEmail = $_SESSION['user_email'];

        //Query to see if the user has permission to view the application.
        $sql  = "SELECT * FROM f20_application_info WHERE fw_id = '$wfID' AND student_email = '$studentEmail'";
        $qsql  = mysqli_query($db_conn, $sql);
        $r = mysqli_num_rows($qsql);
        
        //If the user has permission and the application is found.
        if ($r == 1) {  
            $result = mysqli_fetch_assoc($qsql);
            $title = $result['project_name'];
            $semester = $result['semester'] . " " . $result['year'];
            $classnumber = $result['dept_code'] . " " . $result['course_number'];
            $grademode = $result['grade_mode'];
            $credits = $result['academic_credits'];
            $hours = $result['hours_per_wk'];
        }
        else {
            //If the user does not have permission to view the application.
            exit(header('Location: ./workflows.php'));
        }
        //Second query for application information.
        $utilsql = "SELECT * FROM f20_application_util WHERE fw_id = '$wfID'";
        $query = mysqli_query($db_conn, $utilsql);
        $result = mysqli_fetch_assoc($query);
        $rejected = $result['rejected'];
        $comments = $result['comments'];
        $stage = $result['assigned_to'];
        $progress = $result['progress'];
        if ($rejected == 1 or $stage == "student" or $progress == -1) {
            $showedits = true;
        } 
    } 
    else {
        //If no workflow ID was sent to this page.
        exit(header('Location: ./workflows.php'));
    }
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-share-alt"></i>  View Workflow</b></h5>
</header>

<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" onClick="openForm('activeWF')">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-user w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Student</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onClick="openForm('newWF')">
    <div class="w3-container w3-teal w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-graduation-cap w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Course</h5></div>
    </div>
    </div>
    <div class="w3-quarter">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-briefcase w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Employer</h5></div>
    </div>
    </div>
    <div class="w3-quarter">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-book w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Learning</h5></div>
    </div>
    </div>
</div>

<?php 
    if ($rejected) {
        echo('<div class="w3-card-4 w3-padding w3-red" style="width: auto">'
                . '<h6><strong>Application Denied.</strong></h6>'
                . '<h6>Reason:</h6>'
                . $comments
                . '</div>'
        );
    }
?>

<!-- Student Information -->
<div class="w3-card-4 w3-padding w3-margin">
    <h5>Student Information</h5>
    <table>
        <?php
            $sql  = "SELECT * FROM f20_student_info WHERE fw_id = '$wfID'";
            $stusql  = mysqli_query($db_conn, $sql);
            $result = mysqli_fetch_assoc($stusql);

            $name = $result['student_first_name'] . " " . $result['student_last_name'];
            if ($result['student_apt_num'] == null) {
                $address = $result['student_address'] . " " . $result['student_city'] . ", " . $result['student_state'] . ", " . $result['student_zip'];
            } 
            else {
                $address = $result['student_address'] . " " . $result['student_apt_num'] . ", " . $result['student_city'] . ", " . $result['student_state'] . ", " . $result['student_zip'];
            }
            $phone = $result['student_phone'];
            $creditreg = $result['credits_registered'];
        ?>
        <tbody>
            <tr>
                <td scope="row">Name:</td>
                <td><?php echo $name; ?></td>
            </tr>
            <tr>
                <td scope="row">Address:</td>
                <td><?php echo $address; ?></td>
            </tr>
            <tr>
                <td scope="row">Phone:</td>
                <td><?php echo $phone; ?></td>
            </tr>
            <tr>
                <td scope="row">Credits Registered:</td>
                <td><?php echo $creditreg; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Course Information -->
<div class="w3-card-4 w3-padding w3-margin">
    <h5>Course Information</h5>
    <table>
        <tbody>
            <tr>
                <td scope="row">Course Number</td>
                <td><?php echo $classnumber; ?></td>
            </tr>
            <tr>
                <td scope="row">Academic Semester</td>
                <td><?php echo $semester; ?></td>
            </tr>
            <tr>
                <td scope="row">Grading Type</td>
                <td><?php echo $grademode; ?></td>
            </tr>
            <tr>
                <td scope="row">Credit Hours</td>
                <td><?php echo $credits; ?></td>
            </tr>
            <tr>
                <td scope="row">Number of Hours/Week</td>
                <td><?php echo $hours; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Employer Information -->
<div class="w3-card-4 w3-padding w3-margin">
    <h5>Employer Information</h5>
    <table>
        <?php
            $sql = "SELECT * FROM f20_company_info WHERE fw_id = '$wfID'";
            $empsql = mysqli_query($db_conn, $sql);
            $r         = mysqli_num_rows($empsql);
            $result    = mysqli_fetch_assoc($empsql);
            $name = $result['supervisor_first_name'] . " " . $result['supervisor_last_name'];
            $company   = $result['company_name'];
            $email     = $result['supervisor_email'];
            $phone     = $result['supervisor_phone'];
            if ($result['company_address2'] == null) {
                $address = $result['company_address'] . " " . $result['company_city'] . " " . $result['company_state'] . " " . $result['company_zip'];
            } else {
                $address = $result['company_address'] . ", " . $result['company_address2'] . ", " . $result['company_city'] . ", " . $result['company_state'] . ", " . $result['company_zip'];
            }
        ?>
        <tbody>
            <tr>
                <td scope="row">Name</td>
                <td><?php echo $name; ?></td>
            </tr>

            <tr>
                <td scope="row">Company</td>
                <td><?php echo $company; ?></td>
            </tr>
            <tr>
                <td scope="row">Email</td>
                <td><?php echo $email; ?></td>
            </tr>
            <tr>
                <td scope="row">Phone number</td>
                <td><?php echo $phone; ?></td>
            </tr>
            <tr>
                <td scope="row">Site Address</td>
                <td><?php echo $address; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Learning Outcomes -->
<div class="w3-card-4 w3-padding w3-margin">
    <h5>Learning Outcomes</h5>
    <table>
        <?php
            $losql = "SELECT * FROM f20_project_info WHERE fw_id = '$wfID'";
            $loquery  = mysqli_query($db_conn, $losql);
            $r = mysqli_num_rows($loquery);
            $result = mysqli_fetch_assoc($loquery);
            $firstresponse = $result['project_response1'];
            $secondresponse = $result['project_response2'];
            $thirdresponse = $result['project_response3'];
        ?>
        <tbody>
            <tr>
                <th scope="row">What are your responsibilities on the site? What special project will you be working on? What do you expect to learn? </th>
            </tr>
            <tr>
                <td><?php echo $firstresponse; ?></td>
            </tr>
            <tr>
                <th scope="row">How is the proposal related to your major areas of interest? Describe the course work you have completed which provides appropriate background to the project.</th>
            </tr>
            <tr>
                <td><?php echo $secondresponse; ?></td>
            </tr>
            <tr>
                <th scope="row">What is the proposed method of study? Where appropriate, cite readings and practical experience.</th>
            </tr>
            <tr>
                <td><?php echo $thirdresponse; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php
    if (isset($_POST['modify'])) {
        $wfIDsubmit = mysqli_real_escape_string($db_conn, $_POST['modify']);
        $sql = "SELECT * FROM f20_application_util WHERE fw_id = '$wfID'";  //check the status of the current application at time of submit
        $query = mysqli_query($db_conn, $sql);
        $result = mysqli_fetch_assoc($query);

        if ($result['progress'] == 0 and strtolower($result['assigned_to']) == "student") {  //start of a new app
            $update = "UPDATE f20_application_util SET rejected='0', progress ='1' WHERE fw_id ='$wfID'";
            $up = mysqli_query($db_conn, $update);
            if ($up) {
                //get workflow order
                //get next person in workflow 
                //set assigned to who in the position 1
                $getworkflowsql = "SELECT f20_application_info.dept_code, workflow FROM f20_workflow_order, f20_application_info WHERE fw_id='$wfID' AND f20_workflow_order.dept_code = f20_application_info.dept_code";
                $getworkflowquery = mysqli_query($db_conn, $getworkflowsql);
                if (mysqli_errno($db_conn) == 0) {
                    $getworkflowresult = mysqli_fetch_assoc($getworkflowquery);
                    $order = unserialize($getworkflowresult['workflow']);
                    
                    if (count($order) >= 1) {
                        $neworder = $order[1];
                    }

                    $updateAssignedToSQL = "UPDATE f20_application_util SET assigned_to = '$neworder' WHERE fw_id='$wfID'";
                    $updateAssignedToquery = mysqli_query($db_conn, $updateAssignedToSQL);

                    if (mysqli_errno($db_conn) == 0) {
                        header('Location: ./review.php?wfID=' . $wfID.'&success=true&redirect=true');  
                    }
                } 
                else {
                    alert("appsubmit error :" . mysqli_errno($db_conn));
                }
            } 
            else if ($result['rejected'] == 1) {
                $update = "UPDATE f20_application_util SET rejected='0' WHERE fw_id ='$wfID'";
                $in = mysqli_query($db_conn, $update);
                if ($in) {
                    // confirmation then redirect
                    header('Location: ./application.php');
                } 
                else {
                    alert("appsubmit error :" . mysqli_errno($db_conn));
                }
            }
        }
    }
?>
