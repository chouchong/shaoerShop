<?php
/**
 * Config.php
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
 * @date : 2015.4.24
 * @version : v1.0.0.0
 */
namespace data\service\system;
/**
 * 系统配置业务层
 */
use data\service\BaseService as BaseService;
use data\api\system\IConfig as IConfig;
use data\model\system\ConfigModel as ConfigModel;
use data\model\system\ShopAdModel as ShopAdModel;
class Config extends BaseService implements IConfig
{
    private $config_module;
    function __construct()
    {
        parent::__construct();
        $this->config_module = new ConfigModel();
    }
	/* (non-PHPdoc)
     * @see \data\api\IConfig::getWchatConfig()
     */
    public function getWchatConfig($instance_id)
    {
        $info = $this->config_module->getInfo(['oauth_key'=>'WCHAT', 'instance_id'=>$instance_id],'oauth_value,is_use');
        if(empty($info['oauth_value']))
        {
           return array(
               'oauth_value' => array(
                   'APP_KEY'=>'',
                   'APP_SECRET'=>'',
                   'AUTHORIZE' =>'',
                   'CALLBACK'=>'',
               ),
               'is_use'=>0,
            );
        }else{
            $info['oauth_value'] = json_decode($info['oauth_value'], true);
            return $info;
        }
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\IConfig::setWchatConfig()
     */
    public function setWchatConfig($instance_id, $appid, $appsecret, $url, $call_back_url, $is_use)
    {
        $info = array(
            'APP_KEY'=>$appid,
            'APP_SECRET'=>$appsecret,
            'AUTHORIZE' =>$url,
            'CALLBACK'=>$call_back_url
        );
        $oauth_value = json_encode($info);
        $count = $this->config_module->where(['oauth_key'=>'WCHAT', 'instance_id'=>$instance_id])->count();
        if($count > 0)
        {
            $data = array(
                'oauth_value' =>$oauth_value,
                'is_use' =>$is_use,
                'modify_time' =>date('Y-m-d H:i:s', time())
            );
            $res = $this->config_module->where(['oauth_key'=>'WCHAT', 'instance_id'=>$instance_id])->update($data);
            if($res == 1){
                return SUCCESS;
            }else{
                return UPDATA_FAIL;
            }
        }else{
            $data = array(
                'instance_id'=>$instance_id,
                'oauth_key' => 'WCHAT',
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $res = $this->config_module->save($data);
        }
        
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\IConfig::getQQConfig()
     */
    public function getQQConfig($instance_id)
    {
        $info = $this->config_module->getInfo(['oauth_key'=>'QQLOGIN','instance_id'=>$instance_id], 'oauth_value,is_use');
         if(empty($info['oauth_value']))
        {
           return array(
                'oauth_value' => array(
                   'APP_KEY'=>'',
                   'APP_SECRET'=>'',
                   'AUTHORIZE' =>'',
                   'CALLBACK'=>'',
               ),
                'is_use'=>0,
            );
        }else{
            $info['oauth_value'] = json_decode($info['oauth_value'], true);
            return $info;
        }
        
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\IConfig::setQQConfig()
     */
    public function setQQConfig($instance_id, $appkey, $appsecret, $url, $call_back_url, $is_use)
    {
        $info = array(
            'APP_KEY'=>$appkey,
            'APP_SECRET'=>$appsecret,
            'AUTHORIZE' =>$url,
            'CALLBACK'=>$call_back_url
        );
        $oauth_value = json_encode($info);
        $count = $this->config_module->where(['oauth_key'=>'QQLOGIN', 'instance_id'=>$instance_id])->count();
        if($count > 0)
        {
            $data = array(
                'oauth_value' =>$oauth_value,
                'is_use' =>$is_use,
                'modify_time' =>date('Y-m-d H:i:s', time())
            );
            $res = $this->config_module->where(['oauth_key'=>'QQLOGIN', 'instance_id'=>$instance_id])->update($data);
            if($res == 1){
                return SUCCESS;
            }else{
                return UPDATA_FAIL;
            }
        }else{
            $data = array(
                'instance_id'=>$instance_id,
                'oauth_key' => 'QQLOGIN',
                'oauth_value' => $oauth_value,
                'is_use' =>$is_use,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $res = $this->config_module->save($data);
            return $res;
        }
        // TODO Auto-generated method stub
        
    }
    public function getLoginConfig(){
        switch (NS_VERSION) {
            case NS_VER_B2C:
                $instance_id = 0;
                break;
            case NS_VER_B2C_FX:
                $instance_id = 0;
                break;
            case NS_VER_B2B2C_FX1:
                $instance_id = 0;
                break;
            case NS_VER_B2B2C_FX2:
                $instance_id = 0;
                break;
        }
        $wchat_config = $this->getWchatConfig($instance_id);
        $qq_config = $this->getQQConfig($instance_id);
        
        $mobile_config = $this->getMobileMessage($instance_id);
        $email_config = $this->getEmailMessage($instance_id);
        $data = array(
            'wchat_login_config' => $wchat_config,
            'qq_login_config' => $qq_config,
            'mobile_config' => $mobile_config,
            'email_config' => $email_config
        );
        return $data;
    }

	/* (non-PHPdoc)
     * @see \data\api\IConfig::getWpayConfig()
     */
    public function getWpayConfig($instance_id)
    {
        $info = $this->config_module->getInfo(['instance_id'=>$instance_id,'oauth_key'=>'WPAY'], 'oauth_value,is_use');
        if(empty($info['oauth_value']))
        {
            return array(
                'oauth_value' => array(
                    'appid' => '',
                    'appkey' => '',
                    'mch_id' => '',
                    'mch_key' => '',
                ),
                'is_use' => 0,
            );
        }else{
            $info['oauth_value'] = json_decode($info['oauth_value'], true);
            return $info;
        }
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\IConfig::setWpayConfig()
     */
    public function setWpayConfig($instanceid, $appid, $appkey, $mch_id, $mch_key, $is_use)
    {
        $data = array(
            'appid'=>$appid,
            'appkey'=>$appkey,
            'mch_id' =>$mch_id,
            'mch_key'=>$mch_key
        );
        $oauth_value = json_encode($data);
        $info = $this->config_module->getInfo(['oauth_key'=>'WPAY', 'instance_id' => $instanceid], 'oauth_value');
        if(empty($info['oauth_value']))
        {
            $config_module = new ConfigModel();
            $data = array(
                'instance_id' => $instanceid,
                'oauth_key' => 'WPAY',
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data);
        }else
        {
            $config_module = new ConfigModel();
            $data = array(
                'oauth_key' => 'WPAY',
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'modify_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data, ['instance_id' => $instanceid, 'oauth_key'=>'WPAY']);
        }
        return $res;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\IConfig::getAlipayConfig()
     */
    public function getAlipayConfig($instance_id)
    {
        $info = $this->config_module->getInfo(['instance_id'=>$instance_id,'oauth_key'=>'ALIPAY'], 'oauth_value,is_use');
        if(empty($info['oauth_value']))
        {
            return array(
                'oauth_value' => array(
                    'ali_partnerid' => '',
                    'ali_seller' => '',
                    'ali_key' => ''
                ),
                'is_use' => 0,
            );
        }else{
            $info['oauth_value'] = json_decode($info['oauth_value'], true);
            return $info;
        }
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\IConfig::setAlipayConfig()
     */
    public function setAlipayConfig($instanceid, $partnerid, $seller, $ali_key, $is_use)
    {
        $data = array(
              'ali_partnerid' => $partnerid,
                'ali_seller' => $seller,
                'ali_key' => $ali_key
        );
        $oauth_value = json_encode($data);
        $info = $this->config_module->getInfo(['oauth_key'=>'ALIPAY', 'instance_id' => $instanceid], 'oauth_value');
        if(empty($info['oauth_value']))
        {
            $config_module = new ConfigModel();
            $data = array(
                'instance_id' => $instanceid,
                'oauth_key' => 'ALIPAY',
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data);
        }else
        {
            $config_module = new ConfigModel();
            $data = array(
                'oauth_key' => 'ALIPAY',
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'modify_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data, ['instance_id' => $instanceid, 'oauth_key'=>'ALIPAY']);
        }
        return $res;
        // TODO Auto-generated method stub
        
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\system\IConfig::getHotsearchConfig()
     */
    public function getHotsearchConfig($instanceid)
    {
        $info = $this->config_module->getInfo(['oauth_key'=>'HOTKEY', 'instance_id'=>$instanceid], 'oauth_value');
        if(empty($info['oauth_value']))
        {
            return null;
        }else{
            return json_decode($info['oauth_value'], true);
        }
        // TODO Auto-generated method stub
    
    }
    /*
     * (non-PHPdoc)
     * @see \data\api\system\IConfig::setHotsearchConfig()
     */
    public function setHotsearchConfig($instanceid, $keywords, $is_use)
    {
        $data = $keywords;
        $oauth_value = json_encode($data);
        $info = $this->config_module->getInfo(['oauth_key'=>'HOTKEY', 'instance_id' => $instanceid], 'oauth_value');
        if(empty($info['oauth_value']))
        {
            $config_module = new ConfigModel();
            $data = array(
                'instance_id' => $instanceid,
                'oauth_key' => 'HOTKEY',
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data);
        }else
        {
            $config_module = new ConfigModel();
            $data = array(
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'modify_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data, ['instance_id' => $instanceid, 'oauth_key' => 'HOTKEY']);
        }
        return $res;
        // TODO Auto-generated method stub
    
    }
    
    /**
     * {@inheritDoc}
     * @see \data\api\system\IConfig::getDefaultSearchConfig()
     */
    public function getDefaultSearchConfig($instanceid){
        $info = $this->config_module->getInfo(['oauth_key'=>'DEFAULTKEY', 'instance_id'=>$instanceid], 'oauth_value');
        if(empty($info['oauth_value'])){
            return null;
        }else{
            return json_decode($info['oauth_value'], true);
        }
    }
    
    /**
     * {@inheritDoc}
     * @see \data\api\system\IConfig::setDefaultSearchConfig()
     */
    public function setDefaultSearchConfig($instanceid, $keywords, $is_use){
        $data = $keywords;
        $oauth_value = json_encode($data);
        $info = $this->config_module->getInfo(['oauth_key'=>'DEFAULTKEY', 'instance_id' => $instanceid], 'oauth_value');
        if(empty($info['oauth_value']))
        {
            $config_module = new ConfigModel();
            $data = array(
                'instance_id' => $instanceid,
                'oauth_key' => 'DEFAULTKEY',
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data);
        }else
        {
            $config_module = new ConfigModel();
            $data = array(
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'modify_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data, ['instance_id' => $instanceid,'oauth_key' => 'DEFAULTKEY']);
        }
        return $res;
    }
    
    /**
     * {@inheritDoc}
     * @see \data\api\system\IConfig::getUserNotice()
     */
    public function getUserNotice($instanceid){
        $info = $this->config_module->getInfo(['oauth_key'=>'USERNOTICE', 'instance_id' => $instanceid], 'oauth_value');
        if(empty($info['oauth_value'])){
            return null;
        }else{
            return json_decode($info['oauth_value'], true);
        }
    }
    
    /**
     * {@inheritDoc}
     * @see \data\api\system\IConfig::setUserNotice()
     */
    public function setUserNotice($instanceid, $keywords, $is_use){
        $data = $keywords;
        $oauth_value = json_encode($data);
        $info = $this->config_module->getInfo(['oauth_key'=>'USERNOTICE', 'instance_id' => $instanceid], 'oauth_value');
        if(empty($info['oauth_value']))
        {
            $config_module = new ConfigModel();
            $data = array(
                'instance_id' => $instanceid,
                'oauth_key' => 'USERNOTICE',
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data);
        }else
        {
            $config_module = new ConfigModel();
            $data = array(
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'modify_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data, ['instance_id' => $instanceid, 'oauth_key'=>'USERNOTICE']);
        }
        return $res;
    }
    
    /**
     * {@inheritDoc}
     * @see \data\api\system\IConfig::getEmailMessage()
     */
    public function getEmailMessage($instanceid){
        $info = $this->config_module->getInfo(['oauth_key'=>'EMAILMESSAGE', 'instance_id' => $instanceid], 'oauth_value, is_use');
        if(empty($info['oauth_value'])){
            return array(
                'oauth_value' => array(
                    'email_host' => '',
                    'email_port' => '',
                    'email_addr' => '',
                    'email_id' => '',
                ),
                'is_use' => 0
            );
        }else{
            $info['oauth_value'] = json_decode($info['oauth_value'], true);
            return $info;
        }
    }
    
    /**
     * {@inheritDoc}
     * @see \data\api\system\IConfig::setEmailMessage()
     */
    public function setEmailMessage($instanceid, $email_host, $email_port, $email_addr, $email_id, $email_pass, $is_use){
        $data = array(
            'email_host' => $email_host,
            'email_port' => $email_port,
            'email_addr' => $email_addr,
            'email_id' => $email_id,
            'email_pass' => $email_pass,
        );
        $oauth_value = json_encode($data);
        $info = $this->config_module->getInfo(['oauth_key'=>'EMAILMESSAGE', 'instance_id' => $instanceid], 'oauth_value');
        if(empty($info['oauth_value']))
        {
            $config_module = new ConfigModel();
            $data = array(
                'instance_id' => $instanceid,
                'oauth_key' => 'EMAILMESSAGE',
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data);
        }else
        {
            $config_module = new ConfigModel();
            $data = array(
                'oauth_key' => 'EMAILMESSAGE',
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'modify_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data, ['instance_id' => $instanceid, 'oauth_key'=>'EMAILMESSAGE']);
        }
        return $res;
    }
    
    /**
     * {@inheritDoc}
     * @see \data\api\system\IConfig::getMobileMessage()
     */
    public function getMobileMessage($instanceid){
        $info = $this->config_module->getInfo(['oauth_key'=>'MOBILEMESSAGE', 'instance_id' => $instanceid], 'oauth_value, is_use');
        if(empty($info['oauth_value'])){
            return array(
                'oauth_value' => array(
                    'appKey' => '',
                    'secretKey' => '',
                    'freeSignName' => '',
                ),
                'is_use' => 0
            );
        }else{
            $info['oauth_value'] = json_decode($info['oauth_value'], true);
            return $info;
        }
    }
    /**
     * {@inheritDoc}
     * @see \data\api\system\IConfig::setMobileMessage()
     */
    public function setMobileMessage($instanceid, $app_key, $secret_key, $free_sign_name, $is_use){
        $data = array(
            'appKey' => $app_key,
            'secretKey' => $secret_key,
            'freeSignName' => $free_sign_name,
        );
        $oauth_value = json_encode($data);
        $info = $this->config_module->getInfo(['oauth_key'=>'MOBILEMESSAGE', 'instance_id' => $instanceid], 'oauth_value');
        if(empty($info['oauth_value']))
        {
            $config_module = new ConfigModel();
            $data = array(
                'instance_id' => $instanceid,
                'oauth_key' => 'MOBILEMESSAGE',
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data);
        }else
        {
            $config_module = new ConfigModel();
            $data = array(
                'oauth_key' => 'MOBILEMESSAGE',
                'oauth_value' => $oauth_value,
                'is_use' => $is_use,
                'modify_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data, ['instance_id' => $instanceid, 'oauth_key'=>'MOBILEMESSAGE']);
        }
        return $res;
    }
    /**
     * {@inheritDoc}
     * @see \data\api\system\IConfig::getWinxinOpenPlatformConfig()
     */
    public function getWinxinOpenPlatformConfig($instanceid){
        $info = $this->config_module->getInfo(['oauth_key'=>'WXOPENPLATFORM', 'instance_id' => $instanceid], 'oauth_value, is_use');
        if(empty($info['oauth_value'])){
            return array(
                'oauth_value' => array(
                    'appId' => '',
                    'appsecret' => '',
                    'encodingAesKey' => '',
                    'tk' => ''
                ),
                'is_use' => 1
            );
        }else{
            $info['oauth_value'] = json_decode($info['oauth_value'], true);
            return $info;
        }
    }
    /**
     * {@inheritDoc}
     * @see \data\api\system\IConfig::setWinxinOpenPlatformConfig()
     */
    public function setWinxinOpenPlatformConfig($instanceid, $appid, $appsecret, $encodingAesKey, $tk){
        $data = array(
            'appId' => $appid,
            'appsecret' => $appsecret,
            'encodingAesKey' => $encodingAesKey,
            'tk' => $tk
        );
        $oauth_value = json_encode($data);
        $info = $this->config_module->getInfo(['oauth_key'=>'WXOPENPLATFORM', 'instance_id' => $instanceid], 'oauth_value');
        if(empty($info['oauth_value']))
        {
            $config_module = new ConfigModel();
            $data = array(
                'instance_id' => $instanceid,
                'oauth_key' => 'WXOPENPLATFORM',
                'oauth_value' => $oauth_value,
                'is_use' => 1,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data);
        }else
        {
            $config_module = new ConfigModel();
            $data = array(
                'oauth_key' => 'WXOPENPLATFORM',
                'oauth_value' => $oauth_value,
                'is_use' => 1,
                'modify_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data, ['instance_id' => $instanceid, 'oauth_key'=>'WXOPENPLATFORM']);
        }
        return $res;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\system\IConfig::getLoginVerifyCodeConfig()
     */
    public function getLoginVerifyCodeConfig($instanceid){
        $info = $this->config_module->getInfo(['oauth_key'=>'LOGINVERIFYCODE', 'instance_id' => $instanceid], 'oauth_value, is_use');
        if(empty($info['oauth_value'])){
            return array(
                'oauth_value' => array(
                    'platform' => 0,
                    'admin' => 0,
                    'pc' => 0
                ),
                'is_use' => 1
            );
        }else{
            $info['oauth_value'] = json_decode($info['oauth_value'], true);
            return $info;
        }
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\system\IConfig::setLoginVerifyCodeConfig()
     */
    public function setLoginVerifyCodeConfig($instanceid, $platform, $admin, $pc){
        $data = array(
            'platform' => $platform,
            'admin' => $admin,
            'pc' => $pc
        );
        $oauth_value = json_encode($data);
        $info = $this->config_module->getInfo(['oauth_key'=>'LOGINVERIFYCODE', 'instance_id' => $instanceid], 'oauth_value');
        if(empty($info['oauth_value']))
        {
            $config_module = new ConfigModel();
            $data = array(
                'instance_id' => $instanceid,
                'oauth_key' => 'LOGINVERIFYCODE',
                'oauth_value' => $oauth_value,
                'is_use' => 1,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data);
        }else
        {
            $config_module = new ConfigModel();
            $data = array(
                'oauth_key' => 'LOGINVERIFYCODE',
                'oauth_value' => $oauth_value,
                'is_use' => 1,
                'modify_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data, ['instance_id' => $instanceid, 'oauth_key'=>'LOGINVERIFYCODE']);
        }
        return $res;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\system\IConfig::setInstanceWchatConfig()
     */
    public function setInstanceWchatConfig($instance_id, $appid, $appsecret){
         $data = array(
            'appid' => $appid,
            'appsecret' => $appsecret
        );
        $oauth_value = json_encode($data);
        $info = $this->config_module->getInfo(['oauth_key'=>'SHOPWCHAT', 'instance_id' => $instance_id], 'oauth_value');
        if(empty($info['oauth_value']))
        {
            $config_module = new ConfigModel();
            $data = array(
                'instance_id' => $instance_id,
                'oauth_key' => 'SHOPWCHAT',
                'oauth_value' => $oauth_value,
                'is_use' => 1,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data);
        }else
        {
            $config_module = new ConfigModel();
            $data = array(
                'oauth_key' => 'SHOPWCHAT',
                'oauth_value' => $oauth_value,
                'is_use' => 1,
                'modify_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data, ['instance_id' => $instance_id, 'oauth_key'=>'SHOPWCHAT']);
        }
        return $res;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\system\IConfig::getInstanceWchatConfig()
     */
    public function getInstanceWchatConfig($instance_id){
        $info = $this->config_module->getInfo(['oauth_key'=>'SHOPWCHAT', 'instance_id' => $instance_id], 'oauth_value');
        if(empty($info['oauth_value'])){
            return array(
                'oauth_value' => array(
                    'appid' => '',
                    'appsecret' => ''
                ),
                'is_use' => 1
            );
        }else{
            $info['oauth_value'] = json_decode($info['oauth_value'], true);
            return $info;
        }
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\system\IConfig::getOtherPayTypeConfig()
     */
    public function getOtherPayTypeConfig(){
      $info = $this->config_module->getInfo(['oauth_key'=>'OTHER_PAY', 'instance_id' => 0], 'oauth_value');
        if(empty($info['oauth_value'])){
            return array(
                'oauth_value' => array(
                    'is_coin_pay' => 0,
                    'is_balance_pay' => 0
                ),
                'is_use' => 1
            );
        }else{
            $info['oauth_value'] = json_decode($info['oauth_value'], true);
            return $info;
        }
        
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\system\IConfig::setOtherPayTypeConfig()
     */
    public function setOtherPayTypeConfig($is_coin_pay, $is_balance_pay){
        $data = array(
            'is_coin_pay' => $is_coin_pay,
            'is_balance_pay' => $is_balance_pay
        );
        $oauth_value = json_encode($data);
        $info = $this->config_module->getInfo(['oauth_key'=>'OTHER_PAY', 'instance_id' => 0], 'oauth_value');
        if(empty($info['oauth_value']))
        {
            $config_module = new ConfigModel();
            $data = array(
                'instance_id' => 0,
                'oauth_key' => 'OTHER_PAY',
                'oauth_value' => $oauth_value,
                'is_use' => 1,
                'create_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data);
        }else
        {
            $config_module = new ConfigModel();
            $data = array(
                'oauth_key' => 'OTHER_PAY',
                'oauth_value' => $oauth_value,
                'is_use' => 1,
                'modify_time' => date('Y-m-d H:i:s', time())
            );
            $res = $config_module->save($data, ['instance_id' => 0, 'oauth_key'=>'OTHER_PAY']);
        }
        return $res;
    }
}