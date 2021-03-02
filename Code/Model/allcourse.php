<?php
/**
 * Collect courses from the course database.
 * 
 * Requirments:
 * No requirements
 * 
 * Steps:
 *  1) Connect to the database
 *  2) Collect all the details for all the course
 *  3) Encode & Return as JSON format
 * 
 * @version 1.0
 * @link      http://15.223.123.122/vsbp/Code/courseDB.php
 * @author    Xinyu Liu (sid: 200362878) <liu725@uregina.ca>
 * @param   {Null}
 * 
 * @return  {json}  $data "All the course that in the course database"
 */


// Include the course_db_config.php file
require_once "course_db_config.php";

$sql = "SELECT * FROM course";
$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_array($result)) {
    $course = array(
        "short_name" => $row['short_name'],
        "title" => $row["title"],
        "faculty" => $row["faculty"],
        "credit" => $row["credit"],
        "description" => $row["description"],
        "prerequisite" => $row["prerequisite"],
        "preExpression" => $row["preExpression"]
    );
    array_push($data, json_encode($course));
}
// print_r($data);
// echo json_encode(array_values($data));
$json_data = json_encode($data, JSON_PRETTY_PRINT);
echo $json_data;
// echo "Connection success!";

$conn->close();
