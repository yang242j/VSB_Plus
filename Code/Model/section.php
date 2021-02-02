<?php
    // get the q parameter from URL or post or get method
    $short_name = isset($_REQUEST["short_name"]) ? $_REQUEST["short_name"] : '';
    $addCond = '';
    if (isset($_REQUEST["type"])){
        $addCond += " AND schedule_type = '" + $_REQUEST["type"] + "'";
    }
    if(isset($_REQUEST["term"])){
        switch ($_REQUEST["term"]){
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

        $addCond += " AND term = '" + $term + "'";
    }

    if($short_name !== ""){
        $host = "localhost";
        $username = 'root';
        $pass = "vsbp";
        $database = "course";
        $conn = mysqli_connect($host, $username, $pass, $database);
        if (!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $count_sql =  "SELECT COUNT(*) FROM section where short_name = '" . $short_name . "'" + $addCond;
        $count_res = mysqli_query($conn, $count_sql);
        $count = mysqli_fetch_array($count_res)[0];
        
        // If there is a course that is required.
        if ($count > 0){
            $sec_sql = "SELECT * FROM section where short_name = '" . $short_name . "'" + $addCond;
            $sec_result = mysqli_query($conn, $detail_sql);
            $data = array();
            while($row = mysqli_fetch_array($sec_result)){
                $section = array("title"=>$row['title'],
                "course_code"=>$row['course_code'],
                "short_name"=>$row['short_name'],
                "section_num"=>$row['section_num'],
                "term"=>$row['term'],
                "type"=>$row['type'],
                "time"=>$row['time'],
                "days"=>$row['days'],
                "loc"=>$row['loc'],
                "date_range"=>$row['date_range'],
                "course_type"=>$row['schedule_type'],
                "instructors"=>$row['instructors']  
            );
            array_push($data, json_encode($section)); 
            }
            $json_data = json_encode($data);
            echo $json_data;
        }
        else{
            echo "Cannot find the section!";
        }
        
        // print_r($data);
        // echo json_encode(array_values($data));
        mysqli_close($conn);
    }
    echo "Please enter the short name for course";


?>