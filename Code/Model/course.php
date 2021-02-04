<?php
    // get the q parameter from URL
    // $short_name = isset($_REQUEST('short_name'));
    // $short_name = $_GET['short_name'];
    $short_name = $_REQUEST["short_name"];

    if($short_name !== ""){
        // $host = "15.233.123.122";
        $host = "localhost";
        $username = 'root';
        $pass = "vsbp";
        $database = "course";
        $conn = mysqli_connect($host, $username, $pass, $database);
        if (!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $count_sql =  "SELECT COUNT(*) FROM course where short_name = '" . $short_name . "'"; 
        $count_res = mysqli_query($conn, $count_sql);
        $count = mysqli_fetch_array($count_res)[0];
        
        // If there is a course that is required.
        if ($count > 0){
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

            $json_data = json_encode($data);
            echo $json_data;
        }
        else{
            echo "Cannot find the course!";
        }
        
        // print_r($data);
        // echo json_encode(array_values($data));
        mysqli_close($conn);
    }



?>