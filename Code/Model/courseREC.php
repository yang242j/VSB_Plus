<?php
/**
 * Collect courses from the "major_req.json" file.
 * 
 * Requirments:
 *  1) Required or Approved courses.
 *  2) Only return required number of courses.
 *  3) Semester (term) presented courses.
 *  4) Prerequisites of the course must met.
 *  5) Required courses take priority over approved courses. (Recommend all the required courses first.)
 * 
 * Steps:
 *  1) Collect inputs.( $doneList, $major, $term, $maxNum )
 *  2) Convert $term input into db readable format.
 *  3) Based on the $major input, open & collect the cooresponding json file for required courses.
 *  4) Based on the requirments, generate the $toTakeList.
 *  5) Encode & Return as JSON format
 * 
 * @version 1.0
 * @link      http://15.223.123.122/vsbp/Code/semesterBuilder.php
 * @author    Jingkang Yang (sid: 200362586) <yang242j@uregina.ca>
 * @param array $doneList "Courses completed"
 * @param string $major "The major of the student"
 * @param string $term "Term to be registerd"
 * @param string $maxNum "Maximum number of courses to collect"
 * @return json $toTakeList "Recommended courses to take in the selected term"
 */

// 1. Collect inputs
$doneList = isset($_REQUEST["courseCompletedList"]) ? $_REQUEST["courseCompletedList"] : '';
$major = isset($_REQUEST["major"]) ? $_REQUEST["major"] : '';
$maxNum = isset($_REQUEST["maxNum"]) ? $_REQUEST["maxNum"] : '';

// 2. Convert term input
if (isset($_REQUEST["term"]) and $_REQUEST["term"] != '') {
    $term_NUM = $_REQUEST["term"];
    switch ($_REQUEST["term"]) {
        case 202020:
            $term_EN = "2020 Spring/Summer";
            break;
        case 202030:
            $term_EN = "2020 Fall";
            break;
        case 202110:
            $term_EN = "2021 Winter";
            break;
    }
}

if ($doneList !== "" && $major !== "" && $term_NUM !== "" && $term_EN !== "") {

    // 3. Open & Collect required courses 
    $fileName = $major . '_req.json';
    $reqList_json_String = file_get_contents("../JSON/$fileName"); // Get the contents of the JSON file 
    $reqList_json_array = json_decode($reqList_json_String, true); // Convert to array 

    // 4. Generate $toTakeList.
    $toTakeList = array();
    foreach ($reqList_json_array as $reqTerm => $reqCourses_array) {
        foreach ($reqCourses_array as $reqCourse) {

            $skipCondition_1 = in_array($reqCourse, $doneList); // Course was completed
            $skipCondition_2 = $reqCourse == "Approved"; // Approved elective
            $skipCondition_3 = sizeof($toTakeList)>= $maxNum; // To take list is full
            $coursePath = "../JSON/$term_NUM/$reqCourse.json";
            $skipCondition_4 = file_exists($coursePath) ? false : true; // Course file exist in that semester dir.
            $skipCondition_5 = $skipCondition_4 ? checkSectionEmpty($coursePath) : false; // Check if course section is empty

            if ( $skipCondition_1 || $skipCondition_2 || $skipCondition_3 || $skipCondition_4 ) {
                //echo "$reqCourse : $skipCondition_1, $skipCondition_2, $skipCondition_3, $skipCondition_4 <br>";
                continue; 
            } else {
                array_push($toTakeList, $reqCourse);
            }
        }
    }
    
    // 5. Encode & Return as JSON format.
    //echo json_encode($toTakeList, JSON_PRETTY_PRINT); 

} else {
    echo "One of three inputs is invalid";
}

function checkSectionEmpty($path) {
    $json_string = file_get_contents($path);
    $parsed_json = json_decode($json_string, true);
    echo isset($parsed_json['section']) ? $parsed_json['short_name'] : null;
    //echo json_encode($parsed_json, JSON_PRETTY_PRINT);
}

?>