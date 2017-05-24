<?php
/**
 * Index.php
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
namespace app\wap\controller_b2c;

use data\service\niushop\Goods;
use data\service\niushop\GoodsBrand as GoodsBrand;
use data\service\niushop\GoodsCategory;
use data\service\niushop\Member as MemberService;
use data\service\niushop\Platform;
use data\service\niushop\Shop;
use data\service\system\Config;
use data\service\system\Weixin;
use data\service\system\WebSite;
use data\service\niushop\promotion\PromoteRewardRule;

class Index extends BaseController
{

    /**
     * 平台端首页
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function index()
    {
        // 分享
        $ticket = $this->getShareTicket();
        $this->assign("signPackage", $ticket);
        $platform = new Platform();
        // 轮播图
        $plat_adv_list = $platform->getPlatformAdvPositionDetail(1105);
        $this->assign('plat_adv_list', $plat_adv_list);
        
        // 促销模块
        $class_list = $platform->getPlatformGoodsRecommendClass();
        $this->assign("class_list", $class_list);
        // 品牌
        $goods_brand = new GoodsBrand();
        $list = $goods_brand->getGoodsBrandList(1, 6, '', 'sort');
        $this->assign('list', $list['data']);
        
        // 限时折扣
        $goods = new Goods();
        $condition['status'] = 1;
        $discount_list = $goods->getDiscountGoodsList(1, 4, $condition, 'end_time');
        foreach ($discount_list['data'] as $k => $v) {
            $v['discount'] = str_replace('.00', '', $v['discount']);
            $v['promotion_price'] = str_replace('.00', '', $v['promotion_price']);
            $v['price'] = str_replace('.00', '', $v['price']);
        }
        $this->assign('discount_list', $discount_list['data']);
        
        // 首页限时折扣广告位
        $discount_adv = $platform->getPlatformAdvPositionDetail(1106);
        $this->assign('discount_adv', $discount_adv);
        
        // 首页商城热卖
        $hot_selling_adv = $platform->getPlatformAdvPositionDetail(1164);
        $this->assign('hot_selling_adv', $hot_selling_adv);
        
        // 公众号配置查询
        $config = new Config();
        $wchat_config = $config->getInstanceWchatConfig($this->instance_id);
        
        $is_subscribe = 0; // 标识：是否显示顶部关注 0：[隐藏]，1：[显示]
                           // 检查是否配置过微信公众号
        if (! empty($wchat_config['oauth_value'])) {
            if (! empty($wchat_config['oauth_value']['appid']) && ! empty($wchat_config['oauth_value']['appsecret'])) {
                // 如何判断是否关注
                if (isWeixin()) {
                    if (! empty($this->uid)) {
                        // 检查当前用户是否关注
                        $user_sub = $this->user->checkUserIsSubscribeInstance($this->uid, $this->instance_id);
                        if ($user_sub == 0) {
                            // 未关注
                            $is_subscribe = 1;
                        }
                    }
                }
            }
        }
        $this->assign("is_subscribe", $is_subscribe);
        // 公众号二维码获取
        $this->web_site = new WebSite();
        $web_info = $this->web_site->getWebSiteInfo();
        // var_dump($web_info);die;
        $this->assign('web_info', $web_info);
        
        $member = new MemberService();
        $source_user_name = "";
        $source_img_url = "";
        if (! empty($_GET['source_uid'])) {
            $_SESSION['source_uid'] = $_GET['source_uid'];
            $user_info = $member->getUserInfoByUid($_SESSION['source_uid']);
            if (! empty($user_info)) {
                $source_user_name = $user_info["nick_name"];
                if (! empty($user_info["user_headimg"])) {
                    $source_img_url = $user_info["user_headimg"];
                }
            }
        }
        $notice_arr = [
            "Niushop开源商城，震撼发布！",
            "Niushop开源商城，震撼发布！",
            "Niushop开源商城，震撼发布！",
            "Niushop开源商城，震撼发布！",
            "Niushop开源商城，震撼发布！"
        ];
        $this->assign('notice_arr', $notice_arr);
        $this->assign('source_user_name', $source_user_name);
        $this->assign('source_img_url', $source_img_url);
        
        return view($this->style . 'Index/index');
    }

    /**
     * 店铺街
     */
    public function shopStreet()
    {
        $shop = new Shop();
        $shop_name = isset($_GET['shop_name']) ? $_GET['shop_name'] : ''; // 店铺名称
        $shop_group_id = isset($_GET['shop_group_id']) ? $_GET['shop_group_id'] : ''; // 店铺分类
        $shop_group_name = isset($_GET['shop_group_name']) ? $_GET['shop_group_name'] : ''; // 店铺名称
        $order_type = isset($_GET['order_type']) ? $_GET['order_type'] : ''; // 排序类型 为1销售排行2信誉排行
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'asc'; // 倒排正排
        $order = "shop_sort " . $sort;
        if ($order_type == 1) {
            $order = "shop_sales " . $sort;
        } else 
            if ($order_type == 2) {
                $order = "shop_credit " . $sort;
            }
        
        $condition['shop_state'] = 1;
        if (! empty($shop_group_id)) {
            $condition['shop_group_id'] = $shop_group_id;
        }
        
        if (! empty($shop_name)) {
            $condition['shop_name'] = array(
                "like",
                "%" . $shop_name . "%"
            );
        }
        
        $shop_list = $shop->getShopList(1, 0, $condition, $order); // 店铺查询
        $shop_group_list = $shop->getShopGroup(); // 店铺分类
        $assign_get_list = array(
            'order_type' => $order_type, // 排序类型
            'shop_group_id' => $shop_group_id, // 店铺类型
            'shop_name' => $shop_name, // 搜索名称
            'sort' => $sort, // 排序
            'shop_list' => $shop_list['data'], // 店铺列表
            'total_count' => $shop_list['total_count'], // 总条数
            'shop_group_list' => $shop_group_list['data']
        ); // 店铺分页
        
        foreach ($assign_get_list as $key => $value) {
            $this->assign($key, $value);
        }
        
        $this->assign('shop_group_name', $shop_group_name);
        return view($this->style . 'Index/shopStreet');
    }

    /**
     * 获取平台不同推荐模块商品
     */
    public function getPlatformRecommendGoodsList()
    {}

    /**
     * 限时折扣
     */
    public function discount()
    {
        $platform = new Platform();
        // 限时折扣广告位
        $discounts_adv = $platform->getPlatformAdvPositionDetail(1163);
        $this->assign('discounts_adv', $discounts_adv);
        if (request()->isAjax()) {
            $goods = new Goods();
            $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '0';
            $condition['status'] = 1;
            if (! empty($category_id)) {
                $condition['category_id_1'] = $category_id;
            }
            $discount_list = $goods->getDiscountGoodsList(1, 0, $condition);
            foreach ($discount_list['data'] as $k => $v) {
                $v['discount'] = str_replace('.00', '', $v['discount']);
                $v['promotion_price'] = str_replace('.00', '', $v['promotion_price']);
                $v['price'] = str_replace('.00', '', $v['price']);
            }
            return $discount_list['data'];
        } else {
            $goods_category = new GoodsCategory();
            $goods_category_list_1 = $goods_category->getGoodsCategoryList(1, 0, [
                "is_visible" => 1,
                "level" => 1
            ]);
            
            $this->assign('goods_category_list_1', $goods_category_list_1['data']);
            
            return view($this->style . 'Index/discount');
        }
    }
    
    // 分享送积分
    public function shareGivePoint()
    {
        if (request()->isAjax()) {
            $rewardRule = new PromoteRewardRule();
            $res = $rewardRule->memberShareSendPoint($this->instance_id, $this->uid);
            return AjaxReturn($res);
        }
    }
}
