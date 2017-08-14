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


    /**
     * getShipmentList
     * @author: Jarvix
     * @param $condition
     * @param int $pagenum
     * @param int $pagesize
     * @return bool|false|\PDOStatement|string|\think\Collection
     */
    public static function getShipmentList($condition,  $pagesize = 2)
    {
        $rowPage = cookie('rows');
        cookie('rows', $rowPage >= 2 ? $rowPage : 2);
        $list = Db::name('lx_shipments')
            ->where($condition)
            ->order('id desc')
            ->paginate($pagesize,false,[
            'page' => input('param.page'),
//            'path'=>__ACTION__.'/channel/'.$channel.'/page/[PAGE].html',
            ]);

        return $list->toArray();
    }

}
