<?php
/**
 * Distribution.php
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

use data\service\niufenxiao\NfxPromoter as NfxPromoterService;
use data\service\niufenxiao\NfxPartner;
use data\service\niufenxiao\NfxCommissionConfig;
use data\service\niufenxiao\NfxPromoter;
use data\service\niushop\GoodsGroup as GoodsGroup;
use data\service\niufenxiao\NfxShopConfig;
use data\service\niufenxiao\NfxPartnerGlobalCalculate;
use data\service\niufenxiao\NfxRegionAgent;
use data\service\system\Address;
use data\service\niushop\Member;
use data\service\niushop\promotion\PromoteRewardRule;

/**
 * 分销控制器
 */
class Distribution extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 推广员列表
     */
    public function promoterList()
    {
        if (request()->isAjax()) {
            $promoter = new NfxPromoterService();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $is_audit = isset($_POST['is_audit']) ? $_POST['is_audit'] : '';
            $start_date = ! empty($_POST['start_date']) ? $_POST['start_date'] : '2010-1-1';
            $end_date = ! empty($_POST['end_date']) ? $_POST['end_date'] : '2099-1-1';
            $condition["regidter_time"] = [
                [
                    ">",
                    $start_date
                ],
                [
                    "<",
                    $end_date
                ]
            ];
            if ($is_audit == "") {
                $condition["is_audit"] = 1;
            } else {
                $condition["is_audit"] = [
                    "<>",
                    1
                ];
            }
            
            $uid_string = "";
            $where = array();
            if ($_POST['user_name'] != "") {
                $where["user_name"] = array(
                    "like",
                    "%" . $_POST['user_name'] . "%"
                );
            }
            if ($_POST['user_phone'] != "") {
                $where["user_tel"] = $_POST['user_phone'];
            }
            if (! empty($where)) {
                $uid_string = $this->getUserUids($where);
                if ($uid_string != "") {
                    $condition["uid"] = array(
                        "in",
                        $uid_string
                    );
                } else {
                    $condition["uid"] = 0;
                }
            }
            // var_dump($uid_string);
            $condition["shop_id"] = $this->instance_id;
            $list = $promoter->getPromoterList($pageindex, PAGESIZE, $condition, 'regidter_time desc');
            return $list;
        } else {
            $is_audit = isset($_GET['is_audit']) ? $_GET['is_audit'] : 1;
            $this->assign("is_audit", $is_audit);
            
            if ($is_audit == 1) {
                $promoter = new NfxPromoterService();
                $level_list = $promoter->getPromoterLevelAll($this->instance_id);
                $this->assign("level_list", $level_list);
                $child_menu_list = array(
                    array(
                        'url' => "Distribution/promoterList",
                        'menu_name' => "推广员",
                        "active" => 1
                    ),
                    array(
                        'url' => "Distribution/promoterList?is_audit=0",
                        'menu_name' => "待审核",
                        "active" => 0
                    )
                );
                $this->assign('child_menu_list', $child_menu_list);
                return view($this->style . "Distribution/promoterList");
            }else{
                $child_menu_list = array(
                    array(
                        'url' => "Distribution/promoterList",
                        'menu_name' => "推广员",
                        "active" => 0
                    ),
                    array(
                        'url' => "Distribution/promoterList?is_audit=0",
                        'menu_name' => "待审核",
                        "active" => 1
                    )
                );
                $this->assign('child_menu_list', $child_menu_list);
                return view($this->style . "Distribution/promoterAuditList");
            }
        }
    }

    /**
     * 推广员审核
     */
    public function promoterAudit()
    {
        $promoter_id = $_POST["promoter_id"];
        $is_audit = $_POST["is_audit"];
        $uid = $_POST['uid'];
        $promoter = new NfxPromoterService();
        $res = $promoter->promoterAudit($promoter_id, $is_audit, $this->instance_id);
        if($is_audit == 1 && $res){
            $promote_reward_rule = new PromoteRewardRule();
            $promote_reward_rule ->RegisterPromoterSendPoint($this->instance_id, $uid);
            return AjaxReturn($res);   
        }         
    }
    
    public function test(){
        $promote_reward_rule = new PromoteRewardRule();
        $promote_reward_rule ->RegisterPromoterSendPoint($this->instance_id, 31);
    }
    
    /**
     * 推广员等级
     */
    public function promoterLevelList()
    {
        if (request()->isAjax()) {
            $promoter = new NfxPromoterService();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $condition = array(
                'shop_id' => $this->instance_id
            );
            $list = $promoter->getPromoterLevelList($pageindex, PAGESIZE, $condition, '');
            return $list;
        } else {
            $child_menu_list = array(
                array(
                    'url' => "Distribution/threeLevelDistributionConfig",
                    'menu_name' => "基本设置",
                    "active" => 0
                ),
                array(
                    'url' => "Distribution/promoterLevelList",
                    'menu_name' => "推广员等级",
                    "active" => 1
                )
            );
            $this->assign('child_menu_list', $child_menu_list);
            return view($this->style . "Distribution/promoterLevelList");
        }
    }

    /**
     * 添加店铺推广员等级
     */
    public function addPromoterLevel()
    {
        if (request()->isAjax()) {
            $shop_id = $this->instance_id;
            $level_name = $_POST["level_name"];
            $level_money = $_POST["level_money"];
            $level_0 = $_POST["level_0"];
            $level_1 = $_POST["level_1"];
            $level_2 = $_POST["level_2"];
            $promoter = new NfxPromoterService();
            $res = $promoter->addPromoterLevel($shop_id, $level_name, $level_money, $level_0, $level_1, $level_2);
            return AjaxReturn($res);
        } else {
            return view($this->style . "Distribution/addPromoterLevel");
        }
    }

    /**
     * 商品分销列表
     */
    public function goodsCommissionRateList()
    {
        if (request()->isAjax()) {
            $commission_config = new NfxCommissionConfig();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $start_date = ! empty($_POST['start_date']) ? $_POST['start_date'] : '2010-1-1';
            $end_date = ! empty($_POST['end_date']) ? $_POST['end_date'] : '2099-1-1';
            $goods_name = isset($_POST['goods_name']) ? $_POST['goods_name'] : '';
            $is_open = isset($_POST['is_open']) ? $_POST['is_open'] : '';
            // if($is_open != ""){
            // $goods_string = $this->getGoodsCommissionGoodsids(array("is_open"=>$is_open));
            // if($goods_string != ""){
            // $condition["goods_id"] = array("in",$goods_string);
            // } else{
            // $condition["goods_id"] =0;
            // }
            // }
            $condition["ng.create_time"] = [
                [
                    ">",
                    $start_date
                ],
                [
                    "<",
                    $end_date
                ]
            ];
            if (! empty($goods_name)) {
                $condition["ng.goods_name"] = array(
                    "like",
                    "%" . $goods_name . "%"
                );
            }
            $condition["ng.shop_id"] = $this->instance_id;
            $list = $commission_config->getGoodsCommissionRateList($pageindex, PAGESIZE, $condition, 'ng.create_time desc');
            return $list;
        } else {
            $goods_group = new GoodsGroup();
            $groupList = $goods_group->getGoodsGroupList(1, 0, [
                'shop_id' => $this->instance_id,
                'pid' => 0
            ]);
            if (! empty($groupList['data'])) {
                foreach ($groupList['data'] as $k => $v) {
                    $v['sub_list'] = $goods_group->getGoodsGroupList(1, 0, 'pid = ' . $v['group_id']);
                }
            }
            
            $this->assign("goods_group", $groupList['data']);
            return view($this->style . "Distribution/goodsCommissionRateList");
        }
    }

    /**
     * 商品开启或关闭分销
     */
    public function modifyGoodsDistribution()
    {
        $is_open = $_POST["is_open"];
        $condition = $_POST["goods_ids"];
        $commission_config = new NfxCommissionConfig();
        $res = $commission_config->modifyGoodsIsOpenDistribution($condition, $is_open);
        return AjaxReturn($res);
    }

    /**
     * 获取商品分销信息
     */
    public function getGoodsCommissionRateDetail()
    {
        $goods_id = $_POST["goods_id"];
        $commission_config = new NfxCommissionConfig();
        $res = $commission_config->getGoodsCommissionRate($goods_id);
        return $res;
    }

    /**
     * 商品分销修改
     */
    public function updateGoodsCommissionRate()
    {
        if (request()->isAjax()) {
            $condition_type = $_POST["condition_type"];
            $condition = $_POST["condition"];
            $distribution_commission_rate = $_POST["distribution_commission_rate"];
            $partner_commission_rate = $_POST["partner_commission_rate"];
            $global_commission_rate = $_POST["global_commission_rate"];
            $distribution_team_commission_rate = $_POST["distribution_team_commission_rate"];
            $partner_team_commission_rate = $_POST["partner_team_commission_rate"];
            $regionagent_commission_rate = $_POST["regionagent_commission_rate"];
            $channelagent_commission_rate = $_POST["channelagent_commission_rate"];
            $shop_id = $this->instance_id;
            $commission_config = new NfxCommissionConfig();
            $retval = $commission_config->updateGoodsCommissionRate($condition, $condition_type, $distribution_commission_rate, $partner_commission_rate, $global_commission_rate, $distribution_team_commission_rate, $partner_team_commission_rate, $regionagent_commission_rate, $channelagent_commission_rate, $shop_id);
            return AjaxReturn($retval);
        } else {
            $goods_id = $_GET["goods_id"];
            $this->assign("goods_id", $goods_id);
            $commission_config = new NfxCommissionConfig();
            $goods_info = $commission_config->getGoodsCommissionRate($goods_id);
            // var_dump($goods_info);
            $this->assign("goods_info", $goods_info);
            return view($this->style . "Distribution/updateGoodsCommissionRate");
        }
    }

    /**
     * 推广员详情
     */
    public function getPromoterDetail()
    {
        $promoter_id = $_POST["promoter_id"];
        $promoter = new NfxPromoter();
        $res = $promoter->getPromoterDetail($promoter_id);
        return $res;
    }

    /**
     * 修改推广员父级
     */
    public function modifyPromoterParent()
    {
        if (request()->isAjax()) {
            $promoter_id = $_POST["promoter_id"];
            $parent_promoter = $_POST["parent_promoter"];
            $promoter = new NfxPromoterService();
            $retval = $promoter->modifyPromoterParent($promoter_id, $parent_promoter, $this->instance_id);
            return AjaxReturn($retval);
        } else {
            $promoter_id = $_GET["promoter_id"];
            $parent_promoter = $_GET["parent_promoter"];
            $this->assign("promoter_id", $promoter_id);
            $this->assign("parent_promoter", $parent_promoter);
            return view($this->style . "Distribution/modifyPromoterParent");
        }
    }

    /**
     * 推广员冻结/解冻
     */
    public function modifyPromoterLock()
    {
        $is_lock = $_POST["is_lock"];
        $promoter_id = $_POST["promoter_id"];
        $promoter = new NfxPromoterService();
        $retval = $promoter->modifyPromoterLock($promoter_id, $is_lock);
        return AjaxReturn($retval);
    }

    /**
     * 修改推广员等级
     */
    public function updatePromoterLevel()
    {
        if (request()->isAjax()) {
            $level_id = $_POST["level_id"];
            $level_name = $_POST["level_name"];
            $level_money = $_POST["level_money"];
            $level_0 = $_POST["level_0"];
            $level_1 = $_POST["level_1"];
            $level_2 = $_POST["level_2"];
            $promoter = new NfxPromoterService();
            $retval = $promoter->updatePromoterLevel($level_id, $level_name, $level_money, $level_0, $level_1, $level_2);
            return AjaxReturn($retval);
        } else {
            $level_id = $_GET["level_id"];
            $promoter = new NfxPromoterService();
            $res = $promoter->getPromoterLevalDetail($level_id);
            $this->assign("premoter_level_info", $res);
            $this->assign("level_id", $level_id);
            return view($this->style . "Distribution/updatePromoterLevel");
        }
    }

    /**
     * 三级分销
     */
    public function threeLevelDistributionConfig()
    {
        $shop_config = new NfxShopConfig();
        $shop_config_info = $shop_config->getShopConfigDetail($this->instance_id);
        $this->assign("shop_config_info", $shop_config_info);
        $child_menu_list = array(
            array(
                'url' => "Distribution/threeLevelDistributionConfig",
                'menu_name' => "基本设置",
                "active" => 1
            ),
            array(
                'url' => "Distribution/promoterLevelList",
                'menu_name' => "推广员等级",
                "active" => 0
            )
        );
        $this->assign('child_menu_list', $child_menu_list);
        return view($this->style . "Distribution/threeLevelDistributionConfig");
    }

    /**
     * 是否开启三级分销及是否开启推广员shenhe
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function modifyShopConfigIsDistributionOrPromoterIsAudit()
    {
        $is_open = $_POST["is_open"];
        $is_audit = $_POST["is_audit"];
        $shop_config = new NfxShopConfig();
        $retval = $shop_config->modifyShopConfigIsDistributionOrPromoterIsAudit($this->instance_id, $is_open, $is_audit);
        return AjaxReturn($retval);
    }

    /**
     * 区域代理
     */
    public function regionalAgent()
    {
        $shop_config = new NfxShopConfig();
        $shop_config_info = $shop_config->getShopConfigDetail($this->instance_id);
        $this->assign("shop_config_info", $shop_config_info);
        $child_menu_list = array(
            array(
                'url' => "Distribution/regionalAgent",
                'menu_name' => "基本设置",
                "active" => 1
            ),
            array(
                'url' => "Distribution/promoterRegionAgentList",
                'menu_name' => "人员管理",
                "active" => 0
            )
        );
        $region_agent = new NfxRegionAgent();
        $region_agent_info = $region_agent->getShopRegionAgentConfig($this->instance_id);
        // ($region_agent_info);
        $this->assign("region_agent_info", $region_agent_info);
        $this->assign('child_menu_list', $child_menu_list);
        return view($this->style . "Distribution/regionalAgent");
    }

    /**
     * 店铺代理配置
     */
    public function UpdateShopRegionAgentConfig()
    {
        if (request()->isAjax()) {
            // 是否开启区域代理
            $is_open = $_POST["is_open"];
            // $shop_config = new NfxShopConfig();
            // $retval = $shop_config->modifyShopConfigIsRegionalAgent($this->instance_id,$is_open);
            
            // 修改区域代理配置
            $province_rate = $_POST["province_rate"];
            $city_rate = $_POST["city_rate"];
            $district_rate = $_POST["district_rate"];
            $application_require_province = $_POST["application_require_province"];
            $application_require_city = $_POST["application_require_city"];
            $application_require_district = $_POST["application_require_district"];
            $region_agent = new NfxRegionAgent();
            $retval = $region_agent->updateShopRegionAgentConfig($this->instance_id, $province_rate, $city_rate, $district_rate, $application_require_province, $application_require_city, $application_require_district, $is_open);
            return ajaxReturn($retval);
        } else {
            $child_menu_list = array(
                array(
                    'url' => "Distribution/regionalAgent",
                    'menu_name' => "基本设置",
                    "active" => 0
                ),
                array(
                    'url' => "Distribution/promoterRegionAgentList",
                    'menu_name' => "人员管理",
                    "active" => 0
                )
            );
            $this->assign('child_menu_list', $child_menu_list);
            $region_agent = new NfxRegionAgent();
            $region_agent_info = $region_agent->getShopRegionAgentConfig($this->instance_id);
            // ($region_agent_info);
            $this->assign("region_agent_info", $region_agent_info);
            return view($this->style . "Distribution/UpdateShopRegionAgentConfig");
        }
    }

    /**
     * 获取区域列表
     *
     * @return multitype:unknown
     */
    public function getAddressList()
    {
        $address = new Address();
        $province_list = $address->getProvinceList();
        $city_list = $address->getCityList();
        $district_list = $address->getDistrictList();
        $address_list = array();
        $address_list["province_list"] = $province_list;
        $address_list["city_list"] = $city_list;
        $address_list["district_list"] = $district_list;
        return $address_list;
    }

    /**
     * 区域代理审核
     *
     * @return multitype:number unknown |Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function modifyPromoterRegionAgentIsAudit()
    {
        $is_audit = isset($_POST["is_audit"]) ? $_POST["is_audit"] : "";
        //var_dump($is_audit);exit;
        $region_agent_id = isset($_POST["region_agent_id"]) ? $_POST["region_agent_id"] : "";
        
        $province_id = isset($_POST["province_id"]) ? $_POST["province_id"] :"";
        $city_id = isset($_POST["city_id"]) ? $_POST["city_id"] :"";
        $district_id = isset($_POST["district_id"]) ? $_POST["district_id"] :"";
        
        $region_agent = new NfxRegionAgent();
        $retval = $region_agent->modifyPromoterRegionAgentIsAudit($this->instance_id, $is_audit, $region_agent_id, $province_id, $city_id, $district_id);
        return AjaxReturn($retval);
    }

    /**
     * 区域代理人员管理
     *
     * @return multitype:number unknown |Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    function promoterRegionAgentList()
    {
        if (request()->isAjax()) {
            $region_agent = new NfxRegionAgent();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $start_date = ! empty($_POST['start_date']) ? $_POST['start_date'] : '2010-1-1';
            $end_date = ! empty($_POST['end_date']) ? $_POST['end_date'] : '2099-1-1';
            $agent_type = ! empty($_POST['agent_type']) ? $_POST['agent_type'] : 0;
            $condition = array(
                'shop_id' => $this->instance_id
            );
            if ($agent_type != 0) {
                $condition["agent_type"] = $agent_type;
            }
            $condition["reg_time"] = [
                [
                    ">",
                    $start_date
                ],
                [
                    "<",
                    $end_date
                ]
            ];
            if ($_POST['user_name'] != "") {
                $uid_string = "";
                $where = array(
                    "user_name" => array(
                        "like",
                        "%" . $_POST['user_name'] . "%"
                    )
                );
                $uid_string = $this->getUserUids($where);
                if ($uid_string != "") {
                    $condition["uid"] = array(
                        "in",
                        $uid_string
                    );
                }
            }
            $list = $region_agent->getPromoterRegionAgent($pageindex, PAGESIZE, $condition, 'reg_time desc');
            return $list;
        } else {
            // $address = new Address();
            // $province_list = $address->getProvinceList();
            // $city_list = $address->getCityList();
            // $district_list = $address->getDistrictList();
            // $this->assign("province_list",$province_list);
            // $this->assign("city_list",$city_list);
            // $this->assign("district_list",$district_list);
            $child_menu_list = array(
                array(
                    'url' => "Distribution/regionalAgent",
                    'menu_name' => "基本设置",
                    "active" => 0
                ),
                array(
                    'url' => "Distribution/promoterRegionAgentList",
                    'menu_name' => "人员管理",
                    "active" => 1
                )
            );
            $this->assign('child_menu_list', $child_menu_list);
            return view($this->style . "Distribution/promoterRegionAgentList");
        }
    }

    /**
     * 是否开启区域代理
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function modifyShopConfigIsRegionalAgent()
    {
        $is_open = $_POST["is_open"];
        $shop_config = new NfxShopConfig();
        $retval = $shop_config->modifyShopConfigIsRegionalAgent($this->instance_id, $is_open);
        return AjaxReturn($retval);
    }

    /**
     * 股东分红
     */
    public function shareholderDividendsConfig()
    {
        $partner = new NfxPartner();
        $partner_level_list = $partner->getPartnerLevelAll($this->instance_id);
        $this->assign("partner_level_list", $partner_level_list);
        $shop_config = new NfxShopConfig();
        $shop_config_info = $shop_config->getShopConfigDetail($this->instance_id);
        $this->assign("shop_config_info", $shop_config_info);
        $child_menu_list = array(
            array(
                'url' => "Distribution/shareholderDividendsConfig",
                'menu_name' => "基本设置",
                "active" => 1
            ),
            array(
                'url' => "Distribution/partnerList",
                'menu_name' => "人员管理",
                "active" => 0
            )
        );
        $this->assign('child_menu_list', $child_menu_list);
        return view($this->style . "Distribution/shareholderDividendsConfig");
    }

    /**
     * 是否开启股东分红
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function modifyShopConfigIsPartnerEnable()
    {
        $is_open = $_POST["is_open"];
        $shop_config = new NfxShopConfig();
        $retval = $shop_config->modifyShopConfigIsPartnerEnable($this->instance_id, $is_open);
        return AjaxReturn($retval);
    }

    /**
     * 全球分红
     */
    public function globalBonusPoolConfig()
    {
        $shop_config = new NfxShopConfig();
        $shop_config_info = $shop_config->getShopConfigDetail($this->instance_id);
        $this->assign("shop_config_info", $shop_config_info);
        $partner = new NfxPartner();
        $partner_level_list = $partner->getPartnerLevelAll($this->instance_id);
        $this->assign("partner_level_list", $partner_level_list);
        $child_menu_list = array(
            array(
                'url' => "Distribution/globalBonusPoolConfig",
                'menu_name' => "基本设置",
                "active" => 1
            ),
            array(
                'url' => "Distribution/globalBonusPoolPut",
                'menu_name' => "发放分红",
                "active" => 0
            ),
            array(
                'url' => "Distribution/commissionPartnerGlobalRecordsList",
                'menu_name' => "发放记录",
                "active" => 0
            )
        );
        $this->assign('child_menu_list', $child_menu_list);
        // $partner = new NfxPartner();
        // $partner_level_list = $partner->getPartnerLevelAll($this->instance_id);
        // $this->assign("partner_level_list",$partner_level_list);
        return view($this->style . "Distribution/globalBonusPoolConfig");
    }

    /**
     * 全球分红发放流水
     *
     * @return multitype:number unknown |Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function commissionPartnerGlobalRecordsList()
    {
        if (request()->isAjax()) {
            $partner = new NfxPartner();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $condition = array(
                'shop_id' => $this->instance_id
            );
            $list = $partner->getCommissionPartnerGlobalRecordsList($pageindex, PAGESIZE, $condition, '');
            return $list;
        } else {
            $child_menu_list = array(
                array(
                    'url' => "Distribution/globalBonusPoolConfig",
                    'menu_name' => "基本设置",
                    "active" => 0
                ),
                array(
                    'url' => "Distribution/globalBonusPoolPut",
                    'menu_name' => "发放分红",
                    "active" => 0
                ),
                array(
                    'url' => "Distribution/commissionPartnerGlobalRecordsList",
                    'menu_name' => "发放记录",
                    "active" => 1
                )
            );
            $this->assign('child_menu_list', $child_menu_list);
            return view($this->style . "Distribution/commissionPartnerGlobalRecordsList");
        }
    }

    /**
     * 分红权重设置
     */
    public function updateGlobalBonusPoolConfig()
    {
        if (request()->isAjax()) {
            $is_open = $_POST["is_open"];
            $partner_level_string = $_POST["partner_level_string"];
            $level_array = array();
            $level_array = explode(';', $partner_level_string);
            foreach ($level_array as $k => $v) {
                $level_array[$k] = explode(",", $v);
            }
            $partner = new NfxPartner();
            $retval = $partner->updatePartnerGlobal($level_array, $this->instance_id, $is_open);
            return AjaxReturn($retval);
        } else {
            $child_menu_list = array(
                array(
                    'url' => "Distribution/globalBonusPoolConfig",
                    'menu_name' => "基本设置",
                    "active" => 0
                ),
                array(
                    'url' => "Distribution/globalBonusPoolPut",
                    'menu_name' => "发放分红",
                    "active" => 0
                ),
                array(
                    'url' => "Distribution/commissionPartnerGlobalRecordsList",
                    'menu_name' => "发放记录",
                    "active" => 0
                )
            );
            $this->assign('child_menu_list', $child_menu_list);
            $partner = new NfxPartner();
            $partner_level_list = $partner->getPartnerLevelAll($this->instance_id);
            $this->assign("partner_level_list", $partner_level_list);
            return view($this->style . "Distribution/updateGlobalBonusPoolConfig");
        }
    }

    /**
     * 是否开启全球分红
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function modifyShopConfigIsGlobalEnable()
    {
        $is_open = $_POST["is_open"];
        $shop_config = new NfxShopConfig();
        $retval = $shop_config->modifyShopConfigIsGlobalEnable($this->instance_id, $is_open);
        return AjaxReturn($retval);
    }

    /**
     * ******************************************************股东 推广员分界线************************************************
     */
    /**
     * 股东列表
     */
    public function partnerList()
    {
        if (request()->isAjax()) {
            $partner = new NfxPartner();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $is_audit = isset($_POST['is_audit']) ? $_POST['is_audit'] : '';
            $condition = array(
                'shop_id' => $this->instance_id
            );
            if($is_audit != ""){
                $condition["is_audit"] = $is_audit;
            }
            if ($_POST['user_name'] != "") {
                $uid_string = "";
                $where = array(
                    "user_name" => array(
                        "like",
                        "%" . $_POST['user_name'] . "%"
                    )
                );
                $uid_string = $this->getUserUids($where);
                if ($uid_string != "") {
                    $condition["uid"] = array(
                        "in",
                        $uid_string
                    );
                }
            }
            $list = $partner->getPartnerList($pageindex, PAGESIZE, $condition, 'register_time desc');
            return $list;
        } else {
            $child_menu_list = array(
                array(
                    'url' => "Distribution/shareholderDividendsConfig",
                    'menu_name' => "基本设置",
                    "active" => 0
                ),
                array(
                    'url' => "Distribution/partnerList",
                    'menu_name' => "人员管理",
                    "active" => 1
                )
            );
            $partner = new NfxPartner();
            $partner_level_list = $partner->getPartnerLevelAll($this->instance_id);
            $this->assign("partner_level_list", $partner_level_list);
            $this->assign('child_menu_list', $child_menu_list);
            return view($this->style . "Distribution/partnerList");
        }
    }

    /**
     * 股东等级列表
     */
    public function partnerLevelList()
    {
        if (request()->isAjax()) {
            $partner = new NfxPartner();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
            $list = $partner->getPartnerLevelList($pageindex, PAGESIZE, $condition, '');
            return $list;
        } else {
            $child_menu_list = array(
                array(
                    'url' => "Distribution/shareholderDividendsConfig",
                    'menu_name' => "基本设置",
                    "active" => 0
                ),
                array(
                    'url' => "Distribution/partnerList",
                    'menu_name' => "人员管理",
                    "active" => 0
                )
            );
            $partner = new NfxPartner();
            $partner_level_list = $partner->getPartnerLevelAll($this->instance_id);
            $this->assign("partner_level_list", $partner_level_list);
            
            $shop_config = new NfxShopConfig();
            $shop_config_info = $shop_config->getShopConfigDetail($this->instance_id);
            $this->assign("shop_config_info", $shop_config_info);
            $this->assign('child_menu_list', $child_menu_list);
            return view($this->style . "Distribution/partnerLevelList");
        }
    }

    /**
     * 股东审核
     */
    public function partnerAudit()
    {
        $partner_id = $_POST["partner_id"];
        $is_audit = $_POST["is_audit"];
        $uid = $_POST['uid'];
        $partner = new NfxPartner();
        $retval = $partner->partnerAudit($partner_id, $is_audit, $this->instance_id);
        if($is_audit == 1 && $retval){
            $promote_reward_rule = new PromoteRewardRule();
            $promote_reward_rule ->RegisterPartnerSendPoint($this->instance_id, $uid);
            return AjaxReturn($retval);
        }
    }

    /**
     * 获取股东等级详情
     */
    public function getPartnerLevelDetail()
    {
        $level_id = $_POST["level_id"];
        $partner = new NfxPartner();
        $res = $partner->getPartnerLevelDetail($level_id);
        return $res;
    }

    /**
     * 修改股东等级
     */
    public function updatePartnerLevel()
    {
        if (request()->isAjax()) {
            $level_id = $_POST["level_id"];
            $level_name = $_POST["level_name"];
            $level_money = $_POST["level_money"];
            $commission_rate = $_POST["commission_rate"];
            // $global_value =$_POST["global_value"];
            // $global_weight =$_POST["global_weight"];
            $partner = new NfxPartner();
            $retval = $partner->updatePartnerLevel($level_id, $level_name, $level_money, $commission_rate, $this->instance_id);
            return AjaxReturn($retval);
        } else {
            $level_id = $_GET["level_id"];
            $partner = new NfxPartner();
            $partner_level_info = $partner->getPartnerLevelDetail($level_id);
            // var_dump($partner_level_info);
            $this->assign("level_id", $level_id);
            $this->assign("partner_level_info", $partner_level_info);
            return view($this->style . "Distribution/updatePartnerLevel");
        }
    }

    /**
     * 添加股东等级
     */
    public function addPartnerLevel()
    {
        if (request()->isAjax()) {
            $level_name = $_POST["level_name"];
            $level_money = $_POST["level_money"];
            $commission_rate = $_POST["commission_rate"];
            // $global_value =$_POST["global_value"];
            // $global_weight =$_POST["global_weight"];
            $partner = new NfxPartner();
            $retval = $partner->addPartnerLevel($level_money, $level_name, $commission_rate, $this->instance_id);
            return AjaxReturn($retval);
        } else {
            return view($this->style . "Distribution/addPartnerLevel");
        }
    }

    /**
     * 股东冻结/解冻
     */
    public function modifyPartnerLock()
    {
        $partner_id = $_POST["partner_id"];
        $is_lock = $_POST["is_lock"];
        $partner = new NfxPartner();
        $retval = $partner->modifyPartnerLock($partner_id, $is_lock);
        return AjaxReturn($retval);
    }

    /**
     * 发放分红
     */
    public function globalBonusPoolPut()
    {
        if (request()->isAjax()) {
            $start_time = ! empty($_POST['start_time']) ? $_POST['start_time'] : '';
            $end_time = ! empty($_POST['end_time']) ? $_POST['end_time'] : '';
            $global_money = ! empty($_POST['global_money']) ? $_POST['global_money'] : 0;
            $partner_global_calculate = new NfxPartnerGlobalCalculate();
            $retval = $partner_global_calculate->getPartnerGlobalCommission($this->instance_id, $start_time, $end_time, $global_money);
            return AjaxReturn($retval);
        } else {
            $child_menu_list = array(
                array(
                    'url' => "Distribution/globalBonusPoolConfig",
                    'menu_name' => "基本设置",
                    "active" => 0
                ),
                array(
                    'url' => "Distribution/globalBonusPoolPut",
                    'menu_name' => "发放分红",
                    "active" => 1
                ),
                array(
                    'url' => "Distribution/commissionPartnerGlobalRecordsList",
                    'menu_name' => "发放记录",
                    "active" => 0
                )
            );
            $this->assign("end_time", date('Y-m-d H:i:s', time()));
            $this->assign('child_menu_list', $child_menu_list);
            $partner_global_calculate = new NfxPartnerGlobalCalculate();
            $partner_global_calculate_info = $partner_global_calculate->getPartnerGlobalLastInfo($this->instance_id);
            $partner = new NfxPartner();
            $partnerLevelGlobalList = $partner->getPartnerLevelGlobalList($this->instance_id);
            
            $shop_config = new NfxShopConfig();
            $shop_config_info = $shop_config->getShopConfigDetail($this->instance_id);
            $this->assign("is_global_enable", $shop_config_info["is_global_enable"]);
            ;
            $this->assign("partner_global_calculate_info", $partner_global_calculate_info);
            $this->assign("partner_level_global_list", $partnerLevelGlobalList);
            return view($this->style . "Distribution/globalBonusPoolPut");
        }
    }

    /**
     * 查询某个店铺指定之间内可分红金额
     */
    public function getPartnerGlobalLastInfo()
    {
        $start_time = ! empty($_POST['start_time']) ? $_POST['start_time'] : '';
        $end_time = ! empty($_POST['end_time']) ? $_POST['end_time'] : '';
        $partner_global_calculate = new NfxPartnerGlobalCalculate();
        $partner_global_last_info = $partner_global_calculate->getPartnerGlobalMoney($this->instance_id, $start_time, $end_time);
        return $partner_global_last_info;
    }

    /**
     * 修改所有股东等级
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function updatePartnerLevelAll()
    {
        $partner_level_string = $_POST["partner_level_string"];
        $is_open = $_POST["is_open"];
        $level_array = array();
        $level_array = explode(';', $partner_level_string);
        foreach ($level_array as $k => $v) {
            $level_array[$k] = explode(",", $v);
        }
        $partner = new NfxPartner();
        $retval = $partner->updatePartnerLevelAll($level_array, $this->instance_id, $is_open);
        return AjaxReturn($retval);
    }

    /**
     * 删除股东等级
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    function deletePartnerLevel()
    {
        $level_id = $_POST["level_id"];
        $partner = new NfxPartner();
        $retval = $partner->deletePartnerLevel($this->instance_id, $level_id);
        return ajaxReturn($retval);
    }

    /**
     * 修改股东用户等级
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function modifyPartnerLevelNum()
    {
        $level_id = $_POST["level_id"];
        $uid = $_POST["uid"];
        $partner = new NfxPartner();
        $retval = $partner->modifyPartnerLevelNum($this->instance_id, $uid, $level_id);
        return ajaxReturn($retval);
    }

    /**
     * 查寻符合条件的数据并返回id （多个以“,”隔开）
     *
     * @param unknown $condition            
     * @return string
     */
    public function getUserUids($condition)
    {
        $member = new Member();
        $list = $member->getMemberAll($condition);
        $uid_string = "";
        foreach ($list as $k => $v) {
            $uid_string = $uid_string . "," . $v["uid"];
        }
        if ($uid_string != "") {
            $uid_string = substr($uid_string, 1);
        }
        return $uid_string;
    }

    /**
     * 查寻符合条件的数据并返回id （多个以“,”隔开）
     *
     * @param unknown $condition            
     * @return string
     */
    public function getGoodsCommissionGoodsids($condition)
    {
        $commission_config = new NfxCommissionConfig();
        $list = $commission_config->getGoodsCommiddionAll($condition);
        $goodsid_string = "";
        foreach ($list as $k => $v) {
            $goodsid_string = $goodsid_string . "," . $v["goods_id"];
        }
        if ($goodsid_string != "") {
            $goodsid_string = substr($goodsid_string, 1);
        }
        return $goodsid_string;
    }   
     /**
     * 删除推广员等级
     * @return Ambigous <number, unknown>
     */
    public function deletePromoterLevel(){
        $level_id = $_POST["level_id"];
        $promoter = new NfxPromoter();
        $retval = $promoter->deletePromoterLevel($this->instance_id, $level_id);
        return ajaxReturn($retval);
    }
    /**
     * 删除推广员
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function deletePromoter(){
        $promoter_id = $_POST["promoter_id"];
        $promoter = new NfxPromoter();
        $retval = $promoter->deletePromoter($this->instance_id, $promoter_id);
        return ajaxReturn($retval);
    }
    /**
     * 修改推广员的等级
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function modifyPromoterLevel(){
        $promoter_id = $_POST["promoter_id"];
        $level_id = $_POST["level_id"];
        $promoter = new NfxPromoter();
        $retval = $promoter->modifyPromoterLevel($this->instance_id, $promoter_id, $level_id);
        return ajaxReturn($retval);
    }
}