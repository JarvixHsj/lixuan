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
use think\response\View;
use think\Db;
use think\Url;

/**
 * 文档管理
 * @package app\lixuan\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Word extends BasicAdmin {

    /**
     * 定义当前操作表名
     * @var string
     */
    public $table = 'lx_word';

    public $randStr = 'abcdefghijklmnopqrstuvwxyz1234567890';


    /**
     * 列表
     * @return View
     */
    public function index() {
        $res = Db::name($this->table)->where('status', 1)->select();
        $this->assign('title', '文档列表信息');
        $this->assign('list', $res);
        return view();
    }


    /**
     * 编辑
     * @return View
     */
    public function edit() {
        $id = $this->request->get('id', '');
        if ($this->request->isGet()) {
            empty($id) && $this->error('参数错误，请稍候再试！');

            $returnUrl = $_SERVER['HTTP_REFERER'].'#/lixuan/word/index.html?spm=m-87-'.rand(0,9).rand(0,9);
            $this->assign('returnUrl', $returnUrl);
            $result['vo'] = Db::table($this->table)->find($id);
            $result['title'] = '编辑'.$result['vo']['name'];

            return view('edit', $result);
        }
        $data = $this->request->param();
        if (!empty($data['id'])) {
            unset($data['spm']);

            //重新组合要插入的数据
            $data['change_at'] = date('Y-m-d H:i:s', time());

            $comboRes = Db::table('lx_word')->update($data);
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
