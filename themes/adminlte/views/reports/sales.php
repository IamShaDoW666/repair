<?php
$v = "";
if ($this->input->post('date_range')) {
    $dr = explode(' - ', $this->input->post('date_range'));
    $v .= "&start_date=" . $this->repairer->fsd($dr[0]);
    $v .= "&end_date=" . $this->repairer->fsd($dr[1]);
}
?>
<div class="row">
  <div class="col-12">
    <div class="card">

    <div class="card-header d-flex p-0">
        <h3 class="card-title p-3"><?= lang('reports/sales'); ?></h3>
        <ul class="nav nav-pills ml-auto p-2">
            <li class="dropdown dropleft">
                    <div class="btn-group dropleft" style="list-style-type: none;">
                        <a data-toggle="dropdown" class="dropdown-toggle btn-round btn btn-default" href="#" >
                            <i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i> 
                        </a>

                        <ul class="dropdown-menu  tasks-menus" role="menu" aria-labelledby="dLabel">
                                <a  href="<?=site_url('panel/reports/getAllSales/pdf/?v=1'.$v);?>" class="dropdown-item">
                                    <i class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?>
                                </a>                       
                                <a class="dropdown-item" href="<?=site_url('panel/reports/getAllSales/0/xls/?v=1'.$v)?>">
                                    <i class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?>
                                </a>
                        </ul>
                    </div>
            </li>
        </ul>
    </div>
      <div class="card-body">
         <?php echo form_open("panel/reports/sales"); ?>
                    <div class="form-group">
                        <?= lang('date_range', 'date_range'); ?>
                        <input class="form-control" type="text" name="date_range" class="date_range" id="date_range" value='<?= set_value('date_range'); ?>'>
                    </div>

                    <div class="form-group">
                        <div
                            class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>
                    
             <table style="width: 100%;" class=" compact table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th><?= lang('sale_id'); ?></th>
                                <th><?= lang('date'); ?></th>
                                <th><?= lang('customer'); ?></th>
                                <th><?= lang('items'); ?></th>
                                <th><?= lang('subtotal'); ?></th>
                                <th><?= lang('tax'); ?></th>
                                <th><?= lang('total'); ?></th>
                                <th><?= lang('paid'); ?></th>
                                <th><?= lang('balance'); ?></th>
                                <th><?= lang('payment_status'); ?></th>
                                <th><?= lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?= lang('sale_id'); ?></th>
                                <th><?= lang('date'); ?></th>
                                <th><?= lang('customer'); ?></th>
                                <th><?= lang('items'); ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><?= lang('payment_status'); ?></th>
                                <th><?= lang('actions'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
      </div>
  </div>
</div>

<link rel="stylesheet" type="text/css" href="<?= $assets ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<script type="text/javascript" src="<?= $assets ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>plugins/jszip/jszip.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>plugins/pdfmake/pdfmake.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>plugins/pdfmake/vfs_fonts.js"></script>
<script type="text/javascript" src="<?= $assets ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= $base_url ?>panel/misc/js/sales"></script>
