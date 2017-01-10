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
class CommentStore{
    // 表名
    protected static $table = 'data_comment_info';

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
    public static function getSomeData($where, $limit = 10)
    {
        return DB::table(self::$table)
            ->where($where)
            ->orderBy('changetime', 'desc')
            ->limit($limit)
            ->get();
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
     * 获取指定页码与指定字段的数据
     * @param int $nowPage
     * @param array $where
     * @param string $field
     * @return mixed
     * author 张洵之
     */
    public function getPageLists($nowPage,$where,$field)
    {
        return DB::table(self::$table)
            ->where($where)
            ->forPage($nowPage, PAGENUM)
            ->orderBy('time','desc')
            ->lists($field);
    }

    /**
     * 得到该用户最近插入的一条数据
     * @param $action_id
     * @param $user_id
     * @return mixed
     * @author 王通
     */
    public function getCommentTime ($action_id, $user_id)
    {
        return DB::table(self::$table)
            ->where('action_id', $action_id)
            ->where('user_id', $user_id)
            ->orderBy('changetime', 'desc')
            ->limit(1)
            ->get();
    }

    /**
     * 统计数量
     * @param array $where
     * @return mixed
     * author 张洵之
     */
    public function getCount($where)
    {
        return DB::table(self::$table)->where($where)->count();
    }
}

