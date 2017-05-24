<?php
/**
 * Platform.php
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
use data\service\BaseService;
use data\model\niushop\NsPlatformAdvPositionModel as NsPlatformAdvPositionModel;
use data\model\niushop\NsPlatformAdvModel as NsPlatformAdvModel;
use data\model\niushop\NsPlatformLinkModel;
use data\model\niushop\NsPlatformBlockModel as NsPlatformBlockModel;
use data\model\niushop\NsGoodsBrandModel as NsGoodsBrandModel;
use data\model\niushop\NsGoodsCategoryModel as NsGoodsCategoryModel;
use data\model\niushop\NsGoodsModel as NsGoodsModel;
use data\model\system\AlbumPictureModel as AlbumPictureModel;
use data\api\niushop\IPlatform;
use data\model\niushop\NsPlatformHelpClassModel;
use data\model\niushop\NsPlatformHelpDocumentModel;
use data\model\niushop\NsPlatformGoodsRecommendModel;
use data\model\niushop\NsPlatformGoodsRecommendClassModel;
use data\model\niushop\NsAccountModel;
use data\model\niushop\NsAccountRecordsModel;
use data\model\niushop\NsShopModel;
use data\model\niushop\NsShopAccountRecordsModel;
use data\model\niushop\NsAccountReturnRecordsModel;
use data\model\niushop\NsOrderGoodsModel;
use data\model\niushop\NsOrderGoodsPromotionDetailsModel;
use data\model\niushop\NsShopOrderGoodsAccountViewModel;
use think\Log;
/**
 * 
 */
class Platform extends BaseService implements IPlatform
{
	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getLinkList()
     */
    public function getLinkList($page_index=1, $page_size=0, $where='', $order='', $field='*' )
    {
        $link = new NsPlatformLinkModel();
        $list = $link->pageQuery($page_index, $page_size, $where, $order, $field);
        return $list;
        
    }
    /**
     * {@inheritDoc}
     * @see \data\api\niushop\IPlatform::getLinkDetail()
     */
    public function getLinkDetail($link_id){
        $link = new NsPlatformLinkModel();
        $info = $link->get($link_id);
        return $info;
    }
	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::addLink()
     */
    public function addLink($link_title, $link_url, $link_pic, $link_sort)
    {
        $data = array(
            'link_title' => $link_title,
            'link_url'   => $link_url,
            'link_pic'   => $link_pic,
            'link_sort'  => $link_sort
        );
        $link = new NsPlatformLinkModel();
        $link->save($data);
        return $link->link_id;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::updateLink()
     */
    public function updateLink($link_id, $link_title, $link_url, $link_pic, $link_sort)
    {
        $data = array(
            'link_title' => $link_title,
            'link_url'   => $link_url,
            'link_pic'   => $link_pic,
            'link_sort'  => $link_sort
        );
        $link = new NsPlatformLinkModel();
        $retval = $link->save($data,['link_id' => $link_id]);
        return $retval;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::deleteLink()
     */
    public function deleteLink($link_id)
    {
        $link = new NsPlatformLinkModel();
        $retval = $link->destroy($link_id);
        return $retval;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getAdList()
     */
    public function getAdList($page_index=1, $page_size=0, $where='', $order='', $field='*' )
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::addAd()
     */
    public function addAd($ad_image, $link_url, $sort)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::updateAd()
     */
    public function updateAd($id, $ad_image, $link_url, $sort)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getAdDetail()
     */
    public function getAdDetail($id)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::delAd()
     */
    public function delAd($id)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::webBlockList()
     */
    public function webBlockList($page_index=1, $page_size=0, $where='', $order='', $field='*' )
    {
        $block = new NsPlatformBlockModel();
        $list = $block->pageQuery($page_index, $page_size, $where, $order, $field);
        return $list;
    }
    /**
     * {@inheritDoc}
     * @see \data\api\niushop\IPlatform::getWebBlockListDetail()
     */
    public function getWebBlockListDetail(){
        $block = new NsPlatformBlockModel();
        $block_list = $this->webBlockList(1, 0, ['is_display'=>1], 'sort', 'block_id, block_data');
        $list = array();
        foreach ($block_list['data'] as $k=>$v){
            $list[] = json_decode($v['block_data'], true);
        }
        return $list;
    }
	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::addWebBlock()
     */
    public function addWebBlock($is_display, $block_color, $sort, $block_name, $block_short_name, $recommend_ad_image_name, $recommend_ad_image, $recommend_ad_slide_name, $recommend_ad_slide,
        $recommend_ad_images_name, $recommend_ad_images, $recommend_brands, $recommend_categorys, $recommend_goods_category_name_1, $recommend_goods_category_1, $recommend_goods_category_name_2, $recommend_goods_category_2, $recommend_goods_category_name_3, $recommend_goods_category_3){
        $data = array(
            'is_display'                            =>   $is_display,
            'block_color'                          =>   $block_color,
            'sort'                                 =>   $sort,
            'create_time'                          =>   date("Y-m-d H:i:s", time()),
            'modify_time'                          =>   date("Y-m-d H:i:s", time()),
            'block_name'                           =>   $block_name,
            'block_short_name'                     =>   $block_short_name,
            'recommend_ad_image_name'              =>   $recommend_ad_image_name,
            'recommend_ad_image'                   =>   $recommend_ad_image,
            'recommend_ad_slide_name'              =>   $recommend_ad_slide_name,
            'recommend_ad_slide'                   =>   $recommend_ad_slide,
            'recommend_ad_images_name'             =>   $recommend_ad_images_name,
            'recommend_ad_images'                  =>   $recommend_ad_images,
            'recommend_brands'                     =>   $recommend_brands,
            'recommend_categorys'                  =>   $recommend_categorys,
            'recommend_goods_category_name_1'      =>   $recommend_goods_category_name_1,
            'recommend_goods_category_1'           =>   $recommend_goods_category_1,
            'recommend_goods_category_name_2'      =>   $recommend_goods_category_name_2,
            'recommend_goods_category_2'           =>   $recommend_goods_category_2,
            'recommend_goods_category_name_3'      =>   $recommend_goods_category_name_3,
            'recommend_goods_category_3'           =>   $recommend_goods_category_3,
            'shop_id'                              =>   $this->instance_id
        );
        $block = new NsPlatformBlockModel();
        $block->save($data);
        $block_data = $this->getWebBlockDetail($block->block_id);
        $block_data = json_encode($block_data);
        $data_block = array(
            'block_data' => $block_data
        );
        $block->save($data_block, ['block_id' => $block->block_id]);
        return $block->block_id;
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::updateWebBlock()
     */
    public function updateWebBlock($block_id, $is_display, $block_color, $sort, $block_name, $block_short_name, $recommend_ad_image_name, $recommend_ad_image, $recommend_ad_slide_name, $recommend_ad_slide, $recommend_ad_images_name, $recommend_ad_images, $recommend_brands, $recommend_categorys, $recommend_goods_category_name_1, $recommend_goods_category_1, $recommend_goods_category_name_2, $recommend_goods_category_2, $recommend_goods_category_name_3, $recommend_goods_category_3){
        $data = array(
            'is_display'                            =>   $is_display,
            'block_color'                          =>   $block_color,
            'sort'                                 =>   $sort,
            'modify_time'                          =>   date("Y-m-d H:i:s", time()),
            'block_name'                           =>   $block_name,
            'block_short_name'                     =>   $block_short_name,
            'recommend_ad_image_name'              =>   $recommend_ad_image_name,
            'recommend_ad_image'                   =>   $recommend_ad_image,
            'recommend_ad_slide_name'              =>   $recommend_ad_slide_name,
            'recommend_ad_slide'                   =>   $recommend_ad_slide,
            'recommend_ad_images_name'             =>   $recommend_ad_images_name,
            'recommend_ad_images'                  =>   $recommend_ad_images,
            'recommend_brands'                     =>   $recommend_brands,
            'recommend_categorys'                  =>   $recommend_categorys,
            'recommend_goods_category_name_1'      =>   $recommend_goods_category_name_1,
            'recommend_goods_category_1'           =>   $recommend_goods_category_1,
            'recommend_goods_category_name_2'      =>   $recommend_goods_category_name_2,
            'recommend_goods_category_2'           =>   $recommend_goods_category_2,
            'recommend_goods_category_name_3'      =>   $recommend_goods_category_name_3,
            'recommend_goods_category_3'           =>   $recommend_goods_category_3
        );
        $block = new NsPlatformBlockModel();
        $res = $block->save($data, ['block_id' => $block_id]);
        $block_data = $this->getWebBlockDetail($block_id);
        $block_data = json_encode($block_data);
        $data_block = array(
            'block_data' => $block_data
        );
        $block->save($data_block, ['block_id' => $block_id]);
        return $res;
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::deleteWebBlock()
     */
    public function deleteWebBlock($block_id)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getWebBlockDetail()
     */
    public function getWebBlockDetail($block_id)
    {
        $platform_block = new NsPlatformBlockModel();
        $info['base_info'] = array();
        $info['brand_list'] = array();
        $info['category_list'] = array();
        $info['goods_list_1'] = array();
        $info['goods_list_2'] = array();
        $info['goods_list_3'] = array();
        $info['recommend_ad_image'] = array();
        $info['recommend_ad_slide'] = array();
        $info['recommend_ad_images'] = array();
        $base_info = $platform_block->get($block_id);
        $info['base_info'] = $base_info;
        if(!empty($base_info)){
            if(!empty($base_info['recommend_brands'])){
                //推荐品牌列表
                $goods_brand = new NsGoodsBrandModel();
                $recommend_brands = $goods_brand->where('brand_id','in',$base_info['recommend_brands'])->select();
                $info['brand_list'] = $recommend_brands;
            }
            if(!empty($base_info['recommend_categorys'])){
                //推荐分类列表
                $goods_category = new NsGoodsCategoryModel();
                $recommend_categorys = $goods_category->where('category_id','in',$base_info['recommend_categorys'])->select();
                $info['category_list'] = $recommend_categorys;
            }
            //第一个 商品分类列表（根据商品分类id查询）
            if(!empty($base_info['recommend_goods_category_1'])){
                $goods = new NsGoodsModel();
                $goods_list_1 = $goods->where('category_id_3 = '.$base_info['recommend_goods_category_1'])->limit(6)->select();
                if(!empty($goods_list_1)){
                    foreach ($goods_list_1 as $k=>$v){
                        $picture = new AlbumPictureModel();
                        $pic_info = array();
                        $pic_info['pic_cover'] = '';
                        if( !empty($v['picture'])){
                            $pic_info = $picture->get($v['picture']);
                        }
                        $v['picture_detail'] = $pic_info;
                    }
                }
                $info['goods_list_1'] = $goods_list_1;
            }
            //第二个 商品分类列表（根据商品分类id查询）
            if(!empty($base_info['recommend_goods_category_2'])){
                $goods = new NsGoodsModel();
                $goods_list_2 = $goods->where('category_id_3 = '.$base_info['recommend_goods_category_2'])->limit(6)->select();
                if(!empty($goods_list_2)){
                    foreach ($goods_list_2 as $k=>$v){
                        $picture = new AlbumPictureModel();
                        $pic_info = array();
                        $pic_info['pic_cover'] = '';
                        if( !empty($v['picture'])){
                            $pic_info = $picture->get($v['picture']);
                        }
                        $v['picture_detail'] = $pic_info;
                    }
                }
                $info['goods_list_2'] = $goods_list_2;
            }
            //第三个 商品分类列表（根据商品分类id查询）
            if(!empty($base_info['recommend_goods_category_3'])){
                $goods = new NsGoodsModel();
                $goods_list_3 = $goods->where('category_id_3 = '.$base_info['recommend_goods_category_3'])->limit(6)->select();
                if(!empty($goods_list_3)){
                    foreach ($goods_list_3 as $k=>$v){
                        $picture = new AlbumPictureModel();
                        $pic_info = array();
                        $pic_info['pic_cover'] = '';
                        if( !empty($v['picture'])){
                            $pic_info = $picture->get($v['picture']);
                        }
                        $v['picture_detail'] = $pic_info;
                    }
                }
                $info['goods_list_3'] = $goods_list_3;
            }
            //获取单广告位详情
            if(!empty($base_info['recommend_ad_image'])){
                $recommend_ad_image = $this->getPlatformAdvPositionDetail($base_info['recommend_ad_image']);
                $info['recommend_ad_image'] = $recommend_ad_image;
            }
            //幻灯广告位
            if(!empty($base_info['recommend_ad_slide'])){
                $recommend_ad_slide = $this->getPlatformAdvPositionDetail($base_info['recommend_ad_slide']);
                $info['recommend_ad_slide'] = $recommend_ad_slide;
            }
            $t8 = time();
            //多图广告位
            if(!empty($base_info['recommend_ad_images'])){
                $recommend_ad_images = $this->getPlatformAdvPositionDetail($base_info['recommend_ad_images']);
                $info['recommend_ad_images'] = $recommend_ad_images;
            }
        }
        return $info;
    }

    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getPlatformAdvList()
     */
    public function getPlatformAdvList($page_index=1, $page_size=0, $where='', $order='', $field='*' )
    {
        $platform_adv = new NsPlatformAdvModel();
        $result = $platform_adv->pageQuery($page_index, $page_size, $where, $order, $field);
        foreach ($result['data'] as $k => $v){
            $platform_adv_position = new NsPlatformAdvPositionModel();
            $result['data'][$k]['ap_info'] = $platform_adv_position->get($v['ap_id']);
        }
        return $result;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getPlatformAdvPositionList()
     */
    public function getPlatformAdvPositionList($page_index=1, $page_size=0, $where='', $order='', $field='*' )
    {
        $platform_adv_position = new NsPlatformAdvPositionModel();
        $result = $platform_adv_position->pageQuery($page_index, $page_size, $where, $order, $field);
        foreach ($result['data'] as $k=>$v){
            if($v['ap_class'] == 0){
                $result['data'][$k]['ap_class_name'] = '图片';
            }else if($v['ap_class'] == 1){
                $result['data'][$k]['ap_class_name'] = '文字';
            }else if($v['app_class'] == 2){
                $result['data'][$k]['ap_class_name'] = '幻灯';
            }else if($v['ap_class'] == 3){
                $result['data'][$k]['ap_class_name'] = 'flash';
            }else{
                $result['data'][$k]['ap_class_name'] = '';
            }
            if($v['ap_display'] == 0){
                $result['data'][$k]['ap_display_name'] = '幻灯片';
            }else if($v['ap_display'] == 1){
                $result['data'][$k]['ap_display_name'] = '多广告展示';
            }else if($v['ap_display'] == 2){
                $result['data'][$k]['ap_display_name'] = '单广告展示';
            }else{
                $result['data'][$k]['ap_display_name'] = '';
            }
        }
        return $result;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::addPlatformAdv()
     */
    public function addPlatformAdv($ap_id, $adv_title, $adv_url, $adv_image, $slide_sort, $background)
    {
        $platform_adv = new NsPlatformAdvModel();
        $data = array(
            'ap_id'           => $ap_id,
            'adv_title'       => $adv_title,
            'adv_url'         => $adv_url,
            'adv_image'       => $adv_image,
            'slide_sort'      => $slide_sort,
            'background'      => $background
        );
        $res = $platform_adv->save($data);
        return $res;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::addPlatformAdvPosition()
     */
    public function addPlatformAdvPosition($instance_id, $ap_name, $ap_intro, $ap_class, $ap_display, $is_use, $ap_height, $ap_width, $default_content, $ap_background_color, $type)
    {
        $platform_adv_position = new NsPlatformAdvPositionModel();
        $data = array(
            'instance_id'       => $instance_id,
            'ap_name'           => $ap_name,
            'ap_intro'          => $ap_intro,
            'ap_class'          => $ap_class,
            'ap_display'        => $ap_display,
            'is_use'            => $is_use,
            'ap_height'         => $ap_height,
            'ap_width'          => $ap_width,
            'default_content'   => $default_content,
            'ap_background_color'   => $ap_background_color,
            'type'   => $type,
        );
        $res = $platform_adv_position->save($data);
        return $res;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::updatePlatformAdv()
     */
    public function updatePlatformAdv($adv_id, $ap_id, $adv_title, $adv_url, $adv_image, $slide_sort, $background)
    {
        $platform_adv = new NsPlatformAdvModel();
        $data = array(
            'ap_id'           => $ap_id,
            'adv_title'       => $adv_title,
            'adv_url'         => $adv_url,
            'adv_image'       => $adv_image,
            'slide_sort'      => $slide_sort,
            'background'      => $background
        );
        $res = $platform_adv->save($data, ['adv_id' => $adv_id]);
        return $res;
    }
    /**
     * {@inheritDoc}
     * @see \data\api\niushop\IPlatform::updateAdvSlideSort()
     */
    public function updateAdvSlideSort($adv_id, $slide_sort)
    {
        $platform_adv = new NsPlatformAdvModel();
        $data = array(
            'adv_id'           => $adv_id,
            'slide_sort'      => $slide_sort
        );
        $res = $platform_adv->save($data, ['adv_id' => $adv_id]);
        return $res;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::updatePlatformAdvPosition()
     */
    public function updatePlatformAdvPosition($ap_id, $instance_id, $ap_name, $ap_intro, $ap_class, $ap_display, $is_use, $ap_height, $ap_width, $default_content, $ap_background_color, $type)
    {
        $platform_adv_position = new NsPlatformAdvPositionModel();
        $data = array(
            'ap_name' => $ap_name,
            'instance_id' => $instance_id,
            'ap_intro' => $ap_intro,
            'ap_class' => $ap_class,
            'ap_display' => $ap_display,
            'is_use' => $is_use,
            'ap_height' => $ap_height,
            'ap_width' => $ap_width,
            'default_content' => $default_content,
            'ap_background_color' => $ap_background_color,
            'type' => $type,
        );
        $res = $platform_adv_position->save($data, ['ap_id' => $ap_id]);
        return $res;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::deletePlatformAdv()
     */
    public function deletePlatformAdv($adv_id)
    {
        $platform_adv = new NsPlatformAdvModel();
        $res = $platform_adv->destroy($adv_id);
        return $res;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getPlatformAdvPositionDetail()
     */
    public function getPlatformAdvPositionDetail($ap_id){
        $platform_adv_position = new NsPlatformAdvPositionModel();
        $info = $platform_adv_position->getInfo(['ap_id' => $ap_id]);
        $platform_adv_list = $this->getPlatformAdvList(1,0,['ap_id'=>$info['ap_id']]);
        $info['adv_list'] = $platform_adv_list['data'];
        return $info;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getPlatformAdDetail()
     */
    public function getPlatformAdDetail($adv_id){
        $platform_adv = new NsPlatformAdvModel();
        $info = $platform_adv->getInfo(['adv_id' => $adv_id]);
        return $info;
    }
	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getPlatformHelpClassList()
     */
    public function getPlatformHelpClassList($page_index = 1, $page_size = 0, $where = '', $order = '', $field = '*')
    {
        $platform_class = new NsPlatformHelpClassModel();
        $list = $platform_class->pageQuery($page_index, $page_size, $where, $order, $field);
        return $list;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getPlatformHelpDocumentList()
     */
//     public function getPlatformHelpDocumentList($page_index = 1, $page_size = 0, $where = '', $order = '', $field = '*')
//     {
//         $platform_document = new NsPlatformHelpDocumentModel();
//         $list = $platform_document->pageQuery($page_index, $page_size, $where, $order, $field);
       
//         return $list;
//         // TODO Auto-generated method stub
        
//     } 
    public function getPlatformHelpDocumentList($page_index = 1, $page_size = 0, $where = '', $order = '', $field = '*')
    {
        $platform_document = new NsPlatformHelpDocumentModel();
        $list = $platform_document->getPlatformHelpDocumentViewList($page_index, $page_size, $where, $order);
         
        return $list;
        // TODO Auto-generated method stub
    
    }

    /**
     * 获取列表返回数据格式
     * @param unknown $page_index
     * @param unknown $page_size
     * @param unknown $condition
     * @param unknown $order
     * @return unknown
     */
 /*    public function getPlatformHelpDocumentList($page_index, $page_size, $condition, $order, $field='*'){
       // $platform_document = new NsPlatformHelpDocumentModel();
       // $list = $platform_document->getPlatformHelpDocumentViewList($page_index, $page_size, $condition, $order);
//         $queryCount = $this->getGoodsrViewCount($condition);
//         $list = $this->setReturnList($queryList, $queryCount, $page_size);
        return 1;
    } */
    

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::addPlatformHelpClass()
     */
    public function addPlatformHelpClass($type, $class_name, $parent_class_id, $sort)
    {
        $data = array(
            'type'          => $type,
            'class_name'    => $class_name,
            'parent_class_id'  => $parent_class_id,
            'sort'          => $sort
        );
        $platform_class = new NsPlatformHelpClassModel();
        $platform_class->save($data);
        return $platform_class->class_id;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::updatePlatformClass()
     */
    public function updatePlatformClass($class_id, $type, $class_name, $parent_class_id, $sort)
    {
        $data = array(
            'type'          => $type,
            'class_name'    => $class_name,
            'parent_class_id'  => $parent_class_id,
            'sort'          => $sort
        );
        $platform_class = new NsPlatformHelpClassModel();
        $retval = $platform_class->save($data, ['class_id' => $class_id]);
        return $retval;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::addPlatformDocument()
     */
    public function addPlatformDocument($uid, $class_id, $title, $link_url, $sort, $content, $image)
    {
        $data = array(
            'uid'           => $uid,
            'class_id'      => $class_id,
            'title'         => $title,
            'link_url'      => $link_url,
            'sort'          => $sort,
            'content'       => $content,
            'image'         => $image,
            'create_time'   => date("Y-m-d H:i:s", time()),
            'modufy_time'   => date("Y-m-d H:i:s", time())
        );
        $platform_document = new NsPlatformHelpDocumentModel();
        $platform_document->save($data);
        return $platform_document->id;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::updatePlatformDocument()
     */
    public function updatePlatformDocument($id, $uid, $class_id, $title, $link_url, $sort, $content, $image)
    {
        $data = array(
            'uid'           => $uid,
            'class_id'      => $class_id,
            'title'         => $title,
            'link_url'      => $link_url,
            'sort'          => $sort,
            'content'       => $content,
            'image'         => $image,
            'modufy_time'   => date("Y-m-d H:i:s", time())
        );
        $platform_document = new NsPlatformHelpDocumentModel();
        $retval = $platform_document->save($data, ['id' => $id]);
        return $retval;
        // TODO Auto-generated method stub
        
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getPlatformDocumentDetail()
     */
    public function getPlatformDocumentDetail($id)
    {
        $platform_document = new NsPlatformHelpDocumentModel();
        $data = $platform_document->get($id);
        return $data;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getPlatformClassDetail()
     */
    public function getPlatformClassDetail($class_id){
       $platform_class = new NsPlatformHelpClassModel();
        $data = $platform_class->get($class_id);
        return $data;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getPlatformGoodsList()
     */
    public function getPlatformGoodsList($page_index=1, $page_size=0, $where='', $order='')
    {
        $goods = new Goods();
        $list = $goods->getGoodsList($page_index, $page_size, $where, $order);
        if(!empty($list['data']))
        {
            foreach ($list['data'] as $k => $v)
            {
                $list['data'][$k]['is_best'] = $this->getGoodsIsBest($v['goods_id']);
                $list['data'][$k]['is_hot'] = $this->getGoodsIshot($v['goods_id']);
                $list['data'][$k]['is_new'] = $this->getGoodsIsnew($v['goods_id']);
            }
        }
        return $list;
        
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getPlatformGoodsRecommend()
     */
    public function getPlatformGoodsRecommend($type)
    {
        $platform_goods_recommend = new NsPlatformGoodsRecommendModel();
        $list = $platform_goods_recommend->getQuery(['class_id'=>$type], '*', 'create_time desc');
        if(!empty($list))
        foreach ($list as $k=> $v)
        {
            $goods = new NsGoodsModel();
            $goods_info = $goods->get($v['goods_id']);
           $album = new AlbumPictureModel();
           $picture_info = $album->getInfo(['pic_id' => $goods_info['picture']], '*');
           $list[$k]['picture_info'] = $picture_info;
           $list[$k]['goods_info'] = $goods_info;
        }
        return $list;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getGoodsIsBest()
     */
    public function getGoodsIsBest($goods_id)
    {
        $platform_goods_recommend = new NsPlatformGoodsRecommendModel();
        $count = $platform_goods_recommend->where(['goods_id' => $goods_id, 'class_id' => 2])->count();
        return $count;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getGoodsIshot()
     */
    public function getGoodsIshot($goods_id){
        $platform_goods_recommend = new NsPlatformGoodsRecommendModel();
        $count = $platform_goods_recommend->where(['goods_id' => $goods_id, 'class_id' => 3])->count();
        return $count;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getGoodsIsnew()
     */
    public function getGoodsIsnew($goods_id)
    {
        $platform_goods_recommend = new NsPlatformGoodsRecommendModel();
        $count = $platform_goods_recommend->where(['goods_id' => $goods_id, 'class_id' => 1])->count();
        return $count;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::modifyGoodsRecommend()
     */
    public function modifyGoodsRecommend($goods_id, $type, $is_recommend)
    {
        $platform_goods_recommend = new NsPlatformGoodsRecommendModel();
        if($is_recommend == 1)
        {
            $platform_goods_recommend = new NsPlatformGoodsRecommendModel();
            $count = $platform_goods_recommend->where(['goods_id' => $goods_id, 'class_id' => $type])->count();
            if($count > 0)
            {
                $retval = $platform_goods_recommend->save(['state'=> 1], ['goods_id' => $goods_id, 'class_id' => $type]);
            }else{
                $retval = $platform_goods_recommend->save(['goods_id' => $goods_id, 'class_id' => $type, 'state' => 1]);
            }
        }else{
            $platform_goods_recommend = new NsPlatformGoodsRecommendModel();
            $retval = $platform_goods_recommend->destroy(['goods_id' => $goods_id, 'class_id' => $type]);
        }
        return $retval;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::addPlatformGoodsRecommendClass()
     */
    public function addPlatformGoodsRecommendClass($class_name, $sort)
    {
        $data = array(
            'class_name' => $class_name,
            'class_type' => 2,
            'sort'       => $sort
            );
        $platform_goods_recommend_class = new NsPlatformGoodsRecommendClassModel();
        $retval = $platform_goods_recommend_class->save($data);
        return $retval;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::updatePlatformGoodsRecommendClass()
     */
    public function updatePlatformGoodsRecommendClass($class_id, $class_name, $sort, $goods_id_array)
    {
        $platform_goods_recommend_class = new NsPlatformGoodsRecommendClassModel();
        $platform_goods_recommend_class->startTrans();
        try {
            if($class_id > 0){
                //修改店铺商品推荐类别
                $data = array(
                    'class_name' => $class_name,
                    'sort'       => $sort
                );
                $retval = $platform_goods_recommend_class->save($data, ['class_id' => $class_id]);
                //先删除掉已有的
                $platform_goods_recommend = new NsPlatformGoodsRecommendModel();
                $platform_goods_recommend->destroy(['class_id'=>$class_id]);
                $new_class_id = $class_id;
            }else{
                $data = array(
                    'class_name' => $class_name,
                    'class_type' => 2,
                    'is_use' => 1,
                    'sort'       => $sort,
                    'shop_id'    => $this->instance_id
                );
                $retval = $platform_goods_recommend_class->save($data);
                $new_class_id = $platform_goods_recommend_class->class_id;
            }
            //添加平台推荐商品
            $goods_id_array = explode(',', $goods_id_array);
            foreach ($goods_id_array as $k=>$v){
                $data = array(
                    'goods_id' => $v,
                    'state' => 1,
                    'class_id' => $new_class_id,
                    'create_time' => date('Y-m-d H:i:s', time()),
                    'modify_time' => date('Y-m-d H:i:s', time()),
                );
                $platform_goods_recommend = new NsPlatformGoodsRecommendModel();
                $res = $platform_goods_recommend->save($data);
            }
            $platform_goods_recommend_class->commit();
            return 1;
        }catch (\Exception $e){
            $platform_goods_recommend_class->rollback();
            return $e->getMessage();
        }
        return 0;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::modifyPlatformGoodsRecommendClassName()
     */
    public function modifyPlatformGoodsRecommendClassName($class_id, $class_name)
    {
        $data = array(
            'class_name' => $class_name
        );
        $platform_goods_recommend_class = new NsPlatformGoodsRecommendClassModel();
        $retval = $platform_goods_recommend_class->save($data, ['class_id' => $class_id]);
        return $retval;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::modifyPlatformGoodsRecommendClassSort()
     */
    public function modifyPlatformGoodsRecommendClassSort($class_id, $sort)
    {
        $data = array(
            'sort'       => $sort
        );
        $platform_goods_recommend_class = new NsPlatformGoodsRecommendClassModel();
        $retval = $platform_goods_recommend_class->save($data, ['class_id' => $class_id]);
        return $retval;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getPlatformGoodsRecommendClass()
     */
    public function getPlatformGoodsRecommendClass()
    {
        $platform_goods_recommend_class = new NsPlatformGoodsRecommendClassModel();
        $class_list = $platform_goods_recommend_class->getQuery(['class_type'=> 2, 'is_use'=> 1], '*', 'sort');
        if(!empty($class_list))
        {
            foreach ($class_list as $k => $v)
            {
                $goods_list = $this->getPlatformGoodsRecommend($v['class_id']);
                $class_list[$k]['goods_list'] = $goods_list;
            }
        }
        return $class_list;
    }
    /**
     * {@inheritDoc}
     * @see \data\api\niushop\IPlatform::getPlatformGoodsRecommendClassDetail()
     */
    public function getPlatformGoodsRecommendClassDetail($class_id){
        $platform_goods_recommend_class = new NsPlatformGoodsRecommendClassModel();
        $class_info = $platform_goods_recommend_class->get($class_id);
        $goods_list = $this->getPlatformGoodsRecommend($class_id);
        $class_info['goods_list'] = $goods_list;
        return $class_info;
    
    }
    public function deletePlatformGoodsRecommendClass($class_id){
        $platform_goods_recommend_class = new NsPlatformGoodsRecommendClassModel();
        $platform_goods_recommend_class->startTrans();
        try {
            $platform_goods_recommend_class->destroy($class_id);
            $platform_goods_recommend = new NsPlatformGoodsRecommendModel();
            $platform_goods_recommend->destroy(['class_id'=>$class_id]);
            $platform_goods_recommend_class->commit();
            return 1;
        }catch (\Exception $e){
            $platform_goods_recommend_class->rollback();
            return $e->getMessage();
        }
        return 0;
    }
	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getAccountCount()
     */
    public function getAccountCount()
    {
        // TODO Auto-generated method stub
        $account = new NsAccountModel();
        $account_info = $account->get(1);
        return $account_info;
    }
    public function  getPlatformAccountMonthRecord(){
        $begin = date('Y-m-01', strtotime(date("Y-m-d")));
        $end = date('Y-m-d', strtotime("$begin +1 month -1 day"));
        $account_records = new NsAccountRecordsModel();
        $condition["create_time"] = [
            [
                ">",
                $begin
            ],
            [
                "<",
                $end
            ]
        ];
        $account_records_list = $account_records->all($condition);
        $begintime = strtotime($begin);
        $endtime = strtotime($end);
        $list= array();
        for ($start = $begintime; $start <= $endtime; $start += 24 * 3600) {
            $list[date("d",$start)] =array();
            $money = 0;
            foreach($account_records_list as $v){
                if(date("Y-m-d",strtotime($v["create_time"]))== date("Y-m-d",$start) ){
                    $money = $money +$v["money"];                    
                }
            }
            $list[date("d",$start)]["money"] = $money;           
        }
        return $list;
    }
	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getPlatformAccountRecordsList()
     */
    public function getPlatformAccountRecordsList($page_index, $page_size = 0, $condition = '', $order = '')
    {
        // TODO Auto-generated method stub
        $account_records = new NsAccountRecordsModel();
        $list = $account_records->pageQuery($page_index, $page_size, $condition, $order, '*');
        foreach($list["data"] as  $k=>$v){
            $shop = new NsShopModel();
            $shop_info = $shop->getInfo(["shop_id"=>$v["shop_id"]],"*");
            $shop_name = $shop_info["shop_name"];
            $list["data"][$k]["shop_name"] =$shop_name;
        }       
        return $list;
    }
    public function getPlatformCount($start_date, $end_date){
        $statistics = array();
        $account_records = new NsAccountRecordsModel();
        $accountReturnRecords  = new NsAccountReturnRecordsModel(); 
        //订单总额
        $order_total = $account_records->where(array("create_time"=>array(array(">",$start_date),array("<",$end_date)),"account_type"=>1))->sum("money");
        //保证金 （暂无）
        $bond =0;
        //营业额 订单总额+保证金（暂无）..
        $turnover = $order_total + $bond;
        //提现
        $cash_withdrawal_amount = $account_records->where(array("create_time"=>array(array(">",$start_date),array("<",$end_date)),"account_type"=>2))->sum("money");
        //总资金  营业额-提现
        $total = $turnover - $cash_withdrawal_amount;
        //平台余额
        $platform_balance = $accountReturnRecords->where(array("create_time"=>array(array(">",$start_date),array("<",$end_date)),"return_type"=>1))->sum("money");                
        //店铺余额
        $shop_balance = $order_total - $platform_balance;
        $statistics["order_total"] = $order_total;
        $statistics["bond"] = $bond;
        $statistics["turnover"] = $turnover;
        $statistics["cash_withdrawal_amount"] = $cash_withdrawal_amount;
        $statistics["total"] = $total;
        $statistics["platform_balance"] = $platform_balance;
        $statistics["shop_balance"] = $shop_balance;
        return $statistics;
        
    }
	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getShopSalesVolume()
     */
    public function getShopSalesVolume($condition)
    {
        // TODO Auto-generated method stub
        $shop = new NsShopModel();
        $shop_list  = $shop ->all();
        foreach($shop_list as $k=>$v){
            $shop_account_record = new NsShopAccountRecordsModel();
            $shop_sales_volume = $shop_account_record->where(array("shop_id"=>$v["shop_id"],"account_type"=>1,"create_time"=>$condition))->sum("money");
            $shop_list[$k]["sales_volume"] = $shop_sales_volume;
        } 
        return $shop_list;
    }
	/* (non-PHPdoc)
     * @see \data\api\niushop\IPlatform::getGoodsSalesVolume()
     */
    public function getGoodsSalesVolume($condition)
    {
        // TODO Auto-generated method stub
        $goods = new NsGoodsModel();
        $goods_lsit = $goods->all();
        foreach($goods_lsit as $k=>$v){
            $condition["goods_id"] = $v["goods_id"];
            $order_goods = new NsOrderGoodsModel();
            $order_goods_list = $order_goods->all($condition);
            $sale_money = 0;
            $sale_num = 0;
            foreach($order_goods_list as $t=>$b){
                $order_goods_promotion = new NsOrderGoodsPromotionDetailsModel();
                $promotion_money = $order_goods_promotion->where(['order_id' => $b["order_id"], 'sku_id' => $b['sku_id']])->sum('discount_money');
                if(empty($promotion_money))
                {
                    $promotion_money = 0;
                }
                $sale_money =$sale_money + $b["price"] * $b["num"] + $b["adjust_money"] - $b["refund_require_money"] - $promotion_money;              
                $sale_num = $sale_num + $b["num"];
                
            }
            $goods_lsit[$k]["sales_volume"] = $sale_money;
            $goods_lsit[$k]["sales_num"] = $sale_num;
        }
        return $goods_lsit;
    }
    /* (non-PHPdoc)
     * @see \data\api\niushop\IGoodsCategory::getGoodsCategorySaleNum()
     */
    public function getGoodsCategorySaleNum()
    {
        // TODO Auto-generated method stub
        $shop_order_account_records_view = new NsShopOrderGoodsAccountViewModel();
        $goods_goods_category = new NsGoodsCategoryModel();
        $goods_goods_category_all = $goods_goods_category->all();
        foreach($goods_goods_category_all as $k=>$v){
            $sale_num = 0;
            $goods_model = new NsGoodsModel();
            $goods_sale_num = $goods_model->where(array("category_id_1|category_id_2|category_id_3"=>$v["category_id"]))->sum("sales");
            $goods_goods_category_all[$k]["sale_num"] = $goods_sale_num;
        }
        return  $goods_goods_category_all;
    }




    
}