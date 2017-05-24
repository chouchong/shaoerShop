<?php
/**
 * IConfig.php
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
namespace data\api\system;
/**
 * 系统配置
 */
interface IConfig
{
    /**
     * 获取微信基本配置(WCHAT)
     */
    function getWchatConfig($instance_id);
    
   /**
    *   开放平台网站应用授权登录
    * @param unknown $appid
    * @param unknown $appsecret
    * @param unknown $url
    * @param unknown $call_back_url
    */
    function setWchatConfig($instance_id, $appid, $appsecret, $url, $call_back_url, $is_use);
    
    /**
     * 获取QQ互联配置(QQ)
     */
    function getQQConfig($instance_id);
    
    /**
     * qq互联
     * @param unknown $appkey
     * @param unknown $appsecret
     * @param unknown $url
     * @param unknown $call_back_url
     */
    function setQQConfig($instance_id, $appkey, $appsecret, $url, $call_back_url, $is_use);
    /**
     * 获取系统登录配置信息
     */
    function getLoginConfig();
    
    /**
     * 获取微信支付参数(WPAY)
     */
    function getWpayConfig($instance_id);
    
    /**
     * 设置微信支付参数(WPAY)
     * @param unknown $appid  微信登录appid
     * @param unknown $appkey  微信登录appkey
     * @param unknown $mch_id  商户账号
     * @param unknown $mch_key  商户支付秘钥
     */
    function setWpayConfig($instanceid, $appid, $appkey, $mch_id, $mch_key, $is_use);
    
    /**
     * 获取支付宝支付参数(ALIPAY)
     */
    function getAlipayConfig($instance_id);
    
    /**
     * 设置支付宝支付配置(ALIPAY)
     * @param unknown $partnerid  商户ID
     * @param unknown $seller    商户账号
     * @param unknown $ali_key   商户秘钥
     */
    function setAlipayConfig($instanceid,$partnerid, $seller, $ali_key, $is_use);
    
    /**
     * PC商城热搜关键词获取
     */
    function getHotsearchConfig($instanceid);
    
    /**
     * PC商城热搜关键词设置
     * @param unknown $partnerid
     * @param unknown $seller
     * @param unknown $ali_key
     */
    function setHotsearchConfig($instanceid, $keywords, $is_use);
    
    /**
     * pc 商城获取 默认搜索
     * @param unknown $instanceid
     */
    function getDefaultSearchConfig($instanceid);
    
    /**
     * PC商城热搜关键词设置
     * @param unknown $instanceid
     * @param unknown $keywords
     * @param unknown $is_use
     */
    function setDefaultSearchConfig($instanceid, $keywords, $is_use);
    
    /**
     * 获取 用户通知 
     */
    function getUserNotice($instanceid);
    
    /**
     * 设置 用户通知
     */
    function setUserNotice($instanceid,$keywords, $is_use);
    
    /**
     * 获取 发送邮件接口设置
     */
    function getEmailMessage($instanceid);
    
    /**
     * 设置  发送邮件接口设置
     */
    function setEmailMessage($instanceid, $email_host, $email_port, $email_addr, $email_id, $email_pass, $is_use);
    
    /**
     * 获取 发送短信接口设置
     * @param unknown $instanceid
     */
    function getMobileMessage($instanceid);
    /**
     * 设置    发送短信接口设置
     * @param unknown $instanceid
     * @param unknown $app_key
     * @param unknown $secret_key
     * @param unknown $is_use
     */
    function setMobileMessage($instanceid, $app_key, $secret_key, $free_sign_name, $is_use);
    /**
     * 获取   微信开放平台接口设置
     * @param unknown $instanceid
     */
    function getWinxinOpenPlatformConfig($instanceid);
    /**
     * 设置   微信开放平台接口设置
     * @param unknown $instanceid
     * @param unknown $appid
     * @param unknown $appsecret
     * @param unknown $encodingAesKey
     * @param unknown $tk
     * @param unknown $is_use
     */
    function setWinxinOpenPlatformConfig($instanceid, $appid, $appsecret, $encodingAesKey, $tk);
    /**
     * 获取     登录验证码
     */
    function getLoginVerifyCodeConfig($instanceid);
    /**
     * 设置       登录验证码是否开启
     * @param unknown $platform
     * @param unknown $admin
     * @param unknown $pc
     */
    function setLoginVerifyCodeConfig($instanceid, $platform, $admin, $pc);
    /**
     * 对于单店铺系统获取微信配置
     * @param unknown $instance_id
     */
    function getInstanceWchatConfig($instance_id);
    /**
     * 对于单店铺系统设置微信配置
     * @param unknown $instance_id
     * @param unknown $appid
     * @param unknown $appsecret
     */
    function setInstanceWchatConfig($instance_id, $appid, $appsecret);
    /**
     * 获取其他支付方式配置
     */
    function getOtherPayTypeConfig();
    /**
     * 设置其他支付方式配置
     * @param unknown $is_coin_pay
     * @param unknown $is_balance_pay
     */
    function setOtherPayTypeConfig($is_coin_pay, $is_balance_pay);
}