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

use think\Controller;
use service\LogService;
use think\Db;
use think\Url;

/**
 * 系统登录控制器
 * class Login
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/10 13:59
 */
class Login extends Controller {

    /**
     * 默认检查用户登录状态
     * @var bool
     */
    public $checkLogin = false;

    /**
     * 默认检查节点访问权限
     * @var bool
     */
    public $checkAuth = false;

    /**
     * 控制器基础方法
     */
    public function _initialize() {
        if (session('agent') && $this->request->action() !== 'out') {
            $this->redirect('@html/Agents/index');
        }
    }

    /**
     * 用户登录
     * @return string
     */
    public function index() {
        // var_dump(session('agent'));die;
//        if ($this->request->isGet()) {
            $this->assign('title', '用户登录');
            return $this->fetch();
//        } else {
//
//        }
    }


    public  function ajaxLogin()
    {
        $result  = array('url' => Url::build('html/Agents/index'), 'msg' => '参数错误！', 'status' => 0);
        $mobile = $this->request->post('mobile', '', 'trim');
        $password = $this->request->post('password', '', 'trim');
        if(empty($mobile) || strlen($mobile) != 11){
            $result['msg'] = '手机号长度不正确长度不正确！';
            return $result;
        }
//        var_dump($password);die;
        if(empty($password) || strlen($password) < 6){
            $result['msg'] = '登录密码长度不能少于6位有效字符！';
            return $result;
        }
        $user = Db::name('LxUser')->where('mobile', $mobile)->find();
        if(empty($user)){
            $result['msg'] = '登录账号不存在，请重新输入!';
            return $result;
        }
        if($user['password'] !== md5($password)){
            $result['msg'] = '登录密码与账号不匹配，请重新输入!';
            return $result;
        }
        if($user['status'] == 0){
            $result['msg'] = '该用户已被禁用，如有疑问请联系平台热线!';
            return $result;
        }

        Db::table('lx_user')->where('id', $user['id'])->update(['login_at' => time(), 'login_num' => ['exp', 'login_num+1']]);
        session('agent', $user);
        LogService::write('代理用户管理', '用户'.$mobile.'登录系统成功');
        $result['msg'] = '登录成功!';
        $result['status'] = 1;
        return $result;
//        $this->success('登录成功，正在进入后台...', '@html/Agents/index');
    }

    /**
     * 退出登录
     */
    public function out() {
        $result  = array('url' => Url::build('html/login/index'), 'msg' => '退出成功！', 'status' => 1);

//        LogService::write('代理用户管理', '用户退出系统成功');
//        session('user', null);
        session('agent', null);
        session_destroy();
        return $result;
//        $this->success('退出登录成功！', '@html/login');
    }


    public function tobeinvited()
    {
        var_dump($this->request);
    }

}
