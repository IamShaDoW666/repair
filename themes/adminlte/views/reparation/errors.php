
<button href="#errormodal" class="add_error btn btn-primary">
    <i class="fa fa-plus-circle"></i> <?= lang('add'); ?> <?= lang('reparation_error'); ?>
</button>
    

    <div class="row">
  <div class="col-12">
    <div class="card">

      <!-- /.card-header -->
      <div class="card-body">
         <table class="display compact table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th><?= lang('error_defect'); ?></th>
                                <th><?= lang('error_code'); ?></th>
                                <th><?= lang('error_description'); ?></th>
                                <th><?= lang('error_reason'); ?></th>
                                <th><?= lang('actions'); ?></th>
                            </tr>
                        </thead>
                
                        <tfoot>
                            <tr>
                              
                                <th><?= lang('error_defect'); ?></th>
                                <th><?= lang('error_code'); ?></th>
                                <th><?= lang('error_description'); ?></th>
                                <th><?= lang('error_reason'); ?></th>
                                <th><?= lang('actions'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
      </div>
  </div>
</div>





<!-- ============= MODAL MODIFY CLIENTI ============= -->
<div class="modal fade" id="errormodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title_error"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                        <form id="error_form" class="col s12" data-parsley-validate>
                    <div class="row">
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('error_defect', 'error_defect'); ?>
                                    <div class="input-group">

                                         <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa  fa-link"></i></span>
                                          </div>


                                        <input id="error_defect" name="defect" type="text" class="validate form-control" required>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('error_code', 'error_code'); ?>
                                    <div class="input-group">

                                         <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa  fa-link"></i></span>
                                          </div>

                                        <input id="error_code" name="code" type="text" class="validate form-control" required>
                                    </div>
                                   
                                </div>
                            </div>
                            
                            <div class="input-field col-lg-12">
                                <div class="form-group">
                                    <?= lang('error_description', 'error_description'); ?>
                                    <textarea class="form-control" id="error_description" name="description" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="input-field col-lg-12">
                                <div class="form-group">
                                    <?= lang('error_reason', 'error_reason'); ?>
                                    <textarea class="form-control" id="error_reason" name="reason" rows="6"></textarea>
                                </div>
                            </div>
                </div>

                        </form>
            </div>
            <div class="modal-footer" id="footerError">
                  <!--    -->
            </div>
        </div>
    </div>
</div>
</div>



<script src="<?=base_url();?>panel/misc/js/errors"></script>
