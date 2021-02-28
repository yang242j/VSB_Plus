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
	 * 会自动将请求参数中的name值注入到这个函数的name参数中
	 * 声明这个接口是POST调用
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
	 * 会自动将请求参数中的name,id值注入到这个函数的name,id参数中
	 * 声明这个接口是GET调用
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