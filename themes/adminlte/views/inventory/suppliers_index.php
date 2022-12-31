<!-- ============= MODAL MODIFICA supplierI ============= -->
<div class="modal fade" id="suppliermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titsupplieri"></h4>

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <p class="tips custip"></p>
                        <form id="suppliers_form" class="col s12">
                    <div class="row">

                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_name', 'suppliers_name'); ?>

                                    <div class="input-group">
                                       <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa  fa-user"></i></span>
                                      </div>
                                        <input id="suppliers_name" name="name" type="text" class="validate form-control" required>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_company', 'suppliers_company'); ?>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa  fa-user"></i></span>
                              </div>
                                        <input id="suppliers_company" name="company" type="text" class="validate form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <?= lang('supplier_address', 'suppliers_address'); ?>
                                    <div class="input-group">
                                       <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa  fa-road"></i></span>
                              </div>
                                        <input id="suppliers_address" name="address" type="text" class="validate form-control">
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_city', 'suppliers_city'); ?>
                                    <div class="input-group">
                                       <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa  fa-globe"></i></span>
                              </div>
                                        <input id="suppliers_city" name="city" type="text" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_country', 'suppliers_country'); ?>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa  fa-envelope"></i></span>
                              </div>
                                        <input id="suppliers_country" name="country" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_state', 'suppliers_state'); ?>

                                    <div class="input-group">
                                       <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa  fa-envelope"></i></span>
                              </div>
                                        <input id="suppliers_state" name="state" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_postal_code', 'suppliers_postal_code'); ?>

                                    <div class="input-group">
                                       <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa  fa-envelope"></i></span>
                              </div>
                                        <input id="suppliers_postal_code" name="postal_code" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_phone', 'suppliers_phone'); ?>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa  fa-phone"></i></span>
                              </div>
                                        <input id="suppliers_phone" type="text" name="phone" class="validate form-control" data-mask="(999) 999-9999">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_email', 'suppliers_email'); ?>

                                    <div class="input-group"><div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa  fa-envelope"></i></span>
                              </div>
                                        <input id="suppliers_email" type="email" name="email" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_vat', 'suppliers_vat_no'); ?>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa  fa-envelope"></i></span>
                              </div>
                                        <input id="suppliers_vat_no" name="vat_no" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                </div>

                        </form>
            </div>
            <div class="modal-footer" id="footersupplier1">
                  <!--    -->
            </div>
        </div>
    </div>
</div>
</div>



<!-- ============= MODAL View supplier ============= -->
<div class="modal fade" id="view_supplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><div id="titlesupplier"></div></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="row">
                        
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-user"></i> <?= lang('supplier_name'); ?> </span><span id="vs_name"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-user"></i> <?= lang('supplier_company'); ?> </span><span id="vs_company"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-road"></i> <?= lang('supplier_address'); ?></span><span id="vs_address"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-globe"></i> <?= lang('supplier_city'); ?></span><span id="vs_city"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-phone"></i> <?= lang('supplier_country'); ?> </span><span id="vs_country"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-envelope"></i> <?= lang('supplier_state'); ?> </span><span id="vs_state"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-barcode"></i> <?= lang('supplier_postal_code'); ?> </span><span id="vs_postal_code"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-quote-left"></i> <?= lang('supplier_phone'); ?> </span><span id="vs_phone"></span></p>
                        </div>
                        
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-quote-left"></i> <?= lang('supplier_email'); ?> </span><span id="vs_email"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-quote-left"></i> <?= lang('supplier_vat'); ?> </span><span id="vs_vat_no"></span></p>
                        </div>

                    </div>
                   
                </div>
            </div>
            <div class="modal-footer" id="footersupplier"></div>
        </div>
    </div>
</div>

<?php if($this->Admin || $GP['inventory-add_supplier']): ?>
<button href="#suppliermodal" class="add_supplier btn btn-primary">
    <i class="fa fa-plus-circle"></i> <?= lang('add'); ?> <?= lang('supplier_title'); ?>
</button>
<?php endif; ?>




<div class="row">
  <div class="col-12">
    <div class="card">

    
    <div class="card-body">
        <table class="display compact table table-bordered table-striped" id="dynamic-table">
            <thead>
                <tr>
                    <th><?= lang('supplier_name'); ?></th>
                    <th><?= lang('supplier_company'); ?></th>
                    <th><?= lang('supplier_phone'); ?></th>
                    <th><?= lang('supplier_email'); ?></th>
                    <th><?= lang('supplier_city'); ?></th>
                    <th><?= lang('supplier_country'); ?></th>
                    <th><?= lang('supplier_vat'); ?></th>
                    <th><?= lang('actions'); ?></th>
                    
                </tr>
            </thead>
    
            <tfoot>
                <tr>
                    <th><?= lang('supplier_name'); ?></th>
                    <th><?= lang('supplier_company'); ?></th>
                    <th><?= lang('supplier_phone'); ?></th>
                    <th><?= lang('supplier_email'); ?></th>
                    <th><?= lang('supplier_city'); ?></th>
                    <th><?= lang('supplier_country'); ?></th>
                    <th><?= lang('supplier_vat'); ?></th>
                    <th><?= lang('actions'); ?></th>
                </tr>
            </tfoot>
        </table>
      </div>
  </div>
</div>
     
<script type="text/javascript" src="<?=base_url();?>panel/misc/js/suppliers"></script>