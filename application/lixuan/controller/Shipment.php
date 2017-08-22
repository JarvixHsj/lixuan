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

namespace app\lixuan\controller;
use controller\BasicAdmin;
use model\Anti;
use service\AntiService;
use service\AgentService;
use model\Product;
use model\User;
use model\Agent;
use model\Shipments;
use think\response\View;
use think\Db;
use think\Config;
use think\Url;

/**
 *
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Shipment extends BasicAdmin {

    /**
     * 定义当前操作表名
     * @var string
     */
    public $table = 'lx_anti';

    private $randStr = 'abcdefghijklmnopqrstuvwxyz1234567890';

    /**
     * 列表
     * @return View
     */
    public function index() {
        $this->title = '防伪码管理';
        $get = $this->request->get();
        $where = array();
        if(isset($get['qrcode']) && !empty($get['qrcode'])){
            $where['qrcode']  = ['like',"%{$get['qrcode']}%"];
        }
        if(isset($get['code']) && !empty($get['code'])){
            $where['code']  = ['like',"%{$get['code']}%"];
        }
//        var_dump($get);
//        dump($get);
        $db = Db::name($this->table)->where($where)->order('id asc');

        $rowPage = intval($this->request->get('rows', cookie('rows')));
        cookie('rows', $rowPage >= 54 ? $rowPage : 54);
        $page = $db->paginate($rowPage, false, ['query' => $this->request->get()]);
        $result['list'] = $page->all();
        $result['page'] = preg_replace(['|href="(.*?)"|', '|pagination|'], ['data-open="$1" href="javascript:void(0);"', 'pagination pull-right'], $page->render());
        if (false !== $this->_callback('_data_filter', $result['list']) && true) {
            !empty($this->title) && $this->assign('title', $this->title);
        }

        $UserModel = new User();
        foreach($result['list'] as $key => $val){
            if($val['user_id'] == 0){
                $result['list'][$key]['username'] = '暂无分配~';
                $result['list'][$key]['mobile'] = '暂无分配~';
            }else{
                $userInfo = $UserModel->getUserInfo($val['user_id']);
                if($userInfo){
                    $result['list'][$key]['username'] = $userInfo['username'];
                    $result['list'][$key]['mobile'] = $userInfo['mobile'];
                }else{
                    $result['list'][$key]['username'] = '无';
                    $result['list'][$key]['mobile'] = '无';
                }
            }
        }

        return $this->fetch('', $result);
    }

    /**
    * 设置防伪码代理
    */
    public function setAntiUser() {
        if ($this->request->isGet()) {
            $anti_id = $this->request->param('anti_id');
            $anti_code = $this->request->param('anti_code');
            if(empty($anti_id) || empty($anti_code)){
                $this->error('网络请求失败，请稍后重试~');
            }
            $is_box = 0;
            if(substr($anti_code,-3,3) == 318){
                $antiList = AntiService::getABoxTotal($anti_code);
                $is_box = 1;
            }else{
                $antiList = AntiService::JudgeAnti(array('id' => $anti_id));
            }
            if($antiList == false){
                $this->error('获取代理用户信息失败，请稍后重试~');
            }

            $UserModel = new User();
            $userList = $UserModel->getUserList();
            $this->assign('anti_list', $antiList);
            $this->assign('user_list', $userList);
            $this->assign('anti_id', $anti_id);
            $this->assign('is_box', $is_box);
            $this->assign('anti_code', $anti_code);
            return parent::_form($this->table, 'form', 'id');
        }
        /**
         * 逻辑
         * 1.接收参数，并判断是否存在有效
         * 2.判断是一盒还是一箱，组合防伪码记录跟踪
         * 3.修改防伪码所属代理
         */
        //接收参数 用户参数
        $anti_id = $this->request->post('anti_id');
        $anti_code = $this->request->post('anti_code');
        $is_box = $this->request->post('is_box');
        $user_id = $this->request->post('user_id') ? trim($this->request->post('user_id')) : '';
        //判断用户
        if(!$user_id) $this->error('请选择要指派的代理！');
        $UserModel = new User();
        $userInfo = $UserModel->getUserInfo($user_id);
        if(!$userInfo) $this->error('要指派的代理信息不存在，请重试~');

        //整理信息，查询出防伪数据
        $isBoxStr = '一盒';
        $isBoxNum = 1;
        $antiList = AntiService::JudgeAnti(array('id' => $anti_id));
//        dump($antiList);
        if($is_box == 1){
            $isBoxStr = '一箱';
            $isBoxNum = 48;
            $antiTempList = AntiService::getABoxTotal($anti_code);
            array_unshift($antiTempList,$antiList[0]);
            $antiList = $antiTempList;
        }
        //订单号
        $AgentService = new AgentService();
        $sn = $AgentService->createShipmentSn();
        $company_name = Config::get('chinese_escape')['company_name'] ? Config::get('chinese_escape')['company_name'] : '公司总部';

        try{
            $messageContent = '公司总部给你发了'. $isBoxStr. '产品，订单号为：'.$sn. '，请注意查收~';
            $newTime = date('Y-m-d H:i:s', time());

            //防伪码流水记录
            $recordInfo['anti_id'] = $anti_id;
            $recordInfo['anti_code'] = $anti_code;
            $recordInfo['type'] = 2;
            $recordInfo['take_user_id'] = $user_id;
            $recordInfo['content'] = $messageContent;
            $recordInfo['created_at'] = $newTime;
            $AgentService->createAntirecord($recordInfo);


            //代理用户消息记录
            $messageInfo['user_id'] = $user_id;
            $messageInfo['content'] = $messageContent;
            $messageInfo['type'] = 1;
            $messageInfo['created_at'] = $newTime;
            $AgentService->createMessage($messageInfo);

            //发货记录
            $shipmentsInfo['take_user_id'] = $user_id;
            $shipmentsInfo['product_id'] = 1;
            $shipmentsInfo['order_sn'] = $sn;
            $shipmentsInfo['picking_type'] = 0;
            $shipmentsInfo['num'] = $isBoxNum;
            $shipmentsInfo['remark'] = '总后台管理员给代理分配防伪码';
            $shipmentsInfo['send_user_id'] = 0;
//            $shipmentsInfo['take_user_level'] = $userInfo[''];
            $shipmentsInfo['take_username'] = $userInfo['username'];
            $shipmentsInfo['take_wechat_no'] = $userInfo['wechat_no'];
            $shipmentsInfo['take_mobile'] = $userInfo['mobile'];
            $shipmentsInfo['send_username'] = $company_name;
            $shipmentsInfo['send_wechat_no'] = $company_name;
            $shipmentsInfo['send_time'] = $newTime;
            $shipmentsInfo['created_at'] = $newTime;
            $ShipmentsModel = new Shipments();
            $ShipmentsModel->data($shipmentsInfo)->allowField(true)->save();
            $ship_id = $ShipmentsModel->id;

            $tempShipDetailArr = array();   //发货详情记录
            $tempAntiUpdateArr = array();   //防伪码更新数组
            foreach($antiList as $key => $val){
                $tempShipDetailInfo = array();
                $tempShipDetailInfo['ship_id'] = $ship_id;
                $tempShipDetailInfo['anti_id'] = $val['id'];
                $tempShipDetailInfo['anti_code'] = $val['code'];
                $tempShipDetailArr[] = $tempShipDetailInfo;

                $tempAntiUpdateInfo = array();
                $tempAntiUpdateInfo['user_id'] = $user_id;
                $tempAntiUpdateInfo['updated_at'] = time();
                $tempAntiUpdateInfo['id'] = $val['id'];
                $tempAntiUpdateArr[] = $tempAntiUpdateInfo;
            }
            //插入发货详情
            Db::table('lx_shipment_details')->insertAll($tempShipDetailArr);

            //更新防伪码记录所属代理
            $AntiModel = new Anti();
            $AntiModel->allowField(true)->saveAll($tempAntiUpdateArr);

            // 提交事务
            Db::commit();  
        } catch (\Exception $e) {
//            var_dump($ShipmentsModel->getLastSql());die;
            // 回滚事务
            Db::rollback();
            $this->error('参数错误，请重试添加！');
        }
        $this->success('指派成功！',$this->_createAdminUrl('shipment'));
    }

    /**
     * 已有代理添加产品
     */
    public function addExists() {
        if ($this->request->isGet()) {
            $userList = Db::table('lx_user')->where('status', 1)->select();
            if(!$userList){
                $this->error('暂无代理，请先添加代理再来授权！');
            }
            $ProModel = new product;
            $proList = $ProModel->where('is_delete = 1')->order('id desc')->select();
            if(!$proList){
                $this->error('暂无产品，请先添加产品再来授权！');
            }
            $this->assign('pro_list', $proList);
            $this->assign('user_list', $userList);
            $this->assign('agenttype', $this->_agentType);
            return parent::_form($this->table, 'existsform', 'id');
        }
        $level = $this->request->post('level');
        $product_id = $this->request->post('product_id') ? trim($this->request->post('product_id')) : '';
        $user_id = $this->request->post('user_id') ? trim($this->request->post('user_id')) : '';

        //判断产品
        if(!$product_id) $this->error('请选择要代理的产品！');
        if(!$user_id) $this->error('请选择代理！');
        $ProModel = new Product;
        $tempPro = $ProModel->find($product_id)->toArray();
        if (!$tempPro) {
            $this->error('选择的代理产品有误，请重新选择！');
        }
        $UserModel = new User;
        $comboUser = $UserModel->find($user_id);
        if (!$comboUser) $this->error('代理信息有误，请刷新后重试~');

        //判断该代理是否已经有该产品的代理
        $AgentModel = new Agent;
        $comboAgent = $AgentModel->where(array('user_id' => $user_id, 'product_id' => $product_id))->find();
        if($comboAgent) $this->error('该代理已经有该产品的授权了，不可重复授权!');

        $empower_sn = AgentService::createAgentSn($tempPro['abbr']);
        if($empower_sn === false){
            $this->error("授权号生成失败！请刷新后重试！");
        }
        $agentData['user_id'] = $user_id;
        $agentData['product_id'] = $product_id;
        $agentData['level'] = $level;   //授权等级
        $agentData['created_at'] = time();  //生成时间
        $agentData['invitation'] = 2;      //生成方式【1邀请 2后台授权】
        $agentData['empower_sn'] = $empower_sn;
        $agentData['super_id'] = 1;        //上级id
        $agentData['super_level'] = 0;      //上级等级

        $AgentModel->data($agentData)->allowField(true)->save();
        $this->success('添加成功！',$this->_createAdminUrl('agents'));
    }

    public function edit(){
        if ($this->request->isGet()) {
            $agentId = $this->request->param('agent_id');
            if(empty($agentId)) $this->error('参数有误，请刷新后重试！');

            $agentInfo = Db::table('lx_agent')->alias('a')
                ->join('lx_user u', 'u.id = a.user_id')
                ->where('a.id', $agentId)
                ->field('a.*,u.mobile,u.username')
                ->find();
            if(!$agentInfo) $this->error('代理信息不存在，请刷新后重试~');

            $ProModel = new product;
            $proList = $ProModel->where('status = 1 AND is_delete = 1')->order('id desc')->select();
            if(!$proList){
                $this->error('暂无产品，请先添加产品再来授权！');
            }
            $this->assign('pro_list', $proList);
            $this->assign('agent_info', $agentInfo);

            $tempLevel = $this->_agentType;
            if($agentInfo['super_level'] != 0){
                foreach($tempLevel as $key => $val) {
                    if($key < $agentInfo['super_level']){
                        unset($tempLevel[$key]);
                    }
                }
            }
            $this->assign('agenttype', $tempLevel);

            return parent::_form($this->table, 'edit', 'id');
        }

        $id = $this->request->param('id');
        $selectProId = $this->request->param('product_id');
        $selectLevel = $this->request->param('level');

        $AgentModel = new Agent();
        //查询原数据
        $sourceInfo = $AgentModel->find($id);
        if(!$sourceInfo) $this->error('信息不存在！请刷新后重试~');
        $sourceInfo = $sourceInfo->toArray();
//        if($sourceInfo['level'] == $selectLevel && $sourceInfo['product_id'] = $selectProId) $this->success('修改成功~', '');

        //判断是否更换了产品
        if($selectProId != $sourceInfo['product_id']){
            //判断改产品的授权是否已存在
            $comboPro = $AgentModel->where(array('user_id' => $sourceInfo['user_id'], 'product_id' => $selectProId))->find();
            if($comboPro) $this->error('该代理已经有该产品的授权了，不可重复授权~');
        }

        //判断是否更改了代理等级
//        if($selectLevel != $sourceInfo['level']){
        $comboUpdate = $AgentModel->save(array('level' => $selectLevel, 'product_id' => $selectProId), array('id' => $id));
        if($comboUpdate !== false) $this->success('恭喜, 数据保存成功!', '');
        $this->error('修改失败，请关闭后重试~');

//        }
    }

}
