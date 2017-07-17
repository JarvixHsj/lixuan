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
 * 代理信息控制器
 * Class Agents
 * @package app\index\controller
 * @author Jarvix <zoujingli@qq.com>
 * @date 2017/04/05 10:38
 */
class Users extends BasicAgent {

//    private $_agentType = array('1'=>'首席CEO', '2' => '核心总监', '3' => '总代', '4'=>'一级', '5'=>'特约');

    /**
     * 我的代理信息
     */
    public function index() {
    	$Model = new Agent();
    	$list = $Model->getUserAgentList(session('agent.id'));
        if(!$list) $list = array();

    	$this->assign('list', $list);
    	$this->assign('agenttype', $this->_agentType);
    	return view();
    }

    
    //个人资料 入口
    public function personal()
    {
        $UserModel = new User();
        $UserData = $UserModel->find(session('agent.id'))->toArray();
        $Model = new Agent();
        $AgentData = $Model->getUserAgentList(session('agent.id'));
        if ($AgentData) {
            foreach ($AgentData as $key => $val) {
                if ($val['super_id'] > 0) {
                    $superData = $UserModel->field('username')->find($val['super_id'])->toArray();
                    if ($superData) {
                        $AgentData[$key]['super_name'] = $superData['username'];
                    }else{
                        $AgentData[$key]['super_name'] = '不存在！';
                    }
                }else{
                    $AgentData[$key]['super_name'] = '励轩总公司';
                }
            }
        } else {
            $AgentData = array();
        }


        $data = array();
        $data['userinfo'] = $UserData;
        $data['agentinfo'] = $AgentData;

        $this->assign('agenttype', $this->_agentType);
        $this->assign('data', $data);
        return view();
    }


    //ajax请求获取当前出产品可邀请的等级
    public function ajax_get_level()
    {
        $pro_id = $this->request->post('product_id') ? trim($this->request->post('product_id')) : '';
        // $agent_id = $this->request->post('agent_id') ? trim($this->request->post('agent_id')) : '';
        if (empty($pro_id) || empty(session('agent'))) {
            return false;
        }
        //查询该代理产品关系是否存在
        $AgentModel = new Agent;
        $where['product_id'] = $pro_id;
        $where['user_id'] = session('agent.id');
        $res = $AgentModel->where($where)->find()->toArray();
        if (!array_key_exists($res['level'], $this->_agentType)) {
            return false;
        }
        $tempLevel = $this->_agentType;
        foreach ($tempLevel as $key => $val) {
            if ($key < $res['level']) {
                unset($tempLevel[$key]);
            }
        }

        return $tempLevel;
    }

    /**
     * 查看授权
     * @return View
     */
    public function auth()
    {
        $agent_id = $this->request->param('id');
        $UserData = Db::table('lx_user')->find(session('agent.id'));
        $AgentData = Db::table('lx_agent')->alias('a')
            ->join('lx_product p', 'p.id = a.product_id')
            ->where('a.id = '.$agent_id)
            ->field("a.*,p.name")
            ->find();
        $this->assign('user_info', $UserData);
        $this->assign('agent_info', $AgentData);
        $this->assign('agentType', $this->_agentType);
        return view();
    }

    public function message()
    {

        return view();
    }



    /**
     * 修改密码页面
     * @return View
     */
    public function passwd()
    {
        return view();
    }

    /**
     * 修改密码
     * @return array
     */
    public function ajax_modifypasswd()
    {
        $result = array('status' => 0, 'message' => '参数有误！', 'url' => '');
        $mobile = $this->request->param('mobile') ? trim($this->request->param('mobile')) : '';
        $password = $this->request->param('password') ? trim($this->request->param('password')) : '';
        $afirmpassword = $this->request->param('afirmpassword') ? trim($this->request->param('afirmpassword')) : '';
        //判断参数
        if (empty($mobile) || empty($password) || empty($afirmpassword)) {
            return $result;
        }
        if ($mobile != session('agent.mobile')) {
            $result['message'] = '手机号不是当前登录账号~';
           return $result;
        }
        if($password !== $afirmpassword){
            $result['message'] = '两次密码不一致！';
            return $result;
        }

        $UserModel = new User();
        $savadata = array('password' => md5($password));
        if($UserModel->updatePassword(array('id' => session('agent.id')), $savadata) !== false) {
            $result['message'] = '修改成功';
            $result['status'] = 1;
            $result['url'] = Url::build('html/Users/personal');
            return $result;
        }

        $result['message'] = '网络出错，修改失败~';
        return $result;
    }





}
