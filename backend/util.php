<?php
   if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

include_once 'config.php';

/**
* A function that does a javascript alert 
*/
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

/**
 * Gets api url from config
 */

function getAPI(){
    return API_URL;
}
/**
 * redirects based on account type. 
 * This mehtod can also force a redirect to login page.
 *
 * @param string       account type to check for
 * @return void              
 */
function redirect($atype){

    if ($atype == $GLOBALS['admin_type']) {
        header("Location: ./admin/admin.php");
      //exit;
    } else if ($atype == $GLOBALS['student_type']) {
        header("Location: ./student/student.php");
        exit();
    } else if ($atype == $GLOBALS['secretary_type']) {
        header("Location: ./secretary/secretary.php");
        exit();
    } else if ($atype == $GLOBALS['chair_type']) {
        header("Location: ./chair/chair.php");
        exit();
    } else if ($atype == $GLOBALS['dean_type']) {
        header("Location: ./dean/dean.php");
        exit();
    } else if ($atype == $GLOBALS['instructor_type']) {
        header("Location: ./instructor/instructor.php");
        exit();
    } else if ($atype == $GLOBALS['employer_type']) {
        header("Location: ./employer/employer.php");
        exit();
    } else if ($atype == $GLOBALS['recreg_type']) {
        header("Location: ./recreg/recreg.php");
        exit();
    }
    else if($atype == null){
        header("Location: ../backend/logout.php");
        exit();
    }
    else if($atype == "inactive"){
        header("Location: ../backend/logout.php?inactive=1");
        exit();
    }
    
  }
  
  
/** A validating function that prevents unauthorized users from viewing other pages. ex: student cant 
 * view instructor pages. This is log you out and show you an unauthorized notice.
 * @param string the type to check for
 * @return void returns nothing.
*/
function validate($checktype){
    if(!(isset($_SESSION['user_type']) and $_SESSION['user_type'] == $checktype)){
        header('Location: ../backend/logout.php?authorized=false');
    }
}


/**
* A function for logging a message to the console under web browser inspect
* @param string message to output. This pretty much can take anything displayable
*/
function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }
  
/**
 * Generates an alphanumeric password using uppercase and lowercase
 * letters of a specified length.
 *
 * @param int       $length     The specified length of the password.
 * @return string               A password of specified length.
 */
function generatePassword($length)
{
    $characters = [
        '0', '1', '2', '3', '4', '5', '6', '7', '8',
        '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k',
        'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w',
        'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I',
        'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U',
        'V', 'W', 'X', 'Y', 'Z'
    ];

    $result = "";

    for ($i = 0; $i < $length; $i++) {
        $result = $result . $characters[rand(0, 62)];
    }

    return $result;
}

/**
 * Sends an e-mail with the specified subject to a desired recipient.
 * The e-mail will be sent as an RFC multipart-alternative e-mail with
 * a plaintext part and an HTML part. The standards conform to RFC1341.
 *
 * For line breaks, use \n; this function will use a regular expression
 * to replace all \n's to their appropriate line breaks (that is,
 * plaintext must use \r\n, and HTML must close a paragraph, then \r\n,
 * then start a new paragraph.)
 *
 * MIME boundaries are randomly generated using a call to
 * generatePassword(8).
 *
 * @example backend/create-user.php     We use a call of this to welcome a new user in the system.
 *
 * @param string    $email      The e-mail address of the recipient.
 * @param string    $subject    The subject of the e-mail.
 * @param string    $message    The message contents of the e-mail.
 *
 * @return bool     True if mail was sent, false otherwise. Same as a normal call to mail().
 */
function sendEmail($email, $subject, $message)
{
    $BOUNDARY = "mime-boundary-" . generatePassword(8);
    $EMAIL_FROM = MAIL_FROM . " <" . MAIL_FROM . ">";

    // The plaintext part of the email (changing \n to \r\n)
    $PLAIN_TEXT_PART = preg_replace("/\n/", "\r\n", $message) .
        "\r\nTo go back to the field work system, go to " . API_URL . " in your web browser.";

    // The HTML part of the e-mail (changing \n to a paragraph end tag, \r\n, then a paragraph begin)
    $HTML_PART = file_get_contents("email-template/email-top.html", FILE_USE_INCLUDE_PATH)
        . "<p>" . preg_replace("/\n/", "</p>\r\n<p>", $message) .
        file_get_contents("email-template/email-bottom.html", FILE_USE_INCLUDE_PATH);

    // Right now, this is how I incorporate RFC-compliant multipart e-mail.
    // This string builder code isn't exactly pretty.
    $FINAL_MESSAGE = "--" . $BOUNDARY . "\r\nContent-type: text/plain; charset=UTF-8\r\n\r\n" .
        $PLAIN_TEXT_PART . "\r\n\r\n\r\n--" . $BOUNDARY .
        "\r\nContent-type: text/html; charset=UTF-8\r\n\r\n" . $HTML_PART .
        "\r\n\r\n\r\n--" . $BOUNDARY . "--";

    return mail(
        $email,
        $subject,
        $FINAL_MESSAGE,
        "From: " . $EMAIL_FROM . "\r\n" .
            "Reply-To: " . $EMAIL_FROM . "\r\n" .
            "Return-Path: " . $EMAIL_FROM . "\r\n" .
            "MIME-Version: 1.0" .  "\r\n" .
            "Content-type: multipart/alternative; boundary=\"$BOUNDARY\"\r\n\r\n"
    );
}


/**
 * Generates a banner-like number for an employer.
 * Starts with E, followed by 8 digits.
 * 
 * @return string A banner-like ID number for an employer.
 */
function generateEmployerID()
{
    return "E" . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
}

/**
 * Generates a banner-like number for an admin.
 * Starts with A, followed by 8 digits.
 * 
 * @return string A banner-like ID number for an admin account. Required for UserPass table where it cannot be empty.
 */
function generateAdminID()
{
    return "A" . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
}

/**
 * Generates a banner-like number for an secretary.
 * Starts with E, followed by 8 digits.
 * 
 * @return string A banner-like ID number for an Secretary. Required for UserPass table where it cannot be empty.
 */
function generateSecretaryID()
{
    return "S" . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
}
