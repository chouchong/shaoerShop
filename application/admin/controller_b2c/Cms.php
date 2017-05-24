<?php
/**
 * Cms.php
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

use data\model\system\AlbumPictureModel as AlbumPictureModel;
use data\service\niucms\Article;

/**
 * cms内容管理系统
 */
class Cms extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 文章列表
     */
    public function articleList()
    {
        if (request()->isAjax()) {
            $article = new Article();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $result = $article->getArticleList($pageindex, PAGESIZE, '', 'nca.create_time desc');
            return $result;
        } else {
            return view($this->style . 'Cms/articleList');
        }
    }

    /**
     * 添加文章
     */
    public function addArticle()
    {
        if (request()->isAjax()) {
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : '';
            $short_title = isset($_POST['short_title']) ? $_POST['short_title'] : '';
            $source = isset($_POST['source']) ? $_POST['source'] : '';
            $url = isset($_POST['url']) ? $_POST['url'] : '';
            $author = isset($_POST['author']) ? $_POST['author'] : '';
            $summary = isset($_POST['summary']) ? $_POST['summary'] : '';
            $content = isset($_POST['content']) ? $_POST['content'] : '';
            $image = isset($_POST['image']) ? $_POST['image'] : '';
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $article_id_array = isset($_POST['article_id_array']) ? $_POST['article_id_array'] : '';
            $click = isset($_POST['click']) ? $_POST['click'] : '';
            $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
            $commend_flag = isset($_POST['commend_flag']) ? $_POST['commend_flag'] : '';
            $comment_flag = isset($_POST['comment_flag']) ? $_POST['comment_flag'] : '';
            $attachment_path = isset($_POST['attachment_path']) ? $_POST['attachment_path'] : '';
            $tag = isset($_POST['tag']) ? $_POST['tag'] : '';
            $comment_count = isset($_POST['comment_count']) ? $_POST['comment_count'] : '';
            $share_count = isset($_POST['share_count']) ? $_POST['share_count'] : '';
            $share_count = isset($_POST['share_count']) ? $_POST['share_count'] : '';
            $status = 2;
            $article = new Article();
            $result = $article->addArticle($title, $class_id, $short_title, $source, $url, $author, $summary, $content, $image, $keyword, $article_id_array, $click, $sort, $commend_flag, $comment_flag, $status, $attachment_path, $tag, $comment_count, $share_count);
            return AjaxReturn($result);
        } else {
            $article = new Article();
            $articleClassList = $article->getArticleClass();
            $this->assign('articleClassList', $articleClassList);
            return view($this->style . 'Cms/addArticle');
        }
    }

    /**
     * 修改文章
     */
    public function updateArticle()
    {
        $article_id = isset($_GET['id']) ? $_GET['id'] : '';
        $article = new Article();
        $ArticleDetail = $article->getArticleDetail($article_id);
        $attachment_path = explode(",", $ArticleDetail['attachment_path']);
        $articleClassList = $article->getArticleClass();
        $this->assign('attachment_path', $attachment_path[0]);
        $this->assign('article_id', $article_id);
        $this->assign('articleClassList', $articleClassList);
        $this->assign('ArticleDetail', $ArticleDetail);
        // 查询图片表
        $goods_img = new AlbumPictureModel();
        $imginfo = $goods_img->all($ArticleDetail['image']);
        $img = empty($imginfo) ? '' : $imginfo[0]["pic_cover_big"];
        $this->assign('img', $img);
        return view($this->style . 'Cms/updateArticle');
    }

    /**
     * 处理文章
     */
    public function ajax_updateArticle()
    {
        $article_id = isset($_POST['article_id']) ? $_POST['article_id'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : '';
        $short_title = isset($_POST['short_title']) ? $_POST['short_title'] : '';
        $source = isset($_POST['source']) ? $_POST['source'] : '';
        $url = isset($_POST['url']) ? $_POST['url'] : '';
        $author = isset($_POST['author']) ? $_POST['author'] : '';
        $summary = isset($_POST['summary']) ? $_POST['summary'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $image = isset($_POST['image']) ? $_POST['image'] : '';
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
        $article_id_array = isset($_POST['article_id_array']) ? $_POST['article_id_array'] : '';
        $click = isset($_POST['click']) ? $_POST['click'] : '';
        $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
        $commend_flag = isset($_POST['commend_flag']) ? $_POST['commend_flag'] : '';
        $comment_flag = isset($_POST['comment_flag']) ? $_POST['comment_flag'] : '';
        $attachment_path = isset($_POST['attachment_path']) ? $_POST['attachment_path'] : '';
        $tag = isset($_POST['tag']) ? $_POST['tag'] : '';
        $comment_count = isset($_POST['comment_count']) ? $_POST['comment_count'] : '';
        $share_count = isset($_POST['share_count']) ? $_POST['share_count'] : '';
        $status = 2;
        $article = new Article();
        $result = $article->updateArticle($article_id, $title, $class_id, $short_title, $source, $url, $author, $summary, $content, $image, $keyword, $article_id_array, $click, $sort, $commend_flag, $comment_flag, $status, $attachment_path, $tag, $comment_count, $share_count);
        return AjaxReturn($result);
    }

    /**
     * 文章分类列表
     */
    public function articleClassList()
    {
        if (request()->isAjax()) {
            $article = new Article();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $articleClassList = $article->getArticleClass($pageindex, PAGESIZE, '', 'sort');
            return $articleClassList;
        } else {
            $article = new Article();
            $article_class_frist_list = $article->getArticleClass(1, 0, [
                'pid' => 0
            ], 'sort');
            $this->assign('article_class_frist_list', $article_class_frist_list['data']);
            return view($this->style . 'Cms/articleClassList');
        }
    }

    /**
     * 根据文章id获取文章详情
     */
    public function articleClassInfo()
    {
        if (request()->isAjax()) {
            $article = new Article();
            $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : '';
            $infolist = $article->getArticleClassDetail($class_id);
            return $infolist;
        }
    }

    /**
     * 文章分类添加修改
     *
     * @return multitype:unknown @class_id 大于0就是修改，小于等于0就是添加
     */
    public function addUpdateAritcleClass()
    {
        if (request()->isAjax()) {
            $article = new Article();
            $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : '';
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
            $pid = isset($_POST['pid']) ? $_POST['pid'] : '';
            if ($class_id > 0) {
                $retval = $article->updateArticleClass($class_id, $name, $sort, $pid);
            } else {
                $retval = $article->addAritcleClass($name, $sort, $pid);
            }
            return AjaxReturn($retval);
        }
    }

    /**
     * 文章分类删除
     */
    public function deleteArticleClass()
    {
        if (request()->isAjax()) {
            $article = new Article();
            $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : '';
            if ($article->articleClassUseCount($class_id) > 0) {
                $retval = array(
                    'code' => '0',
                    'message' => '分类已被使用不可删除'
                );
                return $retval;
            } else {
                $retval = $article->deleteArticleClass($class_id);
                return AjaxReturn($retval);
            }
        }
    }

    /**
     * 文章删除
     */
    public function deleteArticle()
    {
        if (request()->isAjax()) {
            $article = new Article();
            $article_id = isset($_POST['article_id']) ? $_POST['article_id'] : '';
            $retval = $article->deleteArticle($article_id);
            return AjaxReturn($retval);
        }
    }

    /**
     * 评论列表
     */
    public function commentArticle()
    {
        if (request()->isAjax()) {
            $article = new Article();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '';
            $commentArticleList = $article->getCommentList($pageindex, PAGESIZE, '', 'up desc');
            return $commentArticleList;
        } else {
            return view($this->style . 'Cms/commentArticle');
        }
    }

    /**
     * 评论详情
     */
    public function comment_detaile()
    {
        if (request()->isAjax()) {
            $comment_id = isset($_POST['comment_id']) ? $_POST['comment_id'] : '';
            $article = new Article();
            $result = $article->getCommentDetail($comment_id);
            return $result;
        }
    }

    /**
     * 删除单条评论
     */
    public function comment_delete()
    {
        if (request()->isAjax()) {
            $comment_id = isset($_POST['comment_id']) ? $_POST['comment_id'] : '';
            $article = new Article();
            $result = $article->deleteComment($comment_id);
            return AjaxReturn($result);
        }
    }

    /**
     * 修改分类排序
     */
    public function modifyField()
    {
        if (request()->isAjax()) {
            $class_id = isset($_POST['fieldid']) ? $_POST['fieldid'] : '';
            $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
            $article = new Article();
            $result = $article->modifyArticleClassSort($class_id, $sort);
            return AjaxReturn($result);
        }
    }

    /**
     * 修改文章列表排序
     */
    public function modifyArticleField()
    {
        if (request()->isAjax()) {
            $class_id = isset($_POST['fieldid']) ? $_POST['fieldid'] : '';
            $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
            $article = new Article();
            $result = $article->modifyArticleSort($class_id, $sort);
            return AjaxReturn($result);
        }
    }
}