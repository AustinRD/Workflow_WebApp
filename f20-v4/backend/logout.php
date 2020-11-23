<?php
    /**
     * This logout page clears all data from session and redirects to login page. 
     * Under special circumstance it can be given request for special log out messages
     * such as unauthorized or inactivity.
     */
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    // remove all session variables
    session_unset();

    // destroy the session 
    session_destroy();
    include_once './util.php';
    if (isset($_GET['inactive'])) {
        $id = $_GET['inactive'];
        if ($id == $GLOBALS['Inactivity']) {
            header("Location: ../index.php?inactive=1");
        }
    }
    else if(isset($_GET['authorized'])){
        $a = $_GET['authorized'];
        if($a == 'false'){
        header("Location: ../index.php?unauthorized=true&redirect=true");
        }
    }

    else{
        header("Location: ../index.php");
    }
?>