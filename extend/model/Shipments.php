<?php

namespace model;
use think\Db;
use think\Model;

class Shipments extends Model
{
    protected $table = 'lx_shipments';

    // protected static function init()
    // {
    // 	parent::init();
    // 	if( !self::$user_id)  session('user_info.user_id') ? self::$user_id = session('user_info.user_id') : '2';
    // }


//    public static function getCondJudgeAnti($condition)
//    {
//        Db::table($this->table)
//            ->where($condition)
//            ->
//    }

}
