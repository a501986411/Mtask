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
		 * ��¼����
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
		 * �����û���¼token
		 * @access public
		 * @return void
		 * @author knight
		 */
		protected function createToken($id)
		{
			$user_info = $this->where('id',$id)->find();
			if ($user_info) {
				# ��װJWT(token)�ַ�����JWT����3���֡�
				# ��һ�������ǳ���Ϊͷ����header),
				# �ڶ��������ǳ���Ϊ�غɣ�payload, �����ڷɻ��ϳ��ص���Ʒ)��
				# ����������ǩ֤��signature)

				# ����һ���֡���װͷ����header)
				$header = [
					'typ' => 'JWT',
					'alg'  => config('token_alg_secret'),
				];
				$jwt_header = base64_encode( json_encode($header) );
				# ���ڶ����֡���װ�غɣ�payload��
				$payload = [
					'phone'   => $user_info['phone'],
					'nick_name'  => $user_info['nick_name'],
					'id'      => $user_info['id']
				];
				$jwt_payload = base64_encode( json_encode($payload) );

				# ���������֡���װǩ֤��signature)
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