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
     *手动输入防伪码
     * @return View
     */
    public function manual() {
        if($this->request->isGet()){
            $returnUrl = $_SERVER['HTTP_REFERER'].'#/lixuan/word/index.html?spm=m-87-'.rand(0,9).rand(0,9);
            $this->assign('returnUrl', $returnUrl);
            $result['title'] = '手动输入';

            $UserModel = new User();
            $userList = $UserModel->getUserList();
            $this->assign('user_list', $userList);

            return view('manual', $result);
        }

        $keyword = $this->request->param('keyword') ? $this->request->param('keyword') : '';
        if(!$keyword) $this->result('', 0, '搜索信息不能为空！', 'json');

        $ShipModel = new Shipments();
        $list = $ShipModel->searchKeyword($keyword);
        if($list){
            $this->result($list,1, 'ok', 'json');
        }
        $this->result('', 0, '无搜索内容~', 'json');

    }

    /**
     * 提交--手动指派防伪码
     */
    public function manualSubmit()
    {
//        $this->error('失败', '', '', 2);
//        $this->result('', 0, '无搜索内容~', 'json');
//
//        var_dump($this->request->param());die;
        $sweep = $this->request->param()['sweep'];
        $user_id = $this->request->param()['user_id'];
        //判断用户
        if(!$user_id) $this->error('请选择要指派的代理！');
        $UserModel = new User();
        $userInfo = $UserModel->getUserInfo($user_id);
        if(!$userInfo) $this->error('要指派的代理信息不存在，请重试~');

        if(!$sweep){
            $this->error('请先选择防伪码~', '', '', 2);
        }


        //整理信息，查询出防伪数据
        $sweepCount = count($sweep);
        if($sweepCount >= 1){
            $sweepStr = implode(',',$sweep);
        }elseif($sweepCount == 0){
            $this->error('无扫描信息~', '', '', 2);
        }

        $where  = 'id in(' .$sweepStr.')';
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
            $tempRecord['anti_id'] = $val['id'];
            $tempRecord['anti_code'] = $val['code'];
            $tempRecord['take_user_id'] = $user_id;
            $tempRecord['send_user_id'] = 0;
            $tempRecord['agent_id'] = 0;
            $antiRecordData[] = $tempRecord;

            $val['user_id'] = $user_id;
            $val['agent_id'] = 0;
            $val['product_id'] = $val['product_id'];
            $val['updated_at'] = $newTime;
            $antiUpdateData[] = $val;
        }
        //收货代理消息记录
        $messageContent = '公司总部给你发了'. $sweepCount. '盒产品，订单号为：'.$orderSn. ', ';

        $takeUserMessage = array();
        $takeUserMessage['user_id'] = $user_id;
        $takeUserMessage['created_at'] = date('Y-m-d H:i:s',$newTime);
        $takeUserMessage['content'] = $messageContent. '请到发货列表或单号查询里面查看详情！';

        //发货记录
        $shipmentsInfo['take_user_id'] = $user_id;
        $shipmentsInfo['product_id'] = 0;
        $shipmentsInfo['order_sn'] = $orderSn;
        $shipmentsInfo['picking_type'] = 0;
        $shipmentsInfo['express_sn'] = 0;
        $shipmentsInfo['num'] = $sweepCount;
        $shipmentsInfo['remark'] = '总后台管理员给代理分配防伪码';
        $shipmentsInfo['product_name'] = 0;
        $shipmentsInfo['send_user_id'] = 0;
        $shipmentsInfo['take_user_level'] = 0;
        $shipmentsInfo['take_username'] = $userInfo['username'];
        $shipmentsInfo['take_wechat_no'] = $userInfo['wechat_no'];
        $shipmentsInfo['take_mobile'] = $userInfo['mobile'];
        $shipmentsInfo['send_username'] = session('agent.username');
        $shipmentsInfo['send_wechat_no'] = session('agent.wechat_no');
        $shipmentsInfo['send_time'] = date('Y-m-d H:i:s',$newTime);
        $shipmentsInfo['created_at'] = date('Y-m-d H:i:s',$newTime);
        $ShipmentsModel = new Shipments();
        // 启动事务
        Db::startTrans();
        try{
            $ShipmentsModel->data($shipmentsInfo)->allowField(true)->save();
            $ship_id = $ShipmentsModel->id;
            $AgentService->createMessage($takeUserMessage); //新增收货人消息记录
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
        $this->success('指派成功！',$this->_createAdminUrl('shipment'));
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
                // $antiList = AntiService::getABoxTotal($anti_code);
                // 只筛选一箱中未指派的记录
                $antiList = AntiService::getNotAssignABoxTotal($anti_code);
                $is_box = 1;
            }else{
                $antiList = AntiService::JudgeAnti(array('id' => $anti_id));
            }
            if($antiList == false){
                $this->error('产品都已指派~');
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
        if($is_box == 1){
            //获取一箱中未指派的记录
            $antiTempList = AntiService::getNotAssignABoxTotal($anti_code);
            //判断是否是一箱
            $countAntiTemp = count($antiTempList);
            $isBoxNum = $countAntiTemp;
            $isBoxStr = '一箱';
            if($countAntiTemp == 48){
                array_unshift($antiTempList,$antiList[0]);
                $antiList = $antiTempList;
            }else{
                $isBoxStr = $countAntiTemp . '盒';
            }
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

}
