<?php

/**
 * Collect one user taken class detail.
 * 
 * Requirments:
 *  1) Required student id.
 * 
 * Steps:
 *  1) Collect inputs.( $sid, $password)
 *  2) Check the if there is a student id in the database.
 *  3) Check the password with specific acount.
 *  4) Covert to the data array with taken class 
 *  5) Encode & Return as JSON format
 * 
 * @version 1.0
 * @link      http://15.223.123.122/vsbp/Code/courseDB2.php
 * @author    Xinyu Liu (sid: 200362878) <liu725@uregina.ca>
 * @param array $sid "Student id"
 * @param array $password "password of account"
 * @return json $toTakeList "Recommended courses to take in the selected term"
 */

//1) Collect inputs.( $sid, $password)
// get the parameters from URL
if (isset($_REQUEST["sid"]) and $_REQUEST["sid"] != '') {
    $sid = $_REQUEST["sid"];
} else {
    echo "Please enter the Sutdent ID";
    return;
}


// Include the vsbp_db_config.php file
require_once "vsbp_db_config.php";

// 2) Check the if there is a student id in the database.
$count_sql =  "SELECT COUNT(*) FROM students where student_id = '" . $sid . "'";
$count_res = mysqli_query($conn, $count_sql);
$count = mysqli_fetch_array($count_res)[0];

// If there is a course that is required.
if ($count > 0) {
    $tableName = "S" . $sid;
    $takenClass_sql = "SELECT * FROM `" . $tableName . "`";
    $result = mysqli_query($conn, $takenClass_sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
    $data = array();
    // 4) Covert to the data array with taken class 
    while ($row = mysqli_fetch_array($result)) {
        $oneTaken = array(
            "courseIndex" => $row['courseIndex'],
            "term" => $row['term'],
            "course_ID" => $row['course_ID'],
            "section_num" => $row['section_num'],
            "course_title" => $row['course_title'],
            "final_grade" => $row['final_grade'],
            "credit_hour" => $row['credit_hour'],
            "credit_earned" => $row['credit_earned'],
            "class_size" => $row['class_size'],
            "class_average" => $row['class_average']
        );
        array_push($data, $oneTaken);
    }
    // 5) Encode & Return as JSON format
    $json_data = json_encode($data, JSON_PRETTY_PRINT);
    echo $json_data;
} else {
    echo "Uncorrect student ID!";
}

mysqli_close($conn);
