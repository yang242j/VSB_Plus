<!DOCTYPE html>
<html lang="en">
<head>
<?php
echo"hello world";
    phpinfo();
?>
</head>


</html>
<?php
    phpinfo();
?>
<?php
    $host = "15.233.123.122";
    $username = 'root';
    $pass = "vsbp";
    $database = "course";
    $con = mysqli_connect($host, $username, $pass, $database);
    if (!$con){
        echo "Error: Unable to connect to MySQL.". PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    }
    
    echo "Succes: ". PHP_EOL;
    echo "host info: " . mysqli_get_host_info($con) . PHP_EOL;

    mysqli_close($con);
?>