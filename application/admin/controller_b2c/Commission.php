<?php
/**
 * Commission.php
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

use data\service\niufenxiao\NfxPartner;
use data\service\niufenxiao\NfxPromoter;
use data\service\niufenxiao\NfxRegionAgent;
use data\service\niufenxiao\NfxUser;
use data\service\niushop\Member;
use data\service\niushop\Shop;

/**
 * 佣金控制器
 */
class Commission extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 三级分销佣金列表
     * 
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function commissionDistributionList()
    {
        if (request()->isAjax()) {
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : 1;
            $start_date = ! empty($_POST['start_date']) ? $_POST['start_date'] : '2010-1-1';
            $end_date = ! empty($_POST['end_date']) ? $_POST['end_date'] : '2099-1-1';
            $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
            $order_no = isset($_POST['order_no']) ? $_POST['order_no'] : '';
            $order_status = isset($_POST['order_status']) ? $_POST['order_status'] : '';
            $condition["create_time"] = [
                [
                    ">",
                    $start_date
                ],
                [
                    "<",
                    $end_date
                ]
            ];
            if (! empty($order_status)) {
                $condition['order_status'] = $order_status;
            }
            if (! empty($user_name)) {
                $condition['user_name'] = $user_name;
            }
            if (! empty($order_no)) {
                $condition['out_trade_no'] = $order_no;
            }
            $condition['shop_id'] = $this->instance_id;
            $promoter = new NfxPromoter();
            // var_dump($commission_calculate);
            $order_list = $promoter->getCommissionDistributionList($pageindex, PAGESIZE, $condition, 'create_time desc');
            return $order_list;
        } else {
            return view($this->style . "Commission/commissionDistributionList");
        }
    }

    /**
     * 股东分红佣金列表
     * 
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function commissionPartnerList()
    {
        if (request()->isAjax()) {
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : 1;
            $start_date = ! empty($_POST['start_date']) ? $_POST['start_date'] : '2010-1-1';
            $end_date = ! empty($_POST['end_date']) ? $_POST['end_date'] : '2099-1-1';
            $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
            $order_no = isset($_POST['order_no']) ? $_POST['order_no'] : '';
            $order_status = isset($_POST['order_status']) ? $_POST['order_status'] : '';
            $condition["create_time"] = [
                [
                    ">",
                    $start_date
                ],
                [
                    "<",
                    $end_date
                ]
            ];
            if (! empty($order_status)) {
                $condition['order_status'] = $order_status;
            }
            if (! empty($user_name)) {
                $condition['user_name'] = $user_name;
            }
            if (! empty($order_no)) {
                $condition['out_trade_no'] = $order_no;
            }
            $condition['shop_id'] = $this->instance_id;
            $partner = new NfxPartner();
            $order_list = $partner->getCommissionPartnerList($pageindex, PAGESIZE, $condition, 'create_time desc');
            return $order_list;
        } else {
            return view($this->style . "Commission/commissionPartnerList");
        }
    }

    /**
     * 区域代理佣金
     * 
     * @return multitype:number unknown |Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function commissionRegionAgentList()
    {
        if (request()->isAjax()) {
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : 1;
            $start_date = ! empty($_POST['start_date']) ? $_POST['start_date'] : '2010-1-1';
            $end_date = ! empty($_POST['end_date']) ? $_POST['end_date'] : '2099-1-1';
            $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
            $order_no = isset($_POST['order_no']) ? $_POST['order_no'] : '';
            $order_status = isset($_POST['order_status']) ? $_POST['order_status'] : '';
            $condition["create_time"] = [
                [
                    ">",
                    $start_date
                ],
                [
                    "<",
                    $end_date
                ]
            ];
            if (! empty($order_status)) {
                $condition['order_status'] = $order_status;
            }
            if (! empty($user_name)) {
                $condition['user_name'] = $user_name;
            }
            if (! empty($order_no)) {
                $condition['out_trade_no'] = $order_no;
            }
            $condition['shop_id'] = $this->instance_id;
            $region_agent = new NfxRegionAgent();
            $order_list = $region_agent->getCommissionRegionAgentList($pageindex, PAGESIZE, $condition, 'create_time desc');
            return $order_list;
        } else {
            return view($this->style . "Commission/commissionRegionAgentList");
        }
    }

    /**
     * 全球分红发放列表
     */
    public function commissionPartnerGlobalList()
    {
        if (request()->isAjax()) {
            $partner = new NfxPartner();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $records_id = $_POST["records_id"];
            if ($records_id != 0) {
                $condition["records_id"] = $records_id;
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
            $condition["shop_id"] = $this->instance_id;
            $list = $partner->getCommissionPartnerGlobalList($pageindex, PAGESIZE, $condition, '');
            return $list;
        } else {
            $records_id = isset($_GET["records_id"]) ? $_GET["records_id"] : 0;
            $this->assign("records_id", $records_id);
            return view($this->style . "Commission/commissionPartnerGlobalList");
        }
    }

    /**
     * 推广员佣金列表
     * 
     * @return Ambigous <multitype:number unknown , unknown>|Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function userAccountList()
    {
        if (request()->isAjax()) {
            $user = new NfxUser();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $condition["shop_id"] = $this->instance_id;
            $uid_string = "";
            $search_string = "";
            $where = array();
            if ($_POST["role"] == 1) {
                $search_string = $this->getPromoterUids(array(
                    "shop_id" => $this->instance_id,
                    "is_audit" => 1
                ));
                if ($search_string != "") {
                    $where["uid"] = [
                        "in",
                        $search_string
                    ];
                }
            } else 
                if ($_POST["role"] == 2) {
                    $search_string = $this->getPartnerUids(array(
                        "shop_id" => $this->instance_id,
                        "is_audit" => 1
                    ));
                    if ($search_string != "") {
                        $where["uid"] = [
                            "in",
                            $search_string
                        ];
                    }
                } else 
                    if ($_POST["role"] == 3) {
                        $search_string = $this->getPromoterRegionAgentUids(array(
                            "shop_id" => $this->instance_id,
                            "is_audit" => 1
                        ));
                        if ($search_string != "") {
                            $where["uid"] = [
                                "in",
                                $search_string
                            ];
                        }
                    }
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
            $list = $user->getShopUserAccountList($pageindex, PAGESIZE, $condition, '');
            return $list;
        } else {
            return view($this->style . "Commission/userAccountList");
        }
    }

    /**
     * 会员提现列表
     */
    public function userCommissionWithdrawList()
    {
        if (request()->isAjax()) {
            $user = new NfxUser();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $user_phone = isset($_POST['user_phone']) ? $_POST['user_phone'] : '';
            if ($user_phone != "") {
                $condition["mobile"] = $_POST['user_phone'];
            }
            $uid_string = "";
            $where = array();
            if ($_POST['user_name'] != "") {
                $where["user_name"] = array(
                    "like",
                    "%" . $_POST['user_name'] . "%"
                );
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
            $condition["shop_id"] = $this->instance_id;
            $list = $user->getUserCommissionWithdraw($pageindex, PAGESIZE, $condition, 'ask_for_date desc');
            return $list;
        } else {
            return view($this->style . "Commission/userCommissionWithdrawList");
        }
    }

    /**
     * 用户提现审核
     * 
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function userCommissionWithdrawAudit()
    {
        $id = $_POST["id"];
        $status = $_POST["status"];
        $user = new NfxUser();
        $retval = $user->UserCommissionWithdrawAudit($this->instance_id, $id, $status);
        return AjaxReturn($retval);
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
     * 查询 股东 返回id 已,隔开
     * 
     * @param unknown $condition            
     * @return string
     */
    public function getPartnerUids($condition)
    {
        $partner = new NfxPartner();
        $list = $partner->getPartnerAll($condition);
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
     * 查询 推广员 返回id 已,隔开
     * 
     * @param unknown $condition            
     * @return string
     */
    public function getPromoterUids($condition)
    {
        $promoter = new NfxPromoter();
        $list = $promoter->getPromoterAll($condition);
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
     * 查询 代理 返回id 已,隔开
     * 
     * @param unknown $condition            
     * @return string
     */
    public function getPromoterRegionAgentUids($condition)
    {
        $region_agent = new NfxRegionAgent();
        $list = $region_agent->getPromoterRegionAgentAll($condition);
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
     * 会员提现设置
     *
     * @return multitype:number unknown |Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function memberWithdrawSetting()
    {
        $shop = new Shop();
        if (request()->isAjax()) {
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            if($id == ''){
                $withdraw_cash_min = isset($_POST['cash_min']) ? $_POST['cash_min'] : '';
                $withdraw_multiple = isset($_POST['multiple']) ? $_POST['multiple'] : '';
                $withdraw_poundage = isset($_POST['poundage']) ? $_POST['poundage'] : '';
                $withdraw_message = isset($_POST['message']) ? $_POST['message'] : '';
                $list = $shop->addMemberWithdrawSetting($this->instance_id, $withdraw_cash_min, $withdraw_multiple, $withdraw_poundage, $withdraw_message, "银联卡");
                return $list;
            }else {
                $withdraw_cash_min = isset($_POST['cash_min']) ? $_POST['cash_min'] : '';
                $withdraw_multiple = isset($_POST['multiple']) ? $_POST['multiple'] : '';
                $withdraw_poundage = isset($_POST['poundage']) ? $_POST['poundage'] : '';
                $withdraw_message = isset($_POST['message']) ? $_POST['message'] : '';
                $list = $shop->updateMemberWithdrawSetting($this->instance_id, $withdraw_cash_min, $withdraw_multiple, $withdraw_poundage, $withdraw_message, "银联卡",$id);
                return $list;
            }
        }else {
            $list = $shop->getWithdrawInfo($this->instance_id);
            if(empty($list)){
                $list['id'] = '';
                $list['withdraw_cash_min'] = '';
                $list['withdraw_multiple'] = '';
                $list['withdraw_poundage'] = '';
                $list['withdraw_message'] = '';
            }
            $this->assign("list", $list);
            return view($this->style . "Commission/memberWithdrawSetting");
        }
           
    }
    
    
}