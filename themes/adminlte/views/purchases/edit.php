<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>




<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header">
              <h3 class="card-title"><i class="fa-fw fa fa-edit"></i><?= lang('edit_purchase'); ?></h3>
          </div>
      <!-- /.card-header -->
      <div class="card-body">

          <div class="col-lg-12">

                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-po-form');
                echo form_open_multipart("panel/purchases/edit/" . $inv->id, $attrib)
                ?>


                <div class="row">

                        <div class="col-md-4">
                                        <div class="form-group">
                                            <?= lang('date', 'podate'); ?>

                                             <div class="input-group" id="podate" data-target-input="nearest">
                                                 <div class="input-group-append" data-target="#podate" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                

                                                <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : $this->repairer->fld($purchase->date)), 'class="form-control datetimepicker-input" data-target="#podate" required="required"'); ?>


                                            </div>


                                            
                                        </div>
                                    </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("reference_no", "poref"); ?>
                                <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $purchase->reference_no), 'class="form-control input-tip" id="poref" required="required"'); ?>
                            </div>
                        </div>
                       
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("status", "postatus"); ?>
                                <?php
                                $post = array('received' => lang('received'), 'pending' => lang('pending'), 'ordered' => lang('ordered'));
                                echo form_dropdown('status', $post, (isset($_POST['status']) ? $_POST['status'] : $purchase->status), 'id="postatus" class="form-control input-tip select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("status") . '" required="required" style="width:100%;" ');
                                ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("document", "document") ?>
                                <input id="document" type="file"  data-language="mylang" data-browse-label="<?= lang('browse'); ?>" name="document" data-show-upload="false"
                                       data-show-preview="false" class="form-control file">
                            </div>
                        </div>

                           <div class="col-md-12">
                                    <div class="card card-warning">
                                        <div  class="card-header"><?= lang('please_select_these_before_adding_product'); ?></div>
                                        <div class="card-body" style="padding: 5px;">
                                            <div class="col-md-4">
                                                <div class="form-group">

                                                    <?= lang('supplier', 'posupplier'); ?>
                                                    <select class="form-control" name="posupplier" id="posupplier">
                                                    </select>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="col-md-12" id="sticker">
                                    <div class="well well-sm">
                                        <div class="form-group" style="margin-bottom:0;">

                                             <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                    <i class="fa  fa-barcode addIcon"></i></span>
                                                  </div>

                                                <?php echo form_input('add_purchase_item', '', 'class="form-control input-lg" id="add_purchase_item" placeholder="' . lang('add_product') . '"'); ?>
                                                
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                       <div class="col-md-12">
                            <div class="control-group table-group">
                                <label class="table-label"><?= lang('order_items'); ?></label>

                                <div class="controls table-controls">
                                    <table id="poTable"
                                           class="table items table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th class="col-md-4"><?= lang('product_name'); ?>(<?= lang('product_code'); ?>)</th>
                                            <th class="col-md-1"><?= lang('unit_cost'); ?></th>
                                            <th class="col-md-1"><?= lang('quantity'); ?></th>
                                            <?php if($settings->product_discount == 1): ?>
                                            <th class="col-md-1"><?= lang('discount'); ?></th>
                                            <?php endif; ?>
                                            <?php if($settings->tax1 == 1): ?>
                                            <th class="col-md-1"><?= lang('tax'); ?></th>
                                            <?php endif; ?>
                                            <th><?= lang("subtotal"); ?> (<span class="currency"><?= $settings->currency ?></span>)
                                            </th>
                                            <th style="width: 30px !important; text-align: center;"><i
                                                    class="fa fa-trash-o"
                                                    style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <input type="hidden" name="total_items" value="" id="total_items" required="required"/>

                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="checkbox" class="checkbox" id="extras" value=""/>
                                <label for="extras" class="padding05"><?= lang('more_options'); ?></label>
                            </div>
                            <div class="row" id="extras-con" style="display: none;">
                                <?php if ($settings->tax1) { ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?= lang('order_tax', 'potax2'); ?>
                                            <select name="order_tax" id="potax2" class="form-control input-tip select" style="width:100%;">
                                                <?php foreach ($tax_rates as $tax): ?>
                                                    <option value="<?= $tax->id; ?>" <?php if($tax->id == $inv->order_tax_id){echo "selected";}?>><?= $tax->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('discount', 'podiscount'); ?>
                                        <?php echo form_input('discount', '', 'class="form-control input-tip" id="podiscount"'); ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('shipping', 'poshipping'); ?>
                                        <?php echo form_input('shipping', '', 'class="form-control input-tip" id="poshipping"'); ?>
                                    </div>
                                </div>

                                
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <?= lang('note', 'ponote');?>
                                <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="ponote" style="margin-top: 10px; height: 100px;"'); ?>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div
                                class="from-group"><?php echo form_submit('edit_pruchase', lang('submit'), 'id="edit_pruchase" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset"><?= lang('reset'); ?></button>
                            </div>
                        </div>
                    </div>
                   <div id="bottom-total" class="well well-sm" style="margin-bottom: 0;">
                        <table class="table table-bordered table-condensed totals" style="margin-bottom:0;">
                            <tr class="warning">
                                <td><?= lang('items') ?> <span class="totals_val pull-right" id="titems">0</span></td>
                                <td><?= lang('total') ?> <span class="totals_val pull-right" id="total">0.00</span></td>
                                <td><?= lang('order_discount') ?> <span class="totals_val pull-right" id="tds">0.00</span></td>
                                <?php if ($settings->tax2) { ?>
                                    <td><?= lang('order_tax') ?> <span class="totals_val pull-right" id="ttax2">0.00</span></td>
                                <?php } ?>
                                <td><?= lang('shipping') ?> <span class="totals_val pull-right" id="tship">0.00</span></td>
                                <td><?= lang('grand_total') ?> <span class="totals_val pull-right" id="gtotal_purchase">0.00</span></td>
                            </tr>
                        </table>
                    </div>

                <?php echo form_close(); ?>

            </div>

            
      </div>
  </div>
</div>

<div class="modal" id="prModal" tabindex="-1" role="dialog" aria-labelledby="prModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="prModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?= lang('product_tax') ?></label>
                            <div class="col-sm-8">
                                <?php
                                $tr[""] = "";
                                foreach ($tax_rates as $tax) {
                                    $tr[$tax['id']] = $tax['name'];
                                }
                                echo form_dropdown('ptax', $tr, "", 'id="ptax" class="form-control pos-input-tip" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                    <div class="form-group">
                        <label for="pquantity" class="col-sm-4 control-label"><?= lang('quantity') ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pquantity">
                        </div>
                    </div>
                        

                        <div class="form-group">
                            <label for="pdiscount" class="col-sm-4 control-label"><?= lang('product_discount') ?></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pdiscount">
                            </div>
                        </div>
                    <div class="form-group">
                        <label for="pcost" class="col-sm-4 control-label"><?= lang('unit_cost') ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pcost">
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width:25%;"><?= lang('net_unit_cost'); ?></th>
                            <th style="width:25%;"><span id="net_cost"></span></th>
                            <th style="width:25%;"><?= lang('product_tax'); ?></th>
                            <th style="width:25%;"><span id="pro_tax"></span></th>
                        </tr>
                    </table>
                    <div class="card panel-default">
                        <div class="card-header"><?= lang('calculate_unit_cost'); ?></div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="pcost" class="col-sm-4 control-label"><?= lang('subtotal'); ?></label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="psubtotal">
                                        <div class="input-group-addon" style="padding: 2px 8px;">
                                            <span class="input-group-text">
                                                    <a href="#" id="calculate_unit_price" class="tip" title="<?= lang('calculate_unit_cost'); ?>">
                                                        <i class="fa fa-calculator"></i>
                                                    </a>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="punit_cost" value=""/>
                    <input type="hidden" id="old_tax" value=""/>
                    <input type="hidden" id="old_qty" value=""/>
                    <input type="hidden" id="old_cost" value=""/>
                    <input type="hidden" id="row_id" value=""/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="editItem"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>



<input type="hidden" id="invoice" value="<?=htmlspecialchars(json_encode($inv));?>"/>
<input type="hidden" id="inv_items" value="<?=htmlspecialchars(json_encode($inv_items));?>"/>
<input type="hidden" id="purchase_date" value="<?php echo date($dateFormats['php_ldate'], strtotime($purchase->date));?>"/>
<input type="hidden" id="purchase_date_fld" value="<?php echo $this->repairer->fld($purchase->date);?>"/>
<script type="text/javascript" src="<?=base_url();?>panel/misc/js/purchases_edit"></script>

