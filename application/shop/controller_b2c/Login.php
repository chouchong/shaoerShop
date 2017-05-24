<?php
/**
 * Login.php
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2015-2025 山西牛酷信息科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: http://www.niushop.com.cn
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * =========================================================
 * @author : niuteam
 * @date : 2015.1.17
 * @version : v1.0.0.0
 */
namespace app\shop\controller_b2c;

use data\extend\ThinkOauth as ThinkOauth;
use data\service\niushop\Member as Member;
use data\service\system\Config as Config;
use data\service\system\WebSite as WebSite;
use think\Controller;
use think\Session;
\think\Loader::addNamespace('data', 'data/');

/**
 * 登录控制器
 * 创建人：李吉
 * 创建时间：2017-02-06 10:59:23
 */
class Login extends Controller
{
    // 验证码配置
    public $login_verify_code;

    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function _empty($name)
    {}

    public function init()
    {
        $this->user = new Member();
        $this->web_site = new WebSite();
        $web_info = $this->web_site->getWebSiteInfo();
        $this->assign("platform_shopname", $this->user->getInstanceName());
        $this->assign("title", $web_info['title']);
        if (request()->isMobile()) {
            $this->redirect("index/index/index");
        } else {
            $this->style = 'shop/' . NS_TEMPLATE.'/';
        }
        // 是否开启qq跟微信
        $tencent = new Config();
        $instance_id = 0;
        $qq_info = $tencent->getQQConfig($instance_id);
        $Wchat_info = $tencent->getWchatConfig($instance_id);
        $this->assign("qq_info", $qq_info);
        $this->assign("Wchat_info", $Wchat_info);
        // 是否开启验证码
        $web_config = new Config();
        $this->login_verify_code = $web_config->getLoginVerifyCodeConfig($instance_id);
        $this->assign("login_verify_code", $this->login_verify_code["oauth_value"]);
        
        $this->assign("style", 'shop/' . NS_TEMPLATE);
    }

    public function index()
    {
        if ($_POST) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if ($this->login_verify_code["oauth_value"]["pc"] == 1) {
                $vertification = $_POST['vertification'];
                if (! captcha_check($vertification)) {
                    $retval = [
                        'code' => 0,
                        'message' => "验证码错误"
                    ];
                    return $retval;
                }
            }
            $res = $this->user->login($username, $password);
            if ($res == 1) {
                if (! empty($_SESSION['login_pre_url'])) {
                    $retval = [
                        'code' => 1,
                        'url' => $_SESSION['login_pre_url']
                    ];
                } else {
                    $retval = [
                        'code' => 2,
                        'url' => 'Index/index'
                    ];
                }
            } else {
                $retval = AjaxReturn($res);
            }
            return $retval;
        }
        // 点击商品详情没有登录首先要获取上一页
        $pre_url = '';
        $_SESSION['bund_pre_url'] = '';
        if (! empty($_SERVER['HTTP_REFERER'])) {
            $pre_url = $_SERVER['HTTP_REFERER'];
            if (strpos($pre_url, 'login')) {
                $pre_url = '';
            }
            $_SESSION['login_pre_url'] = $pre_url;
        }
        // 获取商场logo
        $website = new WebSite();
        $web_info = $website->getWebSiteInfo();
        
        $tencent = new Config();
        $instance_id = 0;
        $qq_info = $tencent->getQQConfig($instance_id);
        $Wchat_info = $tencent->getWchatConfig($instance_id);
        $this->assign("qq_info", $qq_info);
        $this->assign("Wchat_info", $Wchat_info);
        $this->assign("web_info", $web_info);
        return view($this->style . 'Login/login');
    }

    /*
     * 吴奇
     * 首页登录
     * 2017/3/7 9:55
     */
    public function login()
    {
        $tencent = new Config();
        $instance_id = 0;
        $qq_info = $tencent->getQQConfig($instance_id);
        $Wchat_info = $tencent->getWchatConfig($instance_id);
        $this->assign("qq_info", $qq_info);
        $this->assign("Wchat_info", $Wchat_info);
        
        $username = $_POST['userName'];
        $password = $_POST['password'];
        if ($this->login_verify_code["oauth_value"]["pc"] == 1) {
            $vertification = $_POST['vertification'];
            if (! captcha_check($vertification)) {
                
                $retval = [
                    'code' => 0,
                    'message' => "验证码错误"
                ];
                return $retval;
            }
        }
        $res = $this->user->login($username, $password);
        if ($res == 1) {
            if (! empty($_SESSION['login_pre_url'])) {
                $retval = [
                    'code' => 1,
                    'url' => $_SESSION['login_pre_url']
                ];
            } else {
                $retval = [
                    'code' => 2,
                    'url' => 'Index/index'
                ];
            }
        } else {
            $retval = AjaxReturn($res);
        }
        return $retval;
    }

    /*
     * 吴奇
     * 2017/2/8 14:30
     * 以下两个分别为注册页面
     */
    public function mobile()
    {
        if (request()->isAjax()) {
            // 获取数据库中的用户列表
            $user_mobile = $_GET['mobile'];
            $exist = false;
            $user_list = $this->user->getMemberList();
            foreach ($user_list["data"] as $user_list2) {
                if ($user_list2["user_tel"] == $user_mobile) {
                    $exist = true;
                }
            }
            return $exist;
        }
        if ($_POST) {
            $min = 1;
            $max = 1000000000;
            $member = new Member();
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $email = '';
            $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
            $user_name = $mobile;
            
            $uid = $this->user->getSessionUid();
            $mobile_code = isset($_POST['mobile_code']) ? $_POST['mobile_code'] : '';
            $verification_code = Session::get('mobileVerificationCode');
            if ($mobile_code == $verification_code && ! empty($verification_code)) {
                $retval = $member->registerMember($user_name, $password, $email, $mobile, '', '', '', '', '');
                $result = true;
            } else {
                $retval = "";
                $result = false;
            }
            if ($retval > 0 && $result) {
                $this->success("注册成功", "login/index");
            } else {
                $this->success("注册失败", "login/register");
                // return AjaxReturn($retval);
            }
        }
        // 获取商场logo
        $website = new WebSite();
        $web_info = $website->getWebSiteInfo();
        
        $phone_email = new Config();
        $instanceid = 0;
        $phone_info = $phone_email->getMobileMessage($instanceid);
        $this->assign("phone_info", $phone_info);
        $email_info = $phone_email->getEmailMessage($instanceid);
        $this->assign("email_info", $email_info);
        
        $this->assign("web_info", $web_info);
        return view($this->style . "/Login/mobile");
    }

    public function email()
    {
        if (request()->isAjax()) {
            // 获取数据库中的用户列表
            $user_email = $_GET['email'];
            $exist = false;
            $user_list = $this->user->getMemberList();
            foreach ($user_list["data"] as $user_list2) {
                if ($user_list2["user_email"] == $user_email) {
                    $exist = true;
                }
            }
            return $exist;
        }
        if ($_POST) {
            $min = 1;
            $max = 1000000000;
            $member = new Member();
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $mobile = '';
            $user_name = $email;
            $uid = $this->user->getSessionUid();
            $email_code = isset($_POST['email_code']) ? $_POST['email_code'] : '';
            $verification_code = Session::get('emailVerificationCode');
            if ($email_code == $verification_code && ! empty($verification_code)) {
                $retval = $member->registerMember($user_name, $password, $email, $mobile, '', '', '', '', '');
                $result = true;
            } else {
                $retval = "";
                $result = false;
            }
            if ($retval > 0 && $result) {
                $this->success("注册成功", "Login/index");
            } else {
                $this->success("注册失败", "Login/register");
            }
        }
        // 获取商场logo
        $website = new WebSite();
        $web_info = $website->getWebSiteInfo();
        $phone_email = new Config();
        $instanceid = 0;
        $phone_info = $phone_email->getMobileMessage($instanceid);
        $this->assign("phone_info", $phone_info);
        $email_info = $phone_email->getEmailMessage($instanceid);
        $this->assign("email_info", $email_info);
        
        $this->assign("web_info", $web_info);
        return view($this->style . "Login/email");
    }

    public function register()
    {
        if (request()->isAjax()) {
            // 获取数据库中的用户列表
            $username = $_GET['username'];
            $exist = false;
            $user_list = $this->user->getMemberList();
            foreach ($user_list["data"] as $user_list2) {
                if ($user_list2["user_name"] == $username) {
                    $exist = true;
                }
            }
            return $exist;
        }
        if ($_POST) {
            $min = 10000000000;
            $max = 19999999999;
            $member = new Member();
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            // $email = rand($min, $max) . '@qq.com';
            // $mobile = rand($min, $max);
            $user_name = isset($_POST["username"]) ? $_POST["username"] : '';
            $retval = $member->registerMember($user_name, $password, '', '', '', '', '', '', '');
            if ($retval > 0) {
                $this->success("注册成功", "Login/index");
            } else {
                $this->success("注册失败", "Login/register");
                // return AjaxReturn($retval);
            }
        }
        $website = new WebSite();
        $web_info = $website->getWebSiteInfo();
        $phone_email = new Config();
        $instanceid = 0;
        $phone_info = $phone_email->getMobileMessage($instanceid);
        $this->assign("phone_info", $phone_info);
        
        $email_info = $phone_email->getEmailMessage($instanceid);
        $this->assign("email_info", $email_info);
        
        $this->assign("web_info", $web_info);
        return view($this->style . 'Login/register');
    }

    /*
     * 以下为找回密码页面
     */
    public function findPasswd()
    {
        return view($this->style . "Login/findPasswd");
    }

    public function findPasswd2()
    {
        return view($this->style . "Login/findPasswd2");
    }

    public function findPasswd3()
    {
        return view($this->style . "Login/findPasswd3");
    }

    public function findPasswd4()
    {
        return view($this->style . "Login/findPasswd4");
    }

    /**
     * 第三方登录登录
     */
    public function oauthLogin()
    {
        $type = $_GET['type'];
        $test = ThinkOauth::getInstance($type);
        $this->redirect($test->getRequestCodeURL());
    }

    /**
     * qq登录返回
     */
    public function callback()
    {
        $code = isset($_GET['code']) ? $_GET['code'] : '';
        if (empty($code))
            die();
        $qq = ThinkOauth::getInstance('QQLOGIN');
        $token = $qq->getAccessToken($code);
        if (! empty($token['openid'])) {
            if (! empty($_SESSION['bund_pre_url'])) {
                // 1.检测当前qqopenid是否已经绑定，如果已经绑定直接返回绑定失败
                $bund_pre_url = $_SESSION['bund_pre_url'];
                $_SESSION['bund_pre_url'] = '';
                $is_bund = $this->user->checkUserQQopenid($token['openid']);
                if ($is_bund == 0) {
                    // 2.绑定操作
                    $qq = ThinkOauth::getInstance('QQLOGIN', $token);
                    $data = $qq->call('user/get_user_info');
                    $_SESSION['qq_info'] = json_encode($data);
                    // 执行用户信息更新user服务层添加更新绑定qq函数（绑定，解绑）
                    $res = $this->user->bindQQ($token['openid'], json_encode($data));
                    // 如果执行成功执行跳转
                    
                    if ($res) {
                        $this->success('绑定成功', $bund_pre_url);
                    } else {
                        $this->error('绑定失败', $bund_pre_url);
                    }
                } else {
                    $this->error('该qq已经绑定', $bund_pre_url);
                }
            } else {
                $retval = $this->user->qqLogin($token['openid']);
                // 已经绑定
                if ($retval == 1) {
                    if (! empty($_SESSION['login_pre_url'])) {
                        $this->redirect($_SESSION['login_pre_url']);
                    } else
                        $this->redirect("Index/index");
                    // $this->success("登录成功", "Index/index");
                }
                if ($retval == USER_NBUND) {
                    $qq = ThinkOauth::getInstance('QQLOGIN', $token);
                    $data = $qq->call('user/get_user_info');
                    $_SESSION['qq_info'] = json_encode($data);
                    $this->assign("qq_info", json_encode($data));
                    $this->assign("qq_openid", $token['openid']);
                    $this->assign("data", $data);
                    return view($this->style . 'Login/qqcallback');
                }
            }
        }
    }
}