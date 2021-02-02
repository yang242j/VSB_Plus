<?php
/* 
Connect to server 
database "vsb_plus" 
*/
define('DB_SERVER', '15.223.123.122');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'vsbp');
define('DB_NAME', 'course');
 
/* Attempt to connect to MySQL database */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($conn === FALSE){
    die("ERROR! Connection FAILED: " . mysqli_connect_error());
} else {
    $conn_message = "<script>
    console.log( 'Connection: " . $conn . "' );
    console.log( 'DB_SERVER: " . DB_SERVER . "');
    console.log( 'DB_NAME: " . DB_NAME . "');
    </script>";
    echo $conn_message;
}
?>