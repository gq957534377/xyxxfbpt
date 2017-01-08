<?php
/**
 * Created by PhpStorm.
 * User: wangtong
 * Date: 2016/12/5
 * Time: 16:57
 */

namespace App\Services;

use App\Store\WebAdminStore;
use Illuminate\Contracts\Logging\Log;
use DB;
use App\Tools\Avatar;
use App\Redis\WebAdminCache;



class WebAdminService
{
    protected static $webAdminStore;
    protected static $webAdminCache;
    function __construct(WebAdminStore $webAdminStore, WebAdminCache $webAdminCache)
    {
        self::$webAdminStore = $webAdminStore;
        self::$webAdminCache = $webAdminCache;
    }


    /**
     * 得到所有的配置表数据
     * @return array
     * @author 王通
     */
    public function getAllWebConf ()
    {
        // 初始化数组
        $arr = [];

        // 获取所有未删除数据
        $obj = self::$webAdminStore->getConfig();
        // 验证是否正确取出数据
        if (empty($obj)) {
            return ['StatusCode'=>'201','ResultData'=>[]];
        }
        // 把取到的数据，格式化成['name' => 'value'] 格式 并且返回
        foreach ($obj as $val) {
            $arr[$val->type] = $val->value;
        }
        return ['StatusCode'=>'200','ResultData'=>$arr];
    }


    /**
     * 更新WebAdmin 配置表
     * @param $data
     * @return array
     * $author 王通
     */
    public function saveWebAdmin ($data)
    {
        // 开始事务
        DB::beginTransaction();
        Try {

            // 循环指定数据，写入数据库 （ps:因最多为四条，并且需要判断传过来具体数据，暂用循环。）
            foreach ($data as $key => $val) {
                switch ($key)
                {
                    case 'email':
                        $info = ['type' => 1, 'value' => $val, 'add_time' => time()];
                        $id = self::$webAdminStore->selectWebAdminId(['type' => 1]);
                        break;
                    case 'time':
                        $info = ['type' => 2, 'value' => $val, 'add_time' => time()];
                        $id = self::$webAdminStore->selectWebAdminId(['type' => 2]);
                        break;
                    case 'tel':
                        $info = ['type' => 3, 'value' => $val, 'add_time' => time()];
                        $id = self::$webAdminStore->selectWebAdminId(['type' => 3]);
                        break;
                    case 'record':
                        $info = ['type' => 4, 'value' => $val, 'add_time' => time()];
                        $id = self::$webAdminStore->selectWebAdminId(['type' => 4]);
                        break;
                }
                // 判断是否有指定类型的数据，如果没有则直接插入，有则删除之后再插入

                if (!empty($id)) {
                    self::$webAdminStore->delWebAdmin($id->id);
                    // 删除redis 哈希
                    self::$webAdminCache->delHash($id->id);
                    self::$webAdminStore->saveWebAdmin($info);
                } else {
                    self::$webAdminStore->saveWebAdmin($info);
                }
            }
            self::$webAdminCache->delList();
        } catch (Exception $e) {

            // 日志
            Log::info('更新网站头部，联系方式，或者备案内容出错' . $e->getMessage());

            // 回滚事务
            DB::rollBack();
            return ['status'=>'400','msg'=>'更新失败'];
        }

        // 提交事务
        DB::commit();
        return ['status'=>'200','msg'=>'更新成功'];
    }

    /**
     * 图片上传到七牛
     * @param $request
     * @return array|\Illuminate\Http\JsonResponse
     * @author 王通
     */
    public function uploadImg ($request, $field)
    {
        //上传
        $info = Avatar::avatar($request);

        // 文件上传判断
        if ($info['status'] == '400') {
            return['status' => '400','msg' => '文件上传失败!'];
        } else {

            // 管理页面logo信息
            $res = $this->saveWebAdmin([$field => $info['msg']]);
            if ($res['status'] == '400') {
                return ['status'=>'400','msg'=>'更新失败'];
            }

            // 验证通过返回数据
            return ['status' => '200','msg' => $info['msg']];
        }
    }

    /**
     * 得到页面基本信息
     * @return array
     * @author 王通
     */
    public function getWebInfo ()
    {
        if (empty(self::$webAdminCache->checkList())) {
            $obj = self::$webAdminStore->getWebInfo();
            self::$webAdminCache->saveRedisList($obj);
        } else {
            $obj = self::$webAdminCache->selRedisInfo();
        }
        if (!empty($obj)) {
            return ['StatusCode' => '200', 'ResultData' => $obj];
        } else {
            return ['StatusCode' => '400', 'ResultData' => '查询失败'];
        }
    }
}