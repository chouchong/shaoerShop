<?php
/**
 * BaseController.php
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

\think\Loader::addNamespace('data', 'data/');
use data\service\niushop\Shop;
use data\service\system\AdminUser as User;
use data\service\system\WebSite as WebSite;
use think\Controller;

class BaseController extends Controller
{

    protected $user = null;

    protected $website = null;

    protected $uid;

    protected $instance_id;

    protected $instance_name;

    protected $user_name;

    protected $user_headimg;

    protected $module = null;

    protected $controller = null;

    protected $action = null;

    protected $module_info = null;

    protected $rootid = null;

    protected $moduleid = null;

    /**
     * 当前版本的路径
     *
     * @var string
     */
    protected $style = null;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
        $this->website = new WebSite();
        $this->init();
        $this->assign("pageshow", PAGESHOW);
    }

    /**
     * 创建时间：2016-10-27
     * 功能说明：action基类 调用 加载头部数据的方法
     */
    public function init()
    {
        $this->uid = $this->user->getSessionUid();
        $is_system = $this->user->getSessionUserIsSystem();
        
        if (empty($this->uid)) {
            $this->redirect("Login/index");
        }
        if (empty($is_system)) {
            $this->redirect("Login/index");
        }
        $this->instance_id = $this->user->getSessionInstanceId();
        $this->instance_name = $this->user->getInstanceName();
        $this->module = \think\Request::instance()->module();
        $this->controller = \think\Request::instance()->controller();
        $this->action = \think\Request::instance()->action();
        $this->module_info = $this->website->getModuleIdByModule($this->controller, $this->action);
        // 过滤控制权限 为0
        if (empty($this->module_info)) {
            $this->moduleid = 0;
            $check_auth = 1;
        } elseif ($this->module_info["is_control_auth"] == 0) {
            $this->moduleid = $this->module_info['module_id'];
            $check_auth = 1;
        } else {
            $this->moduleid = $this->module_info['module_id'];
            $check_auth = $this->user->checkAuth($this->moduleid);
        }
        if ($check_auth) {
            $this->style = 'admin/' . NS_TEMPLATE.'/';
            $this->addUserLog();
            if (! request()->isAjax()) {
                /* 店铺导航 */
                $shop = new Shop();
                $ShopNavigationData = $shop->ShopNavigationList(1, 6, [
                    "type" => 3
                ], 'sort');
                $web_info = $this->website->getWebSiteInfo();
                $user_info = $this->user->getUserInfo();
                $root_array = $this->website->getModuleRootAndSecondMenu($this->moduleid);
                $this->rootid = $root_array[0];
                $second_menu_id = $root_array[1];
                $root_module_info = $this->website->getSystemModuleInfo($this->rootid, 'module_name,url,module_picture');
                $first_menu_list = $this->user->getchildModuleQuery(0);
                if ($this->rootid != 0) {
                    $second_menu_list = $this->user->getchildModuleQuery($this->rootid);
                } else {
                    $second_menu_list = '';
                }
                $this->user_name = $user_info['user_name'];
                $this->user_headimg = $user_info['user_headimg'];
                $this->assign("style", 'admin/' . NS_TEMPLATE);
                $this->assign("headid", $this->rootid);
                $this->assign("second_menu_id", $second_menu_id);
                $this->assign("moduleid", $this->moduleid);
                $this->assign("HeadCode", $this->user_name);
                $this->assign("title_name", $this->instance_name);
                $this->assign("username", $this->user_name);
                $this->assign("user_headimg", $this->user_headimg);
                $this->assign("headlist", $first_menu_list);
                $this->assign("leftlist", $second_menu_list);
                $this->assign("frist_menu", $root_module_info); // 当前选中的导航菜单
                $this->assign("secend_menu", $this->module_info);
                $child_menu_list = array(
                    array(
                        'url' => $this->module_info['url'],
                        'menu_name' => $this->module_info['module_name'],
                        'active' => 1
                    )
                );
                $this->assign('child_menu_list', $child_menu_list);
                $this->assign('ShopNavigationData', $ShopNavigationData['data']);
                $this->assign('first_menu_list', $first_menu_list);
                $this->assign('second_menu_list', $second_menu_list);
                $this->getNavigation();
            }
        } else {
            if (request()->isAjax()) {
                echo json_encode(AjaxReturn(NO_AITHORITY));
                exit();
            } else {
                $this->error("当前用户没有操作权限");
            }
        }
    }

    /**
     * 添加操作日志（当前考虑所有操作），
     */
    private function addUserLog()
    {
        $get_data = '';
        if ($_GET) {
            $res = \think\Request::instance()->get();
            $get_data = json_encode($res);
        }
        if ($_POST) {
            $res = \think\Request::instance()->post();
            if (empty($get_data)) {
                $get_data = json_encode($res);
            } else {
                $get_data = $get_data . ',' . json_encode($res);
            }
        }
        // 建议，调试模式，用于
        // $res = $this->user->addUserLog($this->uid, 1, $this->controller, $this->action, \think\Request::instance()->ip(), $get_data);
    }

    /**
     * 获取导航
     */
    public function getNavigation()
    {
        $first_list = $this->user->getchildModuleQuery(0);
        $list = array();
        foreach ($first_list as $k => $v) {
            $submenu = $this->user->getchildModuleQuery($v['module_id']);
            $list[$k]['data'] = $v;
            $list[$k]['sub_menu'] = $submenu;
        }
        $this->assign("nav_list", $list);
    }
}
