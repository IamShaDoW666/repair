<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <div class="modal-content">
    <div class="modal-header no-print">
        
        <h4 class="modal-title" id="myModalLabel"><?= $product->name; ?></h4>


        <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
            <i class="fa fa-print"></i> <?= lang('print'); ?>
        </button>

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <i class="fa fa-2x">&times;</i>
        </button>
    </div>
        <div class="modal-body">

            <div class="row">
                
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped dfTable table-right-left">
                            <tbody>
                                <tr>
                                    <td style="width:30%;"><?= lang("barcode_qrcode"); ?></td>
                                    <td style="width:70%;">
                                        <?= $this->repairer->barcode($product->code, 'code128', 66, false); ?>
                                        <?= $this->repairer->qrcode('link', urlencode(site_url('panel/products/view/' . $product->id)), 2); ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td><?= lang("type"); ?></td>
                                    <td><?= lang($product->type); ?></td>
                                </tr>
                                <tr>
                                    <td><?= lang("name"); ?></td>
                                    <td><?= $product->name; ?></td>
                                </tr>
                                <tr>
                                    <td><?= lang("code"); ?></td>
                                    <td><?= $product->code; ?></td>
                                </tr>
                                <tr>
                                    <td><?= lang("model"); ?></td>
                                    <td><?= $product->model_name; ?></td>
                                </tr>
                                
                                    <tr>
                                        <td><?= lang("unit"); ?></td>
                                        <td><?= $product->unit ?></td>
                                    </tr>
                                    <?php 
                                        echo '<tr><td>' . lang("cost") . '</td><td>' . $this->repairer->formatMoney($product->cost) . '</td></tr>';
                                        echo '<tr><td>' . lang("price") . '</td><td>' . $this->repairer->formatMoney($product->price) . '</td></tr>';
                                    ?>

                                    <?php if ($product->tax_rate) { ?>
                                    <tr>
                                        <td><?= lang("tax_rate"); ?></td>
                                        <td><?= $tax_rate->name; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= lang("tax_method"); ?></td>
                                        <td><?= $product->tax_method == 0 ? lang('inclusive') : lang('exclusive'); ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if ($product->alert_quantity != 0) { ?>
                                    <tr>
                                        <td><?= lang("alert_quantity"); ?></td>
                                        <td><?= $this->repairer->formatQuantity($product->alert_quantity); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>

                <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12">
                    <?= $product->details ? '<div class="card card-success"><div class="card-header">' . lang('product_details') . '</div><div class="card-body">' . $product->details . '</div></div>' : ''; ?>
                </div>
            </div>
            <div class="row">

            <div class="buttons no-print">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <a href="<?= site_url('panel/inventory/print_barcodes/' . $product->id) ?>" class="tip btn btn-primary" title="<?= lang('print_barcode_label') ?>">
                    <i class="fa fa-print"></i>
                    <span class="hidden-sm hidden-xs"><?= lang('print_barcode_label') ?></span>
                </a>
            </div>
            <div class="btn-group">
                <a href="<?= site_url('panel/inventory/edit/' . $product->id) ?>" class="tip btn btn-warning tip" title="<?= lang('edit_product') ?>">
                    <i class="fa fa-edit"></i>
                    <span class="hidden-sm hidden-xs"><?= lang('edit') ?></span>
                </a>
            </div>
            <div class="btn-group">
                <a href="#" class="tip btn btn-danger bpo" title="<b><?= lang("delete_product") ?></b>"
                    data-content="<div style='width:150px;'><p><?= lang('r_u_sure') ?></p><a class='btn btn-danger' href='<?= site_url('panel/inventory/delete/' . $product->id) ?>'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button></div>"
                    data-html="true" data-placement="top">
                    <i class="fa fa-trash-o"></i>
                    <span class="hidden-sm hidden-xs"><?= lang('delete') ?></span>
                </a>
            </div>
        </div>
    </div>
        </div>
    
    </div>
</div>
