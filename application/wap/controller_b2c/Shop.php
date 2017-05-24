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
namespace app\wap\controller_b2c;

use data\service\niufenxiao\NfxUser;
use data\service\niushop\Goods as GoodsService;
use data\service\niushop\Member as MemberService;
use data\service\niushop\Shop as ShopService;
use data\service\system\Weixin;

/**
 * 店铺控制器
 *
 * @author Administrator
 *        
 */
class Shop extends BaseController
{

    /**
     * 店铺主页
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    
    /**
     * 店铺主页
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function index()
    {
        $is_sub = isset($_COOKIE["subscribe_" . $this->shop_id]) ? $_COOKIE["subscribe_" . $this->shop_id] : 0;
        $this->assign("is_subscribe", $is_sub);
        $shop = new ShopService();
        $shop_info = $shop->getShopInfo($this->shop_id);
        if (! empty($shop_info["shop_logo"])) {
            $shop_logo = $shop_info["shop_logo"];
            $shop_info["shop_logo"] = "__UPLOAD__/$shop_logo";
        }
        $member = new MemberService();
        $goods = new GoodsService();
        $source_user_name = "";
        if (! empty($_GET['source_uid'])) {
            $_SESSION['source_uid'] = isset($_GET['source_uid']) ? $_GET['source_uid'] : 0;
            $_SESSION['source_shop_id'] = isset($_GET['shop_id']) ? $_GET['shop_id'] : 0;
            $user_info = $member->getUserInfoByUid($_SESSION['source_uid']);
            if (! empty($user_info)) {
                $source_user_name = $user_info["nick_name"];
                if (! empty($user_info["user_headimg"])) {
                    $shop_info['shop_logo'] = $user_info["user_headimg"];
                }
                if (! empty($this->uid)) {
                    $nfx_user = new NfxUser();
                    $nfx_user->userAssociateShop($this->uid, $_SESSION['source_shop_id'], $_SESSION['source_uid']);
                }
            }
        }
        
        $shop_ad_list = $shop->getShopAdList(1, 0, [
            'type' => 1
        ]);
        $this->assign('source_user_name', $source_user_name);
        $this->assign('shop_ad_list', $shop_ad_list["data"]);
        if (null == $shop_info) {
            $this->redirect('index/index'); // 没有商品返回到首页
        }
        $this->assign("shop_info", $shop_info);
        
        // 是否收藏店铺
        $is_member_fav_shop = $member->getIsMemberFavorites($this->uid, $this->shop_id, 'shop');
        $this->assign("is_member_fav_shop", $is_member_fav_shop);
        // 新品推荐,推荐专区,热销专区
        $title_arr = [
            "新品推荐",
            "推荐专区",
            "热销专区"
        ];
        $conditions = array(
            [
                'ng.shop_id' => $this->shop_id,
                'is_new' => 1
            ],
            [
                'ng.shop_id' => $this->shop_id,
                'is_recommend' => 1
            ],
            [
                'ng.shop_id' => $this->shop_id,
                'is_hot' => 1
            ]
        );
        
        $goods_list = null;
        foreach ($conditions as $key => $item) {
            $temp_list = $goods->getGoodsList(1, 14, $item, 'sort');
            $goods_list["list"][$key] = $temp_list["data"];
            $goods_list["nav"][$key]["count"] = count($temp_list["data"]);
            $goods_list["nav"][$key]["title"] = $title_arr[$key];
        }
        $query_strint = empty($_SERVER['QUERY_STRING']) ? "" : "?" . $_SERVER['QUERY_STRING'];
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . $query_strint;
        $ticket = $this->getShareTicket();
        
        // 获取会员和店铺的关系
        $nfx_user = new NfxUser();
        $shop_member_association = $nfx_user->getShopMemberAssociation($this->uid, $this->shop_id);
        $is_shop_member = empty($shop_member_association) ? '0' : '1'; // 是否是店铺会员（关注）
        
        $this->assign('is_shop_member', $is_shop_member);
        $this->assign("signPackage", $ticket);
        $this->assign("goods_list", $goods_list);
        
        // 点击关注【微信公众号】
        $weixin = new Weixin();
        $onekey_subscribe = $weixin->getInstanceOneKeySubscribe($this->shop_id);
        $this->assign("onekey_subscribe", $onekey_subscribe);
        return view($this->style . '/Shop/index');
    }

    /**
     * 获取推荐类型商品列表
     */
    public function goodsList()
    {
        $shop_id = isset($_GET['shop_id']) ? $_GET['shop_id'] : 1;
        $type = isset($_GET['type']) ? $_GET['type'] : 0;
        $this->assign("search_title", '全部商品');
        $components = new Components();
        $goods_list = $components->getTypeGoodsList($shop_id, $type);
        $this->assign("goods_list", $goods_list);
        return view($this->style . '/Shop/goodsList');
    }

    /**
     * 关注店铺
     */
    public function userAssociateShop()
    {
        if (empty($this->uid)) {
            return - 1;
        } else {
            $nfx_user = new NfxUser();
            $shop_id = isset($_POST['shop_id']) ? $_POST['shop_id'] : '';
            $session_id = 0;
            if (! empty($_SESSION["source_shop_id"])) {
                if ($shop_id == $_SESSION["source_shop_id"]) {
                    $session_id = $_SESSION["source_uid"];
                }
            }
            $retval = $nfx_user->userAssociateShop($this->uid, $shop_id, $session_id);
            return AjaxReturn($retval);
        }
    }
}
