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
use think\Url;

/**
 * 游客控制器
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
        if($info['end_in'] < time()){
            $this->error('邀请时间已过期，请联系代理重新生成分享链接~', Url::build('Index/index'));
        }

        $this->assign('info', $info);
        return view();
    }

    //核对填写信息
    public function checkinfo()
    {   
        //接收用户参数
        $param = $this->request->param();
        $this->assign('param', $param);
        $sourceUrl = $this->request->header()['referer'];
        $strstrStr = strstr($sourceUrl, 'share_no=');
        $share_no = substr($strstrStr,9,32);  //截取
        if(!$share_no) {
            $this->result('',0, '链接参数有误~','json');
        }
        //判断是否有该邀请
        $UserInviteModel = new UserInvite;
        $inviteInfo = $UserInviteModel->where('share_no', $share_no)->find();
        if(!$inviteInfo) $this->result('',0,'地址参数不正确，请确认受邀链接是否正确！', 'json');
        $inviteInfo = $inviteInfo->toArray();
        //判断邀请时间是否过期
        if(time() >= $inviteInfo['end_in']) $this->result('',0, '受邀时间已过期~','json');

        //判断参数
        if(checkParam($param) === false) $this->result('',0, '请填写完成~','json');
        if(judgeMobile($param['mobile']) == false) $this->result('',0, '手机号码格式错误~','json');
        if(isCreditNo($param['idcard']) === false) $this->result('',0, '身份证格式错误~','json');
        if(strlen($param['address']) > 100) $this->result('',0, '收货地址过长~','json');
        if(strlen($param['username']) > 25) $this->result('',0, '姓名长度过长~','json');
        if($param['password'] != $param['afirmpassword']) $this->result('',0, '两次密码不一样~','json');
        //校验图片是否存在
        $reversePath = session('user.reverse');
        $positivePath = session('user.positive');
        if(!empty($positivePath) && !file_exists(UPLOAD_PATH.$positivePath)) $this->result('', 0, '请重新上传正面照片！','json');
        if(!empty($reversePath) && !file_exists(UPLOAD_PATH.$reversePath)) $this->result('', 0, '请重新上传反面照片！','json');

        //判断是否有这个代理信息代理过该产品
        $sql = "SELECT u.* FROM lx_user u JOIN lx_agent a ON a.user_id = u.id WHERE (u.mobile = '{$param['mobile']}' OR u.idcard = '{$param['idcard']}') AND a.product_id = '{$inviteInfo['product_id']}'";
        $judgeUserInfo = Db::query($sql);
        if($judgeUserInfo) $this->result('',0, '该手机号或身份证已经代理了该产品！不可重复代理！','json');
        
        //判断信息是否已经填写过了
        session('temp_invite_id', $inviteInfo['id']);
        session('temp_mobile', $param['mobile']);
        session('temp_idcard', $param['idcard']);
        $result = Db::table('lx_user_audit')->where(function ($query) {
            $query->where('mobile', session('temp_mobile'))->whereor('idcard', session('temp_idcard'));
        })->where(function ($query) {
            $query->where('user_invite_id', session('temp_invite_id'));
        })->select();
        if($result) $this->result('',0, '已经提交过信息了，请耐心等候审核~','json');
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
        $saveData['username'] = $param['username'];
        $saveData['mobile'] = $param['mobile'];
        $saveData['idcard'] = $param['idcard'];
        $saveData['password'] = md5($param['password']);
        $saveData['address'] = $param['address'];
        $saveData['status'] = 0;
        $saveData['is_through'] = 0;
        $saveData['share_no'] = $share_no;
        $saveData['invite_level'] = $inviteInfo['level'];
        $saveData['positive'] = $reversePath;
        $saveData['reverse'] = $positivePath;
        $UserAuditModel->allowField(true)->save($saveData);
        if($UserAuditModel->id){
            $this->result(Url::build('Index/index'),1, '提交成功，请耐心等待后台审核~','json');
        }
        if($result) $this->result('',0, '提交失败，填写信息格式不正确！','json');
    }


    /**
     * 合作协议
     */
    public function agree()
    {

        return view();
    }




}


