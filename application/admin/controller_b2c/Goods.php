<?php
/**
 * Goods.php
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

use data\service\niushop\Express as Express;
use data\service\niushop\Goods as GoodsService;
use data\service\niushop\GoodsBrand as GoodsBrand;
use data\service\niushop\GoodsCategory as GoodsCategory;
use data\service\niushop\GoodsGroup as GoodsGroup;
use data\service\system\Address;
use think\Request;
use data\model\system\AlbumPictureModel;

/**
 * 商品控制器
 */
class Goods extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 根据商品ID查询单个商品，然后进行编辑操作
     *
     * 2016年11月25日 09:42:40
     *
     * @return \data\model\niushop\NsGoodsModel
     */
    public function GoodsSelect()
    {
        $goods_detail = new GoodsService();
        $goods = $goods_detail->getGoodsDetail($_GET['goodsId']);
        return $goods;
    }

    /**
     * 商品列表
     */
    public function goodsList()
    {
        $goodservice = new GoodsService();
        if (request()->isAjax()) {
            $page_index = $_POST["pageIndex"];
            $start_date = ! empty($_POST['start_date']) ? $_POST['start_date'] : '2010-1-1';
            $end_date = ! empty($_POST['end_date']) ? $_POST['end_date'] : '2099-1-1';
            $goods_name = isset($_POST['goods_name']) ? $_POST['goods_name'] : '';
            $state = isset($_POST['state']) ? $_POST['state'] : '';
            $condition["ng.create_time"] = [
                [
                    ">",
                    $start_date
                ],
                [
                    "<",
                    $end_date
                ]
            ];
            if ($state != "") {
                $condition["ng.state"] = $state;
            }
            if (! empty($goods_name)) {
                $condition["ng.goods_name"] = array(
                    "like",
                    "%" . $goods_name . "%"
                );
            }
            $condition["ng.shop_id"] = $this->instance_id;
            $result = $goodservice->getGoodsList($page_index, PAGESIZE, $condition, "ng.create_time desc");
            return $result;
        } else {
            $goods_group = new GoodsGroup();
            $groupList = $goods_group->getGoodsGroupList(1, 0, [
                'shop_id' => $this->instance_id,
                'pid' => 0
            ]);
            if (! empty($groupList['data'])) {
                foreach ($groupList['data'] as $k => $v) {
                    $v['sub_list'] = $goods_group->getGoodsGroupList(1, 0, 'pid = ' . $v['group_id']);
                }
            }
            $result = $goodservice->getGoodsList(1, 10, [
                'ng.shop_id' => 1
            ], "ng.create_time desc");
            $this->assign("goods_group", $groupList['data']);
            $search_info = isset($_GET['search_info']) ? $_GET['search_info'] : '';
            $this->assign("search_info", $search_info);
            return view($this->style . "Goods/goodsList");
        }
    }

    /**
     * 创建时间：2015年6月1日09:40:10 创建人：高伟
     * 功能说明：通过ajax来的得到页面的数据
     */
    public function SelectCateGetData()
    {
        $goods_category_id = $_POST["goods_category_id"]; // 商品类目用
        $goods_category_name = $_POST["goods_category_name"]; // 商品类目名称显示用
        $quick = $_POST["goods_category_quick"]; // JSON格式
        setcookie("goods_category_id", $goods_category_id, time() + 3600 * 24);
        setcookie("goods_category_name", $goods_category_name, time() + 3600 * 24);
        setcookie("goods_category_quick", $quick, time() + 3600 * 24);
    }

    /**
     * 获取用户快速选择商品
     */
    public function getQuickGoods()
    {
        if (isset($_COOKIE["goods_category_quick"])) {
            return $_COOKIE["goods_category_quick"];
        } else {
            return - 1;
        }
    }

    public function getGoodsGroupList()
    {
        $goods_group = new GoodsGroup();
        return $goods_group->getGroupGroup();
    }

    /**
     * 添加商品
     */
    public function addGoods()
    {
        $step = isset($_GET['step']) ? $_GET['step'] : 1;
        if ($step == 1) {
            $goods_category = new GoodsCategory();
            $list = $goods_category->getGoodsCategoryListByParentId(0);
            $this->assign("cateGoryList", $list);
            return view($this->style . 'Goods/selectCategory');
        } else 
            if ($step == 2) {
                $goodsId = isset($_GET["goodsId"]) ? $_GET["goodsId"] : 0;
                $goods_group = new GoodsGroup();
                $groupList = $goods_group->getGoodsGroupList(1, 0, [
                    'shop_id' => $this->instance_id
                ]);
                $goodsbrand = new GoodsBrand();
                $goodsbrandList = $goodsbrand->getGoodsBrandList();
                $express = new Express();
                if (isset($_COOKIE["goods_category_id"])) {
                    $this->assign("goods_category_id", $_COOKIE["goods_category_id"]);
                    $name = str_replace(":", "&gt;", $_COOKIE["goods_category_name"]);
                    $this->assign("goods_category_name", $name);
                } else {
                    $this->assign("goods_category_id", 0); // 修改商品时，会进行查询赋值 2016年12月9日 10:54:07
                    $this->assign("goods_category_name", "");
                }
                $this->assign("shipping_list", $express->shippingFeeQuery(""));
                $this->assign("group_list", $groupList['data']);
                $this->assign("goods_id", $goodsId);
                $this->assign("shop_type", 2);
                $this->assign("goodsbrand_list", $goodsbrandList["data"]);
                return view($this->style . 'Goods/selectCategoryNext');
            }
    }

    /**
     * 创建时间：2015年5月28日11:19:30 创建人：高伟
     * 功能说明：通过节点的ID查询得到某个节点下的子集
     */
    public function getChildCateGory()
    {
        $categoryID = $_POST["categoryID"];
        $goods_category = new GoodsCategory();
        $list = $goods_category->getGoodsCategoryListByParentId($categoryID);
        return $list;
    }

    /**
     * 修改商品
     */
    public function updataGoods()
    {
        return view($this->style . "Goods/addGoods");
    }

    /**
     * 删除商品
     */
    public function deleteGoods()
    {
        $goods_ids = $_POST["goods_ids"];
        $goodservice = new GoodsService();
        $retval = $goodservice->deleteGoods($goods_ids);
        return AjaxReturn($retval);
    }

    /**
     * 商品品牌列表
     */
    public function goodsBrandList()
    {
        if (request()->isAjax()) {
            $page_index = $_POST["pageIndex"];
            $goodsbrand = new GoodsBrand();
            $result = $goodsbrand->getGoodsBrandList($page_index, PAGESIZE, [
                'shop_id' => $this->instance_id
            ]);
            $album = new AlbumPictureModel();
            return $result;
        } else {
            return view($this->style . "Goods/goodsBrandList");
        }
    }

    /**
     * 添加商品品牌
     */
    public function addGoodsBrand()
    {
        if (request()->isAjax()) {
            $goodsbrand = new GoodsBrand();
            $shop_id = $this->instance_id;
            $brand_name = isset($_POST['brand_name']) ? $_POST['brand_name'] : '';
            $brand_initial = isset($_POST['brand_initial']) ? $_POST['brand_initial'] : '';
            $brand_pic = isset($_POST['brand_pic']) ? $_POST['brand_pic'] : '';
            $brand_recommend = isset($_POST['brand_recommend']) ? $_POST['brand_recommend'] : 0;
            $category_name = isset($_POST['category_name']) ? $_POST['category_name'] : '';
            $category_id_1 = isset($_POST['category_id_1']) ? $_POST['category_id_1'] : 0;
            $category_id_2 = isset($_POST['category_id_2']) ? $_POST['category_id_2'] : 0;
            $category_id_3 = isset($_POST['category_id_3']) ? $_POST['category_id_3'] : 0;
            $sort = 1;
            $brand_category_name = '';
            $category_id_array = 1;
            $brand_ads = isset($_POST['brand_ads']) ? $_POST['brand_ads'] : '';
            $res = $goodsbrand->addOrUpdateGoodsBrand('', $shop_id, $brand_name, $brand_initial, '', $brand_pic, $brand_recommend, $sort, $brand_category_name, $category_id_array, $brand_ads, $category_name, $category_id_1, $category_id_2, $category_id_3);
            return AjaxReturn($res);
        } else {
            $goodscategory = new GoodsCategory();
            $list = $goodscategory->getGoodsCategoryListByParentId(0);
            $this->assign('goods_category_list', $list);
            return view($this->style . "Goods/addGoodsBrand");
        }
    }

    /**
     * 选择商品分类
     */
    function changeCategory()
    {
        $pid = isset($_POST['pid']) ? $_POST['pid'] : 0;
        $list = array();
        if ($pid > 0) {
            $goodscategory = new GoodsCategory();
            $list = $goodscategory->getGoodsCategoryListByParentId($pid);
        }
        return $list;
    }

    /**
     * 修改商品品牌
     */
    public function updateGoodsBrand()
    {
        $goodsbrand = new GoodsBrand();
        if (request()->isAjax()) {
            $brand_id = isset($_POST['brand_id']) ? ($_POST['brand_id']) : "";
            $brand_name = isset($_POST['brand_name']) ? $_POST['brand_name'] : '';
            $brand_initial = isset($_POST['brand_initial']) ? $_POST['brand_initial'] : '';
            $brand_pic = isset($_POST['brand_pic']) ? $_POST['brand_pic'] : '';
            $brand_recommend = isset($_POST['brand_recommend']) ? $_POST['brand_recommend'] : 0;
            $category_name = isset($_POST['category_name']) ? $_POST['category_name'] : '';
            $category_id_1 = isset($_POST['category_id_1']) ? $_POST['category_id_1'] : 0;
            $category_id_2 = isset($_POST['category_id_2']) ? $_POST['category_id_2'] : 0;
            $category_id_3 = isset($_POST['category_id_3']) ? $_POST['category_id_3'] : 0;
            $sort = 1;
            $brand_category_name = '';
            $category_id_array = 1;
            $shopid = $this->instance_id;
            $brand_ads = isset($_POST['brand_ads']) ? $_POST['brand_ads'] : '';
            $res = $goodsbrand->addOrUpdateGoodsBrand($brand_id, $shopid, $brand_name, $brand_initial, '', $brand_pic, $brand_recommend, $sort, $brand_category_name, $category_id_array, $brand_ads, $category_name, $category_id_1, $category_id_2, $category_id_3);
            return AjaxReturn($res);
        } else {
            $brand_id = $_GET['brand_id'];
            $brand_info = $goodsbrand->getGoodsBrandInfo($brand_id);
            if (empty($brand_info)) {
                return $this->error("没有查询到商品品牌信息");
            }
            $this->assign('brand_info', $brand_info);
            $goodscategory = new GoodsCategory();
            $list = $goodscategory->getGoodsCategoryListByParentId(0);
            $this->assign('goods_category_list', $list);
            return view($this->style . "Goods/editGoodsBrand");
        }
    }

    /**
     * 删除商品品牌
     */
    public function deleteGoodsBrand()
    {
        $brand_id = $_POST['brand_id'];
        $goodsbrand = new GoodsBrand();
        $res = $goodsbrand->deleteGoodsBrand($brand_id);
        return AjaxReturn($res);
    }

    /**
     * 商品分类列表
     */
    public function goodsCategoryList()
    {
        $goodscate = new GoodsCategory();
        $one_list = $goodscate->getGoodsCategoryListByParentId(0);
        if (! empty($one_list)) {
            foreach ($one_list as $k => $v) {
                $two_list = array();
                $two_list = $goodscate->getGoodsCategoryListByParentId($v['category_id']);
                $v['child_list'] = $two_list;
                if (! empty($two_list)) {
                    foreach ($two_list as $k1 => $v1) {
                        $three_list = array();
                        $three_list = $goodscate->getGoodsCategoryListByParentId($v1['category_id']);
                        $v1['child_list'] = $three_list;
                    }
                }
            }
        }
        $this->assign("category_list", $one_list);
        return view($this->style . "Goods/goodsCategoryList");
    }

    /**
     * 添加商品分类
     */
    public function addGoodsCategory()
    {
        $goodscate = new GoodsCategory();
        if (request()->isAjax()) {
            $category_name = $_POST["category_name"];
            $pid = $_POST["pid"];
            $is_visible = $_POST['is_visible'];
            $keywords = $_POST["keywords"];
            $description = $_POST["description"];
            $sort = $_POST["sort"];
            $category_pic = isset($_POST['category_pic']) ? $_POST['category_pic'] : "";
            $short_name = $_POST["short_name"];
            $result = $goodscate->addOrEditGoodsCategory(0, $category_name, $short_name, $pid, $is_visible, $keywords, $description, $sort, $category_pic);
            return AjaxReturn($result);
        } else {
            $category_list = $goodscate->getGoodsCategoryTree(0);
            $this->assign('category_list', $category_list);
            return view($this->style . "Goods/addGoodsCategory");
        }
    }

    /**
     * 修改商品分类
     */
    public function updateGoodsCategory()
    {
        $goodscate = new GoodsCategory();
        if (request()->isAjax()) {
            $category_id = $_POST["category_id"];
            $category_name = $_POST["category_name"];
            $short_name = $_POST["short_name"];
            $pid = $_POST["pid"];
            $is_visible = $_POST['is_visible'];
            $keywords = $_POST["keywords"];
            $description = $_POST["description"];
            $sort = $_POST["sort"];
            $category_pic = $_POST['category_pic'];
            $result = $goodscate->addOrEditGoodsCategory($category_id, $category_name, $short_name, $pid, $is_visible, $keywords, $description, $sort, $category_pic);
            return AjaxReturn($result);
        } else {
            $category_id = $_GET['category_id'];
            $result = $goodscate->getGoodsCategoryDetail($category_id);
            $this->assign("data", $result);
            $category_list = $goodscate->getGoodsCategoryTree(0);
            $this->assign('category_list', $category_list);
            return view($this->style . "Goods/updateGoodsCategory");
        }
    }

    /**
     * 删除商品分类
     */
    public function deleteGoodsCategory()
    {
        $goodscate = new GoodsCategory();
        $category_id = $_POST['category_id'];
        $res = $goodscate->deleteGoodsCategory($category_id);
        return AjaxReturn($res);
    }

    /**
     * 创建时间：2015年6月10日15:25:14 创建人：高伟
     * 功能说明：查询模板的属性数据
     */
    public function CateGoryPropSelect()
    {
        $provList = array(
            array(
                'name' => '颜色'
            ),
            array(
                'name' => '大小'
            ),
            array(
                'name' => '款式'
            )
        );
        return $provList;
    }

    /**
     * 创建时间：2015年6月1日17:17:53 创建人：高伟
     * 功能说明：商品属性规格获取
     */
    public function CateGoryPropsGet()
    {
        $name = $_POST["name"];
        $goodservice = new GoodsService();
        $res = $goodservice->addGoodsAttribute($name);
        return $res;
    }

    /**
     * 创建时间：2015年6月1日17:17:53 创建人：高伟
     * 功能说明：商品属性规格值获取
     */
    public function CateGoryPropvaluesGet()
    {
        $propId = $_POST["propId"];
        $value = $_POST["value"];
        $goodservice = new GoodsService();
        $res = $goodservice->addGoodsAttributeValue($propId, $value);
        return $res;
    }

    /**
     * 创建时间：2015年6月12日09:50:07 创建人：高伟
     * 功能说明：添加或更新商品时 ajax调用的函数
     */
    public function GoodsCreateOrUpdate()
    {
        $product = $_POST["product"];
        $qrcode = $_POST["is_qrcode"]; // 1代表 需要创建 二维码 0代表不需要
        $shopId = $this->instance_id;
        $goodservice = new GoodsService();
        $res = $goodservice->addOrEditGoods($product["goodsId"], // 商品Id
$product["title"], // 商品标题
$shopId, $product["categoryId"], // 商品类目
$category_id_1 = 0, $category_id_2 = 0, $category_id_3 = 0, $product["brandId"], $product["groupArray"], // 商品分组
$goods_type = 1, $product["market_price"], $product["price"], // 商品现价
$product["cost_price"], $product["point_exchange_type"], $product['integration_available_use'], $product['integration_available_give'], $is_member_discount = 0, $product["shipping_fee"], $product["shipping_fee_id"], $product["stock"], $product['max_buy'], $product["minstock"], $product["base_good"], $product["base_sales"], $collects = 0, $star = 0, $evaluates = 0, $product["base_share"], $product["province_id"], $product["city_id"], $product["picture"], 'keywords', $product["introduction"], // 商品描述
$product["description"], '商品二维码', $product["code"], $product["display_stock"], $is_hot = 0, $is_recommend = 0, $is_new = 0, $sort = 0, $product["imageArray"], $product["skuArray"], $product["is_sale"], $product["sku_img_array"]); // sku编码分组
        /*
         * if($res["retval"]==1){
         * if($qrcode==1){
         * $goodsId=$res["data"][0][0]["goodsId"];
         * $filepath=$this->QRcode($goodsId);
         * $this->goods->goods_QRcode_make($goodsId,$filepath);
         * }
         * }
         */
        return $res;
    }

    /**
     * 获取省列表，商品添加时用户可以设置商品所在地
     * 创建人：王永杰
     * 创建时间：2017年2月22日 16:01:26
     */
    public function getProvince()
    {
        $address = new Address();
        $province_list = $address->getProvinceList();
        return $province_list;
    }

    /**
     * 获取城市列表
     * 创建人：王永杰
     * 创建时间：2017年2月22日 16:01:56
     *
     * @return Ambigous <multitype:\think\static , \think\false, \think\Collection, \think\db\false, PDOStatement, string, \PDOStatement, \think\db\mixed, boolean, unknown, \think\mixed, multitype:, array>
     */
    public function getCity()
    {
        $address = new Address();
        $province_id = isset($_POST['province_id']) ? $_POST['province_id'] : 0;
        $city_list = $address->getCityList($province_id);
        return $city_list;
    }

    /**
     * 商品分组列表
     */
    public function goodsGroupList()
    {
        $goodsgroup = new GoodsGroup();
        $one_list = $goodsgroup->getGoodsGroupListByParentId($this->instance_id, 0);
        if (! empty($one_list)) {
            foreach ($one_list as $k => $v) {
                $two_list = array();
                $two_list = $goodsgroup->getGoodsGroupListByParentId($this->instance_id, $v['group_id']);
                $v['child_list'] = $two_list;
            }
        }
        $this->assign("group_list", $one_list);
        return view($this->style . "Goods/goodsGroupList");
    }

    /**
     * 添加商品分组
     */
    public function addGoodsGroup()
    {
        $goodsgroup = new GoodsGroup();
        if (request()->isAjax()) {
            $shop_id = $this->instance_id;
            $group_name = $_POST["group_name"];
            $pid = $_POST["pid"];
            $is_visible = $_POST['is_visible'];
            $sort = $_POST["sort"];
            $group_pic = $_POST['group_pic'];
            $result = $goodsgroup->addOrEditGoodsGroup(0, $shop_id, $group_name, $pid, $is_visible, $sort, $group_pic);
            return AjaxReturn($result);
        } else {
            $group_list = $goodsgroup->getGoodsGroupListByParentId($this->instance_id, 0);
            $this->assign("group_list", $group_list);
            return view($this->style . "Goods/addGoodsGroup");
        }
    }

    /**
     * 修改商品分类
     */
    public function updateGoodsGroup()
    {
        $goodsgroup = new GoodsGroup();
        if (request()->isAjax()) {
            $group_id = $_POST["group_id"];
            $shop_id = $this->instance_id;
            $group_name = $_POST["group_name"];
            $pid = $_POST["pid"];
            $is_visible = $_POST['is_visible'];
            $sort = $_POST["sort"];
            $group_pic = $_POST['group_pic'];
            $result = $goodsgroup->addOrEditGoodsGroup($group_id, $shop_id, $group_name, $pid, $is_visible, $sort, $group_pic);
            return AjaxReturn($result);
        } else {
            $group_id = $_GET['group_id'];
            $result = $goodsgroup->getGoodsGroupDetail($group_id);
            $this->assign("data", $result);
            $group_list = $goodsgroup->getGoodsGroupListByParentId($this->instance_id, 0);
            $this->assign("group_list", $group_list);
            return view($this->style . "Goods/updateGoodsGroup");
        }
    }

    /**
     * 删除商品分类
     */
    public function deleteGoodsGroup()
    {
        $goodsgroup = new GoodsGroup();
        $group_id = $_POST['group_id'];
        $res = $goodsgroup->deleteGoodsGroup($group_id, $this->instance_id);
        return AjaxReturn($res);
    }

    /**
     * 修改 商品 分类 单个字段
     */
    public function modifyGoodsCategoryField()
    {
        $goodscate = new GoodsCategory();
        $fieldid = $_POST['fieldid'];
        $fieldname = $_POST['fieldname'];
        $fieldvalue = $_POST['fieldvalue'];
        $res = $goodscate->ModifyGoodsCategoryField($fieldid, $fieldname, $fieldvalue);
        return $res;
    }

    /**
     * 修改 商品 分组 单个字段
     */
    public function modifyGoodsGroupField()
    {
        $goodsgroup = new GoodsGroup();
        $fieldid = $_POST['fieldid'];
        $fieldname = $_POST['fieldname'];
        $fieldvalue = $_POST['fieldvalue'];
        $res = $goodsgroup->ModifyGoodsGroupField($fieldid, $fieldname, $fieldvalue);
        return $res;
    }

    /**
     * 商品上架
     */
    public function ModifyGoodsOnline()
    {
        $condition = $_POST["goods_ids"]; // 将商品id用,隔开
        $goods_detail = new GoodsService();
        $result = $goods_detail->ModifyGoodsOnline($condition);
        return AjaxReturn($result);
    }

    /**
     * 商品下架
     */
    public function ModifyGoodsOffline()
    {
        $condition = $_POST["goods_ids"]; // 将商品id用,隔开
        $goods_detail = new GoodsService();
        $result = $goods_detail->ModifyGoodsOffline($condition);
        return AjaxReturn($result);
    }

    /**
     * 获取筛选后的商品
     *
     * @return unknown
     */
    public function getSerchGoodsList()
    {
        $page_index = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : 1;
        $condition = isset($_POST['condition']) && $_POST['condition'] != '' ? (" goods_name like  '%{$_POST['condition']}%'") : "";
        $goods_detail = new GoodsService();
        $result = $goods_detail->getSerchGoodsList($page_index, PAGESIZE, $condition);
        return $result;
    }

    /**
     * 获取 商品分组一级分类
     * @return Ambigous <number, unknown>
     */
    public function getGoodsGroupFristLevel(){
        $goods_group = new GoodsGroup();
        $list = $goods_group->getGoodsGroupListByParentId($this->instance_id, 0);
        return $list;
    }

    /**
     * 修改分组
     */
    public function ModifyGoodsGroup()
    {
        $goods_id = $_POST["goods_id"];
        $goods_type = $_POST["goods_type"];
        $goods_detail = new GoodsService();
        $result = $goods_detail->ModifyGoodsGroup($goods_id, $goods_type);
        return AjaxReturn($result);
    }

    /**
     * 修改推荐商品
     */
    public function ModifyGoodsRecommend()
    {
        $goods_ids = $_POST["goods_id"];
        $recommend_type = $_POST["recommend_type"];
        $goods_detail = new GoodsService();
        $result = $goods_detail->ModifyGoodsRecommend($goods_ids, $recommend_type);
        return AjaxReturn($result);
    }
}