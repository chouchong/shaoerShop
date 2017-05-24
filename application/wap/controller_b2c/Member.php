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
namespace app\wap\controller_b2c;

use data\service\niufenxiao\NfxPromoter;
use data\service\niufenxiao\NfxShopConfig;
use data\service\niufenxiao\NfxUser as NfxUserService;
use data\service\niushop\Member\MemberAccount as MemberAccount;
use data\service\niushop\Member as MemberService;
use data\service\niushop\Platform;
use data\service\niushop\Shop;
use data\service\system\WebSite;
use data\service\system\Weixin;
use data\service\niushop\Promote;
use think\Request;
use data\service\niushop\promotion\PromoteRewardRule;
use think;

/**
 * 会员
 *
 * @author Administrator
 *        
 */
class Member extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->uid)) {
            $this->wchatLogin();
        }
        $this->checkLogin();
    }

    /**
     * 检测用户
     */
    private function checkLogin()
    {
        $uid = $this->uid;
        if (empty($uid)) {
            $this->redirect("login/index"); // 用户未登录
        }
        $is_member = $this->user->getSessionUserIsMember();
        if (empty($is_member)) {
            $this->redirect("Login/index"); // 当前用户不是前台会员
        }
    }

    /**
     * 用户首页
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function index()
    {
        switch (NS_VERSION) {
            case NS_VER_B2C:
                $retval = $this->memberIndex(); // 单店B2C版
                break;
            case NS_VER_B2C_FX:
                $retval = $this->memberIndexFx(); // 单店B2C分销版
                break;
        }
        return $retval;
    }

    /*
     * 单店B2C版
     */
    public function memberIndex()
    {
        $member = new MemberService();
        $platform = new Platform();
        // 基本信息行级显示菜单项
        $member_menu_arr = array(
            'personal' => array(
                '个人资料',
                'member/personaldata'
            ),
            'address' => array(
                '收货地址',
                'Member/memberAddress?flag=1'
            ),
            'qr_code' => array(
                '推广二维码',
                'member/getWchatQrcode'
            ),
            "shop_code" => array(
                '店铺二维码',
                'member/getShopQrcode'
            ),
            "memberCoupon" => array(
                '优惠券',
                'member/memberCoupon'
            )
        );
        $member_info = $member->getMemberDetail($this->instance_id);
        // 头像
        if (! empty($member_info['user_info']['user_headimg'])) {
            $member_img = $member_info['user_info']['user_headimg'];
        } else {
            $member_img = '0';
        }
        $index_adv = $platform->getPlatformAdvPositionDetail(1152);
        // 平台广告位
        $menu_arr = array(
            $member_menu_arr
        );
        foreach ($menu_arr as $arr_key => $arr_item) {
            if (empty($arr_item)) {
                unset($menu_arr[$arr_key]);
                continue;
            }
            foreach ($arr_item as $key => $item) {
                $class_item = array(
                    'class' => $key,
                    'title' => $item[0],
                    'url' => $item[1]
                );
                $menu_arr[$arr_key][$key] = $class_item;
            }
        }
        
        //判断用户是否签到
        $dataMember = new MemberService();
        $isSign = $dataMember->getIsMemberSign($this->uid, $this->instance_id);
        $this->assign("isSign", $isSign);
        
        $this->assign('member_info', $member_info);
        $this->assign('index_adv', $index_adv["adv_list"][0]);
        $this->assign('member_img', $member_img);
        $this->assign('menu_arr', $menu_arr);
        
        return view($this->style . '/Member/memberIndexB2C');
    }

    /**
     * 单店B2C分销版
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function memberIndexFx()
    {
        $member = new MemberService();
        $nfx_promoter = new NfxPromoter();
        $nfx_shop_config = new NfxShopConfig();
        $platform = new Platform();
        // 基本信息行级显示菜单项
        $member_menu_arr = array(
            'personal' => array(
                '个人资料',
                'member/personaldata'
            ),
            'address' => array(
                '收货地址',
                'Member/memberAddress?flag=1'
            ),
            'withdrawals' => array(
                '提现账号',
                'member/accountList?flag=1'
            ),
            'qr_code' => array(
                '推广二维码',
                'member/getWchatQrcode'
            ),
            "shop_code" => array(
                '店铺二维码',
                'member/getShopQrcode'
            ),
            "memberCoupon" => array(
                '优惠券',
                'member/memberCoupon'
            )
        );
        
        // 推广信息
        $apply_promoter_menu = null;
        $promoter_center = ""; // 推广中心
        
        $member_info = $member->getMemberDetail($this->instance_id);
        // 头像
        if (! empty($member_info['user_info']['user_headimg'])) {
            $member_img = $member_info['user_info']['user_headimg'];
        } else {
            $member_img = '0';
        }
        
        $promoter_info = $nfx_promoter->getUserPromoter($this->uid, $this->instance_id);
        // 平台/店铺 会员中心
        $shop_config = $nfx_shop_config->getShopConfigDetail($this->instance_id);
        // 店铺详情类型
        $promoter_detail = null;
        if (empty($promoter_info)) {
            $apply_promoter_menu = array(
                'class' => 'extension',
                'title' => '申请推广员',
                'url' => 'distribution/applyPromoter'
            );
            $promoter_center = 'distribution/applyPromoter';
        } else {
            if ((empty($promoter_info['is_audit']) || $promoter_info['is_audit'] == - 1) && $shop_config['is_distribution_enable'] == 1) {
                $apply_promoter_menu = array(
                    'class' => 'extension',
                    'title' => '申请推广员',
                    'url' => 'distribution/applyPromoter'
                );
                $promoter_center = 'distribution/applyPromoter';
            } elseif ($promoter_info['is_audit'] == 1) { // 通过显示推广中心
                $promoter_detail = $nfx_promoter->getPromoterDetail($promoter_info['promoter_id']);
                $promoter_center = 'distribution/distributionCenter';
            }
        }
        
        $count = 0;
        $commission_cash = 0;
        if (! empty($promoter_detail)) {
            $count = $promoter_detail['team_count']; // 我的团队人数
            $commission_cash = $promoter_detail['commission']['commission_cash']; // 可提现佣金
        }
        $commission_cash = number_format($commission_cash, 2); // 保留两位数
        $menu_arr = array(
            $member_menu_arr
        );
        
        foreach ($menu_arr as $arr_key => $arr_item) {
            if (empty($arr_item)) {
                unset($menu_arr[$arr_key]);
                continue;
            }
            foreach ($arr_item as $key => $item) {
                $class_item = array(
                    'class' => $key,
                    'title' => $item[0],
                    'url' => $item[1]
                );
                $menu_arr[$arr_key][$key] = $class_item;
            }
        }
        
        //判断用户是否签到
        $dataMember = new MemberService();
        $isSign = $dataMember->getIsMemberSign($this->uid, $this->instance_id);
        $this->assign("isSign", $isSign);
        
        $index_adv = $platform->getPlatformAdvPositionDetail(1152); // 广告位
        $this->assign('counts', $count); // 我的团队
        $this->assign('commission_cash', $commission_cash); // 我的佣金
        $this->assign('promoter_center', $promoter_center); // 推广中心地址
        
        $this->assign('member_img', $member_img); // 会员头像
        $this->assign('member_info', $member_info); // 会员信息
        $this->assign('index_adv', $index_adv["adv_list"][0]); // 广告位
        $this->assign('promoter_info', $promoter_detail); // 推广员信息（包括我的团队人数、）
        $this->assign('menu_arr', $menu_arr); // 菜单项
        $this->assign('apply_promoter_menu', $apply_promoter_menu); // 推广中心菜单项
        
        return view($this->style . 'Member/memberIndexB2CFX');
    }

    /**
     * 会员地址管理
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function memberAddress()
    {
        $member = new MemberService();
        $addresslist = $member->getMemberExpressAddressList();
        $this->assign("list", $addresslist);
        $flag = isset($_GET['flag']) ? $_GET['flag'] : "";
        $url = isset($_GET['url']) ? $_GET['url'] : "";
        $pre_url = getUrl();
        $_SESSION['address_pre_url'] = $pre_url;
        $this->assign("pre_url", $pre_url);
        $this->assign("flag", $flag);
        $this->assign("url", $url);
        return view($this->style . "/Member/memberAddress");
    }

    /**
     * 添加地址
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function addMemberAddress()
    {
        if (request()->isAjax()) {
            $member = new MemberService();
            $consigner = $_POST['consigner'];
            $mobile = $_POST['mobile'];
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $province = $_POST['province'];
            $city = $_POST['city'];
            $district = $_POST['district'];
            $address = $_POST['address'];
            $zip_code = isset($_POST['zip_code']) ? $_POST['zip_code'] : '';
            $alias = isset($_POST['alias']) ? $_POST['alias'] : '';
            $retval = $member->addMemberExpressAddress($consigner, $mobile, $phone, $province, $city, $district, $address, $zip_code, $alias);
            return AjaxReturn($retval);
        } else {
            $address_id = isset($_GET['addressid']) ? $_GET['addressid'] : 0;
            $this->assign("address_id", $address_id);
            if (! empty($_SESSION['address_pre_url'])) {
                $pre_url = $_SESSION['address_pre_url'];
            } else {
                $pre_url = '';
            }
            $this->assign("pre_url", $pre_url);
            $flag = isset($_GET['flag']) ? $_GET['flag'] : "";
            $this->assign("flag", $flag);
            return view($this->style . "/Member/addMemberAddress");
        }
    }

    /**
     * 修改会员地址
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >|Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function updateMemberAddress()
    {
        $member = new MemberService();
        if (request()->isAjax()) {
            $id = $_POST['id'];
            $consigner = $_POST['consigner'];
            $mobile = $_POST['mobile'];
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $province = $_POST['province'];
            $city = $_POST['city'];
            $district = $_POST['district'];
            $address = $_POST['address'];
            $zip_code = isset($_POST['zip_code']) ? $_POST['zip_code'] : '';
            $alias = isset($_POST['alias']) ? $_POST['alias'] : '';
            $retval = $member->updateMemberExpressAddress($id, $consigner, $mobile, $phone, $province, $city, $district, $address, $zip_code, $alias);
            return AjaxReturn($retval);
        } else {
            $id = $_GET['id'];
            $flag = isset($_GET['flag']) ? $_GET['flag'] : "";
            $info = $member->getMemberExpressAddressDetail($id);
            $this->assign("address_info", $info);
            $this->assign("flag", $flag);
            $pre_url = $_SERVER['HTTP_REFERER'];
            $_SESSION['address_pre_url'] = $pre_url;
            $this->assign("pre_url", $pre_url);
            return view($this->style . "/Member/updateMemberAddress");
        }
    }

    /**
     * 获取用户地址详情
     *
     * @return Ambigous <\think\static, multitype:, \think\db\false, PDOStatement, string, \think\Model, \PDOStatement, \think\db\mixed, multitype:a r y s t i n g Q u e \ C l o , \think\db\Query, NULL>
     */
    public function getMemberAddressDetail()
    {
        $address_id = isset($_POST['id']) ? $_POST['id'] : 0;
        $member = new MemberService();
        $info = $member->getMemberExpressAddressDetail($address_id);
        return $info;
    }

    /**
     * 会员地址删除
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function memberAddressDelete()
    {
        $id = $_POST['id'];
        $member = new MemberService();
        $res = $member->memberAddressDelete($id);
        return AjaxReturn($res);
    }

    /**
     * 修改会员地址
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function updateAddressDefault()
    {
        $id = $_POST['id'];
        $member = new MemberService();
        $res = $member->updateAddressDefault($id);
        return AjaxReturn($res);
    }

    /**
     * 店铺积分列表和平台积分
     */
    public function integral()
    {
        $market_isset = false;
        $shop_isset = false;
        $market_list = '';
        $shop_list = '';
        // 获取店铺的积分列表
        $integral_list = $this->user->getShopAccountListByUser($this->uid, 1, 0);
        // 获取店铺的信息
        if (! empty($integral_list["data"])) {
            foreach ($integral_list["data"] as $shop_list) {
                if ($shop_list["shop_id"] == 0) {
                    // 此时为商场
                    $market_isset = true;
                    $market = new WebSite();
                    $market_list = $market->getWebSiteInfo();
                } else {
                    $shop_isset = true;
                    $shop = new Shop();
                    $shop_list['extra'] = $shop->getShopInfo($shop_list['shop_id']);
                }
            }
        }
        $this->assign([
            'market_isset' => $market_isset,
            'shop_isset' => $shop_isset,
            'integral' => $integral_list,
            'market_list' => $market_list
        ]);
        return view($this->style . '/Member/integral');
    }

    /**
     * 店铺积分流水
     */
    public function integralWater()
    {
        $shop_id = $this->instance_id;
        
        // 查看用户在该商铺下的积分消费流水
        $member_point_list = $this->user->getPageMemberPointList('', '', 1, 0, $shop_id);
        
        // 查看积分总数
        $member = new MemberService();
        $menber_info = $member ->getMemberDetail($this->instance_id);
        
        $from_type_arr = array('','商城订单','订单退换','兑换','充值','签到','分享','注册','推广下级会员注册',  '下下级会员注册', '下下下级会员注册',
            '成为推广员', '推广下级推广员', '下下级推广员', '下下下级推广员', '成为股东', '推广下级股东', '下下级股东', '下下下级股东');
        
        foreach($member_point_list['data'] as $item){
            $item['from_type_name'] = $from_type_arr[$item['from_type']];
        }
        //查找店铺积分说明
        $pointConfig = new Promote();
        $pointconfiginfo = $pointConfig->getPointConfig(); 
        
        
        $this->assign([
            "sum" => $menber_info['point'],
            "member_point_list" => $member_point_list,
            "pointconfiginfo" => $pointconfiginfo
        ]);
        return view($this->style . '/Member/integralWater');
    }

    /**
     * 会员余额
     */
    public function balance()
    {
        $market_isset = false;
        $shop_isset = false;
        $market_list = '';
        $shop_list = '';
        // 获取店铺的积分列表
        $balance_list = $this->user->getShopAccountListByUser($this->uid, 1, 0);
        // 获取店铺的信息
        foreach ($balance_list["data"] as $shop_list) {
            if ($shop_list["shop_id"] == 0) {
                // 此时为商场
                $market_isset = true;
                $market = new WebSite();
                $market_list = $market->getWebSiteInfo();
            } else {
                $shop_isset = true;
                $shop = new Shop();
                $shop_list['extra'] = $shop->getShopInfo($shop_list['shop_id']);
            }
        }
        $this->assign([
            'market_isset' => $market_isset,
            'shop_isset' => $shop_isset,
            'balance' => $balance_list,
            'market_list' => $market_list
        ]);
        return view($this->style . '/Member/balance');
    }

    /**
     * 会员余额流水
     */
    public function balanceWater()
    {
//         $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '2016-01-01';
//         $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '2099-01-01';
//         $page_index = isset($_GET['page']) ? $_GET['page'] : '1';
//         $page_count = '';
        // 该店铺下的余额流水
        $shopid = $this->instance_id;
        $list = $this->user->getPageMemberBalanceList('', '', 1, 0, $shopid);
        $from_type = array('','商城订单','订单退换','兑换','充值','签到','分享','注册','推广下级会员注册', '下下级会员注册', '下下下级会员注册',
            '成为推广员', '推广下级推广员', '下下级推广员', '下下下级推广员', '成为股东', '推广下级股东', '下下级股东', '下下下级股东');
        foreach ($list['data'] as $item){
            $item['from_type_name'] = $from_type[$item['from_type']];
        }
//         var_dump($list['data']);
//         exit;
        // 用户在该店铺的账户余额总数
        $member = new MemberService();
        $member_info = $member->getMemberDetail($this->instance_id);
        $this->assign("sum", $member_info['balance']);
        $this->assign("balances", $list);
        return view($this->style . '/Member/balanceWater');
    }

    /**
     * 会员优惠券
     */
    public function memberCoupon()
    {
        if (request()->isAjax()) {
            $member = new MemberService();
            $type = isset($_POST['type']) ? $_POST['type'] : '';
            $shop_id = $this->instance_id;
            $counpon_list = $member->getMemberCounponList($type, $shop_id);
            foreach ($counpon_list as $key => $item) {
                $counpon_list[$key]['start_time'] = date("Y-m-d", strtotime($item['start_time']));
                $counpon_list[$key]['end_time'] = date("Y-m-d", strtotime($item['end_time']));
            }
            return $counpon_list;
        } else {
            return view($this->style . "/Member/memberCoupon");
        }
    }

    /**
     * 会员个人资料主界面
     */
    public function personalData()
    {
        $shop_id = isset($_GET['shop_id']) ? $_GET['shop_id'] : 0;
        $_SESSION['bund_pre_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $uid = $this->user->getSessionUid();
        $member = new MemberService();
        $member_info = $member->getMemberDetail();
        $this->assign('member_info', $member_info);
        //查询账户信息
//         $user = new UserModel();
//         $nick_name = $user->getInfo(["uid" => $this->uid], "nick_name");
        
        if (! empty($member_info['user_info']['user_headimg'])) {
            $member_img = $member_info['user_info']['user_headimg'];
        } elseif (! empty($member_info['user_info']['qq_openid'])) {
            $member_img = $member_info['user_info']['qq_info_array']['figureurl_qq_1'];
        } elseif (! empty($member_info['user_info']['wx_openid'])) {
            $member_img = '0';
        } else {
            $member_img = '0';
        }
        $this->assign("shop_id", $shop_id);
        $this->assign('qq_openid', $member_info['user_info']['qq_openid']);
        $this->assign('member_img', $member_img);
        return view($this->style . "/Member/personalData");
    }

    /**
     * 修改密码
     */
    public function modifyPassword()
    {
        $member = new MemberService();
        $uid = $this->user->getSessionUid();
        $old_password = isset($_POST['old_password']) ? $_POST['old_password'] : '';
        $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
        $retval = $member->ModifyUserPassword($uid, $old_password, $new_password);
        return AjaxReturn($retval);
    }

    /**
     * 修改邮箱
     */
    public function modifyEmail()
    {
        $member = new MemberService();
        $uid = $this->user->getSessionUid();
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $retval = $member->modifyEmail($uid, $email);
        return AjaxReturn($retval);
    }

    /**
     * 修改手机
     */
    public function modifyMobile()
    {
        $uid = $this->user->getSessionUid();
        $mobile = isset($_POST['mobilephone']) ? $_POST['mobilephone'] : '';
        $member = new MemberService();
        $retval = $member->modifyMobile($uid, $mobile);
        return AjaxReturn($retval);
    }

    /**
     * 修改昵称
     *
     * @return unknown[]
     */
    public function modifyNickName()
    {
        $uid = $this->user->getSessionUid();
        $nickname = isset($_POST['nickname']) ? $_POST['nickname'] : '';
        $member = new MemberService();
        $retval = $member->modifyNickName($uid, $nickname);
        return AjaxReturn($retval);
    }

    /**
     * 修改qq
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function modifyQQ()
    {
        $uid = $this->user->getSessionUid();
        $qq = isset($_POST['qqno']) ? $_POST['qqno'] : '';
        $member = new MemberService();
        $retval = $member->modifyQQ($uid, $qq);
        return AjaxReturn($retval);
    }

    /**
     * 退出登录
     */
    public function logOut()
    {
        $member = new MemberService();
        $member->Logout();
        $_SESSION['user_cart'] = "";
        return AjaxReturn(1);
    }

    /**
     * 接触QQ绑定
     */
    public function removeBindQQ()
    {
        $retval = $this->user->removeBindQQ();
        $this->success('解除绑定成功', $_SESSION['bund_pre_url']);
    }

    /**
     * 积分兑换余额
     *
     * @return \think\response\View
     */
    public function integralExchangeBalance()
    {
        // 获取兑换比例
        $account = new MemberAccount();
        $accounts = $account->getConvertRate($this->shop_id);
        
        // 查看积分总数
        $conponAccount = new MemberAccount();
        $conponSum = $conponAccount->getMemberAccount($this->shop_id, $this->uid, 1);
        
        $this->assign('conponSum', $conponSum);
        $this->assign('accounts', $accounts['convert_rate']);
        return view($this->style . "/Member/integralExchangeBalance");
    }

    /**
     * 积分兑换余额
     *
     * @return \think\response\View
     */
    public function ajaxIntegralExchangeBalance()
    {
        $point = (float) $_POST["amount"];
        $shop_id = isset($_POST["shop_id"]) ? $_POST["shop_id"] : '';
        $result = $this->user->memberPointToBalance($this->uid, $shop_id, $point);
        return AjaxReturn($result);
    }

    /**
     * 账户列表
     * 任鹏强
     * 2017年3月13日10:52:59
     */
    public function accountList()
    {
        $flag = isset($_GET["flag"]) ? $_GET["flag"] : "0"; // 标识，1：从会员中心的提现账号进来，0：从申请提现进来
        $member = new NfxUserService();
        $account_list = $member->getUserBankAccount();
        $this->assign('flag', $flag);
        $this->assign('account_list', $account_list);
        return view($this->style . "/Member/accountList");
    }

    /**
     * 添加账户
     * 任鹏强
     * 2017年3月13日10:53:06
     */
    public function addAccount()
    {
        if (request()->isAjax()) {
            $member = new NfxUserService();
            $uid = $this->uid;
            $realname = isset($_POST['realname']) ? $_POST['realname'] : '';
            $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
            $bank_type = isset($_POST['bank_type']) ? $_POST['bank_type'] : '1';
            $account_number = isset($_POST['account_number']) ? $_POST['account_number'] : '';
            $branch_bank_name = isset($_POST['branch_bank_name']) ? $_POST['branch_bank_name'] : '';
            $retval = $member->addUserBankAccount($uid, $bank_type, $branch_bank_name, $realname, $account_number, $mobile);
            return AjaxReturn($retval);
        } else {
            return view($this->style . "/Member/addAccount");
        }
    }

    /**
     * 修改账户信息
     */
    public function updateAccount()
    {
        $member = new NfxUserService();
        if (request()->isAjax()) {
            $uid = $this->uid;
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $realname = isset($_POST['realname']) ? $_POST['realname'] : '';
            $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
            $bank_type = isset($_POST['bank_type']) ? $_POST['bank_type'] : '1';
            $account_number = isset($_POST['account_number']) ? $_POST['account_number'] : '';
            $branch_bank_name = isset($_POST['branch_bank_name']) ? $_POST['branch_bank_name'] : '';
            $retval = $member->updateUserBankAccount($id, $branch_bank_name, $realname, $account_number, $mobile);
            return AjaxReturn($retval);
        } else {
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $result = $member->getUserBankAccountDetail($id);
            $this->assign('result', $result);
            return view($this->style . "/Member/updateAccount");
        }
    }

    /**
     * 删除账户信息
     */
    public function delAccount()
    {
        if (request()->isAjax()) {
            $member = new NfxUserService();
            $uid = $this->uid;
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $retval = $member->delUserBankAccount($id);
            return AjaxReturn($retval);
        }
    }

    /**
     * 设置选中账户
     */
    public function checkAccount()
    {
        if (request()->isAjax()) {
            $member = new NfxUserService();
            $uid = $this->uid;
            $account_id = isset($_POST['id']) ? $_POST['id'] : '';
            $retval = $member->setUserBankAccountDefault($uid, $account_id);
            return AjaxReturn($retval);
        }
    }

    /**
     * 获取微信推广二维码
     */
    public function getWchatQrcode()
    {
        $uid = $this->user->getSessionUid();
        $instance_id = $this->instance_id;
        $this->assign("shop_id", $instance_id);
        // 分享
        $ticket = $this->getShareTicket();
//         var_dump($ticket);
        $this->assign("signPackage", $ticket);
        return view($this->style . "/Member/myqrcode");
    }

    /**
     * 生成个人店铺二维码
     */
    public function getShopQrcode()
    {
        $weisite = new WebSite();
        $weisite_info = $weisite->getWebSiteInfo();
        $info["logo"] = $weisite_info["logo"];
        $info["shop_name"] = $weisite_info["title"];
        $info["phone"] = $weisite_info["web_phone"];
        $info["address"] = $weisite_info["web_address"];
        $this->assign("info", $info);
        // 分享
        $ticket = $this->getShareTicket();
        $this->assign("signPackage", $ticket);
        return view($this->style . "/Member/shopqrcode");
    }

    /**
     * 用户更换模板
     */
    public function updateUserQrcodeTemplate()
    {
        $uid = $this->user->getSessionUid();
        $instance_id = $this->instance_id;
        $weixin = new Weixin();
        $data = $weixin->updateMemberQrcodeTemplate($instance_id, $uid);
        $this->assign("shop_id", $instance_id);
        // 分享
        $ticket = $this->getShareTicket();
        $this->assign("signPackage", $ticket);
        var_dump($ticket);
        return view($this->style . "/Member/myqrcode");
    }

    /**
     * 制作推广二维码
     */
    function showUserQrcode()
    {
        $uid = $this->user->getSessionUid();
        $instance_id = $this->instance_id;
        // 读取生成图片的位置配置
        $weixin = new Weixin();
        $data = $weixin->getWeixinQrcodeConfig($instance_id, $uid);
        $member_info = $this->user->getUserDetail();
        // 获取所在店铺信息
        $web = new WebSite();
        $shop_info = $web->getWebDetail();
        $shop_logo = $shop_info["logo"];
        
        // 查询并生成二维码
        $path = 'upload/qrcode/' . 'qrcode_' . $uid . '_' . $instance_id . '.png';
        
        if (! file_exists($path)) {
            $weixin = new Weixin();
            $url = $weixin->getUserWchatQrcode($uid, $instance_id);
            if ($url == WEIXIN_AUTH_ERROR) {
                exit();
            } else {
                getQRcode($url, 'upload/qrcode', "qrcode_" . $uid . '_' . $instance_id);
            }
        }
        // 定义中继二维码地址
        $thumb_qrcode = 'upload/qrcode/thumb_' . 'qrcode_' . $uid . '_' . $instance_id . '.png';
        $image = \think\Image::open($path);
        // 生成一个固定大小为360*360的缩略图并保存为thumb_....jpg
        $image->thumb(288, 288, \think\Image::THUMB_CENTER)->save($thumb_qrcode);
        // 背景图片
        $dst = $data["background"];
        if (! file_exists($dst)) {
            $dst = "public/static/images/qrcode_bg/qrcode_user_bg.png";
        }
        // 生成画布
        list ($max_width, $max_height) = getimagesize($dst);
        $dests = imagecreatetruecolor($max_width, $max_height);
        $dst_im = getImgCreateFrom($dst);
        imagecopy($dests, $dst_im, 0, 0, 0, 0, $max_width, $max_height);
        imagedestroy($dst_im);
        // 并入二维码
        // $src_im = imagecreatefrompng($thumb_qrcode);
        $src_im = getImgCreateFrom($thumb_qrcode);
        $src_info = getimagesize($thumb_qrcode);
        imagecopy($dests, $src_im, $data["code_left"] * 2, $data["code_top"] * 2, 0, 0, $src_info[0], $src_info[1]);
        imagedestroy($src_im);
        // 并入用户头像
        $user_headimg = $member_info["user_headimg"];
        // $user_headimg = "upload/user/1493363991571.png";
        if (! file_exists($user_headimg)) {
            $user_headimg = "public/static/images/qrcode_bg/head_img.png";
        }
        $src_im_1 = getImgCreateFrom($user_headimg);
        $src_info_1 = getimagesize($user_headimg);
        // imagecopy($dests, $src_im_1, $data['header_left'] * 2, $data['header_top'] * 2, 0, 0, $src_info_1[0], $src_info_1[1]);
        imagecopyresampled($dests, $src_im_1, $data['header_left'] * 2, $data['header_top'] * 2, 0, 0, 80, 80, $src_info_1[0], $src_info_1[1]);
        // imagecopy($dests, $src_im_1, $data['header_left'] * 2, $data['header_top'] * 2, 0, 0, $src_info_1[0], $src_info_1[1]);
        imagedestroy($src_im_1);
        
        // 并入网站logo
        if ($data['is_logo_show'] == '1') {
            // $shop_logo = $shop_logo;
            if (! file_exists($shop_logo)) {
                $shop_logo = "public/static/images/logo.png";
            }
            $src_im_2 = getImgCreateFrom($shop_logo);
            $src_info_2 = getimagesize($shop_logo);
            imagecopy($dests, $src_im_2, $data['logo_left'] * 2, $data['logo_top'] * 2, 0, 0, $src_info_2[0], $src_info_2[1]);
            imagedestroy($src_im_2);
        }
        // 并入用户姓名
        $rgb = hColor2RGB($data['nick_font_color']);
        $bg = imagecolorallocate($dests, $rgb['r'], $rgb['g'], $rgb['b']);
        $name_top_size = $data['name_top'] * 2 + $data['nick_font_size'];
        @imagefttext($dests, $data['nick_font_size'], 0, $data['name_left'] * 2, $name_top_size, $bg, "public/static/font/Microsoft.ttf", $member_info["nick_name"]);
        header("Content-type: image/jpeg");
        imagejpeg($dests);
    }

    /**
     * 制作店铺二维码
     */
    function showShopQecode()
    {
        $uid = $this->user->getSessionUid();
        $instance_id = $this->instance_id;
        if ($instance_id == 0) {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . '/wap?source_uid=' . $uid;
        } else {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . '/wap/shop/index?shop_id=' . $instance_id . '&source_uid=' . $uid;
        }
        // 查询并生成二维码
        $path = 'upload/qrcode/' . 'shop_' . $uid . '_' . $instance_id . '.png';
        if (! file_exists($path)) {
            getQRcode($url, 'upload/qrcode', "shop_" . $uid . '_' . $instance_id);
        }
        
        // 定义中继二维码地址
        $thumb_qrcode = 'upload/qrcode/thumb_shop_' . 'qrcode_' . $uid . '_' . $instance_id . '.png';
        $image = \think\Image::open($path);
        // 生成一个固定大小为360*360的缩略图并保存为thumb_....jpg
        $image->thumb(260, 260, \think\Image::THUMB_CENTER)->save($thumb_qrcode);
        // 背景图片
        $dst = "public/static/images/qrcode_bg/shop_qrcode_bg.png";
        
        // $dst = "http://pic107.nipic.com/file/20160819/22733065_150621981000_2.jpg";
        // 生成画布
        list ($max_width, $max_height) = getimagesize($dst);
        $dests = imagecreatetruecolor($max_width, $max_height);
        $dst_im = getImgCreateFrom($dst);
        // if (substr($dst, - 3) == 'png') {
        // $dst_im = imagecreatefrompng($dst);
        // } elseif (substr($dst, - 3) == 'jpg') {
        // $dst_im = imagecreatefromjpeg($dst);
        // }
        imagecopy($dests, $dst_im, 0, 0, 0, 0, $max_width, $max_height);
        imagedestroy($dst_im);
        // 并入二维码
        // $src_im = imagecreatefrompng($thumb_qrcode);
        $src_im = getImgCreateFrom($thumb_qrcode);
        $src_info = getimagesize($thumb_qrcode);
        imagecopy($dests, $src_im, "94px" * 2, "170px" * 2, 0, 0, $src_info[0], $src_info[1]);
        imagedestroy($src_im);
        // 获取所在店铺信息
        
        $web = new WebSite();
        $shop_info = $web->getWebDetail();
        $shop_logo = $shop_info["logo"];
        $shop_name = $shop_info["title"];
        $shop_phone = $shop_info["web_phone"];
        $live_store_address = $shop_info["web_address"];
        
        // logo
        if (! file_exists($shop_logo)) {
            $shop_logo = "public/static/images/logo.png";
        }
        // if (substr($shop_logo, - 3) == 'png') {
        // $src_im_2 = imagecreatefrompng($shop_logo);
        // } elseif (substr($shop_logo, - 3) == 'jpg') {
        // $src_im_2 = imagecreatefromjpeg($shop_logo);
        // }
        $src_im_2 = getImgCreateFrom($shop_logo);
        $src_info_2 = getimagesize($shop_logo);
        imagecopy($dests, $src_im_2, "10px" * 2, "380px" * 2, 0, 0, $src_info_2[0], $src_info_2[1]);
        imagedestroy($src_im_2);
        // 并入用户姓名
        $rgb = hColor2RGB("#333333");
        $bg = imagecolorallocate($dests, $rgb['r'], $rgb['g'], $rgb['b']);
        $name_top_size = "430px" * 2 + "23";
        @imagefttext($dests, 23, 0, "10px" * 2, $name_top_size, $bg, "public/static/font/Microsoft.ttf", "店铺名称：" . $shop_name);
        @imagefttext($dests, 23, 0, "10px" * 2, $name_top_size + 50, $bg, "public/static/font/Microsoft.ttf", "电话号码：" . $shop_phone);
        @imagefttext($dests, 23, 0, "10px" * 2, $name_top_size + 100, $bg, "public/static/font/Microsoft.ttf", "店铺地址：" . $live_store_address);
        header("Content-type: image/jpeg");
        imagejpeg($dests);
    }
    //用户签到
    public function signIn()
    {
        if (request()->isAjax()) {
            $rewardRule = new PromoteRewardRule();
            $res = $rewardRule->memberSign($this->uid, $this->instance_id);
            return AjaxReturn($res);
        }
    }
    //分享送积分
    public function shareGivePoint(){
        if (request()->isAjax()) {
            $rewardRule = new PromoteRewardRule();
            $res = $rewardRule->memberShareSendPoint($this->instance_id, $this->uid);
            return AjaxReturn($res);
        }
    }
    
    
}