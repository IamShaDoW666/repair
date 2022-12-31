<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<input type="hidden" id="reference" value="<?= $reference ?>"/>
<input type="hidden" id="invoice" value="<?=htmlspecialchars(json_encode($inv));?>"/>
<input type="hidden" id="inv_items" value="<?=htmlspecialchars(json_encode($inv_items));?>"/>

<script type="text/javascript" src="<?=base_url();?>panel/misc/js/return_purchase"></script>


<div class="card">
 
    <div class="card-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = ['data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-resl-form'];
                echo form_open_multipart('panel/purchases/return_purchase/' . $inv->id, $attrib)
                ?>

                <div class="">
                    <div class="col-lg-12">
                <div class="row">
                       
                         <div class="col-md-4">
                            <div class="form-group">
                                <?= lang('date', 'redate'); ?>

                                 <div class="input-group" id="redate" data-target-input="nearest">
                                     <div class="input-group-append" data-target="#redate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    

                                    <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control datetimepicker-input" data-target="#redate" required="required"'); ?>


                                </div>


                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang('reference_no', 'reref'); ?>
                                <?php echo form_input('reference_no', ($_POST['reference_no'] ?? ''), 'class="form-control input-tip" id="reref"'); ?>
                            </div>
                        </div>
                      

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('rma_number');?></label>
                                <?php echo form_input('rma_number', set_value('rma_number'), 'class="form-control input-tip" id="reref"'); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang('return_surcharge', 'return_surcharge'); ?>
                                <?php echo form_input('return_surcharge', ($_POST['return_surcharge'] ?? ''), 'class="form-control input-tip" id="return_surcharge" required="required"'); ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang('document', 'document') ?>
                                <input id="document" type="file" data-browse-label="<?= lang('browse'); ?>" name="document" data-show-upload="false"
                                       data-show-preview="false" class="form-control file">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="control-group table-group">
                                <label class="table-label"><?= lang('order_items'); ?></label> (<?= lang('return_tip'); ?>)

                                <div class="controls table-controls">
                                    <table id="reTable"
                                           class="table items table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th class="col-md-4"><?= lang('product_name') . ' (' . $this->lang->line('product_code') . ')'; ?></th>
                                          
                                            <th class="col-md-1"><?= lang('net_unit_cost'); ?></th>
                                            <th class="col-md-1"><?= lang('quantity'); ?></th>
                                            <th class="col-md-1"><?= lang('received'); ?></th>
                                            <th class="col-md-1"><?= lang('return_quantity'); ?></th>
                                            <?php
                                            if ($settings->product_discount) {
                                                echo '<th class="col-md-1">' . $this->lang->line('discount') . '</th>';
                                            }
                                            ?>
                                            <?php
                                            if ($settings->tax1) {
                                                echo '<th class="col-md-1">' . $this->lang->line('product_tax') . '</th>';
                                            }
                                            ?>
                                            <th><?= lang('subtotal'); ?> (<span
                                                    class="currency"><?= $settings->currency ?></span>)
                                            </th>
                                            <th style="width: 30px !important; text-align: center;">
                                                <i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="bottom-total" class="well well-sm" style="margin-bottom: 0;">
                                <table class="table table-bordered table-condensed totals" style="margin-bottom:0;">
                                    <tr class="warning">
                                        <td>
                                            <?= lang('items') ?>
                                            <span class="totals_val pull-right" id="titems">0</span>
                                        </td>
                                        <td>
                                            <?= lang('total') ?>
                                            <span class="totals_val pull-right" id="total">0.00</span>
                                        </td>
                                        <?php if ($settings->tax1) {
                                                ?>
                                        <td>
                                            <?= lang('product_tax') ?>
                                            <span class="totals_val pull-right" id="ttax1">0.00</span>
                                        </td>
                                        <?php
                                            } ?>
                                        <td>
                                            <?= lang('surcharges') ?>
                                            <span class="totals_val pull-right" id="trs">0.00</span>
                                        </td>
                                        <?php if ($settings->tax2) {
                                                ?>
                                        <td>
                                            <?= lang('order_tax') ?>
                                            <span class="totals_val pull-right" id="ttax2">0.00</span>
                                        </td>
                                        <?php
                                            } ?>
                                        <td>
                                            <?= lang('return_amount') ?>
                                            <span class="totals_val pull-right" id="gtotal">0.00</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div style="height:15px; clear: both;"></div>
                        

                        <input type="hidden" name="total_items" value="" id="total_items" required="required"/>
                        <input type="hidden" name="order_tax" value="" id="retax2" required="required"/>
                        <input type="hidden" name="discount" value="" id="rediscount" required="required"/>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= lang('return_note', 'renote'); ?>
                                    <?php echo form_textarea('note', ($_POST['note'] ?? ''), 'class="form-control" id="renote" style="margin-top: 10px; height: 100px;"'); ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="fprom-group">
                                    <?php echo form_submit('add_return', $this->lang->line('submit'), 'id="add_return" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
