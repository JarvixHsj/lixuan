<?php
/**
 * Created by PhpStorm.
 * User: Jarvix
 * Date: 17/7/31
 * Time: 下午5:48
 */

namespace app\html\controller;

use think\Controller;
use service\LogService;
use think\Db;
use think\Url;

class Test extends Controller{


    public function index()
    {
//        require_once(dirname(dirname(__FILE__)).'/sql/123.xlsx');
//        var_dump(ROOT_PATH);die;
        require_once(ROOT_PATH.'vendor/PHPExcel.class.php');
        require_once(ROOT_PATH.'vendor/PHPExcel/IOFactory.php');
//        import("Org.Util.PHPExcel");
//        import("Org.Util.IOFactory");
        $inputFileName = ROOT_PATH.'sql/123.xlsx';
// Check prerequisites
        if (!file_exists($inputFileName)) {
            exit("not found {$inputFileName}.\n");
        }

        $PHPExcel = \PHPExcel_IOFactory::load($inputFileName);

         /**读取excel文件中的第一个工作表*/
         $currentSheet = $PHPExcel->getSheet(0);
         /**取得最大的列号*/
         $allColumn = $currentSheet->getHighestColumn();
         /**取得一共有多少行*/
         $allRow = $currentSheet->getHighestRow();
var_dump($allRow);
         //循环读取每个单元格的内容。注意行从1开始，列从A开始
         for($rowIndex=2;$rowIndex<=$allRow;$rowIndex++){
//             foreach()
             $colIndexA = 'A';
             $colIndexB = 'B';
             $colIndexC = 'C';
             $addrA = $colIndexA.$rowIndex; //防伪码
             $addrB = $colIndexB.$rowIndex; //密码
             $addrC = $colIndexC.$rowIndex; //二维码
             $cellA = $currentSheet->getCell($addrA)->getValue(); //防伪码
             $cellB = $currentSheet->getCell($addrB)->getValue();//密码
             $cellC = $currentSheet->getCell($addrC)->getValue();//二维码

             $sql = " INSERT INTO `lx_anti` (`qecode`, `code`, `passwd`, `query`, `user_id`, `agent_id`, `project_id`, `admin_id`, `status`)VALUES( $cellC, $cellA, $cellB, NULL, 0, 0, 0, 0, 1);";
             echo $sql ."<br />";
//             var_dump($cellA,$cellB,$cellC);die;
//             for($colIndex='A';$colIndex<=$allColumn;$colIndex++){
//                 $addr = $colIndex.$rowIndex;
//                 $cell = $currentSheet->getCell($addr)->getValue();
//                 if($cell instanceof PHPExcel_RichText)     //富文本转换字符串
//                     $cell = $cell->__toString();
//
//                 $sql = " INSERT INTO `lx_anti` (`qecode`, `code`, `passwd`, `query`, `user_id`, `agent_id`, `project_id`, `admin_id`, `status`)VALUES( '', '', '', NULL, 0, 0, 0, 0, 1);";
//                 echo $sql ."<br />";
//
//             }

         }
        die;




// 读取第一個工作表
        $sheet = $PHPExcel->getSheet(0);
// 取得总行数
        $highestRow = $sheet->getHighestRow();
// 取得总列数
        $highestColumm = $sheet->getHighestColumn();

//
        $map = [
            'A'=> '自定义字段',
            'B'=> '自定义字段',
            'C'=> '自定义字段',
            'D'=> '自定义字段',
            'E'=> '自定义字段',
            'F'=> '自定义字段',
            'G'=> '自定义字段'
        ];

// 循环读取每个单元格的数据
        $keywords = S('insert_keywords');
        if( !$keywords )
        {
            // 行数是以第1行开始
            for ($row = 1; $row <= $highestRow; $row++)
            {
                for ($column = 'A'; $column <= $highestColumm; $column++)
                {
                    // 列数是以A列开始
                    if($row == 1 ||  $column == 'H')
                    {
                        continue;
                    }
                    $value = $sheet->getCell($column.$row)->getValue();

                    // 富文本转换字符串
                    if($value instanceof \PHPExcel_RichText)
                    {
                        $value = $value->__toString();
                    }
                    $keywords[$row][$map[$column]] = trim($value);
                    // $encode = mb_detect_encoding($value, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
                    // echo $encode, PHP_EOL, mb_convert_encoding("$value", "big5", "UTF-8"), die;
                    // $dataset[$row][$map[$column]] = iconv('ASCII', 'UTF-8',$value);
                    // echo $column, $row, ":", $sheet->getCell($column.$row)->getValue(), PHP_EOL;
                }
            }

            // 将读取的excel数据保存，以便后续处理
            if( $keywords )
            {
                S('insert_keywords', $keywords, 86400);
            }
            // 处理 $keywords
            // code...
        }
    }

}