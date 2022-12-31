<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('update_status'); ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
        </div>
        <?php $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
        echo form_open_multipart('panel/reparation/update_status/' . $repair['id'], $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= lang('sale_details'); ?>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed table-striped table-borderless" style="margin-bottom:0;">
                        <tbody>
                            <tr>
                                <td><?= lang('reference_no'); ?></td>
                                <td><?= $repair['code']; ?></td>
                            </tr>
                            <tr>
                                <td><?= lang('customer'); ?></td>
                                <td><?= $repair['name']; ?></td>
                            </tr>
                            <tr>
                                <td><?= lang('payment_status'); ?></td>
                                <td><?= lang($repair['payment_status']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
           
            <div class="form-group">
                <?= lang('status', 'status'); ?>

                <?php 
                $opts = [];
                foreach ($statuses as $status){
                    $opts[$status->id] = $status->label;
                } 
                ?>
                

                <?= form_dropdown('status', $opts, $repair['status'], 'class="form-control select" id="status" required="required" style="width:100%;"'); ?>
            </div>

            <div class="form-group">
                <?= lang('description', 'description'); ?>
                <?php echo form_textarea('description', '', 'class="form-control" id="description"'); ?>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('update', lang('update'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>