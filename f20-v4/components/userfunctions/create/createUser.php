<!-- 
    This file is for creating users it may need work 
    1. Implement user creation
    2. Add password(generate random or make user pick)
    3. Add password field to database.
    3. Add name field to database.
-->
<?php
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/create/create.php');
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    
    if (isset($_POST['userCreate'])) {
        $userName = mysqli_real_escape_string($db_conn, $_POST['name']);
        $userEmail = mysqli_real_escape_string($db_conn, $_POST['email']);
        $userType = mysqli_real_escape_string($db_conn, $_POST['type']);
        $userPass = mysqli_real_escape_string($db_conn, $_POST['pswd']);

        $insertUser = "INSERT INTO f20_user_table (URID, USID, user_email, user_password, user_name) 
                            VALUES ($userType, 1,'$userEmail','$userPass', '$userName')";
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

<!-- Create User -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <h5>Create User</h5>
    <form method="post" action="./dashboard.php?content=create&contentType=user">
        <label for="name">Full Name</label>
        <input id="name" name="name" type="text" class="w3-input" placeholder="Enter the user's Full Name" required>
        <br>
        <label for="email">Email Address</label>
        <input id="email" name="email" type="email" class="w3-input" placeholder="@newpaltz.edu" required>
        <br>
        <label for="pswd">Password</label>
        <input id="pswd" name="pswd" type="password" class="w3-input" required>
        <br>
        <label for="type">User Type</label>
        <select id="type" name="type" class="w3-input" required>
            <option value="">Select a user type.</option>
            <?php
                $sql = "SELECT * FROM f20_user_role_table";
                $query = mysqli_query($db_conn, $sql);
                while ($row = mysqli_fetch_assoc($query)) {
                    echo("<option value='" . $row['URID'] . "'>" . $row['user_role_title'] . "</option>");
                }
            ?>
        </select>
        <br>
        <button type="submit" class="w3-button w3-teal" name="userCreate">Create</button>
    </form>
</div>