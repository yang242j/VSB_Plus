<?php
    // get the q parameter from URL or post or get method
    $short_name = isset($_REQUEST["short_name"]) ? $_REQUEST["short_name"] : '';
    $addCond = '';

    if (isset($_REQUEST["schedule_type"]) and $_REQUEST["schedule_type"] != ''){
            $addCond .= " AND schedule_type = '" . $_REQUEST["schedule_type"] . "'";
    }

    if(isset($_REQUEST["term"]) and $_REQUEST["term"] != ''){
        switch ($_REQUEST["term"]){
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

    // echo $addCond;

    if($short_name !== ""){
        // Include the course_db_config.php file
        require_once "course_db_config.php";

        $count_sql =  "SELECT COUNT(*) FROM section where short_name = '" . $short_name . "'" . $addCond;
        $count_res = mysqli_query($conn, $count_sql);
        $count = mysqli_fetch_array($count_res)[0];
    
        // If there is a course that is required.
        if ($count > 0){
            $sec_sql = "SELECT * FROM section where short_name = '" . $short_name . "'" . $addCond;
            $sec_result = mysqli_query($conn, $sec_sql);
            $data = array();
            while($row = mysqli_fetch_array($sec_result)){
                $type = ($row['type'] == 'Class') ? $row['type'] : "";
                // if ($row['type'] == "") {echo "null type!";}
                $section = array("title"=>$row['title'],
                "course_code"=>$row['course_code'],
                "short_name"=>$row['short_name'],
                "section_num"=>$row['section_num'],
                "term"=>$row['term'],
                "type"=>$type,
                "time"=>$row['time'],
                "days"=>$row['days'],
                "loc"=>$row['loc'],
                "date_range"=>$row['date_range'],
                "schedule_type"=>$row['schedule_type'],
                "instructors"=>$row['instructors']  
            );
            // array_push($data, json_encode($section)); 
            array_push($data, $section); 
            }
            $json_data = json_encode($data, JSON_PRETTY_PRINT);
            echo $json_data;
            // print_r($data);
        }
        else{
            echo "Cannot find the section!";
        }
        
        // print_r($data);
        // echo json_encode(array_values($data));
        mysqli_close($conn);
    }
    else{
        echo "Please enter the short name for course";
    }

?>