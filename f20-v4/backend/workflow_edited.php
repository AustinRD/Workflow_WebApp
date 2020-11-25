<?php
include_once('db_connector.php');
include_once('config.php');
$newWorkflowOrder = str_replace(',', '=>', $_POST['hiddeninput']);
//$deptKey = $_POST['dept'];
$title = $_POST['workflowTitle'];
$stmt = "INSERT INTO f20_app_template_table (TSID, title, instructions) 
			VALUES (1, '$title', '$newWorkflowOrder')";
$prepare = $db_conn->query($stmt);
echo "Added workflow template '$title'.";
echo "New workflow template order: <br>";
echo $newWorkflowOrder;
mysqli_query($prepare, $stmt);

//if(mysqli_query($prepare, $stmt)){
	//echo "Workflow order updated";
//}
//else echo "Error: " . $stmt . "<br>" . mysqli_error($prepare);
//echo $_POST['deptkeypost'];
//echo $_POST["hiddeninput"];
?>
<br><br>
<a href="../dashboard.php?content=home">Return to Dashboard</a>