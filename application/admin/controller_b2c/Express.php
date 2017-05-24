<?php
/**
 * Express.php
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

use data\service\niushop\Express as ExpressService;
use data\service\system\Address as Address;

/**
 * 物流
 *
 * @author Administrator
 *        
 */
class Express extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 物流地址
     */
    public function expressAddress()
    {
        if (request()->isAjax()) {
            $express = new ExpressService();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $list = $express->getShopExpressAddressList($pageindex, PAGESIZE, [
                'shop_id' => $this->instance_id
            ], '');
            return $list;
        } else {
            return view($this->style . 'Express/expressAddress');
        }
    }

    /**
     * 功能说明：获取省
     * 创建人：李志伟
     * 创建时间：2017年1月4日14:40:31
     */
    public function getProvinceList()
    {
        $address = new Address();
        $data = $address->getProvinceList();
        return $data;
    }

    /**
     * 功能说明：获取市
     * 创建人：李志伟
     * 创建时间：2017年1月4日14:41:02
     */
    public function getCityList()
    {
        $province = $_POST['province'];
        $address = new Address();
        $data = $address->getCityList($province);
        return $data;
    }

    /**
     * 功能说明：获取区/县
     * 创建人：李志伟
     * 创建时间：2017年1月4日14:41:19
     */
    public function getDistrictList()
    {
        $city = $_POST['city'];
        $address = new Address();
        $data = $address->getDistrictList($city);
        return $data;
    }

    /**
     * 添加物流地址
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function addExpressAddress()
    {
        // 获取数据一律使用三元运算符
        $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
        $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $company_name = isset($_POST['company_name']) ? $_POST['company_name'] : '';
        $province = isset($_POST['province']) ? $_POST['province'] : '';
        $city = isset($_POST['city']) ? $_POST['city'] : '';
        $district = isset($_POST['district']) ? $_POST['district'] : '';
        $zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $express = new ExpressService();
        $retval = $express->addShopExpressAddress($contact, $mobile, $phone, $company_name, $province, $city, $district, $zipcode, $address);
        return AjaxReturn($retval);
    }

    /**
     * 功能说明： 根据id查看收货地址详情
     * 创建人：李志伟
     * 创建时间：2017年1月5日11:23:38
     */
    public function ExpressAddressInfo()
    {
        $express_address_id = isset($_POST['express_address_id']) ? $_POST['express_address_id'] : '';
        $express = new ExpressService();
        $retval = $express->selectShopExpressAddressInfo($express_address_id);
        return $retval;
    }

    /**
     * 修改物流地址
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function updateExpressAddress()
    {
        $express = new ExpressService();
        $express_address_id = isset($_POST['express_address_id']) ? $_POST['express_address_id'] : '';
        $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
        $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $company_name = isset($_POST['company_name']) ? $_POST['company_name'] : '';
        $province = isset($_POST['province']) ? $_POST['province'] : '';
        $city = isset($_POST['city']) ? $_POST['city'] : '';
        $district = isset($_POST['district']) ? $_POST['district'] : '';
        $zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $retval = $express->updateShopExpressAddress($express_address_id, $contact, $mobile, $phone, $company_name, $province, $city, $district, $zipcode, $address);
        return AjaxReturn($retval);
    }

    /**
     * 运费模板管理
     */
    public function getShippingFeeList()
    {
        if (request()->isAjax()) {
            $shippingfee_list = new ExpressService();
            $page_index = $_POST["pageindex"];
            $list = $shippingfee_list->getShippingFeeList($page_index, $page_size = 20, $condition = '', $order = '');
            return $list;
        } else {
            return view($this->style . 'Express/getShippingFeeList');
        }
    }

    /**
     * 添加运费模板
     */
    public function addShippingfee()
    {
        $Area = new Address();
        $Arealist = $Area->getAreaList();
        foreach ($Arealist as $k => $v) {
            $list[$k]['data'] = $v;
            $list[$k]['data']['province'] = $Area->getProvinceList($list[$k]['data']['area_id']);
            foreach ($list[$k]['data']['province'] as $k => $v) {
                $list[$k]['data']['city'] = $Area->getCityList($v["province_id"]);
            }
        }
        $this->assign("list", $list);
        return view($this->style . 'Express/addShippingFee');
    }

    /**
     * 功能说明：运费模板管理-列表分页
     * 创建人：耿鹏鹏
     * 创建时间：2015-6-11 12:04
     */
    public function Transportation()
    {
        if (request()->isAjax()) {
            $pageindex = isset($_POST['pageindex']) ? $_POST['pageindex'] : 1;
            $template_name = isset($_POST['template_name']) ? $_POST['template_name'] : '';
            $shippingfee_list = new ExpressService();
            $express_list_pagequery = $shippingfee_list->getShippingFeeList($pageindex, $page_size = 20, $condition = '', $order = '');
            $totalcount = $express_list_pagequery['total_count'];
            $pagecount = $express_list_pagequery['page_count'];
            $this->assign('pageindex', $pageindex);
            $this->assign('template_name', $template_name);
            $this->assign('totalcount', $totalcount);
            $this->assign('pagecount', $pagecount);
            $this->assign('express_list_pagequery', $express_list_pagequery['data']); // 列表
            return view($this->style . 'Express/TransportationPage');
        } else {
            return view($this->style . 'Express/Transportation');
        }
    }

    /**
     * 功能说明：运费模板管理-添加
     * 创建人：耿鹏鹏
     * 创建时间：2015-6-17 10:39
     */
    public function TransportationAdd()
    {
        if (request()->isAjax()) {
            $shipping_fee_name = $_POST["shipping_fee_name"];
            $shipping_fee_ext = $_POST["shipping_fee_ext"];
            $express = new ExpressService();
            $retval = $express->addShippingFee($shipping_fee_name, $shipping_fee_ext);
            return AjaxReturn($retval);
        } else {
            $address = new Address();
            $retval = $address->getAreaTree();
            $this->assign("address_list", $retval);
            return view($this->style . 'Express/TransportationAdd');
        }
    }

    /**
     * 功能说明：运费模板管理-编辑显示
     * 创建人：耿鹏鹏
     * 创建时间：2015-6-17 10:39
     */
    public function TransportationEdit()
    {
        $express = new ExpressService();
        if (request()->isAjax()) {
            $shipping_fee_id = $_POST["shipping_fee_id"];
            $shipping_fee_name = $_POST["shipping_fee_name"];
            $shipping_fee_ext = $_POST["shipping_fee_ext"];
            $retval = $express->updateShippingFee($shipping_fee_id, $shipping_fee_name, $shipping_fee_ext);
            return AjaxReturn($retval);
        } else {
            $shipping_fee_id = $_GET["shipping_fee_id"];
            $this->assign("shipping_fee_id", $shipping_fee_id);
            $address = new Address();
            $tree = $address->getAreaTree();
            $this->assign("address_list", $tree);
            $order_shipping_fee_info = $express->shippingFeeDetail($shipping_fee_id);
            $default_info = array(
                "1" => array(),
                "0" => array()
            );
            foreach ($order_shipping_fee_info["order_shipping_fee_ext_info"] as $v) {
                $default_info[$v["is_default"]][] = $v;
            }
            $this->assign("shipping_fee_name", $order_shipping_fee_info["shipping_fee_name"]);
            $this->assign("order_shipping_fee_info", $default_info);
            return view($this->style . 'Express/TransportationEdit');
        }
    }

    /**
     * 运费模板删除
     */
    public function TransportationDelete()
    {
        $shipping_fee_id = $_POST["shipping_fee_id"];
        $express = new ExpressService();
        $retval = $express->shippingFeeDelete($shipping_fee_id);
        return AjaxReturn($retval);
    }

    /**
     * 功能：物流公司
     * 创建：左骐羽
     * 时间：2016年12月9日11:45:07
     */
    public function expressCompany()
    {
        $expressCompany = new ExpressService();
        if (request()->isAjax()) {
            $page_index = isset($_POST['page_index']) ? $_POST['page_index'] : 1;
            $search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
            $condition = array(
                'shopId' => $this->instance_id,
                'company_name|express_no' => array(
                    'like',
                    '%' . $search_text . '%'
                )
            );
            $retval = $expressCompany->getExpressCompanyList($page_index, PAGESIZE, $condition);
            return $retval;
        }
        return view($this->style . 'Express/expressCompany');
    }

    /**
     * 功能：添加物流公司
     * 创建：左骐羽
     * 时间：2016年12月9日14:43:18
     */
    public function addExpressCompany()
    {
        $expressCompany = new ExpressService();
        if (request()->isAjax()) {
            $shopId = $this->instance_id;
            $company_name = $_POST['company_name'];
            $express_no = $_POST['express_no'];
            $is_enabled = $_POST['is_enabled'];
            $image = isset($_POST['image']) ? $_POST['image'] : '';
            $phone = $_POST['phone'];
            $orders = $_POST['orders'];
            $retval = $expressCompany->addExpressCompany($shopId, $company_name, $express_no, $is_enabled, $image, $phone, $orders);
            return AjaxReturn($retval);
        }
        return view($this->style . 'Express/addExpressCompany');
    }

    /**
     * 功能：修改物流公司信息
     * 创建：左骐羽
     * 时间：2016年12月9日16:07:27
     */
    public function updateExpressCompany()
    {
        $expressCompany = new ExpressService();
        if (request()->isAjax()) {
            $co_id = $_POST['co_id'];
            $shopId = $this->instance_id;
            $company_name = $_POST['company_name'];
            $express_no = $_POST['express_no'];
            $is_enabled = $_POST['is_enabled'];
            $image = isset($_POST['image']) ? $_POST['image'] : '';
            $phone = $_POST['phone'];
            $orders = $_POST['orders'];
            $retval = $expressCompany->updateExpressCompany($co_id, $shopId, $company_name, $express_no, $is_enabled, $image, $phone, $orders);
            return AjaxReturn($retval);
        }
        $co_id = $_GET['co_id'];
        $expressCompanyinfo = $expressCompany->expressCompanyDetail($co_id);
        $this->assign('expressCompany', $expressCompanyinfo);
        return view($this->style . 'Express/updateExpressCompany');
    }

    /**
     * 功能：删除物流公司
     * 创建：左骐羽
     * 时间：2016年12月9日16:42:14
     */
    public function expressCompanyDelete()
    {
        if (request()->isAjax()) {
            $expressCompany = new ExpressService();
            $co_id = $_POST['co_id'];
            $retval = $expressCompany->expressCompanyDelete($co_id);
            return AjaxReturn($retval);
        }
    }

    /**
     * 功能说明：物流地址删除
     * 创建：李志伟
     * 时间：2017年1月4日17:20:27
     */
    public function deleteShopExpressAddress()
    {
        if (request()->isAjax()) {
            $expressCompany = new ExpressService();
            $express_address_id = $_POST['express_address_id'];
            $retval = $expressCompany->deleteShopExpressAddress($express_address_id);
            return AjaxReturn($retval);
        }
    }

    /**
     * 功能说明：设置默认地址
     * $addressType 为0发货地址 1收货地址
     * 创建人：李志伟
     * 创建时间：2017-1-5 12:10:02
     */
    public function modifyShopExpressAddress()
    {
        if (request()->isAjax()) {
            $expressCompany = new ExpressService();
            $addressType = isset($_POST['addressType']) ? $_POST['addressType'] : '';
            $express_address_id = isset($_POST['express_address_id']) ? $_POST['express_address_id'] : '';
            if ($addressType == 0) {
                $retval = $expressCompany->modifyShopExpressAddressConsigner($express_address_id, 1);
            } else 
                if ($addressType == 1) {
                    $retval = $expressCompany->modifyShopExpressAddressReceiver($express_address_id, 1);
                }
            return AjaxReturn($retval);
        }
    }
}