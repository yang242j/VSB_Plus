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
	 * Will automatically insert the name value 
     * in the request parameter into the name parameter of this function
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
	 * Will automatically insert the sid value 
     * in the request parameter into the sid parameter of this function
     * 
     * Declare that this interface is initiated by POST
	 * @method:POST
	 */
	public function TakenCourse($sid)
	{
		return array(
		);
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
	 * @method:POST
	 */
	public function BasicInfo($sid)
	{
		require_once "../Model/vsbp_db_config.php";
		return array(
		);
	}

    
}