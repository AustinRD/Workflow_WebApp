<!-- 
    This file is for creating users it may need work 
    1. Implement user creation
    2. Add password(generate random or make user pick)
    3. Add password field to database.
    3. Add name field to database.
-->
<?php
    if (isset($_POST['userCreate'])) {
        include_once('./backend/config.php');
        include_once('./backend/db_connector.php');
        
        $userName = mysqli_real_escape_string($db_conn, $_POST['name']);
        $userEmail = mysqli_real_escape_string($db_conn, $_POST['email']);
        $bannerID = mysqli_real_escape_string($db_conn, $_POST['banner']);
        $userType = mysqli_real_escape_string($db_conn, $_POST['type']);
        $userPass = mysqli_real_escape_string($db_conn, $_POST['pswd']);

        $insertUser = "INSERT INTO f20_userpass (email, passcode, profile_type, verified, first_time) 
                            VALUES ('$userEmail', '$userPass', '$userType', 1, 0)";
        $insertUserQuery = mysqli_query($db_conn, $insertUser);

        //Database insert success
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-panel w3-margin w3-green'><p>User Successfully Created.</p></div>");
        } 
        //Database detected duplicate entry
        else if (mysqli_errno($db_conn) == 1062) {  
            echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create User - Duplicate Found.</p></div>");
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

<!-- Create User -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <h5>Create User</h5>
    <form method="post" action="./dashboard.php?content=create">
        <label for="name">Name</label>
        <input id="name" name="name" type="text" class="w3-input" required>
        <br>
        <label for="email">Email Address</label>
        <input id="email" name="email" placeholder="@newpaltz.edu" type="email" class="w3-input" required>
        <br>
        <label for="pswd">Password</label>
        <input id="pswd" name="pswd" type="password" class="w3-input" required>
        <br>
        <label for="banner">Banner ID</label>
        <input id="banner" name="banner" type="text" class="w3-input" required>
        <br>
        <label for="type">User Type</label>
        <select id="type" name="type" class="w3-input" required>
            <option value="admin">Admin</option>
            <option value="recreg">Records & Registration</option>
            <option value="crc">Career Resource Center</option>
            <option value="dean">Dean</option>
            <option value="chair">Department Chair</option>
            <option value="secretary">Secretary</option>
            <option value="student">Student</option>
            <option value="employer">Employer</option>
            <option value="instructor">Faculty [Advisor/Instructor]</option> 
        </select>
        <br>
        <button type="submit" class="w3-button w3-teal" name="userCreate">Create</button>
    </form>
</div>