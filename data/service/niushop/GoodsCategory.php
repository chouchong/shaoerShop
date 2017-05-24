<?php
/**
 * GoodsCategory.php
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
 * 商品分类服务层
 */
use data\service\BaseService as BaseService;
use data\model\niushop\NsGoodsCategoryModel as NsGoodsCategoryModel;
use data\api\niushop\IGoodsCategory as IGoodsCategory;
use data\model\niushop\NsGoodsModel;
use data\model\niushop\NsGoodsBrandModel;
class GoodsCategory extends BaseService implements IGoodsCategory 
{
    private $goods_category;
    function __construct(){
        parent:: __construct();
        $this->goods_category = new NsGoodsCategoryModel();
    }
	/* (non-PHPdoc)
     * @see \data\api\niushop\IGoodsCategory::getGoodsCategoryList()
     */
    public function getGoodsCategoryList($page_index=1, $page_size=0, $condition = '', $order = '', $field = '*')
    {
        $list = $this->goods_category->pageQuery($page_index, $page_size, $condition, $order, $field);
        return $list;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IGoodsCategory::getGoodsCategoryListByParentId()
     */
    public function getGoodsCategoryListByParentId($pid)
    {
       $list = $this->getGoodsCategoryList(1, 0, 'pid='.$pid, 'pid,sort');
       return $list['data'];
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IGoodsCategory::addOrEditGoodsCategory()
     */
    public function addOrEditGoodsCategory($category_id, $category_name, $short_name, $pid, $is_visible, $keywords='', $description='', $sort=0, $category_pic)
    {
    	if($pid == 0){
    		$level = 1;
    	}else{
    		$level = $this->getGoodsCategoryDetail($pid)['level'] + 1;
    	}
        $data = array(
            'category_name'   => $category_name,
            'short_name'   => $short_name,
            'pid'             => $pid,
            'level'           => $level,
            'is_visible'      => $is_visible,
            'keywords'        => $keywords,
            'description'     => $description,
            'sort'            => $sort,
            'category_pic'    => $category_pic,
        );
        if($category_id == 0)
        {  
            $this->goods_category->save($data);
            $res = $this->goods_category->category_id;
        }else{
            $res = $this->goods_category->save($data,['category_id'=>$category_id]);
        }
        return $res;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IGoodsCategory::deleteGoodsCategory()
     */
    public function deleteGoodsCategory($category_id)
    {
    	$sub_list = $this->getGoodsCategoryListByParentId($category_id);
		if (! empty($sub_list)) {
			$res = SYSTEM_DELETE_FAIL;
		}else {
            $res = $this->goods_category->destroy($category_id);
        }
        return $res;
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IGoodsCategory::getTreeCategoryList()
     */
    public function getTreeCategoryList($show_deep, $condition)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IGoodsCategory::getKeyWords()
     */
    public function getKeyWords($category_id)
    {
        $res = $this->goods_category->getInfo(['category_id'=>$category_id],'keywords');
        return $res;
        // TODO Auto-generated method stub
        
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoodsCategory::getLevel()
     */
    public function getLevel($category_id)
    {
        $res = $this->goods_category->getInfo(['category_id'=>$category_id],'level');
        return $res;
        // TODO Auto-generated method stub
    
    }
    /**
     * (non-PHPdoc)
     * @see \data\api\niushop\IGoodsCategory::getName()
     */
    public function getName($category_id)
    {
        $res = $this->goods_category->getInfo(['category_id'=>$category_id],'category_name');
        return $res;
        // TODO Auto-generated method stub
    
    }

	/* (non-PHPdoc)
     * @see \data\api\niushop\IGoodsCategory::getGoodsCategoryDetail()
     */
    public function getGoodsCategoryDetail($category_id)
    {
        $res = $this->goods_category->get($category_id);
        return $res;
        // TODO Auto-generated method stub
        
    }

	public function getGoodsCategoryTree($pid){
		//暂时  获取 两级
		$list = array();  
		$one_list = $this->getGoodsCategoryListByParentId($pid);
		foreach($one_list as $k1=>$v1){
			$two_list = array();
			$two_list = $this->getGoodsCategoryListByParentId($v1['category_id']);
			$one_list[$k1]['child_list'] = $two_list;
		}
		$list = $one_list;
		return $list;
	}
	
    /**
     * 修改商品分类  单个字段
     * @param unknown $category_id
     * @param unknown $order
    */
	public function ModifyGoodsCategoryField($category_id, $field_name, $field_value){
        $res = $this->goods_category->ModifyTableField('category_id',$category_id, $field_name, $field_value);
        return $res;
    }
    /**
     * 获取商品分类下的商品品牌(non-PHPdoc)
     * @see \data\api\niushop\IGoodsCategory::getGoodsCategoryBrands()
     */
    public function getGoodsCategoryBrands($category_id)
    {
        $goods_model = new NsGoodsModel();
        $brand_id_array = $goods_model->getQuery(['category_id'=> $category_id], 'brand_id', '');
        $array = array();
        if(!empty($brand_id_array))
        {
            foreach($brand_id_array as $k=> $v)
            {
                $array[] = $v['brand_id'];
            }
        }
        if(!empty($array))
        {
            $brand_str = implode(',', $array);
            $goods_brand = new NsGoodsBrandModel();
            $condition = array(
                'brand_id' => array('in',$brand_str)
            );
            $brand_list = $goods_brand->getQuery($condition, '*', '');
            return $brand_list;
        }else 
        {
            return '';
        }
        
    }
    /**
     * 获取商品分类下的价格区间(non-PHPdoc)
     * @see \data\api\niushop\IGoodsCategory::getGoodsCategoryPriceGrades()
     */
    public function getGoodsCategoryPriceGrades($category_id)
    {
        $goods_model = new NsGoodsModel();
        $max_price = $goods_model->where(['category_id'=> $category_id])->max('price');
        $min_price = $goods_model->where(['category_id'=> $category_id])->min('price');
        $price_grade = 1;
        for($i=1; $i<= log10($max_price); $i++)
        {
        $price_grade *= 10;
        }
        //跨度
        $dx = (ceil(log10(($max_price-$min_price)/3))-1)* $price_grade;
        if($dx <= 0)
        {
            $dx = $price_grade;
        }
        $array = array();
        $j = 0;
        while($j <= $max_price)
        {
            $array[] = array($j, $j+$dx-1);
            $j = $j + $dx;
        }
       
        return $array; 
        
        
    }
	/* (non-PHPdoc)
     * @see \data\api\niushop\IGoodsCategory::getGoodsCategorySaleNum()
     */
    public function getGoodsCategorySaleNum()
    {
        // TODO Auto-generated method stub
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
    /**
     * 获取商品分类的子项列
     * @param unknown $category_id
     * @return string|unknown
     */
    public function getCategoryTreeList($category_id)
    {
        $goods_goods_category = new NsGoodsCategoryModel();
        $level = $goods_goods_category->getInfo(['category_id' => $category_id], 'level');
        if(!empty($level))
        {
            $category_list = array();
            if($level['level'] == 1)
            {
                $child_list = $goods_goods_category->getQuery(['pid' => $category_id], 'category_id,pid', '');
                $category_list = $child_list;
                if(!empty($child_list))
                {
                    foreach ($child_list as $k => $v)
                    {
                        $grandchild_list = $goods_goods_category->getQuery(['pid' => $v['category_id']], 'category_id', '');
                        if(!empty($grandchild_list))
                        {
                            $category_list = array_merge($category_list, $grandchild_list);
                        }
                    }
                }
            }elseif($level['level'] == 2)
            {
                $child_list = $goods_goods_category->getQuery(['pid' => $category_id], 'category_id,pid', '');
                $category_list = $child_list;
            }
            $array = array();
            if(!empty($category_list))
            {
               
                foreach ($category_list as $k => $v)
                {
                    $array[] = $v['category_id'];
                }
                
            }
            if(!empty($array))
            {
                $id_list = implode(',', $array);
                return $id_list.','.$category_id;
            }else{
                return $category_id;
            }
            
            
        }else{
            return $category_id;
        }
    }
    
    

}

?>