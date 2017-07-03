<?php

namespace model;
use think\Model;

class UserInvite extends Model
{

	protected $table = 'lx_user_invite';
	
	public function getInviteList( $where)
	{
		if(!is_array($where)) return false;
		$res = $this->where($where)->select()->toArray();
		if($res) return $res;
		return false;
	}
}
