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
use service\PayService;
use service\FileService;
use model\Banner as banners;
use think\response\View;
use think\Db;
use think\Url;

/**
 * 轮播管理
 * @package app\lixuan\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Banner extends BasicAdmin {

    /**
     * 定义当前操作表名
     * @var string
     */
    public $table = 'lx_banner';

    public $randStr = 'abcdefghijklmnopqrstuvwxyz1234567890';


    /**
     * 列表
     * @return View
     */
    public function index() {
        $res = Db::name($this->table)->where('is_delete', 1)->select();
        $this->assign('title', '轮播列表信息');
        $this->assign('add', '添加轮播');
        $this->assign('list', $res);
        return view();
    }


    /**
    * 添加
    */
    public function add() {
        if ($this->request->isGet()) {

            $returnUrl = $_SERVER['HTTP_REFERER'].'#/lixuan/banner/index.html?spm=m-87-'.rand(0,9).rand(0,9);
            $this->assign('returnUrl', $returnUrl);
            return view('form');
            return parent::_form($this->table, 'form', 'id');
        }
        //接收参数
        $data = $this->request->post();
        $data = $data['data'];

        //获取图片信息  后缀名等
        $phpinfo = pathinfo($data['image']);
        // var_dump($this->request->host(),$root);

        //去除域名图片域名，取得目录路径部分
        $tempOldName = trim(strstr($data['image'], $this->request->host()), $this->request->host());
        //拼成绝对路径
        $oldname = $this->request->server('DOCUMENT_ROOT') . $tempOldName;
        //组合新的绝对路径
        $newNamePath = "/static/admin/image/banner/". date('Y-m-d-H-i-s',time()).$this->randStr[mt_rand(0, 35)].'.'.$phpinfo['extension'];
        $newname = $this->request->server('DOCUMENT_ROOT').$newNamePath;
        //判断新路径是否不存在，判断旧路径是存在
        if(file_exists($newname) || !file_exists($oldname)){
            $this->error('目标文件已存在或原文件不存在，请重新上传图片');
        }
        //移动文件 结果是bool
//        var_dump($oldname,$newname);die;
        $mvFileRes = @rename($oldname,$newname);  
        if(!$mvFileRes){
            $this->error('网络出错，请稍后再重试~');
        }

        //重新组合要插入的数据
        $newTime = date('Y-m-d H:i:s',time());
        $data['image'] = $newNamePath;
        $data['created_at'] = $newTime;
        $data['change_at'] = $newTime;
//        var_dump($data);die;
        $bannerId = Db::table('lx_banner')->insertGetId($data);

        if($bannerId)
            $this->success('添加成功！', '');

        $this->error('添加失败，请重试~');

    }


    /**
     * 编辑
     * @return View
     */
    public function edit() {
        $id = $this->request->get('id', '');
        if ($this->request->isGet()) {
            empty($id) && $this->error('参数错误，请稍候再试！');

            $returnUrl = $_SERVER['HTTP_REFERER'].'#/lixuan/banner/index.html?spm=m-87-'.rand(0,9).rand(0,9);
            $this->assign('returnUrl', $returnUrl);
            $result['title'] = '编辑轮播';
            $result['vo'] = Db::table($this->table)->find($id);
//            return view('form', ['title' => '编辑图文', 'vo' => WechatService::getNewsById($id)]);
//            $this->assign('vo', $result);
            return view('edit', $result);
        }
        $data = $this->request->param();
        if (!empty($data['id'])) {
            unset($data['spm']);
            //查询出原来的产品信息
            $BannerModel = new banners();
            $oldInfo = $BannerModel->find($data['id']);
            if(!$oldInfo) $this->error('参数有误，请稍后重试！');
            $oldInfo = $oldInfo->toArray();
//            var_dump($data,$oldInfo);die;
            //判断是否有重新上传图片
            if($oldInfo['image'] != $data['image']){
                 //获取图片信息  后缀名等
                $phpinfo = pathinfo($data['image']);
                //去除域名图片域名，取得目录路径部分
                $tempOldName = trim(strstr($data['image'], $this->request->host()), $this->request->host());
                //拼成绝对路径
                $oldname = $this->request->server('DOCUMENT_ROOT') . $tempOldName;
                //组合新的绝对路径
                $newNamePath = "/static/admin/image/banner/". date('Y-m-d-H-i-s',time()).$this->randStr[mt_rand(0, 35)].'.'.$phpinfo['extension'];
                $newname = $this->request->server('DOCUMENT_ROOT').$newNamePath;
                //判断新路径是否不存在，判断旧路径是存在
                if(file_exists($newname)||!file_exists($oldname)){
                    $this->error('目标文件已存在或原文件不存在！');
                }
                //移动文件 结果是bool
                $mvFileRes = @rename($oldname,$newname);
                if(!$mvFileRes){
                    $this->error('网络出错，请重试~');
                }
                @unlink($this->request->server('DOCUMENT_ROOT').$data['image']);
                $data['image'] = $newNamePath;
            }

            //重新组合要插入的数据
            $data['change_at'] = date('Y-m-d H:i:s', time());
            $comboRes = $BannerModel->update($data );
            if($comboRes !== false) $this->success('保存成功!', '');
            $this->error('保存失败，请稍候再试！');
        }
        $this->error('参数有误，请稍后重试！');

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
        $successUrl = $_SERVER['HTTP_REFERER'].'#/lixuan/banner/index.html?spm=m-87-'.rand(0,9).rand(0,9);
        $this->success('操作成功~', $successUrl);
    }
    

    /**
     * 删除
     */
    public function del() {
        if (DataService::update($this->table)) {
            $this->success("删除成功!", '');
        }
        $this->error("删除失败, 请稍候再试!");
    }

}
