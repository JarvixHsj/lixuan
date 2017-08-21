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
use model\Antirecord;
use service\AgentService;
use service\AntiService;
use think\response\View;
use think\Url;
use think\Config;
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
//        dump(session('agent'));
//        $where = array('take_user_id' => 1111);
        $where = array('send_user_id' => session('agent.id'));
        $list = $ShipModel->getShipmentList($where,2);
        $this->assign('list', $list);
    	return view();
    }

    /**
     * 发货列表ajax分页请求
     * @author: Jarvix
     */
    public function ajaxPage()
    {
        $ShipModel = new Shipments();
        $where = array('send_user_id' => session('agent.id'));
        $list = $ShipModel->getShipmentList($where,2);
        $this->result($list, 1, '~~', 'json');
    }


    /**
     * 新增发货
     * @author: Jarvix
     * @return mixed|View
     */
    public function add()
    {
        $data = array();
        $data['take_user_id'] = session('shipment.take_user_id') ? session('shipment.take_user_id') : 0; //收货人
        $countAnti = 0;
        if (!$this->request->isPost()) {
            if (!empty(session('shipment.agent_id')) && !empty(session('shipment.pro_id')) && !empty(session('shipment.take_user_id'))) {
                $take_info = AgentService::getAgentAllInfo(session('shipment.agent_id'), session('shipment.pro_id'));
                if($take_info) {
                    $sweep = session('shipment.sweeplist');
                    $countAnti = count($sweep) ? count($sweep) : 0;

                    $this->assign('take_info', $take_info);
                }
            }

            $this->assign('data', $data);
            $this->assign('count_anti', $countAnti);
            $this->assign('agenttype', $this->_agentType);
            return $this->fetch();
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

        $data['userinfo'] = $UserData;
        $data['agentinfo'] = $AgentData;
//        var_dump($data);die;

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
     * 删除已扫描的防伪码记录.
     * @author: Jarvix
     */
    public function ajaxDelSelectAnti()
    {
        $delAntiId = $this->request->param('del_id');
        $antiArr = session('shipment.sweeplist');
        if(!$antiArr){
            $this->result('', 1, '删除成功~', 'json');
        }

        /**
         * 逻辑：查询出id对应的键，unset之后重新赋值到session
         */
        $del_key = array_search($delAntiId, $antiArr);
        if($del_key !== false){
            unset($antiArr[$del_key]);
            session('shipment.sweeplist', $antiArr);
            $this->result('', 1, '删除成功~', 'json');
        }else{
            $this->result('',0,'系统繁忙~','json');
        }
    }

    /**
     * 扫描发货页面
     * 逻辑：如果是get请求则直接进入扫一扫发货页面
     *          并判断之前是否有选择过。
     */
    public function ajaxSweepIndex()
    {
        if($this->request->isGet()){
            session('shipment.sweeplist',null);

            $list = array();
            $sweep = session('shipment.sweeplist');
            $sweepCount = count($sweep);
            $where = '';
            $list = array();
            if($sweepCount > 1){
                $sweepStr = implode(',',$sweep);
                $where = 'id in('.$sweepStr.')';
            }elseif($sweepCount == 1){
                $where = array('id' => $sweep['0']);
            }

            if($where){
                $AntiModel = new Anti();
                $res = $AntiModel->where($where)->select();
                if($res){
                    $list = $res->toArray();
                }
            }

            $this->assign('list', $list);
            return $this->fetch('sweep');
        }

        $param = $this->request->param();
        session('shipment.picking_type',$param['picking_type']);
        if(isset($param['express_sn'])){
            session('shipment.express_sn', $param['express_sn']);
        }
        if(isset($param['send_time'])){
            session('shipment.send_time', $param['send_time']);
        }
        if(isset($param['product_name'])){
            session('shipment.product_name', $param['product_name']);
        }
        if(isset($param['remark'])){
            session('shipment.remark', $param['remark']);
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
     * 逻辑：将防伪码id存储到session.sweeplist，二维数组
     */
    public function doneSweep()
    {
        $returnUrl = Url::build('Shipping/add');
        //判断是否选择了发货人
        if($this->checkShipmentInfo() === false){
            $this->success('请先选择发货代理~', 'Shipping/add');
        }
//        $takeUserId = session('shipment.take_user_id');
//        $takeUserInfo = Db::table('lx_user')->find($takeUserId);

//        if(isset($this->request->param()['sweephidden'])){
//            $sweepHidden = $this->request->param()['sweephidden'];
//        }else{
//            $sweepHidden = '';
//        }

        $sweepHidden = $this->request->param()['sweephidden'] ?  $this->request->param()['sweephidden'] : '';

        $sweep = $this->request->param()['sweep'];
//        dump($sweep);
        $sweepCount = count($sweep);
        $where = '';
        $newSweepStr = '';
        $newSweepArr = array();
        $send_user_id = session('agent.id');
        if($sweepCount > 1){
            $sweepStr = implode(',',$sweep);
            $where = 'id in('.$sweepStr.')';
        }elseif($sweepCount == 1){
            $where = array('id' => $sweep['0']);
        }
        if($where){
            $AntiModel = new Anti();
            $res = $AntiModel->where($where)->select();
            if($res){
                $res = $res->toArray();
                foreach($res as $key => $val){
                    if($val['user_id'] == $send_user_id){
                        $newSweepStr .= $val['id'] . ',';
                    }
                }
            }
        }
        if($newSweepStr){
            $newSweepArr = explode(',',rtrim($newSweepStr, ','));
        }
        session('shipment.sweeplist', $newSweepArr);
        session('shipment.sweephidden', $sweepHidden);
        $this->redirect($returnUrl);
//
////        var_dump(session('shipment'));die;
//        $sweepCount = count($sweep);
//        $where = '';
//        if($sweepCount > 1){
//            $sweepStr = implode(',',$sweep);
//            $where = 'id in('.$sweepStr.')';
//        }elseif($sweepCount == 1){
//            $where = array('id' => $sweep['0']);
//        }elseif($sweepCount == 0){
//            $this->success('无扫描信息~', 'Shipping/index');
//        }
//
//        $AntiModel = new Anti();
//        $res = $AntiModel->where($where)->select();
//        if(!$res){
//            $this->success('无扫描信息~', 'Shipping/index');
//        }
//        $res = $res->toArray();
//        $antiRecordData = array();  //防伪码记录
//        $antiUpdateData = array();  //防伪码更新（更新所属代理）
//        $shipmentAgentId = session('shipment.agent_id');
//        foreach($res as $key => $val){
//            $tempRecord['anti_id'] = $val['id'];
//            $tempRecord['anti_code'] = $val['code'];
//            $tempRecord['take_user_id'] = $takeUserId;
//            $tempRecord['send_user_id'] = session('agent.id');
//            $tempRecord['agent_id'] = $shipmentAgentId;
//            $antiRecordData[] = $tempRecord;
//
//            $val['user_id'] = $takeUserId;
//            $val['agent_id'] = $shipmentAgentId;
//            $val['project_id'] = session('shipment.pro_id');
//            $val['updated_at'] = time();
//            $antiUpdateData[] = $val;
//        }
//        //代理消息记录
//        $takeRecoed = array();
//        $takeRecoed['user_id'] = $takeUserId;
//        $takeRecoed['created_at'] = date('Y-m-d H:i:s',time());
//        $takeRecoed['content'] = session('agent.username').'给你发了'.$sweepCount.'个货物，订单号为'.$orderSn.'。请到单号查询里面查看详情！';
//        var_dump(session('agent'),$antiUpdateData,$antiRecordData);
    }


    /**
     * 保存发货
     * 逻辑：1.判断参数，session
     *      2.添加防伪码跟踪记录
     *      3.防伪码记录更新
     *      4.添加代理消息记录
     */
    public function ajaxSave()
    {
        dump(session('shipment'));
//        $returnUrl = Url::build('Shipping/index');
        //接收参数
        $product_name = $this->request->param('product_name');  //产品名称
        $remark = $this->request->param('remark');  //备注
        $send_time = $this->request->param('send_time');  //发货时间
        $picking_type = $this->request->param('picking_type');  //取货类型
        $express_sn = $this->request->param('express_sn');  //快递单号

        $takeUserId = session('shipment.take_user_id');
        $UserModel = new User();
        $takeUserInfo = $UserModel->getUserInfo($takeUserId);
        if($takeUserInfo === false){
            $this->result('',0, '收货代理信息不存在~收货代理信息不存在~', 'json');
        }
        $shipmentAgentId = session('shipment.agent_id');
        $takeProId = session('shipment.pro_id');
        $sweep = session('shipment.sweeplist');
        $sendUserId = session('agent.id');
        $sweepCount = count($sweep);
        $where = '';
        if($sweepCount > 1){
            $sweepStr = implode(',',$sweep);
            $where = 'id in('.$sweepStr.')';
        }elseif($sweepCount == 1){
            $where = array('id' => $sweep['0']);
        }elseif($sweepCount == 0){
            $this->result('',0, '无扫描信息~', 'json');
        }

        $AntiModel = new Anti();
        $res = $AntiModel->where($where)->select();
        if(!$res){
            $this->result('',0, '无扫描信息~', 'json');
        }

        $AgentService = new AgentService();
        $orderSn = $AgentService::createShipmentSn();
        $res = $res->toArray();
        $antiRecordData = array();  //防伪码记录
        $antiUpdateData = array();  //防伪码更新（更新所属代理）
        $newTime = time();
        foreach($res as $key => $val){
            if($val['user_id'] == $takeUserId){
                unset($res[$key]);
                continue;
            }

            $tempRecord['anti_id'] = $val['id'];
            $tempRecord['anti_code'] = $val['code'];
            $tempRecord['take_user_id'] = $takeUserId;
            $tempRecord['send_user_id'] = $sendUserId;
            $tempRecord['agent_id'] = $shipmentAgentId;
            $antiRecordData[] = $tempRecord;

            $val['user_id'] = $takeUserId;
            $val['agent_id'] = $shipmentAgentId;
            $val['project_id'] = $takeProId;
            $val['updated_at'] = $newTime;
            $antiUpdateData[] = $val;
        }
        if(!$res){
            session('shippment.sweeplist', null);
            $this->result('',0, '这批货物已经是该代理的~~', 'json');
        }
        //收货代理消息记录
        $takeUserMessage = array();
        $takeUserMessage['user_id'] = $takeUserId;
        $takeUserMessage['created_at'] = date('Y-m-d H:i:s',$newTime);
        $takeUserMessage['content'] = session('agent.username').'给你发了 '.$sweepCount.' 个货物，订单号为 '.$orderSn.' 。请到发货列表或单号查询里面查看详情！';

        //发货代理消息记录
        $sendUserMessage = array();
        $sendUserMessage['user_id'] = $sendUserId;
        $sendUserMessage['created_at'] = date('Y-m-d H:i:s',$newTime);
        $sendUserMessage['content'] = "你给 ". $takeUserInfo['username']. ' 发了'.$sweepCount."个货物，订单号为： ".$orderSn.' 。';

        //发货记录
        $shipmentsInfo['take_user_id'] = $takeUserId;
        $shipmentsInfo['product_id'] = $takeProId;
        $shipmentsInfo['order_sn'] = $orderSn;
        $shipmentsInfo['picking_type'] = $picking_type;
        $shipmentsInfo['num'] = $sweepCount;
        $shipmentsInfo['remark'] = $remark;
        $shipmentsInfo['product_name'] = $product_name;
        $shipmentsInfo['send_user_id'] = $sendUserId;
        $shipmentsInfo['take_user_level'] = $shipmentAgentId;
        $shipmentsInfo['take_username'] = $takeUserInfo['username'];
        $shipmentsInfo['take_wechat_no'] = $takeUserInfo['wechat_no'];
        $shipmentsInfo['take_mobile'] = $takeUserInfo['mobile'];
        $shipmentsInfo['send_username'] = session('agent.username');
        $shipmentsInfo['send_wechat_no'] = session('agent.wechat_no');
        $shipmentsInfo['send_time'] = $send_time;
        $shipmentsInfo['created_at'] = $newTime;
        $ShipmentsModel = new Shipments();

        // 启动事务
        Db::startTrans();
        try{
            $ShipmentsModel->data($shipmentsInfo)->allowField(true)->save();
            $ship_id = $ShipmentsModel->id;
//            var_dump($ship_id);
            $res1 = $AgentService->createMessage($takeUserMessage); //新增收货人消息记录
            $res2 = $AgentService->createMessage($sendUserMessage); //新增发货人消息记录
            $AntiModel = new Anti();
            $res3 = $AntiModel->saveAll($antiUpdateData);  //更新发货防伪码
            $res4 = Db::table('lx_antirecord')->insertAll($antiRecordData); //添加防伪码跟踪记录
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->result('',0, '系统繁忙，请稍后重试~', 'json');
        }
        session('shipment.sweeplist',null);
        $returnUrl = Url::build('Shipping/index');
        $this->result($returnUrl,1, '发货成功！', 'json');
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
        $data = array();
        $data['hidden'] = 0;
        $AntiService = new AntiService();
        //查询是否代理是否有防伪码（即货物）
        $antiList = $AntiService->getUserAntiList(session('agent.id'));
        if(!$antiList) $this->result('',0, '你还没有商品~', 'json');
//        dump($antiList);
//        $id = rand(0,count($antiList) - 1);
        $id = count($antiList) - 1;
        $res[] = $antiList[$id];
        $anticode = $res['0']['code'];
        $antiId = $res['0']['id'];
//        $res = AntiService::JudgeAnti(array('id' => $id));
        if(substr($anticode, -3) == 318){
            $res = AntiService::getABoxTotal($anticode);
            $data['hidden'] = 1;
            $data['value'] = $antiId;
        }
        if(!$res) $res = array();

        $data['res'] = $res;

        $this->result($data,1,'ok~','json');
    }


    //            扫一扫sdk
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


}
