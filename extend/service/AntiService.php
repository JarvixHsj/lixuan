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

        array_pop($res);
        array_pop($res);
        array_pop($res);
        array_pop($res);
        array_pop($res);
        array_pop($res);
        return $res;
    }

    /**
     * 判断一箱是否都是同一个代理的
     * @author: Jarvix
     */
    public static function judgeBoxBelong($res)
    {
        if(!is_array($res)) return false;
        $userId = session('agent.id');
        $step = 0;
        foreach($res as $key=>$val){
//            var_dump($val['user_id']. '-----'. $userId);
            if($val['user_id'] != $userId){
                $step = 1;
                break;
            }
        }
        return $step;
    }

    /**
     * 获取用户 的防伪码信息
     * @param $user_id  用户id
     */
    public static function getUserAntiList($user_id, $combo = false)
    {
        if(!is_numeric($user_id)) return false;
        if($combo === false){
            //获取防伪码列表
            $res = Db::table('lx_anti')->where('user_id', $user_id)->select();
        }else{
            //获取逗号隔开的防伪码id 二维数组
            $sql = "SELECT group_concat(id) as ids FROM lx_anti where user_id = {$user_id}";
            $res = Db::query($sql);
        }
        if($res) return $res;
        return false;
    }

}









