<!-- 
    This file is meant to be used with AJAX to populate a course field given
    any department in the header with a get request. 
    
    This file is current used in:
    /components/workflows/startWorkflow.php 
-->
<?php
    include_once('./config.php');
    include_once('./db_connector.php');
    $q = $_GET['q'];

    $sql="SELECT * FROM `f20_course_numbers` WHERE `dept_code` = '". $q ."'";
    $result = mysqli_query($db_conn,$sql);

    echo("<option value=''>Select a course.</option>");

    while($row = mysqli_fetch_array($result)) {
        echo("<option value='$row[course_number]'>$row[course_number]</option>");
    }
    mysqli_close($db_conn);
?>