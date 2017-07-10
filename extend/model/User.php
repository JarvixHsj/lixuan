<?php
namespace model;
use think\Model;

class User extends Model
{
    protected $table = 'lx_user';

    public  function updatePassword($where = array(), $save = array())
    {
        return $this->allowField(true)->update($save,$where);

    }

}
