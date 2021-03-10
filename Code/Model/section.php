<?php
/**
 * Collect one courses all section details from the course database.
 *
 * Requirments:
 *  1) Required one courses short name as varible name short_name in the data set.
 *  2) Allow to set the class type as "class", "exam" or "lab".
 *  3) Allow to set the search term.
 *
 * Steps:
 *  1) Collect inputs.( $short_name, $schedule_type, $term)
 *  2) Convert $short_name, $schedule_type and $term input into db readable format.
 *  3) Based on the $short_name, $schedule_type, $term input, form the arrray for course detail.
 *  4) Encode & Return as JSON format
 *
 * @version 1.0
 * @link      http://15.223.123.122/vsbp/Code/courseDB.php
 * @author    Xinyu Liu (sid: 200362878) <liu725@uregina.ca>
 * @param   {array}     $short_name "short_name of one course"
 * @param   {array}     $schedule_type "schedule type of the course"
 * @param   {array}     $term "term of the course at the different semester"
 *
 * @return  {json}      $toTakeList "Recommended courses to take in the selected term"
 */

//1) Collect inputs.( $short_name, $schedule_type, $term)
// get the q parameter from URL or post or get method
$short_name = isset($_REQUEST["short_name"]) ? $_REQUEST["short_name"] : '';
$addCond = '';

if (isset($_REQUEST["schedule_type"]) and $_REQUEST["schedule_type"] != '') {
    $addCond .= " AND schedule_type = '" . $_REQUEST["schedule_type"] . "'";
}

// 2) Convert $short_name, $schedule_type and $term input into db readable format.
if (isset($_REQUEST["term"]) and $_REQUEST["term"] != '') {
    switch ($_REQUEST["term"]) {
        case "2020 Spring/Summer":
        case "2020 Fall":
        case "2021 Winter":
            $term = $_REQUEST["term"];
            break;
        case 202020:
            $term = "2020 Spring/Summer";
            break;
        case 202030:
            $term = "2020 Fall";
            break;
        case 202110:
        default:
            $term = "2021 Winter";
    }
    $addCond .= " AND term = '" . $term . "'";
}

if ($short_name !== "") {
    // Include the course_db_config.php file
    require_once "course_db_config.php";

    $count_sql =
        "SELECT COUNT(*) FROM section where short_name = '" .
        $short_name .
        "'" .
        $addCond;
    $count_res = mysqli_query($conn, $count_sql);
    $count = mysqli_fetch_array($count_res)[0];

    // 3) Based on the $short_name, $schedule_type, $term input, form the arrray for course detail.
    // If there is a course that is required.
    if ($count > 0) {
        $sec_sql =
            "SELECT * FROM section where short_name = '" .
            $short_name .
            "'" .
            $addCond;
        $sec_result = mysqli_query($conn, $sec_sql);
        $data = [];
        $x = 0;
        while ($row = mysqli_fetch_array($sec_result)) {
            // $str = $row['days'];
            // if (mb_detect_encoding($str, 'UTF-8'));
            // else {
            //     echo $str;
            //     echo "<br>";
            // }
            $type = $row['type'] == 'Class' ? $row['type'] : "";
            $days = mb_convert_encoding($row['days'], 'UTF-8', 'UTF-8');
            // if ($row['type'] == "") {echo "null type!";}
            $section = [
                "title" => $row['title'],
                "course_code" => $row['course_code'],
                "short_name" => $row['short_name'],
                "section_num" => $row['section_num'],
                "term" => $row['term'],
                "type" => $type,
                "time" => $row['time'],
                "days" => $days,
                "loc" => $row['loc'],
                "date_range" => $row['date_range'],
                "schedule_type" => $row['schedule_type'],
                "instructors" => $row['instructors'],
            ];
            // array_push($data, json_encode($section));
            array_push($data, $section);
            // echo "<br> " . $section['course_code'];
            // echo $section["section_num"];
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
        // echo json_last_error();
        // //4) Encode & Return as JSON format
        // echo json_encode($data, JSON_PRETTY_PRINT);
        // echo "<br>";
        // echo json_last_error();

        // print_r($data);
    } else {
        echo json_encode(json_decode("{}"));
    }

    // print_r($data);
    // echo json_encode(array_values($data));
    mysqli_close($conn);
} else {
    echo "Please enter the short name for course";
}
