<?php
namespace app\user\controller;


use app\logic\Login;
use App\user\model\HomeUser;
use think\Controller;
use think\Db;
use think\Exception;
use think\Request;
use alySms\api_demo\SmsDemo;


class Index extends Controller
{

    /**
     * 用户登录
     * @access public
     * @return array
     * @author knight
     */
    public function login()
    {
        if(Request::instance()->isPost()) {
            $phone = input('phone');
            $password = input('password');
            //登录操作
            $logic = new Login();
            $info = $logic->login($phone,$password);
            if($info===false){
                return ['status'=>false,'msg'=>'登录失败'];
            }
            return ['status'=>true,'msg'=>'登录成功','token'=>$info['token'],'nick_name'=>$info['nick_name']];
        }
    }

    /**
     * 用户注册
     * @return \think\response\View
     */
    public function register()
    {
        if(Request::instance()->isPost()){
            $rgData['phone'] = input('?post.phone');
            $rgData['email'] = input('?post.email');
            $password = input('?post.password');
            if($rgData['phone'] && $rgData['email'] && $password){
                return ['status'=>false,'msg'=>'参数不正确','param'=>json_encode(input(),JSON_UNESCAPED_UNICODE)];
            }
            $rgData['salt'] = createStr();
            $rgData['password'] = encrypt($password,$rgData['salt']);
            $checkResult = $this->validate($rgData,'User.register');
            if($checkResult !== true){
                return ['status'=>false,'msg'=>$checkResult];
            }
            try{
                Db::startTrans();
                $user = new HomeUser();
                $userId = $user->data($rgData)->save();
                if(!$userId){
                    throw new Exception('注册失败');
                }

                //登录操作
                $logic = new Login();
                $info = $logic->login($rgData['phone'],$rgData['password']);
                if($info===false)
                {
                    throw new Exception('注册失败');
                }
                Db::commit();
                return ['status'=>true,'msg'=>'注册成功','token'=>$info['token'],'nick_name'=>$info['nick_name']];
            }catch (Exception $e){
                Db::rollback();
                return ['status'=>false,'msg'=>$e->getMessage()];
            }



        }
    }

    /**
     * 发送短信验证码
     * @access public
     * @return array
     * @author knight
     */
    public function getSmsCode()
    {
        if(Request::instance()->has('code','post') && Request::instance()->has('phone','post')){
            $code = input('code');
            $phone = input('phone');
            $sms = new SmsDemo();
            $response = $sms->sendSms(
                "M导师", // 短信签名
                "SMS_94695118", // 短信模板编号
                $phone, // 短信接收者
                ["code"=>$code]// 短信模板中字段的值
            );
            $response = json_decode($response,'true');
            if($response['Code']=='OK'){
                return ['status'=>true,'msg'=>'验证码发送成功'];
            }
        }
        return ['status'=>false,'msg'=>'验证码发送失败'];
    }
}
