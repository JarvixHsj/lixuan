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
class AgentService {

    const CONFEMPOWER = 'empower';

    //生成授权号
    public static function createAgentSn($zimu = 'LX')
    {
        $res = Db::name('SystemConfig')->where(array('name'=> self::CONFEMPOWER))->find();
        if(!$res) return false;
        $valNum = strlen($res['value']);
        if(Db::name('SystemConfig')->where('name', self::CONFEMPOWER)->setInc('value') === false) return false;
        if($valNum >= 3) {
            return $zimu.$res['value'];
        }
        return $zimu.str_pad($res['value'], 3, '0', STR_PAD_LEFT);
    }

    //生成分享邀请记号
    public static function createAgentInvite()
    {
        $nanosecond = getMillisecond();
        return md5($nanosecond.uniqid());
    }

    /**
     * 生成发货唯一订单号
     * @return string
     */
    public static function createShipmentSn()
    {
        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    /**
     * 生成用户消息记录
     * @param int $user_id
     * @param string $content
     * @param string $type
     */
    public static function createMessage($data)
    {
        Db::table('lx_message')->insert($data);
    }


    /**
     * 统计代理直属人数
     * @param $userId  代理用户id
     * @param $proId  产品id
     * @return int|string
     */
    public static function totalDirectlyNum($userId, $proId)
    {
        if(!is_numeric($userId)) return 0;
        $num = Db::table('lx_agent')
            ->where('super_id',$userId)
            ->count();
        if(is_numeric($num)) return $num;
        return 0;
    }


    /**
     * 统计代理团队人数（不包括自己）
     * @param $userId
     * @param $proId
     * @return int
     */
    public static function totalAgentTeam($userId, $proId)
    {
        if(!is_numeric($userId)) return 0;

        $total = 0;
        $num = self::recursionTotal($userId, $total, $proId);
        if(is_numeric($num)) return $num;
        return 0;
    }

    /**
     * 递归统计
     * @param $userId
     * @param $total
     * @param $proId
     * @return int
     */
    public static function recursionTotal($userId, &$total, $proId)
    {
        $res = Db::table('lx_agent')
            ->where('super_id', $userId)
            ->where('product_id', $proId)
            ->select();
        if($res){
            $total += count($res);
            foreach($res as $key => $val){
                self::recursionTotal($val['user_id'], $total, $proId);
            }
        }
        return $total;
    }


    /**
     * 代理团队列表
     * @param $userId
     * @param $proId
     * @return array
     */
    public static function agentTeamList($userId, $proId = 0)
    {
        if(!is_numeric($userId)) return array();

        $list = array();
        $totalList = self::recuesionTeamList($userId, $list, $proId);
        if(is_array($totalList)) return $totalList;
        return array();
    }

    /**
     * 递归查询代理团队人数
     * @param $userId
     * @param $list
     * @param $proId
     * @return array
     */
    public static function recuesionTeamList($userId, &$list, $proId)
    {
        $where = array();
        if($userId) $where['super_id'] = $userId;
        if($proId) $where['product_id'] = $proId;
        $res = Db::table('lx_agent')
            ->where($where)
            ->select();
        if($res){
            $list[] = $res;
            foreach($res as $key => $val){
                self::recuesionTeamList($val['user_id'], $list, $proId);
            }
        }
        return $list;
    }


    /**
     * 查询代理直属人数
     * @param $userId
     */
    public static function agentDirectlyList($userId)
    {
        if(!is_numeric($userId)) return false;
        $res = Db::table('lx_agent')->alias('a')
            ->join('lx_user u', 'u.id = a.user_id')
            ->join("lx_product p", "p.id = a.product_id")
            ->where('super_id', $userId)
            ->field('a.*,u.username,u.mobile,u.wechat_no,p.name as project_name')
            ->select();
        if(!$res) return false;
        return $res;
    }


    /**
     * 获取代理 授权信息
     * @param int $agent_id
     * @param int $pro_id
     */
    public static function getAgentAllInfo($agent_id = 0,$pro_id = 0)
    {
        return Db::table('lx_agent')->alias('a')
            ->join('lx_user u ', 'u.id = a.user_id')
            ->join('lx_product p ', 'p.id = a.product_id')
            ->where('a.id', $agent_id)
            ->where('a.product_id', $pro_id)
            ->field('a.*,u.username,u.mobile,u.wechat_no,p.name as product_name')
            ->find();
//        var_dump($res);die;
    }


    /**
     * 获取单条代理信息
     * @param int $agent_id
     */
    public static function getAgentOneInfo($agent_id = 0)
    {
        return Db::table('lx_agent')->find($agent_id);
    }





}









