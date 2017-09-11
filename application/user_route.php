<?php
	/**
	 *
	 * 用户模块，路由配置文件
	 * User: knight
	 * Date: 2017/9/11
	 * Time: 17:32
	 */
use think\Route;

//批量注册POST路由
Route::post([
	'login'=>'user/Index/Login', //登录
	'register'=>'user/Index/register', //注册

	'sendCode'=>'user/Index/getSmsCode', //发送短信验证码
]);