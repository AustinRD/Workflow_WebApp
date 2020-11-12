<!-- Dashboard Header -->
<?php
include_once('./backend/config.php');
switch ($_SESSION['user_type']) {
    case $GLOBALS['student_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Student Dashboard</b></h5>
            </header>");
        break;
    case $GLOBALS['admin_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Admin Dashboard</b></h5>
            </header>");
        break;
    case $GLOBALS['secretary_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Secretary Dashboard</b></h5>
            </header>");
        break;
    case $GLOBALS['chair_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Chair Dashboard</b></h5>
            </header>");
        break;
    case $GLOBALS['dean_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Dean Dashboard</b></h5>
            </header>");
        break;
    case $GLOBALS['faculty_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Faculty Dashboard</b></h5>
            </header>");
        break;
    case $GLOBALS['employer_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Employer Dashboard</b></h5>
            </header>");
        break;
    case $GLOBALS['recreg_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Records and Registration Dashboard</b></h5>
            </header>");
        break;
    case $GLOBALS['crc_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Career Resource Center Dashboard</b></h5>
            </header>");
        break;
}
?>