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
use service\DataService;
use service\LogService;
use service\AgentService;
use model\Product;
use model\User;
use model\Agent;
use model\UserAudit;
use model\UserInvite;
use think\response\View;
use think\Db;
// use think\Config;

/**
 * 审核管理
 * Class Config
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Audit extends BasicAdmin {

    /**
     * 定义当前操作表名
     * @var string
     */
    public $table = 'LxUserAudit';

//    private $_agentType = array('1'=>'首席CEO', '2' => '核心总监', '3' => '总代', '4'=>'一级', '5'=>'特约');

    /**
     * 申请列表
     * @return View
     */
    public function index() {
        $res = Db::name($this->table)->alias('ua')
        ->field('ua.*,u.username as super_name,u.mobile as super_mobile, p.name as pro_name')
        ->join('lx_user u', 'u.id = ua.user_id')
        ->join('lx_product p', 'p.id = ua.product_id')
        ->order('ua.id desc')->select();
        
        $this->assign('title', '审核列表');
        $this->assign('list', $res);
        $this->assign('agenttype', $this->_agentType);
        return view();
    }


    /**
     * 审核通过
     */
    public function pass()
    {
        $id = $this->request->param('id') ? trim($this->request->param('id')) : '';
        if(empty($id)){
            $this->error('参数错误！');
        }
        $UserAuditModel = new UserAudit();
        $AuditData = $UserAuditModel->find($id)->toArray();
        if(!$AuditData) $this->error('数据异常！');

        //查询等级
        $UserInviteModel = new UserInvite();
        $AgentData = $UserInviteModel->alias('ui')
            ->field('a.*')
            ->join('lx_agent a', 'a.id = ui.agent_id')
            ->where('ui.id', $AuditData['user_invite_id'])
            ->find()->toArray();
        if(!$AgentData) $this->error('数据异常！');

        // 启动事务
        Db::startTrans();
        try{
            $empower_sn = AgentService::createAgentSn($AuditData['invite_level']);

            //代理表
            $insertUserData = array();
            $insertUserData['username'] = $AuditData['mobile'];
            $insertUserData['idcard'] = $AuditData['idcard'];
            $insertUserData['mobile'] = $AuditData['mobile'];
            $insertUserData['password'] = $AuditData['password'];
            $insertUserData['wechat_no'] = $AuditData['wechat_no'];
            $insertUserData['reg_at'] = time();
            $insertUserData['detail_address'] = $AuditData['address'];
            $UserModel = new User();
            $UserModel->data($insertUserData)->allowField(true)->save();
            $insert_user_id = $UserModel->id;

            //代理关系表
            $insertAgentData = array();
            $insertAgentData['product_id'] = $AuditData['product_id'];
            $insertAgentData['user_id'] = $insert_user_id;
            $insertAgentData['super_id'] = $AuditData['user_id'];
            $insertAgentData['super_level'] = $AgentData['level'];
            $insertAgentData['level'] = $AuditData['invite_level'];
            $insertAgentData['empower_sn'] = $empower_sn;
            $insertAgentData['created_at'] = time();
            $insertAgentData['invitation'] = 1;
            $AgentModel = new Agent();
            $AgentModel->data($insertAgentData)->allowField(true)->save();
            $insert_agent_id = $AgentModel->id;

            $updateData['is_through'] = 1;
            $updateData['status'] = 1;
            $UserAuditModel->where('id',$id)->update($updateData);

            // 提交事务
            Db::commit();
        } catch (\Exception $e) {

            // 回滚事务
            Db::rollback();
            $this->error('数据异常！！!');
        }

        $this->success('审核成功！',  $_SERVER["HTTP_REFERER"].'#'.'/lixuan/Audit/index');
    }


    /**
     * 审核不通过
     */
    public function nopass()
    {
        $id = $this->request->param('id') ? trim($this->request->param('id')) : '';
        if(empty($id)){
            $this->error('参数错误！');
        }
        $UserAuditModel = new UserAudit();
        $AuditData = $UserAuditModel->find($id)->toArray();
        if($AuditData) {
            $updateData['is_through'] = 2;
            $updateData['status'] = 1;
            $res = $UserAuditModel->where('id',$id)->update($updateData);
            if($res !== false) $this->success('审核成功！', $_SERVER["HTTP_REFERER"].'#'.'/lixuan/Audit/index');
            $this->error('审核失败！');
        }
        $this->error('审核失败！');
    }

}
