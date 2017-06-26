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
use think\Db;
use model\UserInvite;
use model\UserAudit;
use model\User;

/**
 * 系统登录控制器
 * class Login
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/10 13:59
 */
class Tourists extends Controller {

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
        // if (session('agent') && $this->request->action() !== 'out') {
        //     $this->redirect('@html/Agents/index');
        // }
    }

    /**
     * 
     * @return string
     */
    public function index() {
        // var_dump(session('agent'));die;

        // if ($this->request->isGet()) {
        //     $this->assign('title', '用户登录');
        //     return $this->fetch();
        // } else {
        //     // var_dump(md5($this->request->post('password')));die;
        //     $mobile = $this->request->post('mobile', '', 'trim');
        //     $password = $this->request->post('password', '', 'trim');
        //     (empty($mobile) || strlen($mobile) != 11) && $this->error('手机号长度不正确长度不正确!');
        //     (empty($password) || strlen($password) < 6) && $this->error('登录密码长度不能少于6位有效字符!');
        //     $user = Db::name('LxUser')->where('mobile', $mobile)->find();
        //     empty($user) && $this->error('登录账号不存在，请重新输入!');
        //     ($user['password'] !== md5($password)) && $this->error('登录密码与账号不匹配，请重新输入!');
        //     Db::name('SystemUser')->where('id', $user['id'])->update(['login_at' => ['exp', 'now()'], 'login_num' => ['exp', 'login_num+1']]);
        //     session('agent', $user);
        //     // !empty($user['authorize']) && NodeService::applyAuthNode();
        //     LogService::write('代理用户管理', '用户'.$mobile.'登录系统成功');
        //     $this->success('登录成功，正在进入后台...', '@html/Agents/index');
        // }
    }

    //受邀请页面
    public function tobeinvited()
    {
        $share_no = $this->request->param('share_no') ? trim($this->request->param('share_no')) : '';
        if(!$share_no){
            $this->error('地址参数接收失败，请重新打开受邀的链接');
        }
        $UserInviteModel = new UserInvite;
        $info = $UserInviteModel
        ->alias('ui')
        // ->join('lx_product p', 'ui.product_id = p.id')
        ->join('lx_user u', 'ui.user_id = u.id')
        ->where('ui.share_no', $share_no)
        ->field('ui.*,u.username,u.mobile')
        ->find()->toArray();
        if(!$info){
            $this->error('地址参数不正确，请确认受邀链接是否正确！');
        }
        //点击+1
        if(!session('agent')){
            $UserInviteModel->where('id',$info['id'])->setInc('click_num');
        }
        
        $this->assign('info', $info);
        return view();
    }

    //核对填写信息
    public function checkinfo()
    {   
        //接收用户参数
        $param = $this->request->param();
        $sourceUrl = $this->request->header()['referer'];
        $share_no = ltrim(strstr($sourceUrl, 'share_no='), 'share_no=');
        if(!$share_no) {
            $this->error('链接参数有误！');
        }
        //判断参数
        if(checkParam($param) === false) $this->error('请填写完成！');
        if(judgeMobile($param['mobile']) == false) $this->error('手机号码格式错误！');
        if(isCreditNo($param['idcard']) === false) $this->error('身份证格式错误！'); 
        if(strlen($param['address']) > 100) $this->error('收货地址过长！');
        if($param['password'] != $param['afirmpassword']) $this->error("两次密码不一样！");
        //判断是否有该邀请
        $UserInviteModel = new UserInvite;
        $inviteInfo = $UserInviteModel->where('share_no', $share_no)->find()->toArray();
        if(!$inviteInfo) $this->error('地址参数不正确，请确认受邀链接是否正确！');
        //判断邀请时间是否过期
        if(time() >= $inviteInfo['end_in']) $this->error('受邀时间已过期~');
        
        //判断是否有这个代理信息
        $UserModel = new User;
        $judgeUserInfo = $UserModel
        ->where('mobile', $param['mobile'])
        ->whereOr('idcard', $param['idcard'])
        ->find()->toArray();        
        if($judgeUserInfo) $this->error('该手机号或身份证已被使用');
        
        //判断信息是否已经填写过了
        session('temp_invite_id', $inviteInfo['id']);
        session('temp_mobile', $param['mobile']);
        session('temp_idcard', $param['idcard']);
        $result = Db::table('lx_user_audit')->where(function ($query) {
            $query->where('mobile', session('temp_mobile'))->whereor('idcard', session('temp_idcard'));
        })->where(function ($query) {
            $query->where('user_invite_id', session('temp_invite_id'));
        })->select();
        if($result) $this->error('已经提交过信息了，请耐心等候审核~');
        session('temp_invite_id', null);
        session('temp_mobile', null);
        session('temp_idcard', null);

        //组合参数
        $UserAuditModel = new UserAudit;
        $saveData = array();
        $saveData['user_invite_id'] = $inviteInfo['id'];
        $saveData['user_id'] = $inviteInfo['user_id'];
        $saveData['product_id'] = $inviteInfo['product_id'];
        $saveData['wechat_no'] = $param['wechat_no'];
        $saveData['mobile'] = $param['mobile'];
        $saveData['idcard'] = $param['idcard'];
        $saveData['password'] = md5($param['password']);
        $saveData['address'] = $param['address'];
        $saveData['status'] = 0;
        $saveData['is_through'] = 0;
        $saveData['share_no'] = $share_no;
        $saveData['invite_level'] = $inviteInfo['level'];
        $UserAuditModel->allowField(true)->save($saveData);
        if($UserAuditModel->id){
            $this->success('提交成功，请耐心等待后台审核~', 'Index/index');
        }
        $this->error('提交失败，填写信息格式不正确！');
    }

}
