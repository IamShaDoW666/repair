<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 *  ==============================================================================
 *  Author      : Usman Sher
 *  Email       : uskhan099@Gmail.com
 *  For         : Repairer
 *  Web         : http://otsglobal.org
 *  ==============================================================================
 */

class Repairer
{

    public function __construct()
    {
        
    }

    public function __get($var)
    {
        return get_instance()->controller->$var;
    }

    private function _rglobRead($source, &$array = array())
    {
        if (!$source || trim($source) == "") {
            $source = ".";
        }
        foreach ((array) glob($source . "/*/") as $key => $value) {
            $this->_rglobRead(str_replace("//", "/", $value), $array);
        }
        $hidden_files = glob($source . ".*") and $htaccess = preg_grep('/\.htaccess$/', $hidden_files);
        $files = array_merge(glob($source . "*.*"), $htaccess);
        foreach ($files as $key => $value) {
            $array[] = str_replace("//", "/", $value);
        }
    }

    private function _zip($array, $part, $destination, $output_name = 'sma')
    {
        $zip = new ZipArchive;
        @mkdir($destination, 0777, true);

        if ($zip->open(str_replace("//", "/", "{$destination}/{$output_name}" . ($part ? '_p' . $part : '') . ".zip"), ZipArchive::CREATE)) {
            foreach ((array) $array as $key => $value) {
                $zip->addFile($value, str_replace(array("../", "./"), null, $value));
            }
            $zip->close();
        }
    }

    public function formatMoney($number)
    {
        $decimals = $this->mSettings->decimals;
        $ts = ',';
        $ds = '.';
        return number_format($number, 2) . ($this->mSettings->currency);
    }

    public function formatQuantity($number, $decimals = '00')
    {
        if (!$decimals) {
            $decimals = $this->mSettings->qty_decimals;
        }
        return number_format($number, $decimals);
    }

    public function formatDecimal($number, $decimals = null)
    {
        $formatted = number_format($number, 2, '.', ',');
        return ($formatted);
    }


    public function formatDecimal2($number, $decimals = null)
    {
        $formatted = number_format($number, 2, '.', '');
        return ($formatted);
    }

    public function clear_tags($str)
    {
        return htmlentities(
            strip_tags($str,
                '<span><div><a><br><p><b><i><u><img><blockquote><small><ul><ol><li><hr><big><pre><code><strong><em><table><tr><td><th><tbody><thead><tfoot><h3><h4><h5><h6>'
            ),
            ENT_QUOTES | ENT_XHTML | ENT_HTML5,
            'UTF-8'
        );
    }

    public function decode_html($str)
    {
        return html_entity_decode($str, ENT_QUOTES | ENT_XHTML | ENT_HTML5, 'UTF-8');
    }

    public function roundMoney($num, $nearest = 0.05)
    {
        return round($num * (1 / $nearest)) * $nearest;
    }

    public function roundNumber($number, $toref = null)
    {
        switch ($toref) {
            case 1:
                $rn = round($number * 20) / 20;
                break;
            case 2:
                $rn = round($number * 2) / 2;
                break;
            case 3:
                $rn = round($number);
                break;
            case 4:
                $rn = ceil($number);
                break;
            default:
                $rn = $number;
        }
        return $rn;
    }

    public function unset_data($ud)
    {
        if ($this->session->userdata($ud)) {
            $this->session->unset_userdata($ud);
            return true;
        }
        return false;
    }
  public function hrsd($sdate)
    {
        if ($sdate) {
            return date($this->dateFormats['php_sdate'], strtotime($sdate));
        } else {
            return '0000-00-00';
        }
    }

    public function hrld($ldate)
    {
        if ($ldate) {
            return date($this->dateFormats['php_ldate'], strtotime($ldate));
        } else {
            return '0000-00-00 00:00:00';
        }
    }

    public function fsd($inv_date)
    {
        if ($inv_date) {
            $jsd = $this->dateFormats['js_sdate'];
            if ($jsd == 'DD-MM-YYYY' || $jsd == 'DD/MM/YYYY' || $jsd == 'DD.MM.YYYY') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 3, 2) . "-" . substr($inv_date, 0, 2);
            } elseif ($jsd == 'MM-DD-YYYY' || $jsd == 'MM/DD/YYYY' || $jsd == 'MM.DD.YYYY') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 0, 2) . "-" . substr($inv_date, 3, 2);
            } else {
                $date = $inv_date;
            }
            return $date;
        } else {
            return '0000-00-00';
        }
    }

    public function fld($ldate)
    {
        if ($ldate) {
            $date = explode(' ', $ldate);
            $jsd = $this->dateFormats['js_sdate'];
            $inv_date = $date[0];
            $time = $date[1];
            if ($jsd == 'DD-MM-YYYY' || $jsd == 'DD/MM/YYYY' || $jsd == 'DD.MM.YYYY') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 3, 2) . "-" . substr($inv_date, 0, 2) . " " . $time;
            } elseif ($jsd == 'MM-DD-YYYY' || $jsd == 'MM/DD/YYYY' || $jsd == 'MM.DD.YYYY') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 0, 2) . "-" . substr($inv_date, 3, 2) . " " . $time;
            } else {
                $date = $inv_date;
            }
            return $date;
        } else {
            return '0000-00-00 00:00:00';
        }
    }

    public function send_email($to, $subject, $message, $from = null, $from_name = null, $attachment = null, $cc = null, $bcc = null)
    {

        $result = false;
        $this->load->library('wf_mail');
        try {
            $result = $this->wf_mail->send_mail($to, $subject, $message, $from, $from_name, $attachment, $cc, $bcc);
        } catch (\Exception $e) {
            $this->session->set_flashdata('error', 'Mail Error: ' . $e->getMessage());
        }
        return $result;
    }
 
  
    public function imgto64($file_name){
        $bc = file_get_contents($file_name);
        $bcimage = base64_encode($bc);
        return $bcimage;
    }
  
    public function barcode($text = null, $bcs = 'code128', $height = 74, $stext = 1, $get_be = false, $re = false)
    {
        $drawText = ($stext != 1) ? false : true;
        $this->load->library('wf_barcode', '', 'bc');
        return $this->bc->generate($text, $bcs, $height, $drawText, $get_be, $re);
    }


    public function qrcode($type = 'text', $text = 'http://otsglobal.org', $size = 2, $level = 'H', $sq = null)
    {
        $file_name = 'assets/uploads/qrcode' . $this->session->userdata('user_id') . ($sq ? $sq : '') . ($this->mSettings->barcode_img ? '.png' : '.svg');
        if ($type == 'link') {
            $text = urldecode($text);
        }
        $this->load->library('wf_qrcode', '', 'qr');
        $config = array('data' => $text, 'size' => $size, 'level' => $level, 'savename' => $file_name);
        $this->qr->generate($config);
        $imagedata = file_get_contents($file_name);
        return "<img src='data:image/png;base64,".base64_encode($imagedata)."' alt='{$text}' class='qrimg' />";
    }
    
    public function generate_pdf($content, $name = 'download.pdf', $output_type = null, $footer = null, $margin_bottom = null, $header = null, $margin_top = null, $orientation = 'P')
    {

        $this->load->library('wf_mpdf', '', 'pdf');
        return $this->pdf->generate($content, $name, $output_type, $footer, $margin_bottom, $header, $margin_top, $orientation);
    }

    public function send_json($data)
    {
        header('Content-Type: application/json');
        die(json_encode($data));
        exit;
    }

    function slug($title, $type = NULL, $r = 1)
    {
        $this->load->helper('text');
        $slug = url_title(convert_accented_characters($title), '-', TRUE);
        $check_slug = $this->checkSlug($slug, $type);
        if (!empty($check_slug)) {
            $slug = $slug.$r; $r++;
            $this->slug($slug, $type, $r);
        }
        return $slug;
    }
    public function checkSlug($slug, $type = NULL) {
        return $this->db->get_where('categories', ['code' => $slug], 1)->row();
    }

    public function checkPermissions($action = null, $js = null, $module = null)
    {
        if (!$this->actionPermissions($action, $module)) {
            $this->session->set_flashdata('error', lang("access_denied_auth"));
            if ($js) {
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('panel')) . "'; }, 10);</script>");
            } else {
                redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'panel');
            }
        }
    }

    public function js_redirect($url = 'panel')
    {
        die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url($url) . "'; }, 10);</script>");
    }

    public function actionPermissions($action = null, $module = null)
    {

        if ($this->Admin) {
            return true;
        } else {
            if (!$module) {
                $module = $this->mCtrler;
            }
            if (!$action) {
                $action = $this->mAction;
            }

            if ($this->Admin || $this->GP[$module . '-' . $action] == 1) {
                return true;
            } else {
                return false;
            }
        }

    }
    public function in_group($check_group)
    {
        if ( !$this->ion_auth->logged_in() ) {
            return false;
        }
        if (($this->ion_auth->get_users_groups()->row()->name) === $check_group) {
            return true;
        }
        return false;
    }


    public function returnOpenRegisterSets()
    {
        return array(

            'n1000' => '100',

            'n500' => '50',

            'n200' => '20',

            'n100' => '10',

            'n50' => '5',

            'n20' => '1',

            'n10' => '0.25',

            'n5' => '0.10',

            'n2' => '0.05',

            'n1' => '0.01',

        );
    }



    
    function base30_to_jpeg($base30_string, $output_file) {
        require APPPATH.'libraries/jSignature.php';
        $data = str_replace('image/jsignature;base30,', '', $base30_string);
        $converter = new jSignature();
        $raw = $converter->Base64ToNative($data);
        //Calculate dimensions
        $width = 0;
        $height = 0;
        foreach($raw as $line) {
            if (max($line['x']) > $width) $width = max($line['x']);
            if (max($line['y']) > $height) $height = max($line['y']);
        }

        // Create an image
        $im = imagecreatetruecolor($width+20,$height+20);
        // Save transparency for PNG
        imagesavealpha($im, true);
        // Fill background with transparency
        $trans_colour = imagecolorallocatealpha($im, 255, 255, 255, 127);
        imagefill($im, 0, 0, $trans_colour);
        // Set pen thickness
        imagesetthickness($im, 2);
        // Set pen color to black
        $black = imagecolorallocate($im, 0, 0, 0);
        // Loop through array pairs from each signature word
        for ($i = 0; $i < count($raw); $i++)
        {
            // Loop through each pair in a word
            for ($j = 0; $j < count($raw[$i]['x']); $j++)
            {
                // Make sure we are not on the last coordinate in the array
                if ( ! isset($raw[$i]['x'][$j]))
                    break;
                if ( ! isset($raw[$i]['x'][$j+1]))
                // Draw the dot for the coordinate
                    imagesetpixel ( $im, $raw[$i]['x'][$j], $raw[$i]['y'][$j], $black);
                else
                // Draw the line for the coordinate pair
                imageline($im, $raw[$i]['x'][$j], $raw[$i]['y'][$j], $raw[$i]['x'][$j+1], $raw[$i]['y'][$j+1], $black);
            }
        }

        //Create Image
        $ifp = fopen($output_file, "wb");
        imagepng($im, $output_file);
        fclose($ifp);
        imagedestroy($im);
        return true;
    }






     public function getReference($field) {
        $q = $this->db->get_where('order_ref', array('ref_id' => '1'), 1);
        if ($q->num_rows() > 0) {
            $ref = $q->row();
            switch ($field) {
                case 'pos':
                    $prefix = isset($this->mSettings->sales_prefix) ? $this->mSettings->sales_prefix . '/POS/' : '';
                    break;
                case 'pay':
                    $prefix = $this->mSettings->payment_prefix;
                    break;
                case 're':
                    $prefix = $this->mSettings->return_prefix;
                    break;
                default:
                    $prefix = '';
            }

            $ref_no = (!empty($prefix)) ? $prefix . '/' : '';
            $format = $this->mSettings->reference_format;


            if ($this->mSettings->reference_format !== '') {
                $ref_no .= date('Y') . "/" . sprintf("%04s", $ref->{$field});
            } elseif ($this->mSettings->reference_format == 2) {
                $ref_no .= date('Y') . "/" . date('m') . "/" . sprintf("%04s", $ref->{$field});
            } elseif ($this->mSettings->reference_format == 3) {
                $ref_no .= sprintf("%04s", $ref->{$field});
            } else {
                $ref_no .= $this->getRandomReference();
            }
            
            return $ref_no;
        }
        return FALSE;
    }



    public function paid_opts($paid_by = null, $empty_opt = false)
    {
        $opts = '';
        if ($empty_opt) {
            $opts .= '<option value="">'.lang('select').'</option>';
        }
        $opts .= '
        <option value="cash"'.($paid_by && $paid_by == 'cash' ? ' selected="selected"' : '').'>'.lang("cash").'</option>
        <option value="CC"'.($paid_by && $paid_by == 'CC' ? ' selected="selected"' : '').'>'.lang("CC").'</option>
        <option value="Cheque"'.($paid_by && $paid_by == 'Cheque' ? ' selected="selected"' : '').'>'.lang("cheque").'</option>
        <option value="other"'.($paid_by && $paid_by == 'other' ? ' selected="selected"' : '').'>'.lang("other").'</option>';
        return $opts;
    }

    

    public function updateReference($field) {
        $q = $this->db->get_where('order_ref', array('ref_id' => '1'), 1);
        if ($q->num_rows() > 0) {
            $ref = $q->row();
            $this->db->update('order_ref', array($field => $ref->{$field} + 1), array('ref_id' => '1'));
            return TRUE;
        }
        return FALSE;
    }

     function base64url_encode($data, $pad = null) {
        $data = str_replace(array('+', '/'), array('-', '_'), base64_encode($data));
        if (!$pad) {
            $data = rtrim($data, '=');
        }
        return $data;
    }

    function base64url_decode($data) {
        return base64_decode(str_replace(array('-', '_'), array('+', '/'), $data));
    }
    
    public function getReferencesHear()
    {
        return array(
            'Facebook' => 'Facebook',
            'Google' => 'Google Search',
            'Friend' => 'From a Friend',
            'Other' => 'Other',
        );
    }
    
    public function md($page = false)
    {
        die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . ($page ? site_url($page) : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'welcome')) . "'; }, 10);</script>");
    }

    public function get_cal_lang()
    {
        switch ($this->mSettings->language) {
            case 'french':
                $cal_lang = 'fr';
                break;
            case 'german':
                $cal_lang = 'de';
                break;
            case 'italian':
                $cal_lang = 'it';
                break;
            case 'dutch':
                $cal_lang = 'nl';
                break;
            case 'bulgarian':
                $cal_lang = 'bg';
                break;
            case 'russian':
                $cal_lang = 'ru';
                break;
            case 'turkish':
                $cal_lang = 'tr-TR';
                break;
            default:
                $cal_lang = 'en';
                break;
        }
        return $cal_lang;
    }


    
    public function calculateDiscount($discount = null, $amount = 0, $order = null)
    {
        if ($discount && ($order || $this->mSettings->product_discount)) {
            $dpos = strpos($discount, '%');
            if ($dpos !== false) {
                $pds = explode('%', $discount);
                return $this->formatDecimal(((($this->formatDecimal($amount)) * (float) ($pds[0])) / 100), 4);
            }
            return $this->formatDecimal($discount, 4);
        }
        return 0;
    }

    public function calculateOrderTax($order_tax_id = null, $amount = 0)
    {
        if ($this->mSettings->tax2 != 0 && $order_tax_id) {
            if ($order_tax_details = $this->site->getTaxRateByID($order_tax_id)) {
                if ($order_tax_details->type == 1) {
                    return $this->formatDecimal((($amount * $order_tax_details->rate) / 100), 4);
                }
                return $this->formatDecimal($order_tax_details->rate, 4);
            }
        }
        return 0;
    }
}
