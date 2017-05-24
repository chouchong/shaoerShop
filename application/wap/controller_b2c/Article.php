<?php
/**
 * Article.php
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

use data\model\system\AlbumPictureModel as AlbumPictureModel;
use data\service\niucms\Article as ArticleService;
use data\service\niushop\Member as Member;
use data\service\system\WebSite as WebSite;
use think\Controller;
\think\Loader::addNamespace('data', 'data/');

class Article extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->user = new Member();
        $this->web_site = new WebSite();
        $web_info = $this->web_site->getWebSiteInfo();
        $this->assign("title", $web_info['title']);
        $this->style = 'wap/' . NS_TEMPLATE;
        $this->assign("style", $this->style);
    }

    public function showArticle()
    {
        $article_id = isset($_GET['id']) ? $_GET['id'] : 0;
        if (empty($article_id)) {
            $this->error("没有获取到文章信息");
        }
        $article = new ArticleService();
        $ArticleDetail = $article->getArticleDetail($article_id);
        $this->assign("ArticleDetail", $ArticleDetail);
        $this->assign("content", $ArticleDetail['content']);
        $attachment_path = explode(",", $ArticleDetail['attachment_path']);
        $this->assign('attachment_path', $attachment_path);
        // 查询图片表
        $goods_img = new AlbumPictureModel();
        $imginfo = $goods_img->all($ArticleDetail['image']);
        $img = empty($imginfo) ? '' : $imginfo[0]["pic_cover_big"];
        $this->assign('img', $img);
        return view($this->style . 'Article/showArticle');
    }
}