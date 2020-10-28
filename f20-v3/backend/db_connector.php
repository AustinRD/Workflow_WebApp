<?php
    include_once('config.php');

    // Connect to database
    $db_conn = new mysqli($server, $user, $pass, $db);
    // Check connection
    if ($db_conn->connect_error) {
        die("Connection failed: " . $db_conn->connect_error);
    }
?>