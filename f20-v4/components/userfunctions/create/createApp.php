<?php
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/create/create.php');
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    
    if (isset($_POST['appCreate'])) {
		$initiatorName = $_SESSION['user_name'];
		$initiatorID = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE user_name = '$initiatorName'"))['UID'];
		$title = $_POST['title'];
		$priority = $_POST['type'];
		$deadline = $_POST['deadline'];
		$templateID = $_POST['template'];
		$template = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_app_template_table WHERE ATPID = '$templateID'"))['instructions'];
		

        $insertApp = "INSERT INTO f20_app_table (ASID, ATID, UID, title, instructions, deadline, created) 
                            VALUES (2, '$priority', '$initiatorID', '$title', '$template', '2020-11-28 21:47:51', '2020-11-10 21:47:51')";
        $insertAppQuery = mysqli_query($db_conn, $insertApp);

        //Database insert success
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Workflow app created successfully.</p></div>");
        } 
		else { echo("<div class='w3-panel w3-margin w3-red'><p>Error - Message could not be sent.</p></div>");}
        //Database detected duplicate entry
        //else if (mysqli_errno($db_conn) == 1062) {  
         //   echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create User - Duplicate Found.</p></div>");
        //}
    }
?>

<!-- Admin Create Message -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <h5>Create Workflow App</h5>
    <form method="post" action="./dashboard.php?content=create&contentType=app">
        <label for="title">Title</label>
        <input id="title" name="title" type="text" class="w3-input" required>
        <br>
        <label for="type">Priority</label>
        <select id="type" name="type" class="w3-input">
		<option selected="" disabled="" hidden=""> Select a priority. </option>
		<option value="1" id="1">urgent</option>
		<option value="2" id="2">normal</option>
		</select>
        <br>
		<label for="deadline">Deadline</label>
        <input id="deadline" name="deadline" type="datetime-local" class="w3-input" required>
        <br>
		<label for="template">Workflow Template</label>
		<?php
			//Load templates
			include_once('./backend/config.php');
			include_once('./backend/db_connector.php');
			$sql = "SELECT ATPID, title from f20_app_template_table";
			$result = $db_conn->query($sql);
			if ($result->num_rows > 0){
				echo " <select class='w3-input' id='template' name='template'><option selected disabled hidden>Select a Workflow Template</option>";
				while($row = $result->fetch_assoc()){
			
					echo "<option value=".$row['ATPID']." id=".$row['ATPID'].">" .$row['title']. "</option>";
				}
			}
			echo "</select>";
        ?>
		<br>
        <button type="submit" class="w3-button w3-teal" name="appCreate">Submit</button>
    </form>
</div>