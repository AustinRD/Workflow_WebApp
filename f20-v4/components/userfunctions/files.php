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
    if($_SESSION['user_type'] == 1){
		$thisUser = $_SESSION['user_id'];

?>

<!-- User Search -->
<div id="userSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='../var/index.html'">Upload File</button>
    <p>You may search by ID, owner, type, or status</p>
    <input type="text" id="userInput" onkeyup="search('fileTable', 'userInput')"></input>
    <h5>Files</h5>
    <table id="fileTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
	    <th class="w3-center">ID</th>
	    <th class="w3-center">Owner</th>
	    <th class="w3-center">Data Type</th>
	    <th class="w3-center">Data Status</th>
            <th class="w3-center">Data Location</th>
            <th class="w3-center">Data Created</th>
            <th class="w3-center">Data Updated</th>
            <th class="w3-center">Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM f20_data_T JOIN f20_dataType_T ON f20_data_T.dataType_id = f20_dataType_T.dataType_id JOIN f20_dataStatus_T ON f20_data_T.dataStatus_id = f20_dataStatus_T.dataStatus_id";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
		$dataID = $row['data_id'];
		$dataOwner = $row['data_owner'];
		$ownerName = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE UID = '$dataOwner'"))['user_name'];
		$dataType = $row['dataType_title'];
		$dataStatus = $row['dataStatus_title'];
                $dataLocation = $row['data_location'];
                $dataCreated = $row['data_created'];
                $dataUpdated = $row['data_changed'];
        ?>
        <tr>
	    <td><?php echo $dataID; ?></td>
	    <td><?php echo $ownerName; ?></td>
	    <td><?php echo $dataType; ?></td>
	    <td><?php echo $dataStatus; ?></td>
            <td><a href="<?php echo $dataLocation; ?>"><?php echo $dataLocation; ?></a></td>
            <td><?php echo $dataCreated; ?></td>
            <td><?php echo $dataUpdated; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=file">
                    <!-- The hidden input field must be used to pass the account the user has selected
                        to the next page. -->
                    <input type="hidden" name="dataID" value="<?php echo $dataID;?>">
                    <button type="submit" name="viewFile" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
<?php } else { $thisUser = $_SESSION['user_id']; ?>
	
<!-- User Messages (non admins can only see their own messages)-->
<div id="messages" class="w3-card-4 w3-padding w3-margin">
	<form method="post" name="userCompose" action='./dashboard.php?content=create&contentType=message'>
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='../var/index.html'">Upload File</button>
    <p>You may search by ID, owner, type, or status</p>
    <input type="text" id="userInput" onkeyup="search('fileTable', 'userInput')"></input>
    <h5>Files</h5>
    <table id="fileTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th class="w3-center">ID</th>
	    <th class="w3-center">Owner</th>
	    <th class="w3-center">Data Type</th>
	    <th class="w3-center">Data Status</th>
            <th class="w3-center">Data Location</th>
            <th class="w3-center">Data Created</th>
            <th class="w3-center">Data Updated</th>
            <th class="w3-center">Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM f20_data_T JOIN f20_dataType_T ON f20_data_T.dataType_id = f20_dataType_T.dataType_id JOIN f20_dataStatus_T ON f20_data_T.dataStatus_id = f20_dataStatus_T.dataStatus_id WHERE owner_id = '$thisUser'";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
		$dataID = $row['data_id'];
		$dataOwner = $row['owner_id'];
		$ownerName = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE UID = '$dataOwner'"))['user_name'];
		$dataType = $row['dataType_title'];
		$dataStatus = $row['dataStatus_title'];
                $dataLocation = $row['data_location'];
                $dataCreated = $row['data_created'];
                $dataUpdated = $row['data_changed'];
        ?>
        <tr>
            <td><?php echo $dataID; ?></td>
	    <td><?php echo $ownerName; ?></td>
	    <td><?php echo $dataType; ?></td>
	    <td><?php echo $dataStatus; ?></td>
            <td><a href="<?php echo $dataLocation; ?>"><?php echo $dataLocation; ?></a></td>
            <td><?php echo $dataCreated; ?></td>
            <td><?php echo $dataUpdated; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=message">
                    <!-- The hidden input field must be used to pass the message the user has selected
                        to the next page. -->
                    <input type="hidden" name="message_ID" value="<?php echo $messageId;?>">
                    <button type="submit" name="viewMessage" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
<?php } ?>