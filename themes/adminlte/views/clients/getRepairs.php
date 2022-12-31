<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><?= lang('reparation'); ?></h4>
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <i class="fa">&times;</i>
        </button>
    </div>
    <div class="modal-body">
        <!-- Main content -->
        <div class="modal-body">
            <div class="table-responsive">
                <table class="display compact table table-bordered table-striped" id="view-repars-table">
                    <thead>
                        <tr>
                            <th><?= lang('reparation_code'); ?></th>
                            <th><?= lang('reparation_imei'); ?></th>
                            <th><?= lang('reparation_defect'); ?></th>
                            <th><?= lang('reparation_model'); ?></th>
                            <th><?= lang('reparation_opened_at'); ?></th>
                            <th><?= lang('reparation_status'); ?></th>
                            <th><?= lang('added_by'); ?></th>
                            <th><?= lang('last_modified_by'); ?></th>
                            <th><?= lang('grand_total'); ?></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><?= lang('reparation_code'); ?></th>
                            <th><?= lang('reparation_imei'); ?></th>
                            <th><?= lang('reparation_defect'); ?></th>
                            <th><?= lang('reparation_model'); ?></th>
                            <th><?= lang('reparation_opened_at'); ?></th>
                            <th><?= lang('reparation_status'); ?></th>
                            <th><?= lang('added_by'); ?></th>
                            <th><?= lang('last_modified_by'); ?></th>
                            <th><?= lang('grand_total'); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url();?>panel/misc/js/getRepairs"></script>