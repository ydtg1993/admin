<?php
/**
 * Created by PhpStorm.
 * User: ydtg1
 * Date: 2019/2/10
 * Time: 16:14
 */

namespace App\Http\Model;


class ClassifyModel extends BaseModel
{
    protected $table = 'classify';

    public static function getParent($id)
    {
        $mine = self::where('id',$id)->first();
        if(!$mine){
            return [];
        }
        $layer = $mine->layer - 1;
        $data = self::where([
            ['left','<',$mine->left],
            ['right','>',$mine->right],
            ['layer','=',$layer]
            ]
        )->first();
        if(!$data){
            return [];
        }

        return $data->toArray();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getTreeData($id)
    {
        $mine = self::where('id',$id)->first();
        if(!$mine){
            return [];
        }
        $left = $mine->left;
        $right = $mine->right;
        $children = self::whereBetween('left', [$left, $right])->orderBy('layer')->get();
        if(!$children){
            $data = [$mine->toArray()];
        }else {
            $data = $children->toArray();
        }

        self::makeTeeData($data,$tree);
        return current($tree);
    }

    private static function makeTeeData(&$array, &$branch = [])
    {
        if(empty($array)){
            return;
        }

        if (empty($branch)) {
            $item = array_shift($array);
            $item['children'] = [];
            $branch[] = $item;
            if (!empty($array)) {
                self::makeTeeData($array,$branch);
            }
            return;
        }

        foreach ($branch as $k=>&$b) {
            $b['children'] = [];
            $shoot = [];
            foreach ($array as $key => $value) {
                if (($b['layer'] + 1) == $value['layer'] && $b['left'] < $value['left'] && $b['right'] > $value['left']) {
                    $value['children'] = [];
                    $shoot[$value['id']] = $value;
                    unset($array[$key]);
                }
            }

            if (!empty($array) && !empty($shoot)) {
                self::makeTeeData($array,$shoot);
                $b['children'] = $shoot;
            }elseif (empty($array) && !empty($shoot)){
                self::makeTeeData($array,$shoot);
                $b['children'] = $shoot;
            }
        }
    }
}