<?php
/**
 * Goods.php
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
use data\api\niushop\IGoods as IGoods;
use data\model\niushop\NsGoodsModel as NsGoodsModel;
use data\model\niushop\NsGoodsSkuModel as NsGoodsSkuModel;
use data\model\niushop\NsGoodsViewModel as NsGoodsViewModel;
use data\model\niushop\NsGoodsAttributeValueModel as NsGoodsAttributeValueModel;
use data\model\niushop\NsGoodsAttributeModel as NsGoodsAttributeModel;
use data\model\niushop\NsGoodsCategoryModel as NsGoodsCategoryModel;
use data\model\system\AlbumPictureModel as AlbumPictureModel;
use data\model\niushop\NsGoodsGroupModel as NsGoodsGroupModel;
use data\model\niushop\NsCartModel;
use data\service\niushop\promotion\GoodsMansong;
use data\service\niushop\promotion\GoodsExpress;
use data\service\niushop\promotion\GoodsPreference;
use data\model\niushop\NsPromotionDiscountModel;
use data\model\niushop\NsShopModel;
use data\service\niushop\promotion\GoodsDiscount;
use data\model\niushop\NsGoodsEvaluateModel;
use data\model\niushop\NsConsultModel;
use data\model\niushop\NsConsultTypeModel;
use think\Model;
use think\helper\Arr;
use phpDocumentor\Reflection\Types\Array_;

class Goods extends BaseService implements IGoods
{

    private $goods;

    function __construct()
    {
        parent::__construct();
        $this->goods = new NsGoodsModel();
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::getGoodsList()
     */
    public function getGoodsList($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        //针对商品分类
        if(!empty($condition['ng.category_id']))
        {
            $goods_category = new GoodsCategory();
            $category_list = $goods_category->getCategoryTreeList($condition['ng.category_id']);
            $condition['ng.category_id'] = array('in', $category_list);
        }
        $goods_view = new NsGoodsViewModel();
        $list = $goods_view->getGoodsViewList($page_index, $page_size, $condition, $order);
        if (! empty($list['data'])) {
            // 用户针对商品的收藏
            foreach ($list['data'] as $k => $v) {
                if (! empty($this->uid)) {
                    $member = new Member();
                    $list['data'][$k]['is_favorite'] = $member->getIsMemberFavorites($this->uid, $v['goods_id'], 'goods');
                } else {
                    $list['data'][$k]['is_favorite'] = 0;
                }
                // 查询商品单品活动信息
                $goods_preference = new GoodsPreference();
                $goods_promotion_info = $goods_preference->getGoodsPromote($v['goods_id']);
                $list["data"][$k]['promotion_info'] = $goods_promotion_info;
            }
        }
        return $list;
        
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::getGoodsCount()
     */
    public function getGoodsCount($condition)
    {
        $count = $this->goods->where($condition)->count();
        return $count;
        
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::addOrEditGoods()
     */
    public function addOrEditGoods($goods_id, $goods_name, $shopid, $category_id, $category_id_1, $category_id_2, $category_id_3, $brand_id, $group_id_array, $goods_type, $market_price, $price, $cost_price, $point_exchange_type, $point_exchange, $give_point, $is_member_discount, $shipping_fee, $shipping_fee_id, $stock, $max_buy, $min_stock_alarm, $clicks, $sales, $collects, $star, $evaluates, $shares, $province_id, $city_id, $picture, $keywords, $introduction, $description, $QRcode, $code, $is_stock_visible, $is_hot, $is_recommend, $is_new, $sort, $image_array, $sku_array, $state, $sku_img_array)
    {
        $error = 0;
        $category_list = $this->getGoodsCategoryId($category_id);
        $this->goods->startTrans();
        try {
            $data_goods = array(
                'goods_name' => $goods_name,
                'shop_id' => $shopid,
                'category_id' => $category_id,
                'category_id_1' => $category_list[0],
                'category_id_2' => $category_list[1],
                'category_id_3' => $category_list[2],
                'brand_id' => $brand_id,
                'group_id_array' => $group_id_array,
                'goods_type' => $goods_type,
                'market_price' => $market_price,
                'price' => $price,
                'promotion_price' => $price,
                'cost_price' => $cost_price,
                'point_exchange_type' => $point_exchange_type,
                'point_exchange' => $point_exchange,
                'give_point' => $give_point,
                'is_member_discount' => $is_member_discount,
                'shipping_fee' => $shipping_fee,
                'shipping_fee_id' => $shipping_fee_id,
                'stock' => $stock,
                'max_buy' => $max_buy,
                'min_stock_alarm' => $min_stock_alarm,
                'clicks' => $clicks,
                'sales' => $sales,
                'collects' => $collects,
                'star' => $star,
                'evaluates' => $evaluates,
                'shares' => $shares,
                'province_id' => $province_id,
                'city_id' => $city_id,
                'picture' => $picture,
                'keywords' => $keywords,
                'introduction' => $introduction,
                'description' => $description,
                'QRcode' => $QRcode,
                'code' => $code,
                'is_stock_visible' => $is_stock_visible,
                // 'is_hot' => $is_hot,
                // 'is_recommend' => $is_recommend,
                // 'is_new' => $is_new,
                'sort' => $sort,
                'img_id_array' => $image_array,
                'state' => $state,
                'sku_img_array' => $sku_img_array
            );
            if ($goods_id == 0) {
                $data_goods['create_time'] = date("Y-m-d H:i:s", time());
                $data_goods['sale_date'] = date("Y-m-d H:i:s", time());
                $res = $this->goods->save($data_goods);
                // 添加sku
                if (! empty($sku_array)) {
                    $sku_list_array = explode('§', $sku_array);
                    
                    foreach ($sku_list_array as $k => $v) {
                        $res = $this->addOrUpdateGoodsSkuItem($this->goods->goods_id, $v);
                        if (! $res) {
                            $error = 1;
                        }
                    }
                } else {
                    $goods_sku = new NsGoodsSkuModel();
                    $retval = $goods_sku->destroy([
                        'goods_id' => $goods_id
                    ]);
                    // 添加一条skuitem
                    $sku_data = array(
                        'goods_id' => $this->goods->goods_id,
                        'sku_name' => $goods_name,
                        'market_price' => $market_price,
                        'price' => $price,
                        'promote_price' => $price,
                        'cost_price' => $cost_price,
                        'stock' => $stock,
                        'picture' => 0,
                        'code' => $code,
                        'QRcode' => '',
                        'create_date' => date('Y-m-d H:i:s', time())
                    );
                    $res = $goods_sku->save($sku_data);
                    if (! $res) {
                        $error = 1;
                    }
                }
            } else {
                $data_goods['update_time'] = date("Y-m-d H:i:s", time());
                $res = $this->goods->save($data_goods, [
                    'goods_id' => $goods_id
                ]);
                if (! empty($sku_array)) {
                    $sku_list_array = explode('§', $sku_array);
                    $this->deleteSkuItem($goods_id, $sku_list_array);
                    foreach ($sku_list_array as $k => $v) {
                        $res = $this->addOrUpdateGoodsSkuItem($goods_id, $v);
                        if (! $res) {
                            $error = 1;
                        }
                    }
                } else {
                    $goods_sku = new NsGoodsSkuModel();
                    $sku_data = array(
                        'sku_name' => $goods_name,
                        'market_price' => $market_price,
                        'price' => $price,
                        'promote_price' => $price,
                        'cost_price' => $cost_price,
                        'stock' => $stock,
                        'picture' => 0,
                        'code' => $code,
                        'QRcode' => ''
                    );
                    $res = $goods_sku->save($sku_data, [
                        'goods_id' => $goods_id
                    ]);
                }
            }
            
            if ($error == 0) {
                $this->goods->commit();
                return 1;
            } else {
                $this->goods->rollback();
                return 0;
            }
        } catch (\Exception $e) {
            $this->goods->rollback();
            return $e->getMessage();
        }
        return 0;
        
        // TODO Auto-generated method stub
    }

    /**
     * 获取单个商品的sku属性
     *
     * {@inheritdoc}
     *
     * @see \data\api\niushop\IGoods::getGoodsSkuAll()
     */
    public function getGoodsAttribute($goods_id)
    {
        // 查询商品sku表
        $goods_sku = new NsGoodsSkuModel();
        $list = $goods_sku->where('goods_id=' . $goods_id)->select();
        // 查询属性与属性值
        $attrbute_list = array();
        $attrbute_value_list = array();
        if (! empty($list[0]['attr_value_items'])) {
            $attr_array = explode(';', $list[0]['attr_value_items']);
            $attr_str = array();
            foreach ($attr_array as $k => $v) {
                $item_array = explode(':', $v);
                $attr_str[] = $item_array[0];
            }
            $attrbute = new NsGoodsAttributeModel();
            $attrbute_list = $attrbute->all($attr_str);
            $attr_value_array = array();
            foreach ($list as $k => $v) {
                $attr_all_array = explode(';', $v['attr_value_items']);
                foreach ($attr_all_array as $k => $v) {
                    $item_array = explode(':', $v);
                    $attr_value_array[] = $item_array[1];
                }
            }
            $attrbute_value = new NsGoodsAttributeValueModel();
            $attrbute_value_list = $attrbute_value->all($attr_value_array);
        }
        $attribute['attribute_list'] = $attrbute_list;
        $attribute['attribute_value_list'] = $attrbute_value_list;
        
        return $attribute;
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::getGoodsSku()
     */
    public function getGoodsSku($goods_id)
    {
        $goods_sku = new NsGoodsSkuModel();
        $list = $goods_sku->get([
            'goods_id' => $goods_id
        ]);
        return $list;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::editGoodsSku()
     */
    public function ModifyGoodsSku($goods_id, $sku_list)
    {
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::editGoodsPromotionPrice()
     */
    public function ModifyGoodsPromotionPrice($condition)
    {
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::getGoodsImg()
     */
    public function getGoodsImg($goods_id)
    {
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::editGoodsOffline()
     */
    public function ModifyGoodsOffline($condition)
    {
        $data = array(
            "state" => 0
        );
        $result = $this->goods->save($data, "goods_id  in($condition)");
        // TODO Auto-generated method stub
        if ($result > 0) {
            return SUCCESS;
        } else {
            return UPDATA_FAIL;
        }
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::editGoodsOnline()
     */
    public function ModifyGoodsOnline($condition)
    {
        $data = array(
            "state" => 1
        );
        $result = $this->goods->save($data, "goods_id  in($condition)");
        // TODO Auto-generated method stub
        if ($result > 0) {
            return SUCCESS;
        } else {
            return UPDATA_FAIL;
        }
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::deleteGoods()
     */
    public function deleteGoods($goods_id)
    {
        $res = $this->goods->destroy($goods_id);
        // TODO Auto-generated method stub
        if ($res > 0) {
            return SUCCESS;
        } else {
            return DELETE_FAIL;
        }
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::deleteGoodImages()
     */
    public function deleteGoodImages($goods_id)
    {
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::getGoodsDetail()
     */
    public function getGoodsDetail($goods_id)
    {
        // 查询商品主表
        $goods = new NsGoodsModel();
        $goods_detail = $goods->get($goods_id);
        if ($goods_detail == null) {
            return null;
        }
        // 查询商品分组表
        $goods_group = new NsGoodsGroupModel();
        $goods_group_list = $goods_group->all($goods_detail['group_id_array']);
        $goods_detail['goods_group_list'] = $goods_group_list;
        // 查询商品sku表
        $goods_sku = new NsGoodsSkuModel();
        $goods_sku_detail = $goods_sku->where('goods_id=' . $goods_id)->select();
        $goods_detail['sku_list'] = $goods_sku_detail;
        // 查询属性与属性值
        $attrbute_list = array();
        $attrbute_value_list = array();
        if (! empty($goods_sku_detail[0]['attr_value_items'])) {
            $attr_array = explode(';', $goods_sku_detail[0]['attr_value_items']);
            $attr_str = array();
            foreach ($attr_array as $k => $v) {
                $item_array = explode(':', $v);
                $attr_str[] = $item_array[0];
            }
            $attrbute = new NsGoodsAttributeModel();
            $attrbute_list = $attrbute->all($attr_str);
            //
            $attr_value_array = array();
            foreach ($goods_sku_detail as $k => $v) {
                $attr_all_array = explode(';', $v['attr_value_items']);
                foreach ($attr_all_array as $k => $v) {
                    $item_array = explode(':', $v);
                    $attr_value_array[] = $item_array[1];
                }
            }
            $attrbute_value = new NsGoodsAttributeValueModel();
            $attrbute_value_list = $attrbute_value->all($attr_value_array);
        }
        $goods_detail['attribute_list'] = $attrbute_list;
        $goods_detail['attribute_value_list'] = $attrbute_value_list;
        // 查询图片表
        $goods_img = new AlbumPictureModel();
        $goods_img_list = $goods_img->all($goods_detail['img_id_array']);
        $goods_picture = $goods_img->get($goods_detail['picture']);
        $goods_detail['img_list'] = $goods_img_list;
        $goods_detail['picture_detail'] = $goods_picture;
        // 查询分类名称
        $category_name = $this->getGoodsCategoryName($goods_detail['category_id_1'], $goods_detail['category_id_2'], $goods_detail['category_id_3']);
        $goods_detail['category_name'] = $category_name;
        // 查询商品属性值对应图片
        $attr_sku_img_list = array();
        $attr_sku_img_array = explode(';', $goods_detail['sku_img_array']);
        foreach ($attr_sku_img_array as $k => $v) {
            if (! empty($v)) {
                $attr_sku_img_item = explode(',', $v);
                $sku_picture = $goods_img->get($attr_sku_img_item[2]);
                $attr_sku_img_list[] = array(
                    'attr_id' => $attr_sku_img_item[0],
                    'attr_value_id' => $attr_sku_img_item[1],
                    'pic_id' => $attr_sku_img_item[2],
                    'img' => $sku_picture
                );
            }
        }
        $goods_detail['attr_sku_img_list'] = $attr_sku_img_list;
        // 查询商品单品活动信息
        $goods_preference = new GoodsPreference();
        $goods_promotion_info = $goods_preference->getGoodsPromote($goods_id);
        if (! empty($goods_promotion_info)) {
            $goods_discount_info = new NsPromotionDiscountModel();
            $goods_detail['promotion_detail'] = $goods_discount_info->getInfo([
                'discount_id' => $goods_detail['promote_id']
            ], 'start_time, end_time');
        }
        $goods_detail['promotion_info'] = $goods_promotion_info;
        // 查询商品满减送活动
        $goods_mansong = new GoodsMansong();
        $goods_detail['mansong_name'] = $goods_mansong->getGoodsMansongName($goods_id);
        $goods_express = new GoodsExpress();
        $goods_detail['shipping_fee_name'] = $goods_express->getGoodsExpressTemplate($goods_id, 1,1);
        
        $shop_model = new NsShopModel();
        $shop_name = $shop_model->getInfo(array(
            "shop_id" => $goods_detail["shop_id"]
        ), "shop_name");
        $goods_detail["shop_name"] = $shop_name["shop_name"];
        return $goods_detail;
        // TODO Auto-generated method stub
    }

    /**
     * 商品规格列表(non-PHPdoc)
     *
     * @see \data\api\niushop\IGoods::getGoodsAttributeList()
     */
    public function getGoodsAttributeList($condition, $field)
    {
        $attribute = new NsGoodsAttributeModel();
        $list = $attribute->where($condition)->clumn($field);
        return $list;
    }

    /**
     * 商品规格值列表(non-PHPdoc)
     *
     *
     * @see \data\api\niushop\IGoods::getGoodsAttributeValueList()
     */
    public function getGoodsAttributeValueList($condition, $field)
    {
        $attribute = new NsGoodsAttributeModel();
        $list = $attribute->where($condition)->clumn($field);
        return $list;
    }

    /*
     * 添加商品规格
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::addGoodsAttribute()
     */
    public function addGoodsAttribute($attribute_name, $sort = 0)
    {
        $attribute = new NsGoodsAttributeModel();
        $data = array(
            'shop_id' => $this->instance_id,
            'attr_name' => $attribute_name,
            'sort' => 0,
            'create_time' => date('y-m-d h:i:s', time())
        );
        $find_id = $attribute->get([
            'attr_name' => $attribute_name
        ]);
        if (! empty($find_id)) {
            return $find_id['attr_id'];
        } else {
            $res = $attribute->save($data);
            return $attribute->attr_id;
        }
        
        // TODO Auto-generated method stub
    }

    /*
     * 添加商品规格值
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::addGoodsAttributeValue()
     */
    public function addGoodsAttributeValue($attr_id, $attr_value, $sort = 0)
    {
        $attribute = new NsGoodsAttributeValueModel();
        $data = array(
            'attr_id' => $attr_id,
            'attr_value' => $attr_value,
            'sort' => $sort,
            'create_time' => date('Y-m-d H:i:s', time())
        );
        $find_id = $attribute->get([
            'attr_value' => $attr_value,
            'attr_id' => $attr_id
        ]);
        if (! empty($find_id)) {
            return $find_id['attr_value_id'];
        } else {
            $res = $attribute->save($data);
            return $attribute->attr_value_id;
        }
        
        // TODO Auto-generated method stub
    }

    /**
     * 添加商品sku列表
     *
     * @param unknown $goods_id            
     * @param unknown $sku_item_array            
     * @return Ambigous <number, \think\false, boolean, string>
     */
    private function addOrUpdateGoodsSkuItem($goods_id, $sku_item_array)
    {
        $sku_item = explode('¦', $sku_item_array);
        $goods_sku = new NsGoodsSkuModel();
        $sku_name = $this->createSkuName($sku_item[7]);
        $condition = array(
            'goods_id' => $goods_id,
            'attr_value_items' => $sku_item[7]
        );
        $sku_count = $goods_sku->where($condition)->find();
        if (empty($sku_count)) {
            $data = array(
                'goods_id' => $goods_id,
                'sku_name' => $sku_name,
                'attr_value_items' => $sku_item[7],
                'attr_value_items_format' => $sku_item[7],
                'price' => $sku_item[1],
                'market_price' => $sku_item[2],
                'cost_price' => $sku_item[3],
                'stock' => $sku_item[4],
                'picture' => 0,
                'code' => $sku_item[5],
                'QRcode' => $sku_item[6],
                'create_date' => date('Y-m-d H:i:s', time())
            );
            $goods_sku->save($data);
            return $goods_sku->sku_id;
        } else {
            $data = array(
                'goods_id' => $goods_id,
                'sku_name' => $sku_name,
                'price' => $sku_item[1],
                'market_price' => $sku_item[2],
                'cost_price' => $sku_item[3],
                'stock' => $sku_item[4],
                'code' => $sku_item[5],
                'QRcode' => $sku_item[6],
                'update_date' => date('Y-m-d H:i:s', time())
            );
            $res = $goods_sku->save($data, [
                'sku_id' => $sku_count['sku_id']
            ]);
            return $res;
        }
    }

    private function deleteSkuItem($goods_id, $sku_list_array)
    {
        $sku_item_list_array = array();
        foreach ($sku_list_array as $k => $sku_item_array) {
            $sku_item = explode('¦', $sku_item_array);
            $sku_item_list_array[] = $sku_item[7];
        }
        $goods_sku = new NsGoodsSkuModel();
        $list = $goods_sku->where('goods_id=' . $goods_id)->select();
        if (! empty($list)) {
            foreach ($list as $k => $v) {
                if (! in_array($v['attr_value_items'], $sku_item_list_array)) {
                    $goods_sku->destroy($v['sku_id']);
                }
            }
        }
    }

    /**
     * 组装sku name
     *
     * @param unknown $pvs            
     * @return string
     */
    private function createSkuName($pvs)
    {
        $name = '';
        $pvs_array = explode(';', $pvs);
        foreach ($pvs_array as $k => $v) {
            $value = explode(':', $v);
            $prop_id = $value[0];
            $prop_value = $value[1];
            $goods_attr_value = new NsGoodsAttributeValueModel();
            $value_name = $goods_attr_value->getInfo([
                'attr_value_id' => $prop_value
            ], 'attr_value');
            $name = $name . $value_name['attr_value'] . ' ';
        }
        return $name;
    }

    /**
     * 根据当前分类ID查询商品分类的三级分类ID
     *
     * @param unknown $category_id            
     */
    private function getGoodsCategoryId($category_id)
    {
        // 获取分类层级
        $goods_category = new NsGoodsCategoryModel();
        $info = $goods_category->get($category_id);
        if ($info['level'] == 1) {
            return array(
                $category_id,
                0,
                0
            );
        }
        if ($info['level'] == 2) {
            // 获取父级
            return array(
                $info['pid'],
                $category_id,
                0
            );
            ;
        }
        if ($info['level'] == 3) {
            $info_parent = $goods_category->get($info['pid']);
            // 获取父级
            return array(
                $info_parent['pid'],
                $info['pid'],
                $category_id
            );
            ;
        }
    }

    /**
     * 根据当前商品分类组装分类名称
     *
     * @param unknown $category_id_1            
     * @param unknown $category_id_2            
     * @param unknown $category_id_3            
     */
    private function getGoodsCategoryName($category_id_1, $category_id_2, $category_id_3)
    {
        $name = '';
        $goods_category = new NsGoodsCategoryModel();
        $info_1 = $goods_category->getInfo([
            'category_id' => $category_id_1
        ], 'category_name');
        $info_2 = $goods_category->getInfo([
            'category_id' => $category_id_2
        ], 'category_name');
        $info_3 = $goods_category->getInfo([
            'category_id' => $category_id_2
        ], 'category_name');
        if (! empty($info_1['category_name'])) {
            $name = $info_1['category_name'] . ' > ';
        }
        if (! empty($info_2['category_name'])) {
            $name = $name . '' . $info_2['category_name'] . ' > ';
        }
        if (! empty($info_3['category_name'])) {
            $name = $name . '' . $info_3['category_name'] . ' > ';
        }
        return $name;
    }

    /**
     * 获取条件查询出商品
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IGoods::getSerchGoodsList()
     */
    public function getSerchGoodsList($page_index=1, $page_size = 0, $condition='',$order='', $field='*')
    {
        $result = $this->goods->pageQuery($page_index, $page_size, $condition, $order, $field);
        foreach ($result['data'] as $k => $v) {
            $picture = new AlbumPictureModel();
            $pic_info = array();
            $pic_info['pic_cover'] = '';
            if (! empty($v['picture'])) {
                $pic_info = $picture->get($v['picture']);
            }
            $result['data'][$k]['picture_info'] = $pic_info;
        }
        return $result;
    }

    /**
     * 修改商品分组(non-PHPdoc)
     *
     * @see \data\api\niushop\IGoods::ModifyGoodsGroup()
     */
    public function ModifyGoodsGroup($goods_id, $goods_type)
    {
        $data = array(
            "group_id_array" => $goods_type,
            "update_time" => date("Y-m-d H:i:s", time())
        );
        $result = $this->goods->save($data, "goods_id  in($goods_id)");
        if ($result > 0) {
            return SUCCESS;
        } else {
            return UPDATA_FAIL;
        }
    }

    /**
     * 修改商品 推荐 1=热销 2=推荐 3=新品
     */
    public function ModifyGoodsRecommend($goods_ids, $goods_type)
    {
        $goods = new NsGoodsModel();
        $goods->startTrans();
        try {
            $goods_id_array = explode(',', $goods_ids);
            $goods_type = explode(',', $goods_type);
            $data = array(
                "is_new" => $goods_type[0],
                "is_recommend" => $goods_type[1],
                "is_hot" => $goods_type[2]
            );
            foreach ($goods_id_array as $k => $v) {
                $goods = new NsGoodsModel();
                $goods->save($data, [
                    'goods_id' => $v
                ]);
            }
            $goods->commit();
            return 1;
        } catch (\Exception $e) {
            $goods->rollback();
            return $e->getMessage();
        }
    }

    /**
     * 获取商品可得积分
     *
     * @param unknown $goods_id            
     */
    public function getGoodsGivePoint($goods_id)
    {
        $goods = new NsGoodsModel();
        $point_info = $goods->getInfo([
            'goods_id' => $goods_id
        ], 'give_point');
        return $point_info['give_point'];
    }

    /**
     * 通过商品skuid查询goods_id
     *
     * @param unknown $sku_id            
     */
    public function getGoodsId($sku_id)
    {
        $goods_sku = new NsGoodsSkuModel();
        $sku_info = $goods_sku->getInfo([
            'sku_id' => $sku_id
        ], 'goods_id');
        return $sku_info['goods_id'];
    }
    

    /**
     * 获取购物车中项目，根据cartid
     *
     * @param unknown $carts            
     */
    public function getCartList($carts)
    {
        $cart = new NsCartModel();
        $cart_list = $cart->getQuery([
            'buyer_id' => $this->uid
        ], '*', '');
        $cart_array = explode(',', $carts);
        $list = array();
        foreach ($cart_list as $k => $v) {
            $goods = new NsGoodsModel();
            $goods_info = $goods->getInfo([
                'goods_id' => $v['goods_id']
            ], 'max_buy,state,point_exchange_type,point_exchange');
            // 获取商品sku信息
            $goods_sku = new NsGoodsSkuModel();
            $sku_info = $goods_sku->getInfo([
                'sku_id' => $v['sku_id']
            ], 'stock');
            if (empty($sku_info)) {
                $cart->destroy([
                    'buyer_id' => $this->uid,
                    'sku_id' => $v['sku_id']
                ]);
                continue;
            }
            $v['stock'] = $sku_info['stock'];
            $v['max_buy'] = $goods_info['max_buy'];
            $v['point_exchange_type'] = $goods_info['point_exchange_type'];
            $v['point_exchange'] = $goods_info['point_exchange'];
            if ($goods_info['state'] != 1) {
                $this->cartDelete($v['cart_id']);
                unset($v);
            }
            $num = $v['num'];
            if ($goods_info['max_buy'] != 0 && $goods_info['max_buy'] < $v['num']) {
                $num = $goods_info['max_buy'];
            }
            
            if ($sku_info['stock'] < $num) {
                $num = $sku_info['stock'];
            }
            if ($num != $v['num']) {
                // 更新购物车
                $this->cartAdjustNum($v['cart_id'], $sku_info['stock']);
                $v['num'] = $num;
            }
            // 获取图片信息
            $picture = new AlbumPictureModel();
            $picture_info = $picture->get($v['goods_picture']);
            $v['picture_info'] = $picture_info;
            if (in_array($v['cart_id'], $cart_array)) {
                $list[] = $v;
            }
        }
        return $list;
    }

    /**
     * 获取购物车
     *
     * @param unknown $uid            
     */
    public function getCart($uid, $shop_id = 0)
    {
        if (! empty($_SESSION['user_cart'])) {
            return $_SESSION['user_cart'];
        } else {
            $cart = new NsCartModel();
            $cart_goods_list = null;
            if ($shop_id == 0) {
                $cart_goods_list = $cart->getQuery([
                    'buyer_id' => $this->uid
                ], '*', '');
            } else {
                
                $cart_goods_list = $cart->getQuery([
                    'buyer_id' => $this->uid,
                    'shop_id' => $shop_id
                ], '*', '');
            }
            if (! empty($cart_goods_list)) {
                foreach ($cart_goods_list as $k => $v) {
                    $goods = new NsGoodsModel();
                    $goods_info = $goods->getInfo([
                        'goods_id' => $v['goods_id']
                    ], 'max_buy,state,point_exchange_type,point_exchange');
                    // 获取商品sku信息
                    $goods_sku = new NsGoodsSkuModel();
                    $sku_info = $goods_sku->getInfo([
                        'sku_id' => $v['sku_id']
                    ], 'stock');
                    if (empty($sku_info)) {
                        $cart->destroy([
                            'buyer_id' => $uid,
                            'sku_id' => $v['sku_id']
                        ]);
                        continue;
                    }
                    $cart_goods_list[$k]['stock'] = $sku_info['stock'];
                    $cart_goods_list[$k]['max_buy'] = $goods_info['max_buy'];
                    $cart_goods_list[$k]['point_exchange_type'] = $goods_info['point_exchange_type'];
                    $cart_goods_list[$k]['point_exchange'] = $goods_info['point_exchange'];
                    if ($goods_info['state'] != 1) {
                        $this->cartDelete($v['cart_id']);
                        unset($cart_goods_list[$k]);
                    }
                    $num = $v['num'];
                    if ($goods_info['max_buy'] != 0 && $goods_info['max_buy'] < $v['num']) {
                        $num = $goods_info['max_buy'];
                    }
                    
                    if ($sku_info['stock'] < $num) {
                        $num = $sku_info['stock'];
                    }
                    if ($num != $v['num']) {
                        // 更新购物车
                        $this->cartAdjustNum($v['cart_id'], $sku_info['stock']);
                        $cart_goods_list[$k]['num'] = $num;
                    }
                }
                foreach ($cart_goods_list as $k => $v) {
                    $picture = new AlbumPictureModel();
                    $picture_info = $picture->get($v['goods_picture']);
                    $cart_goods_list[$k]['picture_info'] = $picture_info;
                }
                $_SESSION['user_cart'] = $cart_goods_list;
            }
            
            return $cart_goods_list;
        }
    }

    /**
     * 添加购物车(non-PHPdoc)
     *
     * @see \data\api\niushop\IGoods::addCart()
     */
    public function addCart($uid, $shop_id, $shop_name, $goods_id, $goods_name, $sku_id, $sku_name, $price, $num, $picture, $bl_id)
    {
        // 检测当前购物车中是否存在产品
        $cart = new NsCartModel();
        $condition = array(
            'buyer_id' => $uid,
            'sku_id' => $sku_id
        );
        $count = $cart->where($condition)->count();
        if ($count == 0 || empty($count)) {
            $data = array(
                'buyer_id' => $uid,
                'shop_id' => $shop_id,
                'shop_name' => $shop_name,
                'goods_id' => $goods_id,
                'goods_name' => $goods_name,
                'sku_id' => $sku_id,
                'sku_name' => $sku_name,
                'price' => $price,
                'num' => $num,
                'goods_picture' => $picture,
                'bl_id' => $bl_id
            );
            $cart->save($data);
            $retval = $cart->cart_id;
        } else {
            $cart = new NsCartModel();
            // 查询商品限购
            $goods = new NsGoodsModel();
            $get_num = $cart->getInfo($condition, 'cart_id,num');
            $max_buy = $goods->getInfo([
                'goods_id' => $goods_id
            ], 'max_buy');
            $new_num = $num + $get_num['num'];
            if ($max_buy['max_buy'] != 0) {
                
                if ($new_num > $max_buy['max_buy']) {
                    $new_num = $max_buy['max_buy'];
                }
            }
            
            $data = array(
                'num' => $new_num
            );
            $retval = $cart->save($data, $condition);
            if ($retval) {
                $retval = $get_num['cart_id'];
            }
        }
        $_SESSION["user_cart"] = '';
        return $retval;
    }

    /**
     * 购物车数量修改(non-PHPdoc)
     *
     * @see \data\api\niushop\IGoods::cartAdjustNum()
     */
    public function cartAdjustNum($cart_id, $num)
    {
        $cart = new NsCartModel();
        $data = array(
            'num' => $num
        );
        $retval = $cart->save($data, [
            'cart_id' => $cart_id
        ]);
        $_SESSION["user_cart"] = '';
        return $retval;
    }

    /**
     * 购物车项目删除(non-PHPdoc)
     *
     * @see \data\api\niushop\IGoods::cartDelete()
     */
    public function cartDelete($cart_id_array)
    {
        $cart = new NsCartModel();
        $retval = $cart->destroy($cart_id_array);
        $_SESSION["user_cart"] = '';
        return $retval;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IGoods::getGroupGoodsList()
     */
    public function getGroupGoodsList($goods_group_id, $condition = '', $num = 0, $order = '')
    {
        $goods_list = array();
        $goods = new NsGoodsModel();
        $condition['state'] = 1;
        $list = $goods->getQuery($condition, '*', $order);
        foreach ($list as $k => $v) {
            $picture = new AlbumPictureModel();
            $picture_info = $picture->get($v['picture']);
            $v['picture_info'] = $picture_info;
            $group_id_array = explode(',', $v['group_id_array']);
            if (in_array($goods_group_id, $group_id_array) || $goods_group_id == 0) {
                $goods_list[] = $v;
            }
        }
        foreach ($goods_list as $k => $v) {
            if (! empty($this->uid)) {
                $member = new Member();
                $goods_list[$k]['is_favorite'] = $member->getIsMemberFavorites($this->uid, $v['goods_id'], 'goods');
            } else {
                $goods_list[$k]['is_favorite'] = 0;
            }
            
            $goods_sku = new NsGoodsSkuModel();
            // 获取sku列表
            $sku_list = $goods_sku->where([
                'goods_id' => $v['goods_id']
            ])->select();
            $goods_list[$k]['sku_list'] = $sku_list;
            
            // 查询商品单品活动信息
            $goods_preference = new GoodsPreference();
            $goods_promotion_info = $goods_preference->getGoodsPromote($v['goods_id']);
            $goods_list[$k]['promotion_info'] = $goods_promotion_info;
        }
        if ($num == 0) {
            return $goods_list;
        } else {
            $count_list = count($goods_list);
            if ($count_list > $num) {
                return array_slice($goods_list, 0, $num);
            } else {
                return $goods_list;
            }
        }
    }

    /**
     * 获取限时折扣的商品
     *
     * @param number $page_index            
     * @param number $page_size            
     * @param unknown $condition            
     * @param string $order            
     */
    public function getDiscountGoodsList($page_index = 1, $page_size = 0, $condition = array(), $order = '')
    {
        $goods_discount = new GoodsDiscount();
        $goods_list = $goods_discount->getDiscountGoodsList($page_index, $page_size, $condition, $order);
        return $goods_list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IGoods::getGoodsEvaluate()
     */
    public function getGoodsEvaluate($goods_id)
    {
        $goodsEvaluateModel = new NsGoodsEvaluateModel();
        $condition['goods_id'] = $goods_id;
        $field = 'order_id, orderno, order_goods_id, goods_id, goods_name, goods_price, goods_image, storeid, storename, content, addtime, image, explain_first, member_name, uid, is_anonymous, scores, again_content, again_addtime, again_image, again_explain';
        return $goodsEvaluateModel->getQuery($condition, $field, 'id ASC');
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IGoods::getGoodsShopid()
     */
    public function getGoodsShopid($goods_id)
    {
        $goods_model = new NsGoodsModel();
        $goods_info = $goods_model->getInfo([
            'goods_id' => $goods_id
        ], 'shop_id');
        return $goods_info['shop_id'];
    }

    /**
     * (non-PHPdoc)
     * @evaluate_count总数量 @imgs_count带图的数量 @praise_count好评数量 @center_count中评数量 bad_count差评数量
     *
     * @see \data\api\niushop\IGoods::getGoodsEvaluateCount()
     */
    public function getGoodsEvaluateCount($goods_id)
    {
        $goods_evaluate = new NsGoodsEvaluateModel();
        $evaluate_count_list['evaluate_count'] = $goods_evaluate->where([
            'goods_id' => $goods_id
        ])->count();
        
        $evaluate_count_list['imgs_count'] = $goods_evaluate->where([
            'goods_id' => $goods_id
        ])
            ->where('image|again_image', 'NEQ', '')
            ->count();
        $evaluate_count_list['praise_count'] = $goods_evaluate->where([
            'goods_id' => $goods_id,
            'explain_type' => 1
        ])->count();
        $evaluate_count_list['center_count'] = $goods_evaluate->where([
            'goods_id' => $goods_id,
            'explain_type' => 2
        ])->count();
        $evaluate_count_list['bad_count'] = $goods_evaluate->where([
            'goods_id' => $goods_id,
            'explain_type' => 3
        ])->count();
        return $evaluate_count_list;
    }

    /**
     * 查询商品积分兑换(non-PHPdoc)
     *
     * @see \data\api\niushop\IGoods::getGoodsPointExchange()
     */
    public function getGoodsPointExchange($goods_id)
    {
        $goods_model = new NsGoodsModel();
        $goods_info = $goods_model->getInfo([
            'goods_id' => $goods_id
        ], 'point_exchange_type,point_exchange');
        if ($goods_info['point_exchange_type'] == 0) {
            return 0;
        } else {
            return $goods_info['point_exchange'];
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \data\api\niushop\IGoods::getConsultTypeList()
     */
    public function getConsultTypeList($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        $consult_type = new NsConsultTypeModel();
        $list = $consult_type->pageQuery($page_index, $page_size, $condition, $order, '');
        return $list;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \data\api\niushop\IGoods::getConsultList()
     */
    public function getConsultList($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        $consult = new NsConsultModel();
        $list = $consult->pageQuery($page_index, $page_size, $condition, $order, '');
        return $list;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \data\api\niushop\IGoods::addConsult()
     */
    public function addConsult($goods_id, $goods_name, $uid, $member_name, $shop_id, $shop_name, $ct_id, $consult_content)
    {
        $consult = new NsConsultModel();
        $data = array(
            'goods_id' => $goods_id,
            'goods_name' => $goods_name,
            'uid' => $uid,
            'member_name' => $member_name,
            'shop_id' => $shop_id,
            'shop_name' => $shop_name,
            'ct_id' => $ct_id,
            'consult_content' => $consult_content,
            'consult_addtime' => date('Y-m-d H:i:s', time())
        );
        $consult->save($data);
        $res = $consult->consult_id;
        return $res;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \data\api\niushop\IGoods::replyConsult()
     */
    public function replyConsult($consult_id, $consult_reply)
    {
        $consult = new NsConsultModel();
        $data = array(
            'consult_reply' => $consult_reply,
            'consult_reply_time' => date('Y-m-d H:i:s', time())
        );
        $res = $consult->save($data, [
            'consult_id' => $consult_id
        ]);
        return $res;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \data\api\niushop\IGoods::addConsultType()
     */
    public function addConsultType($ct_name, $ct_introduce, $ct_sort)
    {}

    /**
     *
     * {@inheritdoc}
     *
     * @see \data\api\niushop\IGoods::updateConsultType()
     */
    public function updateConsultType($ct_id, $ct_name, $ct_introduce, $ct_sort)
    {}
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::deleteConsult()
     */
    public function deleteConsult($consult_id)
    {
        $consult = new NsConsultModel();
        return $consult->destroy($consult_id);
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::deleteConsultType()
     */
    public function deleteConsultType($ct_id)
    {}
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::getConsultDetail()
     */
    public function getConsultDetail($ct_id)
    {}
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::getGoodsRank()
     */
    public function getGoodsRank($condition)
    {
        $goods = new NsGoodsModel();
        $goods_list = $goods->where($condition)
            ->order(" real_sales desc ")
            ->limit(6)
            ->select();
        return $goods_list;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::getConsultCount()
     */
    public function getConsultCount($condition)
    {
        $consult = new NsConsultModel();
        $count = $consult->where($condition)->count();
        return $count;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoods::getGoodsExpressTemplate()
     */
    public function getGoodsExpressTemplate($goods_id, $province_id, $city_id)
    {
        $goods_express = new GoodsExpress();
        $retval = $goods_express->getGoodsExpressTemplate($goods_id, $province_id, $city_id);
        return $retval;
    }
}
