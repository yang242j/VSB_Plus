<?php
    // Include the course_db_config.php file
    require_once "course_db_config.php";

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