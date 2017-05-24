<?php
/**
 * UnifyPay.php
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
 * 统一支付接口服务层
 */
use data\service\BaseService as BaseService;
use data\api\niushop\IUnifyPay;
use data\model\niushop\NsOrderPaymentModel;
use data\service\niushop\Pay\WeiXinPay;
use data\service\niushop\Pay\AliPay;
use data\service\system\Config;
use app\wap\controller\Assistant;
use data\service\niubusiness\NbsBusinessAssistant;

class UnifyPay extends BaseService implements IUnifyPay
{

    function __construct()
    {
        parent::__construct();
    }
    /**
     * 创建订单支付编号
     * @param unknown $order_id
     */
    public function createOutTradeNo()
    {
        $no = time().rand(111,999);
        return $no;
    }
    /**
     * 获取支付配置(non-PHPdoc)
     * @see \data\api\niushop\IUnifyPay::getPayConfig()
     */
    public function getPayConfig()
    {
        switch (NS_VERSION) {
            case NS_VER_B2C:
                $instance_id = 0;
                break;
            case NS_VER_B2C_FX:
                $instance_id = 0;
                break;
            case NS_VER_B2B2C_FX1:
                $instance_id = 0;
                break;
            case NS_VER_B2B2C_FX2:
                $instance_id = 0;
                break;
        }
        $config = new Config();
        $wchat_pay = $config->getWpayConfig($instance_id);
        $ali_pay = $config->getAlipayConfig($instance_id);
        $data_config = array(
            'wchat_pay_config' => $wchat_pay,
            'ali_pay_config'   => $ali_pay
        );
        return $data_config;
    }
    /**
     * 创建待支付单据
     * @param unknown $pay_no
     * @param unknown $pay_body
     * @param unknown $pay_detail
     * @param unknown $pay_money
     * @param unknown $type  订单类型  1. 商城订单  2.
     * @param unknown $pay_money
     */
    public function createPayment($shop_id, $out_trade_no, $pay_body, $pay_detail, $pay_money, $type, $type_alis_id)
    {
        $pay = new NsOrderPaymentModel();
        $data = array(
            'shop_id'       => $shop_id,
            'out_trade_no'  => $out_trade_no,
            'type'          => $type,
            'type_alis_id'  => $type_alis_id,
            'pay_body'      => $pay_body,
            'pay_detail'    => $pay_detail,
            'pay_money'     => $pay_money,
            'create_time'   => date("Y-m-d H:i:s", time())
        );
        if($pay_money <= 0)
        {
            $data['pay_status'] = 1;
        }
        $res = $pay->save($data);
        return $res;
    }

    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IUnifyPay::updatePayment()
     */
    public function updatePayment($out_trade_no,$shop_id, $pay_body, $pay_detail, $pay_money, $type, $type_alis_id)
    {
        $pay = new NsOrderPaymentModel();
        $data = array(
            'shop_id'       => $shop_id,
            'type'          => $type,
            'type_alis_id'  => $type_alis_id,
            'pay_body'      => $pay_body,
            'pay_detail'    => $pay_detail,
            'pay_money'     => $pay_money,
            'modify_time'   => date("Y-m-d H:i:s", time())
        );
        if($pay_money <= 0)
        {
            $data['pay_status'] = 1;
        }
        $res = $pay->save($data,['out_trade_no'=>$out_trade_no]);
        return $res;
    }
    
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IUnifyPay::delPayment()
     */
    public function delPayment($out_trade_no){
        $pay = new NsOrderPaymentModel();
        $res = $pay->where('out_trade_no',$out_trade_no)->delete();
        return $res;
    }
    
    /**
     * 线上支付主动根据支付方式执行支付成功的通知
     * @param unknown $out_trade_no
     */
    public function onlinePay($out_trade_no, $pay_type)
    {
        $pay = new NsOrderPaymentModel();
        $pay->startTrans();
        try{
            $data = array(
                'pay_status'     => 1,
                'pay_type'       => $pay_type,
                'pay_time'   => date("Y-m-d H:i:s", time())
            );
            $retval = $pay->save($data, ['out_trade_no' => $out_trade_no]);
            $pay_info = $pay->getInfo(['out_trade_no' => $out_trade_no], 'type');
            switch ( $pay_info['type']){
                case 1:
                    $order = new Order();
                    $order->orderOnLinePay($out_trade_no, $pay_type);
                    break;
                case 2:
                    $assistant = new NbsBusinessAssistant();
                    $assistant->payOnlineBusinessAssistantApply($out_trade_no);
                    break;
                default:
                    break;
            }
            $pay->commit();
            return 1;
        }catch(\Exception $e)
        {
            $pay->rollback();
            return $e->getMessage();
        }
    
    }
    /**
     * 只是执行单据支付，不进行任何处理用于执行支付后被动调用
     * @param unknown $out_trade_no
     * @param unknown $pay_type
     */
    public function offLinePay($out_trade_no, $pay_type)
    {
        $pay = new NsOrderPaymentModel();
        $data = array(
            'pay_status'     => 1,
            'pay_type'       => $pay_type,
            'pay_time'   => date("Y-m-d H:i:s", time())
        );
        $retval = $pay->save($data, ['out_trade_no' => $out_trade_no]);
        return $retval;
    }
    /**
     * 获取支付信息
     * @param unknown $out_trade_no
     */
    public function getPayInfo($out_trade_no)
    {
        $pay = new NsOrderPaymentModel();
        $info = $pay->getInfo(['out_trade_no' => $out_trade_no], '*');
        return $info;
    }
    /**
     * 重新设置编号，用于修改价格订单
     * @param unknown $out_trade_no
     * @param unknown $new_no
     * @return Ambigous <number, \think\false, boolean, string>
     */
    public function modifyNo($out_trade_no, $new_no)
    {
        $pay = new NsOrderPaymentModel();
        $data = array(
            "out_trade_no" => $new_no
        );
        $retval = $pay->where(['out_trade_no' => $out_trade_no])->update($data);
        return $retval;
    }
    /**
     * 修改支付价格
     * @param unknown $out_trade_no
     */
    public function modifyPayMoney($out_trade_no, $pay_money)
    {
        $pay = new NsOrderPaymentModel();
        $data = array(
            'pay_money'       => $pay_money
        );
        $retval = $pay->save($data, ['out_trade_no' => $out_trade_no]);
    }
	/* (non-PHPdoc)
     * @see \data\api\niushop\IUnifyPay::wchatPay()
     */
    public function wchatPay($out_trade_no, $trade_type, $red_url)
    {
        $data = $this->getPayInfo($out_trade_no);
        if($data < 0)
        {
            return $data;
        }
        $weixin_pay = new WeiXinPay();
        if($trade_type == 'JSAPI')
        {
            $openid = $weixin_pay->get_openid();
            $product_id = '';
        }
        if($trade_type == 'NATIVE')
        {
            $openid = '';
            $product_id = $out_trade_no;
        }
        $retval = $weixin_pay->setWeiXinPay($data['pay_body'], $data['pay_detail'], $data['pay_money']*100, $out_trade_no, $red_url, $trade_type, $openid, $product_id);
        return $retval;
        
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IUnifyPay::aliPay()
     */
    public function aliPay($out_trade_no, $notify_url, $return_url, $show_url)
    {
        $data = $this->getPayInfo($out_trade_no);
        if($data < 0)
        {
            return $data;
        }
        $ali_pay = new AliPay();
        $retval = $ali_pay->setAliPay($out_trade_no, $data['pay_body'], $data['pay_detail'], $data['pay_money'], 3, $notify_url, $return_url, $show_url);
        return $retval;
        // TODO Auto-generated method stub
        
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IUnifyPay::getWxJsApi()
     */
    public function getWxJsApi($UnifiedOrderResult)
    {
        $weixin_pay = new WeiXinPay();
        $retval = $weixin_pay->GetJsApiParameters($UnifiedOrderResult);
        return $retval;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IOrder::getVerifyResult()
     */
    public function getVerifyResult(){
        $pay = new AliPay();
        $verify = $pay->getVerifyResult();
        return $verify;
    }

}
