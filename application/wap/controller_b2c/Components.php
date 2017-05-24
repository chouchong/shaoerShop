<?php
/**
 * Components.php
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

use data\service\niushop\Goods as GoodsService;
use data\service\niushop\GoodsGroup;
use data\service\niushop\Member as MemberService;

/**
 * 组件控制器
 *
 * @author Administrator
 *        
 */
class Components extends BaseController
{

    /**
     * 获取商品列表
     */
    public function goodsList()
    {
        $goods = new GoodsService();
        $goods_list = $goods->getGoodsList(1, 0, [
            'state' => 1
        ]);
        return $goods_list['data'];
    }

    /**
     * 获取商品分组列表
     */
    public function goodsGroupList($shop_id)
    {
        $goods_group = new GoodsGroup();
        // $shop_id = isset($_POST['shop_id']) ? $_POST['shop_id'] : 1;
        $retval = $goods_group->getGoodsGroupList(1, 0, [
            'shop_id' => $shop_id
        ], 'sort');
        return $retval['data'];
    }

    /**
     * 收藏商品或者店铺
     */
    public function collectionGoodsOrShop()
    {
        $fav_id = isset($_POST["fav_id"]) ? $_POST["fav_id"] : '';
        $fav_type = isset($_POST["fav_type"]) ? $_POST["fav_type"] : '';
        $log_msg = isset($_POST["log_msg"]) ? $_POST["log_msg"] : '';
        $member = new MemberService();
        $result = $member->addMemberFavouites($fav_id, $fav_type, $log_msg);
        return AjaxReturn($result);
    }

    /**
     * 取消收藏 商品/店铺
     */
    public function cancelCollGoodsOrShop()
    {
        $fav_id = isset($_POST["fav_id"]) ? $_POST["fav_id"] : '';
        $fav_type = isset($_POST["fav_type"]) ? $_POST["fav_type"] : '';
        $member = new MemberService();
        $result = $member->deleteMemberFavorites($fav_id, $fav_type);
        return AjaxReturn($result);
    }

    /**
     * 通过good_groupi获取该分类下的商品
     */
    public function getGroupGoodsList()
    {
        $goods_group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
        $goods = new GoodsService();
        $good_list = $goods->getGroupGoodsList($goods_group_id);
        return $good_list;
    }

    /**
     * 获取店铺不同推荐类型的商品
     */
    public function getTypeGoodsList($shop_id, $type, $number = 4)
    {
        $goods = new GoodsService();
        switch ($type) {
            case 1:
                $condition = [
                    'ng.is_new' => 1,
                    'ng.shop_id' => $shop_id
                ];
                break;
            case 2:
                $condition = [
                    'ng.is_hot' => 1,
                    'ng.shop_id' => $shop_id
                ];
                break;
            case 3:
                $condition = [
                    'ng.is_recommend' => 1,
                    'ng.shop_id' => $shop_id
                ];
                break;
            default:
                $condition = [
                    'ng.shop_id' => $shop_id
                ];
                break;
        }
        
        $good_list = $goods->getGoodsList(1, $number, $condition, $order = 'ng.create_time desc');
        return $good_list['data'];
    }

/**
 * 获取平台不同推荐类型的商品
 */
    // public function getPlatformTypeGoodsList()
    // {
    // $type = isset($_POST['type']) ? $_POST['type'] : 1;
    // $number = isset($_POST['number']) ? $_POST['number'] : 4;
    // $goods = new GoodsService();
    // switch ($type) {
    // case 1:
    // $condition = [
    // 'ng.is_new' => 1,
    // 'ng.shop_id' => $shop_id
    // ];
    // break;
    // case 2:
    // $condition = [
    // 'ng.is_hot' => 1,
    // 'ng.shop_id' => $shop_id
    // ];
    // break;
    // case 3:
    // $condition = [
    // 'ng.is_recommend' => 1,
    // 'ng.shop_id' => $shop_id
    // ];
    // break;
    // default:
    // break;
    // }
    
    // $good_list = $goods->getGoodsList(1, $number, $condition, $order = 'ng.create_time desc');
    // return $good_list['data'];
    // }
}
