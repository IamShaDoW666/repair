<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="<?= $assets ?>dist/css/custom/barcode_print.css">

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
         <h3 class="card-title"><i class="fa-fw fa fa-plus"></i><?= lang('print_barcode'); ?></h3><br>
            <small><?php echo sprintf(lang('print_barcode_heading'), 
                anchor('panel/purchases', lang('purchases_label')),
                anchor('panel/inventory', lang('inventory_label'))); ?></small>
         
        </div>
      <div class="card-body">
         <div class="row">
            <div class="col-lg-12">
                
                <div class="well well-sm no-print">
                    <div class="form-group">
                        <label><?= lang('add_product'); ?></label>
                        <?php echo form_input('add_barcode_item', '', 'class="form-control" id="add_barcode_item" placeholder="' . $this->lang->line("add_barcode_item") . '"'); ?>
                    </div>
                    <?= form_open("panel/inventory/print_barcodes", 'id="barcode-print-form" data-toggle="validator"'); ?>
                    <div class="controls table-controls">
                        <table id="bcTable"
                               class="table items table-striped table-bordered table-condensed table-hover">
                            <thead>
                            <tr>
                                <th class="col-xs-8"><?= lang('product_name'); ?> (<?= lang('product_code'); ?>)</th>
                                <th class="col-xs-3"><?= lang('quantity'); ?></th>
                                <th class="col-xs-1 text-center" style="width:30px;">
                                    <i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                </th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                        <div class="form-group">
                            <label><?= lang('style');?></label>
                           <?php $opts = array('' => lang('select').' '.lang('style'), 40 => lang('40_per_sheet'), 30 => lang('30_per_sheet'), 24 => lang('24_per_sheet'), 20 => lang('20_per_sheet'), 18 => lang('18_per_sheet'), 14 => lang('14_per_sheet'), 12 => lang('12_per_sheet'), 10 => lang('10_per_sheet'), 50 => lang('continuous_feed')); ?>
                            <?= form_dropdown('style', $opts, set_value('style', 50), 'class="form-control tip" id="style" required="required"'); ?>
                            <div class="row cf-con" style="margin-top: 10px;">
                                <div class="col-xs-4 ml-2">
                                    <div class="form-group">
                                         <div class="input-group">
                                           <?= form_input('cf_width', '1.6', 'class="form-control" id="cf_width" placeholder="' . lang("width") . '"'); ?>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <?= lang('inches'); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">

                                        <div class="input-group">

                                            <?= form_input('cf_height', '0.8', 'class="form-control" id="cf_height" placeholder="' . lang("height") . '"'); ?>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <?= lang('inches'); ?>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                    <?php $oopts = array(0 => lang('portrait'), 1 => lang('landscape')); ?>
                                        <?= form_dropdown('cf_orientation', $oopts , '', 'class="form-control" id="cf_orientation" placeholder="' . lang("orientation") . '"'); ?>
                                    </div>
                                </div>
                            </div>
                            <span class="help-block"><?= lang('barcode_tip'); ?></span>
                            <span class="aflinks pull-right">
                                <a href="https://www.a4labels.com" target="_blank">A4Lables.com</a> |
                                <a href="https://www.a4labels.com/products/white-self-adhesive-printer-labels-63-5-x-72mm/23585" target="_blank">12 per sheet</a> |
                                <a href="https://www.a4labels.com/products/white-self-adhesive-printer-labels-63-x-47mm/23586" target="_blank">18 per sheet</a> |
                                <a href="https://www.a4labels.com/products/white-self-adhesive-printer-labels-63-x-34mm/23588" target="_blank">24 per sheet</a> |
                                <a href="https://www.a4labels.com/products/white-self-adhesive-printer-labels-46-x-25mm/23587" target="_blank">40 per sheet</a>
                            </span>
                            <div class="clearfix"></div>
                        </div>
                         <div class="form-group">
                            <span style="font-weight: bold; margin-right: 15px;"><?= lang('print'); ?>:</span>
                            <input name="site_name" type="checkbox" id="site_name" value="1" style="display:inline-block;" />
                            <label for="site_name" class="padding05"><?= lang('site_name'); ?></label>
                            <input name="product_name" type="checkbox" id="product_name" value="1" checked="checked" style="display:inline-block;" />
                            <label for="product_name" class="padding05"><?= lang('product_name'); ?></label>
                            <input name="price" type="checkbox" id="price" value="1" checked="checked" style="display:inline-block;" />
                            <label for="price" class="padding05"><?= lang('price'); ?></label>
                        </div>


                    <div class="form-group">
                        <?php echo form_submit('print', lang('update'), 'class="btn btn-primary"'); ?>
                        <button type="button" id="reset" class="btn btn-danger"><?= lang('reset'); ?></button>
                    </div>
                    <?= form_close(); ?>
                    <div class="clearfix"></div>
                </div>
                <div id="barcode-con">
                    <?php
                        if ($this->input->post('print')) {
                            if (!empty($barcodes)) {
                                echo '<button type="button" onclick="customPrint();" class="btn btn-primary btn-block no-print"><i class="icon fa fa-print"></i> '.'Print'.'</button>';
                                $c = 1;
                                    echo '<div id="page">';

                                if ($style == 12 || $style == 18 || $style == 24 || $style == 40) {
                                    echo '<div class="barcodea4">';
                                } elseif ($style != 50) {
                                    echo '<div class="barcode">';
                                }
                                foreach ($barcodes as $item) {
                                    for ($r = 1; $r <= $item['quantity']; $r++) {
                                        echo '<div class="item style'.$style.'" '.
                                        ($style == 50 && $this->input->post('cf_width') && $this->input->post('cf_height') ?
                                            'style="width:'.$this->input->post('cf_width').'in;height:'.$this->input->post('cf_height').'in;border:0;"' : '')
                                        .'>';
                                        if ($style == 50) {
                                            if ($this->input->post('cf_orientation')) {
                                                $ty = (($this->input->post('cf_height')/$this->input->post('cf_width'))*100).'%';
                                                $landscape = '
                                                -webkit-transform-origin: 0 0;
                                                -moz-transform-origin:    0 0;
                                                -ms-transform-origin:     0 0;
                                                transform-origin:         0 0;
                                                -webkit-transform: translateY('.$ty.') rotate(-90deg);
                                                -moz-transform:    translateY('.$ty.') rotate(-90deg);
                                                -ms-transform:     translateY('.$ty.') rotate(-90deg);
                                                transform:         translateY('.$ty.') rotate(-90deg);
                                                ';
                                                echo '<div class="div50" style="width:'.$this->input->post('cf_height').'in;height:'.$this->input->post('cf_width').'in;border: 1px dotted #CCC;'.$landscape.'">';
                                            } else {
                                                echo '<div class="div50" style="width:'.$this->input->post('cf_width').'in;height:'.$this->input->post('cf_height').'in;border: 1px dotted #CCC;padding-top:0.025in;">';
                                            }
                                        }
                                        
                                        if($item['site']) {
                                            echo '<span style="font-size:11px" class="barcode_site">'.$item['site'].'</span>';
                                        }
                                        if($item['name']) {
                                            echo '<span style="font-size:11px" class="barcode_name">'.$item['name'].'</span>';
                                        }
                                        if($item['price']) {
                                            echo '<span style="font-size:11px" class="barcode_price">'.lang('price').': ';
                                            echo $settings->currency. " " .$this->repairer->formatDecimal($item['price']);
                                            echo '</span> ';
                                        }

                                        echo '<span class="barcode_image"><img src="'.base_url('panel/misc/barcode/'.$item['barcode'].'/'.'code128'.'/'. 30).'" alt="'.$item['barcode'].'" class="bcimg" style="width:60%" /></span>';
                                        

                                        if ($style == 50) {
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                        if ($style == 40) {
                                            if ($c % 40 == 0) {
                                                echo '</div><div class="clearfix"></div><div class="barcodea4">';
                                            }
                                        } elseif ($style == 30) {
                                            if ($c % 30 == 0) {
                                                echo '</div><div class="clearfix"></div><div class="barcode">';
                                            }
                                        } elseif ($style == 24) {
                                            if ($c % 24 == 0) {
                                                echo '</div><div class="clearfix"></div><div class="barcodea4">';
                                            }
                                        } elseif ($style == 20) {
                                            if ($c % 20 == 0) {
                                                echo '</div><div class="clearfix"></div><div class="barcode">';
                                            }
                                        } elseif ($style == 18) {
                                            if ($c % 18 == 0) {
                                                echo '</div><div class="clearfix"></div><div class="barcodea4">';
                                            }
                                        } elseif ($style == 14) {
                                            if ($c % 14 == 0) {
                                                echo '</div><div class="clearfix"></div><div class="barcode">';
                                            }
                                        } elseif ($style == 12) {
                                            if ($c % 12 == 0) {
                                                echo '</div><div class="clearfix"></div><div class="barcodea4">';
                                            }
                                        } elseif ($style == 10) {
                                            if ($c % 10 == 0) {
                                                echo '</div><div class="clearfix"></div><div class="barcode">';
                                            }
                                        }
                                        $c++;
                                    }
                                }
                                if ($style != 50) {
                                    echo '</div>';
                                }
                                    echo '</div>';

                                echo '<button type="button" onclick="customPrint();" class="btn btn-primary btn-block tip no-print" title="'.lang('print_label').'"><i class="icon fa fa-print"></i> '.lang('print_label').'</button>';
                            } else {
                                echo '<h3>'.lang('no_product_selected').'</h3>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
<input type="hidden" id="print_items" value="<?=htmlspecialchars(json_encode($items));?>"/>
<script src="<?=base_url();?>panel/misc/js/reparation_print_barcodes"></script>
