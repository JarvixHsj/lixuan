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
 * 代理服务
 * Class AgentService
 * @package service
 * @author Anyon <zoujingli@qq.com>
 * @date 2016/10/25 14:49
 */
class PurchasesService {


    /**
     * 获取用户向别人采购的记录
     * @param $user_id
     * @return bool|false|\PDOStatement|string|\think\Collection
     */
    public static function getUserSponsorList($user_id)
    {
        if(!$user_id) return false;
        $res = Db::table('lx_purchase')->alias('p')
            ->field('p.*,u.username as sponsor_username, uu.username as incept_username')
            ->join('lx_user u', 'u.id = sponsor_user_id')
            ->join('lx_user uu', 'uu.id = incept_user_id')
            ->where('sponsor_user_id', $user_id)
            ->order('p.id desc')
            ->select();
        if($res) return $res;

        return false;
    }

    /**
     * 获取用户被别人采购的记录
     * @param $user_id
     * @return bool|false|\PDOStatement|string|\think\Collection
     */
    public static function getUserInceptList($user_id)
    {
        if(!$user_id) return false;
        $res = Db::table('lx_purchase')->alias('p')
            ->field('p.*,u.username as sponsor_username, uu.username as incept_username')
            ->join('lx_user u', 'u.id = sponsor_user_id')
            ->join('lx_user uu', 'uu.id = incept_user_id')
            ->where('incept_user_id', $user_id)
            ->whereOr('super_user_id', $user_id)
            ->order('p.id desc')
            ->select();
        if($res) return $res;
    }


    /**
     * 获取采购记录的详情信息
     * @param $Purchase_id  采购记录id
     * @return bool|false|\PDOStatement|string|\think\Collection
     */
    public static function getPurchaseDetailsInfo($Purchase_id)
    {
        if(!$Purchase_id) return false;
        $res = Db::table('lx_purchase_details')->where('purchase_id', $Purchase_id)->select();
        if($res) return $res;
        return  false;
    }


//    /**
//     * 生成发货唯一订单号
//     * @return string
//     */
//    public static function createShipmentSn()
//    {
//        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
//    }
//
//
//    /**
//     * 代理团队列表
//     * @param $userId
//     * @param $proId
//     * @return array
//     */
//    public static function User($userId, $proId = 0)
//    {
//        if(!is_numeric($userId)) return array();
//
//        $list = array();
//        $totalList = self::recuesionTeamList($userId, $list, $proId);
//        if(is_array($totalList)) return $totalList;
//        return array();
//    }
//
//    /**
//     * 递归查询代理团队人数
//     * @param $userId
//     * @param $list
//     * @param $proId
//     * @return array
//     */
//    public static function recuesionTeamList($userId, &$list, $proId)
//    {
//        $where = array();
//        if($userId) $where['super_id'] = $userId;
//        if($proId) $where['product_id'] = $proId;
//        $res = Db::table('lx_agent')
//            ->where($where)
//            ->select();
//        if($res){
//            $list[] = $res;
//            foreach($res as $key => $val){
//                self::recuesionTeamList($val['user_id'], $list, $proId);
//            }
//        }
//        return $list;
//    }
//
//
//    /**
//     * 查询代理直属人数
//     * @param $userId
//     */
//    public static function agentDirectlyList($userId)
//    {
//        if(!is_numeric($userId)) return false;
//        $res = Db::table('lx_agent')->alias('a')
//            ->join('lx_user u', 'u.id = a.user_id')
//            ->join("lx_product p", "p.id = a.product_id")
//            ->where('super_id', $userId)
//            ->field('a.*,u.username,u.mobile,u.wechat_no,p.name as project_name')
//            ->select();
//        if(!$res) return false;
//        return $res;
//    }
//
//
//    /**
//     * 获取代理 授权信息
//     * @param int $agent_id
//     * @param int $pro_id
//     */
//    public static function getAgentAllInfo($agent_id = 0,$pro_id = 0)
//    {
//        return Db::table('lx_agent')->alias('a')
//            ->join('lx_user u ', 'u.id = a.user_id')
//            ->join('lx_product p ', 'p.id = a.product_id')
//            ->where('a.id', $agent_id)
//            ->where('a.product_id', $pro_id)
//            ->field('a.*,u.username,u.mobile,u.wechat_no,p.name as product_name')
//            ->find();
////        var_dump($res);die;
//    }
//
//
//    /**
//     * 获取单条代理信息
//     * @param int $agent_id
//     */
//    public static function getAgentOneInfo($agent_id = 0)
//    {
//        return Db::table('lx_agent')->find($agent_id);
//    }
//
//
//    /**
//     * 统计用户未读消息
//     * @param int $user_id
//     * @return bool|int|string
//     */
//    public static function getMessageUnreadNum($user_id = 0)
//    {
//        if(empty($user_id)) return false;
//        $where = array();
//        $where['user_id'] = $user_id;
//        $where['is_read'] = 0;
//        $num = Db::table('lx_message')->where($where)->count();
//        if($num > 0) return $num;
//        return false;
//    }
//
//
//    public static function getAgentSuperInfo($agent_id)
//    {
//        if(!$agent_id) return false;
//        $res = Db::table('lx_agent')->alias('a')
//            ->join('lx_user u', 'u.id = a.super_id')
//            ->join('lx_product p ', 'p.id = a.product_id')
//            ->field('a.*,u.username,u.mobile,u.wechat_no,p.name as product_name')
//            ->find($agent_id);
//        if($res) return $res;
//        return false;
//    }
//
//
//    /**
//     * 获取用户上级代理列表
//     * @param $user_id
//     * @return bool|false|\PDOStatement|string|\think\Collection
//     */
//    public static function getSuperAgentUserIDList($user_id)
//    {
//        if(!$user_id) return false;
//        $res = Db::table('lx_agent')->alias('a')
//            ->join('lx_user u', 'u.id = a.super_id')
//            ->join('lx_product p ', 'p.id = a.product_id')
//            ->distinct(true)
//            ->where('user_id', $user_id)
//            ->where('super_id != 0')
//            ->field('a.super_id')
//            ->field('a.*,u.username,u.mobile,u.wechat_no,p.name as product_name')
//            ->select();
//        if($res) return $res;
//        return false;
//    }
//




}









