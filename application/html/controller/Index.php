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
use think\response\View;
use model\Product;
use model\Banner;
use think\Db;

/**
 * 网站入口控制器
 * Class Index
 * @package app\index\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/04/05 10:38
 */
class Index extends Controller {

    /**
     * 网站入口
     */
    public function index() {
    	$Model = new Product;
    	$BannerModel = new Banner();
    	$list = $Model->where('status = 1 AND is_delete = 1')->order('id', 'desc')->select()->toArray();
    	$bannerRes = $BannerModel->where('status = 1 AND is_delete = 1')->order('id', 'desc')->select();
        if(!$bannerRes) $bannerRes = array();
        $bannerRes = $bannerRes->toArray();
    	$this->assign('list', $list);
    	$this->assign('banner_res', $bannerRes);
    	$this->assign('banner_res_count', count($bannerRes) -1);
    	return view();
    }


    /**
     * 轮播详情
     * @return View
     */
    public function bannerDetails()
    {
        $id = $this->request->param('id') ? $this->request->param('id') : 0;
        if(empty($id)) $this->error('服务器系统繁忙，请稍后重试~');

        $BannerModel = new Banner();
        $res = $BannerModel->find($id);

        $this->assign('res', $res);
        return view('banner_detail');
    }

    /**
     * 产品详情
     * @return View
     */
    public function productDetails()
    {
        $id = $this->request->param('id') ? $this->request->param('id') : 0;
        if(empty($id)) $this->error('服务器系统繁忙，请稍后重试~');

        $ProductModel = new Product();
        $res = $ProductModel->find($id);

        $this->assign('res', $res);
        return view('product/detail');
    }

    /**
     * 关于我们
     * @return View
     */
    public function about()
    {
        $res = Db::table('lx_word')->where('key', 'about')->find();
        if(empty($res)) $this->error('整改中~~');
        $this->assign('res', $res);
        return view();
    }


    /**
     * 授权查询首页
     * @return View
     */
    public function authorize()
    {
        return view();
    }


    









}
