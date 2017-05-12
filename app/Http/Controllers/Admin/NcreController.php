<?php

namespace App\Http\Controllers\Admin;

use App\Store\NcreStore;
use App\Tools\Avatar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\NoticeService as NoticeServer;
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
        $result = $this->read('xls', '成绩数据(140009).xls');
        for ($i = 2; $i < count($result); $i++) {
            settype($result[$i][5], "int");
            $result[$i][5] = (string)$result[$i][5];
            if (strlen($result[$i][5]) == 17) {
                $result[$i][5] = $result[$i][5] . 'X';
            }
            $res = self::$ncreStore->insertData([
                'csrq' => $result[$i][4],
                'zjh' => (string)$result[$i][5],
                'cj' => $result[$i][6],
                'dd' => $result[$i][7],
                'zsbh' => $result[$i][8],
                'file' => '140009',
                'addtime' => time()]);
        }
    }

    /**
     * 获取分页数据
     *
     * @return array
     * @author 郭庆
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $nowPage = isset($data["nowPage"]) ? (int)$data["nowPage"] : 1;//获取当前页
        $forPages = 5;//一页的数据条数
        $status = $data["status"];//通知状态：已发布 待审核 已下架
        $type = $data["type"];//获取通知类型

        $where = [];
        if ($status) {
            $where["status"] = $status;
        }
        if ($type != 'null') {
            $where["type"] = $type;
        }
        $result = self::$noticeServer->selectDatas($where, $nowPage, $forPages, "/notice/create");
        return response()->json($result);
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
