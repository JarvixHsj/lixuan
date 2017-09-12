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
use model\User;

/**
 * 代理基础控制器
 * @package app\index\controller
 * @author Jarvix <zoujingli@qq.com>
 * @date 2017/04/05 10:38
 */
class Agents extends BasicAgent {

    /**
     * 代理入口
     */
    public function index() {
    	$Model = new Product;
    	$list = $Model->order('id', 'desc')->select()->toArray();

        $messNum = AgentService::getMessageUnreadNum(session('agent.id'));
        if($messNum !== false){
            $this->assign('mess_num', $messNum);
        }

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
        ->where('p.is_delete' , 1)
        ->select()->toArray();
        $this->assign('agenttype', $this->_agentType);
        $this->assign('list', $list);
        return view();
    }

    //ajax请求获取当前出产品可邀请的等级
    public function ajax_get_level()
    {
        $pro_id = $this->request->post('product_id') ? trim($this->request->post('product_id')) : '';
        // $agent_id = $this->request->post('agent_id') ? trim($this->request->post('agent_id')) : '';
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
        $tempLevel = $this->_selectAgent;
        foreach($tempLevel as $key => $val) {
            if($key < $res['level']){
                unset($tempLevel[$key]);
            }
            if($res['level'] == 1){
                if($key == 1){
                    unset($tempLevel[$key]);
                }
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
        $agent_id = $this->request->post('agent_id') ? trim($this->request->post('agent_id')) : '';
        if(empty($pro_id) || empty(session('agent')) || empty($agent_id)){
            return $result;
        }
        //判断代理的产品代理记录是否存在
        $AgentModel = new agent;
        $AgentData = $AgentModel->find($agent_id);
        if(!$AgentData) return $result;
        //判断产品是否存在
        $ProModel = new product;
        $proData = $ProModel->find($pro_id);
        if(!$proData){
            $result['message'] = '该产品不存在！';
            return $result;
        }    
        if(!array_key_exists($level, $this->_agentType)) return $result;
          //获取分享唯一号
        $newTime = time();
        $saveData['share_no'] = AgentService::createAgentInvite();
        //组合连接
        $share_url = 'http://'.$this->request->header()['host'].$this->request->baseFile().'/'.$this->request->module().'/Tourists/tobeinvited?share_no='.$saveData['share_no'];
//        var_dump($share_url);die;

        $UserInviteModel = new UserInvite;
        //组合数据
        $saveData['user_id'] = session('agent.id');      
        $saveData['product_id'] = $proData['id'];        
        $saveData['product_name'] = $proData['name'];        
        $saveData['level'] = $level;        
        $saveData['start_at'] = $newTime;
        $saveData['end_in'] = $newTime + 3600;        
        $saveData['share_url'] = $share_url;
        $saveData['agent_id'] = $agent_id;
        $UserInviteModel->allowField(true)->save($saveData);
        if($UserInviteModel->id){
            $result['status'] = 1;
            $result['url'] = $share_url;
            return $result;
        }
        return $result;
    }

    //邀请记录
    public function inviterecord()
    {
        $agent_id = $this->request->param('id') ? trim($this->request->param('id')) : '';
//        if(empty($agent_id)) $this->error('请求有误，请重试！');
        
//        $AgentModel = new Agent;
//        $AgentData = $AgentModel->getOneInfo(array('id' => $agent_id));
        
        $UserInviteModel = new UserInvite;
        $inviteData = $UserInviteModel->getInviteList(array('agent_id' => $agent_id));
        if($inviteData) {
            $newTime = time();
            foreach($inviteData as $key => $val) {
                $inviteData[$key]['countdown'] = 0;
                if($val['end_in'] >= $newTime){
                    $inviteData[$key]['countdown'] = $val['end_in'] - $newTime;
                }
            }
        }else{
            $inviteData = array();
        } 
        
        $this->assign('list', $inviteData);
        return view();

    }


    //查看下级代理
    public function looksublist()
    {
        $pro_id = $this->request->param('pro_id') ? trim($this->request->param('pro_id')) : '';
        //用户信息
        $UserModel = new User;
        $AgentModel = new Agent;
        $userData = $UserModel->field('id,username,wechat_no,mobile')->find(session('agent.id'))->toArray();

        //用户代理的产品
        $AgentData = $AgentModel->alias('a')
            ->field('a.*,p.name')
            ->join('lx_product p', 'p.id = a.product_id')
            ->where('a.user_id', session('agent.id'))
            ->where('p.is_delete' , 1)
            ->order('a.id desc')->select()->toArray();
        $data = array();

        if($pro_id) {
            //等级统计
            $TempCountAgnetData = $AgentModel->alias('a')
                ->field('a.level,count(a.level) as countlevel')
                ->where('a.super_id', session('agent.id'))
                ->where('a.product_id', $pro_id)
                ->group('a.level')
                ->select()->toArray();
            $data['countagent'] = $TempCountAgnetData;
            //查询用户代理等级
            $levelInfo = $AgentModel->field("level")
                ->where(array('user_id' => session('agent.id'), 'product_id'=>$pro_id))
                ->find();

            if($levelInfo){
                $data['user_level'] = $levelInfo->toArray()['level'];
            }


            //统计下级信息
            $subData = $AgentModel->alias('a')
                ->field('a.id as agent_id,u.id as user_id,u.wechat_no,u.mobile,u.username,a.empower_sn,a.level')
                ->join('lx_user u', "u.id = a.user_id")
                ->where('a.super_id', session('agent.id'))
                ->where('a.product_id', $pro_id)
                ->order('a.id desc')
                ->select();
            if($subData) $subData->toArray();
            if($subData){
                //统计代理的直属人数和团队人数
                foreach($subData as $key=>$val){
                    $subData[$key]['totaldirectly'] = AgentService::totalDirectlyNum($val['user_id'],$pro_id);
                    $subData[$key]['totalteam'] = AgentService::totalAgentTeam($val['user_id'], $pro_id) + 1;
                }
                $data['subinfo'] = $subData;
            }
        }
        $data['userinfo'] = $userData;
        $data['agentinfo'] = $AgentData;
        $data['agenttype'] = $this->_agentType;

        $this->assign('data', $data);
        $this->assign('pro_id', $data);
        return view();
    }

    /**
     * 查看代理所有下级（无限极）
     */
    public function seeSubList()
    {
        $user_id = $this->request->param('user_id') ? trim($this->request->param('user_id')) : 0;
        $pro_id = $this->request->param('pro_id') ? trim($this->request->param('pro_id')) : 0;

        $resList = AgentService::agentTeamList($user_id,$pro_id);
        $UserModel = new User;
        if ($resList) {
            $resList = agent_array_to_ring($resList);
            if(is_array($resList)){
                foreach($resList as $key=>$val){
                    $tempUserInfo = $UserModel->field('username,mobile,wechat_no')->find($val['user_id']);
                    if($tempUserInfo){
                        $resList[$key]['user_username'] = $tempUserInfo['username'] ? $tempUserInfo['username'] : ' ';
                        $resList[$key]['user_mobile'] = $tempUserInfo['mobile'] ? $tempUserInfo['mobile'] : ' ';
                        $resList[$key]['user_wechat_no'] = $tempUserInfo['wechat_no'] ? $tempUserInfo['wechat_no'] : ' ';
                    }
                }
            }
        }
        $agentInfo = $UserModel->field('username')->find($user_id);
//        var_dump($resList);die;
        $this->assign('res', $resList);
        $this->assign('agent', $agentInfo);
        return view('see_sub_list');
    }

}
