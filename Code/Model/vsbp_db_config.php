<?php
/* 
Connect to server 
database "vsb_plus" 
*/
$host = "15.223.123.122";
$username = 'root';
$pass = "vsbp";
$database = "course";
$conn = mysqli_connect($host, $username, $pass, $database);
 
// Check connection
if($conn === FALSE){
    die("ERROR! Connection FAILED: " . mysqli_connect_error());
} else {
    $conn_message = "<script>
    console.log( 'Connection: " . $conn . "' );
    console.log( 'DB_SERVER: " . $host . "');
    console.log( 'DB_NAME: " . $database . "');
    </script>";
    echo $conn_message;
}
?>