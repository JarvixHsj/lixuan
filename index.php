<?php
//error_reporting(E_ALL | E_STRICT);
//ini_set("display_errors", "On");
//$_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URL'];
// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------
/* SESSION会话名称 */
//session_name('s' . substr(md5(__FILE__), 0, 8));
//var_dump($_SERVER);die;
/* 定义应用目录 */
define('APP_PATH', __DIR__ . '/application/');

/* 定义Runtime运行目录 */
//define('RUNTIME_PATH', __DIR__ . '/runtime/');

/* 加载框架引导文件 */
require __DIR__ . '/thinkphp/start.php';
