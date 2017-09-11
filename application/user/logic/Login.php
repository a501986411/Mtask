<?php
	/**
	 *
	 * Created by PhpStorm.
	 * User: knight
	 * Date: 2017/9/11
	 * Time: 16:09
	 */

	namespace app\logic\Login;


	use App\user\model\HomeUser;
	use think\Model;

	class Login extends Model
	{
		private $model;

		/**
		 * 登录功能
		 * @access public
		 * @param $phone
		 * @param $password
		 * @return bool
		 * @author knight
		 */
		public function login($phone,$password)
		{
			$this->model = new HomeUser();
			$info = $this->model->where(['phone',$phone.'status'=>HomeUser::STATUS_ONE])->column('id','salt','password','nick_name');
			if(!empty($info) && encrypt($password.$info['salt']) === $info['password']){
				if(!$info->setLoginInfo()){
					return false;
				}
				$token =  $this->createToken($info['id']);
				$info['token'] = $token;
				return $info;
			}
			return false;
		}


		/**
		 * 构造用户登录token
		 * @access public
		 * @return void
		 * @author knight
		 */
		protected function createToken($id)
		{
			$user_info = $this->where('id',$id)->find();
			if ($user_info) {
				# 组装JWT(token)字符串【JWT包含3部分】
				# 第一部分我们称它为头部（header),
				# 第二部分我们称其为载荷（payload, 类似于飞机上承载的物品)，
				# 第三部分是签证（signature)

				# 【第一部分】组装头部（header)
				$header = [
					'typ' => 'JWT',
					'alg'  => config('token_alg_secret'),
				];
				$jwt_header = base64_encode( json_encode($header) );
				# 【第二部分】组装载荷（payload）
				$payload = [
					'phone'   => $user_info['phone'],
					'nick_name'  => $user_info['nick_name'],
					'id'      => $user_info['id']
				];
				$jwt_payload = base64_encode( json_encode($payload) );

				# 【第三部分】组装签证（signature)
				$signature = $jwt_header.'.'.$jwt_payload;
				$jwt_signature = hash_hmac('md5', $signature, config('token_signature_secret'), false);
				$jwt_signature = base64_encode( $jwt_signature );

				$token = $jwt_header.'.'.$jwt_payload.'.'.$jwt_signature;
				return $token;
			}else{
				return false;
			}
		}

	}