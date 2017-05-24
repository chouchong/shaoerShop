<?php
/**
 * BaseController.php
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

\think\Loader::addNamespace('data', 'data/');
use data\service\niushop\GoodsCategory;
use data\service\niushop\Member as Member;
use data\service\niushop\Platform;
use data\service\niushop\Shop as ShopService;
use data\service\system\Config;
use data\service\system\WebSite as WebSite;
use think\Controller;

class BaseController extends Controller
{

    public $user;

    protected $uid;

    protected $instance_id;

    protected $is_member;

    protected $shop_name;

    protected $user_name;

    public $web_site;

    public $style;
    // 验证码配置
    public $login_verify_code;

    public function __construct()
    {
        if (request()->isMobile()) {
            $this->redirect("wap/Index/index");
        } else {
//             getShopCache();//开启缓存
            parent::__construct();
            $this->init();
            $get_array = request()->get();
        }
    }

    /**
     * 功能说明：action基类
     */
    public function init()
    {
        $this->user = new Member();
        $this->web_site = new WebSite();
        $web_info = $this->web_site->getWebSiteInfo();
        $this->uid = $this->user->getSessionUid();
        $this->instance_id = $this->user->getSessionInstanceId();
        $this->shop_name = $this->user->getInstanceName();
        $this->assign("uid", $this->uid);
        $this->assign("title", $web_info['title']);
        $this->assign("web_info", $web_info);
        $this->style = 'shop/' . NS_TEMPLATE.'/';
        
        // 是否开启验证码
        $web_config = new Config();
        $this->login_verify_code = $web_config->getLoginVerifyCodeConfig($this->instance_id);
        $this->assign("login_verify_code", $this->login_verify_code["oauth_value"]);
        $qq_info = $web_config->getQQConfig($this->instance_id);
        $Wchat_info = $web_config->getWchatConfig($this->instance_id);
        $this->assign("qq_info", $qq_info);
        $this->assign("Wchat_info", $Wchat_info);
        if (! request()->isAjax()) {
            $keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
            $this->assign("keyword", $keyword);
            /* 商品分类查询 */
            $goodsCategory = new GoodsCategory();
            $goods_category_one = $goodsCategory->getGoodsCategoryList('', '', [
                'level' => 1
            ], 'sort');
            $this->assign('goods_category_one', $goods_category_one['data']); // 商品分类一级
            
            $goodsCategory = new GoodsCategory();
            $goods_category_two = $goodsCategory->getGoodsCategoryList('', '', [
                'level' => 2
            ], 'sort');
            $this->assign('goods_category_two', $goods_category_two['data']); // 商品分类二级
            
            $goodsCategory = new GoodsCategory();
            $goods_category_three = $goodsCategory->getGoodsCategoryList('', '', [
                'level' => 3
            ], 'sort');
            $this->assign('goods_category_three', $goods_category_three['data']); // 商品分类三级
            
            $this->getCms(); // 底部文章分类列表
            $this->assign("style", 'shop/' . NS_TEMPLATE);
            $this->assign("platform_shopname", $this->shop_name);
            
            // 导航
            $nav = new ShopService();
            $navigation_list = $nav->ShopNavigationList(1, 0, [
                'type' => 1
            ], 'sort');
            $this->assign("navigation_list", $navigation_list["data"]);
            $this->getHotkeys(); // 热搜关键词
            
            $this->getPageUrl(); // 分页url拼接
            
            $this->assign('page_num', 5); // 分页显示的页码个数 注：误删不然所有分页都报错必须为奇数
            
            $this->assign('is_head_goods_nav', 0); // 商品分类是否显示样式
        }
    }

    public function _empty($name)
    {}

    /**
     * 获取导航
     */
    public function getNavigation()
    {
        $nav = new ShopService();
        $list = $nav->ShopNavigationList(1, 0, '', 'sort');
        return $list;
    }

    /**
     * 拼接共用的分页中的url
     */
    public function getPageUrl()
    {
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : ""; // 地址
        $path_info = substr($path_info, 6, strlen($path_info));
        $get_array = request()->get();
        $query_string = '';
        if(array_key_exists('page', $get_array))
        {
            $tag = '&';
        }else{
            if(!empty($get_array))
            {
                $tag = '&';
            }else
            $tag = '?';
        }
        foreach ($get_array as $k => $v)
        {
            if ($k != 'page') {
                $query_string .= $tag.$k.'='.$v;
            }
        }
        $this->assign('path_info', $path_info);
        $this->assign('query_string', $query_string);
    }

    /**
     * 底部信息
     */
    public function getCms()
    {
        $platform = new Platform();
        $platform_help_class = $platform->getPlatformHelpClassList(1, 5, '', 'sort');
        $this->assign('platform_help_class', $platform_help_class['data']); // 帮助中心分类列表
        
        $platform_help_Document = $platform->getPlatformHelpDocumentList(1, 0, '', 'sort');
        $this->assign('platform_help_document', $platform_help_Document['data']); // 帮助中心列表
    }

    /**
     * 热搜关键词
     */
    public function getHotkeys()
    {
        $config = new Config();
        $hot_keys = $config->getHotsearchConfig($this->instance_id);
        $this->assign("hot_keys", $hot_keys);
        $default_keywords = $config->getDefaultSearchConfig($this->instance_id);
        $this->assign('default_keywords', $default_keywords);
    }
}
