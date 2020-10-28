<?php
    //Loads the action bar so the user can navigate between pages.
    include_once('./components/userfunctions/workflows/workflows.php');
    //If this field is set then the user submitted the form to start the workflow.
    if(isset($_POST['studentSubmit'])) {
        //First we gather all the input field information.
        $workflowID = mysqli_real_escape_string($_POST['workflowID']);
        $firstname = mysqli_real_escape_string($_POST['studentFirstName']);
        $lastname = mysqli_real_escape_string($_POST['studentLastName']);
        $middlename = mysqli_real_escape_string($_POST['studentMiddleName']);
        $phonenum = mysqli_real_escape_string($_POST['studentPhone']);
        $address = mysqli_real_escape_string($_POST['studentAddress']);
        $aptnum = mysqli_real_escape_string($_POST['studentAptNum']);
        $city = mysqli_real_escape_string($_POST['studentCity']);
        $state = mysqli_real_escape_string($_POST['studentState']);
        $zip = mysqli_real_escape_string($_POST['studentZip']);
        $credits = mysqli_real_escape_string($_POST['studentCredits']);
        $workflowType = mysqli_real_escape_string($_POST['appType']);
        $workflowCredits = mysqli_real_escape_string($_POST['appCredits']);
        $workflowHours = mysqli_real_escape_string($_POST['appHours']);
        $outcome1 = mysqli_real_escape_string($_POST['outcomes1']);
        $outcome2 = mysqli_real_escape_string($_POST['outcomes2']);
        $outcome3 = mysqli_real_escape_string($_POST['outcomes3']);
        $employerOrganization = mysqli_real_escape_string($_POST['employerOrganization']);
        $employerFirstName = mysqli_real_escape_string($_POST['employerFirstName']);
        $employerLastName = mysqli_real_escape_string($_POST['employerLastName']);
        $employerEmail = mysqli_real_escape_string($_POST['employerEmail']);
        $employerPhone = mysqli_real_escape_string($_POST['employerPhone']);
        $employerStreet = mysqli_real_escape_string($_POST['employerStreet']);
        $employerBldNum = mysqli_real_escape_string($_POST['employerBldNum']);
        $employerCity = mysqli_real_escape_string($_POST['employerCity']);
        $employerState = mysqli_real_escape_string($_POST['employerState']);
        $employerZipcode = mysqli_real_escape_string($_POST['employerZipcode']);

        //This creates an entry for the student's information in the database attached with the workflow ID.
        $sql = "INSERT INTO f20_student_info (fw_id, student_first_name, student_last_name, student_middle_initial, 
            student_phone, student_address, student_apt_num, student_city, student_state, student_zip, credits_registered) 
            VALUES ('$workflowID','$firstname', '$lastname','$middlename','$phonenum','$address', '$aptnum', '$city', '$state','$zip', '$credits')";
        $query = mysqli_query($db_conn, $sql);
        if ($query) {
            echo("<div class='w3-card w3-green'>Student Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Error. Student Information Update Unsuccessful .</div>");
        }
        
        //This updates the missing fields from the workflow in the database.
        $sql = "UPDATE f20_application_info SET project_name = '$workflowType', academic_credits = '$workflowCredits', 
            hours_per_wk = '$workflowHours' WHERE fw_id = '$workflowID'";
        $query = mysqli_query($db_conn, $sql);
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-card w3-green'>Student Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Student Information Successfully Updated.</div>");
        }

        //This updates the application utility table in the database.
        $sql = "UPDATE f20_application_util SET rejected = '0', progress = '1', assigned_to = 'instructor@email.com' 
            WHERE fw_id = '$workflowID'";
        $query = mysqli_query($db_conn, $sql);
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-card w3-green'>Student Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Student Information Successfully Updated.</div>");
        }

        //This creates an entry in the company info table of the database.
        $sql = "INSERT INTO f20_company_info (fw_id, company_name, supervisor_email, supervisor_phone, supervisor_first_name,
            supervisor_last_name, company_address, company_address2, company_city, company_state, company_zip) 
            VALUES ('$workflowID','$employerOrganization', '$employerEmail', '$employerPhone', '$employerFirstName', '$employerLastName', '$employerStreet', '$employerBldNum', '$employerCity','$employerState', '$employerZip')";
        $query = mysqli_query($db_conn, $sql);
        if ($query) {
            echo("<div class='w3-card w3-green'>Business/Organization Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Error. Business/Student Information Update Unsuccessful .</div>");
        }
    }
    //If this field is set then the user came here from their list of active workflows.
    else if(isset($_POST['wfID'])) {
        $workflowID = $_POST['wfID'];
    }
    
?>

<script>
    //Hides the currently hardcoded Feed from workflows.php
    document.getElementById('activityFeed').style.display = 'none';
</script>

<!-- Form that starts the internship workflow from the student's side.--> 
<form method="post" action="./dashboard.php?content=startInternApp">
    <div class="w3-card-4 w3-margin w3-padding" id="studentInformation">
        <h5>Student Information</h5>
        <input type="hidden" name="workflowID" value="<?php echo $workflowID ?>">
        <label class="w3-input" for="studentFirstName">First name</label>
        <input type="text" class="w3-input" name="studentFirstName" id="studentFirstName" placeholder="Enter the Student's First Name." required>
        <label class="w3-input" for="studentLastName">Last name</label>
        <input type="text" class="w3-input" name="studentLastName" id="studentLastName" placeholder="Enter the Student's Last Name." required>
        <label class="w3-input" for="studentMiddleName">Middle Initial</label>
        <input type="text" class="w3-input" name="studentMiddleName" id="studentMiddleName" maxlength="1" placeholder="Enter the Student's Middle Initial.">
        <label class="w3-input" for="studentPhone">Phone number</label>
        <input type="tel" class="w3-input" name="studentPhone" id="studentPhone" placeholder="Enter the Student's Phone Number.">
        <label class="w3-input" for="studentCredits">Credits registered</label>
        <input type="number" name="studentCredits" id="studentCredits" maxlength="2" class="w3-input" placeholder="Enter the Number of Credits Registered." required>
        <br>
        <h5>Student Address</h5>
        <label class="w3-input" for="studentAddress">Street</label>
        <input type="text" class="w3-input" name="studentAddress" id="studentAddress" placeholder="Enter the Student's street address." required>
        <label class="w3-input" for="studentAptNum">Apartment Number</label>
        <input type="text" class="w3-input" name="studentAptNum" id="studentAptNum" placeholder="Enter the Apartment or suite">
        <label class="w3-input" for="studentCity">City</label>
        <input type="text" class="w3-input" name="studentCity" id="studentCity" placeholder="Enter the Student's City." required>
        <label class="w3-input" for="studentState">State</label>
        <select class="w3-input" name="studentState" id="studentState" required>
            <option value="">Select the Student's State.</option>
            <!-- File that contains the list of states. -->
            <?php include('./util/states.php') ?>
        </select>
        <label class="w3-input" for="studentZip">Zip</label>
        <input type="text" class="w3-input" name="studentZip" id="studentZip" placeholder="Enter the Student's Zip Code." required>
        <br>
        <button type="button" name="continue" class="w3-button w3-teal" onclick="document.getElementById('studentInformation').style.display = 'none'; document.getElementById('internshipInformation').style.display = 'block';">Continue</button>
    </div>
    <div class="w3-card-4 w3-margin w3-padding" id="internshipInformation" style="display:none;">
        <h5>Internship/Fieldwork Information</h5>
        <label class="w3-input" for="appType">Internship/Fieldwork Type</label>
        <select class="w3-input" name="appType" id="appType" required>
            <option value="Internship">Internship</option>
            <option value="Independent Study">Independent Study</option>
        </select>
        <label class="w3-input" for="appCredits">Academic credits</label>
        <input type="number" class="w3-input" name="appCredits" id="appCredits" step="1" min="1">
        <label class="w3-input" for="appHours">Number of Hours/Week</label>
        <input type="number" class="w3-input" name="appHours" id="appHours" min="0" step="1">
        <br>
        <h5>Learning Outcomes</h5>
        <label class="w3-input" for="outcomes1">
            1.) What are your responsibilities on site?<br>
            2.) What special project will you be working on?<br>
            3.) What do you expect to learn?
        </label>
        <input type="text" class="w3-input" name="outcomes1" id="outcomes1" required></input>
        <label class="w3-input" for="outcomes2">
            1.) How is the proposal related to your major areas of interest?<br>
            *.) Describe the course work you have completed which provides appropriate background to the project.
        </label>
        <input type="text" class="w3-input" name="outcomes2" id="outcomes2" required></input>
        <label class="w3-input" for="outcomes3">
            1.) What is the proposed method of study?<br>
            *.) Where appropriate, cite readings and practical experience.
        </label>
        <input type="text" class="w3-input" name="outcomes3" id="outcomes3" required></input>
        <br>
        <button type="button" name="continue" class="w3-button w3-teal" onclick="document.getElementById('internshipInformation').style.display = 'none'; document.getElementById('employerInformation').style.display = 'block';">Continue</button>
        <button type="button" name="back" class="w3-button w3-teal" onclick="document.getElementById('studentInformation').style.display = 'block'; document.getElementById('internshipInformation').style.display = 'none';">Back</button>
    </div>
    <div class="w3-card-4 w3-margin w3-padding" id="employerInformation" style="display:none;">
        <h5>Employer Information</h5>
        <label class="w3-input" for="employerOrganization">Name of Organization: </label>
        <input type="text" class="w3-input" name="employerOrganization" id="employerOrganization" placeholder="Enter the Organization or Business's Name.">
        <label class="w3-input" for="employerFirstName">First name</label>
        <input type="text" class="w3-input" name="employerFirstName" id="employerFirstName" placeholder="Enter the Employer's First Name." required>
        <label class="w3-input" for="lastName">Last name</label>
        <input type="text" class="w3-input" name="employerLastName" id="employerLastName" placeholder="Enter the Employer's Last Name." required>
        <label class="w3-input" for="employerEmail">Email </label>
        <input type="email" class="w3-input" name="employerEmail" id="employerEmail" placeholder="Enter the Employer's Email.">
        <label class="w3-input" for="employerPhone">Phone number</label>
        <input type="tel" class="w3-input" name="employerPhone" id="employerPhone" maxlength=10 placeholder="Enter the Employer's Phone.">
        <br>
        <h5>Organization/Business Location</h5>
        <label class="w3-input" for="employerStreet">Street</label>
        <input type="text" class="w3-input" name="employerStreet" id="employerStreet" required>
        <label class="w3-input" for="employerBldNum">Building/Suite#</label>
        <input type="text" class="w3-input" name="employerBldNum" id="employerBldNum">
        <label class="w3-input" for="employerCity">City</label>
        <input type="text" class="w3-input" name="employerCity" id="employerCity" required>
        <label class="w3-input" for="employerState">State</label>
        <select class="w3-input" name="employerState" id="employerState" required>
            <option value="">Select the State.</option>
            <?php include('./util/states.php') ?>
        </select>
        <label class="w3-input" for="employerZipcode">Zip</label>
        <input type="text" name="employerZipcode" id="employerZipcode" class="w3-input" required>
        <br>
        <button type="submit" name="studentSubmit" class="w3-button w3-teal">Submit</button>
        <button type="button" name="back" class="w3-button w3-teal" onclick="document.getElementById('internshipInformation').style.display = 'block'; document.getElementById('employerInformation').style.display = 'none';">Back</button>
    </div>
</form>