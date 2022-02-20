<?php


namespace app\common\model\mysql;


use think\Model;

class SpecValue extends BaseModel
{

    public function getNormalBySpecid($spec_id,$field)
    {
        $where = [
            'spec_id' => $spec_id,
            'status'  => self::STATUS_NORMAL,
        ];
        return $this->where('spec_id',$spec_id)->field($field)->select();
    }

    public function getNormalInIds($val_ids)
    {
        $where = [
            'status' => self::STATUS_NORMAL,
        ];
        return $this->where($where)->whereIn('id',$val_ids)->select();
    }
}