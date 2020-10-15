<?php
    $user = mysqli_real_escape_string($db_conn, $_POST['userEmail']);
    $sql = "SELECT * FROM " . $GLOBALS['accounts'] . " WHERE email = '$user'";

?>


<!-- Course Information -->

