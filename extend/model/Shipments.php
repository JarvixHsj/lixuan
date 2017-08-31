<?php

namespace model;
use think\Db;
use think\Model;

class Shipments extends Model
{
    protected $table = 'lx_shipments';

    /**
     * getShipmentList
     * @author: Jarvix
     * @param $condition
     * @param int $pagenum
     * @param int $pagesize
     * @return bool|false|\PDOStatement|string|\think\Collection
     */
    public static function getShipmentList($condition,  $pagesize = 10)
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

    /**
     * 关键字匹配
     */
    public static function searchKeyword($keyword)
    {
        if(!$keyword) return false;

        $list = Db::table('lx_anti')
            ->field('id,qrcode,code,passwd,query,user_id,product_id')
            ->where('code', 'like', "{$keyword}%")
            ->order('user_id asc')
            ->limit(0,48)
            ->select();
        if($list) return $list;
        return false;
    }

}
