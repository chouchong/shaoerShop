<?php
/**
 * IMember.php
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
use data\api\system\IUser as IUser;
/**
 * 前台会员接口
 *
 */
interface IMember extends IUser
{
    
    /**
     * 前台会员添加
     * @param unknown $user_name
     * @param unknown $password
     * @param unknown $email
     * @param unknown $mobile
     * @param unknown $is_system
     * @param unknown $user_qq_id
     * @param unknown $qq_info
     * @param unknown $wx_openid
     * @param unknown $wx_info
     */
    function registerMember($user_name,$password, $email, $mobile, $user_qq_id, $qq_info, $wx_openid, $wx_info, $wx_unionid);
    
    /**
     * 删除会员
     * @param unknown $uid(会员ID)
     */
    function deleteMember($uid);
    /**
     * 会员列表
     * @param number $page_index
     * @param number $page_size
     * @param string $condition
     * @param string $order
     * @param string $field
     */
    function getMemberList($page_index=1, $page_size=0, $condition = '', $order = '', $field = '*');
    /**
     * 获取会员默认地址
     */
    function getDefaultExpressAddress();
    /**
     * 获取会员基础信息
     */
    function getMemberInfo();
    /**
     * 获取会员详情
     * $shop_id不传就为全部
     */
    function getMemberDetail($shop_id='');
    /**
     * 会员地址管理列表
     */
    function getMemberExpressAddressList();
    /**
     * 修改会员地址
     * @param unknown $id
     * @param unknown $consigner
     * @param unknown $mobile
     * @param unknown $phone
     * @param unknown $province
     * @param unknown $city
     * @param unknown $district
     * @param unknown $address
     * @param unknown $zip_code
     * @param unknown $alias
     */
    function updateMemberExpressAddress($id, $consigner, $mobile, $phone, $province, $city, $district, $address, $zip_code, $alias);
    /**
     * 添加会员物流地址
     * @param unknown $consigner
     * @param unknown $mobile
     * @param unknown $phone
     * @param unknown $province
     * @param unknown $city
     * @param unknown $district
     * @param unknown $address
     * @param unknown $zip_code
     * @param unknown $alias
     */
    function addMemberExpressAddress($consigner, $mobile, $phone, $province, $city, $district, $address, $zip_code, $alias);
    /**
     * 获取会员物流地址详情
     * @param unknown $id 地址ID
     */
    function getMemberExpressAddressDetail($id);
    /**
     * 删除会员物流地址
     * @param unknown $id  地址ID
     */
    function memberAddressDelete($id);
    /**
     * 修改地址为默认地址
     * @param unknown $id
     */  
    function updateAddressDefault($id);
    /**
     * 修改个人信息
     * @param unknown $user_name
     * @param unknown $user_tel
     * @param unknown $user_qq
     * @param unknown $user_email
     * @param unknown $real_name
     * @param unknown $sex
     * @param unknown $birthday
     * @param unknown $location
     * @param unknown $user_headimg
     */
    function updateMemberInformation($user_name,$user_tel,$user_qq, $user_email,$real_name,$sex,$birthday,$location,$user_headimg);
    /**
     * 分页获取用户积分和余额
     * @param unknown $uid          //用户ID
     * @param unknown $page_index   //分页列
     * @param unknown $page_size    //分页数量
     */
    function getShopAccountListByUser($uid,$page_index,$page_size);
    /**
     * 获取会员积分记录
     * @param unknown $start_time  //开始时间
     * @param unknown $end_time    //结束时间
     */
    function getMemberPointList($start_time, $end_time);
    /**
     * 分页获取会员积分记录
     * @param unknown $start_time  //开始时间
     * @param unknown $end_time    //结束时间
     * @param unknown $page_index   //分页列
     * @param unknown $page_size    //分页数量
     * @param unknown $shop_id    //店铺ID
     */
    function getPageMemberPointList($start_time, $end_time,$page_index,$page_size,$shop_id);
    /**
     * 获取会员余额
     * @param unknown $start_time  //开始时间
     * @param unknown $end_time     //结束时间
     */
    function getMemberBalanceList($start_time, $end_time);
    /**
     * 分页获取会员余额记录
     * @param unknown $start_time  //开始时间
     * @param unknown $end_time    //结束时间
     * @param unknown $page_index   //分页列
     * @param unknown $page_size    //分页数量
     * @param unknown $shop_id    //店铺ID
     */
    function getPageMemberBalanceList($start_time, $end_time,$page_index,$page_size,$shop_id);
    /**
     * 通过订单ID获取订单号
     * @param unknown $order_id  //订单ID
     */
    function getOrderNumber($order_id);
    /**
     * 获取会员优惠券
     * @param unknown $type  1已领用未使用  2.已使用   3.已过期
     */
    function getMemberCounponList($type);
    /**
     * 通过商铺号来获取商铺名
     * @param unknown $shop_id  商铺ID
     */
    function getShopNameByShopId($shop_id);
    /**
     * 会员锁定
     * {@inheritDoc}
     * @see \data\api\system\IUser::userLock()
     */
    function userLock($uid);
    /**
     * 会员解锁
     * @param unknown $uid
     */
    function userUnlock($uid);
    /**
     * 获取会员商品收藏
     * @param number $page_index
     * @param number $page_size
     * @param string $condition
     * @param string $order
     */
    function getMemberGoodsFavoritesList($page_index=1, $page_size=0, $condition = '', $order = '');
    /**
     * 获取会员店铺收藏
     * @param number $page_index
     * @param number $page_size
     * @param string $condition
     * @param string $order
     */
    function getMemberShopsFavoritesList($page_index=1, $page_size=0, $condition = '', $order = '');
    /**
     * 添加收藏
     * @param unknown $fav_id   对应店铺或者会员ID 
     * @param unknown $fav_type  收藏方式  goods shop 
     * @param unknown $log_msg   收藏备注
     */
    function addMemberFavouites($fav_id, $fav_type,$log_msg);
    /**
     * 取消收藏
     * @param unknown $fav_id   对应店铺或者会员ID
     * @param unknown $fav_type  收藏方式  goods shop
     */
    function deleteMemberFavorites($fav_id, $fav_type);
    /**
     * 判断会员 是否已经收藏（商品，店铺）  返回  1 or 0
     * @param unknown $uid
     * @param unknown $fav_id
     * @param unknown $fav_type
     */
    function getIsMemberFavorites($uid, $fav_id, $fav_type);
    /**
     * 获取浏览历史
     */
    function getMemberViewHistory();
    /**
     * 获取会员浏览历史
     * @param unknown $uid
     * @param unknown $start_time
     * @param unknown $end_time
     */
    function getMemberAllViewHistory($uid, $start_time, $end_time);
    /**
     * 添加浏览历史
     * @param unknown $goods_id
     * @param unknown $goods_name
     * @param unknown $goods_category_id
     */
    function addMemberViewHistory($goods_id);
    /**
     * 删除浏览历史
     */
    function deleteMemberViewHistory();
    /**
     * 获取用户猜你喜欢
     */
    function getGuessMemberLikes();
    /**
     * 获取会员申请店铺情况
     * @param unknown $uid
     */
    function getMemberIsApplyShop($uid);
    /**
     * 获取店铺账户
     * @param unknown $uid
     * @param unknown $shop_id
     */
    function getMemberAccount($uid, $shop_id);
    /**
     * 会员积分转余额
     * @param unknown $uid
     * @param unknown $shop_id
     * @param unknown $point
     */
    function memberPointToBalance($uid, $shop_id, $point);
    
    /**
     * 会员对应店积分总额默认为平台的
     * @param unknown $shop_id
     */
    function memberShopPointCount($uid=0,$shop_id=0);
    
    /**
     * 会员对应店余额默认为平台的
     * @param unknown $shop_id
     */
    function memberShopBalanceCount($uid=0,$shop_id=0);
    /**
     * 获取所有会员
     * @param unknown $condition
     */
    function getMemberAll($condition);
    /**
     * 获取会员头像
     * @param unknown $uid
     */
    function getMemberImage($uid);
    /**
     * 获取会员总数
     */
    function getMemberCount($condition);
    /**
     * 查看某月的会员注册情况
     * @param unknown $begin_date
     * @param unknown $end_date
     */
    function getMemberMonthCount($begin_date, $end_date);
    /**
     * 会员购物币流水
     * @param unknown $start_time
     * @param unknown $end_time
     */
    function getMemberCoinList($start_time, $end_time);
    /**
     * 会员购物币分页流水
     * @param unknown $start_time
     * @param unknown $end_time
     * @param unknown $page_index
     * @param unknown $page_size
     * @param unknown $shop_id
     */
    function getPageMemberCoinList($start_time, $end_time,$page_index,$page_size,$shop_id);
    /**
     * 充值会员账户（针对会员账户充值）1. 积分2. 余额 3. 购物币
     * @param unknown $shop_id
     * @param unknown $type
     * @param unknown $num
     * @param unknown $text
     */
    function addMemberAccount($shop_id, $uid, $type, $num, $text);
    
    /**
     * 判断会员是否已经签到
     * 返回  1 or 0
     */
    function getIsMemberSign($uid, $shop_id);
    
    /**
     * 获取会员签到记录
     * @param unknown $page_index
     * @param unknown $page_size
     * @param unknown $shop_id
     */
    function getPageMemberSignList($page_index,$page_size,$shop_id);
    
    /**
     * 判断 会员今天 是否已经分享过
     * 返回  1 or 0
     */
    function getIsMemberShare($uid, $shop_id);
}