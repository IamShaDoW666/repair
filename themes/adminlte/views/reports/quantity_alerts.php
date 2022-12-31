
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
            <table class="display compact table table-bordered table-striped" id="dynamic-table">
                <thead>
                    <tr>
                        <th><?= lang('product_name'); ?></th>
                        <th><?= lang('product_code'); ?></th>
                        <th><?= lang('quantity'); ?></th>
                        <th><?= lang('alert_quantity'); ?></th>
                    </tr>
                </thead>
        
                <tfoot>
                    <tr>
                        <th><?= lang('product_name'); ?></th>
                        <th><?= lang('product_code'); ?></th>
                        <th><?= lang('quantity'); ?></th>
                        <th><?= lang('alert_quantity'); ?></th>
                    </tr>
                </tfoot>
            </table>
      </div>
  </div>
</div>
<script src="<?= $base_url ?>panel/misc/js/quantity_alerts"></script>
