<?php
/**
 * 开发规范：
 * 1.不同版本不同控制器以及模板
 * 2.不同版本不同数据库，但是对应数据表表结构必须一致
 * 3.不同版本共用service层，所以修改表结构必须所有版本统一
 */
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 检测PHP环境
if (version_compare(PHP_VERSION, '5.4.0', '<'))
    die('require PHP > 5.4.0 !');

// 发布代码的时候把下面的代码放开 2017年5月12日 09:29:16
 if (! file_exists('./install.lock')) {
     header('location: ./install.php');
     exit();
 }
// [ 应用入口文件 ]
// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
/**
 * **************************************************************版本定义*******************************************************************************
 */
define('NS_VER_B2C', 'NS_VER_B2C'); // 单店版基础电商
define('NS_VER_B2C_FX', 'NS_VER_B2C_FX'); // 单店版分销
define('NS_VER_B2B2C_FX1', 'NS_VER_B2B2C_FX1'); // 平台化电商店铺独立分销
define('NS_VER_B2B2C_FX2', 'NS_VER_B2B2C_FX2'); // 平台化电商平台分销
define('IS_OPEN_BUSINESS', true); // 是否启用招商模块
/**
 * **************************************************************版本定义*******************************************************************************
 */

define('NS_VERSION', NS_VER_B2C);
switch (NS_VERSION) {
    case NS_VER_B2C:
        define('NS_CONTROLLER', 'controller_b2c');
        define('NS_TEMPLATE', 'b2c');
        define('NS_DATABASE', 'niushop_b2c');
        break;
    case NS_VER_B2C_FX:
        define('NS_CONTROLLER', 'controller_b2c');
        define('NS_TEMPLATE', 'b2c');
        define('NS_DATABASE', 'niushop_b2c_fx');
        break;
    case NS_VER_B2B2C_FX1:
        define('NS_CONTROLLER', 'controller');
        define('NS_TEMPLATE', 'default');
        define('NS_DATABASE', 'niushop_business1');
        break;
    case NS_VER_B2B2C_FX2:
        define('NS_CONTROLLER', 'controller');
        define('NS_TEMPLATE', 'default');
        define('NS_DATABASE', 'niushop_business2');
        break;
}

require APP_PATH . 'error_message.php';
// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';


