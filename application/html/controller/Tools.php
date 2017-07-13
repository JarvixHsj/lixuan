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
class Tools extends Controller {

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
     * 上传目录路径public
     * @var string
     */
//    private $path = ROOT_PATH.'public'.DS. 'uploads/';

    /**
     * 控制器基础方法
     */
//    public function _initialize() {
//        if (session('agent') && $this->request->action() !== 'out') {
//            $this->redirect('@html/Agents/index');
//        }
//    }

    /**
     * 用户登录
     * @return string
     */
    public function index() {
        // var_dump(session('agent'));die;
//        if ($this->request->isGet()) {
//            $this->assign('title', '用户登录');
//            return $this->fetch();
//        } else {
//
//        }
    }




    /**
     * 用户上传身份证。
     */
    public  function ajaxUploads()
    {
        //校验图片是否存在
//        $url = session('user.reverse');
//        if(file_exists(UPLOAD_PATH.$url)){
//            echo '1';
//        }else{
//            echo '2';
//        }
////        var_dump($headerPath.$url);
//
//        die;
        $uploadCatelogName = 'user';//存储在uploads目录下的路径名
        $paramSelect = array(1 => 'positive', 2 => 'reverse');
//        positive正面    reverse反面
        $type = $this->request->param('type');  //用于判断是正面还是反面图片  1=正面  2=反面
        if(array_key_exists($type,$paramSelect)){
            //上传文件目录位置是
            $fileCatelog = UPLOAD_PATH.$uploadCatelogName;
            $res = $this->upload($paramSelect[$type], $fileCatelog);
            if($res) {
                session('user.'.$paramSelect[$type],$uploadCatelogName.DS.$res); //存储
                var_dump($res);
            }
            //string(50) "/Library/WebServer/Documents/lixuan/public/uploads"
//            jpg20170712/8feaeebe7e987d759e5146cbbb419004.jpg8feaeebe7e987d759e5146cbbb419004.jpg
        }
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


    /**
     * 图片上传
     * @param  string $uploadName [description]
     * @param  [type] $catalog    [description]
     * @return [type]             [description]
     */
    protected function upload($uploadName = 'image', $catalog = ROOT_PATH){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($uploadName);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move($catalog);
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
//            echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            $res = $info->getSaveName();
//            var_dump($info->getSaveName());die;
            return $res;
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
//            echo $info->getFilename();
        }else{
            // 上传失败获取错误信息
//            echo $file->getError();
            return false;
        }
    }
}
