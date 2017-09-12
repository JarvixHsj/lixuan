<?php

	namespace model;

	use think\Model;

	class Purchases extends Model
	{
	  	protected $table = 'lx_purchase';
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
            $res = $this->select();
            if($res) return $res;
            return array();
        }

        /**
         * 获取一条采购信息
         * @param int $id
         * @return array|false|\PDOStatement|string|Model
         */
        public function getOneInfo($id = 0)
        {
            if(!$id) return array();
            $res = $this->find($id);
            if($res) return $res;
            return array();
        }

        /**
         * 修改采购信息的审核状态
         * @param $id
         * @param int $value
         * @return int
         */
        public function setAudit($id, $value = 0)
        {
            return $this->where('id', $id)->setField('audit', $value);
        }

        /**
         * 根据ID条件更新信息
         * @param $id
         * @param array $data
         * @return $this
         */
        public function updateById($id, $data = array())
        {
            return $this->where('id', $id)->update($data);
        }
	}
