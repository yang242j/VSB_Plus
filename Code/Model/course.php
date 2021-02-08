<?php
// get the q parameter from URL
// $short_name = isset($_REQUEST('short_name'));
// $short_name = $_GET['short_name'];
$short_name = $_REQUEST["short_name"];

if ($short_name !== "") {
    // Include the course_db_config.php file
    require_once "course_db_config.php";

    $count_sql =  "SELECT COUNT(*) FROM course where short_name = '" . $short_name . "'";
    $count_res = mysqli_query($conn, $count_sql);
    $count = mysqli_fetch_array($count_res)[0];

    // If there is a course that is required.
    if ($count > 0) {
        $detail_sql = "SELECT * FROM course where short_name = '" . $short_name . "'";
        $detail_result = mysqli_query($conn, $detail_sql);

        $row = mysqli_fetch_array($detail_result);
        $data = array(
            "short_name" => $row['short_name'],
            "title" => $row["title"],
            "faculty" => $row["faculty"],
            "course_num" => $row["course_num"],
            "credit" => $row["credit"],
            "description" => $row["description"],
            "prerequisite" => $row["prerequisite"]
        );

        $json_data = json_encode($data, JSON_PRETTY_PRINT);
        echo $json_data;
    } else {
        echo "Cannot find the course!";
    }

    // print_r($data);
    // echo json_encode(array_values($data));
    mysqli_close($conn);
}
