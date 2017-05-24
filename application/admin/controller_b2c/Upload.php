<?php
/**
 * Upload.php
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
use data\service\system\Album as Album;
use think\Controller;

/**
 * 图片上传控制器
 * 
 * @author Administrator
 *        
 */
class Upload extends Controller
{

    /**
     * 功能说明：文件(图片)上传(存入相册)
     */
    public function fileAlbumUpload()
    {
        $upFilePath = "upload/admin/album/";
        $guid = time();
        $extend = explode(".", $_FILES["file_upload"]["name"]);
        $key = count($extend) - 1;
        $ext = "." . $extend[$key];
        $newfile = $guid . $ext; // 原图
        $size = $_FILES["file_upload"]["size"];
        $ext = $_FILES["file_upload"]["type"];
        // 检测路径是否纯在
        if (! file_exists($upFilePath)) {
            mkdir($upFilePath);
        }
        $ok = move_uploaded_file($_FILES["file_upload"]["tmp_name"], $upFilePath . $newfile);
        @unlink($_FILES['file_upload']);
        $mageSize = getimagesize($upFilePath . $newfile);
        $width = $mageSize[0];
        $height = $mageSize[1];
        $name = "";
        for ($i = 0; $i < (count($extend) - 1); $i ++) {
            $name .= $extend[$i];
        }
        $type = isset($_POST['type']) ? ($_POST['type']) : "";
        $pic_name = isset($_POST['pic_name']) ? ($_POST['pic_name']) : $name;
        $album_id = isset($_POST['album_id']) ? ($_POST['album_id']) : "";
        $pic_tag = isset($_POST['pic_tag']) ? ($_POST['pic_tag']) : $name;
        $pic_id = isset($_POST['pic_id']) ? ($_POST['pic_id']) : "";
        $retval = $this->photoCreate($upFilePath, $upFilePath . $newfile, "." . $extend[$key], $type, $pic_name, $album_id, $width, $height, $pic_tag, $pic_id);
        return $retval;
    }

    /**
     * 功能说明：文件(图片)上传(不存入相册)
     */
    public function fileCommonUpload()
    {
        $upFilePath = "upload/admin/common/";
        $guid = time();
        $extend = explode(".", $_FILES["file_upload"]["name"]);
        $key = count($extend) - 1;
        $ext = "." . $extend[$key];
        $newfile = $guid . $ext; // 原图
        $size = $_FILES["file_upload"]["size"];
        $ext = $_FILES["file_upload"]["type"];
        // 检测路径是否纯在
        if (! file_exists($upFilePath)) {
            mkdir($upFilePath);
        }
        $ok = move_uploaded_file($_FILES["file_upload"]["tmp_name"], $upFilePath . $newfile);
        @unlink($_FILES['file_upload']);
        $mageSize = getimagesize($upFilePath . $newfile);
        $width = $mageSize[0];
        $height = $mageSize[1];
        $name = "";
        for ($i = 0; $i < (count($extend) - 1); $i ++) {
            $name .= $extend[$i];
        }
        return $upFilePath . $newfile;
    }
    


    /**
     * 功能说明：文件(图片)上传(不存入相册)
     */
    public function fileUpload()
    {
        $upFilePath = "upload/admin/files/";
        $guid = time();
        $extend = explode(".", $_FILES["file_upload"]["name"]);
        $key = count($extend) - 1;
        $ext = "." . $extend[$key];
        $newfile = $guid . $ext; // 原图
        $size = $_FILES["file_upload"]["size"];
        $ext = $_FILES["file_upload"]["type"];
        // 检测路径是否纯在
        if (! file_exists($upFilePath)) {
            mkdir($upFilePath);
        }
        $ok = move_uploaded_file($_FILES["file_upload"]["tmp_name"], $upFilePath . $newfile);
        @unlink($_FILES['file_upload']);
        $name = "";
        for ($i = 0; $i < (count($extend) - 1); $i ++) {
            $name .= $extend[$i];
        }
        return $upFilePath . $newfile;
    }

    /**
     * 各类型图片生成
     *
     * @param unknown $photoPath            
     * @param unknown $ext            
     * @param number $type            
     */
    public function photoCreate($upFilePath, $photoPath, $ext, $type = 0, $pic_name, $album_id, $width, $height, $pic_tag, $pic_id)
    {
        $image = \think\Image::open($photoPath);
        $photoArray = array(
            "bigPath" => array(
                "path" => $upFilePath . time() . "1" . $ext,
                "width" => 700,
                "height" => 700,
                'type' => '1'
            ),
            "middlePath" => array(
                "path" => $upFilePath . time() . "2" . $ext,
                "width" => 360,
                "height" => 360,
                'type' => '2'
            ),
            "smallPath" => array(
                "path" => $upFilePath . time() . "3" . $ext,
                "width" => 240,
                "height" => 240,
                'type' => '3'
            ),
            "littlePath" => array(
                "path" => $upFilePath . time() . "4" . $ext,
                "width" => 60,
                "height" => 60,
                'type' => '4'
            )
        );
        foreach ($photoArray as $v) {
            if (stristr($type, $v['type'])) {
                // $this->resizeImg($photoPath, $v["path"], $v["width"], $v["height"]);
                $image->thumb($v["width"], $v["height"], \think\Image::THUMB_CENTER)->save($v["path"]);
            }
        }
        $album = new Album();
        if ($pic_id == "") {
            $retval = $album->addPicture($pic_name, $pic_tag, $album_id, $photoPath, $width . "," . $height, $width . "," . $height, $photoArray["bigPath"]["path"], $photoArray["bigPath"]["width"] . "," . $photoArray["bigPath"]["height"], $photoArray["bigPath"]["width"] . "," . $photoArray["bigPath"]["height"], $photoArray["middlePath"]["path"], $photoArray["middlePath"]["width"] . "," . $photoArray["middlePath"]["height"], $photoArray["middlePath"]["width"] . "," . $photoArray["middlePath"]["height"], $photoArray["smallPath"]["path"], $photoArray["smallPath"]["width"] . "," . $photoArray["smallPath"]["height"], $photoArray["smallPath"]["width"] . "," . $photoArray["smallPath"]["height"], $photoArray["littlePath"]["path"], $photoArray["littlePath"]["width"] . "," . $photoArray["littlePath"]["height"], $photoArray["littlePath"]["width"] . "," . $photoArray["littlePath"]["height"]);
        } else {
            $retval = $album->ModifyAlbumPicture($pic_id, $photoPath, $width . "," . $height, $width . "," . $height, $photoArray["bigPath"]["path"], $photoArray["bigPath"]["width"] . "," . $photoArray["bigPath"]["height"], $photoArray["bigPath"]["width"] . "," . $photoArray["bigPath"]["height"], $photoArray["middlePath"]["path"], $photoArray["middlePath"]["width"] . "," . $photoArray["middlePath"]["height"], $photoArray["middlePath"]["width"] . "," . $photoArray["middlePath"]["height"], $photoArray["smallPath"]["path"], $photoArray["smallPath"]["width"] . "," . $photoArray["smallPath"]["height"], $photoArray["smallPath"]["width"] . "," . $photoArray["smallPath"]["height"], $photoArray["littlePath"]["path"], $photoArray["littlePath"]["width"] . "," . $photoArray["littlePath"]["height"], $photoArray["littlePath"]["width"] . "," . $photoArray["littlePath"]["height"]);
            $retval = $pic_id;
        }
        return $retval;
    }
}