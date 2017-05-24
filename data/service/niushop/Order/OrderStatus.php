<?php
/**
 * OrderStatus.php
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
namespace data\service\niushop\Order;
use data\service\BaseService as BaseService;
/**
 * 订单调度类
 */
class OrderStatus extends BaseService
{
    /**
     * 获取订单所有可能的订单状态
     */
    public static function getOrderCommonStatus()
    {
        $status = array(
            array(
                'status_id' => '0',
                'status_name' =>'待付款',
                'is_refund' => 0,  //是否可以申请退款
                'operation' =>  array(
                    '0' => array(
                                'no' => 'pay',
                                'name' => '线下支付',
                                'color'=>'green'
                            ),
                    '1' => array(
                        'no' => 'close',
                        'color'=>'#FF8400',
                        'name' => '交易关闭'
                    ),
                    '2' => array(
                        'no' => 'adjust_price',
                        'color'=>'green',
                        'name' => '修改价格'
                    )
                ),
                'member_operation' => array(
                '0' => array(
                        'no' => 'pay',
                        'name' => '去支付',
                        'color' => '#F15050'
                ),
            
                 '1' => array(
                        'no' => 'close',
                        'name' =>'关闭订单',
                        'color' => '#999999'
                 ) 
                )
            ),
            array(
                'status_id' => '1',
                'status_name' =>'待发货',
                'is_refund' => 1,
                'operation' => array(
                        '0' => array(
                            'no' => 'delivery',
                            'color'=>'green',
                            'name' => '发货'
                            )
                ),
                'member_operation' => array(
             
                )
            ),
            array(
                'status_id' => '2',
                'status_name' =>'已发货',
                'is_refund' => 1,
                'operation' => array(
                  
                ),
                'member_operation' => array(
                    '0' => array(
                        'no' => 'getdelivery',
                        'name' => '确认收货',
                        'color' => '#FF6600'
                    )
                
                )
            ),
            array(
                'status_id' => '3',
                'status_name' =>'已收货',
                'is_refund' => 0,
                'operation' => array(
                  
                ),
                'member_operation' => array(
                     
                )
            ),
            array(
                'status_id' => '4',
                'status_name' =>'已完成',
                'is_refund' => 0,
                'operation' => array(
                  
                ),
                'member_operation' => array(
             
                )
            ),
            array(
                'status_id' => '5',
                'status_name' =>'已关闭',
                'is_refund' => 0,
                'operation' => array(
                  
                ),
                'member_operation' => array(
             
                )
            ),
            array(
                'status_id' => '-1',
                'status_name' =>'退款中',
                'is_refund' => 1,
                'operation' => array(
                  
                ),
                'member_operation' => array(
             
                )
            ),
            array(
                'status_id' => '-2',
                'status_name' =>'已退款',  //全部退款才能算已退款
                'is_refund' => 0,
                'operation' => array(
                
                ),
                'member_operation' => array(
             
                )
            )
        );
        return $status;
    }
    /**
     * 获取发货操作状态
     */
    public static function getShippingStatus(){
        $shipping_status = array(
            array(
                'shipping_status' => '0',
                'status_name' =>'待发货'
            ),
            array(
                'shipping_status' => '1',
                'status_name' =>'已发货'
            ),
            array(
                'shipping_status' => '2',
                'status_name' =>'已收货'
            ),
            array(
                'shipping_status' => '3',
                'status_name' =>'备货中'
            )
        );
        return $shipping_status;
    }
    /**
     * 获取订单支付操作状态
     */
    public static function getPayStatus($pay_status_id = -100){
        $pay_status = array(
            array(
                'pay_status' => '0',
                'status_name' =>'待支付'
            ),
            array(
                'pay_status' => '1',
                'status_name' =>'支付中'
            ),
            array(
                'pay_status' => '2',
                'status_name' =>'已支付'
            )
        );
        return $pay_status;
       
    }
    /**
     * 获取订单退款操作状态
     */
    public static function getRefundStatus(){
        $refund_status = array(
            '0' => array(
                'status_id' => '1',
                'status_name' => '买家申请退款',
                'status_desc' => '发起了退款申请,等待卖家处理',
                'refund_operation' =>array(
                    '0' => array(
                        'no' => 'agree',
                        'name' => '同意'
                    ),
                    '1' => array(
                        'no' => 'refuse',
                        'name' => '拒绝'
                    ),
                    
                )
            ),
            '1' => array(
                'status_id' => '2',
                'status_name' => '等待买家退货',
                'status_desc' => '卖家已同意退款申请,等待买家退货',
                'refund_operation' =>array(
                
                )
            ),
            '2' => array(
                'status_id' => '3',
                'status_name' => '等待卖家确认收货',
                'status_desc' => '买家已退货,等待卖家确认收货',
                'refund_operation' =>array(
                    '0' => array(
                        'no' => 'confirm_receipt',
                        'name' => '确认收货'
                    )
                
                )
            ),
            '3' => array(
                'status_id' => '4',
                'status_name' => '等待卖家确认退款',
                'status_desc' => '卖家同意退款',
                'refund_operation' =>array(
                    '0' => array(
                        'no' => 'confirm_refund',
                        'name' => '确认退款'
                    )
                
                )
            ),
            '4' => array(
                'status_id' => '5',
                'status_name' => '退款已成功',
                'status_desc' => '卖家退款给买家，本次维权结束',
                'refund_operation' =>array(
               
                )
            ),
            '5' => array(
                'status_id' => '-1',
                'status_name' => '退款已拒绝',
                'status_desc' => '卖家拒绝本次退款，本次维权结束',
                'refund_operation' =>array(
                     
                )
            ),
            '6' => array(
                'status_id' => '-2',
                'status_name' => '退款已关闭',
                'status_desc' => '主动撤销退款，退款关闭',
                'refund_operation' =>array(
                     
                )
            ),
            '7' => array(
                'status_id' => '-3',
                'status_name' => '退款申请不通过',
                'status_desc' => '拒绝了本次退款申请,等待买家修改',
                'refund_operation' =>array(
                     
                )
            )
        );
        return $refund_status;
    }
    
    /**
     * 获取订单所有的操作
     */
    public static function getOrderOperation(){
        $operation = array(
            '0' => array(
                'no' => 'pay',
                'name' => '线下支付'
            ),
            '1' => array(
                'no' => 'complate',
                'name' => '交易完成'
            ),
            '2' => array(
                'no' => 'delivery',
                'name' => '发货'
            )
        );
    }
    
}