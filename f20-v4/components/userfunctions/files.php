<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        header('Location: ./index.php');
    }
?>
<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    //Loading the page title and action buttons.
?>

<!-- User Search -->
<div id="userSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=create&contentType=files'">Upload File</button>
    <h5>Files</h5>
    <table id="userTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th class="w3-center">Data Location</th>
            <th class="w3-center">Data Created</th>
            <th class="w3-center">Data Updated</th>
            <th class="w3-center">Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM f20_data_T";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $dataLocation = $row['data_location'];
                $dataCreated = $row['data_created'];
                $dataUpdated = $row['data_changed'];
        ?>
        <tr>
            <td><?php echo $dataLocation; ?></td>
            <td><?php echo $dataCreated; ?></td>
            <td><?php echo $dataUpdated; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=file">
                    <!-- The hidden input field must be used to pass the account the user has selected
                        to the next page. -->
                    <input type="hidden" name="userEmail" value="<?php echo $userEmail;?>">
                    <button type="submit" name="viewUser" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>