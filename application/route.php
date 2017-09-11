<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
//使用动态配置
use think\Route;
//批量注册GET路由
Route::get([
	'/'=>'index/Index/index', //首页
	'login'=>'index/Index/Login', //登录
	'register'=>'index/Index/register', //注册
	'resume' => 'index/Resume/index',	//简历列表
	'create' => 'index/Resume/create',
	'addWork' => 'index/Resume/addWork',

	'showResume/:resumeId'=>['index/Resume/showResume?id=455',['ext'=>'shtml'],['resumeId'=>'\d{1,4}']],
]);


