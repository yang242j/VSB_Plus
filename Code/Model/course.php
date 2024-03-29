<?php
/**
 * Collect one courses detail from the course database.
 *
 * Requirments:
 *  1) Required one courses short_name in the passed data.
 *
 * Steps:
 *  1) Collect inputs.( $short_name )
 *  2) Convert $short_name input into db readable format.
 *  3) Based on the $short_name input, form the arrray for course detail.
 *  4) Encode & Return as JSON format
 *
 * @version 1.0
 * @link      http://15.223.123.122/vsbp/Code/courseDB.php
 * @author    Xinyu Liu (sid: 200362878) <liu725@uregina.ca>
 * @param   {array}     $short_name "short_name of one course"
 *
 * @return  {json}      $toTakeList "Recommended courses to take in the selected term"
 */

// 1) Get the parameter from URL
// $short_name = isset($_REQUEST('short_name'));
// $short_name = $_GET['short_name'];
$short_name = $_REQUEST["short_name"];

if ($short_name !== "") {
    // Include the course_db_config.php file
    require_once "course_db_config.php";

    // 2) Convert $short_name input into db readable format.
    $count_sql =
        "SELECT COUNT(*) FROM course where short_name = '" . $short_name . "'";
    $count_res = mysqli_query($conn, $count_sql);
    $count = mysqli_fetch_array($count_res)[0];

    // If there is a course that is required.
    if ($count > 0) {
        $detail_sql =
            "SELECT * FROM course where short_name = '" . $short_name . "'";
        $detail_result = mysqli_query($conn, $detail_sql);
        // 3) Based on the $short_name input, form the arrray for course detail.
        $row = mysqli_fetch_array($detail_result);
        // print_r($row);
        $data = [
            "short_name" => $row['short_name'],
            "title" => $row["title"],
            "faculty" => $row["faculty"],
            "course_num" => $row["course_num"],
            "credit" => $row["credit"],
            "description" => $row["description"],
            "prerequisite" => $row["prerequisite"],
            "preExpression" => $row["preExpression"],
            "preExpression_v2" => $row["preExpression_v2"],
        ];
        // 4) Encode & Return as JSON format
        $json_data = json_encode(utf8ize($data), JSON_PRETTY_PRINT);
        // print(json_last_error());
        echo $json_data;
    } else {
        echo "Cannot find the course!";
    }

    // print_r($data);
    // echo json_encode(array_values($data));
    mysqli_close($conn);
}

/* Use it for json_encode some corrupt UTF-8 chars
 * useful for = malformed utf-8 characters possibly incorrectly encoded by json_encode
 */
function utf8ize($mixed)
{
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } elseif (is_string($mixed)) {
        return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
    }
    return $mixed;
}
