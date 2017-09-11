<?php
	/**
	 *
	 * Created by PhpStorm.
	 * User: knight
	 * Date: 2017/9/11
	 * Time: 15:52
	 */

	namespace app\user\validate;


	use think\Validate;

	class User extends Validate
	{
		protected $rule = [
			'phone' =>'require|unique:HomeUser',
			'email' =>'require|email',
			'password' =>'require'
		];

		protected $message = [
			'phone.require'=>'电话号码必须',
			'phone.unique'=>'电话号码已被注册',
			'email.require'=>'电子邮箱不能为空',
			'email.email'=>'邮箱格式不正确',
			'password'=>'密码不能为空',
		];

		protected $scene = [
			'register'=>['phone','email','password']
		];
	}