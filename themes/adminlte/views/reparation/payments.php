<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><?= lang('view_payments').' ('.lang('sale').' '.lang('reference').': '.$inv->code.')'; ?></h4>
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <i class="fa">&times;</i>
        </button>
    </div>
    <div class="modal-body">
        <a href="<?=base_url();?>panel/reparation/add_payment/<?=$inv->id;?>" class="btn-icon btn btn-primary btn-icon" data-toggle="modal" data-target="#myModal2">
            <i class="fas fa-money-bill-alt img-circle text-primary"></i> 
            <?=lang('add_payment');?>
        </a>
        <div class="table-responsive">
            <table id="CompTable" cellpadding="0" cellspacing="0" border="0"
                   class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th style="width:30%;"><?= $this->lang->line("date"); ?></th>
                    <th style="width:15%;"><?= $this->lang->line("amount"); ?></th>
                    <th style="width:15%;"><?= $this->lang->line("paid_by"); ?></th>
                    <th style="width:10%;"><?= $this->lang->line("actions"); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($payments)) {
                    foreach ($payments as $payment) { ?>
                        <tr class="row<?= $payment->id ?>">
                            <td><?= date('Y-m-d', strtotime($payment->date)); ?></td>
                            <td><?= $this->repairer->formatMoney($payment->amount) . ' ' . (($payment->attachment) ? '<a href="' . base_url('panel/welcome/download/' . $payment->attachment) . '"><i class="fa fa-chain"></i></a>' : ''); ?></td>
                            <td><?= humanize($payment->paid_by); ?></td>
                            <td>
                                <div class="text-center">
                                    <a href="<?= base_url('panel/reparation/edit_payment/' . $payment->id.'/'. $payment->reparation_id) ?>"
                                       data-toggle="modal" data-target="#myModal2"><i
                                            class="fa fa-edit"></i></a>


                                <a href="#" class="po"
                                           title="<b><?= $this->lang->line("delete_payment") ?></b>"
                                           data-content="<p><?= lang('r_u_sure') ?></p><a class='btn-icon btn btn-danger' id='<?= $payment->id ?>' href='<?= base_url('panel/reparation/delete_payment/' . $payment->id) ?>'><i class='fa fa-trash img-circle text-danger'></i> <?= lang('i_m_sure') ?></a> <button class='btn po-close btn-default btn-icon '><i class='fa fa-reply img-circle text-muted'></i> <?= lang('no') ?></button>"
                                           rel="popover"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='4'>" . lang('no_payments') . "</td></tr>";
                } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn-responsive  btn-icon btn btn-goback" type="button">
            <i class="fa fa-reply img-circle text-muted"></i> 
            <?= lang('go_back'); ?>
        </button>
    </div>
</div>