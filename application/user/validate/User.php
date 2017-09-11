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
			'phone.require'=>'�绰�������',
			'phone.unique'=>'�绰�����ѱ�ע��',
			'email.require'=>'�������䲻��Ϊ��',
			'email.email'=>'�����ʽ����ȷ',
			'password'=>'���벻��Ϊ��',
		];

		protected $scene = [
			'register'=>['phone','email','password']
		];
	}