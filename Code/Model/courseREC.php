<?php
// Collect inputs
$doneList = isset($_REQUEST["courseCompletedList"]) ? $_REQUEST["courseCompletedList"] : '';
$major = isset($_REQUEST["major"]) ? $_REQUEST["major"] : '';

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
}

if ($doneList !== "" && $major !== "" && $term !== "") {
    // 1. Based on the major, open and read the json file of required courses.
    $fileName = $major . '_req.json';
    $json_String = file_get_contents("../JSON/$fileName"); // Get the contents of the JSON file 
    $json_array = json_decode($json_String, true); // Convert to array 
    $reqList_json = json_encode($json_array, JSON_PRETTY_PRINT); // Encode to json
    //echo $reqList_json;

    // 2. Compare the doneList and the reqList_json, store the first 10 courses into an array.
    foreach ($json_array as $reqCourse) {
        echo "$reqCourse";
    }

} else {
    echo "One of three inputs is invalid";
}
