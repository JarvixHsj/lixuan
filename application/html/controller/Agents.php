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
use model\Product;
use model\Agent;
use model\UserInvite;

/**
 * 代理基础控制器
 * Class Index
 * @package app\index\controller
 * @author Jarvix <zoujingli@qq.com>
 * @date 2017/04/05 10:38
 */
class Agents extends BasicAgent {

    private $_agentType = array('1'=>'首席CEO', '2' => '核心总监', '3' => '总代', '4'=>'一级', '5'=>'特约');

    /**
     * 代理入口
     */
    public function index() {
    	$Model = new Product;
    	$list = $Model->order('id', 'desc')->select()->toArray();

    	$this->assign('list', $list);
    	return view();
    }

    
    //新代理加盟 入口
    public function new_agent_index()
    {
        $AgentModel = new Agent;
        $list = $AgentModel->alias('a')
        ->field('a.*,p.name')
        ->join('lx_product p', 'a.product_id = p.id')
        ->where('a.user_id', session('agent.id'))
        ->select()->toArray();

        $this->assign('agenttype', $this->_agentType);
        $this->assign('list', $list);
        return view();
    }

    //ajax请求获取当前出产品可邀请的等级
    public function ajax_get_level()
    {
        $pro_id = $this->request->post('product_id') ? trim($this->request->post('product_id')) : '';
        if(empty($pro_id) || empty(session('agent'))){
            return false;
        }
        //查询该代理产品关系是否存在
        $AgentModel = new Agent;
        $where['product_id'] = $pro_id;
        $where['user_id'] = session('agent.id');
        $res = $AgentModel->where($where)->find()->toArray();
        if(!array_key_exists($res['level'], $this->_agentType)){
            return false;
        }
        $tempLevel = $this->_agentType;
        foreach($tempLevel as $key => $val) {
            if($key < $res['level']){
                unset($tempLevel[$key]);
            }
        }

        return $tempLevel;
    }

    //邀请代理分享页 生成url写入数据库
    public function ajax_inviteshare()
    {
        $result = array('status' => 0, 'url' => '', 'message' => '参数错误！');
        //接收需要分享的产品id和等级id
        $pro_id = $this->request->post('product_id') ? trim($this->request->post('product_id')) : '';
        $level = $this->request->post('level_id') ? trim($this->request->post('level_id')) : '';
        if(empty($pro_id) || empty(session('agent'))){
            return $result;
        }
        $ProModel = new product;
        $proData = $ProModel->find($pro_id);
        if(!$proData){
            $result['message'] = '该产品不存在！';
            return $result;
        }
        if(!array_key_exists($level, $this->_agentType)) return $resule;
        $share_url = $this->request->header()['origin'].'/'.$this->request->module().'/Tourists/tobeinvited?share_no='.$saveData['share_no'];
        $UserInviteModel = new UserInvite;
        //获取分享唯一号
        $newTime = time();
        $saveData['share_no'] = AgentService::createAgentInvite();        
        $saveData['user_id'] = session('agent.id');      
        $saveData['product_id'] = $proData['id'];        
        $saveData['product_name'] = $proData['name'];        
        $saveData['level'] = $level;        
        $saveData['start_at'] = $newTime;
        $saveData['end_in'] = $newTime + 3600;        
        $saveData['share_url'] = $share_url;
        $UserInviteModel->allowField(true)->save($saveData);
        if($UserInviteModel->id){
            $result['status'] = 1;
            $result['url'] = $share_url;
            return $result;
        }
        return $result;
    }






}
