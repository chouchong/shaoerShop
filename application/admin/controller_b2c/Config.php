<?php
/**
 * Config.php
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
namespace app\admin\controller_b2c;

use data\service\niushop\Platform;
use data\service\niushop\Shop as Shop;
use data\service\system\Config as WebConfig;
use data\service\niushop\Promote;
use data\extend\Send;

/**
 * 网站设置模块控制器
 *
 * @author Administrator
 *        
 */
class Config extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 网站设置
     */
    public function webConfig()
    {
        if ($_POST) {
            // 网站设置
            $title = $_POST['title']; // 网站标题
            $logo = $_POST['logo']; // 网站logo
            $web_desc = $_POST['web_desc']; // 网站描述
            $key_words = $_POST['key_words']; // 网站关键字
            $web_icp = $_POST['web_icp']; // 网站备案号
            $web_style = $_POST['web_style']; // 网站风格
            $web_qrcode = $_POST['web_qrcode']; // 网站公众号二维码
            $web_url = $_POST['web_url']; // 店铺网址
            $web_phone = $_POST['web_phone']; // 网站联系方式
            $web_email = $_POST['web_email']; // 网站邮箱
            $web_qq = $_POST['web_qq']; // 网站qq号
            $web_weixin = $_POST['web_weixin']; // 网站微信号
            $web_address = $_POST['web_address']; // 网站联系地址
            $retval = $this->website->updateWebSite($title, $logo, $web_desc, $key_words, $web_icp, $web_style, $web_qrcode, $web_url, $web_phone, $web_email, $web_qq, $web_weixin, $web_address);
            return AjaxReturn($retval);
        } else {
            $list = $this->website->getWebSiteInfo();
            $style_list = $this->website->getWebStyleList();
            $path = getQRcode('HTTP://' . $_SERVER['HTTP_HOST'], 'upload/qrcode', 'url');
            $this->assign('style_list', $style_list);
            $this->assign("website", $list);
            $this->assign("qrcode_path", $path);
            return view($this->style . "Config/webConfig");
        }
    }

    /**
     * qq登录配置
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function loginQQConfig()
    {
        $appkey = isset($_POST['appkey']) ? $_POST['appkey'] : '';
        $appsecret = isset($_POST['appsecret']) ? $_POST['appsecret'] : '';
        $url = isset($_POST['url']) ? $_POST['url'] : '';
        $call_back_url = isset($_POST['call_back_url']) ? $_POST['call_back_url'] : '';
        $is_use = isset($_POST['is_use']) ? $_POST['is_use'] : 0;
        $web_config = new WebConfig();
        // 获取数据
        $retval = $web_config->setQQConfig($this->instance_id, $appkey, $appsecret, $url, $call_back_url, $is_use);
        return AjaxReturn($retval);
    }

    /**
     * 微信登录配置
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function loginWeixinConfig()
    {
        $appid = isset($_POST['appkey']) ? $_POST['appkey'] : '';
        $appsecret = isset($_POST['appsecret']) ? $_POST['appsecret'] : '';
        $url = isset($_POST['url']) ? $_POST['url'] : '';
        $call_back_url = isset($_POST['call_back_url']) ? $_POST['call_back_url'] : '';
        $is_use = isset($_POST['is_use']) ? $_POST['is_use'] : 0;
        $web_config = new WebConfig();
        // 获取数据
        $retval = $web_config->setWchatConfig($this->instance_id, $appid, $appsecret, $url, $call_back_url, $is_use);
        return AjaxReturn($retval);
    }

    /**
     * 第三方登录 页面显示
     */
    public function loginConfig()
    {
        $type = isset($_GET["type"]) ? $_GET["type"] : "qq";
        if ($type == "qq") {
            $child_menu_list = array(
                array(
                    'url' => "config/loginconfig?type=qq",
                    'menu_name' => "QQ登录",
                    "active" => 1
                ),
                array(
                    'url' => "config/loginconfig?type=wchat",
                    'menu_name' => "微信登录",
                    "active" => 0
                )
            );
        } else {
            $child_menu_list = array(
                array(
                    'url' => "config/loginconfig?type=qq",
                    'menu_name' => "QQ登录",
                    "active" => 0
                ),
                array(
                    'url' => "config/loginconfig?type=wchat",
                    'menu_name' => "微信登录",
                    "active" => 1
                )
            );
        }
        $this->assign('child_menu_list', $child_menu_list);
        $this->assign("type", $type);
        $web_config = new WebConfig();
        // qq登录配置
        // 获取当前域名
        $domain_name = \think\Request::instance()->domain();
        // 获取回调域名qq回调域名
        $qq_call_back = $domain_name . \think\Request::instance()->root() . '/wap/login/callback';
        // 获取qq配置信息
        $qq_config = $web_config->getQQConfig($this->instance_id);
        $qq_config['oauth_value']["AUTHORIZE"] = $domain_name;
        $qq_config['oauth_value']["CALLBACK"] = $qq_call_back;
        $this->assign("qq_config", $qq_config);
        // 微信登录配置
        // 微信登录返回
        $wchat_call_back = $domain_name . \think\Request::instance()->root() . '/wap/Login/callback';
        $wchat_config = $web_config->getWchatConfig($this->instance_id);
        $wchat_config['oauth_value']["AUTHORIZE"] = $domain_name;
        $wchat_config['oauth_value']["CALLBACK"] = $wchat_call_back;
        $this->assign("wchat_config", $wchat_config);
        
        return view($this->style . "Config/loginConfig");
    }

    /**
     * 支付配置
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function payConfig()
    {
        if (request()->isAjax()) {
            $type = isset($_POST['type']) ? $_POST['type'] : '';
            if ($type == 'wchat') {
                // 微信支付
                $appkey = isset($_POST['appkey']) ? $_POST['appkey'] : '';
                $appsecret = isset($_POST['appsecret']) ? $_POST['appsecret'] : '';
                $paySignKey = isset($_POST['paySignKey']) ? $_POST['paySignKey'] : '';
                $MCHID = isset($_POST['MCHID']) ? $_POST['MCHID'] : '';
                $is_use = isset($_POST['is_use']) ? $_POST['is_use'] : 0;
                $web_config = new WebConfig();
                // 获取数据
                $retval = $web_config->setWpayConfig($this->instance_id, $appkey, $appsecret, $MCHID, $paySignKey, $is_use);
                return AjaxReturn($retval);
            } else {
                // 支付宝
                $partnerid = isset($_POST['partnerid']) ? $_POST['partnerid'] : '';
                $seller = isset($_POST['seller']) ? $_POST['seller'] : '';
                $ali_key = isset($_POST['ali_key']) ? $_POST['ali_key'] : '';
                $is_use = isset($_POST['is_use']) ? $_POST['is_use'] : 0;
                $web_config = new WebConfig();
                // 获取数据
                $retval = $web_config->setAlipayConfig($this->instance_id, $partnerid, $seller, $ali_key, $is_use);
                return AjaxReturn($retval);
            }
        } else {
            $type = isset($_GET['type']) ? $_GET['type'] : 'wchat';
            if ($type == 'wchat') {
                
                $child_menu_list = array(
                    array(
                        'url' => "Config/payConfig?type=wchat",
                        'menu_name' => "微信支付",
                        "active" => 1
                    ),
                    array(
                        'url' => "Config/payConfig?type=ali",
                        'menu_name' => "支付宝支付",
                        "active" => 0
                    )
                );
                $this->assign('child_menu_list', $child_menu_list);
                $web_config = new WebConfig();
                $data = $web_config->getWpayConfig($this->instance_id);
                $this->assign("config", $data);
                return view($this->style . "Config/payConfig");
            } else {
                $child_menu_list = array(
                    array(
                        'url' => "Config/payConfig?type=wchat",
                        'menu_name' => "微信支付",
                        "active" => 0
                    ),
                    array(
                        'url' => "Config/payConfig?type=ali",
                        'menu_name' => "支付宝支付",
                        "active" => 1
                    )
                );
                $this->assign('child_menu_list', $child_menu_list);
                $web_config = new WebConfig();
                $data = $web_config->getAlipayConfig($this->instance_id);
                $this->assign("config", $data);
                return view($this->style . "Config/payAliConfig");
            }
        }
    }

    /**
     * 广告列表
     */
    public function shopAdList()
    {
        if (request()->isAjax()) {
            $shop_ad = new Shop();
            
            $list = $shop_ad->getShopAdList(1, 10, [
                'shop_id' => $this->instance_id
            ], 'sort');
            return $list;
        }
        return view($this->style . "Config/shopAdList");
    }

    /**
     * 添加店铺广告
     *
     * @return \think\response\View
     */
    public function addShopAd()
    {
        if (request()->isAjax()) {
            $ad_image = isset($_POST['ad_image']) ? $_POST['ad_image'] : '';
            $link_url = isset($_POST['link_url']) ? $_POST['link_url'] : '';
            $sort = isset($_POST['sort']) ? $_POST['sort'] : 0;
            $type = isset($_POST['type']) ? $_POST['type'] : 0;
            $background = isset($_POST['background']) ? $_POST['background'] : '#FFFFFF';
            $shop_ad = new Shop();
            $res = $shop_ad->addShopAd($ad_image, $link_url, $sort, $type, $background);
            return AjaxReturn($res);
        }
        return view($this->style . "Config/addShopAd");
    }

    /**
     * 修改店铺广告
     */
    public function updateShopAd()
    {
        if (request()->isAjax()) {
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $ad_image = isset($_POST['ad_image']) ? $_POST['ad_image'] : '';
            $link_url = isset($_POST['link_url']) ? $_POST['link_url'] : '';
            $sort = isset($_POST['sort']) ? $_POST['sort'] : 0;
            $type = isset($_POST['type']) ? $_POST['type'] : 0;
            $background = isset($_POST['background']) ? $_POST['background'] : '#FFFFFF';
            $shop_ad = new Shop();
            $res = $shop_ad->updateShopAd($id, $ad_image, $link_url, $sort, $type, $background);
            return AjaxReturn($res);
        }
        $shop_ad = new Shop();
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $info = $shop_ad->getShopAdDetail($id);
        $this->assign('info', $info);
        return view($this->style . "Config/updateShopAd");
    }

    public function delShopAd()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $res = 0;
        if (! empty($id)) {
            $shop_ad = new Shop();
            $res = $shop_ad->delShopAd($id);
        }
        return AjaxReturn($res);
    }

    /**
     * 店铺导航列表
     */
    public function shopNavigationList()
    {
        if (request()->isAjax()) {
            $shop = new Shop();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '1';
            $list = $shop->ShopNavigationList($pageindex, PAGESIZE, '', 'sort');
            return $list;
        } else {
            return view($this->style . "Config/shopNavigationList");
        }
    }

    /**
     * 店铺导航添加
     *
     * @return multitype:unknown
     */
    public function addShopNavigation()
    {
        if (request()->isAjax()) {
            $shop = new Shop();
            $nav_title = isset($_POST['nav_title']) ? $_POST['nav_title'] : '';
            $nav_url = isset($_POST['nav_url']) ? $_POST['nav_url'] : '';
            $type = isset($_POST['type']) ? $_POST['type'] : '';
            $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
            $align = isset($_POST['align']) ? $_POST['align'] : '';
            $retval = $shop->addShopNavigation($nav_title, $nav_url, $type, $sort, $align);
            return AjaxReturn($retval);
        } else {
            return view($this->style . "Config/addShopNavigation");
        }
    }

    /**
     * 修改店铺导航
     *
     * @return multitype:unknown
     */
    public function updateShopNavigation()
    {
        if (request()->isAjax()) {
            $shop = new Shop();
            $nav_id = isset($_POST['nav_id']) ? $_POST['nav_id'] : '';
            $nav_title = isset($_POST['nav_title']) ? $_POST['nav_title'] : '';
            $nav_url = isset($_POST['nav_url']) ? $_POST['nav_url'] : '';
            $type = isset($_POST['type']) ? $_POST['type'] : '';
            $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
            $align = isset($_POST['align']) ? $_POST['align'] : '';
            $retval = $shop->updateShopNavigation($nav_id, $nav_title, $nav_url, $type, $sort, $align);
            return AjaxReturn($retval);
        } else {
            $shop = new Shop();
            $nav_id = isset($_GET['nav_id']) ? $_GET['nav_id'] : '';
            $data = $shop->shopNavigationDetail($nav_id);
            $this->assign('data', $data);
            return view($this->style . "Config/updateShopNavigation");
        }
    }

    /**
     * 删除店铺导航
     *
     * @return multitype:unknown
     */
    public function delShopNavigation()
    {
        if (request()->isAjax()) {
            $shop = new Shop();
            $nav_id = isset($_POST['nav_id']) ? $_POST['nav_id'] : '';
            $retval = $shop->delShopNavigation($nav_id);
            return AjaxReturn($retval);
        }
    }

    /**
     * 修改店铺导航排序
     *
     * @return multitype:unknown
     */
    public function modifyShopNavigationSort()
    {
        if (request()->isAjax()) {
            $shop = new Shop();
            $nav_id = isset($_POST['nav_id']) ? $_POST['nav_id'] : '';
            $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
            $retval = $shop->modifyShopNavigationSort($nav_id, $sort);
            return AjaxReturn($retval);
        }
    }

    /**
     * 友情链接列表
     *
     * @return unknown[]
     */
    public function linkList()
    {
        if (request()->isAjax()) {
            $index = isset($_POST["pageIndex"]) ? $_POST["pageIndex"] : 1;
            $search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
            $platform = new Platform();
            $list = $platform->getLinkList($index, PAGESIZE, [
                'link_title' => array(
                    'like',
                    '%' . $search_text . '%'
                )
            ]);
            return $list;
        }
        return view($this->style . "Config/linkList");
    }

    /**
     * 添加友情链接
     *
     * @return unknown[]
     */
    public function addLink()
    {
        if (request()->isAjax()) {
            $link_title = isset($_POST["link_title"]) ? $_POST["link_title"] : '';
            $link_url = isset($_POST["link_url"]) ? $_POST["link_url"] : '';
            $link_pic = isset($_POST["link_pic"]) ? $_POST["link_pic"] : '';
            $link_sort = isset($_POST["link_sort"]) ? $_POST["link_sort"] : 0;
            $platform = new Platform();
            $res = $platform->addLink($link_title, $link_url, $link_pic, $link_sort);
            return AjaxReturn($res);
        }
        return view($this->style . "Config/addLink");
    }

    /**
     * 修改友情链接
     */
    public function updateLink()
    {
        if (request()->isAjax()) {
            $link_id = isset($_POST["link_id"]) ? $_POST["link_id"] : '';
            $link_title = isset($_POST["link_title"]) ? $_POST["link_title"] : '';
            $link_url = isset($_POST["link_url"]) ? $_POST["link_url"] : '';
            $link_pic = isset($_POST["link_pic"]) ? $_POST["link_pic"] : '';
            $link_sort = isset($_POST["link_sort"]) ? $_POST["link_sort"] : 0;
            $platform = new Platform();
            $res = $platform->updateLink($link_id, $link_title, $link_url, $link_pic, $link_sort);
            return AjaxReturn($res);
        }
        $link_id = isset($_GET["link_id"]) ? $_GET["link_id"] : '';
        $platform = new Platform();
        $link_info = $platform->getLinkDetail($link_id);
        $this->assign('link_info', $link_info);
        return view($this->style . "Config/updateLink");
    }

    /**
     * 删除友情链接
     *
     * @return unknown[]
     */
    public function delLink()
    {
        $link_id = isset($_POST["link_id"]) ? $_POST["link_id"] : '';
        $platform = new Platform();
        $res = $platform->deleteLink($link_id);
        return AjaxReturn($res);
    }

    /**
     * 搜索设置
     */
    public function searchConfig()
    {
        $type = isset($_GET["type"]) ? $_GET["type"] : "hot";
        if ($type == "hot") {
            $child_menu_list = array(
                array(
                    'url' => "Config/searchConfig?type=hot",
                    'menu_name' => "热门搜索",
                    "active" => 1
                ),
                array(
                    'url' => "Config/searchConfig?type=default",
                    'menu_name' => "默认搜索",
                    "active" => 0
                )
            );
        } else {
            
            $child_menu_list = array(
                array(
                    'url' => "Config/searchConfig?type=hot",
                    'menu_name' => "热门搜索",
                    "active" => 0
                ),
                array(
                    'url' => "Config/searchConfig?type=default",
                    'menu_name' => "默认搜索",
                    "active" => 1
                )
            );
        }
        $web_config = new WebConfig();
        // 热门搜索
        $keywords_array = $web_config->getHotsearchConfig($this->instance_id);
        if (! empty($keywords_array)) {
            $keywords = implode(",", $keywords_array);
        } else {
            $keywords = '';
        }
        $this->assign('hot_keywords', $keywords);
        // 默认搜索
        $default_keywords = $web_config->getDefaultSearchConfig($this->instance_id);
        $this->assign('default_keywords', $default_keywords);
        $this->assign('child_menu_list', $child_menu_list);
        $this->assign('type', $type);
        return view($this->style . "Config/searchConfig");
    }

    /**
     * 热门搜索 提交修改
     */
    public function hotSearchConfig()
    {
        $keywords = isset($_POST["keywords"]) ? $_POST["keywords"] : '';
        if (! empty($keywords)) {
            $keywords_array = explode(",", $keywords);
        } else {
            $keywords_array = array();
        }
        $web_config = new WebConfig();
        $res = $web_config->setHotsearchConfig($this->instance_id, $keywords_array, 1);
        return AjaxReturn($res);
    }

    /**
     * 默认搜索 提交修改
     */
    public function defaultSearchConfig()
    {
        $keywords = isset($_POST["default_keywords"]) ? $_POST["default_keywords"] : '';
        $web_config = new WebConfig();
        $res = $web_config->setDefaultSearchConfig($this->instance_id, $keywords, 1);
        return AjaxReturn($res);
    }

    /**
     * 验证码设置
     *
     * @return \think\response\View
     */
    public function codeConfig()
    {
        $webConfig = new WebConfig();
        if (request()->isAjax()) {
            $platform = 0; // isset($_POST['platform']) ? $_POST['platform'] : '';
            $admin = isset($_POST['adminCode']) ? $_POST['adminCode'] : 0;
            $pc = isset($_POST['pcCode']) ? $_POST['pcCode'] : 0;
            $res = $webConfig->setLoginVerifyCodeConfig($this->instance_id, $platform, $admin, $pc);
            return AjaxReturn($res);
        }
        $code_config = $webConfig->getLoginVerifyCodeConfig($this->instance_id);
        $this->assign('code_config', $code_config["oauth_value"]);
        return view($this->style . 'Config/codeConfig');
    }

    /**
     * 邮件短信接口设置
     */
    public function messageConfig()
    {
        $type = isset($_GET["type"]) ? $_GET["type"] : "email";
        if ($type == 'email') {
            $child_menu_list = array(
                array(
                    'url' => "Config/messageConfig?type=email",
                    'menu_name' => "邮箱设置",
                    "active" => 1
                ),
                array(
                    'url' => "Config/messageConfig?type=sms",
                    'menu_name' => "短信设置",
                    "active" => 0
                )
            );
        } else {
            $child_menu_list = array(
                array(
                    'url' => "Config/messageConfig?type=email",
                    'menu_name' => "邮箱设置",
                    "active" => 0
                ),
                array(
                    'url' => "Config/messageConfig?type=sms",
                    'menu_name' => "短信设置",
                    "active" => 1
                )
            );
        }
        $config = new WebConfig();
        $email_message = $config->getEmailMessage($this->instance_id);
        $this->assign('email_message', $email_message);
        $mobile_message = $config->getMobileMessage($this->instance_id);
        $this->assign('mobile_message', $mobile_message);
        $this->assign('child_menu_list', $child_menu_list);
        $this->assign('type', $type);
        return view($this->style . 'Config/messageConfig');
    }

    /**
     * ajax 邮件接口
     */
    public function setEmailMessage()
    {
        $email_host = isset($_POST['email_host']) ? $_POST['email_host'] : '';
        $email_port = isset($_POST['email_port']) ? $_POST['email_port'] : '';
        $email_addr = isset($_POST['email_addr']) ? $_POST['email_addr'] : '';
        $email_id = isset($_POST['email_id']) ? $_POST['email_id'] : '';
        $email_pass = isset($_POST['email_pass']) ? $_POST['email_pass'] : '';
        $is_use = isset($_POST['is_use']) ? $_POST['is_use'] : '';
        $config = new WebConfig();
        $res = $config->setEmailMessage($this->instance_id, $email_host, $email_port, $email_addr, $email_id, $email_pass, $is_use);
        return AjaxReturn($res);
    }

    /**
     * ajax 短信接口
     *
     * @return unknown[]
     */
    public function setMobileMessage()
    {
        $app_key = isset($_POST['app_key']) ? $_POST['app_key'] : '';
        $secret_key = isset($_POST['secret_key']) ? $_POST['secret_key'] : '';
        $free_sign_name = isset($_POST['free_sign_name']) ? $_POST['free_sign_name'] : '';
        $is_use = isset($_POST['is_use']) ? $_POST['is_use'] : '';
        $config = new WebConfig();
        $res = $config->setMobileMessage($this->instance_id, $app_key, $secret_key, $free_sign_name, $is_use);
        return AjaxReturn($res);
    }

    /**
     * 邮件发送测试接口
     *
     * @return unknown[]
     */
    public function testSend()
    {
        $send = new Send();
        $toemail = $_POST['email_test'];
        $title = '测试邮箱发送';
        $content = '测试邮箱发送成功不成功？';
        $res = $send->email($toemail, $title, $content);
        return AjaxReturn($res);
    }

    /**
     * 帮助类型
     *
     * @return unknown
     */
    public function helpclass()
    {
        if (request()->isAjax()) {
            $index = isset($_POST["pageIndex"]) ? $_POST["pageIndex"] : 1;
            $platform = new Platform();
            $list = $platform->getPlatformHelpClassList(1, 10, [
                'type' => 1
            ], 'sort');
            return $list;
        }
        return view($this->style . "Config/helpClass");
    }

    /**
     * 修改帮助类型
     * 任鹏强
     * 2017年2月18日14:26:20
     */
    public function updateClass()
    {
        if (request()->isAjax()) {
            $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : '';
            $type = isset($_POST['type']) ? $_POST['type'] : 1;
            $class_name = isset($_POST['class_name']) ? $_POST['class_name'] : '';
            $parent_class_id = isset($_POST['parent_class_id']) ? $_POST['parent_class_id'] : 0;
            $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
            $platform = new Platform();
            $res = $platform->updatePlatformClass($class_id, $type, $class_name, $parent_class_id, $sort);
            return AjaxReturn($res);
        }
    }

    /**
     * 添加 帮助类型
     */
    public function addHelpClass()
    {
        if (request()->isAjax()) {
            $class_name = isset($_POST['class_name']) ? $_POST['class_name'] : '';
            $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
            $platform = new Platform();
            $res = $platform->addPlatformHelpClass(1, $class_name, 0, $sort);
            return AjaxReturn($res);
        }
        return view($this->style . 'Config/addHelpClass');
    }

    /**
     * 帮助内容
     *
     * @return multitype:number unknown |Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function helpDocument()
    {
        if (request()->isAjax()) {
            $page_index = isset($_POST["pageIndex"]) ? $_POST["pageIndex"] : 1;
            $platform = new Platform();
            $list = $platform->getPlatformHelpDocumentList($page_index, 10, '', 'sort');
            return $list;
        }
        return view($this->style . "Config/helpDocument");
    }

    /**
     * 修改内容
     */
    public function updateDocument()
    {
        $platform = new Platform();
        if (request()->isAjax()) {
            $uid = $this->user->getSessionUid();
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : '';
            $link_url = isset($_POST['link_url']) ? $_POST['link_url'] : '';
            $content = isset($_POST['content']) ? $_POST['content'] : '';
            $image = isset($_POST['image']) ? $_POST['image'] : '';
            $sort = isset($_POST['sort']) ? $_POST['sort'] : 0;
            $revle = $platform->updatePlatformDocument($id, $uid, $class_id, $title, $link_url, $sort, $content, $image);
            return AjaxReturn($revle);
        } else {
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $this->assign('id', $id);
            $document_detail = $platform->getPlatformDocumentDetail($id);
            $document_detail["content"] = htmlspecialchars($document_detail["content"]);
            $this->assign('document_detail', $document_detail);
            $help_class_list = $platform->getPlatformHelpClassList();
            $this->assign('help_class_list', $help_class_list['data']);
            return view($this->style . 'Config/updateDocument');
        }
    }

    /**
     * 添加内容
     */
    public function addDocument()
    {
        $platform = new Platform();
        if (request()->isAjax()) {
            $uid = $this->user->getSessionUid();
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : '';
            $link_url = isset($_POST['link_url']) ? $_POST['link_url'] : '';
            $content = isset($_POST['content']) ? $_POST['content'] : '';
            $image = isset($_POST['image']) ? $_POST['image'] : '';
            $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
            $result = $platform->addPlatformDocument($uid, $class_id, $title, $link_url, $sort, $content, $image);
            return AjaxReturn($result);
        } else {
            $help_class_list = $platform->getPlatformHelpClassList();
            $this->assign('help_class_list', $help_class_list['data']);
            return view($this->style . 'Config/addDocument');
        }
    }

    /**
     * 用户通知 设置
     *
     * @return \think\response\View
     */
    public function userNotice()
    {
        $web_config = new WebConfig();
        if (request()->isAjax()) {
            $user_notice = isset($_POST['user_notice']) ? $_POST['user_notice'] : '';
            $res = $web_config->setUserNotice($this->instance_id, $user_notice, 1);
            return AjaxReturn($res);
        }
        $user_notice = $web_config->getUserNotice($this->instance_id);
        $this->assign('user_notice', $user_notice);
        return view($this->style . 'Config/userNotice');
    }
    /**
     * 奖励管理
     */
    public function bonuses(){
        if(request()->isAjax()){
            $shop_id = $this->instance_id;
            $sign_point = isset($_POST['sign_point']) ? $_POST['sign_point'] : 0;
            $share_point = isset($_POST['share_point']) ? $_POST['share_point'] : 0;
            $reg_member_self_point = isset($_POST['reg_member_self_point']) ? $_POST['reg_member_self_point'] : 0;
            $reg_member_one_point = 0;
            $reg_member_two_point = 0;
            $reg_member_three_point = 0;
            $reg_promoter_self_point = 0;
            $reg_promoter_one_point = 0;
            $reg_promoter_two_point = 0;
            $reg_promoter_three_point = 0;
            $reg_partner_self_point = 0;
            $reg_partner_one_point = 0;
            $reg_partner_two_point = 0;
            $reg_partner_three_point = 0;
            $into_store_coupon = isset($_POST['into_store_coupon']) ? $_POST['into_store_coupon'] : 0;
            $share_coupon = isset($_POST['share_coupon']) ? $_POST['share_coupon'] : 0;
            $dataShop = new Shop();
            $res = $dataShop -> setRewardRule($shop_id, $sign_point, $share_point, $reg_member_self_point, $reg_member_one_point, $reg_member_two_point, $reg_member_three_point, $reg_promoter_self_point, $reg_promoter_one_point, $reg_promoter_two_point, $reg_promoter_three_point, $reg_partner_self_point, $reg_partner_one_point, $reg_partner_two_point, $reg_partner_three_point, $into_store_coupon, $share_coupon);
            return AjaxReturn($res);
        }
        $dataShop = new Shop();
        $res = $dataShop->getRewardRuleDetail($this->instance_id);
        $this->assign("res", $res);
        //查询未过期的优惠劵
        $coupon = new Promote();
        $condition['shop_id'] = $this->instance_id;
        $nowTime = date("Y-m-d H:i:s");
        $condition['end_time'] = array(">",$nowTime);
        $list = $coupon->getCouponTypeList(1, 0, $condition);
        $this->assign("coupon", $list['data']);
        return view($this->style . 'Config/bonuses');
    }
}