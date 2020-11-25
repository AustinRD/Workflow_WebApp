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

<!-- Admin Messages (admin can see all messages)-->
<div id="messages" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=create&contentType=message'">Admin Compose Message</button>
    <h5>Messages</h5>
    <p>You may search by receiver, sender, subject, or message contents</p>
    <input type="text" id="userInput" onkeyup="search('messageTable', 'userInput')"></input>
    <table id="messageTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th class="w3-center">Sender</th>
            <th class="w3-center">Receiver</th>
            <th class="w3-center">Message Type</th>
            <th class="w3-center">Message Status</th>
			<th class="w3-center">Message Subject</th>
			<th class="w3-center">Message Contents</th>
            <th class="w3-center">Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM f20_message_T";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
				$messageId = $row['message_id'];
                $messageSenderId = $row['message_sender'];
				$messageSender = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE UID = '$messageSenderId'"))['user_name'];
                $messageReceiverId = $row['message_receiver'];
				$messageReceiver = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE UID = '$messageReceiverId'"))['user_name'];
                $messageTypeId = $row['message_type'];
				$messageType = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_messageType_T WHERE messageType_id = '$messageTypeId'"))['messageType_Title'];
                $messageStatusId = $row['message_status'];
				$messageStatus = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_messageStatus_T WHERE messageStatus_id = '$messageStatusId'"))['messageStatus_title'];
				$messageSubject = $row['message_subject'];
				$messageContents = $row['message_contents'];
        ?>
        <tr>
            <td><?php echo $messageSender; ?></td>
            <td><?php echo $messageReceiver; ?></td>
            <td><?php echo $messageType; ?></td>
            <td><?php echo $messageStatus; ?></td>
			<td><?php echo $messageSubject; ?></td>
			<td><?php echo $messageContents; ?></td>
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
	<?php } else { $thisUser = $_SESSION['user_id']; ?>
	
<!-- User Messages (non admins can only see their own messages)-->
<div id="messages" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=create&contentType=message'">Compose Message</button>
    <h5>Messages</h5>
    <p>You may search by receiver, sender, or message contents</p>
    <input type="text" id="userInput" onkeyup="search('messageTable', 'userInput')"></input>
    <table id="messageTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th class="w3-center">Sender</th>
			<th class="w3-center">Receiver</th>
            <th class="w3-center">Message Type</th>
            <th class="w3-center">Message Status</th>
			<th class="w3-center">Message Subject</th>
			<th class="w3-center">Message Contents</th>
            <th class="w3-center">Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM f20_message_T WHERE message_sender = '$thisUser' OR message_receiver = '$thisUser'";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
				$messageId = $row['message_id'];
                $messageSenderId = $row['message_sender'];
				$messageSender = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE UID = '$messageSenderId'"))['user_name'];
                $messageReceiverId = $row['message_receiver'];
				$messageReceiver = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE UID = '$messageReceiverId'"))['user_name'];
                $messageTypeId = $row['message_type'];
				$messageType = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_messageType_T WHERE messageType_id = '$messageTypeId'"))['messageType_Title'];
                $messageStatusId = $row['message_status'];
				$messageStatus = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_messageStatus_T WHERE messageStatus_id = '$messageStatusId'"))['messageStatus_title'];
				$messageSubject = $row['message_subject'];
				$messageContents = $row['message_contents'];
        ?>
        <tr>
            <td><?php echo $messageSender; ?></td>
			<td><?php echo $messageReceiver; ?></td>
            <td><?php echo $messageType; ?></td>
            <td><?php echo $messageStatus; ?></td>
			<td><?php echo $messageSubject; ?></td>
			<td><?php echo $messageContents; ?></td>
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