<?php
/**
 * Member.php
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
namespace data\service\niushop;

/**
 * 前台会员服务层
 */
use data\service\system\User as User;
use data\api\niushop\IMember as IMember;
use data\model\niushop\NsMemberModel as NsMemberModel;
use data\model\system\UserModel as UserModel;
use data\model\niushop\NsMemberExpressAddressModel;
use data\service\system\Address;
use data\model\niushop\NsMemberAccountRecordsModel;
use data\service\niushop\Member\MemberCoupon;
use data\model\niushop\NsMemberFavoritesModel;
use data\model\niushop\NsGoodsModel;
use data\model\system\AlbumPictureModel;
use data\model\niushop\NsShopModel;
use data\model\niushop\NsOrderModel;
use data\service\niushop\Goods;
use think\Cookie;
use think\Session;
use data\model\niushop\NsShopApplyModel;
use data\model\niushop\NsMemberAccountModel;
use data\service\niushop\Member\MemberAccount;
use data\model\niushop\NsMemberBankAccountModel;
use data;
use Prophecy\Exception\Exception;
use data\service\niufenxiao\NfxUser;
use data\model\niushop\NsPointConfigModel;
use think\Model;
use data\service\niushop\promotion\PromoteRewardRule;
use data\service\system\WebSite;

class Member extends User implements IMember
{

    function __construct()
    {
        parent::__construct();
    }

    /*
     * 前台添加会员(non-PHPdoc)
     * @see \data\api\IMember::registerMember()
     */
    public function registerMember($user_name, $password, $email, $mobile, $user_qq_id, $qq_info, $wx_openid, $wx_info, $wx_unionid)
    {
        if (! empty($user_name)) {
            if (! preg_match("/^(?!\d+$)[\da-zA-Z]*$/i", $user_name)) {
                return USER_WORDS_ERROR;
            }
        }
        $res = parent::add($user_name, $password, $email, $mobile, 0, $user_qq_id, $qq_info, $wx_openid, $wx_info, $wx_unionid, 1);
        if ($res > 0) {
            $member = new NsMemberModel();
            $data = array(
                'uid' => $res,
                'member_name' => $user_name,
                'reg_time' => date("Y-m-d H:i:s", time())
            );
            $retval = $member->save($data);
            // 注册会员送积分
            $promote_reward_rule = new PromoteRewardRule();
            // 添加关注
            switch (NS_VERSION) {
                case NS_VER_B2C:
                    break;
                case NS_VER_B2C_FX:
                    if (! empty($_SESSION['source_uid'])) {
                        // 判断当前版本
                        $nfx_user = new NfxUser();
                        $nfx_user->userAssociateShop($res, 0, $_SESSION['source_uid']);
                    } else {
                        // 判断当前版本
                        $nfx_user = new NfxUser();
                        $nfx_user->userAssociateShop($res, 0, 0);
                    }
                    break;
                case NS_VER_B2B2C_FX1:
                    if (! empty($_SESSION['source_uid']) && ! empty($_SESSION['source_shop_id'])) {
                        // 判断当前版本
                        $nfx_user = new NfxUser();
                        $nfx_user->userAssociateShop($res, $_SESSION['source_shop_id'], $_SESSION['source_uid']);
                        $promote_reward_rule->RegisterMemberSendPoint($_SESSION['source_shop_id'], $res);
                    }
                    break;
                case NS_VER_B2B2C_FX2:
                    if (! empty($_SESSION['source_uid'])) {
                        // 判断当前版本
                        $nfx_user = new NfxUser();
                        $nfx_user->userAssociateShop($res, 0, $_SESSION['source_uid']);
                    }
                    break;
            }
            // 平台赠送积分
            $promote_reward_rule->RegisterMemberSendPoint(0, $res);
            // 直接登录
            if (! empty($user_name)) {
                $this->login($user_name, $password);
            } elseif (! empty($mobile)) {
                $this->login($mobile, $password);
            } elseif (! empty($user_qq_id)) {
                $this->qqLogin($user_qq_id);
            } elseif (! empty($wx_openid)) {
                $this->wchatLogin($wx_openid);
            } elseif (! empty($wx_unionid)) {
                $this->wchatUnionLogin($wx_unionid);
            }
        }
        return $res;
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\IMember::deleteMember()
     */
    public function deleteMember($uid)
    {
        // TODO Auto-generated method stub
    }

    /**
     * 会员列表
     *
     * @param number $page_index            
     * @param number $page_size            
     * @param string $condition            
     * @param string $order            
     * @param string $field            
     */
    public function getMemberList($page_index = 1, $page_size = 0, $condition = '', $order = '', $field = '*')
    {
        $user = new UserModel();
        $result = $user->pageQuery($page_index, $page_size, $condition, $order, $field);
        foreach ($result['data'] as $k => $v) {
            $member_account = new MemberAccount();
            $result['data'][$k]['point'] = $member_account->getMemberPoint($v['uid'], '');
            $result['data'][$k]['balance'] = $member_account->getMemberBalance($v['uid']);
            $result['data'][$k]['coin'] = $member_account->getMemberCoin($v['uid']);
        }
        return $result;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getDefaultExpressAddress()
     */
    public function getDefaultExpressAddress()
    {
        $express_address = new NsMemberExpressAddressModel();
        $data = $express_address->getInfo([
            'uid' => $this->uid,
            'is_default' => 1
        ], '*');
        // 处理地址信息
        if (! empty($data)) {
            $address = new Address();
            $address_info = $address->getAddress($data['province'], $data['city'], $data['district']);
            $data['address_info'] = $address_info;
        }
        
        return $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberInfo()
     */
    public function getMemberInfo()
    {
        
        // 获取当前会员积分数
        $member = new NsMemberModel();
        if (! empty($this->uid)) {
            $data = $member->getInfo([
                'uid' => $this->uid
            ], '*');
        } else {
            $data = '';
        }
        return $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberDetail()
     */
    public function getMemberDetail($shop_id = '')
    {
        // 获取基础信息
        if (! empty($this->uid)) {
            $member_info = $this->getMemberInfo();
            // 获取user信息
            
            $user_info = $this->getUserDetail();
            $member_info['user_info'] = $user_info;
            
            // 获取优惠券信息
            $member_coupon = new MemberCoupon();
            $coupon_list = $member_coupon->getUserCouponList('', $shop_id);
            $member_info['coupon_list'] = $coupon_list;
            $member_info['coupon_count'] = count($coupon_list);
            $member_account = new MemberAccount();
            $member_account = new MemberAccount();
            $member_info['point'] = $member_account->getMemberPoint($this->uid, $shop_id);
            $member_info['balance'] = $member_account->getMemberBalance($this->uid);
            $member_info['coin'] = $member_account->getMemberCoin($this->uid);
        } else {
            $member_info = '';
        }
        
        return $member_info;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberImage()
     */
    public function getMemberImage($uid)
    {
        $user_model = new UserModel();
        $user_info = $user_model->getInfo([
            'uid' => $uid
        ], '*');
        if (! empty($user_info['user_headimg'])) {
            $member_img = $user_info['user_headimg'];
        } elseif (! empty($user_info['qq_openid'])) {
            $qq_info_array = json_decode($user_info['qq_info'], true);
            $member_img = $qq_info_array['figureurl_qq_1'];
        } elseif (! empty($user_info['wx_openid'])) {
            $member_img = '0';
        } else {
            $member_img = '0';
        }
        return $member_img;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::updateMemberInformation()
     */
    public function updateMemberInformation($user_name, $user_tel, $user_qq, $user_email, $real_name, $sex, $birthday, $location, $user_headimg)
    {
        $useruser = new UserModel();
        $data = array(
            // 2017/2/22修改为nick_name 昵称
            "nick_name" => $user_name,
            "user_tel" => $user_tel,
            "user_qq" => $user_qq,
            "user_email" => $user_email,
            "real_name" => $real_name,
            "sex" => $sex,
            "birthday" => $birthday,
            "location" => $location
        );
        $data2 = array(
            "user_headimg" => $user_headimg
        );
        if ($user_headimg == "") {
            $result = $useruser->save($data, [
                'uid' => $this->uid
            ]);
        } else {
            $result = $useruser->save($data2, [
                'uid' => $this->uid
            ]);
        }
        return $result;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::addMemberExpressAddress()
     */
    public function addMemberExpressAddress($consigner, $mobile, $phone, $province, $city, $district, $address, $zip_code, $alias)
    {
        $express_address = new NsMemberExpressAddressModel();
        $express_address->save([
            'is_default' => 0
        ], [
            'uid' => $this->uid
        ]);
        $express_address = new NsMemberExpressAddressModel();
        $data = array(
            'uid' => $this->uid,
            'consigner' => $consigner,
            'mobile' => $mobile,
            'phone' => $phone,
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'address' => $address,
            'zip_code' => $zip_code,
            'alias' => $alias,
            'is_default' => 0
        );
        $express_address->save($data);
        $this->updateAddressDefault($express_address->id);
        return $express_address->id;
    }

    /**
     * 修改会员收货地址
     */
    public function updateMemberExpressAddress($id, $consigner, $mobile, $phone, $province, $city, $district, $address, $zip_code, $alias)
    {
        $express_address = new NsMemberExpressAddressModel();
        $data = array(
            'uid' => $this->uid,
            'consigner' => $consigner,
            'mobile' => $mobile,
            'phone' => $phone,
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'address' => $address,
            'zip_code' => $zip_code,
            'alias' => $alias
        );
        $retval = $express_address->save($data, [
            'id' => $id
        ]);
        
        $retval = $this->updateAddressDefault($id);
        
        return $retval;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberExpressAddressList()
     */
    public function getMemberExpressAddressList($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        $express_address = new NsMemberExpressAddressModel();
        $data = $express_address->pageQuery($page_index, $page_size, [
            'uid' => $this->uid
        ], 'id desc', '*');
        // 处理地址信息
        if (! empty($data)) {
            foreach ($data['data'] as $key => $val) {
                $address = new Address();
                $address_info = $address->getAddress($val['province'], $val['city'], $val['district']);
                $data[$key]['address_info'] = $address_info;
            }
        }
        return $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberExpressAddressDetail()
     */
    public function getMemberExpressAddressDetail($id)
    {
        $express_address = new NsMemberExpressAddressModel();
        $data = $express_address->get($id);
        return $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::memberAddressDelete()
     */
    public function memberAddressDelete($id)
    {
        $express_address = new NsMemberExpressAddressModel();
        $count = $express_address->where(array(
            "uid" => $this->uid
        ))->count();
        if ($count == 1) {
            return USER_ADDRESS_DELETE_ERROR;
        } else {
            $express_address_info = $express_address->getInfo([
                'id' => $id
            ]);
            
            $res = $express_address->destroy($id);
            
            if ($express_address_info['is_default'] == 1) {
                $express_address_info = $express_address->where(array(
                    "uid" => $this->uid
                ))
                    ->order("id desc")
                    ->limit(0, 1)
                    ->select();
                $res = $this->updateAddressDefault($express_address_info[0]['id']);
            }
            
            return $res;
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::updateAddressDefault()
     */
    public function updateAddressDefault($id)
    {
        $express_address = new NsMemberExpressAddressModel();
        $res = $express_address->save([
            'is_default' => 0
        ], [
            'uid' => $this->uid
        ]);
        $res = $express_address->save([
            'is_default' => 1
        ], [
            'id' => $id
        ]);
        return $res;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberPointList()
     */
    function getShopAccountListByUser($uid, $page_index, $page_size)
    {
        $userMessage = new NsMemberAccountModel();
        $data = array(
            'uid' => $uid
        );
        $result = $userMessage->pageQuery($page_index, $page_size, $data, 'id asc', 'shop_id,point,balance');
        return $result;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberPointList()
     */
    public function getMemberPointList($start_time, $end_time)
    {
        $member_account = new NsMemberAccountRecordsModel();
        $condition = array(
            'uid' => $this->uid,
            'account_type' => 1,
            'create_time' => array(
                'EGT',
                $start_time
            ),
            'create_time' => array(
                'ELT',
                $end_time
            )
        );
        $list = $member_account->getQuery($condition, 'sign,number,from_type,data_id,text,create_time', 'create_time desc');
        return $list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getPageMemberPointList()
     */
    public function getPageMemberPointList($start_time, $end_time, $page_index, $page_size, $shop_id)
    {
        $member_account = new NsMemberAccountRecordsModel();
        $condition = array(
            'uid' => $this->uid,
            'account_type' => 1,
            'shop_id' => $shop_id
        /*     'create_time' =>array('EGT', $start_time),
            'create_time' =>array('ELT', $end_time) */
        
        );
        $list = $member_account->pageQuery($page_index, $page_size, $condition, 'create_time desc', 'sign,number,from_type,data_id,text,create_time');
        return $list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberBalanceList()
     */
    public function getMemberBalanceList($start_time, $end_time)
    {
        $member_account = new NsMemberAccountRecordsModel();
        $condition = array(
            'uid' => $this->uid,
            'account_type' => 2,
            'create_time' => array(
                'EGT',
                $start_time
            ),
            'create_time' => array(
                'ELT',
                $end_time
            )
        );
        $list = $member_account->getQuery($condition, 'sign,number,from_type,data_id,text,create_time', 'create_time desc');
        return $list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::etPageMemberBalanceList()
     */
    public function getPageMemberBalanceList($start_time, $end_time, $page_index, $page_size, $shop_id)
    {
        $member_account = new NsMemberAccountRecordsModel();
        $condition = array(
            'uid' => $this->uid,
            'account_type' => 2,
            // 'create_time' => array(
            // 'EGT',
            // $start_time
            // ),
            // 'create_time' => array(
            // 'ELT',
            // $end_time
            // ),
            'shop_id' => $shop_id
        );
        $list = $member_account->pageQuery($page_index, $page_size, $condition, 'create_time desc', 'sign,number,from_type,data_id,text,create_time');
        if (! empty($list['data'])) {}
        return $list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberBalanceList()
     */
    public function getMemberCoinList($start_time, $end_time)
    {
        $member_account = new NsMemberAccountRecordsModel();
        $condition = array(
            'uid' => $this->uid,
            'account_type' => 3,
            'create_time' => array(
                'EGT',
                $start_time
            ),
            'create_time' => array(
                'ELT',
                $end_time
            )
        );
        $list = $member_account->getQuery($condition, 'sign,number,from_type,data_id,text,create_time', 'create_time desc');
        return $list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::etPageMemberBalanceList()
     */
    public function getPageMemberCoinList($start_time, $end_time, $page_index, $page_size, $shop_id)
    {
        $member_account = new NsMemberAccountRecordsModel();
        $condition = array(
            'uid' => $this->uid,
            'account_type' => 3,
            'create_time' => array(
                'EGT',
                $start_time
            ),
            'create_time' => array(
                'ELT',
                $end_time
            ),
            'shop_id' => $shop_id
        );
        $list = $member_account->pageQuery($page_index, $page_size, $condition, 'create_time desc', 'sign,number,from_type,data_id,text,create_time');
        if (! empty($list['data'])) {}
        return $list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getOrderNumber()
     */
    public function getOrderNumber($order_id)
    {
        $member_account = new NsOrderModel();
        $condition = array(
            "order_id" => array(
                "EQ",
                $order_id
            )
        );
        $data = $member_account->getInfo($condition, "out_trade_no");
        return $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberCounponList()
     */
    public function getMemberCounponList($type, $shop_id = '')
    {
        $mebercoupon = new MemberCoupon();
        $list = $mebercoupon->getUserCouponList($type, $shop_id);
        return $list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getShopNameByShopId()
     */
    public function getShopNameByShopId($shop_id)
    {
        $member_account = new NsShopModel();
        $condition = array(
            "shop_id" => array(
                "EQ",
                $shop_id
            )
        );
        return $member_account->getInfo($condition, "shop_name")['shop_name'];
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberFavorites()
     */
    public function getMemberGoodsFavoritesList($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        $fav = new NsMemberFavoritesModel();
        $list = $fav->getGoodsFavouitesViewList($page_index, $page_size, $condition, $order);
        return $list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberFavorites()
     */
    public function getMemberShopsFavoritesList($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        $fav = new NsMemberFavoritesModel();
        $list = $fav->getShopsFavouitesViewList($page_index, $page_size, $condition, $order);
        return $list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberFavorites()
     */
    public function getMemberShopFavoritesList($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        $fav = new NsMemberFavoritesModel();
        $list = $fav->getFavouitesViewList($page_index, $page_size, $condition, $order);
        return $list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::addMemberFavouites()
     */
    public function addMemberFavouites($fav_id, $fav_type, $log_msg)
    {
        $member_favorites = new NsMemberFavoritesModel();
        $count = $member_favorites->where(array(
            "fav_id" => $fav_id,
            "uid" => $this->uid,
            "fav_type" => $fav_type
        ))->count("log_id");
        // 检查数据表中，防止用户重复收藏
        if ($count > 0) {
            return 0;
        }
        if ($fav_type == 'goods') {
            // 收藏商品
            $goods = new NsGoodsModel();
            $goods_info = $goods->getInfo([
                'goods_id' => $fav_id
            ], 'goods_name,shop_id,price,picture,collects');
            // 查询商品图片信息
            $album = new AlbumPictureModel();
            $picture = $album->getInfo([
                'pic_id' => $goods_info['picture']
            ], 'pic_cover_small');
            $shop_name = "";
            $shop_logo = "";
            $shop_id = 0;
            switch (NS_VERSION) {
                case NS_VER_B2C:
                case NS_VER_B2C_FX:
                    $web_site = new WebSite();
                    $web_info = $web_site->getWebSiteInfo();
                    $shop_name = $web_info['title'];
                    $shop_logo = $web_info['logo'];
                    break;
                case NS_VER_B2B2C_FX1:
                case NS_VER_B2B2C_FX2:
                    // 查询店铺信息
                    $shop = new NsShopModel();
                    $shop_info = $shop->getInfo([
                        'shop_id' => $goods_info['shop_id']
                    ], 'shop_name,shop_logo');
                    $shop_name = $shop_info['shop_name'];
                    $shop_logo = $shop_info['shop_logo'];
                    $shop_id = $goods_info['shop_id'];
                    break;
            }
            $data = array(
                'uid' => $this->uid,
                'fav_id' => $fav_id,
                'fav_type' => $fav_type,
                'fav_time' => date("Y-m-d H:i:s", time()),
                'shop_id' => $shop_id,
                'shop_name' => $shop_name,
                'shop_logo' => $shop_logo,
                'goods_name' => $goods_info['goods_name'],
                'goods_image' => $picture['pic_cover_small'],
                'log_price' => $goods_info['price'],
                'log_msg' => $log_msg
            );
            $retval = $member_favorites->save($data);
            $goods->save(array(
                "collects" => $goods_info["collects"] + 1
            ), [
                "goods_id" => $fav_id
            ]);
            return $retval;
        } elseif ($fav_type == 'shop') {
            $shop = new NsShopModel();
            $shop_info = $shop->getInfo([
                'shop_id' => $fav_id
            ], 'shop_name,shop_logo,shop_collect');
            $data = array(
                'uid' => $this->uid,
                'fav_id' => $fav_id,
                'fav_type' => $fav_type,
                'fav_time' => date("Y-m-d H:i:s", time()),
                'shop_id' => $fav_id,
                'shop_name' => $shop_info['shop_name'],
                'shop_logo' => empty($shop_info['shop_logo']) ? ' ' : $shop_info['shop_logo'],
                'goods_name' => '',
                'goods_image' => '',
                'log_price' => 0,
                'log_msg' => $log_msg
            );
            $retval = $member_favorites->save($data);
            $shop->save(array(
                "shop_collect" => $shop_info["shop_collect"] + 1
            ), [
                "shop_id" => $fav_id
            ]);
            return $retval;
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::deleteMemberFavorites()
     */
    public function deleteMemberFavorites($fav_id, $fav_type)
    {
        $retval = false;
        $member_favorites = new NsMemberFavoritesModel();
        /*
         * if(!empty($this->uid)){
         * $condition=array(
         * 'fav_id'=>$fav_id,
         * 'fav_type'=>$fav_type,
         * 'uid'=>$this->uid
         * );
         * $retval=$member_favorites->destroy($condition);
         * }
         * return $retval;
         */
        if (! empty($this->uid)) {
            if ($fav_type == 'goods') {
                // 收藏商品
                $goods = new NsGoodsModel();
                $goods_info = $goods->getInfo([
                    'goods_id' => $fav_id
                ], 'goods_name,shop_id,price,picture,collects');
                $condition = array(
                    'fav_id' => $fav_id,
                    'fav_type' => $fav_type,
                    'uid' => $this->uid
                );
                $retval = $member_favorites->destroy($condition);
                $collect = empty($goods_info["collects"]) ? 0 : $goods_info["collects"];
                $collect --;
                if ($collect < 0) {
                    $collect = 0;
                }
                $goods->save([
                    "collects" => $collect
                ], [
                    "goods_id" => $fav_id
                ]);
                return $retval;
            } elseif ($fav_type == 'shop') {
                $shop = new NsShopModel();
                $shop_info = $shop->getInfo([
                    'shop_id' => $fav_id
                ], 'shop_name,shop_logo,shop_collect');
                $condition = array(
                    'fav_id' => $fav_id,
                    'fav_type' => $fav_type,
                    'uid' => $this->uid
                );
                $retval = $member_favorites->destroy($condition);
                $shop_collect = empty($shop_info["shop_collect"]) ? 0 : $shop_info["shop_collect"];
                $shop_collect --;
                if ($shop_collect < 0) {
                    $shop_collect = 0;
                }
                $shop->save([
                    "shop_collect" => $shop_collect
                ], [
                    "shop_id" => $fav_id
                ]);
                return $retval;
            }
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \data\api\niushop\IMember::getIsMemberFavorites()
     */
    public function getIsMemberFavorites($uid, $fav_id, $fav_type)
    {
        $member_favorites = new NsMemberFavoritesModel();
        $condition = array(
            'uid' => $uid,
            'fav_id' => $fav_id,
            'fav_type' => $fav_type
        );
        $res = $member_favorites->where($condition)->count();
        return $res;
    }

    /**
     * 获取浏览历史
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberViewHistory()
     */
    public function getMemberViewHistory()
    {
        $has_history = Cookie::has('goodshistory');
        if ($has_history) {
            $goods_id_array = Cookie::get('goodshistory');
            $goods = new NsGoodsModel();
            $goods_list = $goods->getQuery([
                'goods_id' => array(
                    'in',
                    $goods_id_array
                )
            ], '*', '');
            $list = array();
            for ($i = 0; $i < 8; $i ++) {
                if (! empty($goods_list[$i])) {
                    $picture = new AlbumPictureModel();
                    $picture_info = $picture->get($goods_list[$i]['picture']);
                    $goods_list[$i]['picture_info'] = $picture_info;
                    $list[] = $goods_list[$i];
                }
            }
            return $list;
        } else {
            return '';
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberAllViewHistory()
     */
    public function getMemberAllViewHistory($uid, $start_time, $end_time)
    {}

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::addMemberViewHistory()
     */
    public function addMemberViewHistory($goods_id)
    {
        $has_history = Cookie::has('goodshistory');
        if ($has_history) {
            $goods_id_array = Cookie::get('goodshistory');
            Cookie::set('goodshistory', $goods_id_array . ',' . $goods_id, 3600);
        } else {
            Cookie::set('goodshistory', $goods_id, 3600);
        }
        return 1;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::deleteMemberViewHistory()
     */
    public function deleteMemberViewHistory()
    {
        if (Cookie::has('goodshistory')) {
            Session::set('goodshistory', Cookie::get('goodshistory'));
        }
        Cookie::set('goodshistory', null);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberIsApplyShop()
     */
    public function getMemberIsApplyShop($uid)
    {
        if ($this->is_system == 1) {
            return 'is_system';
        } else {
            // 是否正在申请
            $shop_apply = new NsShopApplyModel();
            $apply = $shop_apply->get([
                'uid' => $uid
            ]);
            if (! empty($apply)) {
                if ($apply['apply_state'] == - 1) {
                    // 已被拒绝
                    return 'refuse_apply';
                } else 
                    if ($apply['apply_state'] == 2) {
                        // 已同意
                        return 'is_system';
                    } else {
                        // 存在正在申请
                        return 'is_apply';
                    }
            } else {
                // 可以申请
                return 'apply';
            }
        }
    }

    /**
     * 猜你喜欢(non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getGuessMemberLikes()
     */
    public function getGuessMemberLikes()
    {
        $history = Cookie::has('goodshistory') ? Cookie::get('goodshistory') : Session::get('goodshistory');
        ;
        if (! empty($history)) {
            $history_array = explode(",", $history);
            $goods_id = $history_array[count($history_array) - 1];
            $goods_model = new NsGoodsModel();
            $category_id = $goods_model->getInfo([
                'goods_id' => $goods_id
            ], 'category_id');
        } else {
            $category_id['category_id'] = 0;
        }
        $goods = new Goods();
        $goods_list = $goods->getGoodsList(1, 15, [
            'ng.category_id' => $category_id['category_id'],
            'ng.state' => 1
        ], 'ng.sort');
        
        return $goods_list['data'];
    }

    /**
     * 用户余额
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getMemberAccount()
     */
    public function getMemberAccount($uid, $shop_id)
    {
        $member_account = new NsMemberAccountModel();
        $account_info = $member_account->getInfo([
            'uid' => $uid,
            'shop_id' => $shop_id
        ], 'point');
        if (empty($account_info)) {
            $account_info["point"] = 0;
        }
        $account = new MemberAccount();
        $account_info['balance'] = $account->getMemberBalance($uid);
        $account_info['coin'] = $account->getMemberCoin($uid);
        return $account_info;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::memberPointToBalance()
     */
    public function memberPointToBalance($uid, $shop_id, $point)
    {
        $member_account_model = new NsMemberAccountModel();
        $member_account_model->startTrans();
        try {
            $member_account_info = $this->getMemberAccount($uid, $shop_id);
            if ($point > $member_account_info['point']) {
                $member_account_model->commit();
                return LOW_POINT;
            } else {
                $point_config = new NsPointConfigModel();
                $point_info = $point_config->getInfo([
                    'shop_id' => $shop_id
                ], 'is_open, convert_rate');
                if ($point_info['is_open'] == 0 || empty($point_info)) {
                    $member_account_model->rollback();
                    return "积分兑换功能关闭";
                } else {
                    $member_account = new MemberAccount();
                    $exchange_balance = $member_account->pointToBalance($point, $shop_id);
                    $retval = $member_account->addMemberAccountData($shop_id, 1, $uid, 0, $point * (- 1), 3, 0, '积分兑换余额');
                    if ($retval < 0) {
                        $member_account_model->rollback();
                        return $retval;
                    }
                    $retval = $member_account->addMemberAccountData($shop_id, 2, $uid, 1, $exchange_balance, 3, 0, '积分兑换余额');
                    if ($retval < 0) {
                        $member_account_model->rollback();
                        return $retval;
                    }
                    $member_account_model->commit();
                    return 1;
                }
            }
        } catch (\Exception $e) {
            $member_account_model->rollback();
            return $e->getMessage();
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::memberShopPointCount()
     */
    public function memberShopPointCount($uid = 0, $shop_id = 0)
    {
        $member_account_model = new NsMemberAccountModel();
        $point_count = $member_account_model->getInfo([
            'shop_id' => $shop_id,
            'uid' => $uid
        ], 'point')['point'];
        return $point_count;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::memberShopBalanceCount()
     */
    public function memberShopBalanceCount($uid = 0, $shop_id = 0)
    {
        $member_account_model = new NsMemberAccountModel();
        $balance_count = $member_account_model->getInfo([
            'shop_id' => $shop_id,
            'uid' => $uid
        ], 'balance')['balance'];
        return $balance_count;
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IMember::getMemberAll()
     */
    public function getMemberAll($condition)
    {
        // TODO Auto-generated method stub
        $user = new UserModel();
        $user_data = $user->all($condition);
        return $user_data;
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IMember::getMemberCount()
     */
    public function getMemberCount($condition)
    {
        // TODO Auto-generated method stub
        $user = new UserModel();
        $user_sum = $user->where($condition)->count();
        return $user_sum;
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\niushop\IMember::getMemberMonthCount()
     */
    public function getMemberMonthCount($begin_date, $end_date)
    {
        // TODO Auto-generated method stub
        // $begin = date('Y-m-01', strtotime(date("Y-m-d")));
        // $end = date('Y-m-d', strtotime("$begin +1 month -1 day"));
        $user = new UserModel();
        $condition["reg_time"] = [
            [
                ">",
                $begin_date
            ],
            [
                "<",
                $end_date
            ]
        ];
        // 一段时间内的注册用户
        $user_list = $user->all($condition);
        $begintime = strtotime($begin_date);
        $endtime = strtotime($end_date);
        
        $list = array();
        for ($start = $begintime; $start <= $endtime; $start += 24 * 3600) {
            $list[date("Y-m-d", $start)] = array();
            $user_num = 0;
            foreach ($user_list as $v) {
                if (date("Y-m-d", strtotime($v["reg_time"])) == date("Y-m-d", $start)) {
                    $user_num = $user_num + 1;
                }
            }
            $list[date("Y-m-d", $start)] = $user_num;
        }
        return $list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::addMemberAccount()
     */
    public function addMemberAccount($shop_id, $type, $uid, $num, $text)
    {
        $member_account = new MemberAccount();
        $retval = $member_account->addMemberAccountData($shop_id, $type, $uid, 1, $num, 4, 0, $text);
        return $retval;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getIsMemberSign()
     */
    public function getIsMemberSign($uid, $shop_id)
    {
        $member_account_records = new NsMemberAccountRecordsModel();
        $day_begin_time = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m'), date('d'), date('Y')));
        $day_end_time = date("Y-m-d H:i:s", mktime(59, 59, 59, date('m'), date('d'), date('Y')));
        $condition = array(
            'uid' => $uid,
            'shop_id' => $shop_id,
            'account_type' => 1,
            'from_type' => 5,
            'create_time' => array(
                'between time',
                [
                    $day_begin_time,
                    $day_end_time
                ]
            )
        );
        $count = $member_account_records->getCount($condition);
        return $count;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getIsMemberShare()
     */
    public function getIsMemberShare($uid, $shop_id)
    {
        $member_account_records = new NsMemberAccountRecordsModel();
        $day_begin_time = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m'), date('d'), date('Y')));
        $day_end_time = date("Y-m-d H:i:s", mktime(59, 59, 59, date('m'), date('d'), date('Y')));
        $condition = array(
            'uid' => $uid,
            'shop_id' => $shop_id,
            'account_type' => 1,
            'from_type' => 6,
            'create_time' => array(
                'between time',
                [
                    $day_begin_time,
                    $day_end_time
                ]
            )
        );
        $count = $member_account_records->getCount($condition);
        return $count;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \data\api\niushop\IMember::getPageMemberSignList()
     */
    public function getPageMemberSignList($page_index, $page_size, $shop_id)
    {
        $member_account = new NsMemberAccountRecordsModel();
        $condition = array(
            'uid' => $this->uid,
            'account_type' => 1,
            'shop_id' => $shop_id,
            'from_type' => '5'
        );
        $list = $member_account->pageQuery($page_index, $page_size, $condition, 'create_time desc', 'sign,number,from_type,data_id,text,create_time');
        return $list;
    }

    /**
     * 用户退出
     */
    public function Logout()
    {
        Session::clear();
        $_SESSION["user_cart"] = '';
    }
}