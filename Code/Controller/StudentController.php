<?php

/**
 * Created by Xinyu Liu.
 * User: Xinyu Liu
 * Date: 2021/2/26
 * Time: pm 5:44
 */

class StudentController
{
	/**
	 * No parameter
	 * 
	 * Declare that this interface is initiated by GET
	 * @method:GET
	 */
	public function Index()
	{
		return [
			"message" => "This is index controller for Student"
		];
	}

	/**
	 * Will automatically insert the sid, password value 
	 * in the request parameter into the sid, password  parameter of this function
	 * 
	 * Declare that this interface is initiated by POST
	 * @method:POST
	 */
	public function Login($sid, $password)
	{
		return array(
			"_message" => "No student id",
			"_code" => "100"
		);
		return array(
			"_message" => "Uncorrect password",
			"_code" => "101"
		);
		return array(
			"_message" => "Successful login",
		);
	}

	/**
	 * Will automatically insert the sid value 
	 * in the request parameter into the sid parameter of this function
	 * 
	 * Declare that this interface is initiated by POST
	 * @method: POST
	 */
	public function BasicInfo($sid)
	{
		require_once "./Model/vsbp_db_config.php";

		$count_sql =  "SELECT COUNT(*) FROM students where student_id = '" . $sid . "'";
		$count_res = mysqli_query($conn, $count_sql);
		$count = mysqli_fetch_array($count_res)[0];

		if ($count == 0) {
			return array(
				"_message" => "Uncorrect student id",
				"_code" => "102"
			); 
		} else {
			$detail_sql = "SELECT * FROM students where student_id = '" . $sid . "'";
			$detail_result = mysqli_query($conn, $detail_sql);
			$row = mysqli_fetch_array($detail_result);
			return array(
				"_message" => "success",
				"_code" => "200",
				"student_id" => $row['student_id'],
				"name" => $row['name'],
				"campus" => $row['campus'],
				"faculty" => $row['faculty'],
				"program" => $row['program'],
				"major" => $row['major'],
				"minor" => $row['minor'],
				"concentration" => $row['concentration'],
				"totalCredit" => $row['totalCredit'],
				"GPA" => $row['GPA'],
				"hashed_password" => $row['password']
			);
		}
	}

	/**
	 * Will automatically insert the sid value 
	 * in the request parameter into the sid parameter of this function
	 * 
	 * Declare that this interface is initiated by POST
	 * @method: POST
	 */
	public function TakenCourse($sid)
	{
		require_once "./Model/vsbp_db_config.php";

		$count_sql =  "SELECT COUNT(*) FROM students where student_id = '" . $sid . "'";
		$count_res = mysqli_query($conn, $count_sql);
		$count = mysqli_fetch_array($count_res)[0];

		if ($count == 0) {
			return array(
				"_message" => "Uncorrect student id",
				"_code" => "102"
			);
		} else {
			$takenCourse_sql = "SELECT * FROM S" . $sid ;
			$takenCourse_result = mysqli_query($conn, $takenCourse_sql);

			if (!$takenCourse_result) {
				return array(
					"_message" => "No courses are taken",
					"_code" => "103"
				);
			}

			$data = array();
			// 4) Covert to the data array with taken class 
			while ($row = mysqli_fetch_array($takenCourse_result)) {
				$oneTaken = array(
					"courseIndex" => $row['courseIndex'],
					"term" => $row['term'],
					"course_ID" => $row['course_ID'],
					"section_num" => $row['section_num'],
					"course_title" => $row['course_title'],
					"final_grade" => $row['final_grade'],
					"credit_hour" => $row['credit_hour'],
					"credit_earned" => $row['credit_earned'],
					"class_size" => $row['class_size'],
					"class_average" => $row['class_average']
				);
				array_push($data, $oneTaken);
			}
			$statu = array(
				"_message" => "success",
				"_code" => "200"
			);
			return array_merge($data, $statu);
		}
	}
}
