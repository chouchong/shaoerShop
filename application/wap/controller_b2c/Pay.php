<?php
/**
 * Pay.php
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

use data\extend\QRcode;
use data\service\niushop\UnifyPay;
use data\service\system\WebSite;
use data\service\niushop\Member as MemberService;
use think\Controller;
\think\Loader::addNamespace('data', 'data/');
use Payment\Common\PayException;
use Payment\Client\Charge;
use Payment\Config;
/**
 * 支付控制器
 *
 * @author Administrator
 *        
 */
class Pay extends Controller
{

    public $style;

    public function __construct()
    {
        parent::__construct();
        $this->web_site = new WebSite();
        $web_info = $this->web_site->getWebSiteInfo();
        $this->assign("web_info", $web_info);
        $this->assign("platform_shopname", $web_info['title']);
        $this->assign("title", $web_info['title']);
        $this->style = 'wap/' . NS_TEMPLATE . '/';
        $this->assign("style", $this->style);
    }

    /* 演示版本 */
    public function demoVersion()
    {
        return view($this->style . 'Pay/demoVersion');
    }

    /**
     * 获取支付相关信息
     */
    public function getPayValue()
    {
         return view($this->style . 'Pay/payVersion');
    }

    /**
     * 支付完成后回调界面
     *
     * status 1 成功
     *
     * @return \think\response\View
     */
    public function payCallback()
    {
        $out_trade_no = isset($_GET['out_trade_no']) ? $_GET['out_trade_no'] : ""; // 流水号
        $msg = isset($_GET['msg']) ? $_GET['msg'] : ""; // 测试，-1：在其他浏览器中打开，1：成功，2：失败
        $this->assign("status", $msg);
        $this->assign("out_trade_no", $out_trade_no);
        return view($this->style . "Pay/payCallback");
    }

    /**
     * 订单微信支付
     */
    public function wchatPay()
    {
        $out_trade_no = isset($_GET['no']) ? $_GET['no'] : '';
        if (empty($out_trade_no)) {
            $this->error("没有获取到支付信息");
        }
        $red_url = 'http://' . $_SERVER['HTTP_HOST'] . '/wap/Pay/wchatUrlBack';
        $pay = new UnifyPay();
        if (! isWeixin()) {
            $res = $pay->wchatPay($out_trade_no, 'NATIVE', $red_url);
            $code_url = $res['code_url'];
            $path = getQRcode($code_url, "upload/qrcode/pay", $out_trade_no);
            $this->assign("path", 'http://' . $_SERVER['HTTP_HOST'] . '/' . $path);
            $pay_value = $pay->getPayInfo($out_trade_no);
            $this->assign('pay_value', $pay_value);
            return view($this->style . "pay/pcwechatpay");
        } else {
            $res = $pay->wchatPay($out_trade_no, 'JSAPI', $red_url);
            $retval = $pay->getWxJsApi($res);
            $this->assign("out_trade_no", $out_trade_no);
            $this->assign('jsApiParameters', $retval);
            return view($this->style . '/Pay/weixinpay');
        }
    }

    /**
     * 微信支付异步回调（只有异步回调对订单进行处理）
     */
    public function wchatUrlBack()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (! empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            
            if ($postObj->result_code == 'SUCCESS') {
                $pay = new UnifyPay();
                
                $retval = $pay->onlinePay($postObj->out_trade_no, 1);
                $xml = "<xml>
                    <return_code><![CDATA[SUCCESS]]></return_code>
                    <return_msg><![CDATA[支付成功]]></return_msg>
                </xml>";
                echo $xml;
            } else {
                $xml = "<xml>
                    <return_code><![CDATA[FAIL]]></return_code>
                    <return_msg><![CDATA[支付失败]]></return_msg>
                </xml>";
                echo $xml;
            }
        }
    }

    /**
     * 微信支付同步回调（不对订单处理）
     */
    public function wchatPayResult()
    {
        $out_trade_no = isset($_GET['out_trade_no']) ? $_GET['out_trade_no'] : '';
        $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
        // if ($msg == 1) {
        // echo $out_trade_no . "支付成功";
        // } else {
        // echo $out_trade_no . "支付失败";
        // }
        $this->assign("status", $msg);
        $this->assign("out_trade_no", $out_trade_no);
        return view($this->style . "Pay/payCallback");
    }

    /**
     * 支付宝支付
     */
    public function aliPay()
    {
        $out_trade_no = isset($_GET['no']) ? $_GET['no'] : '';
        if (empty($out_trade_no)) {
            $this->error("没有获取到支付信息");
        }
        if (! isWeixin()) {
            date_default_timezone_set('Asia/Shanghai');
            // $aliConfig = require_once __DIR__ . '/../aliconfig.php';

            // 订单信息
            // $orderNo = time() . rand(1000, 9999);
            $payData = [
                'body'    => 'ali wap pay',
                'subject'    => '测试支付宝手机网站支付',
                'order_no'    => $out_trade_no,
                'timeout_express' => time() + 600,// 表示必须 600s 内付款
                'amount'    => '0.01',// 单位为元 ,最小为0.01
                'return_param' => 'tata',// 一定不要传入汉字，只能是 字母 数字组合
                'client_ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1',// 客户地址
                'goods_type' => '1',
                'store_id' => '',
            ];

            try {
                $url = Charge::run(Config::ALI_CHANNEL_WAP, config('alipay'), $payData);
            } catch (PayException $e) {
                echo $e->errorMessage();
                exit;
            }
            // header('Location:' . $url);
            // $notify_url = 'http://' . $_SERVER['HTTP_HOST'] . '/wap/Pay/aliUrlBack';
            // $return_url = 'http://' . $_SERVER['HTTP_HOST'] . '/wap/Pay/aliPayReturn';
            // $show_url = 'http://' . $_SERVER['HTTP_HOST'] . '/wap/Pay/aliUrlBack';
            // $pay = new UnifyPay();
            // $res = $pay->aliPay($out_trade_no, $notify_url, $return_url, $show_url);
            echo "<script>window.location.href='" . $url . "'</script>";
        } else {
            // echo "点击右上方在浏览器中打开";
            $this->assign("status", - 1);
            return view($this->style . "Pay/payCallback");
        }
    }

    /**
     * 支付宝支付异步回调
     */
    public function aliUrlBack()
    {
        $pay = new UnifyPay();
        $verify_result = $pay->getVerifyResult();
        if ($verify_result) { // 验证成功
            $out_trade_no = $_POST['out_trade_no'];
            // 支付宝交易号
            $trade_no = $_POST['trade_no'];
            
            // 交易状态
            $trade_status = $_POST['trade_status'];
            
            if ($_POST['trade_status'] == 'TRADE_FINISHED') {
                // 判断该笔订单是否在商户网站中已经做过处理
                // 如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                // 如果有做过处理，不执行商户的业务程序
                // 注意：
                // 退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
                
                // 调试用，写文本函数记录程序运行情况是否正常
                // logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
                $retval = $pay->onlinePay($out_trade_no, 2);
                // $res = $order->orderOnLinePay($out_trade_no, 2);
            } else 
                if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                    // 判断该笔订单是否在商户网站中已经做过处理
                    // 如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    // 如果有做过处理，不执行商户的业务程序
                    
                    // 注意：
                    // 付款完成后，支付宝系统发送该交易状态通知
                    $retval = $pay->onlinePay($out_trade_no, 2);
                    // $res = $order->orderOnLinePay($out_trade_no, 2);
                    // 调试用，写文本函数记录程序运行情况是否正常
                    // logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
                }
            
            // ——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            
            echo "success"; // 请不要修改或删除
                                
            // ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            // 验证失败
            echo "fail";
            
            // 调试用，写文本函数记录程序运行情况是否正常
        } // logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }

    /**
     * 支付宝支付同步会调（页面）（不对订单进行处理）
     */
    public function aliPayReturn()
    {
        $out_trade_no = $_GET['out_trade_no'];
        $this->assign("out_trade_no", $out_trade_no);
        return view($this->style . '/Pay/pay_success');
        $pay = new UnifyPay();
        $verify_result = $pay->getVerifyResult();
        if ($verify_result) {
            $trade_no = $_GET['trade_no'];
            $trade_status = $_GET['trade_status'];
            
            if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                
                echo "<h1>支付成功</h1>";
            } else {
                echo "trade_status=" . $_GET['trade_status'];
            }
            $this->assign("orderNumber", $_GET['out_trade_no']);
            $this->assign("msg", 1);
        } else {
            $this->assign("orderNumber", $_GET['out_trade_no']);
            $this->assign("msg", 0);
            echo "<h1>支付失败</h1>";
            // echo "验证失败";
        }
    }
}