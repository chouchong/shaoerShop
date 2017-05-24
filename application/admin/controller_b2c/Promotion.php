<?php
/**
 * Promotion.php
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

use data\service\niushop\Promote;

/**
 * 营销控制器
 *
 * @author Administrator
 *        
 */
class Promotion extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 优惠券类型列表
     *
     * @return multitype:number unknown |Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function couponTypeList()
    {
        if (request()->isAjax()) {
            $page_index = isset($_POST["pageIndex"]) ? $_POST["pageIndex"] : 1;
            $search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
            $coupon = new Promote();
            $condition = array(
                'shop_id' => $this->instance_id,
                'coupon_name' => array(
                    'like',
                    '%' . $search_text . '%'
                )
            );
            $list = $coupon->getCouponTypeList($page_index, PAGESIZE, $condition);
            return $list;
        } else {
            return view($this->style . "Promotion/couponTypeList");
        }
    }

    /**
     * 添加优惠券类型
     */
    public function addCouponType()
    {
        if (request()->isAjax()) {
            $coupon_name = $_POST["coupon_name"];
            $money = $_POST["money"];
            $count = $_POST["count"];
            $max_fetch = $_POST["max_fetch"];
            $at_least = $_POST["at_least"];
            $need_user_level = $_POST["need_user_level"];
            $range_type = $_POST["range_type"];
            $start_time = $_POST["start_time"];
            $end_time = $_POST["end_time"];
            $goods_list = $_POST["goods_list"];
            $coupon = new Promote();
            $retval = $coupon->addCouponType($coupon_name, $money, $count, $max_fetch, $at_least, $need_user_level, $range_type, $start_time, $end_time, $goods_list);
            return AjaxReturn($retval);
        } else {
            return view($this->style . "Promotion/addCouponType");
        }
    }

    public function updateCouponType()
    {
        $coupon = new Promote();
        if (request()->isAjax()) {
            $coupon_type_id = $_POST["coupon_type_id"];
            $coupon_name = $_POST["coupon_name"];
            $money = $_POST["money"];
            $count = $_POST["count"];
            $max_fetch = $_POST["max_fetch"];
            $at_least = $_POST["at_least"];
            $need_user_level = $_POST["need_user_level"];
            $range_type = $_POST["range_type"];
            $start_time = $_POST["start_time"];
            $end_time = $_POST["end_time"];
            $goods_list = $_POST["goods_list"];
            $coupon = new Promote();
            $retval = $coupon->updateCouponType($coupon_type_id, $coupon_name, $money, $count, $max_fetch, $at_least, $need_user_level, $range_type, $start_time, $end_time, $goods_list);
            return AjaxReturn($retval);
        } else {
            $coupon_type_id = isset($_GET['coupon_type_id']) ? $_GET['coupon_type_id'] : 0;
            if ($coupon_type_id == 0) {
                $this->error("没有获取到类型");
            }
            $coupon_type_data = $coupon->getCouponTypeDetail($coupon_type_id);
            $goods_id_array = array();
            foreach ($coupon_type_data['goods_list'] as $k => $v) {
                $goods_id_array[] = $v['goods_id'];
            }
            $coupon_type_data['goods_id_array'] = $goods_id_array;
            $this->assign("coupon_type_info", $coupon_type_data);
            return view($this->style . "Promotion/updateCouponType");
        }
    }

    /**
     * 获取优惠券详情
     */
    public function getCouponTypeInfo()
    {
        $coupon = new Promote();
        $coupon_type_id = $_POST['coupon_type_id'];
        $coupon_type_data = $coupon->getCouponTypeDetail($coupon_type_id);
        return $coupon_type_data;
    }

    /**
     * 功能：积分设置
     * 创建：左骐羽
     * 时间：2016年12月8日15:02:16
     */
    public function pointConfig()
    {
        $pointConfig = new Promote();
        if (request()->isAjax()) {
            $convert_rate = isset($_POST['convert_rate']) ? $_POST['convert_rate'] : '';
            $is_open = isset($_POST['is_open']) ? $_POST['is_open'] : 0;
            $desc = isset($_POST['desc']) ? $_POST['desc'] : 0;
            $retval = $pointConfig->setPointConfig($convert_rate, $is_open, $desc);
            return AjaxReturn($retval);
        }
        $pointconfiginfo = $pointConfig->getPointConfig();
        $this->assign("pointconfiginfo", $pointconfiginfo);
        return view($this->style . "Promotion/pointConfig");
    }

    /**
     * 赠品列表
     * wzy
     */
    public function giftList()
    {
        if (request()->isAjax()) {
            $pageIndex = isset($_POST["pageIndex"]) ? $_POST["pageIndex"] : 1;
            $search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
            $gift = new Promote();
            $condition = array(
                'shop_id' => $this->instance_id,
                'gift_name' => array(
                    'like',
                    '%' . $search_text . '%'
                )
            );
            $list = $gift->getPromotionGiftList($pageIndex, PAGESIZE, $condition);
            return $list;
        }
        return view($this->style . "Promotion/giftList");
    }

    /**
     * 添加赠品
     *
     * @return \think\response\View
     */
    public function addGift()
    {
        if (request()->isAjax()) {
            $shop_id = $this->instance_id;
            $gift_name = $_POST['gift_name'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $days = $_POST['days'];
            $max_num = $_POST['max_num'];
            $goods_id_array = $_POST['goods_id_array'];
            $gift = new Promote();
            $res = $gift->addPromotionGift($shop_id, $gift_name, $start_time, $end_time, $days, $max_num, $goods_id_array);
            return AjaxReturn($res);
        }
        return view($this->style . "Promotion/addGift");
    }

    /**
     * 修改赠品
     *
     * @return \think\response\View
     */
    public function updateGift()
    {
        $gift = new Promote();
        if (request()->isAjax()) {
            $gift_id = $_POST['gift_id'];
            $shop_id = $this->instance_id;
            $gift_name = $_POST['gift_name'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $days = $_POST['days'];
            $max_num = $_POST['max_num'];
            $goods_id_array = $_POST['goods_id_array'];
            $res = $gift->updatePromotionGift($gift_id, $shop_id, $gift_name, $start_time, $end_time, $days, $max_num, $goods_id_array);
            return AjaxReturn($res);
        } else {
            $gift_id = isset($_GET['gift_id']) ? $_GET['gift_id'] : 0;
            $info = $gift->getPromotionGiftDetail($gift_id);
            $this->assign('info', $info);
            return view($this->style . "Promotion/updateGift");
        }
    }

    /**
     * 获取赠品 详情
     *
     * @param unknown $gift_id            
     */
    public function getGiftInfo($gift_id)
    {
        $gift = new Promote();
        $info = $gift->getPromotionGiftDetail($gift_id);
        return $info;
    }

    /**
     * 满减送 列表
     */
    public function mansongList()
    {
        if (request()->isAjax()) {
            $pageIndex = isset($_POST["pageIndex"]) ? $_POST["pageIndex"] : 1;
            $search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
            $condition = array(
                'shop_id' => $this->instance_id,
                'mansong_name' => array(
                    'like',
                    '%' . $search_text . '%'
                )
            );
            $mansong = new Promote();
            $list = $mansong->getPromotionMansongList($pageIndex, PAGESIZE, $condition);
            return $list;
        }
        return view($this->style . "Promotion/mansongList");
    }

    /**
     * 添加满减送活动
     *
     * @return \think\response\View
     */
    public function addMansong()
    {
        $mansong = new Promote();
        if (request()->isAjax()) {
            $mansong_name = $_POST['mansong_name'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $shop_id = $this->instance_id;
            $type = $_POST['type'];
            $range_type = $_POST['range_type'];
            $rule = $_POST['rule'];
            $goods_id_array = $_POST['goods_id_array'];
            $res = $mansong->addPromotionMansong($mansong_name, $start_time, $end_time, $shop_id, '', $type, $range_type, $rule, $goods_id_array);
            return AjaxReturn($res);
        } else {
            return view($this->style . "Promotion/addMansong");
        }
    }

    /**
     * 修改 满减送活动
     */
    public function updateMansong()
    {
        $mansong = new Promote();
        if (request()->isAjax()) {
            $mansong_id = $_POST['mansong_id'];
            $mansong_name = $_POST['mansong_name'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $shop_id = $this->instance_id;
            $type = $_POST['type'];
            $range_type = $_POST['range_type'];
            $rule = $_POST['rule'];
            $goods_id_array = $_POST['goods_id_array'];
            $res = $mansong->updatePromotionMansong($mansong_id, $mansong_name, $start_time, $end_time, $shop_id, '', $type, $range_type, $rule, $goods_id_array);
            return AjaxReturn($res);
        } else {
            $mansong_id = $_GET['mansong_id'];
            $info = $mansong->getPromotionMansongDetail($mansong_id);
            $condition = array(
                'shop_id' => $this->instance_id
            );
            $coupon_type_list = $mansong->getCouponTypeList(1, 0, $condition);
            $gift_list = $mansong->getPromotionGiftList(1, 0, $condition);
            $this->assign('coupon_type_list', $coupon_type_list);
            $this->assign('gift_list', $gift_list);
            $this->assign('mansong_info', $info);
            return view($this->style . "Promotion/updateMansong");
        }
    }

    /**
     * 获取限时折扣；列表
     */
    public function getDiscountList()
    {
        if (request()->isAjax()) {
            $pageIndex = isset($_POST["pageIndex"]) ? $_POST["pageIndex"] : 1;
            $search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
            $discount = new Promote();
            $condition = array(
                'shop_id' => $this->instance_id,
                'discount_name' => array(
                    'like',
                    '%' . $search_text . '%'
                )
            );
            $list = $discount->getPromotionDiscountList($pageIndex, PAGESIZE, $condition);
            return $list;
        }
        return view($this->style . "Promotion/getDiscountList");
    }

    /**
     * 添加限时折扣
     */
    public function addDiscount()
    {
        if (request()->isAjax()) {
            $discount = new Promote();
            $discount_name = isset($_POST['discount_name']) ? $_POST['discount_name'] : '';
            $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '';
            $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '';
            $remark = '';
            $goods_id_array = isset($_POST['goods_id_array']) ? $_POST['goods_id_array'] : '';
            $retval = $discount->addPromotiondiscount($discount_name, $start_time, $end_time, $remark, $goods_id_array);
            return AjaxReturn($retval);
        }
        return view($this->style . "Promotion/addDiscount");
    }

    /**
     * 修改限时折扣
     */
    public function updateDiscount()
    {
        if (request()->isAjax()) {
            $discount = new Promote();
            $discount_id = isset($_POST['discount_id']) ? $_POST['discount_id'] : '';
            $discount_name = isset($_POST['discount_name']) ? $_POST['discount_name'] : '';
            $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '';
            $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '';
            $remark = '';
            $goods_id_array = isset($_POST['goods_id_array']) ? $_POST['goods_id_array'] : '';
            $retval = $discount->updatePromotionDiscount($discount_id, $discount_name, $start_time, $end_time, $remark, $goods_id_array);
            return AjaxReturn($retval);
        }
        $info = $this->getDiscountDetail();
        if (! empty($info['goods_list'])) {
            foreach ($info['goods_list'] as $k => $v) {
                $goods_id_array[] = $v['goods_id'];
            }
        }
        $info['goods_id_array'] = $goods_id_array;
        $this->assign("info", $info);
        return view($this->style . "Promotion/updateDiscount");
    }

    /**
     * 获取限时折扣详情
     */
    public function getDiscountDetail()
    {
        $discount_id = isset($_GET['discount_id']) ? $_GET['discount_id'] : '';
        if (empty($discount_id)) {
            $this->error("没有获取到折扣信息");
        }
        $discount = new Promote();
        $detail = $discount->getPromotionDiscountDetail($discount_id);
        return $detail;
    }

    /**
     * 获取满减送详情
     */
    public function getMansongDetail()
    {
        $mansong_id = isset($_GET['mansong_id']) ? $_GET['mansong_id'] : '';
        if (empty($mansong_id)) {
            $this->error("没有获取到满减送信息");
        }
        $mansong = new Promote();
        $detail = $mansong->getPromotionMansongDetail($mansong_id);
        return $detail;
    }

    /**
     * 删除限时折扣
     */
    public function delDiscount()
    {
        $discount_id = isset($_POST['discount_id']) ? $_POST['discount_id'] : '';
        if (empty($discount_id)) {
            $this->error("没有获取到折扣信息");
        }
        $discount = new Promote();
        $res = $discount->delPromotionDiscount($discount_id);
        return AjaxReturn($res);
    }

    /**
     * 关闭正在进行的限时折扣
     */
    public function closeDiscount()
    {
        $discount_id = isset($_POST['discount_id']) ? $_POST['discount_id'] : '';
        if (empty($discount_id)) {
            $this->error("没有获取到折扣信息");
        }
        $discount = new Promote();
        $res = $discount->closePromotionDiscount($discount_id);
        return AjaxReturn($res);
    }

    /**
     * 删除满减送活动
     *
     * @return unknown[]
     */
    public function delMansong()
    {
        $mansong_id = isset($_POST['mansong_id']) ? $_POST['mansong_id'] : '';
        if (empty($mansong_id)) {
            $this->error("没有获取到满减送信息");
        }
        $mansong = new Promote();
        $res = $mansong->delPromotionMansong($mansong_id);
        return AjaxReturn($res);
    }

    /**
     * 关闭满减送活动
     *
     * @return unknown[]
     */
    public function closeMansong()
    {
        $mansong_id = isset($_POST['mansong_id']) ? $_POST['mansong_id'] : '';
        if (empty($mansong_id)) {
            $this->error("没有获取到满减送信息");
        }
        $mansong = new Promote();
        $res = $mansong->closePromotionMansong($mansong_id);
        return AjaxReturn($res);
    }
    
    /**
     * 满额包邮
     */
    public function fullShipping()
    {
        $full = new Promote();
        if (request()->isAjax()) {
            $is_open = isset($_POST['is_open']) ? $_POST['is_open'] : '';
            $full_mail_money = isset($_POST['full_mail_money']) ? $_POST['full_mail_money'] : '';
            $res = $full->updatePromotionFullMail(0, $is_open, $full_mail_money);
            return AjaxReturn($res);
        } else {
            $info = $full->getPromotionFullMail(0);
            $this->assign("info", $info);
            return view($this->style . "Promotion/fullShipping");
        }
    }
}