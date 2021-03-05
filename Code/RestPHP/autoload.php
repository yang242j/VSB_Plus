<?php

spl_autoload_register(function ($name) {
	$RestPHPClassArgs = array(                //RestPHP的类列表
		'Printf' => 'Printf.php',
		'Init' => 'Init.php'
	);
	if (isset($RestPHPClassArgs[$name]))   //只加载RestPHP的类
	{
		require_once $RestPHPClassArgs[$name];
	}
});


(new Init())->run();