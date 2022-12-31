<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *  ==============================================================================
 *  Author  : Usman Sher
 *  Email   : uskhan099@gmail.com
 *  Package : zend-barcode
 *  License : New BSD License
 *  ==============================================================================
 */
use Laminas\Barcode\Barcode;
class Wf_barcode
{
    public function __construct() {
    }

     public function __get($var)
    {
        return get_instance()->controller->$var;
    }

    public function generate($text, $bcs = 'code128', $height = 50, $drawText = true, $get_be = false, $re = false) {
        $check = $this->prepareForChecksum($text, $bcs);
        $barcodeOptions = ['text' =>  $check['text'], 'barHeight' => $height, 'drawText' => $drawText, 'withChecksum' => $check['checksum'], 'withChecksumInText' => $check['checksum']];


        $rendererOptions = ['imageType' => 'png', 'horizontalPosition' => 'center', 'verticalPosition' => 'middle'];

        $renderer = Barcode::factory(
            $bcs,
            'image',
            $barcodeOptions,
            $rendererOptions
        );

        $imageResource = $renderer->draw();
        ob_start();
        imagepng($imageResource);
        $imagedata = ob_get_contents();
        ob_end_clean();
        if ($get_be) {
            return ($imagedata);
        }
        return "<img src='data:image/png;base64,".base64_encode($imagedata)."' alt='{$text}' class='bcimg' />";
    }

    protected function prepareForChecksum($text, $bcs) {
        if ($bcs == 'code25' || $bcs == 'code39') {
            return ['text' => $text, 'checksum' => false];
        } elseif ($bcs == 'code128') {
            return ['text' => $text, 'checksum' => true];
        }
        return ['text' => substr($text, 0, -1), 'checksum' => true];
    }
}
