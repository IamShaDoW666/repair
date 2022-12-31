<?php if($this->Admin || $GP['inventory-add_manufacturer']): ?>
<button href="#manufacturermodal" class="add_manufacturer btn btn-primary">
    <i class="fa fa-plus-circle"></i> <?= lang('add'); ?> <?= lang('manufacturer_title'); ?>
</button>
<?php endif; ?>


<div class="row">
  <div class="col-12">
    <div class="card">

    
      <div class="card-body">
          <table class="display compact table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th><?= lang('model_manufacturer'); ?></th>
                                <th><?= lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?= lang('model_manufacturer'); ?></th>
                                <th><?= lang('actions'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
      </div>
  </div>
</div>


<script type="text/javascript" src="<?=base_url();?>panel/misc/js/manufacturer"></script>
