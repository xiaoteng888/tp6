<?php


namespace app\common\business;


use app\common\model\mysql\SpecValue;
use think\Exception;
use think\facade\Log;

class SpecsValueBusiness extends BusinessBase
{
    protected $model = null;
    public function __construct()
    {
        $this->model = new SpecValue();
    }

    public function getValuesBySpecid($spec_id,$field='id,spec_id,name')
    {
        try {
            $values = $this->model->getNormalBySpecid($spec_id,$field);
        }catch (Exception $e){
            Log::error($e->getMessage());
            return [];
        }
        return $values->toArray();
    }



    public function getValueById($id)
    {
        $value = $this->model->find($id);
        if(!$value){
            throw new Exception('该属性值不存在');
        }
        return $value;
    }

    public function del($id)
    {
        $value = $this->getValueById($id);
        try {
            $res = $value->delete();
        }catch (Exception $e){
            Log::error($e->getMessage());
            return false;
        }
        return $res;
    }

    public function getSkuSpeValue($gids,$spec_val_ids)
    {
        foreach ($gids as $k=>$v){
            $arr = explode(',',$k);
            foreach($arr as $k1 => $v1){
                $sortIds[$k1][] = $v1;
                $val_ids[] = $v1;
            }
        }
        $val_ids = array_unique($val_ids);
        $vals = $this->getNormalInIds($val_ids);

        $arr = [];
        $spec_val_ids = explode(',',$spec_val_ids);
        foreach ($sortIds as $k => $v){
            $ids = array_unique($v);
            foreach ($ids as $v1) {
                $arr[$k]['list'][] = [
                    'id' => $v1,
                    'name' => $vals[$v1]['name'],
                    'flag' => in_array($v1,$spec_val_ids) ? 1:0,
                ];
            }
            $arr[$k]['name'] = $vals[$ids[0]]['specs_name'];
        }


        return $arr;

    }

    public function getNormalInIds($ids) {
        if(!$ids) {
            return [];
        }

        try {
            $result = $this->model->getNormalInIds($ids);
        }catch (\Exception $e) {
            return [];
        }
        $result = $result->toArray();
        if(!$result) {
            return [];
        }

        $specsNames = config("spec");
        $specsNamesArrs = array_column($specsNames, "name", "id");

        $res = [];
        foreach ($result as $resultValue) {
            $res[$resultValue['id']] = [
                'name' => $resultValue['name'],
                'specs_name' => $specsNamesArrs[$resultValue['spec_id']] ?? "",
            ];
        }

        return $res;

    }
}