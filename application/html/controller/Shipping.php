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
use model\Anti;
use service\AgentService;
use service\AntiService;
use think\response\View;
use think\Url;
use model\Product;
use model\Agent;
use model\Shipments;
use model\User;
use think\Db;

/**
 * 发货模块控制器
 * Class Agents
 * @package app\index\controller
 * @author Jarvix <zoujingli@qq.com>
 * @date 2017/04/05 10:38
 */
class Shipping extends BasicAgent {

    /**
     * 发货内页--首页
     */
    public function index()
    {
        $ShipModel = new Shipments();
//        $where = array('take_user_id' => 1111);
        $where = array('take_user_id' => session('agent.id'));
        $get = $this->request->get();
        $list = $ShipModel->getShipmentList($where, $get);
//        array(5) {
//        ["total"]=>
//  int(0)
//  ["per_page"]=>
//  int(1)
//  ["current_page"]=>
//  int(1)
//  ["last_page"]=>
//  int(0)
//  ["data"]=>
//  array(0) {
//        }
//}

        dump($list['data']);     die;

    	return view();
    }


    public function ajaxPage()
    {

    }

    
    //新增发货
    public function add()
    {
//        session('shipment',null);
        if (!$this->request->isPost()) {
            if (!empty(session('shipment.agent_id')) && !empty(session('shipment.pro_id')) && !empty(session('shipment.take_user_id'))) {
//                $UserModel = new User();
//                $take_info = $UserModel->find(session('shipment.take_user_id'));
//                var_dump(session('shipment'));die;
                $take_info = AgentService::getAgentAllInfo(session('shipment.agent_id'), session('shipment.pro_id'));
//                var_dump($take_info);die;
                if($take_info) {
//                    $take_info = $take_info->toArray();
                    $this->assign('take_info', $take_info);
                }
            }


//            $AppId = config('wechat.AppID');
//            $AppSecret = config('wechat.AppSecret');
//
//            $token_access_url  = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$AppId."&secret=".$AppSecret;
//            $access_res = file_get_contents($token_access_url);    //获取文件内容或获取网络请求的内容
//            $access_token_data = json_decode($access_res, true);   //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
//
//            $jsapi_ticket = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token_data['access_token']."&type=jsapi";
//            $ticket_res = file_get_contents($jsapi_ticket);
//            $jsapi_ticket_data = json_decode($ticket_res, true);
//
//            $nonceStr = $this->make_nonceStr();
//            $timestamp = time();
//            $jsapi_ticket = $jsapi_ticket_data['ticket'];
//            $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//            $signature = $this->make_signature($nonceStr,$timestamp,$jsapi_ticket,$url);
//
//            $data['config']['appid'] = $AppId;
//            $data['config']['timestamp'] = $timestamp;
//            $data['config']['nonceStr'] = $nonceStr;
//            $data['config']['signature'] = $signature;
//            $this->assign('config', $data['config']);

            $this->assign('agenttype', $this->_agentType);
            return $this->fetch();
//            return view();
        }

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


    /**
     * 选中发货人
     */
    public function selected()
    {
        //将发货人信息存入session
        $data = $this->request->param();
        session('shipment.agent_id', $data['agent_id']);
        session('shipment.take_user_id', $data['user_id']);
        session('shipment.pro_id', $data['pro_id']);

        $this->redirect('Shipping/add');
    }

    /**
     * 列出代理直属 提供选择收货人
     * @return View
     */
    public function consignee()
    {
        $directlyList = AgentService::agentDirectlyList(session('agent.id'));
        $this->assign('res', $directlyList);
        $this->assign('agenttype', $this->_agentType);
        return view();
    }


    /**
     * 扫描发货页面
     */
    public function ajaxSweepIndex()
    {
        if($this->request->isGet()){

            return $this->fetch('sweep');
        }

        //判断
        $data = array('url'=>Url::build('Shipping/ajaxSweepIndex'));

        if (!empty(session('shipment.agent_id')) && !empty(session('shipment.pro_id')) && !empty(session('shipment.take_user_id'))) {
            $this->result($data,1,'','json');
        }
        $this->result($data,0,'请先选择收货人~','json');
    }

    /**
     * 完成扫描
     */
    public function doneSweep()
    {
        $orderSn = AgentService::createShipmentSn();
        //判断是否选择了发货人
        if($this->checkShipmentInfo() === false){
            $this->success('请先选择发货代理~', 'Shipping/add');
        }
        $takeUserId = session('shipment.take_user_id');
        $takeUserInfo = Db::table('lx_user')->find($takeUserId);

        $returnUrl = Url::build('Shipping/index');
        $sweep = $this->request->param()['sweep'];
        $sweepCount = count($sweep);
        $where = '';
        if($sweepCount > 1){
            $sweepStr = implode(',',$sweep);
            $where = 'id in('.$sweepStr.')';
        }elseif($sweepCount == 1){
            $where = array('id' => $sweep['0']);
        }elseif($sweepCount == 0){
            $this->success('无扫描信息~', 'Shipping/index');
        }

        $AntiModel = new Anti();
        $res = $AntiModel->where($where)->select();
        if(!$res){
            $this->success('无扫描信息~', 'Shipping/index');
        }
        $res = $res->toArray();
        $antiRecordData = array();  //防伪码记录
        $antiUpdateData = array();  //防伪码更新（更新所属代理）
        $shipmentAgentId = session('shipment.agent_id');
        foreach($res as $key => $val){
            $tempRecord['anti_id'] = $val['id'];
            $tempRecord['anti_code'] = $val['code'];
            $tempRecord['take_user_id'] = $takeUserId;
            $tempRecord['send_user_id'] = session('agent.id');
            $tempRecord['agent_id'] = $shipmentAgentId;
            $antiRecordData[] = $tempRecord;

            $val['user_id'] = $takeUserId;
            $val['agent_id'] = $shipmentAgentId;
            $val['project_id'] = session('shipment.pro_id');
            $val['updated_at'] = time();
            $antiUpdateData[] = $val;
        }
        //代理消息记录
        $takeRecoed = array();
        $takeRecoed['user_id'] = $takeUserId;
        $takeRecoed['created_at'] = date('Y-m-d H:i:s',time());
        $takeRecoed['content'] = session('agent.username').'给你发了'.$sweepCount.'个货物，订单号为'.$orderSn.'。请到单号查询里面查看详情！';
        var_dump(session('agent'),$antiUpdateData,$antiRecordData);

    }
    
    
    
    
    

    /**
     * 列出选择的下级直属所有代理（可越级发货）
     */
    public function seeSubList()
    {
        $user_id = $this->request->param('user_id') ? trim($this->request->param('user_id')) : 0;
        $agent_id = $this->request->param('agent_id') ? trim($this->request->param('agent_id')) : 0;
        $pro_id = $this->request->param('pro_id') ? trim($this->request->param('pro_id')) : 0;

        $resList = AgentService::agentTeamList($user_id ,$pro_id);
        $UserModel = new User;

        $productInfo = Db::table('lx_product')->find($pro_id);
        //查询这个直属代理信息
        $agentInfo = AgentService::getAgentOneInfo($agent_id);
        //转存二维数组
        $tempArr[] = $agentInfo;
        //如果该代理有下级
        if ($resList && is_array($resList)) {
            $resList = agent_array_to_ring($resList);
            foreach($resList as $key=>$val){
                $tempArr[] = $val;
            }
        }
        foreach($tempArr as $key=>$val){
            $tempUserInfo = $UserModel->field('username,mobile,wechat_no')->find($val['user_id']);
            if($tempUserInfo){
                $tempArr[$key]['user_username'] = $tempUserInfo['username'];
                $tempArr[$key]['user_mobile'] = $tempUserInfo['mobile'];
                $tempArr[$key]['user_wechat_no'] = $tempUserInfo['wechat_no'];
            }
        }
        $this->assign('res', $tempArr);
        $this->assign('pro_res', $productInfo);
        $this->assign('agent', $agentInfo);
        return view('see_sub_list');
    }





    public function make_nonceStr()
    {
        $codeSet = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i<16; $i++) {
            $codes[$i] = $codeSet[mt_rand(0, strlen($codeSet)-1)];
        }
        $nonceStr = implode($codes);
        return $nonceStr;
    }

    public function make_signature($nonceStr,$timestamp,$jsapi_ticket,$url)
    {
        $tmpArr = array(
            'noncestr' => $nonceStr,
            'timestamp' => $timestamp,
            'jsapi_ticket' => $jsapi_ticket,
            'url' => $url
        );
        ksort($tmpArr, SORT_STRING);
        $string1 = http_build_query( $tmpArr );
        $string1 = urldecode( $string1 );
        $signature = sha1( $string1 );
        return $signature;
    }



//        测试方法
    //模拟扫一个码
    public function ajaxSingle()
    {
//        $id = 54; //54  108  162  216
        $id = rand(1,216);
        $res = AntiService::JudgeAnti(array('id' => $id));
        if(substr($res['0']['code'], -3) == 318){
            $res = AntiService::getABoxTotal($res['0']['code']);
        }
        if(!$res) $res = array();

        $this->result($res,1,'ok~','json');
    }





}
