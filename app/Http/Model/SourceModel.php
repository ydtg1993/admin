<?php
/**
 * Created by PhpStorm.
 * User: ydtg1
 * Date: 2019/2/10
 * Time: 16:14
 */

namespace App\Http\Model;


class SourceModel extends BaseModel
{
    protected $table = 'source';


    public static function listWhere(array $where = [],$page = 1,$limit = 20,&$page_info,$order_by = 'id',$sort = 'ASC',$columns = ['*'])
    {
        $page-=$page;
        $start = $page * $limit;
        $total = self::where($where)->count();
        $total_page = ceil($total / $limit);
        $page_info = ['total'=>$total,'total_page'=>$total_page];

        $data = self::where($where)->offset($start)->limit($limit)->orderBy($order_by, $sort)->select($columns)->get();
        if($data){
            return $data->toArray();
        }

        return [];
    }
}