<?php
/**
 * Order.php
 *
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
namespace data\service\niushop;

/**
 * 订单
 */
use data\api\niushop\IOrder as IOrder;
use data\model\niushop\NsCartModel;
use data\model\niushop\NsGoodsEvaluateModel;
use data\model\niushop\NsGoodsModel;
use data\model\niushop\NsOrderGoodsModel;
use data\model\niushop\NsOrderModel;
use data\model\niushop\NsShopModel;
use data\model\system\AlbumPictureModel;
use data\model\system\CityModel;
use data\model\system\DistrictModel;
use data\model\system\ProvinceModel;
use data\service\BaseService;
use data\service\niufenxiao\NfxCommissionCalculate;
use data\service\niufenxiao\NfxUser;
use data\service\niushop\Order\Order as OrderBusiness;
use data\service\niushop\Order\OrderAccount;
use data\service\niushop\Order\OrderExpress;
use data\service\niushop\Order\OrderGoods;
use data\service\niushop\Order\OrderStatus;
use data\service\niushop\promotion\GoodsExpress;
use data\service\niushop\promotion\GoodsPreference;
use data\service\niushop\shopaccount\ShopAccount;
use data\service\niushop\GoodsCalculate\GoodsCalculate;
use data\model\niushop\NsShopOrderReturnModel;
use data\service\niubusiness\NbsBusinessAssistantAccount;
use data\model\niubusiness\NbsCommissionBusinessAssistantOrderModel;

class Order extends BaseService implements IOrder
{

    function __construct()
    {
        parent::__construct();
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::getOrderDetail()
     */
    public function getOrderDetail($order_id)
    {
        // 查询主表信息
        $order = new OrderBusiness();
        $detail = $order->getDetail($order_id);
        return $detail;
        // TODO Auto-generated method stub
    }

    /**
     * 获取订单基础信息
     * 
     * @param unknown $order_id            
     */
    public function getOrderInfo($order_id)
    {
        $order_model = new NsOrderModel();
        $order_info = $order_model->get($order_id);
        return $order_info;
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::getOrderList()
     */
    public function getOrderList($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        $order_model = new NsOrderModel();
        // 查询主表
        $order_list = $order_model->pageQuery($page_index, $page_size, $condition, $order, '*');
        
        if (! empty($order_list['data'])) {
            foreach ($order_list['data'] as $k => $v) {
                // 查询订单项表
                $order_item = new NsOrderGoodsModel();
                $order_item_list = $order_item->where([
                    'order_id' => $v['order_id']
                ])->select();
                
                $province_name = "";
                $city_name = "";
                $district_name = "";
                
                $province = new ProvinceModel();
                $province_info = $province->getInfo(array(
                    "province_id" => $v["receiver_province"]
                ), "*");
                if (count($province_info) > 0) {
                    $province_name = $province_info["province_name"];
                }
                $order_list['data'][$k]['receiver_province_name'] = $province_name;
                $city = new CityModel();
                $city_info = $city->getInfo(array(
                    "city_id" => $v["receiver_city"]
                ), "*");
                if (count($city_info) > 0) {
                    $city_name = $city_info["city_name"];
                }
                $order_list['data'][$k]['receiver_city_name'] = $city_name;
                $district = new DistrictModel();
                $district_info = $district->getInfo(array(
                    "district_id" => $v["receiver_district"]
                ), "*");
                if (count($district_info) > 0) {
                    $district_name = $district_info["district_name"];
                }
                $order_list['data'][$k]['receiver_district_name'] = $district_name;
                foreach ($order_item_list as $key_item => $v_item) {
                    $picture = new AlbumPictureModel();
                    $order_item_list[$key_item]['picture'] = $picture->get($v_item['goods_picture']);
                    if ($v_item['refund_status'] != 0) {
                        $order_refund_status = OrderStatus::getRefundStatus();
                        foreach ($order_refund_status as $k_status => $v_status) {
                            
                            if ($v_status['status_id'] == $v_item['refund_status']) {
                                $order_item_list[$key_item]['refund_operation'] = $v_status['refund_operation'];
                                $order_item_list[$key_item]['status_name'] = $v_status['status_name'];
                            }
                        }
                    } else {
                        $order_item_list[$key_item]['refund_operation'] = '';
                        $order_item_list[$key_item]['status_name'] = '';
                    }
                }
                $order_list['data'][$k]['order_item_list'] = $order_item_list;
                $order_list['data'][$k]['operation'] = '';
                $order_status = OrderStatus::getOrderCommonStatus();
                // 查询订单操作
                foreach ($order_status as $k_status => $v_status) {
                    
                    if ($v_status['status_id'] == $v['order_status']) {
                        $order_list['data'][$k]['operation'] = $v_status['operation'];
                        $order_list['data'][$k]['member_operation'] = $v_status['member_operation'];
                        $order_list['data'][$k]['status_name'] = $v_status['status_name'];
                        $order_list['data'][$k]['is_refund'] = $v_status['is_refund'];
                    }
                }
            }
        }
        return $order_list;
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderCreate()
     */
    public function orderCreate($order_type, $out_trade_no, $pay_type, $shipping_type, $order_from, $buyer_ip, $buyer_message, $buyer_invoice, $shipping_time, $receiver_mobile, $receiver_province, $receiver_city, $receiver_district, $receiver_address, $receiver_zip, $receiver_name, $point, $coupon_id, $user_money, $goods_sku_list, $platform_money, $coin = 0)
    {
        $order = new OrderBusiness();
        $retval = $order->orderCreate($order_type, $out_trade_no, $pay_type, $shipping_type, $order_from, $buyer_ip, $buyer_message, $buyer_invoice, $shipping_time, $receiver_mobile, $receiver_province, $receiver_city, $receiver_district, $receiver_address, $receiver_zip, $receiver_name, $point, $coupon_id, $user_money, $goods_sku_list, $platform_money, $coin);
        return $retval;
        // TODO Auto-generated method stub
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \data\api\niushop\IOrder::getOrderTradeNo()
     */
    public function getOrderTradeNo()
    {
        $order = new OrderBusiness();
        $no = $order->createOutTradeNo();
        return $no;
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderDelivery()
     */
    public function orderDelivery($order_id, $order_goods_id_array, $express_name, $shipping_type, $express_company_id, $express_no)
    {
        $order_express = new OrderExpress();
        $retval = $order_express->delivey($order_id, $order_goods_id_array, $express_name, $shipping_type, $express_company_id, $express_no);
        return $retval;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderGoodsDelivery()
     */
    public function orderGoodsDelivery($order_id, $order_goods_id_array)
    {
        $order_goods = new OrderGoods();
        $retval = $order_goods->orderGoodsDelivery($order_id, $order_goods_id_array);
        return $retval;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderClose()
     */
    public function orderClose($order_id)
    {
        $order = new OrderBusiness();
        $retval = $order->orderClose($order_id);
        return $retval;
        // TODO Auto-generated method stub
    }

    /*
     * 订单完成的函数
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderComplete()
     */
    public function orderComplete($orderid)
    {
        $order = new OrderBusiness();
        $retval = $order->orderComplete($orderid);
        // 结算订单的分销佣金
        $this->updateOrderCommission($orderid);
        //处理店铺的账户资金
        $this->dealShopAccount_OrderComplete("", $orderid);
        //处理平台的账户资金
        $this->updateAccountOrderComplete($orderid);
        
        return $retval;
        // TODO Auto-generated method stub
    }
    /*
     * 订单在线支付
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderOnLinePay()
     */
    public function orderOnLinePay($order_pay_no, $pay_type)
    {
        $order = new OrderBusiness();
        $retval = $order->OrderPay($order_pay_no, $pay_type, 0);
        if ($retval > 0) {
             #计算店铺内部的分销佣金
             $this->orderCommissionCalculate($order_pay_no);
             //处理店铺的账户资金
             $this->dealShopAccount_OrderPay($order_pay_no);
        }
        return $retval;
        // TODO Auto-generated method stub
    }

    /*
     * 订单线下支付
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderOffLinePay()
     */
    public function orderOffLinePay($order_id, $pay_type, $status)
    {
        $order = new OrderBusiness();
        
        $new_no = $this->getOrderNewOutTradeNo($order_id);
        if ($new_no) {
            $retval = $order->OrderPay($new_no, $pay_type, $status);
            if ($retval > 0) {
                $pay = new UnifyPay();
                $pay->offLinePay($new_no, $pay_type);
                #计算店铺的佣金情况
                $this->orderCommissionCalculate('', $order_id);
                //处理店铺的账户资金
                $this->dealShopAccount_OrderPay('', $order_id);
                //处理平台的资金账户
                $this->dealPlatformAccountOrderPay('', $order_id);
            }
            return $retval;
        } else {
            return 0;
        }
        // TODO Auto-generated method stub
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \data\api\niushop\IOrder::getOrderNewOutTradeNo()
     */
    public function getOrderNewOutTradeNo($order_id)
    {
        $order_model = new NsOrderModel();
        $out_trade_no = $order_model->getInfo([
            'order_id' => $order_id
        ], 'out_trade_no');
        $order = new OrderBusiness();
        $new_no = $order->createNewOutTradeNo($order_id);
        $pay = new UnifyPay();
        $pay->modifyNo($out_trade_no['out_trade_no'], $new_no);
        return $new_no;
    }

    /**
     * 订单调整金额(non-PHPdoc)
     * 
     * @see \data\api\niushop\IOrder::orderMoneyAdjust()
     */
    public function orderMoneyAdjust($order_id, $order_goods_id_adjust_array, $shipping_fee)
    {
        // 调整订单
        $order_goods = new OrderGoods();
        $retval = $order_goods->orderGoodsAdjustMoney($order_goods_id_adjust_array);
        
        if ($retval >= 0) {
            // 计算整体商品调整金额
            $new_no = $this->getOrderNewOutTradeNo($order_id);
            $order = new OrderBusiness();
            $order_goods_money = $order->getOrderGoodsMoney($order_id);
            $retval_order = $order->orderAdjustMoney($order_id, $order_goods_money, $shipping_fee);
            $order_model = new NsOrderModel();
            $order_money = $order_model->getInfo([
                'order_id' => $order_id
            ], 'pay_money');
            $pay = new UnifyPay();
            $pay->modifyPayMoney($new_no, $order_money['pay_money']);
            return $retval_order;
        } else {
            return $retval;
        }
    }

    /**
     * 查询订单
     * 
     * {@inheritdoc}
     *
     * @see \data\api\niushop\IOrder::orderQuery()
     */
    public function orderQuery($where = "", $field = "*")
    {
        $order = new OrderBusiness();
        return $order->where($where)
            ->field($field)
            ->select();
    }

    /**
     * 查询订单项退款信息(non-PHPdoc)
     * 
     * @see \data\api\niushop\IOrder::getOrderGoodsRefundInfo()
     */
    public function getOrderGoodsRefundInfo($order_goods_id)
    {
        $order_goods = new OrderGoods();
        $order_goods_info = $order_goods->getOrderGoodsRefundDetail($order_goods_id);
        return $order_goods_info;
    }

    public function test()
    {
        // $res = $order_express->getSkuGroup('466:1,467:2,468:2,462:1');
        // $res = $order_express->getGoodsShippingExpressFee(1, 5, 1, 22);
        // $res = $order_express->getSkuListExpressFee('466:1,467:2,468:2,462:1', 1, 22);
        // $res = $order_express->getGoodsSkuListPrice('466:1,467:2,468:2,462:1');
        /*
         * $order_goods = new OrderGoods();
         * $res = $order_goods->addOrderGoods(12, '466:1,467:2,468:2');
         */
        // 订单创建
        /*
         * $order = new OrderBusiness();
         * $res = $order->orderCreate(1, '20161120811565', 1, 1, 1, '127.0.0.1', '', '', '0000-0-0', '15234151502', 4, 14, 209, '小店', '', '测试', 0, 527, 0, '443:2,445:5,467:2');
         * return $res;
         */
        /*
         * //订单发货
         * $order_express = new OrderExpress();
         * $res = $order_express->delivey(3, '16,17', "测试包裹", 1, 1, 'as0000100');
         */
        /*
         * $order = new OrderBusiness();
         * $res = $order->addOrderAction(3, 1, '订单发货');
         * /* //订单关闭
         * $order = new OrderBusiness();
         * $res = $order->orderClose(4);
         * return $res;
         */
        /*
         * //线下支付
         * $res = $this->orderOffLinePay(4, 1, 0);
         * return $res;
         */
        /*
         * //线上支付
         * $res = $this->orderOnLinePay('1481177387568', 2);
         * return $res;
         */
        $order_goods = new OrderGoods();
        $res = $order_goods->orderGoodsRefundAskfor(71, 162, 1, 1, '不想买');
        return $res;
        // 调整金额
        /*
         * $res = $this->orderMoneyAdjust(24, '52,-20;53,-20', 5);
         * return $res;
         */
        /*
         * //计算退款实际可退金额
         * $order_goods = new OrderGoods();
         * $res = $order_goods->orderGoodsRefundMoney(37);
         * return $res;
         */
        /*
         * $order = new GoodsPreference();
         * $order->
         */
        /*
         * $goods_mansong = new GoodsMansong();
         * $mansong_array = $goods_mansong->getGoodsSkuListMansong('443:2,445:5,467:2');
         * return $mansong_array;
         */
    }

    /**
     * 查询订单的订单项列表
     * 
     * @param unknown $order_id            
     */
    public function getOrderGoods($order_id)
    {
        $order = new OrderBusiness();
        return $order->getOrderGoods($order_id);
    }

    /**
     * 查询订单的订单项列表
     * 
     * @param unknown $order_id            
     */
    public function getOrderGoodsInfo($order_goods_id)
    {
        $order = new OrderBusiness();
        $picture = new AlbumPictureModel();
        $order_goods_info = $order->getOrderGoodsInfo($order_goods_id);
        $order_goods_info['goods_picture'] = $picture->get($order_goods_info['goods_picture'])['pic_cover'];
        return $order_goods_info;
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::addOrder()
     */
    public function addOrder($data)
    {
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderGoodsRefundAskfor()
     */
    public function orderGoodsRefundAskfor($order_id, $order_goods_id, $refund_type, $refund_require_money, $refund_reason)
    {
        $order_goods = new OrderGoods();
        $retval = $order_goods->orderGoodsRefundAskfor($order_id, $order_goods_id, $refund_type, $refund_require_money, $refund_reason);
        return $retval;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderGoodsCancel()
     */
    public function orderGoodsCancel($order_id, $order_goods_id)
    {
        $order_goods = new OrderGoods();
        $retval = $order_goods->orderGoodsCancel($order_id, $order_goods_id);
        return $retval;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderGoodsReturnGoods()
     */
    public function orderGoodsReturnGoods($order_id, $order_goods_id, $refund_shipping_company, $refund_shipping_code)
    {
        $order_goods = new OrderGoods();
        $retval = $order_goods->orderGoodsReturnGoods($order_id, $order_goods_id, $refund_shipping_company, $refund_shipping_code);
        return $retval;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderGoodsRefundAgree()
     */
    public function orderGoodsRefundAgree($order_id, $order_goods_id)
    {
        $order_goods = new OrderGoods();
        $retval = $order_goods->orderGoodsRefundAgree($order_id, $order_goods_id);
        return $retval;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderGoodsRefuseForever()
     */
    public function orderGoodsRefuseForever($order_id, $order_goods_id)
    {
        $order_goods = new OrderGoods();
        $retval = $order_goods->orderGoodsRefuseForever($order_id, $order_goods_id);
        return $retval;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderGoodsRefuseOnce()
     */
    public function orderGoodsRefuseOnce($order_id, $order_goods_id)
    {
        $order_goods = new OrderGoods();
        $retval = $order_goods->orderGoodsRefuseOnce($order_id, $order_goods_id);
        return $retval;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderGoodsConfirmRecieve()
     */
    public function orderGoodsConfirmRecieve($order_id, $order_goods_id)
    {
        $order_goods = new OrderGoods();
        $retval = $order_goods->orderGoodsConfirmRecieve($order_id, $order_goods_id);
        return $retval;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::orderGoodsConfirmRefund()
     */
    public function orderGoodsConfirmRefund($order_id, $order_goods_id, $refund_real_money)
    {
        $order_goods = new OrderGoods();
        $retval = $order_goods->orderGoodsConfirmRefund($order_id, $order_goods_id, $refund_real_money);
        // 重新计算订单的佣金情况
        $this->updateCommissionMoney($order_id, $order_goods_id);
        $this->updateOrderCommission($order_id);
        //计算店铺的账户
        $this->updateShopAccount_OrderRefund($order_goods_id);
        $this->updateShopAccount_OrderComplete($order_id);
        //计算平台的账户
        $this->updateAccountOrderRefund($order_goods_id);
        $this->updateAccountOrderComplete($order_id);
        return $retval;
    }

    /**
     * 获取对应sku列表价格
     * 
     * @param unknown $goods_sku_list            
     */
    public function getGoodsSkuListPrice($goods_sku_list)
    {
        $goods_preference = new GoodsPreference();
        $money = $goods_preference->getGoodsSkuListPrice($goods_sku_list);
        return $money;
    }

    /**
     * 获取邮费
     * 
     * @param unknown $goods_sku_list            
     * @param unknown $province            
     * @param unknown $city            
     * @return Ambigous <unknown, number>
     */
    public function getExpressFee($goods_sku_list, $province, $city)
    {
        $goods_express = new GoodsExpress();
        $fee = $goods_express->getSkuListExpressFee($goods_sku_list, $province, $city);
        return $fee;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \data\api\niushop\IOrder::orderGoodsRefundMoney()
     */
    public function orderGoodsRefundMoney($order_goods_id)
    {
        $order_goods = new OrderGoods();
        $money = $order_goods->orderGoodsRefundMoney($order_goods_id);
        return $money;
    }

    /**
     * 获取用户可使用优惠券
     * 
     * @param unknown $goods_sku_list            
     */
    public function getMemberCouponList($goods_sku_list)
    {
        $goods_preference = new GoodsPreference();
        $coupon_list = $goods_preference->getMemberCouponList($goods_sku_list);
        return $coupon_list;
    }

    /**
     * 查询商品列表可用积分数
     * 
     * @param unknown $goods_sku_list            
     */
    public function getGoodsSkuListUsePoint($goods_sku_list)
    {
        $point = 0;
        $goods_sku_list_array = explode(",", $goods_sku_list);
        foreach ($goods_sku_list_array as $k => $v) {
            
            $sku_data = explode(':', $v);
            $sku_id = $sku_data[0];
            $goods = new Goods();
            $goods_id = $goods->getGoodsId($sku_id);
            $goods_model = new NsGoodsModel();
            $point_use = $goods_model->getInfo([
                'goods_id' => $goods_id
            ], 'point_exchange_type,point_exchange');
            if ($point_use['point_exchange_type'] == 1) {
                $point += $point_use['point_exchange'];
            }
        }
        return $point;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \data\api\niushop\IOrder::OrderTakeDelivery()
     */
    public function OrderTakeDelivery($order_id)
    {
        $order = new OrderBusiness();
        $res = $order->OrderTakeDelivery($order_id);
        return $res;
    }

    /**
     * 删除购物车中的数据
     * (non-PHPdoc)
     * 
     * @see \data\api\niushop\IOrder::deleteCart()
     */
    public function deleteCart($goods_sku_list, $uid)
    {
        $cart = new NsCartModel();
        $goods_sku_list_array = explode(",", $goods_sku_list);
        foreach ($goods_sku_list_array as $k => $v) {
            $sku_data = explode(':', $v);
            $sku_id = $sku_data[0];
            $cart->destroy([
                'buyer_id' => $uid,
                'sku_id' => $sku_id
            ]);
        }
        $_SESSION["user_cart"] = '';
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \data\api\niushop\IOrder::getOrderCount()
     */
    public function getOrderCount($condition)
    {
        $order = new NsOrderModel();
        $count = $order->where($condition)->count();
        return $count;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \data\api\niushop\IOrder::getPayMoneySum()
     */
    public function getPayMoneySum($condition, $date)
    {
        $order_model = new NsOrderModel();
        $money_sum = $order_model->where($condition)
            ->whereTime('create_time', $date)
            ->sum('pay_money');
        return $money_sum;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \data\api\niushop\IOrder::getGoodsNumSum()
     */
    public function getGoodsNumSum($condition, $date)
    {
        $order_model = new NsOrderModel();
        $order_list = $order_model->where($condition)
            ->whereTime('create_time', $date)
            ->select();
        $goods_sum = 0;
        foreach ($order_list as $k => $v) {
            $order_goods = new NsOrderGoodsModel();
            $goods_sum += $order_goods->where([
                'order_id' => $v['order_id']
            ])->sum('num');
        }
        return $goods_sum;
    }

    /**
     * 获取具体配送状态信息
     * 
     * @param unknown $shipping_status_id            
     * @return Ambigous <NULL, multitype:string >
     */
    public static function getShippingInfo($shipping_status_id)
    {
        $shipping_status = OrderStatus::getShippingStatus();
        $info = null;
        foreach ($shipping_status as $shipping_info) {
            if ($shipping_status_id == $shipping_info['shipping_status']) {
                $info = $shipping_info;
                break;
            }
        }
        return $info;
    }

    /**
     * 获取具体支付状态信息
     * 
     * @param unknown $pay_status_id            
     * @return multitype:multitype:string |string
     */
    public static function getPayStatusInfo($pay_status_id)
    {
        $pay_status = OrderStatus::getPayStatus();
        $info = null;
        foreach ($pay_status as $pay_info) {
            if ($pay_status_id == $pay_info['pay_status']) {
                $info = $pay_info;
                break;
            }
        }
        return $info;
    }

    /**
     * 获取订单各状态数量
     */
    public static function getOrderStatusNum($condition = '')
    {
        $order = new NsOrderModel();
        $orderStatusNum['all'] = $order->where($condition)->count(); // 全部
        $condition['order_status'] = 0; // 待付款
        $orderStatusNum['wait_pay'] = $order->where($condition)->count();
        $condition['order_status'] = 1; // 待发货
        $orderStatusNum['wait_delivery'] = $order->where($condition)->count();
        $condition['order_status'] = 2; // 待收货
        $orderStatusNum['wait_recieved'] = $order->where($condition)->count();
        $condition['order_status'] = 3; // 已收货
        $orderStatusNum['recieved'] = $order->where($condition)->count();
        $condition['order_status'] = 4; // 交易成功
        $orderStatusNum['success'] = $order->where($condition)->count();
        $condition['order_status'] = 5; // 已关闭
        $orderStatusNum['closed'] = $order->where($condition)->count();
        $condition['order_status'] = - 1; // 退款中
        $orderStatusNum['refunding'] = $order->where($condition)->count();
        $condition['order_status'] = - 2; // 已退款
        $orderStatusNum['refunded'] = $order->where($condition)->count();
        $condition['order_status'] = 3; // 已收货
        $condition['is_evaluate'] = 0; // 未评价
        $orderStatusNum['wait_evaluate'] = $order->where($condition)->count(); // 待评价
        
        return $orderStatusNum;
    }

    /**
     * 商品评价-添加
     * 
     * @param unknown $dataList
     *            评价内容的 数组
     * @return Ambigous <multitype:, \think\false>
     */
    public function addGoodsEvaluate($dataArr, $order_id)
    {
        $goodsEvaluate = new NsGoodsEvaluateModel();
        $goods = new NsGoodsModel();
        $res = $goodsEvaluate->saveAll($dataArr);
        $result = false;
        
        if ($res != false) {
            // 修改订单评价状态
            $order = new NsOrderModel();
            $data = array(
                'is_evaluate' => 1
            );
            $result = $order->save($data, [
                'order_id' => $order_id
            ]);
        }
        foreach ($dataArr as $item) {
            $good_info = $goods->get($item['goods_id']);
            $evaluates = $good_info['evaluates'] + 1;
            $star = $good_info['star'] + $item['scores'];
            $match_point = $star / $evaluates;
            $match_ratio = $match_point / 5 * 100 + '%';
            $data = array(
                'evaluates' => $evaluates,
                'star' => $star,
                'match_point' => $match_point,
                'match_ratio' => $match_ratio
            );
            $goods->update($data, [
                'goods_id' => $item['goods_id']
            ]);
        }
        
        return $result;
    }

    /**
     * 商品评价-回复
     * 
     * @param unknown $explain_first
     *            评价内容
     * @param unknown $ordergoodsid
     *            订单项ID
     * @return Ambigous <number, \think\false>
     */
    public function addGoodsEvaluateExplain($explain_first, $order_goods_id)
    {
        $goodsEvaluate = new NsGoodsEvaluateModel();
        $data = array(
            'explain_first' => $explain_first
        );
        return $goodsEvaluate->save($data, [
            'order_goods_id' => $order_goods_id
        ]);
    }

    /**
     * 商品评价-追评
     * 
     * @param unknown $again_content
     *            追评内容
     * @param unknown $againImageList
     *            传入追评图片的 数组
     * @param unknown $ordergoodsid
     *            订单项ID
     * @return Ambigous <number, \think\false>
     */
    public function addGoodsEvaluateAgain($again_content, $againImageList, $order_goods_id)
    {
        $goodsEvaluate = new NsGoodsEvaluateModel();
        $data = array(
            'again_content' => $again_content,
            'again_addtime' => date("Y-m-d H:i:s", time()),
            'again_image' => $againImageList
        );
        return $goodsEvaluate->save($data, [
            'order_goods_id' => $order_goods_id
        ]);
    }

    /**
     * 商品评价-追评回复
     * 
     * @param unknown $again_explain
     *            追评的 回复内容
     * @param unknown $ordergoodsid
     *            订单项ID
     * @return Ambigous <number, \think\false>
     */
    public function addGoodsEvaluateAgainExplain($again_explain, $order_goods_id)
    {
        $goodsEvaluate = new NsGoodsEvaluateModel();
        $data = array(
            'again_explain' => $again_explain
        );
        return $goodsEvaluate->save($data, [
            'order_goods_id' => $order_goods_id
        ]);
    }

    /**
     * 获取指定订单的评价信息
     * 
     * @param unknown $orderid
     *            订单ID
     */
    public function getOrderEvaluateByOrder($order_id)
    {
        $goodsEvaluate = new NsGoodsEvaluateModel();
        $condition['order_id'] = $order_id;
        $field = 'order_id, order_no, order_goods_id, goods_id, goods_name, goods_price, goods_image, shop_id, shop_name, content, addtime, image, explain_first, member_name, uid, is_anonymous, scores, again_content, again_addtime, again_image, again_explain';
        return $goodsEvaluate->getQuery($condition, $field, 'order_goods_id ASC');
    }

    /**
     * 获取指定会员的评价信息
     * 
     * @param unknown $uid
     *            会员ID
     */
    public function getOrderEvaluateByMember($uid)
    {
        $goodsEvaluate = new NsGoodsEvaluateModel();
        $condition['uid'] = $uid;
        $field = 'order_id, order_no, order_goods_id, goods_id, goods_name, goods_price, goods_image, shop_id, shop_name, content, addtime, image, explain_first, member_name, uid, is_anonymous, scores, again_content, again_addtime, again_image, again_explain';
        return $goodsEvaluate->getQuery($condition, $field, 'order_goods_id ASC');
    }

    /**
     * 评价信息 分页
     * 
     * @param unknown $page_index            
     * @param unknown $page_size            
     * @param unknown $condition            
     * @param unknown $order            
     * @return number
     */
    public function getOrderEvaluateDataList($page_index, $page_size, $condition, $order)
    {
        $goodsEvaluate = new NsGoodsEvaluateModel();
        return $goodsEvaluate->pageQuery($page_index, $page_size, $condition, $order, "*");
    }

    /**
     * 获取评价列表
     * 
     * @param unknown $page_index
     *            页码
     * @param unknown $page_size
     *            页大小
     * @param unknown $condition
     *            条件
     * @param unknown $order
     *            排序
     * @return multitype:number unknown
     */
    public function getOrderEvaluateList($page_index, $page_size, $condition, $order)
    {
        $goodsEvaluate = new NsGoodsEvaluateModel();
        $field = 'order_id, order_no, order_goods_id, goods_id, goods_name, goods_price, goods_image, shop_id, shop_name, content, addtime, image, explain_first, member_name, uid, is_anonymous, scores, again_content, again_addtime, again_image, again_explain';
        return $goodsEvaluate->pageQuery($page_index, $page_size, $condition, $order, $field);
    }

    /**
     * 修改订单数据
     * 
     * @param unknown $order_id            
     * @param unknown $data            
     */
    public function modifyOrderInfo($data, $order_id)
    {
        $order = new NsOrderModel();
        return $order->save($data, [
            'order_id' => $order_id
        ]);
    }
    /**
     * 判断店铺类型
     * 
     * @param unknown $shop_id            
     */
    private function getShopTypeDetail($shop_id)
    {
        $shop_model = new NsShopModel();
        $shop_detail = $shop_model->get($shop_id);
        if (empty($shop_detail)) {
            return 0;
        } else {
            return $shop_detail["shop_type"];
        }
    }
    /**
     * (non-PHPdoc)
     * 
     * @see \data\api\niushop\IOrder::getShopOrderAccountList()
     */
    public function getShopOrderAccountList($shop_id, $start_time, $end_time, $page_index, $page_size)
    {
        $order_account = new OrderAccount();
        $list = $order_account->getShopOrderSumList($shop_id, $start_time, $end_time, $page_index, $page_size);
        return $list;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \data\api\niushop\IOrder::getShopOrderRefundList()
     */
    public function getShopOrderRefundList($shop_id, $start_time, $end_time, $page_index, $page_size)
    {
        $order_account = new OrderAccount();
        $list = $order_account->getShopOrderRefundList($shop_id, $start_time, $end_time, $page_index, $page_size);
        return $list;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \data\api\niushop\IOrder::getShopOrderStatics()
     */
    public function getShopOrderStatics($shop_id, $start_time, $end_time)
    {
        $order_account = new OrderAccount();
        $order_sum = $order_account->getShopOrderSum($shop_id, $start_time, $end_time);
        $order_refund_sum = $order_account->getShopOrderSumRefund($shop_id, $start_time, $end_time);
        $order_sum_account = $order_sum - $order_refund_sum;
        $array = array(
            'order_sum' => $order_sum,
            'order_refund_sum' => $order_refund_sum,
            'order_account' => $order_sum_account
        );
        return $array;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \data\api\niushop\IOrder::getShopOrderAccountDetail()
     */
    public function getShopOrderAccountDetail($shop_id)
    {
        // 获取总销售统计
        $account_all = $this->getShopOrderStatics($shop_id, '2015-1-1', '3050-1-1');
        // 获取今日销售统计
        $date_day_start = date("Y-m-d", time());
        $date_day_end = date("Y-m-d H:i:s", time());
        $account_day = $this->getShopOrderStatics($shop_id, $date_day_start, $date_day_end);
        // 获取周销售统计（7天）
        $date_week_start = date('Y-m-d', strtotime('-7 days'));
        $date_week_end = $date_day_end;
        $account_week = $this->getShopOrderStatics($shop_id, $date_week_start, $date_week_end);
        // 获取月销售统计(30天)
        $date_month_start = date('Y-m-d', strtotime('-30 days'));
        $date_month_end = $date_day_end;
        $account_month = $this->getShopOrderStatics($shop_id, $date_month_start, $date_month_end);
        $array = array(
            'day' => $account_day,
            'week' => $account_week,
            'month' => $account_month,
            'all' => $account_all
        );
        return $array;
    }
    /*
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IOrder::getShopAccountCountInfo()
     */
    public function getShopAccountCountInfo($shop_id){
        //本月第一天
        $date_month_start = date('Y-m-d', strtotime('-30 days'));
        $date_month_end = date("Y-m-d H:i:s", time());
        //下单金额
        $order_account = new OrderAccount();
        $condition["create_time"] = [[ ">=",$date_month_start],["<=",$date_month_end]];
        $condition['order_status']= array('NEQ', 0);
        $condition['order_status']= array('NEQ', 5);
        if($shop_id != 0)
        {
            $condition['shop_id']= array('NEQ', 0);
        }
        $order_money = $order_account->getShopSaleSum($condition);
     //   var_dump($order_money);
        //下单会员
        $order_user_num = $order_account->getShopSaleUserSum($condition);
        //下单量
        $order_num = $order_account->getShopSaleNumSum($condition);
        //下单商品数
        $order_goods_num = $order_account->getShopSaleGoodsNumSum($condition);
        //平均客单价
        if($order_num > 0){
            $user_money_average = $order_money/$order_user_num;            
        }else{
            $user_money_average = 0;
        }
        //平均价格
        if($order_goods_num > 0){
            $goods_money_average = $order_money/$order_goods_num;
        }else{
            $goods_money_average = 0;
        }
        $array = array(
            "order_money" =>sprintf('%.2f', $order_money),
            "order_user_num" =>$order_user_num,
            "order_num" =>$order_num,
            "order_goods_num" =>$order_goods_num,
            "user_money_average" =>sprintf('%.2f', $user_money_average),
            "goods_money_average" =>sprintf('%.2f', $goods_money_average)
        );
        return $array;        
    }
    /*
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IOrder::getShopGoodsSalesList()
     */
    public function getShopGoodsSalesList($page_index = 1, $page_size = 0, $condition = '', $order = ''){
//         $goods_calculate = new GoodsCalculate();
//         $goods_sales_list = $goods_calculate->getGoodsSalesInfoList($page_index, $page_size , $condition , $order );
//         return $goods_sales_list;
        
        $goods_model = new NsGoodsModel();
        $goods_list = $goods_model->pageQuery($page_index, $page_size, $condition, $order, '*');
        //条件
        $start_date = date('Y-m-d', strtotime('-30 days'));
        $end_date = date("Y-m-d H:i:s", time());
        $condition['create_time'] = [
            'between',
            [
                $start_date,
                $end_date
            ]
        ];
        $order_condition["shop_id"]=$condition["shop_id"];
        $goods_calculate = new GoodsCalculate();
        //得到条件内的订单项
        $order_goods_list = $goods_calculate->getOrderGoodsSelect($order_condition);
        //遍历商品
        foreach($goods_list["data"] as $k=>$v){
            $data= array();
            $goods_sales_num = $goods_calculate->getGoodsSalesNum($order_goods_list, $v["goods_id"]);
            $goods_sales_money = $goods_calculate->getGoodsSalesMoney($order_goods_list, $v["goods_id"]);
            $data["sales_num"] =  $goods_sales_num;
            $data["sales_money"] =  $goods_sales_money;
            $goods_list["data"][$k]["sales_info"] = $data;
        }
        return $goods_list;
    }
	

	/* (non-PHPdoc)
     * @see \data\api\niushop\IOrder::getShopGoodsSalesAll()
     */
    public function getShopGoodsSalesQuery($shop_id, $start_date, $end_date,$condition)
    {
        // TODO Auto-generated method stub
        //商品
        $goods_model = new NsGoodsModel();
        $goods_list = $goods_model->getQuery($condition, "*", '');
        //订单项
        $condition['create_time'] = [
            'between',
            [
                $start_date,
                $end_date
            ]
        ];
        $order_condition["create_time"] = [[">=",$start_date ],["<=",$end_date ]];
        if($shop_id != ''){
            $order_condition["shop_id"]=$shop_id;            
        }
        $goods_calculate = new GoodsCalculate();
        $order_goods_list = $goods_calculate->getOrderGoodsSelect($order_condition);
        //遍历商品
        foreach($goods_list as $k=>$v){
            $data= array();
            $goods_sales_num = $goods_calculate->getGoodsSalesNum($order_goods_list, $v["goods_id"]);
            $goods_sales_money = $goods_calculate->getGoodsSalesMoney($order_goods_list, $v["goods_id"]);
            $goods_list[$k]["sales_num"] =  $goods_sales_num;
            $goods_list[$k]["sales_money"] =  $goods_sales_money;           
        }
        return $goods_list;
        
    }
    /**
     * 查询一段时间内的店铺下单金额
     * @param unknown $shop_id
     * @param unknown $start_date
     * @param unknown $end_date
     * @return Ambigous <\data\service\niushop\Order\unknown, number, unknown>
     */
    public function getShopSaleSum($condition){
        $order_account = new OrderAccount();
        $sales_num =$order_account->getShopSaleSum($condition);
        return $sales_num;
    }
    /**
     * 查询一段时间内的店铺下单量
     * @param unknown $shop_id
     * @param unknown $start_date
     * @param unknown $end_date
     * @return unknown
     */
    public function getShopSaleNumSum($condition){
        $order_account = new OrderAccount();
        $sales_num =$order_account->getShopSaleNumSum($condition);
        return $sales_num;
    }
    
    /*************************************************店铺账户--Start*******************************************************/
    /**
     * 订单支付的时候  调整店铺账户
     * @param string $order_out_trade_no
     * @param number $order_id
     */
    private function dealShopAccount_OrderPay($order_out_trade_no = "", $order_id = 0)
    {
        if(NS_VERSION==NS_VER_B2B2C_FX1 || NS_VERSION==NS_VER_B2B2C_FX2){
            if ($order_out_trade_no != "" && $order_id == 0) {
                $order_model = new NsOrderModel();
                $condition = " order_out_trade_no=" . $order_out_trade_no;
                $order_list = $order_model->getQuery($condition, "order_id", "");
                foreach ($order_list as $k => $v) {
                    $this->updateShopAccount_OrderPay($v["order_id"]);
                }
            } else{
                if ($order_out_trade_no == "" && $order_id != 0) {
                    $this->updateShopAccount_OrderPay($order_id);
                }
            }
        }
        
    }
    /**
     * 订单完成的时候调整账户金额
     * @param string $order_out_trade_no
     * @param number $order_id
     */
    private function dealShopAccount_OrderComplete($order_out_trade_no = "", $order_id = 0){
        if(NS_VERSION==NS_VER_B2B2C_FX1 || NS_VERSION==NS_VER_B2B2C_FX2){
            if ($order_out_trade_no != "" && $order_id == 0) {
                $order_model = new NsOrderModel();
                $condition = " order_out_trade_no=" . $order_out_trade_no;
                $order_list = $order_model->getQuery($condition, "order_id", "");
                foreach ($order_list as $k => $v) {
                    $this->updateShopAccount_OrderComplete($v["order_id"]);
                }
            } else{
                if ($order_out_trade_no == "" && $order_id != 0) {
                    $this->updateShopAccount_OrderComplete($order_id);
                }
            }
        }
    }
    /**
     * 订单支付
     * @param unknown $order_id
     */
    private function updateShopAccount_OrderPay($order_id){
        $order_model=new NsOrderModel();
        $shop_account=new ShopAccount();
        $order=new OrderBusiness();
        $order_model->startTrans();
        try {
            $order_obj=$order_model->get($order_id);
            #订单的实际付款金额
            $pay_money=$order->getOrderRealPayMoney($order_id);
            #订单的支付方式
            $payment_type=$order_obj["payment_type"];
            #店铺id
            $shop_id=$order_obj["shop_id"];
            #订单号
            $order_no=$order_obj["order_no"];
            #处理订单的营业总额
            $shop_account->addShopAccountProfitRecords(getSerialNo(), $shop_id, $pay_money, 1, $order_id, "店铺订单支付金额".$pay_money."元, 订单号为：".$order_no.", 支付方式【线下支付】。");
            if($payment_type!=11){
                #在线支付 处理店铺的入账总额
                $shop_account->addShopAccountMoneyRecords(getSerialNo(), $shop_id, $pay_money, 1, $order_id, "店铺订单支付金额".$pay_money."元, 订单号为：".$order_no.", 支付方式【在线支付】, 已入店铺账户。");
            }
            #处理平台的利润分成
            $shop_account->addShopOrderAccountRecords($order_id, $order_no, $shop_id, $pay_money);
            $order_model->commit();
        } catch (\Exception $e) {
            $order_model->rollback();
        }
    }
    /**
     * 订单项退款
     * @param unknown $order_goods_id
     */
    private function updateShopAccount_OrderRefund($order_goods_id){
        if(NS_VERSION==NS_VER_B2B2C_FX1 || NS_VERSION==NS_VER_B2B2C_FX2){
            $order_goods_model=new NsOrderGoodsModel();
            $order_model=new NsOrderModel();
            $shop_account=new ShopAccount();
            $order_goods_model->startTrans();
            try {
                #查询订单项的信息
                $order_goods_obj=$order_goods_model->get($order_goods_id);
                #退款金额
                $refund_money=$order_goods_obj["refund_real_money"];
                #订单id
                $order_id=$order_goods_obj["order_id"];
                #订单信息
                $order_obj=$order_model->get($order_id);
                #订单的支付方式
                $payment_type=$order_obj["payment_type"];
                #店铺id
                $shop_id=$order_obj["shop_id"];
                #订单号
                $order_no=$order_obj["order_no"];
                #处理店铺的总营业额
                $shop_account->addShopAccountProfitRecords(getSerialNo(), $shop_id, -$refund_money, 2, $order_goods_id, "订单项退款金额".$refund_money."元, 订单号：".$order_no.", 退款方式【线下】。");
                if ($payment_type!=11){
                    #在线支付  处理店铺入账金额
                    $shop_account->addShopAccountMoneyRecords(getSerialNo(), $shop_id, -$refund_money, 2, $order_goods_id,  "订单项退款金额".$refund_money."元, 订单号：".$order_no.", 退款方式【线上】。");
                }
                #订单退款 更新平台抽取利润
                $shop_account->updateShopOrderGoodsReturnRecords($order_id, $order_goods_id, $shop_id);
                $order_goods_model->commit();
            } catch (\Exception $e) {
                $order_goods_model->rollback();
            }
        }
        
    }
    /**
     * 订单完成
     * @param unknown $order_id
     */
    private function updateShopAccount_OrderComplete($order_id){
        if(NS_VERSION==NS_VER_B2B2C_FX1 || NS_VERSION==NS_VER_B2B2C_FX2){
            $order_model=new NsOrderModel();
            $shop_account=new ShopAccount();
            $order=new OrderBusiness();
            $order_model->startTrans();
            try {
                #订单的信息
                $order_obj=$order_model->get($order_id);
                $order_sataus=$order_obj["order_status"];
                #判断当前订单的状态是否 已经交易完成 或者 已退款的状态
                if($order_sataus==4 || $order_sataus==-2){
                    #订单的实际付款金额
                    $pay_money=$order->getOrderRealPayMoney($order_id);
                    #订单的支付方式
                    $payment_type=$order_obj["payment_type"];
                    #店铺id
                    $shop_id=$order_obj["shop_id"];
                    #订单号
                    $order_no=$order_obj["order_no"];
                    if($payment_type!=11){
                        #在线支付
                        $shop_account->addShopAccountProceedsRecords(getSerialNo(), $shop_id, $pay_money, 1, $order_id, "订单完成，店铺收入金额".$pay_money."元,订单号为：".$order_no);
                    }
                    #平台抽取店铺利润佣金发放
                    $shop_account->updateShopOrderAccountRecord($order_id);
                }
                $order_model->commit();
            } catch (\Exception $e) {
                $order_model->rollback();
            }
        }
        
    }   

    /*************************************************店铺账户--End*******************************************************/
    
    
    
    /*************************************************平台账户计算--Start*******************************************************/
    /**
     * 订单支付时处理 平台的账户
     *
     * @param string $order_out_trade_no
     * @param number $order_id
     */
    public function dealPlatformAccountOrderPay($order_out_trade_no = "", $order_id = 0)
    {
        if(NS_VERSION == NS_VER_B2B2C_FX1 || NS_VERSION == NS_VER_B2B2C_FX2)
        {
            if ($order_out_trade_no != "" && $order_id == 0) {
                $order_model = new NsOrderModel();
                $condition = " order_out_trade_no=" . $order_out_trade_no;
                $order_list = $order_model->getQuery($condition, "order_id", "");
                foreach ($order_list as $k => $v) {
                    $this->updateAccountOrderPay($v["order_id"]);
                    #招商员订单佣金计算
                    $this->AssistantOrderCommissionCalculate($order_out_trade_no);
                }
            } else
                if ($order_out_trade_no == "" && $order_id != 0) {
                    $this->updateAccountOrderPay($order_id);
                    #招商员订单佣金计算
                    $this->AssistantOrderCommissionCalculate("", $order_id);
                }
        }
         
    }

    /**
     * 订单支付成功后处理 平台账户
     * @param unknown $orderid
     */
    private function updateAccountOrderPay($order_id){
        $order_model=new NsOrderModel();
        $shop_account=new ShopAccount();
        $order=new OrderBusiness();
        $order_model->startTrans();
        try {
            $order_obj=$order_model->get($order_id);
            #订单的实际付款金额
            $pay_money=$order->getOrderRealPayMoney($order_id);
            #订单的支付方式
            $payment_type=$order_obj["payment_type"];
            #店铺id
            $shop_id=$order_obj["shop_id"];
            #订单号
            $order_no=$order_obj["order_no"];
            if($payment_type!=11){
                #在线支付 处理平台的资金账户
                $shop_account->addAccountOrderRecords($shop_id, $pay_money, 1, $order_id, "店铺订单支付金额".$pay_money."元, 订单号为：".$order_no.", 支付方式【在线支付】。");
            }
            $order_model->commit();
        } catch (\Exception $e) {
            $order_model->rollback();
        }
    }
    /**
     * 订单完成时 处理平台的利润抽成
     * @param unknown $order_id
     */
    private function updateAccountOrderComplete($order_id){
        if(NS_VERSION==NS_VER_B2B2C_FX1 || NS_VERSION==NS_VER_B2B2C_FX2){
            $order_model=new NsOrderModel();
            $order_obj=$order_model->get($order_id);
            $order_sataus=$order_obj["order_status"];
            #判断当前订单的状态是否 已经交易完成 或者 已退款的状态
            if($order_sataus==4 || $order_sataus==-2){
                $order_account_model=new NsShopOrderReturnModel();
                $shop_account=new ShopAccount();
                $order_return_obj=$order_account_model->getInfo(["order_id"=>$order_id]);
                if(!empty($order_return_obj)){
                    $shop_id=$order_return_obj["shop_id"];
                    $return_money=$order_return_obj["platform_money"];
                    $order_no=$order_return_obj["order_no"];
                    $real_pay_money=$order_return_obj["order_pay_money"];
                    $shop_account->addAccountReturnRecords($shop_id, $return_money, 1, $order_return_obj["id"], "订单号为：".$order_no."的订单交易完成，订单实际付款金额为：".$real_pay_money."元，平台抽取".$return_money);
                }
                #结算招商员的订单佣金
                $this->UpdateAssistantOrderCommission($order_id);
            }
        }
    }
    /**
     * 订单退款   更细平台的订单支付金额
     * @param unknown $order_goods_id
     */
    private function updateAccountOrderRefund($order_goods_id){
        if(NS_VERSION==NS_VER_B2B2C_FX1 || NS_VERSION==NS_VER_B2B2C_FX2){
            $order_goods_model=new NsOrderGoodsModel();
            $order_model=new NsOrderModel();
            $shop_account=new ShopAccount();
            $order_goods_model->startTrans();
            try {
                #查询订单项的信息
                $order_goods_obj=$order_goods_model->get($order_goods_id);
                #退款金额
                $refund_money=$order_goods_obj["refund_real_money"];
                #订单id
                $order_id=$order_goods_obj["order_id"];
                #订单信息
                $order_obj=$order_model->get($order_id);
                #订单的支付方式
                $payment_type=$order_obj["payment_type"];
                #店铺id
                $shop_id=$order_obj["shop_id"];
                #订单号
                $order_no=$order_obj["order_no"];
                if ($payment_type!=11){
                    #在线支付  处理店铺入账金额
                    $shop_account->addAccountOrderRecords($shop_id, -$refund_money, 2, $order_goods_id, "订单项退款金额".$refund_money."元, 订单号：".$order_no."。");
                }
                #订单退款 计算招商员的佣金
                $this->UpdateAssistantOrderCommissionRefund($order_id);
                $order_goods_model->commit();
            } catch (\Exception $e) {
                $order_goods_model->rollback();
            }
        }
    }
    
    /*************************************************平台账户计算--End*******************************************************/
    
    /*************************************************订单的佣金计算--Start*******************************************************/
    
    /**
     * 支付后续佣金操作
     *
     * @param unknown $order_out_trade_no
     * @param unknown $order_id
     */
    private function orderCommissionCalculate($order_out_trade_no = "", $order_id = 0)
    {
        //针对非基础电商版
        if(NS_VERSION != NS_VER_B2C)
        {
            if ($order_out_trade_no != "" && $order_id == 0) {
                $order_model = new NsOrderModel();
                $condition = " order_out_trade_no=" . $order_out_trade_no;
                $order_list = $order_model->getQuery($condition, "order_id", "");
                foreach ($order_list as $k => $v) {
                    $this->oneOrderCommissionCalculate($v["order_id"]);
                }
            } else
                if ($order_out_trade_no == "" && $order_id != 0) {
                    $this->oneOrderCommissionCalculate($order_id);
                }
        }
    
    }
    
    /**
     * 处理单个 订单佣金计算
     *
     * @param unknown $order_id
     */
    private function oneOrderCommissionCalculate($order_id)
    {
        if(NS_VERSION !=NS_VER_B2C)
        {
            $commissionCalculate = new NfxCommissionCalculate($order_id);
            //分销佣金计算
            $res = $commissionCalculate->orderdistributionCommission();
            //区域代理计算
            $res = $commissionCalculate->orderRegionAgentCommission();
            //股东分红计算
            $res = $commissionCalculate->orderPartnerCommission();
        }
         
    }
    public function partent_test(){
        $commissionCalculate = new NfxCommissionCalculate(476);
        $res = $commissionCalculate->orderPartnerCommission();
    }
    
    /**
     * 订单退款成功后需要重新计算订单的佣金
     *
     * @param unknown $order_id
     * @param unknown $order_goods_id
     */
    private function updateCommissionMoney($order_id, $order_goods_id)
    {
        //单店基础版不进行计算
        if(NS_VERSION !=NS_VER_B2C)
        {
            $commissionCalculate = new NfxCommissionCalculate($order_id, $order_goods_id);
            //重新计算分销佣金
            $commissionCalculate->updateOrderDistributionCommission();
            //重新计算股东分红
            $commissionCalculate->updateOrderPartnerCommission();
            //重新计算区域代理佣金
            $commissionCalculate->updateOrderRegionAgentCommission();
        }
    }
    /**
     * 订单完成交易进行 佣金结算
     *
     * @param unknown $order_id
     */
    private function updateOrderCommission($order_id)
    {
        if(NS_VERSION!=NS_VER_B2C){
            $order_model = new NsOrderModel();
            $order_model->startTrans();
            try {
                $shop_obj = $order_model->get($order_id);
                $order_sataus=$shop_obj["order_status"];
                #判断当前订单的状态是否 已经交易完成 或者 已退款的状态
                if($order_sataus==4 || $order_sataus==-2){
                    #得到订单的店铺id
                    $shop_id = $shop_obj["shop_id"];
                    #得到订单用户id
                    $uid = $shop_obj["buyer_id"];
                    $user_service = new NfxUser();
                    #发放订单的三级分销佣金
                    $user_service->updateCommissionDistributionIssue($order_id);
                    #更新当前用户的分销商等级
                    $user_service->updatePromoterLevel($uid, $shop_id);
                    #/发放订单的区域代理佣金
                    $user_service->updateCommissionRegionAgentIssue($order_id);
                    #发放订单的股东分红佣金
                    $user_service->updateCommissionPartnerIssue($order_id);
                    #更新用户的股东等级
                    $user_service->updatePartnerLevel($uid, $shop_id);
                }
                $order_model->commit();
            } catch (\Exception $e) {
                $order_model->rollback();
            }
        }
    }
    
    /*************************************************订单的佣金计算--End*******************************************************/

    
    /*************************************************招商员的账户计算--Start*******************************************************/
    /**
     * 招商员的订单佣金计算
     * @param string $order_out_trade_no
     * @param number $order_id
     */
    private function AssistantOrderCommissionCalculate($order_out_trade_no = "", $order_id = 0){
        if(NS_VERSION==NS_VER_B2B2C_FX1 || NS_VERSION==NS_VER_B2B2C_FX2)
        {
            $Assistant_account_service=new NbsBusinessAssistantAccount();
            if ($order_out_trade_no != "" && $order_id == 0) {
                $order_model = new NsOrderModel();
                $condition = " order_out_trade_no=" . $order_out_trade_no;
                $order_list = $order_model->getQuery($condition, "order_id", "");
                foreach ($order_list as $k => $v) {
                    $Assistant_account_service->calculateOrderBusinessAssistant($v["order_id"]);
                }
            } else
                if ($order_out_trade_no == "" && $order_id != 0) {
                    $Assistant_account_service->calculateOrderBusinessAssistant($order_id);
                }
        }
    }
    /**
     * 订单退款 更新佣金金额
     * @param unknown $order_id
     */
    private function UpdateAssistantOrderCommissionRefund($order_id){
        $Assistant_account_service=new NbsBusinessAssistantAccount();
        $Assistant_account_service->updateOrderBusinessAssistant($order_id);
    }
    /**
     * 订单交易完成发放订单的佣金
     * @param unknown $order_id
     */
    private function UpdateAssistantOrderCommission($order_id){
        if(NS_VERSION==NS_VER_B2B2C_FX1 || NS_VERSION==NS_VER_B2B2C_FX2){
            $assistant_model=new NbsCommissionBusinessAssistantOrderModel();
            $Assistant_account_service=new NbsBusinessAssistantAccount();
            $commisson_order_obj=$assistant_model->getInfo(["order_id"=>$order_id, "is_issue"=>0], "*");
            if(!empty($commisson_order_obj)){
                $Assistant_account_service->addbusinessAssistantAccountRecords
                        ($commisson_order_obj["business_assistant_id"], 1, $commisson_order_obj["id"], $commisson_order_obj["commission_money"], "订单交易完成，产生订单佣金!");
                $assistant_model->save(["is_issue"=>1], ["id"=>$commisson_order_obj["id"]]);
            }
        }
    }
    
    /*************************************************招商员的账户计算--End*******************************************************/
    
    
    
}