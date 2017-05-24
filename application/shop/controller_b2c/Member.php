<?php
/**
 * Member.php
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

use data\model\niushop\NsCartModel;
use data\model\niushop\NsGoodsModel;
use data\model\niushop\NsGoodsSkuModel;
use data\model\system\AlbumPictureModel;
use data\service\niushop\Express;
use data\service\niushop\Goods as Goods;
use data\service\niushop\Member\MemberAccount as MemberAccount;
use data\service\niushop\Member as MemberService;
use data\service\niushop\Order\Order;
use data\service\niushop\Order as OrderService;
use data\service\niushop\promotion\GoodsMansong;
use data\service\niushop\Shop;
use data\service\system\Address;
use data\service\system\Config;
use think\Session;

/**
 * 会员控制器
 * 创建人：李吉
 * 创建时间：2017-02-06 10:59:23
 */
class Member extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        // 如果没有登录的话让其先登录
        $this->checkLogin();
        // 查询登陆用户信息
        if (! request()->isAjax()) {
            $member = new MemberService();
            $member_info = $member->getMemberDetail($this->instance_id);
            if (! empty($member_info['user_info']['user_headimg'])) {
                $member_img = $member_info['user_info']['user_headimg'];
            } else {
                $member_img = '0';
            }
            $cart_list = $this->getShoppingCart(); // 购物车列表
                                                   // 选中id
            $curs = isset($_GET['curs']) ? $_GET['curs'] : '1';
            $this->assign('curs', $curs);
            
            $this->assign('member_img', $member_img);
            $this->assign('member_info', $member_info);
            $this->assign("cart_list", $cart_list);
        }
    }

    public function _empty($name)
    {}

    /**
     * 检测用户
     */
    private function checkLogin()
    {
        $uid = $this->user->getSessionUid();
        if (empty($uid)) {
            $this->redirect("login/index"); // 用户未登录
        }
        $is_member = $this->user->getSessionUserIsMember();
        if (empty($is_member)) {
            $this->redirect("Login/index"); // 当前用户不是前台会员
        }
    }

    /**
     * 收货地址列表
     * 创建人：任鹏强
     * 创建时间：2017年2月7日12:26:53
     */
    public function addressList()
    {
        $member = new MemberService();
        $page_index = isset($_GET['page']) ? $_GET['page'] : '1';
        $addresslist = $member->getMemberExpressAddressList(1, 5, '', '');
        $this->assign('page_count', $addresslist['page_count']);
        $this->assign('total_count', $addresslist['total_count']);
        $this->assign('page', $page_index);
        $this->assign('list', $addresslist);
        return view($this->style . "/Member/addressList");
    }

    /**
     * 会员地址管理
     * 添加地址
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function addressInsert()
    {
        if (request()->isAjax()) {
            $member = new MemberService();
            $consigner = $_POST['consigner'];
            $mobile = $_POST['mobile'];
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $province = $_POST['province'];
            $city = $_POST['city'];
            $district = $_POST['district'];
            $address = $_POST['address'];
            $zip_code = isset($_POST['zip_code']) ? $_POST['zip_code'] : '';
            $alias = isset($_POST['alias']) ? $_POST['alias'] : '';
            $retval = $member->addMemberExpressAddress($consigner, $mobile, $phone, $province, $city, $district, $address, $zip_code, $alias);
            return AjaxReturn($retval);
        } else {
            $address_id = isset($_GET['addressid']) ? $_GET['addressid'] : 0;
            $this->assign("address_id", $address_id);
            
            return view($this->style . "/Member/addressInsert");
        }
    }

    /**
     * 编辑收货地址：buyflowsecondgetgoods
     */
    public function operationAddress()
    {
        $id = $_POST["id"];
        $consigner = $_POST["consigner"]; // 收件人
        $mobile = $_POST["mobile"]; // 电话
        $phone = $_POST["phone"]; // 固定电话
        $province = $_POST["province"]; // 省
        $city = $_POST["city"]; // 市
        $district = $_POST["district"]; // 区县
        $address = $_POST["address"]; // 详细地址
        $zip_code = $_POST["zipcode"]; // 邮编
        $alias = ""; // 城市别名
        $member = new MemberService();
        $res = null;
        if ($id == 0) {
            // 添加
            $res = $member->addMemberExpressAddress($consigner, $mobile, $phone, $province, $city, $district, $address, $zip_code, $alias);
        } else {
            // 修改
            $res = $member->updateMemberExpressAddress($id, $consigner, $mobile, $phone, $province, $city, $district, $address, $zip_code, $alias);
        }
        return $res;
    }

    /**
     * 获取地址
     */
    public function getMemberExpressAddress()
    {
        $id = $_POST['id'];
        $member = new MemberService();
        $info = $member->getMemberExpressAddressDetail($id);
        return $info;
    }

    /**
     * 修改会员地址
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >|Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function updateMemberAddress()
    {
        $member = new MemberService();
        if (request()->isAjax()) {
            $id = $_POST['id'];
            $consigner = $_POST['consigner'];
            $mobile = $_POST['mobile'];
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $province = $_POST['province'];
            $city = $_POST['city'];
            $district = $_POST['district'];
            $address = $_POST['address'];
            $zip_code = isset($_POST['zip_code']) ? $_POST['zip_code'] : '';
            $alias = isset($_POST['alias']) ? $_POST['alias'] : '';
            $retval = $member->updateMemberExpressAddress($id, $consigner, $mobile, $phone, $province, $city, $district, $address, $zip_code, $alias);
            return AjaxReturn($retval);
        } else {
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $info = $member->getMemberExpressAddressDetail($id);
            $this->assign("address_info", $info);
            return view($this->style . "/Member/updateMemberAddress");
        }
    }

    /**
     * 获取用户地址详情
     *
     * @return Ambigous <\think\static, multitype:, \think\db\false, PDOStatement, string, \think\Model, \PDOStatement, \think\db\mixed, multitype:a r y s t i n g Q u e \ C l o , \think\db\Query, NULL>
     */
    public function getMemberAddressDetail()
    {
        $address_id = isset($_POST['id']) ? $_POST['id'] : 0;
        $member = new MemberService();
        $info = $member->getMemberExpressAddressDetail($address_id);
        return $info;
    }

    /**
     * 会员地址删除
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function memberAddressDelete()
    {
        $id = $_POST['id'];
        $member = new MemberService();
        $res = $member->memberAddressDelete($id);
        return AjaxReturn($res);
    }

    /**
     * 修改会员默认地址
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function updateAddressDefault()
    {
        $id = $_POST['id'];
        $member = new MemberService();
        $res = $member->updateAddressDefault($id);
        return AjaxReturn($res);
    }

    /**
     * 获取省列表
     */
    public function getProvince()
    {
        $address = new Address();
        $province_list = $address->getProvinceList();
        return $province_list;
    }

    /**
     * 获取城市列表
     *
     * @return Ambigous <multitype:\think\static , \think\false, \think\Collection, \think\db\false, PDOStatement, string, \PDOStatement, \think\db\mixed, boolean, unknown, \think\mixed, multitype:, array>
     */
    public function getCity()
    {
        $address = new Address();
        $province_id = isset($_POST['province_id']) ? $_POST['province_id'] : 0;
        $city_list = $address->getCityList($province_id);
        return $city_list;
    }

    /**
     * 获取区域地址
     */
    public function getDistrict()
    {
        $address = new Address();
        $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : 0;
        $district_list = $address->getDistrictList($city_id);
        return $district_list;
    }

    /**
     * 获取选择地址
     *
     * @return unknown
     */
    public function getSelectAddress()
    {
        $address = new Address();
        $province_list = $address->getProvinceList();
        $province_id = isset($_POST['province_id']) ? $_POST['province_id'] : 0;
        $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : 0;
        $city_list = $address->getCityList($province_id);
        $district_list = $address->getDistrictList($city_id);
        $data["province_list"] = $province_list;
        $data["city_list"] = $city_list;
        $data["district_list"] = $district_list;
        return $data;
    }

    /**
     * 我的订单
     * 创建人：任鹏强
     * 创建时间：2017年2月7日12:26:55
     */
    public function orderList($page = 1, $page_size = 10)
    {
        $status = isset($_GET['status']) ? $_GET['status'] : 'all';
        $condition['buyer_id'] = $this->uid;
        
        $orderService = new OrderService();
        // 查询个人用户的订单数量
        $orderStatusNum = $orderService->getOrderStatusNum($condition);
        $this->assign("statusNum", $orderStatusNum);
        // 查询订单状态的数量
        $status = isset($_GET['status']) ? $_GET['status'] : 'all';
        if ($status != 'all') {
            switch ($status) {
                case 0:
                    $condition['order_status'] = 0;
                    break;
                case 1:
                    $condition['order_status'] = 1;
                    break;
                case 2:
                    $condition['order_status'] = 2;
                    break;
                case 3:
                    $condition['order_status'] = 3;
                    break;
                case 4:
                    $condition['order_status'] = array(
                        'in',
                        '-1,-2'
                    );
                    break;
                case 5:
                    $condition['order_status'] = 3;
                    $condition['is_evaluate'] = 0;
                    break;
                default:
                    break;
            }
            if ($condition['order_status'] == array(
                'in',
                '-1,-2'
            )) {
                $orderList = $orderService->getOrderList($page, $page_size, $condition, 'create_time desc');
                foreach ($orderList['data'] as $key => $item) {
                    $order_item_list = array();
                    $order_item_list = $orderList['data'][$key]['order_item_list'];
                    foreach ($order_item_list as $k => $value) {
                        if ($value['refund_status'] == 0 || $value['refund_status'] == - 2) {
                            unset($order_item_list[$k]);
                        }
                    }
                    $orderList['data'][$key]['order_item_list'] = $order_item_list;
                }
            } else {
                $orderList = $orderService->getOrderList($page, $page_size, $condition, 'create_time desc');
            }
        } else {
            
            $orderList = $orderService->getOrderList($page, $page_size, $condition, 'create_time desc');
        }
        
        $this->assign("orderList", $orderList['data']);
        $this->assign("page_count", $orderList['page_count']);
        $this->assign("total_count", $orderList['total_count']);
        $this->assign("page", $page);
        $this->assign("status", $status);
        return view($this->style . '/Member/orderList');
    }

    /**
     * 我的收藏-->商品收藏
     * 创建人：任鹏强
     * 创建时间：2017年2月7日12:26:58
     */
    public function goodsCollectionList()
    {
        $member = new MemberService();
        $page = isset($_GET['page']) ? $_GET['page'] : '1';
        $data = array(
            "nmf.fav_type" => 'goods',
            "nmf.uid" => $this->uid
        );
        $goods_collection_list = $member->getMemberGoodsFavoritesList($page, 12, $data);
        $this->assign("goods_collection_list", $goods_collection_list["data"]);
        $this->assign('page', $page);
        $this->assign("goods_list", $goods_collection_list);
        $this->assign('page_count', $goods_collection_list['page_count']);
        $this->assign('total_count', $goods_collection_list['total_count']);
        return view($this->style . '/Member/goodsCollectionList');
    }

    /**
     * 查询右侧边栏的店铺收藏
     * 创建人：王永杰
     * 创建时间：2017年2月27日 10:18:14
     *
     * @return unknown
     */
    public function queryShopOrGoodsCollections()
    {
        $member = new MemberService();
        $type = $_POST["type"];
        $data = array(
            "nmf.fav_type" => $type,
            "nmf.uid" => $this->uid
        );
        $list = null;
        if ($type == "shop") {
            $list = $member->getMemberShopsFavoritesList(1, 50, $data);
        } else {
            $list = $member->getMemberGoodsFavoritesList(1, 50, $data);
        }
        return $list["data"];
    }

    /**
     * 订单详情
     * 创建人：任鹏强
     * 创建时间:2017年2月7日14:49:01
     */
    public function orderDetail()
    {
        $order_id = isset($_GET['orderId']) ? $_GET['orderId'] : 0;
        if ($order_id == 0) {
            $this->error("没有获取到订单信息");
        }
        $order_service = new OrderService();
        $detail = $order_service->getOrderDetail($order_id);
        $detail['pay_status_name'] = $order_service->getPayStatusInfo($detail['pay_status'])['status_name'];
        $detail['shipping_status_name'] = $order_service->getShippingInfo($detail['shipping_status'])['status_name'];
        
        $this->assign("order", $detail);
        return view($this->style . '/Member/orderDetail');
    }

    public function index()
    {
        // 可用积分和余额,显示的是用户在店铺中的积分和余额
        $point = 0;
        $balance = 0;
        $member_detail = $this->user->getMemberDetail($this->instance_id);
        if (! empty($member_detail)) {
            $point = $member_detail['point'];
            $balance = $member_detail['balance'];
        }
        if (isset($point)) {
            $this->assign(array(
                'point' => $point,
                'balance' => $balance
            ));
        } else {
            $this->assign(array(
                'point' => '0',
                'balance' => '0.00'
            ));
        }
        // 优惠券
        $vouchers = $this->user->getMemberCounponList(1);
        if ($vouchers != "") {
            $vouchersCount = count($vouchers);
        } else {
            $vouchersCount = 0;
        }
        $this->assign("vouchersCount", $vouchersCount);
        
        $member = new MemberService();
        // 商品收藏
        $data_goods = array(
            "nmf.fav_type" => "goods",
            "nmf.uid" => $this->uid
        );
        $goods_collection_list = $member->getMemberGoodsFavoritesList(1, 3, $data_goods);
        $this->assign("goods_collection_list", $goods_collection_list["data"]);
        $this->assign("goods_collection_list_count", count($goods_collection_list["data"]));
        
        // 交易提醒 商品列表 商品数量
        $orderService = new OrderService();
        $condition = null;
        $condition['buyer_id'] = $this->uid;
        $orderStatusNum = $orderService->getOrderStatusNum($condition);
        $condition = null;
        $condition['order_status'] = 0;
        $condition['buyer_id'] = $this->uid;
        $orderList = $orderService->getOrderList(1, 4, $condition, 'create_time desc');
        
        // 用户公告！
        $config = new Config();
        $user_notice = $config->getUserNotice($this->instance_id);
        $this->assign('user_notice', $user_notice);
        
        $this->assign("wait_pay_num", $orderStatusNum['wait_pay']);
        $this->assign("wait_evaluate", $orderStatusNum['wait_evaluate']);
        
        $this->assign("orderList", $orderList['data']);
        return view($this->style . '/Member/index');
    }

    /**
     * 取消订单
     * 创建人：任鹏强
     * 创建时间：2017年3月3日09:18:35
     */
    public function orderClose()
    {
        $orderService = new OrderService();
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
        $order = $orderService->orderClose($order_id);
        return AjaxReturn($order);
    }

    /**
     * 获取购物车信息
     * 创建人：王永杰
     * 创建时间：2017年2月15日 14:34:54
     *
     * {@inheritdoc}
     *
     * @see \app\shop\controller\BaseController::getShoppingCart()
     */
    public function getShoppingCart()
    {
        if (empty($_SESSION["user_cart"])) {
            $goods = new Goods();
            $cart_list = $goods->getCart($this->uid);
            $_SESSION['user_cart'] = $cart_list;
            return $cart_list;
        } else {
            return $_SESSION['user_cart'];
        }
    }

    /**
     * 更新购物车中商品数量
     * 创建人：王永杰
     * 创建时间：2017年2月15日 15:43:23
     *
     * @return unknown
     */
    public function updateCartGoodsNumber()
    {
        $goods = new Goods();
        $cart_id = $_POST["cart_id"];
        $num = $_POST["num"];
        $_SESSION['user_cart'] = '';
        $res = $goods->cartAdjustNum($cart_id, $num);
        return $res;
    }

    /**
     * 根据cartid删除购物车中的商品
     * 创建人：王永杰
     * 创建时间：2017年2月15日 14:34:45
     *
     * @return unknown
     */
    public function deleteShoppingCartById()
    {
        $goods = new Goods();
        $cart_id_array = $_POST["cart_id_array"];
        $res = $goods->cartDelete($cart_id_array);
        $_SESSION['user_cart'] = '';
        return $res;
    }

    /**
     * 购物车
     * 创建人：王永杰
     * 创建时间：2017年2月7日 15:45:49
     *
     * @return \think\response\View
     */
    public function cart()
    {
        $goods = new Goods();
        $cart_list = $this->getShoppingCart();
        $this->assign("cart_list", $cart_list);
        return view($this->style . '/Member/cart');
    }

    /**
     * 立即购买
     */
    public function buyNowSession()
    {
        $order_sku_list = isset($_SESSION["order_sku_list"]) ? $_SESSION["order_sku_list"] : "";
        if (empty($order_sku_list)) {
            $this->redirect('index/index'); // 没有商品返回到首页
        }
        
        $cart_list = array();
        $order_sku_list = explode(":", $_SESSION["order_sku_list"]);
        $sku_id = $order_sku_list[0];
        $num = $order_sku_list[1];
        
        // 获取商品sku信息
        $goods_sku = new NsGoodsSkuModel();
        $sku_info = $goods_sku->getInfo([
            'sku_id' => $sku_id
        ], '*');
        
        // 清除非法错误数据
        $cart = new NsCartModel();
        if (empty($sku_info)) {
            $cart->destroy([
                'buyer_id' => $this->uid,
                'sku_id' => $sku_id
            ]);
            $this->redirect('index/index'); // 没有商品返回到首页
        }
        
        $goods = new NsGoodsModel();
        $goods_info = $goods->getInfo([
            'goods_id' => $sku_info["goods_id"]
        ], 'max_buy,state,point_exchange_type,point_exchange,picture,goods_id,goods_name');
        
        $cart_list["stock"] = $sku_info['stock']; // 库存
        $cart_list["sku_name"] = $sku_info["sku_name"];
        $cart_list["price"] = $sku_info['promote_price'];
        
        $cart_list["goods_id"] = $goods_info["goods_id"];
        $cart_list["goods_name"] = $goods_info["goods_name"];
        $cart_list["max_buy"] = $goods_info['max_buy']; // 限购数量
        $cart_list['point_exchange_type'] = $goods_info['point_exchange_type']; // 积分兑换类型 0 非积分兑换 1 只能积分兑换
        $cart_list['point_exchange'] = $goods_info['point_exchange']; // 积分兑换
        if ($goods_info['state'] != 1) {
            $this->redirect('index/index'); // 商品状态 0下架，1正常，10违规（禁售）
        }
        $cart_list["num"] = $num;
        // 如果购买的数量超过限购，则取限购数量
        if ($goods_info['max_buy'] != 0 && $goods_info['max_buy'] < $num) {
            $num = $goods_info['max_buy'];
        }
        // 如果购买的数量超过库存，则取库存数量
        if ($sku_info['stock'] < $num) {
            $num = $sku_info['stock'];
        }
        // 获取图片信息
        $picture = new AlbumPictureModel();
        $picture_info = $picture->get($goods_info['picture']);
        $cart_list['picture_info'] = $picture_info;
        
        if (count($cart_list) == 0) {
            $this->redirect('index/index'); // 没有商品返回到首页
        }
        $list[] = $cart_list;
        $goods_sku_list = $sku_id . ":" . $num; // 商品skuid集合
        $res["list"] = $list;
        $res["goods_sku_list"] = $goods_sku_list;
        return $res;
    }

    /**
     * 加入购物车
     *
     * @return unknown
     */
    public function addShoppingCartSession()
    {
        // 加入购物车
        $cart_list = isset($_SESSION["cart_list"]) ? $_SESSION["cart_list"] : ""; // 用户所选择的商品
        $cart_id = implode(",", $cart_list);
        if ($cart_id == "") {
            $this->redirect('index/index'); // 没有商品返回到首页
        }
        
        $cart_id_arr = explode(",", $cart_id);
        $goods = new Goods();
        $cart_list = $goods->getCartList($cart_id);
        if (count($cart_list) == 0) {
            $this->redirect('index/index'); // 没有商品返回到首页
        }
        $list = Array();
        $str_cart_id = ""; // 购物车id
        $goods_sku_list = ''; // 商品skuid集合
        for ($i = 0; $i < count($cart_list); $i ++) {
            if ($cart_id_arr[$i] == $cart_list[$i]["cart_id"]) {
                $list[] = $cart_list[$i];
                $str_cart_id .= "," . $cart_list[$i]["cart_id"];
                $goods_sku_list .= "," . $cart_list[$i]['sku_id'] . ':' . $cart_list[$i]['num'];
            }
        }
        $goods_sku_list = substr($goods_sku_list, 1); // 商品sku列表
        $res["list"] = $list;
        $res["goods_sku_list"] = $goods_sku_list;
        return $res;
    }

    /**
     * 购买流程：查看购物车，待付款订单 第一步
     * 创建人：王永杰
     * 创建时间：2017年2月10日 08:49:34
     *
     * @return \think\response\View
     */
    public function buyFlowSecondGetGoods()
    {
        $order_tag = isset($_SESSION['order_tag']) ? $_SESSION['order_tag'] : "";
        if (empty($order_tag)) {
            $this->redirect('index/index'); // 没有商品返回到首页
        }
        $member = new MemberService();
        $order = new OrderService();
        switch ($order_tag) {
            // 立即购买
            case "buy_now":
                $res = $this->buyNowSession();
                $goods_sku_list = $res["goods_sku_list"];
                $list = $res["list"];
                break;
            case "cart":
                // 加入购物车
                $res = $this->addShoppingCartSession();
                $goods_sku_list = $res["goods_sku_list"];
                $list = $res["list"];
                break;
        }
        $addresslist = $member->getMemberExpressAddressList(1, 10, '', ' is_default DESC'); // 地址查询
        
        $address = $member->getDefaultExpressAddress();
        $is_calculate_express = 1;
        $res_message = '';
        if (! empty($address)) {
            $express = $order->getExpressFee($goods_sku_list, $address['province'], $address['city']);
            if ($express == NULL_EXPRESS_FEE) {
                $is_calculate_express = 0;
                $message = AjaxReturn($express);
                $res_message = $message['message'];
                $express = 0;
            }
        } else {
            $express = 0;
        }
        
        // 计算优惠金额
        $goods_mansong = new GoodsMansong();
        $discount_money = $goods_mansong->getGoodsMansongMoney($goods_sku_list);
        
        $count_money = $order->getGoodsSkuListPrice($goods_sku_list); // 商品金额
        
        $count_point_exchange = 0;
        foreach ($list as $k => $v) {
            if ($v["point_exchange_type"] == 1) {
                if ($v["point_exchange"] > 0) {
                    $count_point_exchange += $v["point_exchange"] * $v["num"];
                }
            }
        }
        
        $this->assign("count_point_exchange", $count_point_exchange); // 总积分
        $member_account = $this->getMemberAccount($this->instance_id); // 用户余额
        $coupon_list = $order->getMemberCouponList($goods_sku_list); // 获取优惠券
        $this->assign("list", $list); // 格式化后的列表
        $this->assign("coupon_list", $coupon_list); // 优惠卷
        $this->assign('goods_sku_list', $goods_sku_list); // 商品sku列表
        $this->assign("member_account", $member_account); // 用户余额、积分
        $this->assign("express", $express); // 运费
        $this->assign("is_calculate_express", $is_calculate_express); // 运费状态
        $this->assign("res_message", $res_message); // 运费提示
        $this->assign("count_money", sprintf("%.2f", $count_money));
        $this->assign("discount_money", sprintf("%.2f", $discount_money)); // 总优惠
        $this->assign("address_list", $addresslist["data"]); // 选择收货地址
        return view($this->style . 'Member/buyFlowSecondGetGoods');
    }

    /**
     * 立即购买、加入购物车都存入session中，
     *
     * @return number
     */
    public function orderCreateSession()
    {
        $tag = isset($_POST['tag']) ? $_POST['tag'] : '';
        if (empty($tag)) {
            return - 1;
        }
        switch ($tag) {
            case 'buy_now':
                // 立即购买
                $_SESSION['order_tag'] = 'buy_now';
                $_SESSION['order_sku_list'] = $_POST['sku_id'] . ':' . $_POST['num'];
                break;
            case 'cart':
                // 加入购物车
                $_SESSION['order_tag'] = 'cart';
                $_SESSION['cart_list'] = $_POST['cart_id'];
                break;
        }
        return 1;
    }

    /**
     * 添加购物车
     * 创建人：王永杰
     * 创建时间：2017年2月13日 14:31:52
     */
    public function addCart()
    {
        $goods = new Goods();
        $cart_detail = $_POST['cart_detail'];
        $uid = $this->uid;
        $goods_id = $cart_detail['goods_id'];
        $goods_name = $cart_detail['goods_name'];
        $shop_id = $this->instance_id;
        $web_info = $this->web_site->getWebSiteInfo();
        $count = $cart_detail['count'];
        $sku_id = $cart_detail['sku_id'];
        $sku_name = $cart_detail['sku_name'];
        $price = $cart_detail['price'];
        $cost_price = $cart_detail['cost_price'];
        $picture_id = $cart_detail['picture_id'];
        $this->is_member = $this->user->getSessionUserIsMember();
        $_SESSION['user_cart'] = '';
        $retval = - 1;
        if (! empty($this->uid) && $this->is_member == 1) {
            $retval = $goods->addCart($uid, $shop_id, $web_info['title'], $goods_id, $goods_name, $sku_id, $sku_name, $price, $count, $picture_id, 0);
        }
        return $retval;
    }

    /**
     * 获取用户余额
     * 2017年3月1日 10:50:45
     *
     * @param unknown $shop_id            
     * @return unknown
     */
    public function getMemberAccount($shop_id)
    {
        $member = new MemberService();
        $member_account = $member->getMemberAccount($this->uid, $shop_id);
        return $member_account;
    }

    /**
     * 退款/退货/维修订单列表
     * 创建人：周学勇
     * 创建时间：2017年2月7日 16:13:04
     *
     * @return \think\response\View
     */
    public function backList()
    {
        $orderService = new OrderService();
        $page = isset($_GET['page']) ? $_GET['page'] : '1'; // pageindex
                                                            // 查询订单状态的数量
        $condition['buyer_id'] = $this->uid;
        $condition['order_status'] = array(
            'in',
            '-1,-2'
        );
        $orderList = $orderService->getOrderList($page, 10, $condition, 'create_time desc');
        
        foreach ($orderList['data'] as $key => $item) {
            $order_item_list = array();
            $order_item_list = $orderList['data'][$key]['order_item_list'];
            foreach ($order_item_list as $k => $value) {
                if ($value['refund_status'] == 0 || $value['refund_status'] == - 2) {
                    unset($order_item_list[$k]);
                }
            }
            $orderList['data'][$key]['order_item_list'] = $order_item_list;
        }
        $this->assign("orderList", $orderList['data']);
        $this->assign("page_count", $orderList['page_count']);
        $this->assign("total_count", $orderList['total_count']);
        $this->assign("page", $page);
        
        return view($this->style . 'Member/backList');
    }

    /**
     * 取消退款
     * 任鹏强
     * 2017年3月1日15:30:51
     */
    public function cancleOrder()
    {
        if (request()->isAjax()) {
            $orderService = new OrderService();
            $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
            $order_goods_id = isset($_POST['order_goods_id']) ? $_POST['order_goods_id'] : '';
            $cancle_order = $orderService->orderGoodsCancel($order_id, $order_goods_id);
            return AjaxReturn($cancle_order);
        }
    }

    /**
     * 商品评价/晒单
     * 创建人：周学勇
     * 创建时间：2017年2月7日 16:14:00
     *
     * @return \think\response\View
     */
    public function goodsEvaluationList($page = 1, $page_size = 10)
    {
        $order = new OrderService();
        $condition['uid'] = $this->uid;
        $goodsEvaluationList = $order->getOrderEvaluateDataList($page, $page_size, $condition, 'addtime desc');
        $this->assign("goodsEvaluationList", $goodsEvaluationList['data']);
        $this->assign("page_count", $goodsEvaluationList['page_count']);
        $this->assign("total_count", $goodsEvaluationList['total_count']);
        $this->assign("page", $page);
        return view($this->style . 'Member/goodsEvaluationList');
    }

    /**
     * 用户信息
     * 创建人:吴奇
     * 创建时间： 2017年2月7日 16:36：00
     */
    public function person()
    {
        if (isset($_POST["submit"])) {
            $user_name = isset($_POST["user_name"]) ? $_POST["user_name"] : "";
            $user_tel = isset($_POST["user_tel"]) ? $_POST["user_tel"] : "";
            $user_qq = isset($_POST["user_qq"]) ? $_POST["user_qq"] : "";
            $user_email = isset($_POST["user_email"]) ? $_POST["user_email"] : "";
            $real_name = isset($_POST["real_name"]) ? $_POST["real_name"] : "";
            $sex = isset($_POST["sex"]) ? (int) $_POST["sex"] : "";
            $birthday = isset($_POST["birthday"]) ? $_POST["birthday"] : "";
            $location = isset($_POST["location"]) ? $_POST["location"] : "";
            $birthday = date('Y-m-d', strtotime($birthday));
            // 把从前台显示的内容转变为可以存储到数据库中的数据
            $result = $this->user->updateMemberInformation($user_name, $user_tel, $user_qq, $user_email, $real_name, $sex, $birthday, $location, "");
        }
        if ($_FILES && isset($_POST["submit2"])) {
            if ((($_FILES["user_headimg"]["type"] == "image/gif") || ($_FILES["user_headimg"]["type"] == "image/jpeg") || ($_FILES["user_headimg"]["type"] == "image/pjpeg") || ($_FILES["user_headimg"]["type"] == "image/png")) && ($_FILES["user_headimg"]["size"] < 10000000)) {
                if ($_FILES["user_headimg"]["error"] > 0) {
                    // echo "错误： " . $_FILES["user_headimg"]["error"] . "<br />";
                }
                $file_name = date("YmdHis") . rand(0, date("is")); // 文件名
                $ext = explode(".", $_FILES["user_headimg"]["name"]);
                $file_name .= $ext[1];
                move_uploaded_file($_FILES["user_headimg"]["tmp_name"], "upload/admin/" . $file_name);
                $user_headimg = "upload/admin/" . $file_name;
                $result = $this->user->updateMemberInformation("", "", "", "", "", "", "", "", $user_headimg);
                $result2 = ($result == true) ? "上传头像成功" : "上传头像失败";
            } else {
                // echo "不是图片，不能上传";
            }
        }
        $member_info = $this->user->getMemberDetail();
        $this->assign('member_info', $member_info);
        if (! empty($member_info['user_info']['user_headimg'])) {
            $member_img = $member_info['user_info']['user_headimg'];
        } elseif (! empty($member_info['user_info']['qq_openid'])) {
            $member_img = $member_info['user_info']['qq_info_array']['figureurl_qq_1'];
        } elseif (! empty($member_info['user_info']['wx_openid'])) {
            $member_img = '0';
        } else {
            $member_img = '0';
        }
        // 处理状态信息
        if ($member_info["user_info"]["user_status"] == 0) {
            $member_info["user_info"]["user_status"] = "锁定";
        } else {
            $member_info["user_info"]["user_status"] = "正常";
        }
        $this->assign('qq_openid', $member_info['user_info']['qq_openid']);
        $this->assign('member_img', $member_img);
        return view($this->style . 'Member/personInformation');
    }

    /**
     * 优惠券
     * 创建人:吴奇
     * 创建时间： 2017年2月7日 16:36：00
     */
    public function vouchers()
    {
        // 获取该用户的所有已领取未使用的优惠券列表
        $list = $this->user->getMemberCounponList(1);
        foreach ($list as $list2) {
            $list2["shop_id"] = $this->user->getShopNameByShopId($list2["shop_id"]);
            $list2["state"] = "未使用";
        }
        $this->assign("list", $list);
        return view($this->style . 'Member/vouchers');
    }

    /**
     * 会员积分流水
     * 创建人:吴奇
     * 创建时间：2017年3月1日 17:00
     */
    public function integrallist()
    {
        $shop_id = $this->instance_id;
        $conponAccount = new MemberAccount();
        $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '2016-01-01';
        $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '2099-01-01';
        $page_index = isset($_GET['page']) ? $_GET['page'] : '1';
        // 每页显示几个
        $page_count = 10;
        // 查看用户在该商铺下的积分消费流水
        $list = $this->user->getPageMemberPointList($start_time, $end_time, $page_index, $page_count, $shop_id);
        foreach ($list["data"] as $list2) {
            if ($list2["number"] < 0) {
                $list2["number"] = 0 - $list2["number"];
            }
            $list2["number"] = (int) $list2["number"];
            $list2["data_id"] = $this->user->getOrderNumber($list2["data_id"])["out_trade_no"];
        }
        // 获取兑换比例
        $account = new MemberAccount();
        $accounts = $account->getConvertRate($shop_id);
        // 查看积分总数
        $account_type = 1;
        
        $conponSum = $conponAccount->getMemberAccount($shop_id, $this->uid, $account_type);
        // 店铺名称
        $shop_name = $this->user->getShopNameByShopId($shop_id);
        $this->assign([
            'account' => $accounts['convert_rate'],
            "sum" => (int) $conponSum,
            "shopname" => $shop_name,
            "shop_id" => $shop_id,
            'page_count' => $list['page_count'],
            'total_count' => $list['total_count'],
            "balances" => $list,
            'page' => $page_index
        ]);
        return view($this->style . 'Member/integral');
    }

    /**
     * 会员余额流水
     * 创建人:吴奇
     * 创建时间： 2017年3月1日 17:00
     */
    public function balancelist()
    {
        $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '2016-01-01';
        $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '2099-01-01';
        $page_index = isset($_GET['page']) ? $_GET['page'] : '1';
        $shop_id = $this->instance_id;
        $page_count = 10;
        // 该店铺下的余额流水
        $list = $this->user->getPageMemberBalanceList($start_time, $end_time, $page_index, $page_count, $shop_id);
        // 对获取的数据进行处理
        foreach ($list["data"] as $list2) {
            if ($list2["number"] < 0) {
                $list2["number"] = number_format(0 - $list2["number"], 2);
            }
            $list2["data_id"] = $this->user->getOrderNumber($list2["data_id"])["out_trade_no"];
        }
        // 用户在该店铺的账户余额总数
        $account_type = 2;
        $accountAccount = new MemberAccount();
        $accountSum = $accountAccount->getMemberAccount($shop_id, $this->uid, $account_type);
        $this->assign("sum", number_format($accountSum, 2));
        // 店铺名称
        $shop_name = $this->user->getShopNameByShopId($shop_id);
        $this->assign("shopname", $shop_name);
        $this->assign('page_count', $list['page_count']);
        $this->assign('total_count', $list['total_count']);
        $this->assign("balances", $list);
        $this->assign('page', $page_index);
        return view($this->style . 'Member/balance');
    }

    /**
     * 余额积分相互兑换
     * 吴奇
     * 2017/3/1 17:57
     */
    public function exchange()
    {
        $point = (float) $_POST["amount"];
        $shop_id = intval($_POST["shopid"]);
        $result = $this->user->memberPointToBalance($this->uid, $shop_id, $point);
        if ($result == 1) {
            $this->assign("shop_id", $shop_id);
            return view($this->style . 'Member/exchangeSuccess');
        }
    }

    /**
     * 退出登录
     * 吴奇
     * 2017/2/15 16:08
     */
    public function logOut()
    {
        $member = new MemberService();
        $member->Logout();
        return AjaxReturn(1);
    }

    /**
     * 账号安全
     */
    public function userSecurity()
    {
        if (request()->isGet()) {
            $atc = isset($_GET['atc']) ? $_GET['atc'] : '';
            $this->assign('atc', $atc);
        }
        return view($this->style . "Member/userSecurity");
    }

    /**
     * 吴奇
     * 商品评价
     * 2017/2/16 16:08
     */
    public function reviewCommodity()
    {
        // 先考虑显示的样式
        if (request()->isGet()) {
            $order_id = $_GET["orderId"];
            $order = new Order();
            $list = $order->getOrderGoods($order_id);
            $orderDetail = $order->getDetail($order_id);
            $this->assign("order_no", $orderDetail['order_no']);
            $this->assign("order_id", $order_id);
            $this->assign("list", $list);
            if (($orderDetail['order_status'] == 3 || $orderDetail['order_status'] == 4) && $orderDetail['is_evaluate'] == 0) {
                return view($this->style . '/Member/reviewCommodity');
            } else {
                $this->redirect("shop/member/index");
            }
        } else {
            return view($this->style . "Member/orderList");
        }
    }

    /**
     * 追评
     * 李吉
     * 2017-02-17 14:12:15
     */
    public function reviewAgain()
    {
        // 先考虑显示的样式
        if (request()->isGet()) {
            $order_id = $_GET["orderId"];
            $order = new Order();
            $list = $order->getOrderGoods($order_id);
            $orderDetail = $order->getDetail($order_id);
            $this->assign("order_no", $orderDetail['order_no']);
            $this->assign("order_id", $order_id);
            $this->assign("list", $list);
            if (($orderDetail['order_status'] == 3 || $orderDetail['order_status'] == 4) && $orderDetail['is_evaluate'] == 1) {
                return view($this->style . '/Member/reviewAgain');
            } else {
                $this->redirect("shop/member/index");
            }
        } else {
            return view($this->style . "Member/orderList");
        }
    }

    /**
     * 增加商品评价
     */
    public function modityCommodity()
    {
        return 1;
    }

    /**
     * 功能：绑定手机
     * 创建人：李志伟
     * 创建时间：2017年2月16日17:17:43
     */
    public function modifyMobile()
    {
        $uid = $this->user->getSessionUid();
        $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
        $mobile_code = isset($_POST['mobile_code']) ? $_POST['mobile_code'] : '';
        $verification_code = Session::get('mobileVerificationCode');
        if ($mobile_code == $verification_code && ! empty($verification_code)) {
            $member = new MemberService();
            $retval = $member->modifyMobile($uid, $mobile);
            if ($retval == 1)
                Session::delete('mobileVerificationCode');
            return AjaxReturn($retval);
        } else {
            return array(
                'code' => 0,
                'message' => '验证码输入错误'
            );
        }
    }

    /**
     * 功能：绑定邮箱
     * 创建人：李志伟
     * 创建时间：2017年2月16日17:17:43
     */
    public function modifyEmail()
    {
        $member = new MemberService();
        $uid = $this->user->getSessionUid();
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $email_code = isset($_POST['email_code']) ? $_POST['email_code'] : '';
        $verification_code = Session::get('emailVerificationCode');
        if ($email_code == $verification_code && ! empty($verification_code)) {
            $member = new MemberService();
            $retval = $member->modifyEmail($uid, $email);
            if ($retval == 1)
                Session::delete('emailVerificationCode');
            return AjaxReturn($retval);
        } else {
            return array(
                'code' => 0,
                'message' => '验证码输入错误'
            );
        }
    }

    /**
     * 功能：修改密码
     * 创建人：李志伟
     * 创建时间：2017年2月16日17:58:06
     */
    public function modifyPassword()
    {
        $member = new MemberService();
        $uid = $this->user->getSessionUid();
        $old_password = isset($_POST['old_password']) ? $_POST['old_password'] : '';
        $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
        $retval = $member->ModifyUserPassword($uid, $old_password, $new_password);
        return AjaxReturn($retval);
    }

    /**
     * 申请退款
     *
     * @return \think\response\View
     */
    public function refundDetail()
    {
        $order_goods_id = isset($_GET['order_goods_id']) ? $_GET['order_goods_id'] : 0;
        if ($order_goods_id == 0) {
            $this->error("没有获取到退款信息");
        }
        $order_service = new OrderService();
        $detail = $order_service->getOrderGoodsRefundInfo($order_goods_id);
        $this->assign("detail", $detail);
        
        $refund_money = $order_service->orderGoodsRefundMoney($order_goods_id);
        $this->assign('refund_money', $refund_money);
        
        // 查询店铺默认物流地址
        $express = new Express();
        $address = $express->getDefaultShopExpressAddress($this->instance_id);
        $this->assign("address_info", $address);
        return view($this->style . "Member/refundDetail");
    }

    /**
     * 申请退款
     */
    public function orderGoodsRefundAskfor()
    {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
        $order_goods_id = isset($_POST['order_goods_id']) ? $_POST['order_goods_id'] : 0;
        $refund_type = isset($_POST['refund_type']) ? $_POST['refund_type'] : 1;
        $refund_require_money = isset($_POST['refund_require_money']) ? $_POST['refund_require_money'] : 0;
        $refund_reason = isset($_POST['refund_reason']) ? $_POST['refund_reason'] : '';
        $order_service = new OrderService();
        $retval = $order_service->orderGoodsRefundAskfor($order_id, $order_goods_id, $refund_type, $refund_require_money, $refund_reason);
        return AjaxReturn($retval);
    }

    /**
     * 买家退货
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function orderGoodsRefundExpress()
    {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
        $order_goods_id = isset($_POST['order_goods_id']) ? $_POST['order_goods_id'] : 0;
        $refund_express_company = isset($_POST['refund_express_company']) ? $_POST['refund_express_company'] : '';
        $refund_shipping_no = isset($_POST['refund_shipping_no']) ? $_POST['refund_shipping_no'] : 0;
        $refund_reason = isset($_POST['refund_reason']) ? $_POST['refund_reason'] : '';
        $order_service = new OrderService();
        $retval = $order_service->orderGoodsReturnGoods($order_id, $order_goods_id, $refund_express_company, $refund_shipping_no);
        return AjaxReturn($retval);
    }
}
