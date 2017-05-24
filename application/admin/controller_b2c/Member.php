<?php
/**
 * Member.php
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

use data\service\niufenxiao\NfxUser;
use data\service\niushop\Member as MemberService;
use data\service\system\Weixin;

/**
 * 会员管理
 *
 * @author Administrator
 *        
 */
class Member extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 会员列表主页
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function memberList()
    {
        if (request()->isAjax()) {
            $index = isset($_POST["pageIndex"]) ? $_POST["pageIndex"] : 1;
            $search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
            if (NS_VERSION == NS_VER_B2C || NS_VERSION == NS_VER_B2C_FX) {
                $member = new MemberService();
                $list = $member->getMemberList($index, PAGESIZE, [
                    'is_member' => 1,
                    'user_name' => array(
                        'like',
                        '%' . $search_text . '%'
                    )
                ],'reg_time desc');
            } else {
                $nfx_user = new NfxUser();
                $list = $nfx_user->getShopMemberList($this->instance_id, $index, PAGESIZE, [
                    'nsma.shop_id' => $this->instance_id,
                    'su.is_member' => 1,
                    'su.user_name' => array(
                        'like',
                        '%' . $search_text . '%'
                    )
                ],'nsma.create_time desc');
            }
            return $list;
        } else {
            return view($this->style . 'Member/memberList');
        }
    }

    /**
     * 用户锁定
     */
    public function memberLock()
    {
        $uid = isset($_POST["id"]) ? $_POST["id"] : '';
        $retval = 0;
        if (! empty($uid)) {
            $member = new MemberService();
            $retval = $member->userLock($uid);
        }
        return AjaxReturn($retval);
    }

    /**
     * 用户解锁
     */
    public function memberUnlock()
    {
        $uid = isset($_POST["id"]) ? $_POST["id"] : '';
        $retval = 0;
        if (! empty($uid)) {
            $member = new MemberService();
            $retval = $member->userUnlock($uid);
        }
        return AjaxReturn($retval);
    }

    /**
     * 粉丝列表
     *
     * @return multitype:number unknown |Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function weixinFansList()
    {
        if (request()->isAjax()) {
            $index = isset($_POST["pageIndex"]) ? $_POST["pageIndex"] : 1;
            $search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
            $condition = array(
                'nickname_decode' => array(
                    'like',
                    '%' . $search_text . '%'
                )
            );
            $weixin = new Weixin();
            $list = $weixin->getWeixinFansList($index, PAGESIZE, $condition);
            return $list;
        } else {
            return view($this->style . 'Member/weixinFansList');
        }
    }
}