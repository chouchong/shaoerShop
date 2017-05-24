<?php
/**
 * Address.php
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
 * 区域地址
 */
use data\service\BaseService as BaseService;
use data\api\system\IAddress as IAddress;
use data\model\system\AreaModel as Area;
use data\model\system\ProvinceModel as Province;
use data\model\system\CityModel as City;
use data\model\system\DistrictModel as District;

class Address extends BaseService implements IAddress
{

    /*
     * (non-PHPdoc)
     * @see \data\api\system\IAddress::getAreaList()
     */
    public function getAreaList()
    {
        $area = new Area();
        $list = $area->getQuery('', 'area_id,area_name', '');
        return $list;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\system\IAddress::getProvinceList()
     */
    public function getProvinceList($area_id = 0)
    {
        $province = new Province();
        if ($area_id == 0) {
            $list = $province->getQuery('', 'province_id,area_id,province_name', '');
        } else {
            $list = $province->getQuery([
                'area_id' => $area_id
            ], 'province_id,area_id,province_name', '');
        }
        return $list;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\system\IAddress::getCityList()
     */
    public function getCityList($province_id = 0)
    {
        $city = new City();
        if ($province_id == 0) {
            $list = $city->getQuery('', 'city_id,province_id,city_name,zipcode', '');
        } else {
            $list = $city->getQuery([
                'province_id' => $province_id
            ], 'city_id,province_id,city_name,zipcode', '');
        }
        return $list;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\system\IAddress::getDistrictList()
     */
    public function getDistrictList($city_id = 0)
    {
        $district = new District();
        if ($city_id == 0) {
            $list = $district->getQuery('', 'district_id,city_id,district_name', '');
        } else {
            $list = $district->getQuery([
                'city_id' => $city_id
            ], 'district_id,city_id,district_name', '');
        }
        return $list;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\system\IAddress::getProvinceName()
     */
    public function getProvinceName($province_id)
    {
        $province = new Province();
        
        if (! empty($province_id)) {
            $condition = array(
                'province_id' => array(
                    'in',
                    $province_id
                )
            );
            $list = $province->getQuery($condition, 'province_name', '');
        }
        $name = '';
        if (! empty($list)) {
            foreach ($list as $k => $v) {
                $name .= $v['province_name'] . ',';
            }
            $name = substr($name, 0, strlen($name) - 1);
        }
        return $name;
        
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\system\IAddress::getCityName()
     */
    public function getCityName($city_id)
    {
        $city = new City();
        if (! empty($city_id)) {
            $condition = array(
                'city_id' => array(
                    'in',
                    $city_id
                )
            );
            $list = $city->getQuery($condition, 'city_name', '');
        }
        
        $name = '';
        if (! empty($list)) {
            foreach ($list as $k => $v) {
                $name .= $v['city_name'] . ',';
            }
            $name = substr($name, 0, strlen($name) - 1);
        }
        return $name;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\system\IAddress::getDictrictName()
     */
    public function getDictrictName($cistrict_id)
    {
        // TODO Auto-generated method stub
    }

    /**
     * 获取地区树(non-PHPdoc)
     *
     * @see \data\api\system\IAddress::getAreaTree()
     */
    public function getAreaTree()
    {
        $list = array();
        $area_list = $this->getAreaList();
        $list = $area_list;
        foreach ($area_list as $k_area => $v_area) {
            $province_list = $this->getProvinceList($v_area['area_id']);
            foreach ($province_list as $key_province => $v_province) {
                $city_list = $this->getCityList($v_province['province_id']);
                $province_list[$key_province]['city_list'] = $city_list;
            }
            $list[$k_area]['province_list'] = $province_list;
        }
        return $list;
    }

    /**
     * 获取地址 返回（例如： 山西省 太原市 小店区）
     *
     * @param unknown $province_id            
     * @param unknown $city_id            
     * @param unknown $dictrict_id            
     */
    public function getAddress($province_id, $city_id, $district_id)
    {
        $province = new Province();
        $city = new City();
        $district = new District();
        $province_name = $province->getInfo('province_id = ' . $province_id, 'province_name');
        $city_name = $city->getInfo('city_id = ' . $city_id, 'city_name');
        $district_name = $district->getInfo('district_id = ' . $district_id, 'district_name');
        $address = $province_name['province_name'] . '&nbsp;' . $city_name['city_name'] . '&nbsp;' . $district_name['district_name'];
        return $address;
    }

    /**
     * 获取省id
     *
     * {@inheritdoc}
     *
     * @see \data\api\system\IAddress::getProvinceId()
     */
    public function getProvinceId($province_name)
    {
        $province = new Province();
        $province_id = $province->getInfo([
            'province_name' => $province_name
        ], 'province_id');
        return $province_id;
    }

    /**
     * 获取市id
     *
     * {@inheritdoc}
     *
     * @see \data\api\system\IAddress::getCityId()
     */
    public function getCityId($city_name)
    {
        $city = new City();
        $city_id = $city->getInfo([
            'city_name' => $city_name
        ], 'city_id');
        return $city_id;
    }
}