<?php
    $host = "localhost";
    // $host = "15.223.123.122";
    $username = 'root';
    $pass = "vsbp";
    $database = "course";
    $conn = mysqli_connect($host, $username, $pass, $database);
    if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM course";
    $result = mysqli_query($conn, $sql);
    $data = array();
    while($row = mysqli_fetch_array($result)){
        $course = array("short_name"=>$row['short_name'], 
        "title"=>$row["title"],
        "faculty"=>$row["faculty"],
        "credit"=>$row["credit"],
        "description"=>$row["description"],
        "prerequisite"=>$row["prerequisite"]);
        array_push($data, json_encode($course));
    }
    // print_r($data);
    // echo json_encode(array_values($data));
    $json_data = json_encode($data);
    echo $json_data;
    // echo "Connection success!";

    $conn->close();
?>