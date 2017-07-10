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

	}
