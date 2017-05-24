<?php
/**
 * 返回值格式
 */
//定义返回值字母格式     基础1000-1999，  用户：2000-2999 商品：3000-3999， 订单：4000-4999 活动：5000-5999
//基础变量定义
define("VER_BC", '1111');//单店基础版
define("VER_BCFX", '1222');//单店分销版
define("VER_BBC", '2111');//平台基础版
define("VER_BBCFX", '2222');//平台分销版
define('SUCCESS', '1');
define('ADD_FAIL','-1000');
define('UPDATA_FAIL','-1001');
define('DELETE_FAIL','-1002');
define('SYSTEM_DELETE_FAIL','-1003');
define('WEIXIN_AUTH_ERROR', '-1004');
define('NO_AITHORITY', '-1005');
//用户变量定义
define('LOGIN_FAIL','-2000');
define('USER_ERROR', '-2001');
define('USER_LOCK', '-2002');
define('USER_NBUND', '-2003');
define('USER_REPEAT', '-2004');
define('PASSWORD_ERROR', '-2005');
define('USER_WORDS_ERROR', '-2006');
define('USER_ADDRESS_DELETE_ERROR', '-2007');

define('USER_GROUP_ISUSE', '-2008');
//订单定义变量
define('ORDER_DELIVERY_ERROR', '-4002');
define('LOW_STOCKS', '-4003');
define('LOW_POINT', '-4004');
define('LOW_BALANCE', '-4006');
define('ORDER_PAY', '-4005');
define('ORDER_CREATE_LOW_POINT', '-4007');
define('ORDER_CREATE_LOW_PLATFORM_MONEY', '-4008');
define('ORDER_CREATE_LOW_USER_MONEY', '-4009');
define('CLOSE_POINT', '-4010');
define('LOW_COIN', '-4011');
define('NULL_EXPRESS_FEE', '-4012');
define('NULL_EXPRESS', '-4013');
//活动定义变量
define('ACTIVE_REPRET', '-5001');


//微信菜单
define("MAX_MENU_LENGTH",'3');//一级菜单数量
define("MAX_SUB_MENU_LENGTH","5");//二级菜单数量


function getErrorInfo($error_code)
{
    $system_error_arr = array(
        //基础变量
        SUCCESS  => '操作成功',
        ADD_FAIL => '添加失败',
        UPDATA_FAIL => '修改失败',
        DELETE_FAIL => '删除失败',
        SYSTEM_DELETE_FAIL => '当前模块下存在子模块,不能删除!',
        NO_AITHORITY => '当前用户无权限',
        //用户变量定义
        LOGIN_FAIL => '登录失败',
        USER_ERROR => '账号或者密码错误',
        USER_LOCK  => '用户被锁定',
        USER_NBUND => '用户未绑定',
        USER_REPEAT => '当前用户名已存在',
        PASSWORD_ERROR => '用户密码错误',
        USER_WORDS_ERROR => '用户名只能是数字或者英文字母',
        USER_ADDRESS_DELETE_ERROR => '当前用户默认地址不能删除',
        USER_GROUP_ISUSE => '当前用户组已被使用，不能删除',

        //订单定义变量
        ORDER_DELIVERY_ERROR => '存在未发货订单',
        LOW_STOCKS => '库存不足',
        LOW_POINT  => '用户积分不足',
        LOW_COIN  => '用户购物币不足',
        CLOSE_POINT  => '店铺积分功能未开启',
        ORDER_PAY  => '订单已支付',
        ORDER_CREATE_LOW_POINT => '当前用户积分不足',
        ORDER_CREATE_LOW_PLATFORM_MONEY => '当前用户平台余额不足',
        ORDER_CREATE_LOW_USER_MONEY => '当前用户店铺余额不足',
        NULL_EXPRESS_FEE => '部分商品无货！',
        NULL_EXPRESS=> '无货',
        //活动定义变量
        ACTIVE_REPRET => '在同一时间段内存在相同商品的活动！'
    );
    if(array_key_exists($error_code, $system_error_arr))
    {
        return $system_error_arr[$error_code];
    } elseif($error_code > 0){
        return '操作成功';
    }else{
        return '操作失败';
    }
}
 