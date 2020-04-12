<?php


namespace App\Helpers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;

class ExcelUnload
{
    /**
     * Выгрузим все элементы массива в эксель файл
     * @param $elements
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws Exception
     */
    public static function arrayToExcel(array $elements)
    {
        $keys = array_keys($elements[0]);

        $alphabet = range('A', 'Z');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($keys as $key_id => $key) {
            $sheet->setCellValue($alphabet[$key_id] . '1', $key);
        }

        foreach ($elements as $element_id => $element) {
            $row_id = $element_id + 2;
            $i = 0;
            foreach ($element as $value_id => $value) {
                $column_id = $alphabet[$i++];
                $sheet->setCellValue($column_id . $row_id, $value);
            }
        }

        $filename = 'bookmarks_' . date('Y-m-d') . '.xlsx';
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename={$filename}");
        $writer->save("php://output");
    }
}
