<?php
/**
 * Created by Atom.
 * User: maolin
 * Date: 2016/11/08
 * Time: 16:34
 */
 namespace App\Store;

 use Illuminate\Support\Facades\DB;

 class MatchStore
 {
     // 表名
     protected static $table = 'data_match';
     /**
      * 获取一条数据
      * @param array $where
      * @return {bool|array}
      * @author maolin
      */
     public function getOntData($where)
     {
        if(empty($where)) return false;
        return DB::table(self::$table)->where('guid',$where)->first();
     }
     /**
      * 添加一条数据
      * @param array $where
      * @return bool
      * @author maolin
      */
      public function addData($data)
      {
          if(empty($data)) return false;
          return DB::table(self::$table)->insert($data);
      }
      /**
       * 查询所有数据
       * @return mixed
       * @author maolin
       */
      public function getAllData()
      {
          return DB::table(self::$table)->get();
      }
      /**
       * 数据更新
       * @param array $where
       * @param array $data
       * @return bool
       * @author maolin
       */
      public function updateData($where,$data)
      {
          if(empty($where) || empty($data)) return false;
          return DB::table(self::$table)->where($where)->update($data);
      }
      /**
       * @param string
       * @return bool
       * @author maolin
       */
       public function deleteOne($id)
       {
           return DB::table(self::$table)->where('guid', '=', $id)->delete();
       }
 }
