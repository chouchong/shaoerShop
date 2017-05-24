<?php
/**
 * Events.php
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
use data\api\niushop\IEvents;
use data\model\niushop\NsPromotionMansongModel;
use data\service\niushop\Order;
use data\model\niushop\NsOrderModel;
use data\model\niushop\NsPromotionMansongGoodsModel;
use data\model\niushop\NsPromotionDiscountModel;
use data\model\niushop\NsPromotionDiscountGoodsModel;
use data\model\niushop\NsGoodsSkuModel;
use data\model\niushop\NsGoodsModel;
/**
 * 计划任务
 */
class Events implements IEvents{
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IEvents::giftClose()
     */
    public function giftClose(){
        
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IEvents::mansongClose()
     */
    public function mansongOperation(){
        $mansong = new NsPromotionMansongModel();
        $mansong->startTrans();
        try{
            $time = date("Y-m-d H:i:s", time());
            $condition_close = array(
                'end_time' => array('LT', $time),
                'status'   => array('NEQ', 3)
            );
            $condition_start = array(
                'start_time' => array('ELT', $time),
                'status'   => 0
            );
            $mansong->save(['status' => 4], $condition_close);
            $mansong->save(['status' => 1], $condition_start);
            $mansong_goods = new NsPromotionMansongGoodsModel();
            $mansong_goods->save(['status' => 4], $condition_close);
            $mansong_goods->save(['status' => 1], $condition_start);
            $mansong->commit();
            return 1;
        }catch (\Exception $e)
        {
            $mansong->rollback();
            return $e->getMessage();
        }
       
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IEvents::ordersClose()
     */
    public function ordersClose(){
        $order_model = new NsOrderModel();
        $order_model->startTrans();
        try{
            $time = date("Y-m-d H:i:s", time()-3600);//暂定为1小时
            $condition = array(
                'order_status' => 0,
                'create_time'  => array('LT', $time)
            );
            $order_list = $order_model->getQuery($condition, 'order_id', '');
            if(!empty($order_list))
            {
                $order = new Order();
                foreach ($order_list as $k => $v)
                {
                    $order->orderClose($v['order_id']);
                }
                    
            }
            $order_model->commit();
            return 1;
        }catch (\Exception $e)
        {
            $order_model->rollback();
            return $e->getMessage();
        }
        
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IEvents::ordersComplete()
     */
    public function ordersComplete(){
        $order_model = new NsOrderModel();
        $order_model->startTrans();
        try{
            $time = date("Y-m-d H:i:s", time()+3600*24*7);//暂定为7天
            $condition = array(
                'order_status' => 3,
                'sign_time'  => array('LT', $time)
            );
            $order_list = $order_model->getQuery($condition, 'order_id', '');
            if(!empty($order_list))
            {
                $order = new Order();
                foreach ($order_list as $k => $v)
                {
                    $order->orderComplete($v['order_id']);
                }
        
            }
            $order_model->commit();
            return 1;
        }catch (\Exception $e)
        {
            $order_model->rollback();
            return $e->getMessage();
        }
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IEvents::discountOperation()
     */
    public function discountOperation(){
        $discount = new NsPromotionDiscountModel();
        $discount->startTrans();
        try{
            $time = date("Y-m-d H:i:s", time());
            $discount_goods = new NsPromotionDiscountGoodsModel();
            /************************************************************结束活动**************************************************************/
            $condition_close = array(
                'end_time' => array('LT', $time),
                'status'   => array('NEQ', 3)
            );
             $discount->save(['status' => 4], $condition_close);
             $discount_close_goods_list = $discount_goods->getQuery($condition_close, '*', '');
             if(!empty($discount_close_goods_list))
             {
                 foreach ( $discount_close_goods_list as $k => $discount_goods_item)
                 {
                     $goods = new NsGoodsModel();
             
                     $data_goods = array(
                         'promotion_type' => 2,
                         'promote_id'     => $discount_goods_item['discount_id']
                     );
                     $goods_id_list = $goods->getQuery($data_goods, 'goods_id', '');
                     if(!empty($goods_id_list))
                     {
                         foreach($goods_id_list as $k => $goods_id)
                         {
                             $goods_info = $goods->getInfo(['goods_id' => $goods_id['goods_id']], 'promotion_type,price');
                             $goods->save(['promotion_price' => $goods_info['price']], ['goods_id'=> $goods_id['goods_id'] ]);
                             $goods_sku = new NsGoodsSkuModel();
                             $goods_sku_list = $goods_sku->getQuery(['goods_id'=> $goods_id['goods_id'] ], 'price,sku_id', '');
                             foreach ($goods_sku_list as $k_sku => $sku)
                             {
                                 $goods_sku = new NsGoodsSkuModel();
                                 $data_goods_sku = array(
                                     'promote_price' => $sku['price']
                                 );
                                 $goods_sku->save($data_goods_sku, ['sku_id' => $sku['sku_id']]);
                             }
                             
                         }
                        
                     }
                     $goods->save(['promotion_type' => 0, 'promote_id' => 0], $data_goods);
                    
                 }
             }
             $discount_goods->save(['status' => 4], $condition_close);
             /************************************************************结束活动**************************************************************/
             /************************************************************开始活动**************************************************************/
            $condition_start = array(
                'start_time' => array('ELT', $time),
                'status'   => 0
            );
            //查询待开始活动列表
            $discount_goods_list = $discount_goods->getQuery($condition_start, '*', '');
            if(!empty($discount_goods_list))
            {
                foreach ( $discount_goods_list as $k => $discount_goods_item)
                {
                    $goods = new NsGoodsModel();
                    $goods_info = $goods->getInfo(['goods_id' => $discount_goods_item['goods_id']],'promotion_type,price');
                    $data_goods = array(
                        'promotion_type' => 2,
                        'promote_id'     => $discount_goods_item['discount_id'],
                        'promotion_price'  => $goods_info['price'] *$discount_goods_item['discount']/10 
                    );
                    $goods->save($data_goods,['goods_id' => $discount_goods_item['goods_id']]);
                    $goods_sku = new NsGoodsSkuModel();
                    $goods_sku_list = $goods_sku->getQuery(['goods_id'=> $discount_goods_item['goods_id'] ], 'price,sku_id', '');
                    foreach ($goods_sku_list as $k_sku => $sku)
                    {
                        $goods_sku = new NsGoodsSkuModel();
                        $data_goods_sku = array(
                            'promote_price' => $sku['price']*$discount_goods_item['discount']/10
                        );
                        $goods_sku->save($data_goods_sku, ['sku_id' => $sku['sku_id']]);
                    }
                }
            }
            $discount_goods->save(['status' => 1], $condition_start);
            $discount->save(['status' => 1], $condition_start);
            /************************************************************开始活动**************************************************************/
            $discount->commit();
            return 1;
        }catch (\Exception $e)
        {
            $discount->rollback();
            return $e;
        }
    }
    
}
