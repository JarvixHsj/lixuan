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
use service\NodeService;
use think\Db;

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
            $this->redirect('@html/Agent/index');
        }
    }

    /**
     * 用户登录
     * @return string
     */
    public function index() {
        // var_dump(session('agent'));die;

        if ($this->request->isGet()) {
            $this->assign('title', '用户登录');
            return $this->fetch();
        } else {
            // var_dump(md5($this->request->post('password')));die;
            $mobile = $this->request->post('mobile', '', 'trim');
            $password = $this->request->post('password', '', 'trim');
            (empty($mobile) || strlen($mobile) != 11) && $this->error('手机号长度不正确长度不正确!');
            (empty($password) || strlen($password) < 6) && $this->error('登录密码长度不能少于6位有效字符!');
            $user = Db::name('LxUser')->where('mobile', $mobile)->find();
            empty($user) && $this->error('登录账号不存在，请重新输入!');
            ($user['password'] !== md5($password)) && $this->error('登录密码与账号不匹配，请重新输入!');
            Db::name('SystemUser')->where('id', $user['id'])->update(['login_at' => ['exp', 'now()'], 'login_num' => ['exp', 'login_num+1']]);
            session('agent', $user);
            // !empty($user['authorize']) && NodeService::applyAuthNode();
            LogService::write('代理用户管理', '用户'.$mobile.'登录系统成功');
            $this->success('登录成功，正在进入后台...', '@html/Agent/index');
        }
    }

    /**
     * 退出登录
     */
    public function out() {
        var_dump(123);die;
        LogService::write('代理用户管理', '用户退出系统成功');
        session('user', null);
        session('agent', null);
        session_destroy();
        $this->success('退出登录成功！', '@html/login');
    }

}
