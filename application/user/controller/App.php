<?php
	/**
	 *Action基类
	 * User: knight
	 * Date: 2017/4/24
	 * Time: 13:39
	 */
    namespace app\user\controller;

    use think\Controller;
	class App extends Controller
	{
		protected $beforeActionList = [
		    'interceptor' ,//拦截器
        ];

		public function __construct()
		{
		    parent::__construct();
		}

        /**
         * 访问拦截器
         */
        protected function interceptor(){
            $token = inpuut('token');
            if(!$this->checkToken($token)){
                return ['status'=>false,'msg'=>'用户信息失效,请重新登录'];
            }
        }

        /**
         * 验证token
         * @access public
         * @param $token
         * @return bool
         * @author knight
         */
        protected function checkToken($token)
        {
            # 【第一部分】组装头部（header)
            $header  = json_decode(base64_decode($token[0]), true);
            # 【第二部分】组装载荷（payload）
            $payload = json_decode(base64_decode($token[1]), true);
            # 【第三部分】组装签证（signature
            $signature = base64_decode($token[2]);
            if ( ($header['alg'] == config('token_alg_secret')) && ($header['typ'] == 'JWT') ) {
                $signature_new = $token[0].'.'.$token[1];
                $jwt_signature_new = hash_hmac('md5', $signature_new, config('token_signature_secret'), false);
                if ($jwt_signature_new === $signature) {
                    return true;
                }
            }
            return false;
        }

		/**
		 * 空操作默认方法
		 * @access public
		 * @return string
		 * @author knight
		 */
		public function _empty()
		{
			return lang('error url');
		}

	}