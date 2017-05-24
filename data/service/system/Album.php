<?php
/**
 * Album.php
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
 * 相册以及图片业务层
 */
use data\service\BaseService as BaseService;
use data\api\system\IAlbum as IAlbum;
use data\model\system\AlbumClassModel as AlbumClassModel;
use data\model\system\AlbumPictureModel as AlbumPictureModel;
class Album extends BaseService implements IAlbum
{
    public $album_class;
    public $album_picture;
    function __construct(){
        parent:: __construct();
        $this->album_class = new AlbumClassModel();
        $this->album_picture = new AlbumPictureModel();  
    }
	/* (non-PHPdoc)
     * @see \data\api\IAlbumClass::getAlbumClassList()
     */
    public function getAlbumClassList($page_index = 1, $page_size = 0, $condition = '', $order = '', $field = '*')
    {
        $album_class = new AlbumClassModel();
        $list = $album_class-> pageQuery($page_index, $page_size, $condition, $order, $field);
        if(!empty($list['data']))
        {
            foreach ($list['data'] as $k => $v)
            {
                //查询相册图片数量
                $count = $this->getAlbumPictureCount($v['album_id']);
                $list['data'][$k]['pic_count'] = $count;
                //查询相册背景图片
                 $album_picture = new AlbumPictureModel();
                $pic_info = $album_picture->getInfo(['pic_id'=>$v['album_cover']], 'pic_cover');
                $list['data'][$k]['pic_info'] = $pic_info;
            }
        }
        return $list;
        
    }
    /**
     * 查询相册图片数
     * @param unknown $album_id
     */
    private function getAlbumPictureCount($album_id){
        $album_picture = new AlbumPictureModel();
        $count = $album_picture->where('album_id='.$album_id)->count();
        return $count;
    }

	/* (non-PHPdoc)
     * @see \data\api\IAlbumClass::addAlbumClass()
     */
    public function addAlbumClass($aclass_name, $aclass_sort, $pid = 0, $aclass_cover = '', $is_default = 0, $instance_id = 1)
    {
        $album_class = new AlbumClassModel();
         $data = array(
            'album_name' => $aclass_name,
            'sort' => $aclass_sort,
            'album_cover' => $aclass_cover,
            'is_default' => $is_default,
            'shop_id' => $instance_id,
            'create_time' => date("Y-m-d H:i:s", time()),
            'pid' => $pid
        );
        $retval = $album_class->save($data);
        if($retval == 1){
            return $album_class->album_id;
        }else{
            return $retval;
        }
        
        
    }

	/* (non-PHPdoc)
     * @see \data\api\IAlbumClass::updateAlbumClass()
     */
    public function updateAlbumClass($aclass_id, $aclass_name, $aclass_sort, $pid = 0, $aclass_cover = '', $is_default = 0)
    {
        $album_class = new AlbumClassModel();
        $data = array(
            'album_name' => $aclass_name,
            'sort' => $aclass_sort,
            "album_cover"=>$aclass_cover
        );
        $retval = $album_class->save($data,['album_id'=>$aclass_id]);
        return $retval;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\IAlbumClass::ModifyAlbumSort()
     */
    public function ModifyAlbumSort($aclass_id, $aclass_sort)
    {
        $album_class = new AlbumClassModel();
        $data = array(
            
        );
        $retval = $album_class->save($data,['aclass_id'=>$aclass_id]);
        return $retval;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\IAlbumClass::ModifyAlbumPid()
     */
    public function ModifyAlbumPid($aclass_id, $pid)
    {
        $album_class = new AlbumClassModel();
        $data = array(
        
        );
        $res = $this->album_class->save($data,['aclass_id'=>$aclass_id]);
        return $res;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\IAlbumClass::deleteAlbumClass()
     */
    public function deleteAlbumClass($aclass_id_array)
    {
        $res = $this->album_class->destroy($aclass_id_array);
        if($res == 1){
            return SUCCESS;
        }else{
            return DELETE_FAIL;
        }
        // TODO Auto-generated method stub
        
    }
	/* (non-PHPdoc)
     * @see \data\api\IAlbum::getPictureList()
     */
    public function getPictureList($page_index = 1, $page_size = 0, $condition = '', $order = " upload_time desc", $field = '*')
    {
        // TODO Auto-generated method stub
        $list = $this->album_picture-> pageQuery($page_index, $page_size, $condition, $order, $field);
        return $list;
    }

	/* (non-PHPdoc)
     * @see \data\api\IAlbum::addPicture()
     */
    public function addPicture($pic_name, $pic_tag, $aclass_id, $pic_cover, $pic_size, $pic_spec, $pic_cover_big, $pic_size_big, 
        $pic_spec_big, $pic_cover_mid, $pic_size_mid, $pic_spec_mid, $pic_cover_small, $pic_size_small, $pic_spec_small, 
        $pic_cover_micro, $pic_size_micro, $pic_spec_micro, $instance_id = 0)
    {
        // TODO Auto-generated method stub
        $data = array(
            'shop_id' => $instance_id,
            'album_id' => $aclass_id,
            'is_wide' => "0",
            'pic_name' => $pic_name,
            'pic_tag' => $pic_tag,
            'pic_cover' => $pic_cover,
            'pic_size' => $pic_size,
            'pic_spec' => $pic_spec,
            'pic_cover_big' => $pic_cover_big,
            'pic_size_big' => $pic_size_big,
            'pic_spec_big' => $pic_spec_big,
            'pic_cover_mid' => $pic_cover_mid,
            'pic_size_mid' => $pic_size_mid,
            'pic_spec_mid' => $pic_spec_mid,
            'pic_cover_small' => $pic_cover_small,
            'pic_size_small' => $pic_size_small,
            'pic_spec_small' => $pic_spec_small,
            'pic_cover_micro' => $pic_cover_micro,
            'pic_size_micro' => $pic_size_micro,
            'pic_spec_micro' => $pic_spec_micro,
            'upload_time' => date("Y-m-d H:i:s", time())
        );
        $res = $this->album_picture->save($data);
        if($res == 1){
            return $this->album_picture->pic_id;
        }else{
            return $res;
        }
    }

	/* (non-PHPdoc)
     * @see \data\api\IAlbum::deletePicture()
     */
    public function deletePicture($pic_id_array)
    {
        // TODO Auto-generated method stub
        $res = $this->album_picture->destroy($pic_id_array);
        if($res == 1){
            return SUCCESS;
        }else{
            return DELETE_FAIL;
        }
        
    }
   /* (non-PHPdoc)
     * @see \data\api\IAlbum::getAlbumClassDetail()
     */
    public function getAlbumClassDetail($album_id){
        // TODO Auto-generated method stub
        $res = $this->album_class->get($album_id);
        return $res;
        // TODO Auto-generated method stub
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\system\IAlbum::getAlbumDetail()
     */
    public function getAlbumDetail($pic_id){
        // TODO Auto-generated method stub
        $res  = $this->album_picture->get($pic_id); 
        return $res;
        // TODO Auto-generated method stub
    }
    public function getAlbumClassAll($data = ''){
        // TODO Auto-generated method stub
        $res  = $this->album_class->all($data);
        if(!empty($res))
        {
            foreach ($res as $k => $v)
            {
                //查询相册图片数量
                $count = $this->getAlbumPictureCount($v['album_id']);
                $res[$k]['pic_count'] = $count;
                //查询相册背景图片
                $album_pic = new AlbumPictureModel();
                $pic_info = $album_pic->getInfo(['pic_id'=>$v['album_cover']], 'pic_cover');
                $res[$k]['pic_info'] = $pic_info;
            }
        }
        return $res;
    }
    
    public function ModifyAlbumPicture($pic_id, $pic_cover,  $pic_size, $pic_spec, $pic_cover_big, $pic_size_big,$pic_spec_big, $pic_cover_mid, $pic_size_mid, $pic_spec_mid, $pic_cover_small, $pic_size_small, $pic_spec_small, $pic_cover_micro, $pic_size_micro, $pic_spec_micro){
        // TODO Auto-generated method stub
        $data = array(
            'pic_cover' => $pic_cover,
            'pic_size' => $pic_size,
            'pic_spec' => $pic_spec,
            'pic_cover_big' => $pic_cover_big,
            'pic_size_big' => $pic_size_big,
            'pic_spec_big' => $pic_spec_big,
            'pic_cover_mid' => $pic_cover_mid,
            'pic_size_mid' => $pic_size_mid,
            'pic_spec_mid' => $pic_spec_mid,
            'pic_cover_small' => $pic_cover_small,
            'pic_size_small' => $pic_size_small,
            'pic_spec_small' => $pic_spec_small,
            'pic_cover_micro' => $pic_cover_micro,
            'pic_size_micro' => $pic_size_micro,
            'pic_spec_micro' => $pic_spec_micro,
            'upload_time' => date("Y-m-d H:i:s", time())
        );
        $res = $this->album_picture->save($data,["pic_id"=>$pic_id]);
        return $res;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\system\IAlbum::ModifyAlbumPictureName()
     */
    public function ModifyAlbumPictureName($pic_id, $pic_name){
        $data =array(
            'pic_name' => $pic_name
        );
        $res = $this->album_picture->save($data,["pic_id"=>$pic_id]);
        if($res == 1){
            return SUCCESS;
        }else{
            return UPDATA_FAIL;
        }
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\system\IAlbum::ModifyAlbumPictureClass()
     */
    public function ModifyAlbumPictureClass($pic_id, $album_id){
        $data =array(
            'album_id' => $album_id
        );
        $res = $this->album_picture->save($data,["pic_id"=>$pic_id]);
        if($res == 1){
            return SUCCESS;
        }else{
            return UPDATA_FAIL;
        }
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\system\IAlbum::ModifyAlbumClassCover()
     */
    public function ModifyAlbumClassCover($pic_id, $album_id){
        $data =array(
            'album_cover' => $pic_id
        );
        $res = $this->album_class->save($data,["album_id"=>$album_id]);
        if($res == 1){
            return SUCCESS;
        }else{
            return UPDATA_FAIL;
        }
    }
}