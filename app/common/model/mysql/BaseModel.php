<?php


namespace app\common\model\mysql;


use think\Model;

class BaseModel extends Model
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'datetime';
    // 定义时间戳字段名
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    //状态
    const STATUS_NORMAL = 1;
    const STATUS_FROZEN = 0;
    const STATUS_DEL = 2;
    const STATUS_UNDER_REVIEW = 3;

    public static $statusMap = [
        'status_normal' => self::STATUS_NORMAL,
        'status_frozen' => self::STATUS_FROZEN,
        'status_del' => self::STATUS_DEL,
        'status_under_review' => self::STATUS_UNDER_REVIEW,
        self::STATUS_NORMAL => '正常',
        self::STATUS_FROZEN => '冻结',
        self::STATUS_DEL => '已删除',
        self::STATUS_UNDER_REVIEW => '待审核',
    ];

    public function getNormalById($id,$field=true)
    {
        return $this->where('status',self::STATUS_NORMAL)->field($field)->find($id);
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

    public function searchTitleAttr($query,$value)
    {
        $query->where('title','like','%'.$value.'%');
    }

    public function searchCreateTimeAttr($query,$value)
    {
        $query->whereBetweenTime('created_at',$value[0],$value[1]);
    }

    public function getPaginateData($keys,$data,$num,$order)
    {
        if($keys){
            $res = $this->withSearch($keys,$data);
        }else{
            $res = $this;
        }

        return $res->whereIn('status',[self::STATUS_NORMAL,self::STATUS_FROZEN,self::STATUS_UNDER_REVIEW])->order($order)->paginate($num);
    }

    public function getModelData($where,$field)
    {
         return $this->where($where)->field($field)->select();

    }

    public function getwhereInId($id,$field)
    {
        return $this->whereIn('id',$id)->field($field)->select();
    }
}