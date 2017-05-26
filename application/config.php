<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------
    
    // 应用命名空间
    'app_namespace' => 'app',
    // 应用调试模式，正式发布版本时改为false
    'app_debug' => true,
    // 应用Trace
    'app_trace' => false,
    // 应用模式状态
    'app_status' => '',
    // 是否支持多模块
    'app_multi_module' => true,
    // 入口自动绑定模块
    'auto_bind_module' => false,
    // 注册的根命名空间
    'root_namespace' => [],
    // 扩展配置文件
    'extra_config_list' => [
        'database',
        'validate'
    ],
    // 扩展函数文件
    'extra_file_list' => [
        THINK_PATH . 'helper' . EXT
    ],
    // 默认输出类型
    'default_return_type' => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return' => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler' => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler' => 'callback',
    // 默认时区
    'default_timezone' => 'PRC',
    // 是否开启多语言
    'lang_switch_on' => false,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter' => '',
    // 默认语言
    'default_lang' => 'zh-cn',
    // 应用类库后缀
    'class_suffix' => false,
    // 控制器类后缀
    'controller_suffix' => false,
    
    // +----------------------------------------------------------------------
    // | 模块设置
    // +----------------------------------------------------------------------
    
    // 默认模块名
    'default_module' => 'wap',
    // 禁止访问模块
    'deny_module_list' => [
        'common'
    ],
    // 默认控制器名
    'default_controller' => 'Index',
    // 默认操作名
    'default_action' => 'index',
    // 默认验证器
    'default_validate' => '',
    // 默认的空控制器名
    'empty_controller' => 'Error',
    // 操作方法后缀
    'action_suffix' => '',
    // 自动搜索控制器
    'controller_auto_search' => false,
    
    // +----------------------------------------------------------------------
    // | URL设置
    // +----------------------------------------------------------------------
    
    // PATHINFO变量名 用于兼容模式
    'var_pathinfo' => 's',
    // 兼容PATH_INFO获取
    'pathinfo_fetch' => [
        'ORIG_PATH_INFO',
        'REDIRECT_PATH_INFO',
        'REDIRECT_URL'
    ],
    // pathinfo分隔符
    'pathinfo_depr' => '/',
    // URL伪静态后缀
    'url_html_suffix' => 'html',
    // URL普通方式参数 用于自动生成
    'url_common_param' => false,
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type' => 0,
    // 是否开启路由
    'url_route_on' => true,
    // 路由配置文件（支持配置多个）
    'route_config_file' => [
        'route'
    ],
    // 是否强制使用路由
    'url_route_must' => false,
    // 域名部署
    'url_domain_deploy' => false,
    // 域名根，如thinkphp.cn
    'url_domain_root' => '',
    // 是否自动转换URL中的控制器和操作名
    'url_convert' => true,
    // 默认的访问控制器层
    'url_controller_layer' => NS_CONTROLLER,
    // 表单请求类型伪装变量
    'var_method' => '_method',
    
    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------
    
    'template' => [
        // 模板引擎类型 支持 php think 支持扩展
        'type' => 'Think',
        // 模板路径
        'view_path'    =>'template/',

        // 模板后缀
        'view_suffix' => 'html',
        // 模板文件名分隔符
        'view_depr' => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin' => '{',
        // 模板引擎普通标签结束标记
        'tpl_end' => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end' => '}'
    ],
    
    // 视图输出字符串内容替换
    'view_replace_str' => [],
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl' => ROOT_PATH . 'template' . DS . 'success_tmpl.html',
    'dispatch_error_tmpl' => ROOT_PATH . 'template' . DS . 'error_tmpl.html',
    
    // +----------------------------------------------------------------------
    // | 异常及错误设置
    // +----------------------------------------------------------------------
    
    // 异常页面的模板文件
    'exception_tmpl' => ROOT_PATH . 'template' . DS . 'think_exception.html',
    
    // 错误显示信息,非调试模式有效
    'error_message' => '页面不存在，请检验网址是否正确',
    // 显示错误信息
    'show_error_msg' => false,
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle' => '',
    
    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------
    
    'log' => [
        // 日志记录方式，内置 file socket 支持扩展
        'type' => 'File',
        // 日志保存目录
        'path' => LOG_PATH,
        // 日志记录级别
        'level' => []
    ],
    
    // +----------------------------------------------------------------------
    // | Trace设置 开启 app_trace 后 有效
    // +----------------------------------------------------------------------
    'trace' => [
        // 内置Html Console 支持扩展
        'type' => 'Html'
    ],
    
    // +----------------------------------------------------------------------
    // | 缓存设置
    // +----------------------------------------------------------------------
    
    'cache' => [
        // 驱动方式
        'type' => 'File',
        // 缓存保存目录
        'path' => CACHE_PATH,
        // 缓存前缀
        'prefix' => '',
        // 缓存有效期 0表示永久缓存
        'expire' => 0
    ],
    
    // +----------------------------------------------------------------------
    // | 会话设置
    // +----------------------------------------------------------------------
    
    'session' => [
        'id' => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix' => 'niu',
        // 驱动方式 支持redis memcache memcached
        'type' => '',
        // 是否自动开启 SESSION
        'auto_start' => true
    ],
    
    // +----------------------------------------------------------------------
    // | Cookie设置
    // +----------------------------------------------------------------------
    'cookie' => [
        // cookie 名称前缀
        'prefix' => '',
        // cookie 保存时间
        'expire' => 0,
        // cookie 保存路径
        'path' => '/',
        // cookie 有效域名
        'domain' => '',
        // cookie 启用安全传输
        'secure' => false,
        // httponly设置
        'httponly' => '',
        // 是否使用 setcookie
        'setcookie' => true
    ],
    'view_replace_str' => array(
        '__PUBLIC__' =>\think\Request::instance()->root().'/public/',
        '__STATIC__' =>__ROOT__.'/public/static',
        'ADMIN_IMG' =>  __ROOT__.'/public/admin/images',
        'ADMIN_CSS' => __ROOT__.'/public/admin/css',
        'ADMIN_JS' => __ROOT__.'/public/admin/js',
        'PLATFORM_IMG' =>  __ROOT__.'/public/platform/images',
        'PLATFORM_CSS' =>__ROOT__.'/public/platform/css',
        'PLATFORM_JS' => __ROOT__.'/public/platform/js',
        '__TEMP__' => __ROOT__.'/template',
        '__ROOT__'=>__ROOT__,
        'UPLOAD_URL' =>\think\Request::instance()->root().'/admin',
        'PLATFORM_MAIN'=>\think\Request::instance()->root().'/platform',
        'ADMIN_MAIN'=>\think\Request::instance()->root().'/admin',
        'APP_MAIN' =>\think\Request::instance()->root().'/wap',
        'SHOP_MAIN' =>\think\Request::instance()->root().'/shop',
        '__UPLOAD__' => __ROOT__,
        '__MODULE__' => '/admin'
    ),
    //验证码排至文件
    'captcha' => [
        //2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY
        //niushop2017459ABCDEFGHJKLMNQRTVWXYZ
    // 验证码字符集合
        'codeSet' => '0123456789',
        // 验证码字体大小(px)
        'fontSize' => 15,

        // 是否画混淆曲线
        'useCurve' => false,
        
        // 是否添加杂点
        'useNoise' => false,
        
        // 验证码图片高度
        'imageH' => 30,
        // 验证码图片宽度
        'imageW' => 100,
        // 验证码位数
        'length' => 4,
        // 验证成功后是否重置
        'reset' => true
    ],
    // 分页配置
    'paginate' => [
        'type' => 'bootstrap',
        'var_page' => 'page',
        'list_rows' => 10,
        'list_showpages' => 5,
        'picture_page_size' => 15
    ],
    'alipay' => [
//         'use_sandbox'               => true,// 是否使用沙盒模式

//         'partner'                   => '2088911647939755',
//         'app_id'                    => '2016030301178543',
//         'sign_type'                 => 'RSA',// RSA  RSA2

//         // 可以填写文件路径，或者密钥字符串  当前字符串是 rsa2 的支付宝公钥(开放平台获取)
//         'ali_public_key'            => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB',

//         // 可以填写文件路径，或者密钥字符串  我的沙箱模式，rsa与rsa2的私钥相同，为了方便测试
//         'rsa_private_key'           => 'MIICXQIBAAKBgQC5pz3G3VVEPyLfw7H3/aQ+VGT5UKuYC7kr1FZW9pXBIHihIq7A
// aDyNnak6r5PqvMoh1xBZ49Ciaf/hG8Eu6/XbEL8HPlko42Zxa3uAADoBjhisjeoR
// b35h4W963Yo+OCMm9b1AiEaOddw+aNMXWv/r6JFazsLoEaczZJSLgs6pgQIDAQAB
// AoGAZcnIGSxo/44ONNk6zlkGoBXtdrRAIJDs6Zb176Aq40RGXzKA1YVRDeQPUNnL
// I7x2pq8fi+lYDnRHksiA1pUQqiee17UUw4QQiFaeFyHnXaeLJIQbh66SRRFGZZZi
// M7pGV8D/h/gSqYMSqj3sqK7/woLWii+qWhW1vMrYiNgrtXECQQDpMC9RnWCTcyJC
// sS7z2ZMrIuovdvayfiC/lmKHN/Con1w45lmMvZ9hGzAchjpfeuacYsWs8M6Rv35R
// 49mZZIgfAkEAy9CfTJkuamzLY63OTF2y0ZWpo0XLL0PiJpUigWmSLll1Ii82J1Fo
// cV9MIpYrsnmyNOQx215/heQZRM8pbbMaXwJBAKuxfMW8+KTYevtb9lQ5ePCj7oYw
// M4hM8dPe6IDjIWEmpQKIKJtF6xnWqN/3vPccSLwQxbeGPrJ1qo6lE0ysBsUCQQC+
// Y6+rOhylxeNoxd9EbvKv3YKNxpC7IkqLiBynjxrCuUY2HKwVpnJOFZtlY6qGGjBi
// QBhit6+gPydro6krlHc5AkADRjCqIXaSJj9IbdF+6AGsRRc2QePfJvTcRmtVyBZ7
// aZ/6vV0PmvATaO3CC7CvaFL2MChVF8Zb6PlyXH/WPFMj',

//         'limit_pay'                 => [
//             //'balance',// 余额
//             //'moneyFund',// 余额宝
//             //'debitCardExpress',//     借记卡快捷
//             //'creditCard',//信用卡
//             //'creditCardExpress',// 信用卡快捷
//             //'creditCardCartoon',//信用卡卡通
//             //'credit_group',// 信用支付类型（包含信用卡卡通、信用卡快捷、花呗、花呗分期）
//         ],// 用户不可用指定渠道支付当有多个渠道时用“,”分隔

//         // 与业务相关参数
//         'notify_url'                => 'https://helei112g.github.io/v1/notify/ali',
//         'return_url'                => 'https://helei112g.github.io/',

//         'return_raw'                => false,// 在处理回调时，是否直接返回原始数据，默认为 true
//     ],
    'use_sandbox'               => true,// 是否使用沙盒模式

    'partner'                   => '2088102169252684',
    'app_id'                    => '2016073100130857',
    'sign_type'                 => 'RSA2',// RSA  RSA2

    // 可以填写文件路径，或者密钥字符串  当前字符串是 rsa2 的支付宝公钥(开放平台获取)
    'ali_public_key'            => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmBjJu2eA5HVSeHb7jZsuKKbPp3w0sKEsLTVvBKQOtyb7bjQRWMWBI7FrcwEekM1nIL+rDv71uFtgv7apMMJdQQyF7g6Lnn9niG8bT1ttB8Fp0eud5L97eRjFTOa9NhxUVFjGDqQ3b88o6u20HNJ3PRckZhNaFJJQzlahCpxaiIRX2umAWFkaeQu1fcjmoS3l3BLj8Ly2zRZAnczv8Jnkp7qsVYeYt01EPsAxd6dRZRw3uqsv9pxSvyEYA7GV7XL6da+JdvXECalQeyvUFzn9u1K5ivGID7LPUakdTBUDzlYIhbpU1VS8xO1BU3GYXkAaumdWQt7f+khoFoSw+x8yqQIDAQAB',

    // 可以填写文件路径，或者密钥字符串  我的沙箱模式，rsa与rsa2的私钥相同，为了方便测试
    'rsa_private_key'           => 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC/z+Ue/oS0GjO2
myYrkdopw5qq6Ih/xlHBx0HBE0xA2dRinpMuZeI0LUUtN54UAUZbDz8rcaOCb0je
loeYolw54tadcIw4Q2hbdeJPplldJZyi1BDYtBJZvAveeRSidHdmBSUtOtCBXUBl
JUP3I8/R4c34Ii4Pm/K4vmhwLf/zqZAedKGhYP6m5q+p8sfBHRPy97/KluLPiSTR
FqGSRmd0IitUGK+KQ5qsAfJXyN1oVR4jBYaxfx7dWkTWmxAfNqtKfMvu2a5lH6hv
ClN+w4RUDBu3939bLjCYKcAomkv3QMquMP46m+D8Ny+3mGk5L9Ul4jyxlFTlV4L4
JM3g/02xAgMBAAECggEBALZliwseHDLnd6V9g56K41ozlzBOTv6yJ6yNPgnLwAcr
HLtq76p/V8smAVIuQTPkwnJ03S0CsumlyTVhDzAltG2XN14fWDdoYiQWxU3YccIR
shFkd2CaW5jZKLA1k1moRqHM4r1P4FYjxshn12l7tHNwtdvvJL3THcxvxABovauF
OVtznpRlnfJLjn2Lg+xNsxaYy3zL8L6nL7MXUWLKvmLiZn64PFcw7cf+9n2exRDs
wn0wDCpypGqOVVXVFeZaXTwmOoxgIUAZfAExdLtabGGCAz1lTsA0+r4DW2nSTe8C
Fy1Db+fcCTm+uQ3y6jDwuS3tB8V+PQKog3+ReZp/9sECgYEA/NEr+ln6DTy7u4rC
Wq7mixRJ1kaiAUph/hADrUwhkMiUapSMNAIXblFB+BQUjFZQmXEbcvz0Y70g9Zi9
JCXVTiDTBe7jj/FK63MU0F9KY5OducpVV+RhSpNy/i1M2qeW4gO351PpPHUpRUYr
GkYvAKktqrSOdBEWD3IeKLYDXxMCgYEAwjoavGjWzD9Xckbpb8yrQ+gHfLeWDKh7
BgvoBGagyqbzIOZU9wg3dSQ2F5eMWDxWVRGqap3fIHxcA0/VMqXG1DrvSIUC4SE8
Zys515fR00c9h3W3IugHnKgdYcV7nZrJoPZXlMjPOo39FCBnfbrUOgnKwxMlz3lV
vC6465ODhKsCgYEAmUtTuTd5kTE0O+FFO6s1iztAEjc94D5z8JNRR3EUITAeHgn4
gUiLYI7Qy1WRqA5mTMPyeuS6Ywe4xnJYrWRrVDY+/if9v7f1T5K2GirNdld5mb//
w41tGMUTQt/A7AwWRvEuP4v3rnr0DVcgp4vK0EHEuO9GOUZq8+6kLtc+cBUCgYBF
J/kzEsVAjmEtkHA33ZExqaFY1+l2clrziTPAtWYVIiK5mSmxl9xfOliER/KxzDIV
MigStEmpQH5ms3s/AGXuVVmz4aBn1rSyK2L6D9WnO9t9qv1dUW68aeOkV3OvZ1jZ
lj0S/flDaSEulGclDmvYinoGwX+aAyLy0VQIlUqj5wKBgHEUEf7YDnvw/IBnF1E4
983/7zBx9skoHhpEZsh2+1or7LIw6z0m3lsNBnK0MZZBmW/7HwOtVfhXUUPbVrOJ
di70YoMynX3gjK3LTXhzISheZgcNRKTqiJgVunPokJxQRyYcAfaQeuIm9O8cCPE1
rZpNAzCdd4NSj83UZRm3YOmC',

    'limit_pay'                 => [
        //'balance',// 余额
        //'moneyFund',// 余额宝
        //'debitCardExpress',//     借记卡快捷
        //'creditCard',//信用卡
        //'creditCardExpress',// 信用卡快捷
        //'creditCardCartoon',//信用卡卡通
        //'credit_group',// 信用支付类型（包含信用卡卡通、信用卡快捷、花呗、花呗分期）
    ],// 用户不可用指定渠道支付当有多个渠道时用“,”分隔

    // 与业务相关参数
    'notify_url'                => 'https://helei112g.github.io/v1/notify/ali',
    'return_url'                => 'https://helei112g.github.io/',

    'return_raw'                => false,// 在处理回调时，是否直接返回原始数据，默认为 true

    ],
    'wxpay' =>[
        'use_sandbox'       => true,// 是否使用 微信支付仿真测试系统

        'app_id'            => 'xxxxxx',  // 公众账号ID
        'mch_id'            => 'xxxxxx',// 商户id
        'md5_key'           => 'xxxxxxx',// md5 秘钥
        'app_cert_pem'      => 'weixin_app_cert.pem',
        'app_key_pem'       => 'weixin_app_key.pem',
        'sign_type'         => 'MD5',// MD5  HMAC-SHA256
        'limit_pay'         => [
            //'no_credit',
        ],// 指定不能使用信用卡支付   不传入，则均可使用
        'fee_type'          => 'CNY',// 货币类型  当前仅支持该字段

        'notify_url'        => 'https://helei112g.github.io/v1/notify/wx',

        'redirect_url'      => 'https://helei112g.github.io/',// 如果是h5支付，可以设置该值，返回到指定页面

        'return_raw'        => false,// 在处理回调时，是否直接返回原始数据，默认为true
    ]
];
