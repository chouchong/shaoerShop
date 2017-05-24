<?php
/**
 * IAddress.php
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
 * 系统地址接口
 *        
 */
interface IAddress
{

    /**
     * 获取区域列表
     */
    function getAreaList();

    /**
     * 获取省列表
     * 
     * @param number $Area_id            
     */
    function getProvinceList($Area_id = 0);

    /**
     * 获取市列表
     * 
     * @param number $province_id            
     */
    function getCityList($province_id = 0);

    /**
     * 获取区县列表
     * 
     * @param number $city_id            
     */
    function getDistrictList($city_id = 0);

    /**
     * 获取省名称
     * 
     * @param unknown $province_id            
     */
    function getProvinceName($province_id);

    /**
     * 获取市名称
     * 
     * @param unknown $city_id            
     */
    function getCityName($city_id);

    /**
     * 获取区县名称
     * 
     * @param unknown $cistrict_id            
     */
    function getDictrictName($cistrict_id);

    /**
     * 获取地区树
     */
    function getAreaTree();

    /**
     * 传入 省市县 获取 省市县 名称
     * 
     * @param unknown $province_id            
     * @param unknown $city_id            
     * @param unknown $district_id            
     */
    function getAddress($province_id, $city_id, $district_id);

    /**
     * 获取省id
     * 
     * @param unknown $province_name            
     */
    function getProvinceId($province_name);

    /**
     * 获取市id
     * 
     * @param unknown $city_name            
     */
    function getCityId($city_name);
    
}
