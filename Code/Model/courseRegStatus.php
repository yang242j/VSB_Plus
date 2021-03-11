<?php
/**
 * Return the status of a course whether it can be registerd in a particular semester with a particular list of completed courses.
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
 * @version     1.0
 * @link        http://15.223.123.122/vsbp/Code/Model/courseREC.php
 * @author      Jingkang Yang (sid: 200362586) <yang242j@uregina.ca>
 * @param   {array}     $doneList       Courses completed
 * @param   {string}    $courseid       The short name of a course
 * @param   {string}    $term           Term to be registerd
 *
 * @return  {array}     $status         A array includes the status of whether this course can be registerd.
 */

// 1. Collect inputs
$doneList = isset($_REQUEST["doneList"])
    ? json_decode($_REQUEST["doneList"])
    : '';
$courseid = isset($_REQUEST["courseid"])
    ? strtoupper($_REQUEST["courseid"])
    : '';
$term = isset($_REQUEST["term"]) ? $_REQUEST["term"] : '';

// 2. Generate the status number
$status = [
    "CourseID" => $courseid, // {String} course id
    "Status" => false, // {bool} whether this course can be registered.
    "Found" => false, // {bool} whether this course can be found.
    "Completion" => false, // {bool} whether this course has already completed.
    "Availability" => false, // {bool} whether this course is available at the given term.
    "Prerequisites" => false, // {bool} whether this course has matched all prerequisites.
    "PrereqNotes" =>"",// {string} nots for prerequisites information
    "Notes" => "$courseid:\n", // {string} Additional notes.
];

// 3. Check courseid is in correct format
$pattern_1 = "/([a-z]{2,}\s[0-9]{3,})/i"; // "ABC 123"
$pattern_2 = "/([a-z]{2,}[0-9]{3,})/i"; // No space: "ABC123"

if (preg_match_all($pattern_1, $courseid) == 1) {
    $validFormat = true;
} elseif (preg_match_all($pattern_2, $courseid) == 1) {
    // Add a space
    $courseid = trim(
        join(
            " ",
            preg_split("/([a-z]+)/i", $courseid, -1, PREG_SPLIT_DELIM_CAPTURE)
        )
    );
    $validFormat = true;
} else {
    // Invalid firmat
    $validFormat = false;
}

// 4. If correct input.
if ($validFormat) {
    $status["CourseID"] = $courseid;

    // 4.1 Check if the course is already completed
    if (!in_array($courseid, $doneList)) {
        $status["Completion"] = false;
        $status["Notes"] .= "NOT Completed.\n";
        
       

        // 4.2 Check if the course can be found in the database.
        $file_path = "../JSON/$term/$courseid.json";
        if (file_exists($file_path)) {
            $status["Found"] = true;
            $status["Notes"] .= "Course Found.\n";

            // 4.3 Check if the course is available in the given term
            $termStr = termNum2Str($term);
            if (!section_empty($file_path)) {
                $status["Availability"] = true;
                $status["Notes"] .= "Available at $termStr.\n";
            } else {
                // Course not available
                $status["Availability"] = false;
                $status["Notes"] .= "NOT available at $termStr.\n";
            }

            // 4.4 Check if the prerequisites of the course has matched.
            $strArr = get_PregExp_PreString($courseid);
            if (exp_matched($strArr[1], $doneList)) {
                $status["Prerequisites"] = true;
                $status["Notes"] .= "\nPrerequisites [Matched]:\n$strArr[0]\n";
                
            } else {
                // Course prerequisites not matched
                $status["Prerequisites"] = false;
                
            }
        } else {
            // Course file not found
            $status["Found"] = false;
            $status["Notes"] .= "Course NOT Found";
        }
    } else {
        // Course completed
        $status["Completion"] = true;
        $status["Notes"] .= "Course is Completed.\n";
    }
} else {
    // Input invalid
    $status["Notes"] .= "Input Format Iinvalid";
    $status[
        "PrereqNotes"
    ] .= "\nPrerequisites [Not Matched]:\n$strArr[0]\n";
}

// 5. Final status decision.
// Valide input, Course found, Not completed, Available, pre-matched
if (
    $validFormat &&
    $status["Found"] &&
    !$status["Completion"] &&
    $status["Availability"] &&
    $status["Prerequisites"]
) {
    $status["Status"] = true;
}

// 6. Encode & Return the status number as JSON format
echo json_encode($status, JSON_PRETTY_PRINT);

/**
 * @param   {string}    $path   The file path to check whether it is empty or not.
 * @return  {boolean}           True for empty, False for not empty.
 */
function section_empty($path)
{
    $json_string = file_get_contents($path);
    $parsed_json = json_decode($json_string, true);
    return empty($parsed_json['section']);
}

/**
 * @param   {string}    $courseid   The course to get expressions from..
 * @return  {string}    $preStr     The prerequisites of the course.
 * @return  {string}    $expStr     The preg expression of the course prerequisites.
 */
function get_PregExp_PreString($courseid)
{
    $response = get_course_json($courseid);
    $resArr = [];
    $resArr = json_decode($response, true);

    $preStr = $resArr['prerequisite'];
    $expStr = $resArr['preExpression'];
    return [$preStr, $expStr];
}

/**
 * @param   {string}    $expStr       The preg expression of the course prerequisites.
 * @param   {array}     $doneList     A list contains the short name of all completed courses.
 * @return  {boolean}                 True for matched, False for not.
 */
function exp_matched($expStr, $doneList)
{
    $expStr = trim($expStr);

    // Basic: if expStr == null, return true
    if ($expStr == null) {
        return true;
    }

    // Basic: exact one course name "ENSE 400"
    if (preg_match_all("/([a-z]+\s[0-9]+)/i", $expStr) == 1) {
        //echo in_array($expStr, $doneList) ? "<b>True</b> $expStr is in the Done array <br>" : "<b>False</b> $expStr is not in  done array <br>";
        return in_array($expStr, $doneList) ? true : false;
    }

    // &&: split "ENSE 400 && ENEL 400"
    $andComp = preg_split("/(&{2})/", $expStr);
    if (sizeof($andComp) > 1) {
        foreach ($andComp as $component) {
            if ($component) {
                //echo "and $component <br>";
                if (exp_matched($component, $doneList) == false) {
                    return false;
                }
            }
        }
        return true;
    }

    // Remove () if " (ENSE 400 || ENEL 400) "
    if (substr($expStr, 0, 1) == "(" && substr($expStr, -1) == ")") {
        return exp_matched(substr($expStr, 1, -1), $doneList);
    }

    // ||: split "ENSE 400 || ENEL 400"
    $orComp = preg_split("/(\|{2})/", $expStr);
    if (sizeof($orComp) > 1) {
        foreach ($orComp as $component) {
            // echo "or $component <br>";
            if ($component) {
                //echo "or $component <br>";
                if (exp_matched($component, $doneList) == true) {
                    return true;
                }
            }
        }
        return false;
    } else {
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

/**
 * @param   {integer}    $term          The number to represent the semester.
 * @return  {string}     $termStr       English sentance to represent the semester.
 */
function termNum2Str($term)
{
    $year = substr($term, 0, 4);
    switch (substr($term, 4)) {
        case 10:
            # Winter
            $semester = "Winter";
            break;

        case 20:
            # SS
            $semester = "Spring/Summer";
            break;

        case 30:
            # Fall
            $semester = "Fall";
            break;
    }
    return $semester . ' ' . $year;
}
?>
