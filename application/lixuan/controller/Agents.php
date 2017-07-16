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
class Agents extends BasicAdmin {

    /**
     * 定义当前操作表名
     * @var string
     */
    public $table = 'LxAgent';

    private $randStr = 'abcdefghijklmnopqrstuvwxyz1234567890';

    /**
     * 产品列表
     * @return View
     */
    public function index() {
//        $this->success('添加成功！',$this->_createAdminUrl('agents'));

//        $where = array();
//        $this->request->param('username') ? $where['u.username'] = $this->request->param('username') : '';
//        $this->request->param('mobile') ? $where['u.mobile'] = $this->request->param('mobile') : '';

        $res = Db::name($this->table)->alias('a')
            ->field('a.*,u.username,u.mobile,p.name')
            ->join('lx_user u', 'u.id = a.user_id')
            ->join('lx_product p', 'p.id = a.product_id')
//            ->where($where)
            ->order('a.id desc')->select();
        
        $this->assign('title', '代理产品列表');
        $this->assign('list', $res);
        $this->assign('agenttype', $this->_agentType);
        return view();
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
            $proList = $ProModel->where('status = 1')->order('id desc')->select();
            if(!$proList){
                $this->error('暂无产品，请先添加产品再来授权！');
            }

            $this->assign('pro_list', $proList);
            $this->assign('user_list', $userList);
            $this->assign('agenttype', $this->_agentType);
            return parent::_form($this->table, 'existsform', 'id');
        }
        //接收参数 用户参数
//        $data['username'] = $this->request->post('username');
//        $data['password'] = $this->request->post('password');
//        $data['mobile'] = $this->request->post('mobile');
        $level = $this->request->post('level');
        $product_id = $this->request->post('product_id') ? trim($this->request->post('product_id')) : '';
        $user_id = $this->request->post('user_id') ? trim($this->request->post('user_id')) : '';
        //判断密码是否空
//        if(!$data['password']) return $this->error('密码不能为空！');
//        //判断手机号格式
//        if(!preg_match("/^1[34578]{1}\d{9}$/",$data['mobile'])){
//            $this->error('手机号格式不正确！');
//        }
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

//        //判断手机号是否已使用
//        $tempUser = $UserModel->where(array('mobile'=>$data['mobile']))->find();
//        if ($tempUser) $this->error('手机号已使用！');
        //添加代理和代理关系
//        try{
            //生成授权号
            $empower_sn = AgentService::createAgentSn($tempPro['abbr']);
            if($empower_sn === false){
                $this->error("授权号生成失败！请刷新后重试！");
            }
//            $data['reg_at'] = time();
//            $data['reg_ip'] = $this->request->ip(0,true);
//            $data['password'] = md5($data['password']);
//            $UserModel->data($data)->allowField(true)->save();
            $agentData['user_id'] = $user_id;
            $agentData['product_id'] = $product_id;
            $agentData['level'] = $level;   //授权等级
            $agentData['created_at'] = time();  //生成时间
            $agentData['invitation'] = 2;      //生成方式【1邀请 2后台授权】
            $agentData['empower_sn'] = $empower_sn;
            $agentData['super_id'] = 1;        //上级id
            $agentData['super_level'] = 0;      //上级等级

            $AgentModel->data($agentData)->allowField(true)->save();
            // 提交事务
//            Db::commit();
//        } catch (\Exception $e) {
//            // 回滚事务
//            Db::rollback();
//            $this->error('参数错误，请重试添加！');
//        }
//        $this->success('添加成功！', $_SERVER["HTTP_REFERER"].'#'.'/lixuan/agents/index');
        $this->success('添加成功！',$this->_createAdminUrl('agents'));
    }

}
