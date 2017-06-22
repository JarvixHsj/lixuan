<?php

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

namespace app\html\controller;

use controller\BasicAgent;
use think\response\View;
use model\Product;

/**
 * 代理基础空机器
 * Class Index
 * @package app\index\controller
 * @author Jarvix <zoujingli@qq.com>
 * @date 2017/04/05 10:38
 */
class Agent extends BasicAgent {

    /**
     * 代理入口
     */
    public function index() {
    	$Model = new Product;
    	$list = $Model->order('id', 'desc')->select()->toArray();

    	$this->assign('list', $list);
    	return view();
    }


    









}
