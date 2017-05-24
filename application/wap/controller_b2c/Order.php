<?php
/**
 * Order.php
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

use data\model\niushop\NsCartModel;
use data\model\niushop\NsGoodsModel;
use data\model\niushop\NsGoodsSkuModel;
use data\model\system\AlbumPictureModel;
use data\service\niushop\Express;
use data\service\niushop\Goods;
use data\service\niushop\Member;
use data\service\niushop\Member as MemberService;
use data\service\niushop\Order as OrderService;
use data\service\niushop\promotion\GoodsMansong;

/**
 * 订单控制器
 *
 * @author Administrator
 *        
 */
class Order extends BaseController
{

    /**
     * 待付款订单
     */
    public function paymentOrder()
    {
        // 检测购物车
        $tag = isset($_SESSION['order_tag']) ? $_SESSION['order_tag'] : '';
        if (empty($tag)) {
            $this->error("没有获取到商品信息");
        } else {
            switch ($tag) {
                case "cart":
                    $carts = isset($_SESSION['cart_list']) ? $_SESSION['cart_list'] : '';
                    if (! empty($carts)) {
                        $goods = new Goods();
                        $cart_list = $goods->getCartList($carts);
                        if (count($cart_list) == 0) {
                            $this->redirect('index/index'); // 没有商品返回到首页
                        }
                        $goods_sku_list = '';
                        for ($i = 0; $i < count($cart_list); $i ++) {
                            $goods_sku_list .= $cart_list[$i]['sku_id'] . ':' . $cart_list[$i]['num'] . ',';
                        }
                        $goods_sku_list = substr($goods_sku_list, 0, strlen($goods_sku_list) - 1);
                    } else {
                        $this->error("没有获取到商品信息");
                    }
                    break;
                case "buy_now":
                    $order_sku_list = isset($_SESSION['order_sku_list']) ? $_SESSION['order_sku_list'] : '';
                    if (! empty($order_sku_list)) {
                        $res = $this->buyNowSession();
                        $cart_list = $res["list"];
                        $goods_sku_list = $res["goods_sku_list"];
                    } else {
                        $this->error("没有获取到商品信息");
                    }
                    break;
            }
        }
        // 查询 商品及优惠信息
        $uid = $this->uid;
        $order = new OrderService();
        $count_money = $order->getGoodsSkuListPrice($goods_sku_list);
        $count_point_exchange = 0;
        foreach ($cart_list as $k => $v) {
            if ($v["point_exchange_type"] == 1) {
                if ($v["point_exchange"] > 0) {
                    $count_point_exchange += $v["point_exchange"] * $v["num"];
                }
            }
        }
        $this->assign("itemlist", $cart_list);
        $this->assign("count_money", sprintf("%.2f", $count_money));
        $this->assign("count_point_exchange", $count_point_exchange); // 总积分
        $this->assign("shopname", $this->shop_name);
        $member = new Member();
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
        $this->assign('goods_sku_list', $goods_sku_list);
        $this->assign("is_calculate_express", $is_calculate_express);
        $this->assign("res_message", $res_message);
        // 计算优惠金额
        $goods_mansong = new GoodsMansong();
        $discount_money = $goods_mansong->getGoodsMansongMoney($goods_sku_list);
        
        $couponlist = '';
        $hongbaolist = '';
        $member_info = $member->getMemberInfo();
        
        // 获取优惠券
        $order_service = new OrderService();
        $coupon_list = $order_service->getMemberCouponList($goods_sku_list);
        // 用户余额
        $member = new MemberService();
        $member_account = $member->getMemberAccount($this->uid, $this->instance_id);
        if ($member_account['balance'] == '' || $member_account['balance'] == 0) {
            $member_account['balance'] = '0.00';
        }
        $this->assign("member_account", $member_account);
        $this->assign("coupon_list", $coupon_list);
        $this->assign("discount_money", sprintf("%.2f", $discount_money));
        $this->assign("express", $express);
        $this->assign("address_default", $address);
        $this->assign("goodslist", $goods_sku_list);
        return view($this->style . '/Order/PaymentOrderNew');
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
        $cart_list["sku_id"] = $sku_info["sku_id"];
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
     * 订单数据存session
     *
     * @return number
     */
    public function orderCreateSession()
    {
        $tag = isset($_POST['tag']) ? $_POST['tag'] : '';
        if (empty($tag)) {
            return - 1;
        }
        if ($tag == 'cart') {
            $_SESSION['order_tag'] = 'cart';
            $_SESSION['cart_list'] = $_POST['cart_id'];
        }
        if ($tag == 'buy_now') {
            $_SESSION['order_tag'] = 'buy_now';
            $_SESSION['order_sku_list'] = $_POST['sku_id'] . ':' . $_POST['num'];
        }
        return 1;
    }

    /**
     * 创建订单
     */
    public function orderCreate()
    {
        $order = new OrderService();
        // 获取支付编号
        $out_trade_no = $order->getOrderTradeNo();
        $use_coupon = $_POST['use_coupon']; // 优惠券
        $use_integration = $_POST['use_integration']; // 积分
        $goods_sku_list = isset($_POST['goodslist']) ? $_POST['goodslist'] : '';
        $leavemessage = isset($_POST['leavemessage']) ? $_POST['leavemessage'] : '';
        $member_balance = isset($_POST["member_balance"]) ? $_POST["member_balance"] : 0; // 使用余额
        $member = new Member();
        $address = $member->getDefaultExpressAddress();
        $express = $order->getExpressFee($goods_sku_list, $address['province'], $address['city']);
        $shipping_time = date("Y-m-d H::i:s", time());
        $order_id = $order->orderCreate('1', $out_trade_no, 1, 1, '1', 1, $leavemessage, '', $shipping_time, $address['mobile'], $address['province'], $address['city'], $address['district'], $address['address'], $address['zip_code'], $address['consigner'], $use_integration, $use_coupon, 0, $goods_sku_list, $member_balance);
        if ($order_id > 0) {
            $order->deleteCart($goods_sku_list, $this->uid);
            $_SESSION['order_tag'] = ""; // 生成订单后，清除购物车
            return AjaxReturn($out_trade_no);
        } else {
            return AjaxReturn($order_id);
        }
    }

    /**
     * 获取当前会员的订单列表
     */
    public function myOrderList()
    {
        $status = isset($_GET['status']) ? $_GET['status'] : 'all';
        if (request()->isAjax()) {
            $status = isset($_POST['status']) ? $_POST['status'] : 'all';
            $condition['buyer_id'] = $this->uid;
            
            if (! empty($this->shop_id)) {
                $condition['shop_id'] = $this->shop_id;
            }
            
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
                            [
                                - 1,
                                - 2,
                                4
                            ]
                        );
                        break;
                }
            }
            // 还要考虑状态逻辑
            
            $order = new OrderService();
            $order_list = $order->getOrderList(1, 0, $condition, 'create_time desc');
            return $order_list['data'];
        } else {
            $this->assign("status", $status);
            return view($this->style . '/Order/myOrderList');
        }
    }

    /**
     * 订单详情
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function orderDetail()
    {
        $order_id = isset($_GET['orderId']) ? $_GET['orderId'] : 0;
        if ($order_id == 0) {
            $this->error("没有获取到订单信息");
        }
        $order_service = new OrderService();
        $detail = $order_service->getOrderDetail($order_id);
        if (empty($detail)) {
            $this->error("没有获取到订单信息");
        }
        $detail['discount_amount'] = $detail['coupon_money'] + $detail['promotion_money'];
        $this->assign("order", $detail);
        return view($this->style . '/Order/orderDetail');
    }

    /**
     * 订单项退款详情
     */
    public function refundDetail()
    {
        $order_goods_id = isset($_GET['order_goods_id']) ? $_GET['order_goods_id'] : 0;
        if ($order_goods_id == 0) {
            $this->error("没有获取到退款信息");
        }
        $order_service = new OrderService();
        $detail = $order_service->getOrderGoodsRefundInfo($order_goods_id);
        $this->assign("order_refund", $detail);
        $refund_money = $order_service->orderGoodsRefundMoney($order_goods_id);
        $this->assign('refund_money', $refund_money);
        $this->assign("detail", $detail);
        // 查询店铺默认物流地址
        $express = new Express();
        $address = $express->getDefaultShopExpressAddress($this->instance_id);
        $this->assign("address_info", $address);
        return view($this->style . '/Order/refundDetail');
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

    /**
     * 交易关闭
     */
    public function orderClose()
    {
        $order_service = new OrderService();
        $order_id = $_POST['order_id'];
        $res = $order_service->orderClose($order_id);
        return AjaxReturn($res);
    }

    /**
     * 订单后期支付页面
     */
    public function orderPay()
    {
        $order_id = isset($_GET['id']) ? $_GET['id'] : 0;
        $out_trade_no = isset($_GET['out_trade_no']) ? $_GET['out_trade_no'] : 0;
        $order_service = new OrderService();
        if ($order_id != 0) {
            // 更新支付流水号
            $new_out_trade_no = $order_service->getOrderNewOutTradeNo($order_id);
            $url = 'http://' . $_SERVER['HTTP_HOST'] . \think\Request::instance()->root() . '/wap/pay/getpayvalue?out_trade_no=' . $new_out_trade_no;
            header("Location: " . $url);
            exit();
        } else {
            // 待结算订单处理
            if ($out_trade_no != 0) {
                $url = 'http://' . $_SERVER['HTTP_HOST'] . \think\Request::instance()->root() . '/wap/pay/getpayvalue?out_trade_no=' . $out_trade_no;
                exit();
            } else {
                $this->error("没有获取到支付信息");
            }
        }
    }

    /**
     * 收货
     */
    public function orderTakeDelivery()
    {
        $order_service = new OrderService();
        $order_id = $_POST['order_id'];
        $res = $order_service->OrderTakeDelivery($order_id);
        return AjaxReturn($res);
    }
}