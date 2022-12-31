<?php if($this->Admin || $GP['inventory-add_model']): ?>
<button href="#modelmodal" class="add_model btn btn-primary">
    <i class="fa fa-plus-circle"></i> <?= lang('add'); ?> <?= lang('model_title'); ?>
</button>
<?php endif; ?>
<!-- Main content -->



<div class="row">
  <div class="col-12">
    <div class="card">

    
      <div class="card-body">
        <table class="display compact table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th><?= lang('model_name'); ?></th>
                                <th><?= lang('model_manufacturer'); ?></th>
                                <th><?= lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?= lang('model_name'); ?></th>
                                <th><?= lang('model_manufacturer'); ?></th>
                                <th><?= lang('actions'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
      </div>
  </div>
</div>



<script type="text/javascript" src="<?=base_url();?>panel/misc/js/model"></script>
