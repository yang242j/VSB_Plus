<?php
/**
 * Do the logout function
 * 
 * Requirments:
 *  1) Session variables should be re-initialized
 *  3) Destroy the session
 * 
 * php Steps:
 *  1) Start session
 *  2) Reinitialize the session to empty array
 *  3) Destroy session
 *  4) Redirect to login page
 *  5) Exit
 * 
 * @version     1.0
 * @author      Jingkang Yang (sid: 200362586) <yang242j@uregina.ca>
 */

// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: ../login.php");
exit;
?>