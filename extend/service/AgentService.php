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
     * 生成用户消息记录
     * @param int $user_id
     * @param string $content
     * @param string $type
     */
    public static function createMessage($data)
    {
        Db::table('lx_message')->insert($data);
    }


}
