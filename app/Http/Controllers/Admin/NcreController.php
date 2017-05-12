<?php

namespace App\Http\Controllers\Admin;

use App\Store\NcreStore;
use App\Tools\Avatar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\NoticeService as NoticeServer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NcreController extends Controller
{
    protected static $ncreStore;

    public function __construct(NcreStore $ncreStore)
    {
        self::$ncreStore = $ncreStore;
    }

    /**
     * 通知后台首页
     *
     * @return array
     * @author 郭庆
     */
    public function index()
    {

    }

    /**
     * 获取分页数据
     *
     * @return array
     * @author 郭庆
     */
    public function create(Request $request)
    {

    }

    /**
     * 向通知表插入数据
     *
     * @return array
     * @author 郭庆
     */
    public function store(Request $request)
    {

    }

    /**
     * 拿取一条通知信息详情
     *
     * @return array
     * @author 郭庆
     */
    public function show($id)
    {
        $result = $this->read('xls', '成绩数据(' . $id . ').xls');
        if (empty($result)) return view('errors.404');
        DB::beginTransaction();
        try {
            for ($i = 2; $i < count($result); $i++) {
                settype($result[$i][5], "int");
                $result[$i][5] = (string)$result[$i][5];
                if (strlen($result[$i][5]) == 17) {
                    $result[$i][5] = $result[$i][5] . 'X';
                }
                self::$ncreStore->insertData([
                    'csrq' => $result[$i][4],
                    'zjh' => (string)$result[$i][5],
                    'cj' => $result[$i][6],
                    'dd' => $result[$i][7],
                    'zsbh' => $result[$i][8],
                    'file' => '140009',
                    'addtime' => time()]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return view('errors.500');
        }
        DB::commit();
    }

    /**
     * 修改通知状态
     *
     * @return array
     * @author 郭庆
     */
    public function edit(Request $request, $id)
    {

    }

    /**
     * 更改通知信息内容
     *
     * @return array
     * @author 郭庆
     */
    public function update(Request $request, $id)
    {

    }

    /**
     *
     *
     * @return array
     * @author 郭庆
     */
    public function destroy($id)
    {

    }


    /**
     * 说明: 读文件
     *
     * @param $file_type
     * @param $filename
     * @param string $encode
     * @return array
     * @author 郭庆
     */
    public function read($file_type, $filename, $encode = 'utf-8')
    {
        $dir = dirname(__FILE__);
        include $dir . '/PHPExcel/Classes/PHPExcel.php';

        if ($file_type == "xlsx") {
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        } else {
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        }
        $objPHPExcel = new \PHPExcel();
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($filename);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        $excelData = array();
        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                if ($objWorksheet->getCellByColumnAndRow(0, $row)->getValue() === null) {
                    continue;
                }
                $excelData[$row][] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
        }
        return $excelData;
    }
}
