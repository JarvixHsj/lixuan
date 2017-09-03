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
use service\AgentService;
use think\response\View;
use think\Url;
use model\Product;
use model\Agent;
use model\UserInvite;
use model\User;
use think\Db;

/**
 * 采购控制器
 * Class Purchase
 * @package app\index\controller
 * @author Jarvix <zoujingli@qq.com>
 * @date 2017/04/05 10:38
 */
class Purchase extends BasicAgent {

//    private $_agentType = array('1'=>'首席CEO', '2' => '核心总监', '3' => '总代', '4'=>'一级', '5'=>'特约');

    /**
     * 我的代理信息
     */
    public function index() {
        return view('index');
//        return view('recordtr');
//        return view('content');
//    	$Model = new Agent();
//    	$list = $Model->getUserAgentList(session('agent.id'));
//        if(!$list) $list = array();
//
//    	$this->assign('list', $list);
//    	$this->assign('agenttype', $this->_agentType);
//    	return view();
    }


}
