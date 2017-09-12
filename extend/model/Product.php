<?php

	namespace model;

	use think\Model;

	class Product extends Model
	{


	  	protected $table = 'lx_product';
	  	

		// protected static function init()
		// {
		// 	parent::init();
		// 	if( !self::$user_id)  session('user_info.user_id') ? self::$user_id = session('user_info.user_id') : '2'; 
		// }


        /**
         * 获取可用的产品信息
         * @return array|false|\PDOStatement|string|\think\Collection
         */
        public function getList()
        {
            $res = $this->where('status = 1 AND is_delete = 1')->select();
            if($res) return $res;
            return array();
        }

        /**
         * 获取某个字段的值
         * @param $product_id
         * @param string $field
         * @return array|bool|false|\PDOStatement|string|Model
         */
        public function getField($product_id, $field = "*")
        {
            if(!is_numeric($product_id)) return false;
            $res = $this->where('id',$product_id)->field($field)->find($product_id);
            if($res) return $res->toArray();
            return false;
        }
	}
