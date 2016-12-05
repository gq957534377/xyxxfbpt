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


class WebAdminService
{
    protected static $webAdminStore;
    function __construct(WebAdminStore $webAdminStore)
    {
        self::$webAdminStore = $webAdminStore;
    }

    /**
     * 管理页面文字信息
     * @param $data
     * @return array
     * @autnor 王通
     */
    public function saveWebText($data)
    {

        DB::beginTransaction();
        Try {
            foreach ($data as $key => $val) {
                $info = [];
                $info = ['name' => $key, 'value' => $val, 'add_time' => time()];
                $id = self::$webAdminStore->selectWebAdminId(['name' => $key]);
                if (!empty($id)) {
                    self::$webAdminStore->delWebAdmin($id->id);
                    self::$webAdminStore->saveWebAdmin($info);
                } else {
                    self::$webAdminStore->saveWebAdmin($info);
                }
            }
        } catch (Exception $e) {
            Log::info('更新网站头部，联系方式，或者备案内容出错' . $e->getMessage());
            DB::rollBack();
            return ['status'=>'400','msg'=>'更新失败'];;
        }
        DB::commit();
        return ['status'=>'400','msg'=>'更新成功'];


    }
}