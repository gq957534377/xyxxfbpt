<?php
/**
 * Created by PhpStorm.
 * User: 郭庆
 * Date: 2016/11/08
 * Time: 16:34
 */
namespace App\Store;

use Illuminate\Support\Facades\DB;

/**
 * Class roadStore
 * 后台数据处理仓库层
 *
 * @package App\Store
 */
class ActionOrderStore{
    // 表名
    protected static $table = 'rel_action_order';

    /**
     * 插入数据
     * @param $data
     * @return null
     * author 杨志宇
     */
    public function insertData($data)
    {
        if(!is_array($data)) return false;
        return $result = DB::table(self::$table)->insertGetId($data);
    }

    /**
     * 添加记录到数据
     * @param array $data
     * @return bool
     * @author 郭庆
     */
    public function addData($data)
    {
        if (empty($data)) return false;
        return DB::table(self::$table)->insert($data);
    }
    /**
     * 获取符合条件的某一个字段的集合
     * @param
     * @return array
     * @author 郭庆
     */
    public static function getSomeField($where, $field)
    {
        return DB::table(self::$table)->where($where)->lists($field);
    }

    /**
     * 得到指定状态的数量
     * @param $where
     * @return mixed
     * @author 郭庆
     */
    public function getCount($where)
    {
        return DB::table(self::$table)->where($where)->count();
    }

















    //无用方法------------------------------------------------------------------------------------------------------

    /**
     * 分页查询数据
     * @param $page
     * @param $tolPage
     * @param $where
     * @return null
     * author 杨志宇
     */
    public function forPage($page, $tolPage, $where)
    {
        if (!is_int($page) || !is_int($tolPage) || !is_array($where)) return false;
        return DB::table(self::$table)
            ->where($where)
            ->orderBy("addtime","desc")
            ->forPage($page,$tolPage)
            ->get();
    }

    /**
     * 更新记录到数据库
     * @param array $where
     * @param array $data
     * @return bool
     * @author 郭庆
     */
    public function updateData($where, $data)
    {
        if(empty($where) || empty($data)) return false;
        return DB::table(self::$table)->where($where)->update($data);
    }


}

