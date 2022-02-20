<?php


namespace app\common\lib;


class Arr
{
    public static function getCateTree($categories)
    {
        $items = [];
        foreach ($categories as $v){
            $items[$v['category_id']] = $v;
        }
        //var_dump($items);exit;
        $tree = [];
        foreach($items as $k => $v){
            if(isset($items[$v['pid']])){
                $items[$v['pid']]['list'][] = &$items[$k];
            }else{
                $tree[] = &$items[$k];
            }
        }
        foreach ($tree as $k=>$v){
            if($v['pid'] !== 0){
                unset($tree[$k]);
            }
        }
        //halt($tree);
        return $tree;
    }

    public static function sliceCateTree($data,$first=5,$second=5,$three=10)
    {
        $data = array_slice($data,0,$first);
        foreach ($data as $k=>$v){
            if(isset($v['list'])){
                $data[$k]['list'] = array_slice($v['list'],0,$second);
                foreach ($v as $kk=>$vv){
                    if(isset($vv['list'])){
                        $data[$k]['list'][$kk]['list'] = array_slice($vv['list'],0,$three);
                    }
                }
            }

        }
        return $data;
    }

    public static function getDefaultPaginate($num)
    {
        return [
            'total' => 0,
            'per_page' => 5,
            'current_page' => 1,
            'last_page' => 0,
            'data' => [],
        ];
    }
}