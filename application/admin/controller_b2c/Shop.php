<?php
/**
 * Shop.php
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

use data\service\niushop\Shop as ShopService;

/**
 * 店铺设置控制器
 *
 * @author Administrator
 *        
 */
class Shop extends BaseController
{

    /**
     * 店铺基础设置
     */
    public function shopConfig()
    {
        $child_menu_list = array(
            array(
                'url' => "Shop/shopConfig",
                'menu_name' => "店铺设置",
                "active" => 1
            ),
            array(
                'url' => "Shop/shopStyle",
                'menu_name' => "pc端主题",
                "active" => 0
            ),
            array(
                'url' => "Shop/shopWchatStyle",
                'menu_name' => "微信端主题",
                "active" => 0
            )
        );
        $shop = new ShopService();
        if (request()->isAjax()) {
            $shop_id = $this->instance_id;
            $shop_logo = isset($_POST['shop_logo']) ? $_POST['shop_logo'] : '';
            $shop_banner = isset($_POST['shop_banner']) ? $_POST['shop_banner'] : '';
            $shop_avatar = isset($_POST['shop_avatar']) ? $_POST['shop_avatar'] : '';
            $shop_qq = isset($_POST['shop_qq']) ? $_POST['shop_qq'] : '';
            $shop_ww = isset($_POST['shop_ww']) ? $_POST['shop_ww'] : '';
            $shop_phone = isset($_POST['shop_phone']) ? $_POST['shop_phone'] : '';
            $shop_keywords = isset($_POST['shop_keywords']) ? $_POST['shop_keywords'] : '';
            $shop_description = isset($_POST['shop_description']) ? $_POST['shop_description'] : '';
            $res = $shop->updateShopConfigByshop($shop_id, $shop_logo, $shop_banner, $shop_avatar, $shop_qq, $shop_ww, $shop_phone, $shop_keywords, $shop_description);
            return AjaxReturn($res);
        }
        $shop_info = $shop->getShopDetail($this->instance_id);
        $this->assign('shop_info', $shop_info);
        $this->assign('child_menu_list', $child_menu_list);
        return view($this->style . "Shop/shopConfig");
    }

    /**
     * 店铺幻灯设置
     */
    public function shopAd()
    {
        $child_menu_list = array(
            array(
                'url' => "Shop/shopConfig",
                'menu_name' => "店铺设置",
                "active" => 0
            ),
            array(
                'url' => "Shop/shopAd",
                'menu_name' => "幻灯设置",
                "active" => 1
            ),
            array(
                'url' => "Shop/shopStyle",
                'menu_name' => "pc端主题",
                "active" => 0
            ),
            array(
                'url' => "Shop/shopWchatStyle",
                'menu_name' => "微信端主题",
                "active" => 0
            )
        );
        
        $this->assign('child_menu_list', $child_menu_list);
        return view($this->style . "Shop/shopAd");
    }

    /**
     * 店铺主题
     */
    public function shopStyle()
    {
        $child_menu_list = array(
            array(
                'url' => "Shop/shopConfig",
                'menu_name' => "店铺设置",
                "active" => 0
            ),
            array(
                'url' => "Shop/shopStyle",
                'menu_name' => "pc端主题",
                "active" => 1
            ),
            array(
                'url' => "Shop/shopWchatStyle",
                'menu_name' => "微信端主题",
                "active" => 0
            )
        );
        
        $this->assign('child_menu_list', $child_menu_list);
        return view($this->style . "Shop/shopStyle");
    }

    /**
     * 微信端样式
     */
    public function shopWchatStyle()
    {
        $child_menu_list = array(
            array(
                'url' => "Shop/shopConfig",
                'menu_name' => "店铺设置",
                "active" => 0
            ),
            array(
                'url' => "Shop/shopStyle",
                'menu_name' => "pc端主题",
                "active" => 0
            ),
            array(
                'url' => "Shop/shopWchatStyle",
                'menu_name' => "微信端主题",
                "active" => 1
            )
        );
        $this->assign('child_menu_list', $child_menu_list);
        return view($this->style . "Shop/shopWchatStyle");
    }
}
