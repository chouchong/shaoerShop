<?php
/**
 * IGoods.php
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
 * 商品接口
 *        
 */
interface IGoods
{

    /**
     * 获取指定条件下商品列表
     *
     * @param number $page_index            
     * @param number $page_size            
     * @param string $condition            
     * @param string $order            
     */
    function getGoodsList($page_index = 1, $page_size = 0, $condition = '', $order = '');

    /**
     * 获取某种条件下商品数量
     *
     * @param unknown $condition            
     */
    function getGoodsCount($condition);

    /**
     * 添加或者修改商品(整体)
     * goods_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品id(SKU)',
     * goods_name varchar(50) NOT NULL COMMENT '商品名称',
     * shop_id int(10) UNSIGNED NOT NULL COMMENT '店铺id',
     * category_id int(10) UNSIGNED NOT NULL COMMENT '商品分类id',
     * category_id_1 int(10) UNSIGNED NOT NULL COMMENT '一级分类id',
     * category_id_2 int(10) UNSIGNED NOT NULL COMMENT '二级分类id',
     * category_id_3 int(10) UNSIGNED NOT NULL COMMENT '三级分类id',
     * brand_id int(10) UNSIGNED NOT NULL COMMENT '品牌id',
     * group_id_array varchar(255) NOT NULL DEFAULT '' COMMENT '店铺分类id 首尾用,隔开',
     * promotion_type tinyint(3) NOT NULL DEFAULT 0 COMMENT '促销类型 0无促销，1团购，2限时折扣',
     * goods_type tinyint(4) NOT NULL DEFAULT 1 COMMENT '实物或虚拟商品标志 1实物商品 0 虚拟商品 2 F码商品',
     * market_price decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '市场价',
     * price decimal(19, 2) NOT NULL DEFAULT 0.00 COMMENT '商品原价格',
     * promotion_price decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '商品促销价格',
     * cost_price decimal(19, 2) NOT NULL DEFAULT 0.00 COMMENT '成本价',
     * point_exchange_type enum ('0', '1', '2') NOT NULL COMMENT '积分兑换类型 0 非积分兑换 1 只能积分兑换 2 积分和商品价格组合购买',
     * point_exchange int(11) NOT NULL DEFAULT 0 COMMENT '积分兑换',
     * give_point int(11) NOT NULL DEFAULT 0 COMMENT '购买商品赠送积分',
     * is_member_discount bit(1) NOT NULL DEFAULT b'0' COMMENT '参与会员折扣',
     * shipping_fee decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '运费 0为免运费',
     * shipping_fee_id int(11) NOT NULL DEFAULT 0 COMMENT '售卖区域id 物流模板id ns_order_shipping_fee 表id',
     * stock int(10) NOT NULL DEFAULT 0 COMMENT '商品库存',
     * max_buy int(11) NOT NULL DEFAULT 0 COMMENT '限购 0 不限购',
     * min_stock_alarm int(11) NOT NULL DEFAULT 0 COMMENT '库存预警值',
     * clicks int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品点击数量',
     * sales int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '销售数量',
     * collects int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '收藏数量',
     * star tinyint(3) UNSIGNED NOT NULL DEFAULT 5 COMMENT '好评星级',
     * evaluates int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '评价数',
     * shares int(11) NOT NULL DEFAULT 0 COMMENT '分享数',
     * province_id int(10) UNSIGNED NOT NULL COMMENT '一级地区id',
     * city_id int(10) UNSIGNED NOT NULL COMMENT '二级地区id',
     * picture int(11) NOT NULL COMMENT '商品主图',
     * keywords varchar(255) NOT NULL DEFAULT '' COMMENT '商品关键词',
     * introduction varchar(255) NOT NULL DEFAULT '' COMMENT '商品简介',
     * description text NOT NULL COMMENT '商品详情',
     * QRcode varchar(255) NOT NULL DEFAULT '' COMMENT '商品二维码',
     * code varchar(50) NOT NULL COMMENT '商家编号',
     * is_stock_visible bit(1) NOT NULL DEFAULT b'0' COMMENT '页面不显示库存',
     * is_hot bit(1) NOT NULL DEFAULT b'0' COMMENT '是否热销商品',
     * is_recommend bit(1) NOT NULL DEFAULT b'0' COMMENT '是否推荐',
     * is_new bit(1) NOT NULL DEFAULT b'0' COMMENT '是否新品',
     * `is_pre-sale` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否预售',
     * is_bill bit(1) NOT NULL DEFAULT b'0' COMMENT '是否开具增值税发票 1是，0否',
     * state tinyint(3) NOT NULL DEFAULT 1 COMMENT '商品状态 0下架，1正常，10违规（禁售）',
     * sale_date datetime NOT NULL COMMENT '上下架时间',
     * create_time datetime NOT NULL COMMENT '商品添加时间',
     * update_time datetime NOT NULL COMMENT '商品编辑时间',
     * sort int(11) NOT NULL DEFAULT 0 COMMENT '排序',
     * PRIMARY KEY (goods_id)
     * $imageArray, //格式为 imageId,is_mainimage,orders;imageId,is_mainimage,orders
     * $skuArray); //#商品sku编码数组 字段之间¦分隔, 记录之间§分隔,
     * #格式skuId¦price¦stock¦pvs¦code¦barcode§skuId¦price¦stock¦pvs¦code¦barcode
     * #pvs格式 propId:valueId;propId:valueId
     *
     * @param unknown $data(数据待定)            
     */
    function addOrEditGoods($goods_id, $goods_name, $shopid, $category_id, $category_id_1, $category_id_2, $brand_id, $group_id_array, $goods_type, $market_price, $price, $cost_price, $point_exchange_type, $point_exchange, $give_point, $is_member_discount, $shipping_fee, $shipping_fee_id, $stock, $max_buy, $min_stock_alarm, $clicks, $sales, $collects, $star, $evaluates, $shares, $province_id, $city_id, $picture, $keywords, $introduction, $description, $QRcode, $code, $is_stock_visible, $is_hot, $is_recommend, $is_new, $state, $sort, $image_array, $sku_array, $state, $sku_img_array);

    /**
     * 获取商品的sku信息
     *
     * @param unknown $goods_id            
     */
    function getGoodsSku($goods_id);

    /**
     * 更新商品的sku数据
     *
     * @param unknown $goods_id            
     * @param unknown $sku_list            
     */
    function ModifyGoodsSku($goods_id, $sku_list);

    /**
     * 更新商品促销信息
     *
     * @param unknown $condition            
     */
    function ModifyGoodsPromotionPrice($condition);

    /**
     * 获取商品的图片信息
     *
     * @param unknown $goods_id            
     */
    function getGoodsImg($goods_id);

    /**
     * 商品下架
     *
     * @param unknown $condition            
     */
    function ModifyGoodsOffline($condition);

    /**
     * 商品上架
     *
     * @param unknown $condition            
     */
    function ModifyGoodsOnline($condition);

    /**
     * 删除商品
     *
     * @param unknown $goods_id            
     */
    function deleteGoods($goods_id);

    /**
     * 删除商品的图片信息
     *
     * @param unknown $goods_id            
     */
    function deleteGoodImages($goods_id);

    /**
     * 获取单条商品的详细信息
     *
     * @param unknown $goods_id            
     */
    function getGoodsDetail($goods_id);

    /**
     * 商品规格列表
     *
     * @param unknown $condition            
     * @param unknown $field            
     */
    function getGoodsAttributeList($condition, $field);

    /**
     * 商品规格值列表
     *
     * @param unknown $condition            
     * @param unknown $field            
     */
    function getGoodsAttributeValueList($condition, $field);

    /**
     * 添加商品规格
     *
     * @param unknown $attribute_name            
     * @param unknown $sort            
     * @param unknown $is_visible            
     */
    function addGoodsAttribute($attribute_name, $sort = 0);

    /**
     * 添加商品guigezhi
     *
     * @param unknown $attr_id            
     * @param unknown $attr_value            
     * @param unknown $sort            
     */
    function addGoodsAttributeValue($attr_id, $attr_value, $sort = 0);
    /**
     * 根据条件查询所需条件
     * @param unknown $condition
     */
    function getSerchGoodsList($page_index=1, $page_size=0,$condition='',$order='', $field='*');
    /**
     * 修改商品分类
     * @param unknown $goods_id
     * @param unknown $goods_type
     */
    function ModifyGoodsGroup($goods_id,$goods_type);
    /**
     * 修改商品推荐 （新品 ， 精品 ， 特惠）
     * @param unknown $goods_id
     * @param unknown $goods_type
     */
    function ModifyGoodsRecommend($goods_id, $goods_type);
    /**
     * 获取商品可得积分
     * @param unknown $goods_id
     */
    function getGoodsGivePoint($goods_id);
   
    /**
     * 通过商品skuid查询goods_id
     * @param unknown $sku_id
     */
    function getGoodsId($sku_id);
    /**
     * 获取商品的店铺ID
     * @param unknown $goods_id
     */
    function getGoodsShopid($goods_id);
    /**
     * 获取会员购物车
     * @param unknown $uid
     */
    function getCart($uid,$shop_id);
    /**
     * 添加购物车
     * @param unknown $uid
     * @param unknown $shop_id
     * @param unknown $shop_name
     * @param unknown $goods_id
     * @param unknown $goods_name
     * @param unknown $sku_id
     * @param unknown $sku_name
     * @param unknown $price
     * @param unknown $num
     * @param unknown $picture
     * @param unknown $bl_id
     */
    function addCart($uid, $shop_id, $shop_name, $goods_id, $goods_name, $sku_id, $sku_name, $price, $num, $picture, $bl_id);
    /**
     * 购物车修改数量
     * @param unknown $cart_id
     * @param unknown $num
     */
    function cartAdjustNum($cart_id, $num);
    /**
     * 购物车项目删除
     * @param unknown $cart_id_array  多项用，隔开
     */
    function cartDelete($cart_id_array);
    /**
     * 获取分组商品列表
     * @param unknown $goods_group_id
     * @param number $num
     */
    function getGroupGoodsList($goods_group_id,$condition='',$num=0,$order='');
    /**
     * 通过购物车项获取列表
     * @param unknown $carts  ','隔开
     */
    function getCartList($carts);
    /**
     * 获取限时折扣的商品
     * @param number $page_index
     * @param number $page_size
     * @param unknown $condition
     * @param string $order
     */
    function getDiscountGoodsList($page_index = 1, $page_size = 0, $condition = array(), $order = '');
    /**
     * 商品评价信息
     * @param unknown $goods_id
     */
    function getGoodsEvaluate($goods_id);
    /**
     * 商品评价信息的数量  
     * @evaluate_count总数量  @imgs_count带图的数量  @praise_count好评数量 @center_count中评数量 bad_count差评数量
     * @param unknown $goods_id
     */
    function getGoodsEvaluateCount($goods_id);
    /**
     * 查询商品兑换所需积分
     * @param unknown $goods_id返回0表示不能兑换
     */
    function getGoodsPointExchange($goods_id);
    
    /**
     * 获取单个商品的sku属性
     * @param unknown $goods_id
     */
    function getGoodsAttribute($goods_id);
    
    /**
     * 获取商品咨询类型列表
     * @param number $page_index
     * @param number $page_size
     * @param string $condition
     * @param string $order
     */
    function getConsultTypeList($page_index = 1, $page_size = 0, $condition = '', $order = '');
    
    /**
     * 添加 商品咨询类型
     * @param unknown $ct_name
     * @param unknown $ct_introduce
     * @param unknown $ct_sort
     */
    function addConsultType($ct_name, $ct_introduce, $ct_sort);
    
    /**
     * 修改商品咨询类型
     * @param unknown $ct_id
     * @param unknown $ct_name
     * @param unknown $ct_introduce
     * @param unknown $ct_sort
     */
    function updateConsultType($ct_id, $ct_name, $ct_introduce, $ct_sort);
    
    /**
     * 删除 商品咨询类型
     * @param unknown $ct_id
     */
    function deleteConsultType($ct_id);
    /**
     * 获取商品咨询列表
     * @param number $page_index
     * @param number $page_size
     * @param string $condition
     * @param string $order
     */
    function getConsultList($page_index = 1, $page_size = 0, $condition = '', $order = '');
    
    /**
     * 获取商品咨询详情
     * @param unknown $ct_id
     */
    function getConsultDetail($ct_id);
    
    /**
     * 添加 商品咨询 
     * @param unknown $goods_id
     * @param unknown $goods_name
     * @param unknown $uid
     * @param unknown $member_name
     * @param unknown $shop_id
     * @param unknown $shop_name
     * @param unknown $ct_id
     * @param unknown $consult_content
     */
    function addConsult($goods_id, $goods_name, $uid, $member_name, $shop_id, $shop_name, $ct_id, $consult_content);
    
    /**
     * 回复 商品咨询 （店铺后台）
     * @param unknown $consult_id
     * @param unknown $consult_reply
     */
    function replyConsult($consult_id, $consult_reply);
    
    /**
     * 删除 商品咨询（店铺后台）
     * @param unknown $consult_id
     */
    function deleteConsult($consult_id);
    /**
     * 获取销售钱排行的商品
     * @param unknown $condition
     */
    function getGoodsRank($condition);
    /**
     * 获取咨询个数
     * @param unknown $condition
     */
    function getConsultCount($condition);
    /**
     * 获取商品运费模板情况
     * @param unknown $goods_id
     * @param unknown $province_id
     * @param unknown $city_id
     */
    function getGoodsExpressTemplate($goods_id, $province_id, $city_id);
    
}

