<?php
	/**
	 *
	 * �û�ģ�飬·�������ļ�
	 * User: knight
	 * Date: 2017/9/11
	 * Time: 17:32
	 */
use think\Route;

//����ע��POST·��
Route::post([
	'login'=>'user/Index/Login', //��¼
	'register'=>'user/Index/register', //ע��

	'sendCode'=>'user/Index/getSmsCode', //���Ͷ�����֤��
]);