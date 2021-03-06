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
use think\response\View;
use think\Db;
use think\Url;

// use think\Config;

/**
 *
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Users extends BasicAdmin {

    /**
     * 定义当前操作表名
     * @var string
     */
    public $table = 'lx_user';

    private $randStr = 'abcdefghijklmnopqrstuvwxyz1234567890';

    /**
     * 列表
     * @return View
     */
    public function index() {
        $res = Db::table($this->table)->order('id asc')->select();
        
        $this->assign('title', '代理列表');
        $this->assign('list', $res);
        $this->assign('agenttype', $this->_agentType);
        return view();
    }

    /**
     * 禁止
     */
    public function forbid()
    {
        $field = $this->request->param();
        $res = Db::table($this->table)->where('id', $field['id'])->update([$field['field'] => $field['value']]);
        if($res === false) {
            $this->error('操作失败，请重试！');
        }
        $successUrl = $_SERVER['HTTP_REFERER'].'#/lixuan/users/index.html?spm=m-87-'.rand(0,9).rand(0,9);
        $this->success('操作成功~', $successUrl);
    }


    /**
    * 添加产品代理
    */
    public function add() {
        if ($this->request->isGet()) {
            $ProModel = new product;
            $proList = $ProModel->where('status = 1')->order('id desc')->select();
            if(!$proList){
                $this->error('暂无产品，请先添加产品再来授权！');
            }
            $this->assign('pro_list', $proList);
            $this->assign('agenttype', $this->_agentType);
            return parent::_form($this->table, 'form', 'id');
        }
        //接收参数 用户参数
        $data['username'] = $this->request->post('username');
        $data['password'] = $this->request->post('password');
        $data['mobile'] = $this->request->post('mobile');
        $level = $this->request->post('level');
        $product_id = $this->request->post('product_id') ? trim($this->request->post('product_id')) : '';
        //判断密码是否空
        if(!$data['password']) return $this->error('密码不能为空！');
        //判断手机号格式
        if(!preg_match("/^1[34578]{1}\d{9}$/",$data['mobile'])){  
            $this->error('手机号格式不正确！');  
        }  
        //判断产品
        if(!$product_id) $this->error('请选择要代理的产品！');
        $ProModel = new Product;
        $tempPro = $ProModel->find($product_id)->toArray();
         if (!$tempPro) {
            $this->error('选择的代理产品有误，请重新选择！');  
        }
        //判断手机号是否已使用
        $UserModel = new User;
        $tempUser = $UserModel->where(array('mobile'=>$data['mobile']))->find();
        if ($tempUser) $this->error('手机号已使用！');  
        //添加代理和代理关系
        try{
             //生成授权号
            $empower_sn = AgentService::createAgentSn($tempPro['abbr']);
            if($empower_sn === false){
                $this->error("授权号生成失败！请刷新后重试！");
            }
            $data['reg_at'] = time();
            $data['reg_ip'] = $this->request->ip(0,true);
            $data['password'] = md5($data['password']);
            $UserModel->data($data)->allowField(true)->save();
            $agentData['user_id'] = $UserModel->id;
            $agentData['product_id'] = $this->request->post('product_id');
            $agentData['level'] = $level;
            $agentData['created_at'] = time();
            $agentData['invitation'] = 2;
            $agentData['empower_sn'] = $empower_sn;
            $agentData['super_id'] = 0;
            $agentData['super_level'] = 0;
            $AgentModel = new Agent;
            $AgentModel->data($agentData)->allowField(true)->save();
            // 提交事务
            Db::commit();  
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->error('参数错误，请重试添加！');
        }
        $this->success('添加成功！',$this->_createAdminUrl('agents'));
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
