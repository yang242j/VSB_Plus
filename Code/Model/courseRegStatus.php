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
 * @return  {string}    $status         A string describes the status of whether this course can be registerd. 
 */

// 1. Collect inputs
$doneList = isset($_REQUEST["doneList"]) ? $_REQUEST["doneList"] : '';
$courseid = isset($_REQUEST["courseid"]) ? $_REQUEST["courseid"] : '';
$term = isset($_REQUEST["term"]) ? $_REQUEST["term"] : '';

// 2. Check courseid is in correct format
if (preg_match_all("/([a-z]+\s[0-9]+)/i", $courseid) == 1){
    // 3. Generate the status number
    // 3.1 Check if the course is in doneList
    if ( in_array($courseid, $doneList) ) {
        $status = "$courseid is already completed.";
    } else {
        // 3.2 Check if the course is available in the given term
        $file_path = "../JSON/$term/$courseid.json";
        if ( file_exists($file_path) && !section_empty($file_path) ) {
            // 3.3 Check if the prerequisites of the course has matched.
            $strArr = get_PregExp_PreString($courseid);
            if ( exp_matched($strArr[1], $doneList) ) {
                $status = "true";
            } else {
                $status = "$courseid has prerequisites:\n$strArr[0].";
            }
        } else {
            $termStr = termNum2Str($term);
            $status = "$courseid is not available at $termStr.";
        }
    }

    // 4. Return the status number
    echo $status;

} else {
    echo "The course id format is invalid.";
}

/**
 * @param   {string}    $path   The file path to check whether it is empty or not.
 * @return  {boolean}           True for empty, False for not empty. 
 */
function section_empty($path) {
    $json_string = file_get_contents($path);
    $parsed_json = json_decode($json_string, true);
    return empty($parsed_json['section']);
}

/**
 * @param   {string}    $courseid   The course to get expressions from..
 * @return  {string}    $preStr     The prerequisites of the course. 
 * @return  {string}    $expStr     The preg expression of the course prerequisites. 
 */
function get_PregExp_PreString($courseid) {
    $response = get_course_json($short_name);
    $resArr = array();
    $resArr = json_decode($response, true);
    
    $preStr = $resArr['prerequisite'];
    $expStr = $resArr['preExpression'];
    return array($preStr, $expStr);
}

/**
 * @param   {string}    $expStr       The preg expression of the course prerequisites.
 * @param   {array}     $doneList     A list contains the short name of all completed courses. 
 * @return  {boolean}                 True for matched, False for not. 
 */
function exp_matched($expStr, $doneList) {
    $expStr = trim($expStr);

    // Basic: if expStr == null, return true
    if ($expStr == null) return true;
    
    // Basic: exact one course name "ENSE 400"
    if (preg_match_all("/([a-z]+\s[0-9]+)/i", $expStr) == 1){
        //echo in_array($expStr, $doneList) ? "<b>True</b> $expStr is in the Done array <br>" : "<b>False</b> $expStr is not in  done array <br>";
        return in_array($expStr, $doneList) ? true : false;
    }

    // &&: split "ENSE 400 && ENEL 400" 
    $andComp = preg_split("/(&{2})/", $expStr);
    if (sizeof($andComp) > 1){
        foreach ($andComp as $component) {
            if ($component) {
                //echo "and $component <br>";
                if (getStatus($component, $doneList) == false) return false;
            }
        }
        return true;
    }

    // Remove () if " (ENSE 400 || ENEL 400) "
    if (substr($expStr, 0, 1) == "(" && substr($expStr, -1) == ")") {
        return getStatus(substr($expStr, 1, -1), $doneList);
    }
    
    // ||: split "ENSE 400 || ENEL 400" 
    $orComp = preg_split("/(\|{2})/", $expStr);
    if (sizeof($orComp) > 1){
        foreach ($orComp as $component) {
            // echo "or $component <br>";
            if ($component) {
                //echo "or $component <br>";
                if (getStatus($component, $doneList) == true) return true;
            }
        }
        return false;
    } 
    else{ echo "something error";}
}

/**
 * @param   {string}    $short_name     The short name of the course to be checked, i.e. "ENGG 401"
 * @return  {json}      $content        The json content returned from course.php
 */
function get_course_json($short_name) {
    $url = "http://15.223.123.122/vsbp/Code/Model/course.php";
    $postField = "short_name=$short_name";

    $options = array(
        CURLOPT_RETURNTRANSFER => true,       // return web page
        CURLOPT_HEADER         => false,      // don't return headers
        CURLOPT_FOLLOWLOCATION => true,       // follow redirects
        CURLOPT_MAXREDIRS      => 10,         // stop after 10 redirects
        CURLOPT_ENCODING       => "",         // handle compressed
        CURLOPT_USERAGENT      => "test",     // name of client
        CURLOPT_AUTOREFERER    => true,       // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,        // time-out on connect
        CURLOPT_TIMEOUT        => 120,        // time-out on response
        CURLOPT_POSTFIELDS     => $postField, // set up post fields
    ); 

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $content  = curl_exec($ch);
    curl_close($ch);
    return $content;
}

/**
 * @param   {integer}    $term          The number to represent the semester.
 * @return  {string}     $termStr       English sentance to represent the semester. 
 */
function termNum2Str($term) {
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