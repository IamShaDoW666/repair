

        <div class="row">
  <div class="col-12">
    <div class="card">

    <div class="card-header d-flex p-0">
        <h3 class="card-title p-3"><?= lang('reports/drawer'); ?></h3>
        <ul class="nav nav-pills ml-auto p-2">
            <li class="dropdown dropleft">
                    <div class="btn-group dropleft" style="list-style-type: none;">
                        <a data-toggle="dropdown" class="dropdown-toggle btn-round btn btn-default" href="#" >
                            <i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i> 
                        </a>
                        <ul class="dropdown-menu  tasks-menus" role="menu" aria-labelledby="dLabel">
                                <a class="dropdown-item" href="#" id="xls" data-action="export_excel">
                                    <i class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?>
                                </a>                       
                                <a class="dropdown-item" href="#" id="pdf" data-action="export_pdf">
                                    <i class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?>
                                </a>
                        </ul>
                    </div>
            </li>
        </ul>
    </div>
      <div class="card-body">
        <?php echo form_open("panel/reports/drawer"); ?>
        <div class="form-group">
            <label>Date Range</label>
            <input class="form-control" type="text" name="date_range" class="date_range" id="date_range" value='<?= set_value('date_range'); ?>'>
        </div>

        <div class="form-group">
            <div
                class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
        </div>
        <?php echo form_close(); ?>
        
        <table class=" compact table table-bordered table-striped" id="dynamic-table">
            <thead>
                <tr>
                    <th><?= lang('opened_by'); ?></th>
                    <th><?= lang('open_time'); ?></th>
                    <th><?= lang('cash_in_hand'); ?></th>
                    <th><?= lang('closed_by'); ?></th>
                    <th><?= lang('close_time'); ?></th>
                    <th><?= lang('close_cash'); ?></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><?= lang('opened_by'); ?></th>
                    <th><?= lang('open_time'); ?></th>
                    <th><?= lang('cash_in_hand'); ?></th>
                    <th><?= lang('closed_by'); ?></th>
                    <th><?= lang('close_time'); ?></th>
                    <th><?= lang('close_cash'); ?></th>
                </tr>
            </tfoot>
        </table>
      </div>
  </div>
</div>
<script src="<?=base_url();?>panel/misc/js/drawer"></script>
