<?php
/**
 * IExpress.php
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
namespace data\api\niushop;
/**
 * 物流接口
 */
interface IExpress
{
    /**
     * 获取售卖区域列表
     * @param number $page_index
     * @param number $page_size
     * @param string $condition
     * @param string $order
     */
    function getShippingFeeList($page_index=1, $page_size=0, $condition='', $order = '');
  /**
   * 添加售卖区域
   * @param unknown $shipping_fee_name
   * @param unknown $shipping_fee_ext 扩展数据 格式: 省ID组;市id组;snum; sprice; xnum; xprice|省ID组;市id组;snum; sprice; xnum; xprice
   */
    function addShippingFee($shipping_fee_name, $shipping_fee_ext);
    /**
     * 修改售卖区域
     * @param unknown $shipping_fee_id
     * @param unknown $shipping_fee_name
     * @param unknown $shipping_fee_ext 扩展数据 格式: 省ID组;市id组;snum; sprice; xnum; xprice|省ID组;市id组;snum; sprice; xnum; xprice
     */
    function updateShippingFee($shipping_fee_id,$shipping_fee_name, $shipping_fee_ext);
    /**
     * 获取售卖区域详情
     * @param unknown $shipping_fee_id
     */
    function shippingFeeDetail($shipping_fee_id); 
    /**
     * 删除售卖区域
     * @param unknown $shipping_fee_id
     */ 
    function shippingFeeDelete($shipping_fee_id);
    
    /**
     *  查询运费模版
     * @param unknown $where 条件
     * @param string $fields 字段
     */
    function shippingFeeQuery($where,$fields = "*");
    /**
     * 快递公司列表
     * @param number $page_index
     * @param number $page_size
     * @param string $condition
     * @param string $order
     */
    function getExpressCompanyList($page_index=1, $page_size=0, $condition='', $order = '');
    /**
     * 添加快递公司
     * @param unknown $shopId
     * @param unknown $company_name
     * @param unknown $express_no
     * @param unknown $is_enabled
     * @param unknown $image
     * @param unknown $phone
     * @param unknown $orders
     */
    function addExpressCompany($shopId, $company_name, $express_no, $is_enabled, $image, $phone, $orders);
    /**
     * 修改快递公司
     * @param unknown $co_id
     * @param unknown $shopId
     * @param unknown $company_name
     * @param unknown $express_no
     * @param unknown $is_enabled
     * @param unknown $image
     * @param unknown $phone
     * @param unknown $orders
     */
    function updateExpressCompany($co_id, $shopId, $company_name, $express_no, $is_enabled, $image, $phone, $orders);
    /**
     * 获取快递公司详情
     * @param unknown $co_id
     */
    function expressCompanyDetail($co_id);
    /**
     * 删除快递公司
     * @param unknown $co_id
     */
    function expressCompanyDelete($co_id);
    /**
     * 查询快递公司
     * @param unknown $where
     * @param string $fields
     */
    function expressCompanyQuery($where, $fields= "*");
    /**
     * 添加公司物流地址
     * @param unknown $contact
     * @param unknown $mobile
     * @param unknown $phone
     * @param unknown $company_name
     * @param unknown $province
     * @param unknown $city
     * @param unknown $district
     * @param unknown $zipcode
     * @param unknown $address
     */
    function addShopExpressAddress($contact, $mobile, $phone, $company_name, $province, $city, $district, $zipcode, $address);
    /**
     * 修改公司物流地址
     * @param unknown $express_address_id
     * @param unknown $contact
     * @param unknown $mobile
     * @param unknown $phone
     * @param unknown $company_name
     * @param unknown $province
     * @param unknown $city
     * @param unknown $district
     * @param unknown $zipcode
     * @param unknown $address
     */
    function updateShopExpressAddress($express_address_id, $contact, $mobile, $phone, $company_name, $province, $city, $district, $zipcode, $address);
    /**
     * 修改公司发货标记
     * @param unknown $express_address_id
     * @param unknown $is_consigner
     */
    function modifyShopExpressAddressConsigner($express_address_id, $is_consigner);
    /**
     * 修改公司收货标记
     * @param unknown $express_address_id
     * @param unknown $receiver
     */
    function modifyShopExpressAddressReceiver($express_address_id, $is_receiver);
    /**
     * 获取公司物流地址
     * @param number $page_index
     * @param number $page_size
     * @param string $condition
     * @param string $order
     */
    function getShopExpressAddressList($page_index=1, $page_size=0, $condition='', $order = '');
    /**
     * 获取公司默认收货地址
     */
    function getDefaultShopExpressAddress($shop_id);
    /**
     * 删除物流地址
     * @param unknown $express_address_id_array  ','隔开
     */
    function deleteShopExpressAddress($express_address_id_array);
	
	/**
	 * 查询单挑物流地址详情
	 * @param unknown $express_address_id
	 */
	function selectShopExpressAddressInfo($express_address_id);
	
    
}