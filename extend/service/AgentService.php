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

    //生成授权号
    public static function createAgentSn($level = 0)
    {
        $type = array('1' => 'A', '2' => 'B', '3' => 'C', '4' => 'D');

        $prefix = 'lixuan_level_';  //数据库name前缀
        if(array_key_exists($level, $type)){
            $configName = strtolower($prefix.$type[$level]);
            $res = Db::name('SystemConfig')->where(array('name'=> $configName))->find();
            if(!$res) return false;
            if(Db::name('SystemConfig')->where('name', $configName)->setInc('value') === false) return false;
            return $type[$level].str_pad($res['value'], 4, '0', STR_PAD_LEFT);
        }
        return false;
    }

    //生成分享邀请记号
    public static function createAgentInvite()
    {
        $nanosecond = getMillisecond();
        return md5($nanosecond.uniqid());
    }

}
