<?php
    // get the parameters from URL
    if (isset($_REQUEST["sid"]) and $_REQUEST["sid"] != ''){
        $sid = $_REQUEST["sid"];
    }
    else{
        echo "Please enter the Sutdent ID";
        return;
    }

    if (isset($_REQUEST["password"]) and $_REQUEST["password"] != ''){
        $pw = $_REQUEST["password"];
    }
    else{
        echo "Please enter the password";
        return;
    }

    // Include the vsbp_db_config.php file
    require_once "vsbp_db_config.php";
    
    $count_sql =  "SELECT COUNT(*) FROM students where student_id = '" . $sid . "'"; 
    $count_res = mysqli_query($conn, $count_sql);
    $count = mysqli_fetch_array($count_res)[0];
    
    // If there is a course that is required.
    if ($count > 0){
        $detail_sql = "SELECT * FROM students where student_id = '" . $sid . "'"; 
        $detail_result = mysqli_query($conn, $detail_sql);
    
        $row = mysqli_fetch_array($detail_result);
        if (password_verify($pw, $row['password'])){
            // echo $sid;
            $tableName = "S" . $sid;
            $takenClass_sql = "SELECT * FROM '" . $tableName . "'"; 
            $result = mysqli_query($conn, $takenClass_sql);
            $data = array();
            while($row = mysqli_fetch_array($result)){
                $oneTaken = array("courseIndex"=>$row['courseIndex'],
                "term"=>$row['term'],
                "course_ID"=>$row['course_ID'],
                "section_num"=>$row['section_num'],
                "course_title"=>$row['course_title'],
                "final_grade"=>$row['final_grade'],
                "credit_hour"=>$row['credit_hour'],
                "credit_earned"=>$row['credit_earned'],
                "class_size"=>$row['class_size'],
                "class_average"=>$row['class_average']);
                array_push($data, $oneTaken);
            }
            $json_data = json_encode($data);
            echo $json_data;
        }
        else{
            echo "Wrong password!";
        }
    }
    else{
        echo "Not correct student ID!";
    }    
    
    mysqli_close($conn);

?>