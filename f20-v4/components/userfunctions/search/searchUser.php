<!--

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
            <th class="w3-center">Last Login</th>
            <th class="w3-center">Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM `f20_user_table`";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $userEmail = $row['email'];
                $userType = $row['profile_type'];
                $lastAccess = $row['last_access'];
        ?>
        <tr>
            <td><?php echo " " ?></td>
            <td><?php echo $userEmail; ?></td>
            <td><?php echo $userType; ?></td>
            <td><?php echo $lastAccess; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=user">
                    <input type="hidden" name="userEmail" value="<?php echo $userEmail;?>">
                    <button type="submit" name="viewUser" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>