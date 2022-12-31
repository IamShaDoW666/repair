

<!-- ============= MODAL MODIFICA supplierI ============= -->
<div class="modal fade" id="taxmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titsupplieri"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <p class="tips custip"></p>
                        <form class="col s12" id="tax_form">
                            <div class="row">
                                <div class="col-md-12 col-lg-6 input-field">
                                    <div class="form-group">
                                        <?= lang('tax_name', 'tax_name'); ?>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa  fa-user"></i></span>
                                            </div>
                                            <input id="tax_name" name="name" type="text" class="validate form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 input-field">
                                    <div class="form-group">
                                        <?= lang('tax_code', 'tax_code'); ?>
                                        <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa  fa-user"></i></span>
                                </div>
                                            <input id="tax_code" name="code" type="text" class="validate form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <?= lang('tax_rate', 'tax_rate'); ?>
                                        <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa  fa-road"></i></span>
                                </div>
                                            <input data-parsley-type="number" id="tax_rate" required name="rate" type="text" class="validate form-control">
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <?= lang('tax_type', 'tax_type'); ?>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa  fa-road"></i></span>
                                            </div>
                                            <select id="tax_type" required name="type" class="validate form-control" >
                                                <option value="1">Percentage</option>
                                                <option value="2">Fixed</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                        </form>
            </div>
            <div class="modal-footer" id="footertaxrate">
                  <!--    -->
            </div>
        </div>
    </div>
</div>
</div>


<?php if($this->Admin || $GP['tax_rates-add']): ?>
<button href="#taxmodal" class="add_taxrate btn btn-primary">
    <i class="fa fa-plus-circle"></i> <?= lang('add').' '.lang('taxrate_title'); ?>
</button>
<?php endif; ?>



<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
            <table class="display compact table table-bordered table-striped" id="dynamic-table">
                <thead>
                    <tr>
                        <th><?= lang('tax_name'); ?></th>
                        <th><?= lang('tax_code'); ?></th>
                        <th><?= lang('tax_rate'); ?></th>
                        <th><?= lang('tax_type'); ?></th>
                        <th><?= lang('actions'); ?></th>
                    </tr>
                </thead>
        
                <tfoot>
                    <tr>
                        <th><?= lang('tax_name'); ?></th>
                        <th><?= lang('tax_code'); ?></th>
                        <th><?= lang('tax_rate'); ?></th>
                        <th><?= lang('tax_type'); ?></th>
                        <th><?= lang('actions'); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</div>

<script type="text/javascript" src="<?=$assets;?>dist/js/page/tax_rates.js"></script>
