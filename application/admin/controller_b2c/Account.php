<?php
/**
 * Account.php
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

use data\service\niushop\Goods;
use data\service\niushop\GoodsCategory;
use data\service\niushop\Order;
use data\service\niushop\Shop;
use think\helper\Time;

/**
 * 账户控制器
 */
class Account extends BaseController
{

    /**
     * 商品销售排行
     */
    public function shopGoodsSalesRank()
    {
        $goods = new Goods();
        $goods_list = $goods->getGoodsRank(array(
            "shop_id" => $this->instance_id
        ));
        $this->assign("goods_list", $goods_list);
        return view($this->style . "Account/shopGoodsSalesRank");
    }

    /**
     * 商品销售统计
     */
    public function shopGoodsAccountList()
    {
        if (request()->isAjax()) {
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : 1;
            $start_date = ! empty($_POST['start_date']) ? $_POST['start_date'] : '';
            $end_date = ! empty($_POST['end_date']) ? $_POST['end_date'] : '';
            $goods_id = ! empty($_POST['goods_id']) ? $_POST['goods_id'] : 0;
            $condition = array();
            if ($start_date != "") {
                $condition["nsoar.create_time"][] = [
                    ">",
                    $start_date
                ];
                $count_condition["nsoar.create_time"][] = [
                    ">",
                    $start_date
                ];
            }
            if ($end_date != "") {
                $condition["nsoar.create_time"][] = [
                    "<",
                    $end_date
                ];
                $count_condition["nsoar.create_time"][] = [
                    "<",
                    $end_date
                ];
            }
            if ($goods_id != 0) {
                $condition["nog.goods_id"] = $goods_id;
                $count_condition["nog.goods_id"] = $goods_id;
            }
            $count_condition["nsoar.shop_id"] = $this->instance_id;
            $condition["nsoar.id"] = [
                ">",
                0
            ];
            $shop = new Shop();
            $list = $shop->getshopOrderAccountRecordsList($pageindex, PAGESIZE, $condition, 'nsoar.create_time desc');
            $count = $shop->getShopGoodsSales($count_condition);
            return [
                "list" => $list,
                "count" => $count
            ];
        } else {
            $goods_id = isset($_GET["goods_id"]) ? $_GET["goods_id"] : 0;
            $this->assign("goods_id", $goods_id);
            return view($this->style . "Account/shopGoodsAccountList");
        }
    }

    /**
     * 店铺销售明细
     *
     * @return unknown|Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function orderRecordsList()
    {
        if (request()->isAjax()) {
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : 1;
            $condition = array();
            $start_date = ! empty($_POST['start_date']) ? $_POST['start_date'] : '';
            $end_date = ! empty($_POST['end_date']) ? $_POST['end_date'] : '';
            if ($start_date != "" && $end_date != "") {
                $condition["create_time"] = [
                    [
                        ">",
                        $start_date
                    ],
                    [
                        "<",
                        $end_date
                    ]
                ];
            } else 
                if ($start_date != "" && $end_date == "") {
                    $condition["create_time"] = [
                        [
                            ">",
                            $start_date
                        ]
                    ];
                } else 
                    if ($start_date == "" && $end_date != "") {
                        $condition["create_time"] = [
                            [
                                "<",
                                $end_date
                            ]
                        ];
                    }
            $order = new Order();
            $list = $order->getOrderList($pageindex, PAGESIZE, $condition, " create_time desc ");
            return $list;
        } else {
            $child_menu_list = array(
                array(
                    'url' => "account/orderaccountcount",
                    'menu_name' => "订单统计",
                    "active" => 0
                ),
                array(
                    'url' => "account/orderrecordslist",
                    'menu_name' => "销售明细",
                    "active" => 1
                )
            );
            $this->assign('child_menu_list', $child_menu_list);
            
            $time = isset($_GET["time"]) ? $_GET["time"] : "";
            $type = isset($_GET["type"]) ? $_GET["type"] : 0;
            $start_time = "";
            $end_time = "";
            if ($time == "day") {
                $start_time = date("Y-m-d", time());
                $end_time = date("Y-m-d H:i:s", time());
            } else 
                if ($time == "week") {
                    $start_time = date('Y-m-d', strtotime('-7 days'));
                    $end_time = date("Y-m-d H:i:s", time());
                } else 
                    if ($time == "month") {
                        $start_time = date('Y-m-d', strtotime('-30 days'));
                        $end_time = date("Y-m-d H:i:s", time());
                    }
            $this->assign("start_time", $start_time);
            $this->assign("end_time", $end_time);
            return view($this->style . "Account/orderRecordsList");
        }
    }

    /**
     * 订单销售统计
     */
    public function orderAccountCount()
    {
        $child_menu_list = array(
            array(
                'url' => "account/orderaccountcount",
                'menu_name' => "订单统计",
                "active" => 1
            ),
            array(
                'url' => "account/orderrecordsList",
                'menu_name' => "销售明细",
                "active" => 0
            )
        );
        $this->assign('child_menu_list', $child_menu_list);
        $order_service = new Order();
        // 获取日销售统计
        $account = $order_service->getShopOrderAccountDetail($this->instance_id);
        $this->assign("account", $account);
        return view($this->style . "Account/orderAccountCount");
    }

    /**
     * 店铺销售概况
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function shopSalesAccount()
    {
        $order_service = new Order();
        // 获取所需销售统计
        $account = $order_service->getShopAccountCountInfo($this->instance_id);
        $this->assign("account", $account);
        return view($this->style . "Account/shopSalesAccount");
    }

    /**
     * 前30日销售统计
     *
     * @return Ambigous <multitype:, unknown>
     */
    public function getShopSaleNumCount()
    {
        $order = new Order();
        $data = array();
        list ($start, $end) = Time::month();
        for ($j = 0; $j < ($end + 1 - $start) / 86400; $j ++) {
            $date_start = date("Y-m-d H:i:s", $start + 86400 * $j);
            $date_end = date("Y-m-d H:i:s", $start + 86400 * ($j + 1));
            $count = $order->getOrderCount([
                'shop_id' => $this->instance_id,
                'create_time' => [
                    'between',
                    [
                        $date_start,
                        $date_end
                    ]
                ]
            ]);
            $data[0][$j] = (1 + $j) . '日';
            $data[1][$j] = $count;
        }
        return $data;
    }

    /**
     * 商品销售详情
     *
     * @return Ambigous <multitype:number , multitype:number unknown >
     */
    public function shopGoodsSalesList()
    {
        if (request()->isAjax()) {
            $order = new Order();
            $pageindex = isset($_POST['pageIndex']) ? $_POST['pageIndex'] : 1;
            $goods_name = isset($_POST["goods_name"]) ? $_POST["goods_name"] : '';
            $condition = array();
            if ($goods_name != '') {
                $condition["goods_name"] = array(
                    'like',
                    '%' . $goods_name . '%'
                );
            }
            $condition["shop_id"] = $this->instance_id;
            $list = $order->getShopGoodsSalesList($pageindex, PAGESIZE, $condition, 'create_time desc');
            return $list;
        } else {
            $child_menu_list = array(
                array(
                    'url' => "account/shopGoodsSalesList",
                    'menu_name' => "商品分析",
                    "active" => 1
                ),
                array(
                    'url' => "account/bestSellerGoods",
                    'menu_name' => "热卖商品",
                    "active" => 0
                )
            );
            $this->assign('child_menu_list', $child_menu_list);
            return view($this->style . "Account/shopGoodsSalesList");
        }
    }

    /**
     * 热卖商品
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function bestSellerGoods()
    {
        $child_menu_list = array(
            array(
                'url' => "account/shopGoodsSalesList",
                'menu_name' => "商品分析",
                "active" => 0
            ),
            array(
                'url' => "account/bestSellerGoods",
                'menu_name' => "热卖商品",
                "active" => 1
            )
        );
        $this->assign('child_menu_list', $child_menu_list);
        return view($this->style . "Account/bestSellerGoods");
    }

    /**
     * 商品销售chart数据
     *
     * @return multitype:multitype:unknown
     */
    public function getGoodsSalesChartCount()
    {
        $date = isset($_POST['date']) ? $_POST['date'] : 1;
        $type = isset($_POST['type']) ? $_POST['type'] : 1;
        $category_id_1 = ! empty($_POST['category_id_1']) ? $_POST['category_id_1'] : '';
        $category_id_2 = ! empty($_POST['category_id_2']) ? $_POST['category_id_2'] : '';
        $category_id_3 = ! empty($_POST['category_id_3']) ? $_POST['category_id_3'] : '';
        if ($date == 1) {
            list ($start, $end) = Time::today();
            $start_date = date("Y-m-d H:i:s", $start);
            $end_date = date("Y-m-d H:i:s", $end);
        } else 
            if ($date == 3) {
                $start_date = date('Y-m-d 00:00:00', strtotime('last day this week + 1 day'));
                $end_date = date('Y-m-d 00:00:00', strtotime('last day this week +8 day'));
            } else 
                if ($date == 4) {
                    list ($start, $end) = Time::month();
                    $start_date = date("Y-m-d H:i:s", $start);
                    $end_date = date("Y-m-d H:i:s", $end);
                }
        $condition = array();
        $condition["shop_id"] = $this->instance_id;
        if ($category_id_1 != '') {
            $condition["category_id_1"] = $category_id_1;
            if ($category_id_2 != '') {
                $condition["category_id_2"] = $category_id_2;
                if ($category_id_3 != '') {
                    $condition["category_id_2"] = $category_id_3;
                }
            }
        }
        $order = new Order();
        $goods_list = $order->getShopGoodsSalesQuery($this->instance_id, $start_date, $end_date, $condition);
        
        if ($type == 1) {
            $sort_array = array();
            foreach ($goods_list as $k => $v) {
                $sort_array[$v["goods_name"]] = $v["sales_money"];
            }
            arsort($sort_array);
            $sort = array();
            $num = array();
            $i = 0;
            foreach ($sort_array as $t => $b) {
                if ($i < 30) {
                    $sort[] = $t;
                    $num[] = $b;
                    $i ++;
                } else {
                    break;
                }
            }
            return array(
                $sort,
                $num
            );
        } else 
            if ($type == 2) {
                $sort_array = array();
                foreach ($goods_list as $k => $v) {
                    $sort_array[$v["goods_name"]] = $v["sales_num"];
                }
                arsort($sort_array);
                $sort = array();
                $money = array();
                $i = 0;
                foreach ($sort_array as $t => $b) {
                    if ($i < 30) {
                        $sort[] = $t;
                        $money[] = $b;
                        $i ++;
                    } else {
                        break;
                    }
                }
                return array(
                    $sort,
                    $money
                );
            }
    }

    /**
     * 运营报告
     */
    public function shopReport()
    {
        return view($this->style . "Account/shopReport");
    }

    /**
     * 店铺下单量/下单金额图标数据
     *
     * @return Ambigous <multitype:, unknown>
     */
    public function getShopOrderChartCount()
    {
        $date = isset($_POST['date']) ? $_POST['date'] : 1;
        $type = isset($_POST['type']) ? $_POST['type'] : 1;
        $order = new Order();
        $data = array();
        if ($date == 1) {
            list ($start, $end) = Time::today();
            for ($i = 0; $i < 24; $i ++) {
                $date_start = date("Y-m-d H:i:s", $start + 3600 * $i);
                $date_end = date("Y-m-d H:i:s", $start + 3600 * ($i + 1));
                $condition = [
                    'shop_id' => $this->instance_id,
                    'create_time' => [
                        'between',
                        [
                            $date_start,
                            $date_end
                        ]
                    ]
                ];
                $count = $this->getShopSaleData($condition, $type);
                
                $data[0][$i] = $i . ':00';
                $data[1][$i] = $count;
            }
        } else 
            if ($date == 2) {
                list ($start, $end) = Time::yesterday();
                for ($j = 0; $j < 24; $j ++) {
                    $date_start = date("Y-m-d H:i:s", $start + 3600 * $j);
                    $date_end = date("Y-m-d H:i:s", $start + 3600 * ($j + 1));
                    $condition = [
                        'shop_id' => $this->instance_id,
                        'create_time' => [
                            'between',
                            [
                                $date_start,
                                $date_end
                            ]
                        ]
                    ];
                    $count = $this->getShopSaleData($condition, $type);
                    $data[0][$j] = $j . ':00';
                    $data[1][$j] = $count;
                }
            } else 
                if ($date == 3) {
                    $start = strtotime(date('Y-m-d 00:00:00', strtotime('last day this week + 1 day')));
                    for ($j = 0; $j < 7; $j ++) {
                        $date_start = date("Y-m-d H:i:s", $start + 86400 * $j);
                        $date_end = date("Y-m-d H:i:s", $start + 86400 * ($j + 1));
                        $condition = [
                            'shop_id' => $this->instance_id,
                            'create_time' => [
                                'between',
                                [
                                    $date_start,
                                    $date_end
                                ]
                            ]
                        ];
                        $count = $this->getShopSaleData($condition, $type);
                        $data[0][$j] = '星期' . ($j + 1);
                        $data[1][$j] = $count;
                    }
                } else 
                    if ($date == 4) {
                        list ($start, $end) = Time::month();
                        for ($j = 0; $j < ($end + 1 - $start) / 86400; $j ++) {
                            $date_start = date("Y-m-d H:i:s", $start + 86400 * $j);
                            $date_end = date("Y-m-d H:i:s", $start + 86400 * ($j + 1));
                            $condition = [
                                'shop_id' => $this->instance_id,
                                'create_time' => [
                                    'between',
                                    [
                                        $date_start,
                                        $date_end
                                    ]
                                ]
                            ];
                            $count = $this->getShopSaleData($condition, $type);
                            $data[0][$j] = (1 + $j) . '日';
                            $data[1][$j] = $count;
                        }
                    }
        return $data;
    }

    /**
     * 查询一段时间内的总下单量及下单金额
     *
     * @return multitype:\app\admin\controller_b2c\Ambigous Ambigous <\app\admin\controller_b2c\Ambigous, number, \data\service\niushop\unknown, \data\service\niushop\Order\unknown, unknown>
     */
    public function getOrderShopSaleCount()
    {
        $date = isset($_POST['date']) ? $_POST['date'] : 1;
        // 查询一段时间内的下单量及下单金额
        if ($date == 1) {
            list ($start, $end) = Time::today();
            $start_date = date("Y-m-d H:i:s", $start);
            $end_date = date("Y-m-d H:i:s", $end);
        } else 
            if ($date == 3) {
                $start_date = date('Y-m-d 00:00:00', strtotime('last day this week + 1 day'));
                $end_date = date('Y-m-d 00:00:00', strtotime('last day this week +8 day'));
            } else 
                if ($date == 4) {
                    list ($start, $end) = Time::month();
                    $start_date = date("Y-m-d H:i:s", $start);
                    $end_date = date("Y-m-d H:i:s", $end);
                }
        $condition = array();
        $condition["shop_id"] = $this->instance_id;
        $condition["shop_id"];
        $condition["create_time"] = [
            'between',
            [
                $start_date,
                $end_date
            ]
        ];
        $count_money = $this->getShopSaleData($condition, 1);
        $count_num = $this->getShopSaleData($condition, 2);
        return array(
            "count_money" => $count_money,
            "count_num" => $count_num
        );
    }

    /**
     * 下单量/下单金额 数据
     *
     * @param unknown $condition            
     * @param unknown $type            
     * @return Ambigous <\data\service\niushop\Ambigous, \data\service\niushop\Order\unknown, number, unknown>
     */
    public function getShopSaleData($condition, $type)
    {
        $order = new Order();
        if ($type == 1) {
            $count = $order->getShopSaleSum($condition);
            $count = (float) sprintf('%.2f', $count);
        } else {
            $count = $order->getShopSaleNumSum($condition);
        }
        return $count;
    }

    /**
     * 同行商品买卖
     */
    public function shopGoodsGroupSaleCount()
    {
        $goods_category = new GoodsCategory();
        $list = $goods_category->getGoodsCategoryListByParentId(0);
        $this->assign("cateGoryList", $list);
        return view($this->style . "Account/shopGoodsGroupSaleCount");
    }
}