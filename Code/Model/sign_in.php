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

    $host = "localhost";
    $username = 'root';
    $pass = "vsbp";
    $database = "vsb_plus";
    $conn = mysqli_connect($host, $username, $pass, $database);
    if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $count_sql =  "SELECT COUNT(*) FROM students where student_id = '" . $sid . "'"; 
    $count_res = mysqli_query($conn, $count_sql);
    $count = mysqli_fetch_array($count_res)[0];
    
    // If there is a course that is required.
    if ($count > 0){
        $detail_sql = "SELECT * FROM students where student_id = '" . $sid . "'"; 
        $detail_result = mysqli_query($conn, $detail_sql);
    
        $row = mysqli_fetch_array($detail_result);
        if (password_verify($pw, $row['password'])){
            $data = array("student_id"=>$row['student_id'],
            "name"=>$row['name'],
            "campus"=>$row['campus'],
            "faculty"=>$row['faculty'],
            "program"=>$row['program'],
            "major"=>$row['major(s)'],
            "minor"=>$row['minor(s)'],
            "concentration"=>$row['concentration(s)'],
            "totalCredit"=>$row['totalCredit'],
            "GPA"=>$row['GPA'],
            "hashed_password"=>$row['password']);

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