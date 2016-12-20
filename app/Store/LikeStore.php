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
class LikeStore{
    // 表名
    protected static $table = 'data_like_info';

    /**
     * 查询一条数据
     * @param array $where
     * @return one data
     * @ author 郭庆
     */
    public function getOneData($where)
    {
        return DB::table(self::$table)->where($where)->first();
    }

    /**获取指定页码的数据
     * @页码
     * @return object|false
     * @author 郭庆
     */
    public function getPageData($nowPage,$where)
    {
        return DB::table(self::$table)
            ->where($where)
            ->forPage($nowPage, PAGENUM)
            ->orderBy('changetime','desc')
            ->get();
    }

    /**
     * 查询指定条件所有数据
     * @return mixed
     * @author 郭庆
     */
    public static function getSomeData($where)
    {
        return DB::table(self::$table)->where($where)->get();
    }
    /**
     * 查询所有数据
     * @return mixed
     * @author 郭庆
     */
    public function getAllData()
    {
        // 返回指定表中说有数据
        return DB::table(self::$table)->get();
    }

    /**
     * 添加记录到数据
     * @param array $data
     * @return bool
     * @author 郭庆
     */
    public function addData($data)
    {
        return DB::table(self::$table)->insert($data);
    }

    /**
     * 更新记录到数据库
     * @param array $where
     * @param array $data
     * @return bool
     * @author 郭庆
     */
    public function updateData($where,$data)
    {
        return DB::table(self::$table)->where($where)->update($data);
    }
    /**
     * 给某个字段自增data
     * @author 郭庆
     */
    public static function incrementData($where,$field,$data)
    {
        return DB::table(self::$table)->where($where)->increment($field,$data);
    }

    /**
     * 获取支持数量
     */
    public static function getSupportNum($action_id)
    {
        return DB::table(self::$table)->where(['action_id' => $action_id, 'support' => 1])->count();
    }

    /**
     * 获取不支持数量
     */
    public static function getNoSupportNum($action_id)
    {
        return DB::table(self::$table)->where(['action_id' => $action_id , 'support' => 2])->count();
    }

    /**
     * 返回某字段信息
     * @param array $where  查询条件
     * @param string $field 字段名
     * @return mixed
     * author 张洵之
     */
    public function getLikeStatus($where, $field)
    {
        return DB::table(self::$table)->where($where)->lists($field);
    }
}

