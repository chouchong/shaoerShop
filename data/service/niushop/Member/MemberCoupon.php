<?php
/**
 * MemberCoupon.php
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
namespace data\service\niushop\Member;
/**
 * 会员流水账户
 */
use data\service\BaseService;
use data\model\niushop\NsCouponModel as NsCouponModel;
class MemberCoupon extends BaseService
{
    function __construct(){
        parent::__construct();
    }
    /**
     * 使用优惠券
     * @param unknown $uid
     * @param unknown $coupon_id
     */
    public function useCoupon($uid, $coupon_id, $order_id)
    {
        $coupon = new NsCouponModel();
        $data = array(
            'use_order_id' => $order_id,
            'state' => 2
        );
        $res = $coupon->save($data, ['coupon_id' => $coupon_id]);
        return $res;
    
    }
    /**
     * 用户获取优惠券
     * @param unknown $uid
     * @param unknown $coupon_type_id
     */
    public function UserAchieveCoupon($uid, $coupon_type_id)
    {
        $coupon = new NsCouponModel();
        $count = $coupon->where(['coupon_type_id'=>$coupon_type_id, 'uid'=> 0])->count();
        if($count > 0)
        {
            $data = array(
                'uid' => $uid,
                'fetch_time' => date("Y-m-d H:i:s", time())
            );
            $retval = $coupon->where(['coupon_type_id'=>$coupon_type_id, 'uid'=> 0])->limit(1)->update($data);
        }else{
            $retval = 0;
        }
        return $retval;
    
    }
    /**
     * 订单返还会员优惠券
     * @param unknown $coupon_id
     */
    public function UserReturnCoupon($coupon_id){
        $coupon = new NsCouponModel();
        $data = array(
            'state' => 1
    
        );
        $retval = $coupon->save($data,['coupon_id' => $coupon_id]);
        return $retval;
    }
    /**
     * 获取优惠券金额
     * @param unknown $coupon_id
     */
    public function getCouponMoney($coupon_id){
        $coupon = new NsCouponModel();
        $money = $coupon->getInfo(['coupon_id' => $coupon_id],'money');
        if(!empty($money['money']))
        {
            return $money['money'];
        }else{
            return 0;
        }
    }
    /**
     * 查询当前会员优惠券列表
     * @param unknown $type  1已领用（未使用） 2已使用 3已过期
     */
    public function getUserCouponList($type = '',$shop_id='')
    {
        $time = date("Y-m-d H:i:s", time());
        $condition['uid'] = $this->uid;
        switch ($type)
        {
            case 1:
                //未使用，已领用,未过期
               // $condition['start_time'] = array('ELT', $time);
                //$condition['end_time'] = array('EGT', $time);
                $condition['state'] = 1;
				break;
            case 2:
                //已使用
                $condition['state'] = 2;
				break;
            case 3:
                //$condition['end_time'] = array('ELT', $time);
                $condition['state'] = 3;
				break;
			default:
			    break;
        }
        if(!empty($shop_id)){
            $condition['shop_id'] = $shop_id;
        }
        $coupon = new NsCouponModel();
        $coupon_list = $coupon->getQuery($condition, '*', 'money desc');
        return $coupon_list;
    }
}