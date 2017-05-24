<?php
/**
 * System.php
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

use data\service\niushop\Goods as Goods;
use data\service\niushop\GoodsBrand as GoodsBrand;
use data\service\niushop\GoodsCategory as GoodsCategory;
use data\service\niushop\Platform;
use data\service\system\Album as Album;

/**
 * 系统模块控制器
 *
 * @author Administrator
 *        
 */
class System extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 图片选择
     * 2016年11月21日 16:23:35
     */
    public function dialogAlbumList()
    {
        $query = $this->getAlbumClassALL();
        $this->assign("photoNumber", $_GET['photoNumber']);
        $this->assign("album_list", $query);
        return view($this->style . "System/dialogAlbumList");
    }

    /**
     * 模块列表
     */
    public function moduleList()
    {
        $condition = array(
            'pid' => 0,
            'module' => $this->module
        );
        $frist_list = $this->website->getSystemModuleList(1, 0, $condition, 'pid,sort');
        $frist_list = $frist_list['data'];
        $list = array();
        foreach ($frist_list as $k => $v) {
            $submenu = $this->website->getSystemModuleList(1, 0, 'pid=' . $v['module_id'], 'pid,sort');
            $v['sub_menu'] = $submenu['data'];
            if (! empty($submenu['data'])) {
                foreach ($submenu['data'] as $ks => $vs) {
                    $sub_sub_menu = $this->website->getSystemModuleList(1, 0, 'pid=' . $vs['module_id'], 'pid,sort');
                    $vs['sub_menu'] = $sub_sub_menu['data'];
                    if (! empty($sub_sub_menu['data'])) {
                        foreach ($sub_sub_menu['data'] as $kss => $vss) {
                            $sub_sub_sub_menu = $this->website->getSystemModuleList(1, 0, 'pid=' . $vss['module_id'], 'pid,sort');
                            $vss['sub_menu'] = $sub_sub_sub_menu['data'];
                            if (! empty($sub_sub_sub_menu['data'])) {
                                foreach ($sub_sub_sub_menu['data'] as $ksss => $vsss) {
                                    $sub_sub_sub_sub_menu = $this->website->getSystemModuleList(1, 0, 'pid=' . $vsss['module_id'], 'pid,sort');
                                    $vsss['sub_menu'] = $sub_sub_sub_sub_menu['data'];
                                }
                            }
                        }
                    }
                }
            }
        }
        $list = $frist_list;
        $this->assign("list", $list);
        return view($this->style . 'System/moduleList');
    }

    /**
     * 添加模块
     */
    public function addModule()
    {
        if (request()->isAjax()) {
            $module_id = 0;
            $module_name = $_POST['module_name'];
            $controller = $_POST['controller'];
            $method = $_POST['method'];
            $pid = $_POST['pid'];
            $url = $_POST['url'];
            $is_menu = $_POST['is_menu'];
            $is_control_auth = $_POST["is_control_auth"]; // 是否控制权限
            $is_dev = $_POST['is_dev'];
            $sort = $_POST['sort'];
            $module_picture = $_POST['module_picture'];
            $desc = $_POST['desc'];
            $icon_class = '';
            $retval = $this->website->addSytemModule($module_name, $controller, $method, $pid, $url, $is_menu, $is_dev, $sort, $module_picture, $desc, $icon_class, $is_control_auth);
            return AjaxReturn($retval, $retval);
        } else {
            $condition = array(
                'pid' => 0,
                'module' => $this->module
            );
            $frist_list = $this->website->getSystemModuleList(1, 100, $condition, 'pid,sort');
            $frist_list = $frist_list['data'];
            $list = array();
            foreach ($frist_list as $k => $v) {
                $submenu = $this->website->getSystemModuleList(1, 100, 'pid=' . $v['module_id'], 'pid,sort');
                $list[$k]['data'] = $v;
                $list[$k]['sub_menu'] = $submenu['data'];
            }
            $this->assign("list", $list);
            $pid = $_GET['pid'];
            $this->assign("pid", $pid);
            return view($this->style . 'System/addModule');
        }
    }

    /**
     * 修改模块
     */
    public function editModule()
    {
        if (request()->isAjax()) {
            $module_id = $_POST['module_id'];
            $module_name = $_POST['module_name'];
            $controller = $_POST['controller'];
            $method = $_POST['method'];
            $pid = $_POST['pid'];
            $url = $_POST['url'];
            $is_menu = $_POST['is_menu'];
            $is_dev = $_POST['is_dev'];
            $is_control_auth = $_POST['is_control_auth']; // 是否控制权限
            $sort = $_POST['sort'];
            $module_picture = $_POST['module_picture'];
            $desc = $_POST['desc'];
            $icon_class = '';
            $retval = $this->website->updateSystemModule($module_id, $module_name, $controller, $method, $pid, $url, $is_menu, $is_dev, $sort, $module_picture, $desc, $icon_class, $is_control_auth);
            return AjaxReturn($retval);
        } else {
            $module_id = $_GET['module_id'];
            $module_info = $this->website->getSystemModuleInfo($module_id);
            $condition = array(
                'pid' => 0,
                'module' => $this->module
            );
            $frist_list = $this->website->getSystemModuleList(1, 100, $condition, 'pid,sort');
            $frist_list = $frist_list['data'];
            $list = array();
            foreach ($frist_list as $k => $v) {
                $submenu = $this->website->getSystemModuleList(1, 100, 'pid=' . $v['module_id'], 'pid,sort');
                $list[$k]['data'] = $v;
                $list[$k]['sub_menu'] = $submenu['data'];
            }
            $this->assign('module_info', $module_info);
            $this->assign("list", $list);
            return view($this->style . 'System/editModule');
        }
    }

    /**
     * 删除模块
     */
    public function delModule()
    {
        $module_id = $_POST['module_id'];
        $retval = $this->website->deleteSystemModule($module_id);
        return AjaxReturn($retval);
    }

    /**
     * 获取图片分组
     */
    public function albumList()
    {
        if (request()->isAjax()) {
            $page_index = isset($_POST["pageIndex"]) ? $_POST["pageIndex"] : 1;
            $search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
            $album = new Album();
            $condition = array(
                'shop_id' => $this->instance_id,
                'album_name' => array(
                    'like',
                    '%' . $search_text . '%'
                )
            );
            $retval = $album->getAlbumClassList($page_index, PAGESIZE, $condition);
            return $retval;
        } else {
            $album_list = $this->getAlbumClassALL();
            $this->assign('album_list', $album_list);
            return view($this->style . "System/albumList");
        }
    }

    /**
     * 创建相册
     */
    public function addAlbumClass()
    {
        $album_name = $_POST['album_name'];
        $sort = $_POST['sort'];
        $album = new Album();
        $retval = $album->addAlbumClass($album_name, $sort, 0, '', 0, $this->instance_id);
        return AjaxReturn($retval);
    }

    /**
     * 删除相册
     */
    public function deleteAlbumClass()
    {
        $aclass_id_array = $_POST['aclass_id_array'];
        $album = new Album();
        $retval = $album->deleteAlbumClass($aclass_id_array);
        return AjaxReturn($retval);
    }

     /**
     * 相册图片列表
     */
    public function albumPictureList()
    {
        if (request()->isAjax()) {
            $page_index = $_POST["pageIndex"];
            $album_id = isset($_POST["album_id"]) ? $_POST["album_id"] : 0;
            $condition = array();
            $condition["album_id"] = $album_id;
            //var_dump(PICTURESIZE);
            $album = new Album();
            $list = $album->getPictureList($page_index, 15, $condition);
            foreach ($list["data"] as $k => $v) {
                $list["data"][$k]["upload_time"] = substr($v["upload_time"], 0, - 8);
            }
            return $list;
        } else {
            $album_list = $this->getAlbumClassALL();
            $this->assign('album_list', $album_list);
            $child_menu_list = array(
                array(
                    'url' => "System/albumList",
                    'menu_name' => "相册",
                    "active" => 0
                ),
                array(
                    'url' => "System/albumPictureList",
                    'menu_name' => "图片",
                    "active" => 1
                )
        
            );
            $this->assign('child_menu_list', $child_menu_list);
            $album_id = isset($_GET["album_id"]) ? $_GET["album_id"] : 0;
            $album_name = isset($_GET["album_name"]) ? $_GET["album_name"] : '';
            $this->assign("album_name", $album_name);
            $this->assign("album_id", $album_id);
            return view($this->style . "System/albumPictureList");
        }
    }

    /**
     * 相册图片列表
     */
    public function dialogAlbumPictureList()
    {
        if (request()->isAjax()) {
            $page_index = $_POST["pageIndex"];
            $album_id = $_POST["album_id"];
            $condition = "album_id = $album_id";
            $album = new Album();
            $list = $album->getPictureList($page_index, 10, $condition);
            foreach ($list["data"] as $k => $v) {
                $list["data"][$k]["upload_time"] = date("Y-m-s", strtotime($v["upload_time"]));
            }
            return $list;
        } else {
            return view($this->style . "System/dialogAlbumPictureList");
        }
    }

    /**
     * 删除图片
     *
     * @param unknown $pic_id_array            
     * @return unknown
     */
    public function deletePicture()
    {
        $pic_id_array = $_POST["pic_id_array"];
        $album = new Album();
        $retval = $album->deletePicture($pic_id_array);
        return AjaxReturn($retval);
    }

    /**
     * 获取相册详情
     *
     * @return Ambigous <\think\static, multitype:, \think\db\false, PDOStatement, string, \think\Model, \PDOStatement, \think\db\mixed, multitype:a r y s t i n g Q u e \ C l o , \think\db\Query, NULL>
     */
    public function getAlbumClassDetail()
    {
        $album_id = $_POST["album_id"];
        $album = new Album();
        $retval = $album->getAlbumClassDetail($album_id);
        return $retval;
    }

    /**
     * 修改相册
     */
    public function updateAlbumClass()
    {
        $album_id = $_POST["album_id"];
        $aclass_name = $_POST["album_name"];
        $aclass_sort = $_POST["sort"];
        $album_cover = $_POST["album_cover"];
        $album = new Album();
        $retval = $album->updateAlbumClass($album_id, $aclass_name, $aclass_sort, 0, $album_cover);
        return AjaxReturn($retval);
    }

    /**
     * 删除制定路径文件
     */
    function delete_file()
    {
        $file_url = isset($_POST['file_url']) ? $_POST['file_url'] : '';
        if (file_exists($file_url)) {
            @unlink($file_url);
            $retval = array(
                'code' => 1,
                'message' => '文件删除成功'
            );
        } else {
            $retval = array(
                'code' => 0,
                'message' => '文件不存在'
            );
        }
        return $retval;
    }

    /**
     * 获取所有相册
     */
    public function getAlbumClassALL()
    {
        $album = new Album();
        $retval = $album->getAlbumClassAll([
            'shop_id' => $this->instance_id
        ]);
        return $retval;
    }

    /**
     * 修改单个字段
     */
    public function modifyField()
    {
        $fieldid = $_POST['fieldid'];
        $fieldname = $_POST['fieldname'];
        $fieldvalue = $_POST['fieldvalue'];
        $retval = $this->website->ModifyModuleField($fieldid, $fieldname, $fieldvalue);
        return AjaxReturn($retval);
    }

    /**
     * 图片名称修改
     */
    public function modifyAlbumPictureName()
    {
        $pic_id = $_POST["pic_id"];
        $pic_name = $_POST["pic_name"];
        $album = new Album();
        $retval = $album->ModifyAlbumPictureName($pic_id, $pic_name);
        return AjaxReturn($retval);
    }

    /**
     * 转移图片所在相册
     */
    public function modifyAlbumPictureClass()
    {
        $pic_id = $_POST["pic_id"];
        $album_id = $_POST["album_id"];
        $album = new Album();
        $retval = $album->ModifyAlbumPictureClass($pic_id, $album_id);
        return AjaxReturn($retval);
    }

    /**
     * 设此图片为本相册的封面
     */
    function modifyAlbumClassCover()
    {
        $pic_id = $_POST["pic_id"];
        $album_id = $_POST["album_id"];
        $album = new Album();
        $retval = $album->ModifyAlbumClassCover($pic_id, $album_id);
        return AjaxReturn($retval);
    }

    /**
     * 广告位列表
     */
    public function shopAdvPositionList()
    {
        if (request()->isAjax()) {
            $index = isset($_POST["pageIndex"]) ? $_POST["pageIndex"] : 1;
            $search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
            $platform = new Platform();
            $list = $platform->getPlatformAdvPositionList($index, PAGESIZE, [
                'ap_name' => array(
                    'like',
                    '%' . $search_text . '%'
                ),
                'instance_id' => $this->instance_id
            ]);
            return $list;
        }
        return view($this->style . "System/shopAdvPositionList");
    }

    /**
     * 添加广告位
     *
     * @return \think\response\View
     */
    public function addShopAdvPosition()
    {
        if (request()->isAjax()) {
            $ap_name = isset($_POST['ap_name']) ? $_POST['ap_name'] : '';
            $ap_intro = isset($_POST['ap_intro']) ? $_POST['ap_intro'] : '';
            $ap_class = isset($_POST['ap_class']) ? $_POST['ap_class'] : 0;
            $ap_display = isset($_POST['ap_display']) ? $_POST['ap_display'] : 2;
            $is_use = isset($_POST['is_use']) ? $_POST['is_use'] : 0;
            $ap_height = isset($_POST['ap_height']) ? $_POST['ap_height'] : '';
            $ap_width = isset($_POST['ap_width']) ? $_POST['ap_width'] : '';
            $default_content = isset($_POST['default_content']) ? $_POST['default_content'] : '';
            $ap_background_color = isset($_POST['ap_background_color']) ? $_POST['ap_background_color'] : '';
            $type = isset($_POST['type']) ? $_POST['type'] : '';
            $platform = new Platform();
            $res = $platform->addPlatformAdvPosition($this->instance_id, $ap_name, $ap_intro, $ap_class, $ap_display, $is_use, $ap_height, $ap_width, $default_content, $ap_background_color, $type);
            return AjaxReturn($res);
        }
        return view($this->style . "System/addShopAdvPosition");
    }

    /**
     * 修改广告位
     */
    public function updateShopAdvPosition()
    {
        $platform = new Platform();
        if (request()->isAjax()) {
            $ap_id = isset($_POST['ap_id']) ? $_POST['ap_id'] : '';
            $ap_name = isset($_POST['ap_name']) ? $_POST['ap_name'] : '';
            $ap_intro = isset($_POST['ap_intro']) ? $_POST['ap_intro'] : '';
            $ap_class = isset($_POST['ap_class']) ? $_POST['ap_class'] : 0;
            $ap_display = isset($_POST['ap_display']) ? $_POST['ap_display'] : 2;
            $is_use = isset($_POST['is_use']) ? $_POST['is_use'] : 0;
            $ap_height = isset($_POST['ap_height']) ? $_POST['ap_height'] : '';
            $ap_width = isset($_POST['ap_width']) ? $_POST['ap_width'] : '';
            $default_content = isset($_POST['default_content']) ? $_POST['default_content'] : '';
            $ap_background_color = isset($_POST['ap_background_color']) ? $_POST['ap_background_color'] : '';
            $type = isset($_POST['type']) ? $_POST['type'] : '';
            $res = $platform->updatePlatformAdvPosition($ap_id, $this->instance_id, $ap_name, $ap_intro, $ap_class, $ap_display, $is_use, $ap_height, $ap_width, $default_content, $ap_background_color, $type);
            return AjaxReturn($res);
        }
        $id = isset($_GET['ap_id']) ? $_GET['ap_id'] : '';
        $info = $platform->getPlatformAdvPositionDetail($id);
        $this->assign('info', $info);
        return view($this->style . "System/updateShopAdvPosition");
    }

    /**
     * 广告列表 （广告位下级）
     *
     * @return number[]|unknown[]|\think\response\View
     */
    public function shopAdvList()
    {
        $ap_id = isset($_GET['ap_id']) ? $_GET['ap_id'] : '';
        $this->assign('ap_id', $ap_id);
        if (request()->isAjax()) {
            $index = isset($_POST["pageIndex"]) ? $_POST["pageIndex"] : 1;
            $search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
            $ap_id = isset($_POST['ap_id']) ? $_POST['ap_id'] : '';
            $platform = new Platform();
            $list = $platform->getPlatformAdvList($index, PAGESIZE, [
                'ap_id' => $ap_id,
                'adv_title' => array(
                    'like',
                    '%' . $search_text . '%'
                )
            ]);
            return $list;
        }
        return view($this->style . "System/shopAdvList");
    }

    /**
     * 修改广告排序
     */
    public function modifyAdvSort()
    {
        if (request()->isAjax()) {
            $adv_id = isset($_POST['fieldid']) ? $_POST['fieldid'] : '';
            $slide_sort = isset($_POST['fieldvalue']) ? $_POST['fieldvalue'] : '';
            $platform = new Platform();
            $res = $platform->updateAdvSlideSort($adv_id, $slide_sort);
            return AjaxReturn($res);
        }
    }

    /**
     * 添加广告
     */
    public function addShopAdv()
    {
        $ap_id = isset($_GET['ap_id']) ? $_GET['ap_id'] : '';
        $this->assign("ap_id", $ap_id);
        $platform = new Platform();
        if (request()->isAjax()) {
            $ap_id = isset($_POST['ap_id']) ? $_POST['ap_id'] : '';
            $adv_title = isset($_POST['adv_title']) ? $_POST['adv_title'] : '';
            $adv_url = isset($_POST['adv_url']) ? $_POST['adv_url'] : '';
            $adv_image = isset($_POST['adv_image']) ? $_POST['adv_image'] : '';
            $slide_sort = isset($_POST['slide_sort']) ? $_POST['slide_sort'] : '';
            $background = isset($_POST['background']) ? $_POST['background'] : '';
            $res = $platform->addPlatformAdv($ap_id, $adv_title, $adv_url, $adv_image, $slide_sort, $background);
            return AjaxReturn($res);
        }
        $list = $platform->getPlatformAdvPositionList(1, 0, '', '', 'ap_id,ap_name,ap_class,ap_display');
        $this->assign('platform_adv_position_list', $list['data']);
        return view($this->style . "System/addShopAdv");
    }

    /**
     * 修改广告
     */
    public function updateShopAdv()
    {
        $platform = new Platform();
        if (request()->isAjax()) {
            $adv_id = isset($_POST['adv_id']) ? $_POST['adv_id'] : '';
            $ap_id = isset($_POST['ap_id']) ? $_POST['ap_id'] : '';
            $adv_title = isset($_POST['adv_title']) ? $_POST['adv_title'] : '';
            $adv_url = isset($_POST['adv_url']) ? $_POST['adv_url'] : '';
            $adv_image = isset($_POST['adv_image']) ? $_POST['adv_image'] : '';
            $slide_sort = isset($_POST['slide_sort']) ? $_POST['slide_sort'] : '';
            $background = isset($_POST['background']) ? $_POST['background'] : '';
            $res = $platform->updatePlatformAdv($adv_id, $ap_id, $adv_title, $adv_url, $adv_image, $slide_sort, $background);
            return AjaxReturn($res);
        }
        $adv_id = isset($_GET['adv_id']) ? $_GET['adv_id'] : '';
        $adv_info = $platform->getPlatformAdDetail($adv_id);
        $this->assign('adv_info', $adv_info);
        $list = $platform->getPlatformAdvPositionList(1, 0, '', '', 'ap_id,ap_name,ap_class,ap_display');
        $this->assign('platform_adv_position_list', $list['data']);
        return view($this->style . "System/updateShopAdv");
    }

    /**
     * 删除广告
     */
    public function delShopAdv()
    {
        $adv_id = isset($_POST['adv_id']) ? $_POST['adv_id'] : '';
        $platform = new Platform();
        $res = $platform->deletePlatformAdv($adv_id);
        return AjaxReturn($res);
    }

    /**
     * 促销 版块
     */
    public function goodsRecommendClass()
    {
        $platform = new Platform();
        $goods_recommend_class = $platform->getPlatformGoodsRecommendClass();
        $this->assign('goods_recommend_class', $goods_recommend_class);
        $goods_category = new GoodsCategory();
        $category_list_1 = $goods_category->getGoodsCategoryList(1, 0, [
            'is_visible' => 1,
            'level' => 1
        ]);
        $this->assign('category_list_1', $category_list_1['data']);
        return view($this->style . "System/goodsRecommendClass");
    }

    /**
     * 获取促销版块 单个详情
     */
    public function getGoodsRecommendClass()
    {
        $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : '';
        $platform = new Platform();
        $info = $platform->getPlatformGoodsRecommendClassDetail($class_id);
        return $info;
    }

    /**
     * 搜索商品
     */
    public function searchGoods()
    {
        $goods_name = isset($_POST['goods_name']) ? $_POST['goods_name'] : '';
        $category1 = isset($_POST['category1']) ? $_POST['category1'] : '';
        $where['ng.goods_name'] = array(
            'like',
            '%' . $goods_name . '%'
        );
        $where['ng.category_id_1'] = $category1;
        $where['ng.state'] = 1;
        $where = array_filter($where);
        $goods = new Goods();
        $list = $goods->getGoodsList(1, 0, $where);
        return $list;
    }

    /**
     * 编辑促销版块
     */
    public function updateGoodsRecommendClass()
    {
        $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : 0;
        $class_name = isset($_POST['class_name']) ? $_POST['class_name'] : '';
        $goods_id_array = isset($_POST['goods_id_str']) ? $_POST['goods_id_str'] : '';
        $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
        $platform = new Platform();
        $res = $platform->updatePlatformGoodsRecommendClass($class_id, $class_name, $sort, $goods_id_array);
        return AjaxReturn($res);
    }

    /**
     * 删除 促销版块
     *
     * @return unknown[]
     */
    public function delGoodsRecommendClass()
    {
        $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : 0;
        if ($class_id > 0) {
            $platform = new Platform();
            $res = $platform->deletePlatformGoodsRecommendClass($class_id);
            return AjaxReturn($res);
        } else {
            return AjaxReturn(0);
        }
    }

    /**
     * 首页版块 列表
     */
    public function blockList()
    {
        if (request()->isAjax()) {
            $index = isset($_POST["pageIndex"]) ? $_POST["pageIndex"] : 1;
            $search_text = isset($_POST['search_text']) ? $_POST['search_text'] : '';
            $platform_block = new Platform();
            $block_list = $platform_block->webBlockList($index, PAGESIZE, [
                'block_name' => array(
                    'like',
                    '%' . $search_text . '%'
                )
            ]);
            return $block_list;
        }
        return view($this->style . "System/blockList");
    }

    /**
     * 添加版块
     */
    public function addBlock()
    {
        $platform = new Platform();
        if (request()->isAjax()) {
            $block_name = isset($_POST['block_name']) ? $_POST['block_name'] : '';
            $block_short_name = isset($_POST['block_short_name']) ? $_POST['block_short_name'] : '';
            $block_color = isset($_POST['block_color']) ? $_POST['block_color'] : '';
            $is_display = isset($_POST['is_display']) ? $_POST['is_display'] : 1;
            $sort = isset($_POST['sort']) ? $_POST['sort'] : 0;
            $recommend_ad_image_name = isset($_POST['recommend_ad_image_name']) ? $_POST['recommend_ad_image_name'] : '';
            $recommend_ad_image = isset($_POST['recommend_ad_image']) ? $_POST['recommend_ad_image'] : '';
            $recommend_ad_slide_name = isset($_POST['recommend_ad_slide_name']) ? $_POST['recommend_ad_slide_name'] : '';
            $recommend_ad_slide = isset($_POST['recommend_ad_slide']) ? $_POST['recommend_ad_slide'] : '';
            $recommend_ad_images_name = isset($_POST['recommend_ad_images_name']) ? $_POST['recommend_ad_images_name'] : '';
            $recommend_ad_images = isset($_POST['recommend_ad_images']) ? $_POST['recommend_ad_images'] : '';
            $recommend_brands = isset($_POST['recommend_brands']) ? $_POST['recommend_brands'] : '';
            $recommend_categorys = isset($_POST['recommend_categorys']) ? $_POST['recommend_categorys'] : '';
            $recommend_goods_category_name_1 = isset($_POST['recommend_goods_category_name_1']) ? $_POST['recommend_goods_category_name_1'] : '';
            $recommend_goods_category_1 = isset($_POST['recommend_goods_category_1']) ? $_POST['recommend_goods_category_1'] : '';
            $recommend_goods_category_name_2 = isset($_POST['recommend_goods_category_name_2']) ? $_POST['recommend_goods_category_name_2'] : '';
            $recommend_goods_category_2 = isset($_POST['recommend_goods_category_2']) ? $_POST['recommend_goods_category_2'] : '';
            $recommend_goods_category_name_3 = isset($_POST['recommend_goods_category_name_3']) ? $_POST['recommend_goods_category_name_3'] : '';
            $recommend_goods_category_3 = isset($_POST['recommend_goods_category_3']) ? $_POST['recommend_goods_category_3'] : '';
            $res = $platform->addWebBlock($is_display, $block_color, $sort, $block_name, $block_short_name, $recommend_ad_image_name, $recommend_ad_image, $recommend_ad_slide_name, $recommend_ad_slide, $recommend_ad_images_name, $recommend_ad_images, $recommend_brands, $recommend_categorys, $recommend_goods_category_name_1, $recommend_goods_category_1, $recommend_goods_category_name_2, $recommend_goods_category_2, $recommend_goods_category_name_3, $recommend_goods_category_3);
            return AjaxReturn($res);
        }
        // 获取所有品牌
        $goods_brand = new GoodsBrand();
        $goods_brand_list = $goods_brand->getGoodsBrandList(1, 0);
        $this->assign('goods_brand_list', $goods_brand_list['data']);
        // 获取所有的三级分类
        $goods_category = new GoodsCategory();
        $goods_three_category_list = $goods_category->getGoodsCategoryList(1, 0, [
            'level' => 3,
            'is_visible' => 1
        ]);
        $this->assign('goods_category_list', $goods_three_category_list['data']);
        // 获取单图 $recommend_ad_image_list， 多图$recommend_ad_images_list， 幻灯片$recommend_ad_slide_list 广告位
        $recommend_ad_image_list = $platform->getPlatformAdvPositionList(1, 0, [
            'ap_display' => 2,
            'is_use' => 1
        ]);
        $this->assign('recommend_ad_image_list', $recommend_ad_image_list['data']);
        $recommend_ad_images_list = $platform->getPlatformAdvPositionList(1, 0, [
            'ap_display' => 1,
            'is_use' => 1
        ]);
        $this->assign('recommend_ad_images_list', $recommend_ad_images_list['data']);
        $recommend_ad_slide_list = $platform->getPlatformAdvPositionList(1, 0, [
            'ap_display' => 0,
            'is_use' => 1
        ]);
        $this->assign('recommend_ad_slide_list', $recommend_ad_slide_list['data']);
        return view($this->style . "System/addBlock");
    }

    /**
     * 修改 版块
     */
    public function updateBlock()
    {
        $platform = new Platform();
        if (request()->isAjax()) {
            $block_id = isset($_POST['block_id']) ? $_POST['block_id'] : '';
            $block_name = isset($_POST['block_name']) ? $_POST['block_name'] : '';
            $block_short_name = isset($_POST['block_short_name']) ? $_POST['block_short_name'] : '';
            $block_color = isset($_POST['block_color']) ? $_POST['block_color'] : '';
            $is_display = isset($_POST['is_display']) ? $_POST['is_display'] : 1;
            $sort = isset($_POST['sort']) ? $_POST['sort'] : 0;
            $recommend_ad_image_name = isset($_POST['recommend_ad_image_name']) ? $_POST['recommend_ad_image_name'] : '';
            $recommend_ad_image = isset($_POST['recommend_ad_image']) ? $_POST['recommend_ad_image'] : '';
            $recommend_ad_slide_name = isset($_POST['recommend_ad_slide_name']) ? $_POST['recommend_ad_slide_name'] : '';
            $recommend_ad_slide = isset($_POST['recommend_ad_slide']) ? $_POST['recommend_ad_slide'] : '';
            $recommend_ad_images_name = isset($_POST['recommend_ad_images_name']) ? $_POST['recommend_ad_images_name'] : '';
            $recommend_ad_images = isset($_POST['recommend_ad_images']) ? $_POST['recommend_ad_images'] : '';
            $recommend_brands = isset($_POST['recommend_brands']) ? $_POST['recommend_brands'] : '';
            $recommend_categorys = isset($_POST['recommend_categorys']) ? $_POST['recommend_categorys'] : '';
            $recommend_goods_category_name_1 = isset($_POST['recommend_goods_category_name_1']) ? $_POST['recommend_goods_category_name_1'] : '';
            $recommend_goods_category_1 = isset($_POST['recommend_goods_category_1']) ? $_POST['recommend_goods_category_1'] : '';
            $recommend_goods_category_name_2 = isset($_POST['recommend_goods_category_name_2']) ? $_POST['recommend_goods_category_name_2'] : '';
            $recommend_goods_category_2 = isset($_POST['recommend_goods_category_2']) ? $_POST['recommend_goods_category_2'] : '';
            $recommend_goods_category_name_3 = isset($_POST['recommend_goods_category_name_3']) ? $_POST['recommend_goods_category_name_3'] : '';
            $recommend_goods_category_3 = isset($_POST['recommend_goods_category_3']) ? $_POST['recommend_goods_category_3'] : '';
            $res = $platform->updateWebBlock($block_id, $is_display, $block_color, $sort, $block_name, $block_short_name, $recommend_ad_image_name, $recommend_ad_image, $recommend_ad_slide_name, $recommend_ad_slide, $recommend_ad_images_name, $recommend_ad_images, $recommend_brands, $recommend_categorys, $recommend_goods_category_name_1, $recommend_goods_category_1, $recommend_goods_category_name_2, $recommend_goods_category_2, $recommend_goods_category_name_3, $recommend_goods_category_3);
            return AjaxReturn($res);
        }
        $block_id = isset($_GET['block_id']) ? $_GET['block_id'] : '';
        // 获取所有品牌
        $goods_brand = new GoodsBrand();
        $goods_brand_list = $goods_brand->getGoodsBrandList(1, 0);
        $this->assign('goods_brand_list', $goods_brand_list['data']);
        // 获取所有的三级分类
        $goods_category = new GoodsCategory();
        $goods_three_category_list = $goods_category->getGoodsCategoryList(1, 0, [
            'level' => 3,
            'is_visible' => 1
        ]);
        $this->assign('goods_category_list', $goods_three_category_list['data']);
        // 获取单图 $recommend_ad_image_list， 多图$recommend_ad_images_list， 幻灯片$recommend_ad_slide_list 广告位
        $recommend_ad_image_list = $platform->getPlatformAdvPositionList(1, 0, [
            'ap_display' => 2,
            'is_use' => 1
        ]);
        $this->assign('recommend_ad_image_list', $recommend_ad_image_list['data']);
        $recommend_ad_images_list = $platform->getPlatformAdvPositionList(1, 0, [
            'ap_display' => 1,
            'is_use' => 1
        ]);
        $this->assign('recommend_ad_images_list', $recommend_ad_images_list['data']);
        $recommend_ad_slide_list = $platform->getPlatformAdvPositionList(1, 0, [
            'ap_display' => 0,
            'is_use' => 1
        ]);
        $this->assign('recommend_ad_slide_list', $recommend_ad_slide_list['data']);
        // 获取详情
        $block_info = $platform->getWebBlockDetail($block_id);
        $this->assign('block_info', $block_info['base_info']);
        return view($this->style . "System/updateBlock");
    }
}   