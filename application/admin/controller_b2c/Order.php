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
namespace app\admin\controller_b2c;

use data\service\niushop\Order as OrderService; // 订单服务层
use data\service\niushop\Express as ExpressService;
use data\service\system\Address as AddressService;
use data\service\niushop\Order\OrderStatus;
use data\service\niushop\Order\OrderGoods;

/**
 * 订单控制器
 *
 * @author Administrator
 *        
 */
class Order extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 订单列表
     */
    public function orderList()
    {
        if (request()->isAjax()) {
            $page_index = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : 1;
            $start_date = ! empty($_POST['start_date']) ? $_POST['start_date'] : '2010-1-1';
            $end_date = ! empty($_POST['end_date']) ? $_POST['end_date'] : '2099-1-1';
            $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
            $order_no = isset($_POST['order_no']) ? $_POST['order_no'] : '';
            $order_status = isset($_POST['order_status']) ? $_POST['order_status'] : '';
            $receiver_mobile = isset($_POST['receiver_mobile']) ? $_POST['receiver_mobile'] : '';
            $payment_type = isset($_POST['payment_type']) ? $_POST['payment_type'] : '';
            $condition["create_time"] = [
                [
                    ">",
                    $start_date
                ],
                [
                    "<",
                    $end_date
                ]
            ];
            if (! empty($order_status)) {
                $condition['order_status'] = $order_status;
            }
            if (! empty($payment_type)) {
                $condition['payment_type'] = $payment_type;
            }
            if (! empty($user_name)) {
                $condition['user_name'] = $user_name;
            }
            if (! empty($order_no)) {
                $condition['out_trade_no'] = $order_no;
            }
            if (! empty($receiver_mobile)) {
                $condition['receiver_mobile'] = $receiver_mobile;
            }
            $condition['shop_id'] = $this->instance_id;
            $order_service = new OrderService();
            $list = $order_service->getOrderList($page_index, PAGESIZE, $condition, 'create_time desc');
            return $list;
        } else {
            $status = isset($_GET['status']) ? $_GET['status'] : '';
            $this->assign("status", $status);
            $all_status = OrderStatus::getOrderCommonStatus();
            $child_menu_list = array();
            $child_menu_list[] = array(
                'url' => "Order/orderList",
                'menu_name' => '全部',
                "active" => $status == '' ? 1 : 0
            );
            foreach ($all_status as $k => $v) {
                $child_menu_list[] = array(
                    'url' => "Order/orderList?status=" . $v['status_id'],
                    'menu_name' => $v['status_name'],
                    "active" => $status == $v['status_id'] ? 1 : 0
                );
            }
            $this->assign('child_menu_list', $child_menu_list);
            return view($this->style . "Order/orderList");
        }
    }

    /**
     * 订单详情
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function orderDetail()
    {
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;
        if ($order_id == 0) {
            $this->error("没有获取到订单信息");
        }
        $order_service = new OrderService();
        $detail = $order_service->getOrderDetail($order_id);
        if (empty($detail)) {
            $this->error("没有获取到订单信息");
        }
        $address_service = new AddressService();
        $detail['address'] = $address_service->getAddress($detail['receiver_province'], $detail['receiver_city'], $detail['receiver_district']);
        $this->assign("order", $detail);
        return view($this->style . "Order/orderDetail");
    }

    /**
     * 订单退款详情
     */
    public function orderRefundDetail()
    {
        $order_goods_id = isset($_GET['itemid']) ? $_GET['itemid'] : 0;
        if ($order_goods_id == 0) {
            $this->error("没有获取到退款信息");
        }
        $order_service = new OrderService();
        $info = $order_service->getOrderGoodsRefundInfo($order_goods_id);
        $this->assign('order_goods', $info);
        return view($this->style . "Order/orderRefundDetail");
    }

    /**
     * 线下支付
     */
    public function orderOffLinePay()
    {
        $order_service = new OrderService();
        $order_id = $_POST['order_id'];
        $res = $order_service->orderOffLinePay($order_id, 10, 0);
        return AjaxReturn($res);
    }

    /**
     * 交易完成
     *
     * @param unknown $orderid            
     * @return Exception
     */
    public function orderComplete()
    {
        $order_service = new OrderService();
        $order_id = $_POST['order_id'];
        $res = $order_service->orderComplete($order_id);
        return AjaxReturn($res);
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
     * 订单发货 所需数据
     */
    public function orderDeliveryData()
    {
        $order_service = new OrderService();
        $express_service = new ExpressService();
        $address_service = new AddressService();
        $order_id = $_POST['order_id'];
        $order_info = $order_service->getOrderDetail($order_id);
        $order_info['address'] = $address_service->getAddress($order_info['receiver_province'], $order_info['receiver_city'], $order_info['receiver_district']);
        $shopId = $this->instance_id;
        // 快递公司列表
        $express_company_list = $express_service->expressCompanyQuery('shopId = ' . $shopId, "*");
        // 订单商品项
        $order_goods_list = $order_service->getOrderGoods($order_id);
        $data['order_info'] = $order_info;
        $data['express_company_list'] = $express_company_list;
        $data['order_goods_list'] = $order_goods_list;
        return $data;
    }

    /**
     * 订单发货
     */
    public function orderDelivery()
    {
        $order_service = new OrderService();
        $order_id = $_POST['order_id'];
        $order_goods_id_array = $_POST['order_goods_id_array'];
        $express_name = $_POST['express_name'];
        $shipping_type = $_POST['shipping_type'];
        $express_company_id = $_POST['express_company_id'];
        $express_no = $_POST['express_no'];
        if ($shipping_type == 1) {
            $res = $order_service->orderDelivery($order_id, $order_goods_id_array, $express_name, $shipping_type, $express_company_id, $express_no);
        } else {
            $res = $order_service->orderGoodsDelivery($order_id, $order_goods_id_array);
        }
        return AjaxReturn($res);
    }

    /**
     * 获取订单大订单项
     */
    public function getOrderGoods()
    {
        $order_id = $_POST['order_id'];
        $order_service = new OrderService();
        $order_goods_list = $order_service->getOrderGoods($order_id);
        $order_info = $order_service->getOrderInfo($order_id);
        $list[0] = $order_goods_list;
        $list[1] = $order_info;
        return $list;
    }

    /**
     * 订单价格调整
     */
    public function orderAdjustMoney($order_id, $order_goods_id_adjust_array, $shipping_fee)
    {
        $order_id = $_POST['order_id'];
        $order_goods_id_adjust_array = $_POST['order_goods_id_adjust_array'];
        $shipping_fee = $_POST['shipping_fee'];
        $order_service = new OrderService();
        $res = $order_service->orderMoneyAdjust($order_id, $order_goods_id_adjust_array, $shipping_fee);
        return AjaxReturn($res);
    }

    public function test()
    {
        $order_service = new OrderService();
        $list = $order_service->test();
        var_dump($list);
    }

    public function orderGoodsOpertion()
    {
        $order_goods = new OrderGoods();
        $order_id = 14;
        $order_goods_id = 35;
        
        // 申请退款
        $refund_type = 2;
        $refund_require_money = 202;
        $refund_reason = '不想买了';
        $retval = $order_goods->orderGoodsRefundAskfor($order_id, $order_goods_id, $refund_type, $refund_require_money, $refund_reason);
        
        // 卖家同意退款
        // $retval = $order_goods->orderGoodsRefundAgree($order_id, $order_goods_id);
        
        // 卖家确认退款
        // $refund_real_money = 10;
        // $retval = $order_goods->orderGoodsConfirmRefund($order_id, $order_goods_id, $refund_real_money);
        
        // 买家退货
        // $refund_shipping_company = 8;
        // $refund_shipping_code = '545654465';
        // $retval = $order_goods->orderGoodsReturnGoods($order_id ,$order_goods_id, $refund_shipping_company, $refund_shipping_code);
        
        // 卖家确认收货
        // $retval = $order_goods->orderGoodsConfirmRecieve($order_id, $order_goods_id);
        
        // 买家取消订单
        // $retval = $order_goods->orderGoodsCancel($order_id ,$order_goods_id);
        
        // 卖家拒绝退款
        // $retval = $order_goods->orderGoodsRefuseForever($order_id, $order_goods_id);
        
        // 卖家拒绝本次退款
        // $retval = $order_goods->orderGoodsRefuseOnce($order_id, $order_goods_id);
        // $orderGoodsList = NsOrderGoodsModel::where("order_id=$order_id AND refund_status<>0 AND refund_status<>5")->select();
        // $map = array("order_id"=>$order_id, "refund_status"=>array("neq", 0), "refund_status"=>array("neq", 5));
        // $orderGoodsList = NsOrderGoodsModel::all($map);
        // $refund_count = count($orderGoodsList);
        // $orderGoodsListTotal = NsOrderGoodsModel::where("order_id=$order_id AND refund_status=5")->count();
        // $total_count = count($orderGoodsListTotal);
        // $retval = $orderGoodsListTotal;
        var_dump($retval);
    }

    /**
     * 买家申请退款
     *
     * @return Ambigous <number, \data\service\niushop\Order\Exception, \data\service\niushop\Order\Ambigous>
     */
    public function orderGoodsRefundAskfor()
    {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : $this->error("缺少必需参数order_id");
        $order_goods_id = isset($_POST['order_goods_id']) ? $_POST['order_goods_id'] : $this->error("缺少必需参数order_goods_id");
        $refund_type = isset($_POST['refund_type']) ? $_POST['refund_type'] : $this->error("缺少必填参数refund_type");
        $refund_require_money = isset($_POST['refund_require_money']) ? $_POST['refund_require_money'] : 0;
        $refund_reason = isset($_POST['refund_reason']) ? $_POST['refund_reason'] : '';
        $order_service = new OrderService();
        $retval = $order_service->orderGoodsRefundAskfor($order_id, $order_goods_id, $refund_type, $refund_require_money, $refund_reason);
        return AjaxReturn($retval);
    }

    /**
     * 买家取消退款
     *
     * @return number
     */
    public function orderGoodsCancel()
    {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : $this->error("缺少必需参数order_id");
        $order_goods_id = isset($_POST['order_goods_id']) ? $_POST['order_goods_id'] : $this->error("缺少必需参数order_goods_id");
        $order_service = new OrderService();
        $retval = $order_service->orderGoodsCancel($order_id, $order_goods_id);
        return AjaxReturn($retval);
    }

    /**
     * 买家退货
     *
     * @return Ambigous <number, \think\false, boolean, string>
     */
    public function orderGoodsReturnGoods()
    {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : $this->error("缺少必需参数order_id");
        $order_goods_id = isset($_POST['order_goods_id']) ? $_POST['order_goods_id'] : $this->error("缺少必需参数order_goods_id");
        $refund_shipping_company = $_POST['refund_shipping_company'];
        $refund_shipping_code = $_POST['$refund_shipping_code'];
        $order_service = new OrderService();
        $retval = $order_service->orderGoodsReturnGoods($order_id, $order_goods_id, $refund_shipping_company, $refund_shipping_code);
        return AjaxReturn($retval);
    }

    /**
     * 买家同意买家退款申请
     *
     * @return number
     */
    public function orderGoodsRefundAgree()
    {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : $this->error("缺少必需参数order_id");
        $order_goods_id = isset($_POST['order_goods_id']) ? $_POST['order_goods_id'] : $this->error("缺少必需参数order_goods_id");
        $order_service = new OrderService();
        $retval = $order_service->orderGoodsRefundAgree($order_id, $order_goods_id);
        return AjaxReturn($retval);
    }

    /**
     * 买家永久拒绝本次退款
     *
     * @return Ambigous <number, Exception>
     */
    public function orderGoodsRefuseForever()
    {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : $this->error("缺少必需参数order_id");
        $order_goods_id = isset($_POST['order_goods_id']) ? $_POST['order_goods_id'] : $this->error("缺少必需参数order_goods_id");
        $order_service = new OrderService();
        $retval = $order_service->orderGoodsRefuseForever($order_id, $order_goods_id);
        return AjaxReturn($retval);
    }

    /**
     * 卖家拒绝本次退款
     *
     * @return Ambigous <number, Exception>
     */
    public function orderGoodsRefuseOnce()
    {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : $this->error("缺少必需参数order_id");
        $order_goods_id = isset($_POST['order_goods_id']) ? $_POST['order_goods_id'] : $this->error("缺少必需参数order_goods_id");
        $order_service = new OrderService();
        $retval = $order_service->orderGoodsRefuseOnce($order_id, $order_goods_id);
        return AjaxReturn($retval);
    }

    /**
     * 卖家确认收货
     *
     * @return Ambigous <number, Exception>
     */
    public function orderGoodsConfirmRecieve()
    {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : $this->error("缺少必需参数order_id");
        $order_goods_id = isset($_POST['order_goods_id']) ? $_POST['order_goods_id'] : $this->error("缺少必需参数order_goods_id");
        $order_service = new OrderService();
        $retval = $order_service->orderGoodsConfirmRecieve($order_id, $order_goods_id);
        return AjaxReturn($retval);
    }

    /**
     * 卖家确认退款
     *
     * @return Ambigous <Exception, unknown>
     */
    public function orderGoodsConfirmRefund()
    {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : $this->error("缺少必需参数order_id");
        $order_goods_id = isset($_POST['order_goods_id']) ? $_POST['order_goods_id'] : $this->error("缺少必需参数order_goods_id");
        $refund_real_money = isset($_POST['refund_real_money']) ? $_POST['refund_real_money'] : $this->error("缺少必需参数refund_real_money");
        $order_service = new OrderService();
        $retval = $order_service->orderGoodsConfirmRefund($order_id, $order_goods_id, $refund_real_money);
        return AjaxReturn($retval);
    }

    /**
     * 获取订单销售统计
     */
    public function getOrderAccount()
    {
        $order_service = new OrderService();
        // 获取日销售统计
        $account = $order_service->getShopOrderAccountDetail($this->instance_id);
        var_dump($account);
    }
}