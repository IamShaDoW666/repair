<input type="hidden" id="repair_id" value="<?=$id?$id:'';?>" />

        <div class="row">
  <div class="col-12">
    <div class="card">

    <div class="card-header d-flex p-0">
        <h3 class="card-title p-3"><?= lang('view_log_title'); ?></h3>
    </div>
      <div class="card-body">

                    <table class="display compact table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th><?= lang('log_date'); ?></th>
                                <th><?= lang('log_username'); ?></th>
                                <th><?= lang('log_details'); ?></th>
                            </tr>
                        </thead>
                
                        <tfoot>
                            <tr>
                                <th><?= lang('log_date'); ?></th>
                                <th><?= lang('log_username'); ?></th>
                                <th><?= lang('log_details'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
<script src="<?=$assets?>dist/js/page/view_log.js"></script>