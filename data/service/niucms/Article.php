<?php
/**
 * Article.php
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
namespace data\service\niucms;
use data\service\BaseService as BaseService;
use data\api\niucms\IArticle;
use data\model\cms\NcCmsArticleModel;
use data\model\cms\NcCmsArticleClassModel;
use data\model\cms\NcCmsArticleViewModel;
use data\model\cms\NcCmsCommentModel;
use data\model\cms\NcCmsCommentViewModel;
use think\Model;
/**
 * 文章服务层
 * @author Administrator
 *
 */
class Article extends BaseService implements IArticle
{
	/* (non-PHPdoc)
     * @see \data\api\cms\IArticle::getArticleList()
     */
    public function getArticleList($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        $articleview = new NcCmsArticleViewModel();
        $list = $articleview->getViewList($page_index, $page_size, $condition, $order);
        return $list;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\cms\IArticle::getArticleDetail()
     */
    public function getArticleDetail($article_id)
    {
        $article = new NcCmsArticleModel();
        $data = $article->get($article_id);
        return $data;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\cms\IArticle::getArticleClass()
     */
    public function getArticleClass($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        $article_class = new NcCmsArticleClassModel();
        $list = $article_class->pageQuery($page_index, $page_size, $condition, $order, '*');
        return $list;
        // TODO Auto-generated method stub
        
    }
    
	/* (non-PHPdoc)
     * @see \data\api\cms\IArticle::getArticleClassDetail()
     */
    public function getArticleClassDetail($class_id)
    {
        $article_class = new NcCmsArticleClassModel();
        $list = $article_class->get($class_id);
        return $list;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\cms\IArticle::addArticle()
     */
    public function addArticle($title, $class_id, $short_title, $source, $url, $author, $summary, $content, $image, $keyword, $article_id_array, $click, $sort, $commend_flag, $comment_flag, $status, $attachment_path, $tag, $comment_count, $share_count)
    {
        $article = new NcCmsArticleModel();
        $data = array(
            'title'         => $title,
            'class_id'      => $class_id,
            'short_title'   => $short_title,
            'source'        => $source,
            'url'           => $url,
            'author'        => $author,
            'summary'       => $summary,
            'content'       => $content,
            'image'         => $image,
            'keyword'       => $keyword,
       'article_id_array'   => $article_id_array,
            'click'         => $click,
            'sort'          => $sort,
            'commend_flag'  => $commend_flag,
            'comment_flag'  => $comment_flag,
            'status'        => $status,
           'attachment_path'=> $attachment_path,
            'tag'           => $tag,
            'comment_count' => $comment_count,
            'share_count'   => $share_count,
            'publisher_name'=> $this->uid,
            'uid'           => $this->uid,
            'public_time'   => date("Y-m-d H:i:s", time()),
            'create_time'   => date("Y-m-d H:i:s", time())
        );
        $article->save($data);
        $retval =$article->article_id;
        return $retval;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\cms\IArticle::updateArticle()
     */
    public function updateArticle($article_id, $title, $class_id, $short_title, $source, $url, $author, $summary, $content, $image, $keyword, $article_id_array, $click, $sort, $commend_flag, $comment_flag, $status, $attachment_path, $tag, $comment_count, $share_count)
    {
        $article = new NcCmsArticleModel();
        $data = array(
            'title'         => $title,
            'class_id'      => $class_id,
            'short_title'   => $short_title,
            'source'        => $source,
            'url'           => $url,
            'author'        => $author,
            'summary'       => $summary,
            'content'       => $content,
            'image'         => $image,
            'keyword'       => $keyword,
            'article_id_array'   => $article_id_array,
            'click'         => $click,
            'sort'          => $sort,
            'commend_flag'  => $commend_flag,
            'comment_flag'  => $comment_flag,
            'status'        => $status,
            'attachment_path'=> $attachment_path,
            'tag'           => $tag,
            'comment_count' => $comment_count,
            'share_count'   => $share_count,
            'publisher_name'=> $this->uid,
            'uid'           => $this->uid,
            'modify_time'   => date("Y-m-d H:i:s", time())
        );
        $retval = $article->save($data, ['article_id' => $article_id]);
        return $retval;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\cms\IArticle::addAritcleClass()
     */
    public function addAritcleClass($name, $sort, $pid)
    {
        $article_class = new NcCmsArticleClassModel();
        $data = array(
            'name' => $name,
            'pid' => $pid,
            'sort' => $sort
        );
        $retval = $article_class->save($data);
        return $retval;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\cms\IArticle::updateArticleClass()
     */
    public function updateArticleClass($class_id, $name, $sort, $pid)
    {
        $article_class = new NcCmsArticleClassModel();
        $data = array(
            'name' => $name,
            'pid' => $pid,
            'sort' => $sort
        );
        $retval = $article_class->save($data, ['class_id' => $class_id]);
        return $retval;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\cms\IArticle::modifyArticleSort()
     */
    public function modifyArticleSort($article_id, $sort)
    {
        $article = new NcCmsArticleModel();
        $data = array(
            'sort' => $sort
        );
        $retval = $article->save($data, ['article_id' => $article_id]);
        return $retval;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\cms\IArticle::modifyArticleClassSort()
     */
    public function modifyArticleClassSort($class_id, $sort)
    {
        $article_class = new NcCmsArticleClassModel();
        $data = array(
            'sort' => $sort
        );
        $retval = $article_class->save($data, ['class_id' => $class_id]);
        return $retval;
        // TODO Auto-generated method stub
        
    }
    
   /* (non-PHPdoc)
     * @see \data\api\cms\IArticle::deleteArticleClass()
     */
    public function deleteArticleClass($class_id){
        $article_class = new NcCmsArticleClassModel();
        $retval=$article_class->destroy($class_id);
        return $retval; 
    }
    /* (non-PHPdoc)
     * @see \data\api\cms\IArticle::deleteArticle()
     */
    public function deleteArticle($article_id){
        $article=new NcCmsArticleModel();
        $retval=$article->destroy($article_id);
        return $retval;
    }
    
    /* (non-PHPdoc)
     * @see \data\api\cms\IArticle::articleClassUseCount()
     */
    public function articleClassUseCount($class_id){
        $article=new NcCmsArticleModel();
        $is_class_count=$article->viewCount($article,['class_id' => $class_id]);
        return $is_class_count;
    }

    /* (non-PHPdoc)
     * @see \data\api\cms\IArticle::getCommentList()
     */
    public function getCommentList($page_index = 1, $page_size = 0, $condition = '', $order = '')
    {
        $commentview = new NcCmsCommentViewModel();
        $list = $commentview->getViewList($page_index, $page_size, $condition, $order);
        return $list;
        // TODO Auto-generated method stub
    
    }
    /* (non-PHPdoc)
     * @see \data\api\cms\IArticle::getCommentDetail()
     */
    public function getCommentDetail($comment_id)
    {
        $comment = new NcCmsCommentModel();
        $data = $comment->get($comment_id);
        return $data;
        // TODO Auto-generated method stub
    
    }
    
    /* (non-PHPdoc)
     * @see \data\api\cms\IArticle::deleteComment()
     */
    public function deleteComment($comment_id){
        $comment = new NcCmsCommentModel();
        $retval=$comment->destroy($comment_id);
        return $retval;
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niucms\IArticle::getArticleClassQuery()
     */
    public function getArticleClassQuery(){
        $list = array();
        $first_list = $this->getArticleClass(1,0,'pid=0','sort');
        $list = $first_list['data'];
        foreach ($list as $k => $v)
        {
            $second_list = $this->getArticleClass(1,0,'pid='.$v['class_id'],'sort');
            $list[$k]['child_list'] = $second_list['data'];
        }
        return $list;
    }
    
}