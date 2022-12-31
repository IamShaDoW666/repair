
<link href="<?= $assets;?>/plugins/patternlock/patternLock.css"  rel="stylesheet" type="text/css" />

<!-- ============= MODAL VISUALIZZA ORDINI/RIPARAZIONI ============= -->
<div class="col-md-12 modal fade" id="view_reparation" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-ku">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <div id="titoloOE"></div>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-12 col-lg-4 bio-row">
              <p><span class="bold"><i class="fa fa-laptop"></i> <?= lang('reparation_imei'); ?> </span><span id="rv_imei"></span></p>
            </div>
            <div class="col-md-12 col-lg-4 bio-row">
              <p><span class="bold"><i class="fa fa-user"></i> <?= lang('client_title'); ?></span><span id="rv_client"></span></p>
            </div>
            <div class="col-md-12 col-lg-4 bio-row stato">
              <p><span class="bold"><i class="fa fa-signal"></i> <?= lang('reparation_condition'); ?> </span><span class="label" id="rv_condition"></span></p>
            </div>
            <div class="col-md-12 col-lg-4 bio-row">
              <p><span class="bold"><i class="fa fa-calendar"></i> <?= lang('reparation_opened_at'); ?> </span><span id="rv_created_at"></span></p>
            </div>
            <div class="col-md-12 col-lg-4 bio-row">
              <p><span class="bold"><i class="fas fa-link"></i> <?= lang('reparation_defect'); ?> </span><span id="rv_defect"></span></p>
            </div>
            <div class="col-md-12 col-lg-4 bio-row">
              <p><span class="bold"><i class="fa fa-sitemap"></i> <?= lang('reparation_category'); ?> </span><span id="rv_category"></span></p>
            </div>
            <div class="col-md-12 col-lg-4 bio-row">
              <p><span class="bold"><i class="fa fa-desktop"></i> <?= lang('reparation_model'); ?> </span><span id="rv_model"></span></p>
            </div>
            <div class="col-md-12 col-lg-4 bio-row nofloat">
              <p><span class="bold"><i class="fas fa-money-bill-alt"></i><?= lang('reparation_price'); ?> </span><span id="rv_price"></span></p>
            </div>
            <div class="col-md-12 col-lg-4 bio-row">
              <p><span class="bold"><i class="fa fa-phone"></i> <?= lang('client_telephone'); ?> </span><span id="rv_phone_number"></span></p>
            </div>
            <div class="col-md-12 col-lg-4 bio-row">
              <p><span class="bold"><i class="glyphicon glyphicon-qrcode"></i> <?= lang('reparation_code'); ?> </span><span id="rv_rep_code"></span></p>
            </div>
            <div class="col-md-12 col-lg-4 bio-row nofloat">
              <p><span class="bold"><i class="fas fa-retweet"></i><?= lang('warranty'); ?> </span><span id="rv_warranty"></span></p>
            </div>
            <?php 
              $custom_fields = explode(',', $settings->custom_fields);
              foreach($custom_fields as $line){
                  if (!empty($line)) {
              ?>
            <div class="col-md-12 col-lg-4 bio-row">
              <p><span class="bold"><i class="fa fa-info-circle"></i> <?= $line; ?> </span><span class="show_custom" id="v<?= bin2hex($line); ?>"></span></p>
            </div>
            <?php }} ?>
          </div>
            <div class="row">
                <div class="col-md-6 bio-row textareacom">
                  <div class="form-group comment">
                    <?= lang('reparation_comment', 'rv_comment'); ?>
                    <textarea class="form-control" id="rv_comment" rows="6" disabled=""></textarea>
                  </div>
                </div>
                <div class="col-md-6 bio-row textareacom">
                  <div class="form-group comment">
                    <?= lang('reparation_diagnostics', 'rv_diagnostics'); ?>
                    <textarea class="form-control" id="rv_diagnostics" rows="6" disabled=""></textarea>
                  </div>
                </div>
                <div class="col-md-6 bio-row fastsms">
                  <div class="form-group rv_comment">
                    <?=lang('quick_sms', 'fastsms');?>
                    <textarea class="form-control" id="fastsms" rows="6" placeholder="Instantly send a text message to the client by entering your text here"></textarea>
                    <button type="button" class="btn btn-xs btn-primary" id="sendsmsfast"><i class="fa fa-check"></i> <?=lang('send');?></button>
                  </div>
                </div>
            </div>
        <div id="timeline"></div>
      </div>
      <div id="footerOR" class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!-- ============= MODAL reparation add ============= -->
<div class="modal fade" id="reparationmodal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-ku">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titReparation"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
          <p class="tips custip"></p>
          <form id="rpair_form" enctype="multipart/form-data">
            <input type="hidden" name="sign_id" id="repair_sign_id" value="">
            <input type="hidden" name="sign_name" id="repair_sign_name" value="">
            <input type="hidden" name="attachment_data" id="attachment_data" value>
            <input type="hidden" name="status_text" id="status_text" value>
            <div id="preprepair_hide"></div>
            <div class="row">
              <div class="col-md-8">
                <div class="row">
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                      <div class="form-group">
                        <?=lang('reparation_imei', 'imei');?>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fas fa-laptop"></i></span>
                          </div>
                          <input id="imei" name="imei" type="text" class="validate form-control imei_typeahead">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                      <?=lang('client_title', 'client_name');?>
                      <div class="input-group">
                        
                        <select required id="client_name" name="client_name" data-num="1" class="form-control m-bot15" >
                          <option></option>
                         
                        </select>
                         <div class="input-group-append">
                          <span  id="add_client" class="input-group-text add_c">
                          <i class="fa fa-user-plus"></i>
                          </span>
                        </div>

                       
                      </div>
                    </div>
                  </div>


                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                      <?=lang('reparation_category', 'category_select');?>


                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa  fa-folder"></i></span>
                        </div>
                        <input id="category" name="category" type="text" class="validate form-control categories_typeahead">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                      <div class="form-group">
                        <?=lang('assigned_to', 'assigned_to');?>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fa fa-user"></i></span>
                          </div>
                          <select required id="assigned_to" name="assigned_to" class="form-control m-bot15" >
                          <?php
                            foreach($users as $user){
                                echo '<option value="'.$user->id.'">'.$user->first_name . ' ' . $user->last_name .'</option>';
                            } 
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                      <div class="form-group">
                        <?=lang('model_manufacturer', 'reparation_manufacturer');?>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fas fa-link"></i></span>
                          </div>
                           <input class="form-control manufacturer_name_typeahead" id="reparation_manufacturer" name="manufacturer" required="" >
                        </div>
                      </div>
                  </div>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                      <?=lang('reparation_model', 'reparation_model');?>
                      <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fas fa-link"></i></span>
                          </div>
                          <input class="form-control model_name_typeahead" id="reparation_model" name="model" required="" >
                        </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                        <?=lang('reparation_defect', 'defect');?>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fas fa-link"></i></span>
                          </div>
                          <input required id="defect" name="defect" type="text" class="validate form-control defect_typeahead">
                        </div>
                    </div>
                  </div>

                  <?php $hide_repair_fields = json_decode($settings->hide_repair_fields);?>

                  <?php if($hide_repair_fields->error_code): ?>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                        <?=lang('error_code', 'error_code');?>
                        <select id="error_code" name="error_code" class="form-control m-bot15" >
                        <?php
                          foreach($errors as $error){
                              echo '<option value="'.$error->code.'">'.$error->code . ' - ' . $error->description .'</option>';
                          } 
                          ?>
                        </select>
                    </div>
                  </div>
                  <?php endif;?>


                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                      <?=lang('reparation_service_charges', 'service_charges');?>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                          <i class="fas fa-truck"></i></span>
                        </div>
                        <input id="service_charges" name="service_charges" min="0" type="number" value="0" step="any" class="validate form-control">
                      </div>
                    </div>
                  </div>

                  <?php if($hide_repair_fields->expected_close_date): ?>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                        <?=lang('expected_close_date', 'expected_close_date');?>

                          <div class="input-group date" id="expected_close_date_" data-target-input="nearest">
                             <div class="input-group-append" data-target="#expected_close_date_" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input id="expected_close_date" data-target="#expected_close_date_" name="expected_close_date" type="text" class="validate form-control datetimepicker-input">
                          </div>
                      </div>
                  </div>
                  <?php endif;?>

                  
                  <?php if($hide_repair_fields->date_of_purchase): ?>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    
                      <div class="form-group">
                        <?=lang('date_of_purchase', 'date_of_purchase');?>


                         <div class="input-group date" id="date_of_purchase_" data-target-input="nearest">
                             <div class="input-group-append" data-target="#date_of_purchase_" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input id="date_of_purchase" data-target="#date_of_purchase_" name="date_of_purchase" type="text" class="validate form-control datetimepicker-input">
                          </div>
                    </div>
                  </div>
                  <?php endif;?>

                  
                  <?php if($hide_repair_fields->has_warranty): ?>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                      <?=lang('has_warranty', 'has_warranty');?>
                     
                        <?php $wm = array('1' => lang('in_warranty'), '0' => lang('out_warranty')); ?>
                        <?= form_dropdown('has_warranty', $wm, '', 'class="form-control" id="has_warranty" '); ?>
                    </div>
                  </div>
                  <?php endif;?>
                  <?php  

                          $warranties = array(
                              '0' => lang('no_warranty'),
                              '1M' => lang('1M'),
                              '2M' => lang('2M'),
                              '3M' => lang('3M'),
                              '4M' => lang('4M'),
                              '5M' => lang('5M'),
                              '6M' => lang('6M'),
                              '7M' => lang('7M'),
                              '8M' => lang('8M'),
                              '9M' => lang('9M'),
                              '10M' => lang('10M'),
                              '11M' => lang('11M'),
                              '12M' => lang('12M'),
                          ); 
                          ?>
                  <?php if($hide_repair_fields->warranty): ?>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                      <?=lang('warranty', 'warranty');?>
                     
                        <?php 
                          
                          echo form_dropdown('warranty', $warranties, '', 'class="form-control" id="warranty"');
                          ?>
                    </div>
                  </div>
                  <?php endif;?>

                  <?php if($hide_repair_fields->warranty_card_number): ?>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                        <?=lang('warranty_card_number', 'warranty_card_number');?>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fas fa-retweet"></i></span>
                          </div>
                          <input required id="warranty_card_number" name="warranty_card_number" type="text" class="validate form-control">
                        </div>
                    </div>
                  </div>
                  <?php endif;?>
                  
                  <?php if($hide_repair_fields->repair_type): ?>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                        <?=lang('repair_type', 'repair_type');?>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fas fa-wrench"></i></span>
                          </div>
                          <input  id="repair_type" name="repair_type" type="text" class="validate form-control">
                        </div>
                      </div>
                  </div>
                  <?php endif;?>

                  <?php if($hide_repair_fields->client_date): ?>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                        <?=lang('client_date', 'client_date');?>

                        <div class="input-group date" id="client_date_" data-target-input="nearest">
                             <div class="input-group-append" data-target="#client_date_" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input id="client_date" data-target="#client_date_" name="client_date" type="text" class="validate form-control datetimepicker-input">
                          </div>
                    </div>
                  </div>
                  <?php endif;?>
                  
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <?=lang('reparation_sms', 'repair_sms');?><br>
                    <input type="checkbox" value="1" name="sms" id="repair_sms" data-bootstrap-switch>
                  </div>  

                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <label for="repair_email"><?=lang('send_email_check');?></label><br>
                    <input type="checkbox" value="1" name="email" id="repair_email" data-bootstrap-switch>
                  </div>  
                  
                  <?php 
                    $custom = explode(',', $settings->custom_fields);
                    foreach($custom as $line){
                        if (!empty($line)) {
                    ?>
                  <div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
                    <div class="form-group">
                      <label><?= $line; ?></label>
                      <input id="custom_<?= bin2hex($line); ?>" name="custom_<?= bin2hex($line); ?>" type="text" class="custom validate form-control">
                    </div>
                  </div>
                  <?php } }?>
                  <div class="clearfix"></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <?=lang('taxrate_title', 'potax2');?>
                  <select id="potax2" class="form-control input-tip select" name="order_tax" style="width: 100%;">
                    <?php foreach ($tax_rates as  $tax): ?>
                    <option value="<?= $tax['id'] ?>"><?= $tax['name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group combo">
                  <?= lang("add_item", 'add_item'); ?>

                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="fa fa-link"></i></span>
                      </div>

                    <?php echo form_input('add_item', '', 'class="form-control ttip" id="add_item" data-placement="top" data-trigger="focus" data-bv-notEmpty-message="' . ('please_add_items_below') . '" placeholder="' . lang("add_item") . '"'); ?>
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i id="add_product_row" class="fa fa-plus"></i></span>
                      </div>
                  </div>
                </div>
                <div class="control-group table-group">
                  <label class="table-label" for="combo"><?= lang("defective_items"); ?></label>
                  <div class="controls table-controls">
                    <table id="prTable"
                      class="table items table-striped table-bordered table-sm table-hover">
                      <thead>
                        <tr>
                          <th class="w-50"><?= lang("product_name") . " (" . lang("product_code") . ")"; ?></th>
                          <th class="w-10"><?= lang("quantity"); ?></th>
                          <th class="w-10"><?= lang("unit_price"); ?></th>
                          <th class="w-10 text-center">
                            <i class="fas fa-trash" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <td colspan="4"><?= lang('nothing_to_display'); ?></td>
                      </tbody>
                    </table>
                     <table class="table items table-striped table-bordered table-sm table-hover">
                      <thead>
                        <tr>
                          <td colspan="1" class="warning"><span class="pull-right"><?= lang('tax');?></span></td>
                          <td colspan="1" class="success"><span id="tax_span">0.00</span></td>
                          <td colspan="1" class="warning"><span class="pull-right"><?=lang('subtotal')?></span></td>
                          <td colspan="1" class="info"><span id="price_span">0.00</span></td>
                        </tr>
                        <tr style="display: none;">
                          <th colspan="3" class="warning"><span class="pull-right"><?= lang('total'); ?></span></th>
                          <th colspan="1" class="success"><span id="totalprice_span">0.00</span></th>
                        </tr>
                        <tr>
                          <td colspan="3" class="warning"><span class="pull-right"><?=lang('reparation_service_charges')?></span></td>
                          <td colspan="1" class="success"><span id="sc_span">0.00</span></td>
                        </tr>
                      </thead>
                        <tbody>
                          <tr> 
                            <th colspan="1" style="width: 25%;
                            padding: 0
                            5px;"><strong><?=lang
                            ('discount_dropdown');?>
                            </strong></th> 
                            <th colspan="1"
                            class="text-right"
                            style="width: 25%;
                            padding: 1px
                            10px;font-weight:bold;">
                            <input type="text"
                            name="order_discount"
                            value=""
                            id="r_order_discount"
                            class="form-control">
                            </th>
                          <th colspan="1" class="warning"><span class="pull-right"><?= lang('grand_total'); ?></span></th>
                          <th class="success"><span id="gtotal">0.00</span></th>
                          </tr>
                        <tr>
                         
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div style="clear: both;"></div>
              
              <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-4 col-sm-6 col-xs-12 col-md-6">
                  <div class="form-group">
                    <?=lang('accessories', 'accessories');?> <i id="add_timestamp" class="fa fa-calendar"></i>
                    <textarea class="form-control" id="accessories" name="accessories" rows="6"></textarea>
                  </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12 col-md-6">
                  <div class="form-group">
                    <?= lang('reparation_comment', 'comment'); ?> <i id="add_timestamp" class="fa fa-calendar"></i>
                    <textarea class="form-control" id="comment" name="comment" rows="6"></textarea>
                  </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12 col-md-6">
                  <div class="form-group">
                    <?= lang('reparation_diagnostics', 'diagnostics'); ?> <i id="add_timestamp" class="fa fa-calendar"></i>
                    <textarea class="form-control" id="diagnostics" name="diagnostics" rows="6"></textarea>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </form>
          
      </div>
        <div class="modal-footer">
          <div class="row" id="footerReparationDiv" style="width: 100%">
          
          <div class="col">
              <button data-dismiss="modal" class="pull-left btn btn-default" type="button">
              <i class="fa fa-reply"></i> 
              <span class="d-none d-sm-inline"><?= lang('go_back'); ?></span>
            </button>
          </div>
          <div class="col-md-3 col-xs-12 ">
             <div class="input-group">
                <select id="status_edit" class="form-control">
                  <?php foreach ($statuses as $status): ?>
                  <option value="<?= $status->id; ?>"><?= $status->label; ?></option>
                  <?php endforeach; ?>
                  <option value="0"><?= lang('cancelled'); ?></option>
                </select>

                  <div class="input-group-prepend">
                    <span class="input-group-text" id="add_status_text">
                    <i class="fas fa-pencil-alt"></i></span>
                  </div>
              </div>
            </div>  
          <div class="col">
              <input id="code" type="text" class="validate form-control" value="" placeholder="<?= lang('reparation_code');?>">
          </div>
          </div>
        </div>
    </div>
  </div>
</div>
<!-- Sign Add -->
<div class="modal fade" id="signModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?=lang('signature');?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p class="tips custip"></p>
        <label id="signature_label"><?=lang('customer_signature_sign_below');?></label>
        <div id="signature"></div>
        <input type="hidden" name="sign_id" id="sign_id" value="">
        <center>
          <button id="submit_sign" data-mode="update_sign" class="btn-icon btn btn-success "><?=lang('save');?></button>
          <button id="reset_sign" class="btn-icon btn btn-primary btn-icon"><?=lang('reset');?></button>
        </center>
      </div>
    </div>
  </div>
</div>

<!-- ============= MODAL Upload Manager ============= -->
<div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="upload_modal_title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <label for="upload_manager"><?=lang('Attachments');?></label>
        <div class="file-loading">
          <input id="upload_manager" name="upload_manager[]" type="file" multiple>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Manufacturer Add -->
<div class="modal fade" id="modelmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="model_title_head"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p class="tips custip"></p>
          <form id="model_form" class="col s12">
            <div class="row">
              <div class="col-md-12 col-lg-6 input-field">
                <?= lang('model_name', 'model_name'); ?>
                <div class="form-line">
                  <select class="form-control" id="model_name" name="name[]" required="" multiple style="width: 100%;"></select>
                </div>
              </div>
              <div class="col-md-12 col-lg-6 input-field">
                <?= lang('model_manufacturer', 'model_manufacturer'); ?>
                <div class="form-line">
                  <input class="form-control manufacturer_name_typeahead" id="manufacturer_name" name="parent_id" required="" style="width: 100%;">
                </div>
              </div>
            </div>
          </form>
      </div>
      <div class="modal-footer" id="model_footer">
        <!--    -->
      </div>
    </div>
  </div>
</div>


<!-- ============= MODAL View CLient ============= -->
<div class="modal fade" id="view_client" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <div id="titoloclienti"></div>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12 col-lg-6 bio-row">
              <p><span class="bold"><i class="fa fa-user"></i> <?= lang('client_name'); ?> </span><span id="v_name"></span></p>
            </div>
            <div class="col-md-12 col-lg-6 bio-row">
              <p><span class="bold"><i class="fa fa-user"></i> <?= lang('client_company'); ?> </span><span id="v_company"></span></p>
            </div>
            <div class="col-md-12 col-lg-6 bio-row">
              <p><span class="bold"><i class="fa fa-road"></i> <?= lang('client_address'); ?></span><span id="v_address"></span></p>
            </div>
            <div class="col-md-12 col-lg-6 bio-row">
              <p><span class="bold"><i class="fa fa-globe"></i><?= lang('client_city'); ?></span><span id="v_city"></span></p>
            </div>
            <div class="col-md-12 col-lg-6 bio-row">
              <p>
                <span class="bold">
                <i class="fa fa-globe"></i>
                <?= lang('client_postal_code'); ?>
                </span>
                <span id="v_postal_code"></span>
              </p>
            </div>
            <div class="col-md-12 col-lg-6 bio-row">
              <p><span class="bold"><i class="fa fa-phone"></i> <?= lang('client_telephone'); ?> </span><span id="v_telephone"></span></p>
            </div>
            <div class="col-md-12 col-lg-6 bio-row">
              <p><span class="bold"><i class="fa fa-envelope"></i> <?= lang('client_email'); ?> </span><span id="v_email"></span></p>
            </div>
            <div class="col-md-12 col-lg-6 bio-row">
              <p><span class="bold"><i class="fa fa-barcode"></i> <?= lang('client_vat'); ?> </span><span id="v_vat"></span></p>
            </div>
            <div class="col-md-12 col-lg-6 bio-row">
              <p><span class="bold"><i class="fa fa-quote-left"></i> <?= lang('client_ssn'); ?> </span><span id="v_cf"></span></p>
            </div>
          </div>
          <div class="form-group commenti">
            <label><?= lang('client_comment'); ?></label>
            <textarea class="form-control" id="v_comment" rows="6" disabled></textarea>
          </div>
          <table class="display compact table table-bordered table-striped" id="dynamic-table2">
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
          </table>
        </div>
      </div>
      <div class="modal-footer" id="footerClient"></div>
    </div>
  </div>
</div>
<!-- ============= MODAL MODIFY CLIENTI ============= -->
<div class="modal fade" id="clientmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titclienti"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="client_form" class="col s12" data-parsley-validate">
          <div class="row">
            <div class="col-md-12 col-lg-6 input-field">
              <div class="form-group">
                <?= lang('client_name', 'name1'); ?>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa  fa-user"></i></span>
                  </div>
                  <input id="name1" name="name" type="text" class="validate form-control" required>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6 input-field">
              <div class="form-group">
                <?= lang('client_company', 'company1'); ?>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa  fa-user"></i></span>
                  </div>
                  <input name="company" id="company1" type="text" class="validate form-control">
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6 input-field">
              <div class="form-group">
                <label><?=lang('geolocate');?></label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa  fa-map-marker"></i></span>
                  </div>
                  <div id="locationField">
                    <input id="autocomplete" class="form-control" placeholder="<?=lang('enter_address');?>"
                      onFocus="geolocate()" type="text"></input>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6 input-field">
              <div class="form-group">
                <?= lang('client_address', 'address1'); ?>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa  fa-road"></i></span>
                  </div>
                  <input type="hidden" class="field form-control input-xs" id="street_number">
                  <input type="hidden" class="field form-control input-xs" id="administrative_area_level_1">
                  <input name="address"  id="route" type="text" class="validate form-control input-xs">
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6 input-field">
              <div class="form-group">
                <?= lang('client_city', 'city1'); ?>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa  fa-globe"></i></span>
                  </div>
                  <input name="city" id="locality" type="text" class="validate form-control">
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6 input-field">
              <div class="form-group">
                <?= lang('client_postal_code', 'postal_code'); ?>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa  fa-globe"></i></span>
                  </div>
                  <input name="postal_code" id="postal_code" type="text" class="validate form-control">
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6 input-field">
              <div class="form-group">
                <?= lang('client_telephone', 'telephone'); ?>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa  fa-phone"></i></span>
                  </div>
                  <input id="telephone" name="telephone" type="text" class="validate form-control" data-mask="(999) 999-9999">
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6 input-field">
              <div class="form-group">
                <?= lang('client_email', 'email1'); ?>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa  fa-envelope"></i></span>
                  </div>
                  <input id="email1" name="email" type="email" class="validate form-control">
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6 input-field">
              <div class="form-group">
                <?= lang('client_vat', 'vat1'); ?>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa  fa-envelope"></i></span>
                  </div>
                  <input name="vat" id="vat1" class="validate form-control">
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6 input-field">
              <div class="form-group">
                <?= lang('client_ssn', 'cf1'); ?>
                <div class="input-group mb-3">
                  <input name="vat" id="vat1" class="validate form-control">
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 input-field">
              <div class="form-group">
                <?=lang('client_image_upload', 'image');?>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa  fa-upload"></i></span>
                  </div>
                  <input id="image" type="file" data-browse-label="Browse" name="image" data-show-upload="false" data-show-preview="false" accept="image/*" class="form-control file">
                </div>
              </div>
            </div>
            <div class="col-lg-4 input-field">
              <div id="showIfImage" style="display: none;">
                <button class="btn btn-primary" id="view_image_in" data-num><i class="fa fa-eye"></i></button>
                <button class="btn btn-danger" id="delete_customer_image" data-num><i class="fa fa-trash-o"></i> <?=lang('delete')?></button>
              </div>
            </div>
            <div class="col-md-12 input-field">
              <div class="form-group">
                <?= lang('client_comment', 'comment1'); ?> <i id="add_timestamp" class="fa fa-calendar"></i>
                <textarea class="form-control" id="comment1" name="comment" rows="6"></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer" id="footerClient1"></div>
    </div>
  </div>
</div>

<div class="modal modal-default-filled fade" id="prerepair" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?=lang('pre_repair_checklist');?></h4>
        <button type="button" class="close" id="exit_prepair" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <div class="panel-body">
            <form id="prerepair_form">
          <div class="row">
              <div class="col-md-6">
          <div class="row">

                <?php
                  $repair_custom_toggles = trim($settings->repair_custom_toggles);
                  if ($repair_custom_toggles !== ''):
                      $repair_custom_toggles = explode(',', $repair_custom_toggles);
                      foreach($repair_custom_toggles as $line): ?>

                <div class="col-lg-6">
                  <div class="checkbox-toggle-styled-on-off">
                    <input name="checktoggle_<?= bin2hex($line); ?>" type="hidden" value="0">
                    <input name="checktoggle_<?= bin2hex($line); ?>" id="checktoggle_<?= bin2hex($line); ?>" value="1" type="checkbox">
                    <label for="checktoggle_<?= bin2hex($line); ?>"><?= $line; ?></label>
                  </div>
                </div>
                <?php endforeach; endif;?>
              </div>
              </div>
              <div class="col-md-6">

                

                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link" id="one-tab-default-tab" data-toggle="pill" href="#one-tab-default" role="tab" aria-controls="one-tab-default" aria-selected="true"><?=lang('pin_code');?></a>
                    </li>

                    <li class="nav-item ">
                      <a class="nav-link active" id="one-tab-default-tab" data-toggle="pill" href="#two-tab-default" role="tab" aria-controls="two-tab-default" aria-selected="true"><?=lang('pattern');?></a>
                    </li>

                  </ul>


                
                  <div class="tab-content">
                    <div class="tab-pane" id="one-tab-default">
                      <div class="form-group">
                        <label><?=lang('pin_code');?></label>
                        <input type="text" name="cust_pin_code" class="form-control">
                      </div>
                    </div>
                    <div class="tab-pane active" id="two-tab-default">
                      <div id="patternHolder"></div>
                      <input type="hidden" name="patternlock" id="patternlock">
                    </div>
                  </div>
          </div>
                </div>
              </div>
            </form>
        </div>
      </div>
      <div id="" class="modal-footer">
        <button class="btn btn-submit btn-primary" id="submit_prerepairs"><?=lang('submit');?></button>
      </div>
    </div>
  </div>
</div>

