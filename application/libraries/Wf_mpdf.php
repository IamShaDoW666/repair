<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Mpdf;

class Wf_mpdf
{
    public function __construct() {
    }

    public function __get($var)
    {
        return get_instance()->controller->$var;
    }
  
    public function generate($content, $name = 'download.pdf', $output_type = null, $footer = null, $margin_bottom = null, $header = null, $margin_top = null, $orientation = 'P') {

        if (!$output_type) {
            $output_type = 'D';
        }
        if (!$margin_top) {
            $margin_top = 20;
        }

        $mpdf = new Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->SetTopMargin($margin_top);
        $mpdf->SetTitle($this->mSettings->title);
        $mpdf->SetAuthor($this->mSettings->title);
        $mpdf->SetCreator($this->mSettings->title);
        $mpdf->SetDisplayMode('fullpage');

        if (is_array($content)) {
            $mpdf->SetHeader($this->mSettings->title.'||{PAGENO}/{nbpg}', '', TRUE); // For simple text header
            $as = sizeof($content);
            $r = 1;
            foreach ($content as $page) {
                $mpdf->WriteHTML($page['content']);
                if (!empty($page['footer'])) {
                    $mpdf->SetHTMLFooter('<p class="text-center">' . $page['footer'] . '</p>', '', true);
                }
                if ($as != $r) {
                    $mpdf->AddPage();
                }
                $r++;
            }

        } else {

            $mpdf->WriteHTML($content);
            if ($header != '') {
                $mpdf->SetHTMLHeader('<p class="text-center">' . $header . '</p>', '', true);
            }
            if ($footer != '') {
                $mpdf->SetHTMLFooter('<p class="text-center">' . $footer . '</p>', '', true);
            }

        }

        if ($output_type == 'S') {
            $file_content = $mpdf->Output('', 'S');
            write_file('assets/uploads/' . $name, $file_content);
            return 'assets/uploads/' . $name;
        } else {
            $mpdf->Output($name, $output_type);
        }
    }

}
