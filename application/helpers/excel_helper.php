<?php defined('BASEPATH') OR exit('No direct script access allowed');
        $this->load->library('excel');

if(! function_exists('create_excel')) {
    function create_excel($excel, $filename) {
        $filename = 'categories_' . date('Y_m_d_H_i_s');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        return $objWriter->save('php://output');
    }
}
