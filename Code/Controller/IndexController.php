<?php
/**
 * Created by Xinyu Liu.
 * User: Xinyu Liu
 * Date: 2021/2/26
 * Time: pm 5:44
 */

class IndexController
{
	/**
	 * Will automatically insert the name value 
	 * in the request parameter into the name parameter of this function
	 * 
	 * Declare that this interface is initiated by GET
	 * @method:get
	 */
	public function Index($name)
	{
		return [
			// "_code" => 200,
			// "_message" => 'suesss',
			"message" => "This is index controller"
		];
	}


	/**
	 * Will automatically insert the sid, password value 
	 * in the request parameter into the sid, password  parameter of this function
	 * 
	 * Declare that this interface is initiated by GET
	 * @method:get
	 */
	public function test($id, $name)
	{
		return array(
			"id" => $id,
			"name" => $name
		);
	}
}