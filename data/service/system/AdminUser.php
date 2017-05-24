<?php
/**
 * AdminUser.php
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

use data\api\system\IAdmin as IAdmin;
use data\model\system\AdminUserModel as AdminUserModel;
use data\model\system\ModuleModel as ModuleModel;
use data\service\system\User as User;
use data\model\system\AdminUserViewModel as AdminUserViewModel;
use \think\Session as Session;
use data\model\system\UserLogModel;
use data\service\niushop\Member;
use data\model\niushop\NsMemberModel;

class AdminUser extends User implements IAdmin
{

    function __construct()
    {
        parent::__construct();
        $this->admin_user = new AdminUserModel();
    }

    /**
     * 获取权限列表(non-PHPdoc)
     *
     * @see \data\api\IAdmin::getchildModuleQuery()
     */
    public function getchildModuleQuery($moduleid)
    {
        $module_list = Session::get('module_list_' . $moduleid);
        if (empty($module_list) || $module_list == false) {
            $auth_group = new ModuleModel();
            if ($this->is_admin) {
                
                $list = $auth_group->getAuthList($moduleid);
                $new_list = $list;
            } else {
                
                $list = $auth_group->getAuthList($moduleid);
                $module_id_array = explode(',', $this->module_id_array);
                $new_list = array();
                if ($moduleid != 0) {
                    
                    foreach ($list as $k => $v) {
                        if (in_array($list[$k]['module_id'], $module_id_array)) {
                            
                            $new_list[] = $list[$k];
                        }
                    }
                } else {
                    
                    foreach ($list as $k => $v) {
                        $check_module_id = $auth_group->getModuleIdByModule($v['controller'], $v['method']);
                        $check_auth = $this->checkAuth($check_module_id);
                        if ($check_auth == 0) {
                            $sub_menu = $this->getchildModuleQuery($v['module_id']);
                            if (! empty($sub_menu[0])) {
                                $v['url'] = $sub_menu[0]['url'];
                            }
                        }
                        if (in_array($list[$k]['module_id'], $module_id_array)) {
                            $new_list[] = $v;
                        }
                    }
                }
            }
            if (config('app_debug')) {
                Session::set('module_list_' . $moduleid, $new_list);
                return $new_list;
            } else {
                $arrange_list = array();
                foreach ($new_list as $k => $v) {
                    if ($v['is_dev'] == 0) {
                        $arrange_list[] = $new_list[$k];
                    }
                }
                Session::set('module_list_' . $moduleid, $arrange_list);
                return $arrange_list;
            }
        } else {
            return $module_list;
        }
    }

    /**
     * 后台操作用户列表(non-PHPdoc)
     *
     * @see \data\api\IAdmin::adminUserList()
     */
    public function adminUserList($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        $admin_user = new AdminUserViewModel();
        $res = $admin_user->getAdminUserViewList($page_index, $page_size, $condition, $order);
        return $res;
    }

    /**
     * 添加后台用户
     */
    public function addAdminUser($user_name, $group_id, $user_password, $desc, $instance_id = 0)
    {
        $uid = $this->add($user_name, $user_password, '', '', 1, '', '', '', '','', 1, $instance_id);
        if ($uid <= 0) {
            return $uid;
        }
        $data_admin = array(
            'uid' => $uid,
            'admin_name' => $user_name,
            'group_id_array' => $group_id,
            'admin_status' => 1,
            'desc' => $desc
        );
        $member = new NsMemberModel();
        $data_member = array(
            'uid' => $uid,
            'member_name' => $user_name,
            'reg_time' => date("Y-m-d H:i:s", time())
        );
        $retval = $member->save($data_member);
        $res = $this->admin_user->save($data_admin);
        return $res;
    }

    /**
     * 获取单个后台用户信息
     */
    public function getAdminUserInfo($condition, $field = "*")
    {
        $admin_user_info = $this->admin_user->getInfo($condition, $field = "*");
        return $admin_user_info;
    }

    /**
     * 编辑后台用户
     */
    public function editAdminUser($uid, $user_name, $group_id, $desc)
    {
        $res = $this->ModifyUserName($uid, $user_name);
        if ($res) {
            $data = array(
                'admin_name' => $user_name,
                'group_id_array' => $group_id,
                'admin_status' => 1,
                'desc' => $desc
            );
            $res = $this->admin_user->save($data, [
                "uid" => $uid
            ]);
        }
        
        return $res;
    }

    /*
     * (non-PHPdoc)
     * @see \data\api\system\IAdmin::getUserLogList()
     */
    public function getUserLogList($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        // TODO Auto-generated method stub
        $user_log = new UserLogModel();
        $list = $user_log->pageQuery($page_index, $page_size, $condition, $order, '*');
        return $list;
    }
    
    /**
     * (non-PHPdoc)
     * @see \data\api\system\IAdmin::getAdminUserCountByGroupIdArray()
     */
    public function getAdminUserCountByGroupIdArray($condition){
        $admin_user = new AdminUserViewModel();
        $num = $admin_user->getAdminUserViewCount($condition);
        return $num;
    }
}