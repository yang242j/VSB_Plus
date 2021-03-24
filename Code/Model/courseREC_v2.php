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
 * @version     2.0
 * @link        http://15.223.123.122/vsbp/Code/Model/courseREC.php
 * @author      Jingkang Yang (sid: 200362586) <yang242j@uregina.ca>
 * @param   {array}     $doneList       Courses completed
 * @param   {string}    $major          The major of the student
 * @param   {string}    $term           Term to be registerd
 * @param   {string}    $maxNum         Maximum number of courses to collect
 *
 * @return  {json}      $toTakeList     Recommended courses to take in the selected term
 */

// 1. Collect inputs
$doneList = isset($_REQUEST["doneList"])
    ? json_decode($_REQUEST["doneList"], true)
    : '';
// print_r($doneList);
$major = isset($_REQUEST["major"]) ? $_REQUEST["major"] : '';
$maxNum = isset($_REQUEST["maxNum"]) ? $_REQUEST["maxNum"] : '';
$totalCredit = isset($_REQUEST["totalCredit"]) ? $_REQUEST["totalCredit"] : '';

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
    $reqList_json_String = file_get_contents("../JSON/reqCourse/$fileName"); // Get the contents of the JSON file
    $reqList_json_array = json_decode($reqList_json_String, true); // Convert to array

    // 4. Generate $toTakeList.
    $toTakeList = [];
    foreach ($reqList_json_array as $reqTerm => $reqCourses_array) {
        foreach ($reqCourses_array as $reqCourse) {
            // $skipCondition_1 = array_key_exists($reqCourse, $doneList);
            $skipCondition_1 = array_key_exists($reqCourse, $doneList); // Course was completed
            $skipCondition_2 = $reqCourse == "Approved"; // Approved elective
            $skipCondition_3 = sizeof($toTakeList) >= $maxNum; // To take list is full
            $coursePath = "../JSON/$term_NUM/$reqCourse.json";
            $skipCondition_4 = !file_exists($coursePath) ? true : false; // Course file exist in that semester dir.
            $skipCondition_5 = $skipCondition_4
                ? true
                : isSectionEmpty($coursePath); // Check if course section is empty
            $skipCondition_6 = notMatchPrerequisites($reqCourse, $totalCredit, $doneList); // Course mush match prerequistes.

            if (
                $skipCondition_1 ||
                $skipCondition_2 ||
                $skipCondition_3 ||
                $skipCondition_4 ||
                $skipCondition_5 ||
                $skipCondition_6
            ) {
                continue;
            } else {
                array_push($toTakeList, $reqCourse);
            }
        }
    }

    // 5. Encode & Return as JSON format.
    echo json_encode($toTakeList, JSON_PRETTY_PRINT);
} else {
    echo "One of three inputs is invalid";
}

/**
 * @param   {string}    $path   The file path to check whether it is empty or not.
 * @return  {boolean}           True for empty, False for not empty.
 */
function isSectionEmpty($path)
{
    $json_string = file_get_contents($path);
    $parsed_json = json_decode($json_string, true);
    return !empty($parsed_json['section']) ? false : true;
    //echo "<br>";
    //echo json_encode($parsed_json, JSON_PRETTY_PRINT);
}

/**
 * @param   {string}      $short_name   The short name of the course to be checked, i.e. "ENGG 401"
 * @param   {array}       $doneList     A list contains the short name of all completed courses.
 * @return  {boolean}                   True for not match with prerequisites, False for matched.
 */
function notMatchPrerequisites($short_name, $totalCredit, $doneList)
{
    // Get course json
    $response = get_course_json($short_name);
    $resArr = [];
    $resArr = json_decode($response, true);

    // Get the prerequisites expression string
    $expStr = $resArr['preExpression_v2'];

    return exp_matched($expStr, $totalCredit, $doneList) ? false : true;
}

/**
 * @param   {string}      $expStr       The expression to represent the course prerequisites, i.e. For ENGG 401 is "ENEL 400 || ENEV 400 || ENIN 400 || ENPE 400 || ENSE 400".
 * @param   {array}       $doneList     A list contains the short name of all completed courses.
 * @return  {boolean}                   True for match with the expression, False for not matched.
 */
function exp_matched($expStr, $totalCredit, $doneList)
{
    $expStr = trim($expStr);

    // Basic: if expStr == null, return true
    if ($expStr == null) {
        return true;
    }

    // Base case: Pending credit requirements
    if (preg_match_all("/^(Credit\s\[(.*?)\])$/i", $expStr) == 1) {
        $creditStr = preg_split("/(\s\[)/i", $expStr);
        $creditExp = rtrim($creditStr[1], ']');
        return eval('return ' . $totalCredit . $creditExp . ';') ? true : false;
    }

    // Basic: exact one course name "ENSE 400"
    if (preg_match_all("/([a-z]+\s[0-9]+)/i", $expStr) == 1) {
        // Check if has condition
        if (preg_match_all("/([a-z]+\s[0-9]+\s\[(.*?)\])/i", $expStr) == 1) {
            $splitedStr = preg_split("/(\s\[)/i", $expStr);
            if (array_key_exists($splitedStr[0], $doneList)) {
                $gradeExp = rtrim($splitedStr[1], ']');
                return eval('return ' . $doneList[$splitedStr[0]] . $gradeExp . ';') ? true : false;
            } else { return false; }
        }
        return array_key_exists($expStr, $doneList) ? true : false;
    }

    // &&: split "ENSE 400 && ENEL 400"
    $andComp = preg_split("/(&{2})/", $expStr);
    if (sizeof($andComp) > 1) {
        foreach ($andComp as $component) {
            if ($component) {
                //echo "and $component <br>";
                if (exp_matched($component, $totalCredit, $doneList) == false) {
                    return false;
                }
            }
        }
        return true;
    }

    // Remove () if " (ENSE 400 || ENEL 400) "
    if (substr($expStr, 0, 1) == "(" && substr($expStr, -1) == ")") {
        return exp_matched(substr($expStr, 1, -1), $totalCredit, $doneList);
    }

    // ||: split "ENSE 400 || ENEL 400"
    $orComp = preg_split("/(\|{2})/", $expStr);
    if (sizeof($orComp) > 1) {
        foreach ($orComp as $component) {
            // echo "or $component <br>";
            if ($component) {
                //echo "or $component <br>";
                if (exp_matched($component, $totalCredit, $doneList) == true) {
                    return true;
                }
            }
        }
        return false;
    } else {
        echo $expStr;
        echo "something error";
    }
}

/**
 * @param   {string}    $short_name     The short name of the course to be checked, i.e. "ENGG 401"
 * @return  {json}      $content        The json content returned from course.php
 */
function get_course_json($short_name)
{
    $url = "http://15.223.123.122/vsbp/Code/Model/course.php";
    $postField = "short_name=$short_name";

    $options = [
        CURLOPT_RETURNTRANSFER => true, // return web page
        CURLOPT_HEADER => false, // don't return headers
        CURLOPT_FOLLOWLOCATION => true, // follow redirects
        CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
        CURLOPT_ENCODING => "", // handle compressed
        CURLOPT_USERAGENT => "test", // name of client
        CURLOPT_AUTOREFERER => true, // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120, // time-out on connect
        CURLOPT_TIMEOUT => 120, // time-out on response
        CURLOPT_POSTFIELDS => $postField, // set up post fields
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}

?>
