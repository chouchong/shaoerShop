<?php
/**
 * Express.php
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
 * 商品服务层
 */
use data\service\BaseService as BaseService;
use data\api\niushop\IExpress as IExpress;
use data\model\niushop\NsOrderShippingFeeModel as NsOrderShippingFeeModel;
use data\model\niushop\NsOrderShippingFeeExtendModel as NsOrderShippingFeeExtendModel;
use data\service\system\Address as Address;
use data\model\niushop\NsOrderExpressCompanyModel;
use data\model\niushop\NsShopExpressAddressModel;
class Express extends BaseService implements IExpress
{
	/* (non-PHPdoc)
     * @see \data\api\niushop\IExpress::getShippingFeeList()
     */
    public function getShippingFeeList($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        $ns_order_shipping_fee = new NsOrderShippingFeeModel();
        $list = $ns_order_shipping_fee->pageQuery($page_index, $page_size, $condition, $order,'*');
        $address = new Address();
      /*   $province = $address->getProvinceList();
        $city=$address->getCityList(); */
        foreach ($list['data'] as $k => $v)
        {
            $shipping_fee_ext = new NsOrderShippingFeeExtendModel();
            $list_ext = $shipping_fee_ext->where('shipping_fee_id='.$v['shipping_fee_id'])->select();
    
            $list['data'][$k]['ext'] = $list_ext;            
            //获取物流省市
            $address = new Address();
            foreach($list['data'][$k]['ext'] as $m=>$q){
           
                $province_name = $address->getProvinceName($q["province_id"]);
                $city_name = $address->getCityName($q["city_id"]);
                $q["address_name"] = $province_name. ' '. $city_name;
            }
        }
        return $list;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IExpress::addShippingFee()
     */
    public function addShippingFee($shipping_fee_name, $shipping_fee_ext)
    {
        $order_shipping_fee = new NsOrderShippingFeeModel();       
        $order_shipping_fee->startTrans();
         try{
                $data = array(
                    'shipping_fee_name' => $shipping_fee_name,
                    'shop_id' => $this->instance_id,
                    'create_time' => date('Y-m-d H:i:s', time())
                );
                $order_shipping_fee->save($data);
                $new_shipping_fee_id = $order_shipping_fee->shipping_fee_id; 
                if(!empty($new_shipping_fee_id))
                {
                    $shipping_fee_ext_array = explode('|', $shipping_fee_ext);
                    foreach ($shipping_fee_ext_array as $k => $v)
                    {
                        $shipping_fee_ext_data = explode(';', $v);
                       
                        $data_ext = array(
                            'shipping_fee_id' => $new_shipping_fee_id,
                            'province_id' => $shipping_fee_ext_data[0],
                            'city_id' => $shipping_fee_ext_data[1],
                            'snum' => $shipping_fee_ext_data[2],
                            'sprice' => $shipping_fee_ext_data[3],
                            'xnum' => $shipping_fee_ext_data[4],
                            'xprice' => $shipping_fee_ext_data[5],
                            'is_default'=>$shipping_fee_ext_data[6]
                        );
                        $order_shipping_fee_ext = new NsOrderShippingFeeExtendModel();
                        $order_shipping_fee_ext->save($data_ext);                       
                    }                                  
                    $order_shipping_fee->commit();
                    return 1;
                }
                return -1;
               
          
        }catch (\Exception $e) {
            $order_shipping_fee->rollback();
            return $e->getMessage();
        }
        return -1; 
        
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IExpress::updateShippingFee()
     */
    public function updateShippingFee($shipping_fee_id, $shipping_fee_name, $shipping_fee_ext)
    {
        $order_shipping_fee = new NsOrderShippingFeeModel();
        $order_shipping_fee_ext = new NsOrderShippingFeeExtendModel();
        $order_shipping_fee->startTrans();
        try{
            $data = array(
                'shipping_fee_name' => $shipping_fee_name,
                'shop_id' => $this->instance_id,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $new_shipping_fee_id = $order_shipping_fee->save($data,['shipping_fee_id' => $shipping_fee_id]);
            $new_shipping_fee_id=$shipping_fee_id;
            if(!empty($new_shipping_fee_id))
            {
                  $order_shipping_fee_ext->destroy(['shipping_fee_id' => $shipping_fee_id]);
                  $shipping_fee_ext_array = explode('|', $shipping_fee_ext);
                  
                    foreach ($shipping_fee_ext_array as $k => $v)
                    {
                        $shipping_fee_ext_data = explode(';', $v);
                        $data_ext = array(
                            'shipping_fee_id' => $new_shipping_fee_id,
                            'province_id' => $shipping_fee_ext_data[0],
                            'city_id' => $shipping_fee_ext_data[1],
                            'snum' => $shipping_fee_ext_data[2],
                            'sprice' => $shipping_fee_ext_data[3],
                            'xnum' => $shipping_fee_ext_data[4],
                            'xprice' => $shipping_fee_ext_data[5],
                            'is_default'=>$shipping_fee_ext_data[6]
                        );
                        $order_shipping_fee_ext = new NsOrderShippingFeeExtendModel();
                        $order_shipping_fee_ext-> save($data_ext);
                    }
                   
                    
                    $order_shipping_fee->commit();
                    return 1;
            }
            return -1;
             
        
        }catch (\Exception $e) {
            $order_shipping_fee->rollback();
            return $e->getMessage();
        }
        return -1;
        // TODO Auto-generated method stub
        
    }
    /* (non-PHPdoc)
     * @see \data\api\niushop\IExpress::shippingFeeDetail()
     */
    public  function shippingFeeDetail($shipping_fee_id){
        $order_shipping_fee = new NsOrderShippingFeeModel();
        $order_shipping_fee_ext = new NsOrderShippingFeeExtendModel();
        $order_shipping_fee_info=$order_shipping_fee->get($shipping_fee_id);
        $order_shipping_fee_ext_info=$order_shipping_fee_ext->all(['shipping_fee_id'=>$shipping_fee_id]);
        $order_shipping_fee_info["order_shipping_fee_ext_info"]=$order_shipping_fee_ext_info;
        //获取物流省市             
        $address = new Address();
        $province = $address->getProvinceList();
        $city=$address->getCityList();
        foreach($order_shipping_fee_info["order_shipping_fee_ext_info"] as $k=>$v){
            $address_name="";
            $address_id ="";
            $province_array = explode(",", $v["province_id"]);
            $city_array = explode(",", $v["city_id"]);
            foreach($province_array as $e){
                foreach($province as $p){
                    if($e == $p["province_id"]){
                        $address_id = $address_id.$p["province_id"].",";
                        $address_name =$address_name.$p["province_name"].",";
                    }
                }
            }
            foreach($city_array as $c){
                foreach($city as $z){
                    if($c == $z["city_id"]){
                        $address_id = $address_id.$z["province_id"].":100".$z["city_id"].",";
                        $address_name =$address_name.$z["city_name"].",";
                    }
                }
            }
            $v["address_name"] = $address_name;
            $v["address_id"] = $address_id;
        }
        return $order_shipping_fee_info;
    }
    /* (non-PHPdoc)
     * @see \data\api\niushop\IExpress::shippingFeeDelete()
     */
    public function shippingFeeDelete($shipping_fee_id){
        $order_shipping_fee = new NsOrderShippingFeeModel();
        $order_shipping_fee_ext = new NsOrderShippingFeeExtendModel();
        $order_shipping_return = $order_shipping_fee->destroy($shipping_fee_id);
        if($order_shipping_return >0){
            $order_shipping_fee_ext->destroy(['shipping_fee_id','=',$shipping_fee_id]);
            return 1;
        }else{
            return -1;
        }                  
        
    }
    
    /**
     * 运费模板查询
     * {@inheritDoc}
     * @see \data\api\niushop\IExpress::shippingFeeQuery()
     */
    public function shippingFeeQuery($where = "",$fields = "*")
    {
        $order_shipping_fee = new NsOrderShippingFeeModel();
        return $order_shipping_fee->where($where)->field($fields)->select();        
    }
    /**
     * {@inheritDoc}
     * @see \data\api\niushop\IExpress::getExpressCompanyList()
     */
    public function getExpressCompanyList($page_index = 1, $page_size = 0, $condition = '', $order = ''){
        $ns_express_company = new NsOrderExpressCompanyModel();
        $list = $ns_express_company->pageQuery($page_index, $page_size, $condition, $order,'*');
        return $list;
    }
    /**
     * {@inheritDoc}
     * @see \data\api\niushop\IExpress::addExpressCompany()
     */
    public function addExpressCompany($shopId, $company_name, $express_no, $is_enabled, $image, $phone, $orders){
        $ns_express_company = new NsOrderExpressCompanyModel();
        $data = array(
            'shopId' => $shopId,
            'company_name' => $company_name,
            'express_no' => $express_no,
            'is_enabled' => $is_enabled,
            'image' => $image,
            'phone' => $phone,
            'orders' => $orders
        );
        $ns_express_company->save($data);
        return $ns_express_company->co_id;
    }
    /**
     * {@inheritDoc}
     * @see \data\api\niushop\IExpress::updateExpressCompany()
     */
    public function updateExpressCompany($co_id, $shopId, $company_name, $express_no, $is_enabled, $image, $phone, $orders){
        $ns_express_company = new NsOrderExpressCompanyModel();
        $data = array(
            'shopId' => $shopId,
            'company_name' => $company_name,
            'express_no' => $express_no,
            'is_enabled' => $is_enabled,
            'image' => $image,
            'phone' => $phone,
            'orders' => $orders,
        );
        $res = $ns_express_company->save($data, ['co_id' => $co_id]);
        return $res;
    }
    /**
     * {@inheritDoc}
     * @see \data\api\niushop\IExpress::expressCompanyDetail()
     */
    public function expressCompanyDetail($co_id){
        $ns_express_company = new NsOrderExpressCompanyModel();
        return $ns_express_company->get($co_id);
    }
    /**
     * {@inheritDoc}
     * @see \data\api\niushop\IExpress::expressCompanyDelete()
     */
    public function expressCompanyDelete($co_id){
        $ns_express_company = new NsOrderExpressCompanyModel();
        $ns_express_company_return = $ns_express_company->destroy($co_id);
        if($ns_express_company_return > 0){
            return 1;
        }else{
            return -1;
        }
    }
    /**
     * {@inheritDoc}
     * @see \data\api\niushop\IExpress::expressCompanyQuery()
     */
    public function expressCompanyQuery($where = "", $field = "*"){
        $ns_express_company = new NsOrderExpressCompanyModel();
        return $ns_express_company->where($where)->field($field)->select();
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IExpress::addShopExpressAddress()
     */
    public function addShopExpressAddress($contact, $mobile, $phone, $company_name, $province, $city, $district, $zipcode, $address){
        $shop_express_address = new NsShopExpressAddressModel();
        $data_consigner = array(
            'is_consigner' => 0,
            'is_receiver'  => 0
        );
        $shop_express_address->save($data_consigner,['shop_id' => $this->instance_id]);
        $shop_express_address = new NsShopExpressAddressModel();
        $data = array(
            'shop_id'      => $this->instance_id,
            'contact'      => $contact,
            'mobile'        => $mobile,
            'phone'        => $phone,
            'company_name' => $company_name,
            'province'     => $province,
            'city'         => $city,
            'district'     => $district,
            'zipcode'      => $zipcode,
            'address'      => $address,
            'is_consigner' => 1,
            'is_receiver'  => 1,
            'create_date'  => date("Y-m-d H:i:s", time())
        );
            $retval = $shop_express_address-> save($data);
            $express_address_id = $shop_express_address->express_address_id;
        return $express_address_id;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IExpress::updateShopExpressAddress()
     */
    public function updateShopExpressAddress($express_address_id, $contact, $mobile, $phone, $company_name, $province, $city, $district, $zipcode, $address)
    {
        $shop_express_address = new NsShopExpressAddressModel();
        $data = array(
            'contact'      => $contact,
            'mobile'        => $mobile,
            'phone'        => $phone,
            'company_name' => $company_name,
            'province'     => $province,
            'city'         => $city,
            'district'     => $district,
            'zipcode'      => $zipcode,
            'address'      => $address,
            'modify_date'  => date("Y-m-d H:i:s", time())
        );
        $retval = $shop_express_address-> save($data, ['express_address_id' => $express_address_id]);
        return $retval;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IExpress::modifyShopExpressAddressConsigner()
     */
    public function modifyShopExpressAddressConsigner($express_address_id, $is_consigner){
        $shop_express_address = new NsShopExpressAddressModel();
        $shop_express_address->save(['is_consigner' => 0],['shop_id' => $this->instance_id]);
        $retval = $shop_express_address->save(['is_consigner' => 1],['express_address_id' => $express_address_id]);
        return $retval;
        
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IExpress::modifyShopExpressAddressReceiver()
     */
    public function modifyShopExpressAddressReceiver($express_address_id, $is_receiver){
        $shop_express_address = new NsShopExpressAddressModel();
        $shop_express_address->save(['is_receiver' => 0],['shop_id' => $this->instance_id]);
        $retval = $shop_express_address->save(['is_receiver' => 1],['express_address_id' => $express_address_id]);
        return $retval;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IExpress::getShopExpressAddressList()
     */
    public function getShopExpressAddressList($page_index=1, $page_size=0, $condition='', $order = '')
    {
        $shop_express_address = new NsShopExpressAddressModel();
        $list = $shop_express_address->pageQuery($page_index, $page_size, $condition, $order, '*');
        if(!empty($list['data']))
        {
            $address = new Address();
            foreach ($list['data'] as $k => $v)
            {
                
                $address_info = $address->getAddress($v['province'], $v['city'], $v['district']);
                $list['data'][$k]['address_info'] = $address_info;
            }
        }
        return $list;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IExpress::getDefaultShopExpressAddress()
     */
    public function getDefaultShopExpressAddress($shop_id){
        $shop_express_address = new NsShopExpressAddressModel();
        $data = $shop_express_address->getInfo(['shop_id' => $shop_id, 'is_receiver' => 1], '*');
        if(!empty($data))
        {
            $address = new Address();
            $address_info = $address->getAddress($data['province'], $data['city'], $data['district']);
            $data['address_info'] = $address_info;
        }
        return $data;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IExpress::deleteShopExpressAddress()
     */
    public function deleteShopExpressAddress($express_address_id_array)
    {
        $shop_express_address = new NsShopExpressAddressModel();
        $retval = $shop_express_address->destroy($express_address_id_array);
        return $retval;
    }
	/**
     * (non-PHPdoc)
     * @see \data\api\niushop\IExpress::selectShopExpressAddressInfo()
     */
	public function selectShopExpressAddressInfo($express_address_id){
		 $shop_express_address = new NsShopExpressAddressModel();
		 $retval = $shop_express_address->getInfo(['express_address_id' => $express_address_id], '*');
         return $retval;
	}
}