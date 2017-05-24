<?php
/**
 * GoodsExpress.php
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
namespace data\service\niushop\promotion;
use data\model\niushop\NsGoodsModel;
use data\model\niushop\NsGoodsSkuModel;
use data\model\niushop\NsOrderShippingFeeExtendModel;
use data\service\BaseService;
/**
 * 商品邮费操作类
 * @author Administrator
 *
 */
class GoodsExpress extends BaseService{
    function __construct(){
        parent::__construct();
    }
    /*****************************************************************************************订单运费管理开始***************************************************/
    /**
     * 获取商品邮费总和
     * @param unknown $goods_sku_list
     */
    public function getSkuListExpressFee($goods_sku_list, $province, $city)
    {
        $fee = 0;
        if(!empty($goods_sku_list))
        {
            $goods_express_list_array = $this->getSkuGroup($goods_sku_list);
            foreach ( $goods_express_list_array as $k => $v)
            {
                $data = $v['data'];
                $shipping_fee_id = $v['template'];
                if($shipping_fee_id != 0)
                {
                    $express_fee = $this->getSameTemplateSkuListExpressFee($shipping_fee_id, $data, $province, $city);
                    if($express_fee != NULL_EXPRESS_FEE)
                    {
                        $fee += $express_fee;
                    }else{
                        return $express_fee;
                    }
                   
                }
            }
            return $fee;
        } else{
            return $fee;
        }
         
    
    }
    /**
     * 商品进行邮费分组(考虑满减送活动)
     * @param unknown $goods_sku_list   skuid:1,skuid:2,skuid:3
     */
    private function getSkuGroup($goods_sku_list)
    {
        //分离商品
        $goods_sku_list_array = explode( ",", $goods_sku_list);
        //获取商品列表满减送活动,方便查询是否满邮情况
        $goods_mansong = new GoodsMansong();
        $mansong_goods_sku_array = $goods_mansong->getFreeExpressGoodsSkuList($goods_sku_list);
        //获取整体数据
        $goods_express_list_array = array();
        //获取免运费商品列表
        $free_express_list = array();
        //获取所有运费模板ID
        $express_template_list = array();
        //获取非免费商品列表
        $goods_sku_nofree_list = array();
        foreach ($goods_sku_list_array as $k => $goods_sku_array)
        {
            $goods_sku = explode(':', $goods_sku_array);
            $goods_sku_model = new NsGoodsSkuModel();
            $goods_id = $goods_sku_model->getInfo(['sku_id' => $goods_sku[0]], 'goods_id');
            $goods = new NsGoodsModel();
            $shipping_fee = $goods->getInfo(['goods_id' => $goods_id['goods_id']], 'shipping_fee,shipping_fee_id');
            if($shipping_fee['shipping_fee'] <= 0)
            {
                $free_express_list[] = $goods_sku_array;
            }else{
                if(in_array($goods_sku[0], $mansong_goods_sku_array))
                {
                    $free_express_list[] = $goods_sku_array;
                }else{
                    $express_template_list[] = $shipping_fee['shipping_fee_id'];
                    $goods_sku_nofree_list[] = $goods_sku_array.';'.$shipping_fee['shipping_fee_id'];
                }
             
            }
        }
        //组合免费模板数据
        if(!empty($free_express_list))
        {
            $free_list['data'] = $free_express_list;
            $free_list['template'] = 0;
            $goods_express_list_array[] = $free_list;
        }
         
        //去除重复
        if(!empty($express_template_list))
        {
            $express_template_list = array_unique($express_template_list);
        }
        //根据运费模板ID获取对应的sku列表
        foreach ($express_template_list as $k => $template_item )
        {
            $express_new_list = array();
            foreach ($goods_sku_nofree_list as $key_nofree => $nofree_item)
            {
                $nofree_item_array = explode(';', $nofree_item);
                if($template_item == $nofree_item_array[1])
                {
                    $express_new_list[] = $nofree_item_array[0];
                }
            }
            $same_express['data'] = $express_new_list;
            $same_express['template'] = $template_item;
            $goods_express_list_array[] = $same_express;
        }
        return $goods_express_list_array;
    
    }
    /**
     * 获取相同运费模板情况下多个sku列表的运费
     * @param unknown $shipping_fee_id
     * @param unknown $goods_sku_array
     * @param unknown $province
     * @param unknown $city
     */
    private function getSameTemplateSkuListExpressFee($shipping_fee_id, $goods_sku_array,$province, $city)
    {
        if(!empty($goods_sku_array))
        {
            $count = 0;
            foreach ($goods_sku_array as $k=> $v)
            {
                $count_item = explode(':', $v);
                $count = $count + $count_item[1];
            }
            $express_fee = $this->getGoodsShippingExpressFee($shipping_fee_id, $count, $province, $city);
            return $express_fee;
        }else{
            return 0;
        }
    }
    /**
     * 获取模板运费
     * @param unknown $shipping_fee_id
     * @param unknown $amount
     * @param unknown $province
     * @param unknown $city
     */
    private function getGoodsShippingExpressFee($shipping_fee_id, $amount, $province, $city)
    {
        //找到对应模板
        $shipping_fee = new NsOrderShippingFeeExtendModel();
        $fee_array = $shipping_fee->where(['shipping_fee_id' => $shipping_fee_id])->select();
        $temp = array();
        $default = array();
        foreach ($fee_array as $k=> $v)
        {
            if($v['is_default'] == 1)
            {
                $default = $v;
            }
            if(!empty($v['city_id']))
            {
                $city_array = explode(',', $v['city_id']);
                if(in_array($city, $city_array))
                {
                    $temp = $v;
                }
            }
        }
        //如果模板为空，找到默认模板
        if(empty($temp))
        {
            if(!empty($default))
            {
                $temp = $default;
            }else{
                return NULL_EXPRESS_FEE;
            }
           
        }
        if($amount <= $temp['snum'])
        {
            return $temp['sprice'];
        }else{
            $ext_amount = $amount - $temp['snum'];
            if($ext_amount%$temp['xnum'] == 0)
            {
                $ext_data = $ext_amount/$temp['xnum'];
            }else{
                $ext_data = floor($ext_amount/$temp['xnum']) + 1;
            }
    
            return $temp['sprice'] + $ext_data * $temp['xprice'];
        }
        /*****************************************************************************************订单运费管理结束***************************************************/
       
    }
   /**
    * 获取商品运费模板名称
    * @param unknown $shipping_fee_id
    */
    public function getGoodsExpressName($id)
    {
        $name = '';
        $shipping_fee = new NsOrderShippingFeeExtendModel();
        $shipping_fee_info = $shipping_fee->getInfo(['id' => $id], 'snum,sprice,xnum,xprice');
        if(!empty($shipping_fee_info))
        {
            $name = $shipping_fee_info['snum'].'件以下'.$shipping_fee_info['sprice'].'元,'.'超过每'.$shipping_fee_info['xnum'].'件'.$shipping_fee_info['xprice'].'元';
        }
       
        return $name;
    }
    /**
     * 获取商品运费
     * @param unknown $goods_id
     * @param unknown $province_id
     * @param unknown $city_id
     * @return string
     */
    public function getGoodsExpressTemplate($goods_id, $province_id, $city_id)
    {
        $goods = new NsGoodsModel();
        $shipping_fee = $goods->getInfo(['goods_id' => $goods_id], 'shipping_fee,shipping_fee_id');
        if($shipping_fee['shipping_fee'] <= 0)
        {
            return "免邮";
        }else{
            $order_shippingfee = new NsOrderShippingFeeExtendModel();
            $fee_array = $order_shippingfee->where(['shipping_fee_id' => $shipping_fee['shipping_fee_id']])->select();
            $temp = array();
            $default = array();
            foreach ($fee_array as $k=> $v)
            {
                if($v['is_default'] == 1)
                {
                    $default = $v;
                }
               if(!empty($v['city_id']))
                {
                    $city_array = explode(',', $v['city_id']);
                    if(in_array($city_id, $city_array))
                    {
                        $temp = $v;
                    }
                }
            }
            if(!empty($temp))
            {
                return $this->getGoodsExpressName($temp['id']);
            }else{
                if(!empty($default))
                {
                   return $this->getGoodsExpressName($default['id']);
                }else{
                    return '无货';
                }
                 
            }
             
        }
    }
}