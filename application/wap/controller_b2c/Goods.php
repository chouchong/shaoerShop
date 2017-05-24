<?php
/**
 * Goods.php
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
use data\service\niushop\GoodsBrand as GoodsBrand;
use data\service\niushop\GoodsCategory;
use data\service\niushop\GoodsGroup;
use data\service\niushop\Order as OrderService;
use data\service\niushop\Platform;
use data\service\niushop\promotion\GoodsExpress;
use data\service\system\Address;

/**
 * 商品相关
 *
 * @author Administrator
 *        
 */
class Goods extends BaseController
{

    /**
     * 商品详情
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function goodsDetail()
    {
        $goods_id = isset($_GET['id']) ? $_GET['id'] : 0;
        if ($goods_id == 0) {
            $this->error("没有获取到商品信息");
        }
        $goods = new GoodsService();
        $goods_detail = $goods->getGoodsDetail($goods_id);
        
        $user_location = get_city_by_ip();
        $this->assign("user_location", get_city_by_ip()); // 获取用户位置信息
        if ($user_location['status'] == 1) {
            // 定位成功，查询当前城市的运费
            $goods_express = new GoodsExpress();
            $address = new Address();
            $province = $address->getProvinceId($user_location["province"]);
            $city = $address->getCityId($user_location["city"]);
            $express = $goods_express->getGoodsExpressTemplate($goods_id, $province['province_id'], $city['city_id']);
            $goods_info["shipping_fee_name"] = $express;
        }
        
        $this->assign("goods_detail", $goods_detail);
        $this->assign("shopname", $this->shop_name);
        $this->assign("price", intval($goods_detail["promotion_price"]));
        $this->assign("goods_id", $goods_id);
        $this->getCartInfo($goods_id);
        // 分享
        $ticket = $this->getShareTicket();
        $this->assign("signPackage", $ticket);
        // 评价数量
        $evaluates_count = $goods->getGoodsEvaluateCount($goods_id);
        $this->assign('evaluates_count', $evaluates_count);
        return view($this->style . 'Goods/goodsDetail');
    }

    /**
     * 功能：商品评论
     * 创建人：李志伟
     * 创建时间：2017年2月23日11:12:57
     */
    public function getGoodsComments()
    {
        $comments_type = $_POST['comments_type'];
        $order = new OrderService();
        $condition['goods_id'] = $_POST["goods_id"];
        switch ($comments_type) {
            case 1:
                $condition['explain_type'] = 1;
                break;
            case 2:
                $condition['explain_type'] = 2;
                break;
            case 3:
                $condition['explain_type'] = 3;
                break;
            case 4:
                $condition['image|again_image'] = array(
                    'NEQ',
                    ''
                );
                break;
        }
        
        $goodsEvaluationList = $order->getOrderEvaluateDataList(1, 15, $condition, 'addtime desc');
        return $goodsEvaluationList;
    }

    /**
     * 返回商品数量和当前商品的限购
     *
     * @param unknown $goods_id            
     */
    public function getCartInfo($goods_id)
    {
        $goods = new GoodsService();
        $cartlist = $goods->getCart($this->uid);
        $num = 0;
        foreach ($cartlist as $v) {
            if ($v["goods_id"] == $goods_id) {
                $num = $v["num"];
            }
        }
        $this->assign("carcount", count($cartlist)); // 购物车商品数量
        $this->assign("num", $num); // 购物车已购买商品数量
    }

    /**
     * 购物车页面
     */
    public function cart()
    {
        $this->is_member = $this->user->getSessionUserIsMember();
        if ($this->is_member == 0) {
            $this->redirect("login/index");
        }
        $this->assign("shopname", $this->shop_name);
        $goods = new GoodsService();
        
        $cartlist = $goods->getCart($this->uid, $this->instance_id);
        // 店铺，店铺中的商品
        $list = Array();
        for ($i = 0; $i < count($cartlist); $i ++) {
            // $cartlist[$i]["goods_name"] = mb_substr($cartlist[$i]["goods_name"], 0,20,"utf-8");
            // $cartlist[$i]["sku_name"] = mb_substr($cartlist[$i]["goods_name"], 0,20,"utf-8");
            $list[$cartlist[$i]["shop_id"] . ',' . $cartlist[$i]["shop_name"]][] = $cartlist[$i];
        }
        $this->assign("list", $list);
        $this->assign("countlist", count($cartlist));
        return view($this->style . '/Goods/cart');
    }

    /**
     * 添加购物车
     * 创建人：李广
     */
    public function addCart()
    {
        $cart_detail = $_POST['cart_detail'];
        $cart_tag = $_POST['cart_tag'];
        $uid = $this->uid;
        $shop_id = $cart_detail["shop_id"];
        $shop_name = $cart_detail["shop_name"];
        $goods_id = $cart_detail['trueId'];
        $goods_name = $cart_detail['goods_name'];
        $num = $cart_detail['count'];
        $sku_id = $cart_detail['select_skuid'];
        $sku_name = $cart_detail['select_skuName'];
        $price = $cart_detail['price'];
        $cost_price = $cart_detail['cost_price'];
        $picture = $cart_detail['picture'];
        $this->is_member = $this->user->getSessionUserIsMember();
        if (! empty($this->uid) && $this->is_member == 1) {
            /* if($cart_tag == "addCart") { */
            $goods = new GoodsService();
            $retval = $goods->addCart($uid, $shop_id, $shop_name, $goods_id, $goods_name, $sku_id, $sku_name, $price, $num, $picture, 0);
            
            /*
             * }else{
             * $retval = 0;
             * }
             */
        } else {
            $retval = "-1";
        }
        return $retval;
    }

    /**
     * 购物车修改数量
     */
    public function cartAdjustNum()
    {
        if (request()->isAjax()) {
            $cart_id = $_POST['cartid'];
            $num = $_POST['num'];
            $goods = new GoodsService();
            $retval = $goods->cartAdjustNum($cart_id, $num);
            return AjaxReturn($retval);
        } else
            return AjaxReturn(- 1);
    }

    /**
     * 购物车项目删除
     */
    public function cartDelete()
    {
        if (request()->isAjax()) {
            $cart_id_array = $_POST['del_id'];
            $goods = new GoodsService();
            $retval = $goods->cartDelete($cart_id_array);
            return AjaxReturn($retval);
        } else
            return AjaxReturn(- 1);
    }

    /**
     * 平台商品分类列表
     */
    public function goodsClassificationList()
    {
        $uid = $this->uid;
        $goods_category = new GoodsCategory();
        $goods_category_list_1 = $goods_category->getGoodsCategoryList(1, 0, [
            "is_visible" => 1,
            "level" => 1
        ]);
        
        $goods_category_list_2 = $goods_category->getGoodsCategoryList(1, 0, [
            "is_visible" => 1,
            "level" => 2
        ]);
        $goods_category_list_3 = $goods_category->getGoodsCategoryList(1, 0, [
            "is_visible" => 1,
            "level" => 3
        ]);
        
        $this->assign("goods_category_list_1", $goods_category_list_1["data"]);
        $this->assign("goods_category_list_2", $goods_category_list_2["data"]);
        $this->assign("goods_category_list_3", $goods_category_list_3["data"]);
        return view($this->style . 'Goods/goodsClassificationList');
    }

    /**
     * 店铺商品分组列表
     */
    public function goodsGroupList()
    {
        // 查询购物车中商品的数量
        $uid = $this->uid;
        $goods = new GoodsService();
        $cartlist = $goods->getCart($uid);
        $this->assign('uid', $uid);
        $this->assign("carcount", count($cartlist));
        
        $components = new Components();
        $grouplist = $components->goodsGroupList($this->shop_id);
        $group_frist_list = null;
        $group_second_list = null;
        foreach ($grouplist as $group) {
            if ($group["pid"] == 0) {
                $group_frist_list[] = $group;
            } else {
                $group_second_list[] = $group;
            }
        }
        $this->assign("group_frist_list", $group_frist_list);
        $this->assign("group_second_list", $group_second_list);
        
        $group_goods = new GoodsGroup();
        $tree_list = $group_goods->getGroupGoodsTree($this->shop_id);
        $this->assign("tree_list", $tree_list);
        return view($this->style . 'Goods/goodsGroupList');
    }

    /**
     * 商品分类列表
     */
    public function goodsCategoryList()
    {
        $goodscate = new GoodsCategory();
        $one_list = $goodscate->getGoodsCategoryListByParentId(0);
        if (! empty($one_list)) {
            foreach ($one_list as $k => $v) {
                $two_list = array();
                $two_list = $goodscate->getGoodsCategoryListByParentId($v['category_id']);
                $v['child_list'] = $two_list;
                if (! empty($two_list)) {
                    foreach ($two_list as $k1 => $v1) {
                        $three_list = array();
                        $three_list = $goodscate->getGoodsCategoryListByParentId($v1['category_id']);
                        $v1['child_list'] = $three_list;
                    }
                }
            }
        }
        return $one_list;
    }

    /**
     * 加入购物车前显示商品规格
     */
    public function joinCartInfo()
    {
        $goods = new GoodsService();
        $goods_id = isset($_POST['goods_id']) ? $_POST['goods_id'] : '';
        $goods_detail = $goods->getGoodsDetail($goods_id);
        $this->assign("goods_detail", $goods_detail);
        return view($this->style . 'joinCart');
    }

    /**
     * 商品搜索页面
     *
     * @return \think\response\View
     */
    public function goodsSearch()
    {
        $goods = new GoodsService();
        $recommmend_good_list = $goods->getGoodsList(1, 10, [
            'is_recommend' => 1
        ], $order = 'create_time desc');
        $this->assign("recommmend_list", $recommmend_good_list['data']);
        return view($this->style . 'Goods/goodsSearch');
    }

    /**
     * 搜索商品显示
     */
    public function goodsSearchList()
    {
        if (request()->isAjax()) {
            $sear_name = isset($_POST['sear_name']) ? $_POST['sear_name'] : '';
            $sear_type = isset($_POST['sear_type']) ? $_POST['sear_type'] : '';
            $order_state = isset($_POST['order_state']) ? $_POST['order_state'] : 'desc';
            $controlType = isset($_POST['controlType']) ? $_POST['controlType'] : '';
            $shop_id = isset($_POST['shop_id']) ? $_POST['shop_id'] : '';
            $goods = new GoodsService();
            $condition['goods_name'] = [
                'like',
                '%' . $sear_name . '%'
            ];
            // 排序类型
            switch ($sear_type) {
                case 1:
                    $order = 'create_time desc'; // 时间
                    break;
                case 2:
                    $order = 'sales desc'; // 销售
                    break;
                case 3:
                    $order = 'promotion_price ' . $order_state; // 促销价格
                    break;
                default:
                    $order = '';
                    break;
            }
            switch ($controlType) {
                case 1:
                    $condition = [
                        'is_new' => 1
                    ];
                    break;
                case 2:
                    $condition = [
                        'is_hot' => 1
                    ];
                    break;
                case 3:
                    $condition = [
                        'is_recommend' => 1
                    ];
                    break;
                default:
                    break;
            }
            if (! empty($shop_id)) {
                $condition['ng.shop_id'] = $shop_id;
            }
            
            $search_good_list = $goods->getGoodsList(1, 0, $condition, $order);
            return $search_good_list['data'];
        } else {
            $sear_name = isset($_GET['sear_name']) ? $_GET['sear_name'] : '';
            $controlType = isset($_GET['controlType']) ? $_GET['controlType'] : ''; // 什么类型 1最新 2精品 3推荐
            $controlTypeName = isset($_GET['controlTypeName']) ? $_GET['controlTypeName'] : ''; // 什么类型 1最新 2精品 3推荐
            
            if (! empty($sear_name)) {
                $search_title = $sear_name;
            } else {
                $search_title = $controlTypeName;
            }
            $shop_id = $this->shop_id;
            $this->assign('controlType', $controlType);
            $this->assign('wherename', 'sear_name');
            $this->assign('sear_name', $sear_name);
            $this->assign('shop_id', $shop_id);
            $this->assign('search_title', $search_title);
            return view($this->style . 'Goods/goodsSearchList');
        }
    }

    /**
     * 品牌专区
     */
    public function brandlist()
    {
        $platform = new Platform();
        // 品牌专区广告位
        $brand_adv = $platform->getPlatformAdvPositionDetail(1162);
        $this->assign('brand_adv', $brand_adv);
        
        if (request()->isAjax()) {
            $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '0';
            
            if (! empty($category_id)) {
                $condition['category_id_1'] = $category_id;
            }
            $goods_brand = new GoodsBrand();
            $list = $goods_brand->getGoodsBrandList(1, '', $condition, 'sort');
            return $list['data'];
        } else {
            $goods_category = new GoodsCategory();
            $goods_category_list_1 = $goods_category->getGoodsCategoryList(1, 0, [
                "is_visible" => 1,
                "level" => 1
            ]);
            $this->assign("goods_category_list_1", $goods_category_list_1["data"]);
            
            return view($this->style . 'Goods/brandlist');
        }
    }

    /**
     * 商品列表
     */
    public function goodsList()
    {
        // 查询购物车中商品的数量
        $uid = $this->uid;
        $goods = new GoodsService();
        $cartlist = $goods->getCart($uid);
        $this->assign('uid', $uid);
        $this->assign("carcount", count($cartlist));
        
        if (request()->isAjax()) {
            $category_id = isset($_POST["category_id"]) ? $_POST["category_id"] : ""; // 商品分类
            $brand_id = isset($_POST["brand_id"]) ? $_POST["brand_id"] : ""; // 品牌
            $order = isset($_POST["order"]) ? $_POST["order"] : ""; // 商品排序分类
            $sort = isset($_POST["sort"]) ? $_POST["sort"] : "desc"; // 商品排序分类
            
            switch ($order) {
                case 1: // 销量
                    $order = 'sales ';
                    break;
                case 2: // 新品
                    $order = 'is_new ';
                    break;
                case 3: // 价钱
                    $order = 'promotion_price ';
                    break;
                default:
                    $order = 'sale_date ';
                    break;
            }
            
            $condition = "";
            if (! empty($category_id)) {
                $condition["ng.category_id"] = $category_id;
            } else 
                if (! empty($brand_id)) {
                    $condition["ng.brand_id"] = array(
                        "in",
                        $brand_id
                    );
                }
            $goods = new GoodsService();
            $goods_list = $goods->getGoodsList(1, 0, $condition, $order . $sort);
            return $goods_list;
        } else {
            $category_id = isset($_GET["category_id"]) ? $_GET["category_id"] : ""; // 商品分类
            $brand_id = isset($_GET["brand_id"]) ? $_GET["brand_id"] : ""; // 品牌
            $this->assign('brand_id', $brand_id);
            $this->assign('category_id', $category_id);
            return view($this->style . 'Goods/goodsList');
        }
    }

    /**
     * 积分中心
     *
     * @return \think\response\View
     */
    public function integralCenter()
    {
        $platform = new Platform();
        // 积分中心广告位
        $discount_adv = $platform->getPlatformAdvPositionDetail(1165);
        $this->assign('discount_adv', $discount_adv);
        // 积分中心商品
        $this->goods = new GoodsService();
        $order = "";
        // 排序
        if (isset($_GET["id"])) {
            if ($_GET["id"] == 1) {
                $order = "sales desc";
            } else 
                if ($_GET["id"] == 2) {
                    $order = "collects desc";
                } else 
                    if ($_GET["id"] == 3) {
                        $order = "evaluates desc";
                    } else 
                        if ($_GET["id"] == 4) {
                            $order = "shares desc";
                        } else {
                            $_GET["id"] = 0;
                            $order = "";
                        }
        } else {
            $_GET["id"] = 0;
        }
        
        $page_index = isset($_GET['page']) ? $_GET['page'] : '1';
        $condition = array(
            "ng.state" => 1,
            "ng.point_exchange_type" => array(
                'NEQ',
                0
            )
        );
        $page_count = 25;
        $hotGoods = $this->goods->getGoodsList(1, 4, $condition, $order);
        $allGoods = $this->goods->getGoodsList($page_index, $page_count, $condition, $order);
        if (isset($_GET["page"])) {
            if (($_GET["page"] > 1 && $_GET["page"] <= $allGoods["page_count"])) {
                $_GET["page"] = 1;
            }
        }
        $this->assign("id", $_GET["id"]);
        $this->assign('page', $page_index);
        $this->assign("allGoods", $allGoods);
        $this->assign("hotGoods", $hotGoods);
        $this->assign('page_count', $allGoods['page_count']);
        $this->assign('total_count', $allGoods['total_count']);
        return view($this->style . 'Goods/integralCenter');
    }

    /**
     * 积分中心 全部积分商品
     *
     * @return \think\response\View
     */
    public function integralCenterList()
    {
        return view($this->style . 'Goods/integralCenterList');
    }

    /**
     * 积分中心全部商品Ajax
     */
    public function integralCenterListAjax()
    {
        $platform = new Platform();
        if (request()->isAjax()) {
            // 积分中心商品
            $this->goods = new GoodsService();
            $order = "";
            // 排序
            if (isset($_POST["id"])) {
                if ($_POST["id"] == 1) {
                    $order = "sales desc";
                } else 
                    if ($_POST["id"] == 2) {
                        $order = "collects desc";
                    } else 
                        if ($_POST["id"] == 3) {
                            $order = "evaluates desc";
                        } else 
                            if ($_POST["id"] == 4) {
                                $order = "shares desc";
                            } else {
                                $_POST["id"] = 0;
                                $order = "";
                            }
            } else {
                $_POST["id"] = 0;
            }
            
            $page_index = isset($_POST['page']) ? $_POST['page'] : '1';
            $condition = array(
                "ng.state" => 1,
                "ng.point_exchange_type" => array(
                    'NEQ',
                    0
                )
            );
            $page_count = 25;
            $allGoods = $this->goods->getGoodsList($page_index, $page_count, $condition, $order);
            return $allGoods['data'];
        }
    }
}