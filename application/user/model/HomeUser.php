<?php

	/**
	 *
	 * Created by PhpStorm.
	 * User: knight
	 * Date: 2017/9/11
	 * Time: 11:02
	 */
	namespace App\user\model;
	use think\Model;
	class HomeUser extends Model
	{
		const STATUS_ONE=1;
		protected $insert = ['status' => self::STATUS_ONE,'nick_name'];

		protected function setNickNameAttr()
		{
			return $this->phone;
		}

		/**
		 * 根据用户电话获取用户信息
		 * @access public
		 * @param $phone
		 * @return array
		 * @author knight
		 */
		public function getUserByPhone($phone)
		{
			return $this->where('phone',$phone)->find()->toArray();
		}

		/**
		 * 每次登陆修改登录IP与登录时间
		 * @access public
		 * @return bool
		 * @author knight
		 */
		public function setLoginInfo()
		{
			$this->last_login_time = time();
			$this->last_login_ip = request()->ip();
			if($this->isUpdate(true)->save()){
				return true;
			}
			return false;
		}
	}