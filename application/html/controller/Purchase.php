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
use service\PurchasesService;
use think\Url;
use model\Product;
use model\Purchases;
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

    /**
     * 采购首页
     */
    public function index() {
        $res = AgentService::getSuperAgentUserIDList(session('agent.id'));
        $list = array();
        if($res){
            $list = $res;
        }
//        if($res){
//            $where_in = '';
//            foreach ($res as $key=>$val) {
//                $where_in .= $val['super_id'] . ',';
//            }
//            $UserModel = new User();
//            $where_in = trim($where_in,',');
//            $map['id'] = $where_in;
//            $temp = $UserModel->getUserConditionList($map);
//            if($temp){
//                $list = $temp;
//            }
//        }
        $this->assign('agnetlist',$this->_agentType);
        $this->assign('list', $list);
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



    public function add()
    {
        //如果是get方式请求，则跳转到添加采购页面
        if($this->request->isGet()){
            $agentId = $this->request->param('agent_id') ? $this->request->param('agent_id') : '';
            $agentInfo = AgentService::getAgentSuperInfo($agentId);
            if(!$agentInfo){
//                header('Refresh:1,Url=http://www.baidu.com');
                echo "<script>alert('上级信息有误，请刷新后重试~');</script>";
                exit();
            }
            $ProModel = new Product();
            $product_list = $ProModel->getList();

            $this->assign('product_list', $product_list);
            $this->assign('agentinfo', $agentInfo);
            return view('content');
        }

        //提交采购
//        Array
//                (
//             [box_arr] => Array
//             (
//                 [3] => 2
//             )
//            [boxful] => Array
//            (
//                [3] => 1
//            )
//            [pro_arr] => Array
//            (
//                [0] => 3
//            )
//            [consignee] => 12
//            [mobile] => 23
//            [address] => 34
//            [remake] => 45
//            [incept_user_id] => 11
//            [incept_user_wechat] => Jarvix
//            [agent_id] => 17
//        )

//        $this->result('123',1,'test ok', 'json');
        //判断并且组合参数
        if(!isset($this->request->param()['box_arr'])){
            $box_arr = '';
        }else{
            $box_arr =  $this->request->param()['box_arr'];
        }
        if(!isset($this->request->param()['boxful'])){
            $boxful = '';
        }else{
            $boxful =  $this->request->param()['boxful'];
        }
        if(!isset($this->request->param()['pro_arr'])){
            $pro_arr = '';
        }else{
            $pro_arr =  $this->request->param()['pro_arr'];
        }
        $consignee = $this->request->param()['consignee'];
        $mobile = $this->request->param()['mobile'];
        $address = $this->request->param()['address'];
        $remake = $this->request->param()['remake'] ? $this->request->param()['remake'] : '';
        $incept_user_id = $this->request->param()['incept_user_id'];
        $incept_user_wechat = $this->request->param()['incept_user_wechat'];
        $agent_id = $this->request->param()['agent_id'];
        if(!$box_arr || !$boxful || !$pro_arr){
            $this->result('',0, '产品信息请填写完整', 'json');
        }
        if(!$consignee) $this->result('',0, '收件人信息不能为空', 'json');
        if(!$mobile) $this->result('',0, '电话不能为空', 'json');
        if(judgeMobile($mobile) == false) $this->result('',0, '电话格式不正确', 'json');
        if(!$address) $this->result('',0, '地址信息不能为空', 'json');
        if(!$incept_user_id) $this->result('',0, '系统繁忙，请稍后刷新重试~', 'json');
        if(!$incept_user_wechat) $this->result('',0, '系统繁忙，请稍后刷新重试~', 'json');
        if(!$agent_id) $this->result('',0, '系统繁忙，请稍后刷新重试~', 'json');
        //判断产品信息
        $newTime = time();
        $formatTime = date('Y-m-d H:i:s',$newTime);
        $ProModel = new Product();
        $UserModel = new User();
        $sponsorMessage = array();              //发起人消息记录
        $inceptMessage = array();               //接收人消息记录
        $PurchaseDetailsAddInfo = array();      //采购详情集合
        $PurchaseAddInfo = array();             //采购信息集合
        $PurchaseAddInfo['sponsor_user_id'] = session('agent.id');
        $PurchaseAddInfo['sponsor_user_wechat'] = session('agent.wechat_no');
        $PurchaseAddInfo['incept_user_id'] = $incept_user_id;
        $PurchaseAddInfo['incept_user_wechat'] = $incept_user_wechat;
        $PurchaseAddInfo['consignee'] = $consignee;
        $PurchaseAddInfo['mobile'] = $mobile;
        $PurchaseAddInfo['address'] = $address;
        $PurchaseAddInfo['remake'] = $remake;
        $PurchaseAddInfo['audit'] = 0;
        $PurchaseAddInfo['is_ceder'] = 0;
        $PurchaseAddInfo['created_at'] = $formatTime;
        $PurchaseAddInfo['updated_at'] = $formatTime;

        //循环选择的产品
        foreach ($pro_arr as $val) {
            if(!$val || !is_numeric($val)) $this->result('',0, '产品信息不存在，请稍后刷新重试~', 'json');
            if(!$boxful[$val] && !$box_arr[$val]) $this->result('',0, '请输入产品数量', 'json');

            $tempDetailsInfo = array();
            $tempProductInfo = $ProModel->getField($val, 'name');
            if(!$tempProductInfo) {
                $this->result('',0, '产品信息不存在，请稍后刷新重试~', 'json');
            }
            //组合采购详情数据
            $tempDetailsInfo['product_name'] = $tempProductInfo['name'];
            $tempDetailsInfo['product_id'] = $val;
            $tempDetailsInfo['boxful'] = $boxful[$val];
            $tempDetailsInfo['box'] = $box_arr[$val];
            $PurchaseDetailsAddInfo[] = $tempDetailsInfo;
        }

        //发起人的消息
//        $sponsorMessage['user_id'] = session('agent.id');
//        $sponsorMessage['content'] = '在'.$formatTime.'成功向'.;
//        $sponsorMessage['type'] = 1;
//        $sponsorMessage['created_at'] = $formatTime;

        $inceptMessage['user_id'] = $incept_user_id;
        $inceptMessage['content'] = '与'.$formatTime.'收到代理 [ '. session('agent.username').' ] 的采购申请，请到【代理后台】-->【采购】-->采购记录，查看';
        $inceptMessage['created_at'] = $formatTime;

        Db::startTrans();
        try{
            Db::table('lx_purchase')->insert($PurchaseAddInfo);
            $PurchaseId = Db::table('lx_purchase')->getLastInsID();
            foreach($PurchaseDetailsAddInfo as $key => $val){
                $val['purchase_id'] = $PurchaseId;
                Db::table('lx_purchase_details')->insert($val);
            }
            AgentService::createMessage($inceptMessage);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->result('',0, '系统繁忙，请稍后重试~', 'json');
        }
        $returnUrl = Url::build('Purchase/index');
        $this->result($returnUrl,1, '采购成功~', 'json');
    }



    /**
     * 我向别人采购列表
     */
    public function record_give_to()
    {
        $list = PurchasesService::getUserSponsorList(session('agent.id'));
        if(!$list){
            $list = array();
        }else{
            foreach ($list as $key => $val) {
                $detailsTemp = array();
                $detailsTemp = PurchasesService::getPurchaseDetailsInfo($val['id']);
                if($detailsTemp){
                    $list[$key]['details'] = $detailsTemp;
                }else{
                    $list[$key]['details'] = array();
                }
            }
        }

        $this->assign('list', $list);
        return view("recordto");
    }

    /**
     * 别人向我采购列表
     */
    public function record_give_me()
    {
        $list = PurchasesService::getUserInceptList(session('agent.id'));
        if(!$list){
            $list = array();
        }else{
            foreach ($list as $key => $val) {
                $detailsTemp = array();
                $detailsTemp = PurchasesService::getPurchaseDetailsInfo($val['id']);
                if($detailsTemp){
                    $list[$key]['details'] = $detailsTemp;
                }else{
                    $list[$key]['details'] = array();
                }
            }
        }

        $this->assign('list', $list);
        return view("recordme");
    }


    /**
     * ajax 修改审核状态
     */
    public function ajaxModifyAudit()
    {
        $id = $this->request->param('id') ? $this->request->param('id') : 0;
        $value = $this->request->param('value') ? $this->request->param('value') : 0;
        if(!$id) $this->result('', 0, '网络异常，请刷新后重试~', 'json');

        $PurchaseModel = new Purchases();
        $res = $PurchaseModel->getOneInfo($id);
        if(!$res) $this->result('', 0, '该记录不存在，请刷新后重试~', 'json');


        $sponsorMessage['user_id'] = $res['sponsor_user_id'];
        $sponsorMessage['content'] = session('agent.username'). ' 审核了你的采购信息，快去查看吧~';
        $sponsorMessage['created_at'] = date('Y-m-d H:i:s', time());

        Db::startTrans();
        try{
            $PurchaseModel->setAudit($id, $value);
            AgentService::createMessage($sponsorMessage);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->result('',0, '系统繁忙，请稍后重试~', 'json');
        }
        $this->result('', 1, '操作成功~', 'json');
    }


    /**
     * 转上级-----获取代理直属上级
     * @return \think\response\View
     */
    public function topagentlist()
    {
        if(!isset($this->request->param()['p_id'])){
            echo "<script>alert('参数有误');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
            exit();
        }
        $p_id = $this->request->param()['p_id'];
        $list = AgentService::getAgentTopDirectlyList(session('agent.id'));
        if(!$list) $list = array();

        $this->assign('res', $list);
        $this->assign('p_id', $p_id);
        return view();
    }


    public function ajaxTurn()
    {
        $p_id = $this->request->param('p_id') ? $this->request->param('p_id') : 0;
        $super_id = $this->request->param('super_id') ? $this->request->param('super_id') : 0;
        $super_wechat = $this->request->param('super_wechat') ? $this->request->param('super_wechat') : 0;
        if(!$super_id || !$super_wechat || !$p_id){
            $this->result('', 0, '参数有误，请刷新后重新选择');
        }

        $PurchaseModel = new Purchases();
        $res = $PurchaseModel->getOneInfo($p_id);
        //判断采购信息
        if(!$res) $this->result('', 0, '采购信息不存在，请确认后再操作~');
        if($res['incept_user_id'] != session('agent.id')) $this->result('', 0, '该采购信息不是你的，无法操作转上级！');

        //组合采购更新信息
        $updateData = array();
        $updateData['is_ceder'] = 1;
        $updateData['super_user_id'] = $super_id;
        $updateData['super_user_wechat'] = $super_wechat;
        $updateData['updated_at'] = date('Y-m-d H:i:s', time());

        //组合消息发送给上级
        $superMessage['user_id'] = $super_id;
        $superMessage['content'] = '您的直属代理 [ '.$res['incept_user_wechat'].' ] 向你转了一条采购申请，请到【代理后台】--【采购】--采购记录，查看';
        $superMessage['created_at'] = date('Y-m-d H:i:s', time());

        Db::startTrans();
        try{
            $PurchaseModel->where('id', $res['id'])->update($updateData);
            AgentService::createMessage($superMessage);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->result('',0, '系统繁忙，请稍后重试~', 'json');
        }
        $this->result('', 1, '操作成功~', 'json');
    }


}
