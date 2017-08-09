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

    /**
     * 获取用户信息
     * @param $id
     * @return array|bool
     */
    public function getUserInfo($id)
    {
        $res = $this->find($id);
        if($res){
            return $res->toArray();
        }else{
            return false;
        }
    }


    /**
     * 获取所有可用用户
     */
    public function getUserList()
    {
        $res = $this->where('status',1)->select();
        if($res){
            return $res->toArray();
        }
        return false;
    }

}
