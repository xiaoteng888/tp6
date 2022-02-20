<?php


namespace app\common\model\mysql;


use think\Model;

class Category extends BaseModel
{

    public function getNomarlCategories($field,$order)
    {
        return $this->where('status',self::STATUS_NORMAL)->field($field)->order($order)->select();
    }

    public function getNomarlByPid($pid,$num)
    {
        $where = [
            'pid' => $pid,
            //'status' => ['<>',self::STATUS_DEL],
        ];
        $order = [
            'sort' => 'desc',
            'id'   => 'desc',
        ];
        $res = $this->where('status','<>',self::STATUS_DEL)->where($where)->order($order)->paginate($num);
        //echo $this->getLastSql();
        return $res;
    }

    public function getCateByPid($pid,$field)
    {
        $where = [
            'pid' => $pid,
            'status' => self::STATUS_NORMAL,
        ];
        $order = [
            'sort' => 'desc',
            'id'   => 'desc',
        ];
        $res = $this->where($where)->field($field)->order($order)->select();
        //echo $this->getLastSql();
        return $res;
    }

    public function getTotalByPid($pids)
    {
        $where[] = ['pid','in',$pids];
        $where[] = ['status','<>',self::STATUS_DEL];

        return $this->where($where)->field(['pid',"count(*) as total"])->group('pid')->select();
    }

    public function getwhereInPid($cate_ids,$field)
    {
        return $this->whereIn('pid',$cate_ids)->field($field)->select();
    }
}