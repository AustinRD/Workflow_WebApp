<!--
    This file displays all results from the user table in the database 
    into an html table. All users except employers/supervisors, and students
    could have use for this table in looking up other faculty to put on a
    custom workflow, or finding students who would like to start a workflow.
-->

<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/search/search.php')
?>

<!-- User Search -->
<div id="userSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=create&contentType=user'">Create User</button>
    <h5>User Search</h5>
    <p>You may search by ID or Email</p>
    <input type="text" id="userInput" onkeyup="search('userTable', 'userInput')"></input>
    <table id="userTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th class="w3-center">Name</th>
            <th class="w3-center">Email</th>
            <th class="w3-center">Account Type</th>
            <th class="w3-center">Account Status</th>
            <th class="w3-center">Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM f20_user_table
                JOIN f20_user_role_table 
                    ON f20_user_table.URID = f20_user_role_table.URID
                JOIN f20_user_status_table
                    ON f20_user_table.USID = f20_user_status_table.USID";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $UID = $row['UID'];
                $userName = $row['user_name'];
                $userEmail = $row['user_email'];
                $userType = $row['user_role_title'];
                $userStatus = $row['user_status'];
        ?>
        <tr>
            <td><?php echo $userName; ?></td>
            <td><?php echo $userEmail; ?></td>
            <td><?php echo $userType; ?></td>
            <td><?php echo $userStatus; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=user">
                    <!-- The hidden input field must be used to pass the account the user has selected
                        to the next page. -->
                    <input type="hidden" name="UID" value="<?php echo $UID;?>">
                    <button type="submit" name="viewUser" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>