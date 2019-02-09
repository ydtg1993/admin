<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10 0010
 * Time: 下午 3:11
 */

namespace App\Http\Controllers;
use DenDroGram\Controller\DenDroGram;
use DenDroGram\Controller\NestedSet;

/**
 * 系统树图
 * Class Category
 * @package App\Http\Controllers
 */
class Classify extends Controller
{
    /**
     * 根茎状结构
     */
    public function rhizome()
    {
        config(['dendrogram.form_action'=>url('operateRhizome')]);
        self::$data['tree_view'] = (new DenDroGram(NestedSet::class))->buildTree(1);
        return view('tree/rhizome',self::$data);
    }

    /**
     * 根茎结构树 节点操作方法
     */
    public function operateRhizome()
    {
        $action = self::$REQUEST->input('action');
        $data = self::$REQUEST->input('data');
        (new DenDroGram(NestedSet::class))->operateNode($action,$data);
    }
}