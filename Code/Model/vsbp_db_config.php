<?php
/**
 * Connect to server database "vsb_plus"
 * 
 * Requirments:
 *  1) If connection is goes false, print the error
 * 
 * php Steps:
 *  1) define server
 *  2) make connection
 *  3) If connection is false, print the error
 * 
 * @version     1.0
 * @link        http://15.223.123.122/vsbp/Code/Model/takenClass.php
 * @link        http://15.223.123.122/vsbp/Code/Model/sign_in.php
 * @author      Jingkang Yang (sid: 200362586) <yang242j@uregina.ca>
 */

// define('DB_SERVER', 'localhost');
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'vsbp');
define('DB_NAME', 'vsb_plus');
 
/* Attempt to connect to MySQL database */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($conn === FALSE){
    die("ERROR! Connection FAILED: " . mysqli_connect_error());
} else {
    $conn_message = "<script>
    console.log( 'DB_SERVER: " . DB_SERVER . "');
    console.log( 'DB_NAME: " . DB_NAME . "');
    </script>";
    //echo $conn_message;
}
?>