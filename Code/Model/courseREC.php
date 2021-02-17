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
    // Based on the major, open and read the json file of required courses.
    $fileName = $major + '_req.json';
    $.getJSON( "../JSON/$fileName.json", function( data ) {
        echo json_encode( data, JSON_PRETTY_PRINT );
    });

} else {
    echo "One of three inputs is invalid";
}
