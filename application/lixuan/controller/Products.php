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
use model\Product;
use think\response\View;
use think\Db;
use think\Url;

/**
 * 微信配置管理
 * Class Config
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Products extends BasicAdmin {

    /**
     * 定义当前操作表名
     * @var string
     */
    public $table = 'LxProduct';

    public $randStr = 'abcdefghijklmnopqrstuvwxyz1234567890';

    /**
     * 产品列表
     * @return View
     */
    public function index() {
        $res = Db::name($this->table)->where('is_delete', 1)->select();
        
        $this->assign('title', '产品列表信息');
        $this->assign('list', $res);
        return view();
    }


    /**
    * 添加产品
    */
    public function add() {
        if ($this->request->isGet()) {
            return view('form');
            return parent::_form($this->table, 'form', 'id');
        }
        //接收参数
        $data = $this->request->post();
//        var_dump($data);die;

        //获取图片信息  后缀名等
        $phpinfo = pathinfo($data['image']);
        // var_dump($this->request->host(),$root);

        //去除域名图片域名，取得目录路径部分
        $tempOldName = trim(strstr($data['image'], $this->request->host()), $this->request->host());
        //拼成绝对路径
        $oldname = $this->request->server('DOCUMENT_ROOT') . $tempOldName;
        //组合新的绝对路径
        $newNamePath = "/static/admin/image/product/". date('Y-m-d-H-i-s',time()).$this->randStr[mt_rand(0, 35)].'.'.$phpinfo['extension'];
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

        //重新组合要插入的数据
        $data['abbr'] = strtoupper($data['abbr']);
        $data['image'] = $newNamePath;
        $data['change_at'] = time();
        $ProductModel = new product;
        $ProductModel->data($data)->allowField(true)->save();

        if($ProductModel->id) 
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

            $result['title'] = '编辑图文';
            $result['vo'] = Db::table('lx_product')->find($id);

//            return view('form', ['title' => '编辑图文', 'vo' => WechatService::getNewsById($id)]);
//            $this->assign('vo', $result);
            return view('edit', $result);
        }
        $data = $this->request->post();
        $ids = $this->_apply_news_article($data['data']);
        if (!empty($ids)) {
            $post = ['id' => $id, 'article_id' => $ids, 'create_by' => session('user.id')];
            if (false !== DataService::save('wechat_news', $post, 'id')) {
                $this->success('图文更新成功!', '');
            }
        }
        $this->error('图文更新失败，请稍候再试！');
    }


    /**
     * 禁止
     */
    public function forbid()
    {
        $field = $this->request->param();
        $res = Db::table('lx_product')->where('id', $field['id'])->update([$field['field'] => $field['value']]);
        if($res === false) {
            $this->error('操作失败，请重试！');
        }
        $successUrl = $_SERVER['HTTP_REFERER'].'#/lixuan/products/index.html?spm=m-87-'.rand(0,9).rand(0,9);
        $this->success('操作成功~', $successUrl);
    }
    

    /**
     * 删除用户
     */
    public function del() {
        if (DataService::update($this->table)) {
            $this->success("图文删除成功!", '');
        }
        $this->error("图文删除失败, 请稍候再试!");
    }

}
