<?php
    // get the q parameter from URL
    $short_name = $_REQUEST("short_name");

    if($short_name !== ""){
        $host = "15.233.123.122";
        // $host = "localhost";
        $username = 'root';
        $pass = "vsbp";
        $database = "course";
        $conn = mysqli_connect($host, $username, $pass, $database);
        if (!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $detail_sql = "SELECT * FROM course where short_name = '" . $short_name . "'"; 
        $detail_result = mysqli_query($conn, $detail_sql);
        
        $row = mysqli_fetch_array($detail_result);
        $data = array("short_name"=>$row['short_name'], 
            "title"=>$row["title"],
            "faculty"=>$row["faculty"],
            "course_num"=>$row["course_num"],
            "credit"=>$row["credit"],
            "description"=>$row["description"],
            "prerequisite"=>$row["prerequisite"]);

        $sec_sql = "SELECT * FROM section where short_name = '" . $short_name . "'";
        $sec_result = mysqli_query($conn, $sec_sql);
        $term = null;
        $sec_data = array();
        while($row = mysqli_fetch_array($sec_result)){
            if ($term == $row){
                $sec_data
            }
            $course = array("short_name"=>$row['short_name'], 
            "title"=>$row["title"],
            "faculty"=>$row["faculty"],
            "credit"=>$row["credit"],
            "description"=>$row["description"],
            "prerequisite"=>$row["prerequisite"]);
            array_push($data, json_encode($course));
        }
        // print_r($data);
        // echo json_encode(array_values($data));
        $json_data = json_encode($data);
        echo $json_data;
    }


    mysqli_close($con);
?>