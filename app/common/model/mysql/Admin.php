<?php


namespace app\common\model\mysql;


use think\Model;

class Admin extends Model
{
    /**
     * 根据用户名获取后端Aadmin表数据
     * @param $username
     * @return bool
     */
    public function getAdminByUsername($username)
    {
        if(empty($username)){
            return false;
        }
        $where = [
            'username' => trim($username),
        ];
        return $this->where($where)->find();
    }

    public function updateById($id, $updateData)
    {
        if(!$id || !$updateData || !is_array($updateData)){
            return false;
        }
        $where = [
            'id' => $id,
        ];
        return $this->where($where)->save($updateData);
    }

}