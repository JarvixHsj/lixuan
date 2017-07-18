<?php

	namespace model;

	use think\Model;

	class Agent extends Model
	{


		protected $table = 'lx_agent';
		
		
		public function getOneInfo($where = array())
		{
			$res = $this->where($where)->find()->toArray();
			if($res) return $res;
			return false;
		}


        //查询用户代理产品信息
        public function getUserAgentList($user_id)
        {
            $res = $this->alias('a')
                ->field('a.*,p.name')
                ->join('lx_product p', 'p.id = a.product_id')
//                ->where('a.user_id', $user_id)
                ->where(array('a.user_id' => $user_id, 'p.is_delete' => 1))
                ->select()->toArray();
            if($res) return $res;
            return false;
        }
	

	}
