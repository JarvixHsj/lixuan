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

namespace service;

use think\Db;
/**
 * 防伪相关服务
 * Class AntiService
 * @package service
 * @author Anyon <zoujingli@qq.com>
 * @date 2016/10/25 14:49
 */
class AntiService {


    /**
     * 判断数据是否存在，一条！
     * @param $where    查询条件
     * @return array|bool|false|\PDOStatement|string|\think\Model
     */
    public static function JudgeAnti($where)
    {
        $res = Db::table('lx_anti')->where($where)->select();
        if($res) return $res;
        return false;
    }


    /**
     * 获取一箱数据
     * @param $qrstr
     */
    public static function getABoxTotal($qrstr)
    {

        $qrstr = rtrim($qrstr, 318);
        $res = Db::table('lx_anti')->where('code','like',"{$qrstr}%")->select();
        if(!$res) return false;

        array_shift($res);
        array_shift($res);
        array_shift($res);
        array_shift($res);
        array_shift($res);
        array_shift($res);
        return $res;
    }

}









