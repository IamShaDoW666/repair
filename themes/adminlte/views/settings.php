<?php
$wm = array('0' => lang('no'), '1' => lang('yes'));
$ps = array('0' => lang("disable"), '1' => lang("enable"));
?>

<div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">



                  <li class="nav-item">
                    <a class="nav-link" id="general_" data-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="false"><?= lang('general_settings_title'); ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="orders_" data-toggle="pill" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><?= lang('reparation'); ?></a>
                  </li>
                    <li class="nav-item">
                    <a class="nav-link" id="invoice_" data-toggle="pill" href="#invoice" role="tab" aria-controls="invoice" aria-selected="false"><?= lang('invoice_title'); ?></a>
                  </li>

                    
                    <li class="nav-item">
                    <a class="nav-link" id="sms_" data-toggle="pill" href="#sms" role="tab" aria-controls="sms" aria-selected="false"><?= lang('sms_title'); ?></a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" id="appearance_" data-toggle="pill" href="#appearance" role="tab" aria-controls="appearance" aria-selected="false"><?= lang('appearance'); ?></a>
                  </li>



                 
                </ul>
              </div>
              <div class="card-body">
                  <form id="settings_form">

                    <div class="tab-content" id="">
                            <div role="tabpanel" class="tab-pane" id="appearance">
                               <h3><?=lang('appearance'); ?></h3>
                               <div class="col-lg-12">
                                  <div class="row">
                                     <div class="col-md-4">
                                        <div class="form-group">
                                           <label class=""><?= lang("use_appearance"); ?></label>
                                           <div class="controls"> <?php
                                              echo form_dropdown('use_dark_theme', $wm, $settings->use_dark_theme, 'class="form-control tip" id="use_dark_theme"  style="width:100%;" required="required"');
                                              ?>
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                           <label class="control-label"><?= lang("use_topbar"); ?></label>
                                           <div class="controls"> <?php
                                              echo form_dropdown('use_topbar', $wm, $settings->use_topbar, 'class="form-control tip" id="use_topbar"  style="width:100%;" required="required"');
                                              ?>
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                           <label class="control-label"><?= lang("body_font"); ?></label>
                                           <div class="controls"> <?php
                                              $body_font = array(13 => "13px", 14 => "14px", 15 => '15px');
                                              echo form_dropdown('body_font', $body_font, $settings->body_font, 'class="form-control tip" id="body_font"  style="width:100%;" required="required"');
                                              ?>
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-lg-4">
                                        <div class="form-group">
                                           <label class="control-label"><?=lang('appearance_bg');?></label>
                                           <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                              <input type="text" name="bg_color" class="form-control input-lg"  value="<?=set_value('bg_color', $settings->bg_color);?>"/>
                                              <span class="input-group-addon"><i></i></span>
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-lg-4">
                                        <div class="form-group">
                                           <label><?=lang('appearance_header');?></label>
                                           <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                              <input type="text" name="header_color" class="form-control input-lg"  value="<?=set_value('header_color', $settings->header_color);?>"/>
                                              <span class="input-group-addon"><i></i></span>
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-lg-4">
                                        <div class="form-group">
                                           <label><?=lang('appearance_menu');?></label>
                                           <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                              <input type="text" name="menu_color" class="form-control input-lg"  value="<?=set_value('menu_color', $settings->menu_color);?>"/>
                                              <span class="input-group-addon"><i></i></span>
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-lg-4">
                                        <div class="form-group">
                                           <label><?=lang('appearance_menu_Active');?></label>
                                           <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                              <input type="text" name="menu_active_color" class="form-control input-lg"  value="<?=set_value('menu_active_color', $settings->menu_active_color);?>"/>
                                              <span class="input-group-addon"><i></i></span>
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-lg-4">
                                        <div class="form-group">
                                           <label><?=lang('menu_text_color');?></label>
                                           <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                              <input type="text" name="menu_text_color" class="form-control input-lg"  value="<?=set_value('menu_text_color', $settings->menu_text_color);?>"/>
                                              <span class="input-group-addon"><i></i></span>
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-lg-4">
                                        <div class="form-group">
                                           <label><?=lang('mmenu_text_color');?></label>
                                           <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                              <input type="text" name="mmenu_text_color" class="form-control input-lg"  value="<?=set_value('mmenu_text_color', $settings->mmenu_text_color);?>"/>
                                              <span class="input-group-addon"><i></i></span>
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-lg-4">
                                        <div class="form-group">
                                           <label><?=lang('bg_text_color');?></label>
                                           <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                              <input type="text" name="bg_text_color" class="form-control input-lg"  value="<?=set_value('bg_text_color', $settings->bg_text_color);?>"/>
                                              <span class="input-group-addon"><i></i></span>
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-lg-4">
                                        <div class="form-group">
                                           <label><?=lang('invoice_table_color');?></label>
                                           <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                              <input type="text" name="invoice_table_color" class="form-control input-lg"  value="<?=set_value('invoice_table_color', $settings->invoice_table_color);?>"/>
                                              <span class="input-group-addon"><i></i></span>
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-lg-4">
                                        <div class="form-group">
                                           <label><?=lang('warranty_ribbon_color');?></label>
                                           <div class="input-group colorpicker-component my-colorpicker1" title="Using horizontal option">
                                              <input type="text" name="warranty_ribbon_color" class="form-control input-lg"  value="<?=set_value('warranty_ribbon_color', $settings->warranty_ribbon_color);?>"/>
                                              <span class="input-group-addon"><i></i></span>
                                           </div>
                                        </div>
                                     </div>
                                  </div>
                               </div>
                            </div>

                            <?php $hide_repair_fields = json_decode($settings->hide_repair_fields);?>
                            <div role="tabpanel" class="tab-pane" id="orders">
                               <h3><?=lang('hide_fields'); ?></h3>
                               <table class="table">
                                 <thead>
                                   <tr>
                                     <th>Field</th>
                                     <th>Enable ?</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                   <tr>
                                     <td><?=lang('expected_close_date');?></td>
                                     <td>
                                        <input type="hidden" value="0" name="hide_repair_fields[expected_close_date]">
                                       <div class="icheck-primary d-inline">
                                        <input type="checkbox" value="1" id="hide_repair_fields_expected_close_date" name="hide_repair_fields[expected_close_date]" <?= @$hide_repair_fields->expected_close_date ? 'checked' : '' ;?>>
                                        <label for="hide_repair_fields_expected_close_date"></label>
                                      </div>
                                    </td>
                                   </tr>
                                   <tr>
                                     <td><?=lang('error_code');?></td>
                                     <td>
                                        <input type="hidden" value="0" name="hide_repair_fields[error_code]">
                                       <div class="icheck-primary d-inline">
                                        <input type="checkbox" value="1" id="hide_repair_fields_error_code" name="hide_repair_fields[error_code]" <?= @$hide_repair_fields->error_code ? 'checked' : '' ;?>>
                                        <label for="hide_repair_fields_error_code"></label>
                                      </div>
                                    </td>
                                   </tr>

                                   <tr>
                                     <td><?=lang('date_of_purchase');?></td>
                                     <td>
                                        <input type="hidden" value="0" name="hide_repair_fields[date_of_purchase]">
                                       <div class="icheck-primary d-inline">
                                        <input type="checkbox" value="1" id="hide_repair_fields_date_of_purchase" name="hide_repair_fields[date_of_purchase]" <?= @$hide_repair_fields->date_of_purchase ? 'checked' : '' ;?>>
                                        <label for="hide_repair_fields_date_of_purchase"></label>
                                      </div>
                                    </td>
                                   </tr>

                                   <tr>
                                     <td><?=lang('has_warranty');?></td>
                                     <td>
                                        <input type="hidden" value="0" name="hide_repair_fields[has_warranty]">
                                       <div class="icheck-primary d-inline">
                                        <input type="checkbox" value="1" id="hide_repair_fields_has_warranty" name="hide_repair_fields[has_warranty]" <?= @$hide_repair_fields->has_warranty ? 'checked' : '' ;?>>
                                        <label for="hide_repair_fields_has_warranty"></label>
                                      </div>
                                    </td>
                                   </tr>
                                   <tr>
                                     <td><?=lang('warranty');?></td>
                                     <td>
                                        <input type="hidden" value="0" name="hide_repair_fields[warranty]">
                                       <div class="icheck-primary d-inline">
                                        <input type="checkbox" value="1" id="hide_repair_fields_warranty" name="hide_repair_fields[warranty]" <?= @$hide_repair_fields->warranty ? 'checked' : '' ;?>>
                                        <label for="hide_repair_fields_warranty"></label>
                                      </div>
                                    </td>
                                   </tr>
                                   <tr>
                                     <td><?=lang('warranty_card_number');?></td>
                                     <td>
                                        <input type="hidden" value="0" name="hide_repair_fields[warranty_card_number]">
                                       <div class="icheck-primary d-inline">
                                        <input type="checkbox" value="1" id="hide_repair_fields_warranty_card_number" name="hide_repair_fields[warranty_card_number]" <?= @$hide_repair_fields->warranty_card_number ? 'checked' : '' ;?>>
                                        <label for="hide_repair_fields_warranty_card_number"></label>
                                      </div>
                                    </td>
                                   </tr>
                                    <tr>
                                     <td><?=lang('repair_type');?></td>
                                     <td>
                                        <input type="hidden" value="0" name="hide_repair_fields[repair_type]">
                                       <div class="icheck-primary d-inline">
                                        <input type="checkbox" value="1" id="hide_repair_fields_repair_type" name="hide_repair_fields[repair_type]" <?= @$hide_repair_fields->repair_type ? 'checked' : '' ;?>>
                                        <label for="hide_repair_fields_repair_type"></label>
                                      </div>
                                    </td>
                                   </tr>
                                   <tr>
                                     <td><?=lang('client_date');?></td>
                                     <td>
                                        <input type="hidden" value="0" name="hide_repair_fields[client_date]">
                                       <div class="icheck-primary d-inline">
                                        <input type="checkbox" value="1" id="hide_repair_fields_client_date" name="hide_repair_fields[client_date]" <?= @$hide_repair_fields->client_date ? 'checked' : '' ;?>>
                                        <label for="hide_repair_fields_client_date"></label>
                                      </div>
                                    </td>
                                   </tr>


                                 </tbody>
                               </table>

                               <h3><?=lang('reparation'); ?></h3>
                               <div class="row"> 
                               <div class="col-lg-4">
                                  <div class="form-group">
                                     <?=lang('open_report_on_repair_add', 'open_report_on_repair_add');?>
                                     <?= form_dropdown('open_report_on_repair_add', [0=>lang('disable'), 2=>lang('report'),  1=>lang('invoice')], $settings->open_report_on_repair_add, 'class="form-control m-bot15" style="width: 100%"'); ?>
                                  </div>
                               </div>
                               <div class="col-lg-12">
                                  <div class="form-group">
                                     <?=lang('categories', 'category');?>
                                     <select id="category" name="category[]" class="form-control m-bot15 select2-hidden-accessible" multiple="" width="100%" tabindex="-1" aria-hidden="true" style="width: 100%">
                                     <?php
                                        foreach(explode(",", $settings->category) as $line){
                                            if($line){
                                                echo '<option data-select2-tag="true" selected value="'.$line.'">'.$line.'</option>';
                                            }
                                        } 
                                        ?>
                                     </select>
                                  </div>
                               </div>
                               <div class="col-lg-12">
                                  <div class="form-group">
                                     <?=lang('repair_custom_toggles', 'repair_custom_toggles');?>
                                     <select id="repair_custom_toggles" name="repair_custom_toggles[]" class="form-control m-bot15 select2-hidden-accessible" multiple="" width="100%" tabindex="-1" aria-hidden="true" style="width: 100%">
                                     <?php
                                        foreach(explode(",", $settings->repair_custom_toggles) as $line){
                                            if($line){
                                                echo '<option data-select2-tag="true" selected value="'.$line.'">'.$line.'</option>';
                                            }
                                        } 
                                        ?>
                                     </select>
                                  </div>
                               </div>
                               <div class="col-lg-12">
                                  <div class="form-group">
                                     <?=lang('custom_fields', 'custom_fields');?>
                                     <select id="custom_fields" name="custom_fields[]" class="form-control m-bot15 select2-hidden-accessible" multiple="" width="100%" tabindex="-1" aria-hidden="true" style="width: 100%">
                                     <?php
                                        foreach(explode(",", $settings->custom_fields) as $line){
                                            if($line){
                                                echo '<option data-select2-tag="true" selected value="'.$line.'">'.$line.'</option>';
                                            }
                                        } 
                                        ?>
                                     </select>
                                  </div>
                               </div>
                               </div>
                            </div>


                            <div role="tabpanel" class="tab-pane" id="invoice">
                               <h3><?=lang('invoice_title');?></h3>
                                  <div class="row">

                               <div class="col-lg-6">
                                  <div class="row">
                                     <div class="col-lg-6">
                                        <div class="form-group">
                                           <?=lang('invoice_name', 'invoice_name');?>


                                            <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa  fa-user"></i></span>
                                              </div>

                                              <input name="invoice_name" id="invoice_name" type="text" class="validate form-control" value="<?= $settings->invoice_name; ?>">
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-lg-6">
                                        <div class="form-group">
                                           <?=lang('invoice_email', 'invoice_mail');?>
                                          <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa  fa-envelope"></i></span>
                                              </div>
                                              <input name="invoice_mail" id="invoice_mail" type="text" class="validate form-control" value="<?= $settings->invoice_mail; ?>">
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-lg-12">

                                        <div class="form-group">
                                             <?=lang('invoice_address', 'invoice_address');?>
                                             <textarea class="form-control summernote" id="invoice_address" name="invoice_address" style="height: 107px" rows="6" ><?= $settings->address; ?>
</textarea>
                                        </div>


                                     </div>
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="row">
                                     <div class="col-lg-12">
                                        <div class="form-group">
                                           <?=lang('invoice_phone', 'invoice_phone');?>
                                           <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa  fa-phone"></i></span>
                                              </div>
                                              <input id="invoice_phone" name="invoice_phone" type="text" class="validate form-control" value="<?= $settings->phone; ?>">
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-lg-12">
                                        <div class="form-group">
                                           <?=lang('invoice_vat', 'invoice_vat');?>
                                           <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa  fa-certificate"></i></span>
                                              </div>
                                              <input id="invoice_vat" name="invoice_vat" type="text" class="validate form-control" value="<?= $settings->vat; ?>">
                                           </div>
                                        </div>
                                     </div>
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="form-group">
                                     <?=lang('invoice_disclaimer', 'disclaimer');?>
                                     <textarea class="form-control summernote" id="disclaimer" name="disclaimer" style="height: 107px" rows="6"><?= $settings->disclaimer; ?></textarea>
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="form-group">
                                     <?=lang('sale_email_text', 'sale_email_text');?>
                                     <textarea class="form-control summernote" id="sale_email_text" name="sale_email_text" style="height: 107px" rows="6"><?= $settings->sale_email_text; ?></textarea>
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="form-group">
                                     <?=lang('email_footer', 'email_footer');?>
                                     <textarea class="form-control summernote" id="email_footer" name="email_footer" style="height: 107px" rows="6"><?= $settings->email_footer; ?></textarea>
                                  </div>
                               </div>
                               <div class="col-lg-6">
                                  <div class="form-group">
                                     <?=lang('invoice_email_text', 'invoice_email_text');?>
                                     <textarea class="form-control summernote" id="invoice_email_text" name="invoice_email_text" style="height: 107px" rows="6"><?= $settings->invoice_email_text; ?></textarea>
                                  </div>
                               </div>
                            </div>
                            </div>


                            <div role="tabpanel" class="tab-pane" id="sms">
                               <h3><?= $this->lang->line('sms_title');?></h3>
                                <div class="row">
                               <div class="col-lg-3 nexmo-info radio-sms" <?php if($settings->usesms == 1 ) echo 'style="opacity: 1;"'; ?>>
                                  <label>
                                  <input type="radio" id="nexmo" name="usesms" value="1" <?php if($settings->usesms == 1 ) echo 'checked'; ?> />
                                  <img style="width: 48%" src="<?= site_url(); ?>assets/images/nexmo.png">
                                  </label>
                                  <div class="form-group">
                                     <label class="title">
                                     <?=lang('nexmo');?>
                                     </label>
                                     <input name="n_api_key" id="n_api_key" type="text" class="validate form-control" placeholder="Nexmo <?=lang('api_key')?>" value="<?= $settings->nexmo_api_key ?>">
                                     <input name="n_api_secret" id="n_api_secret" type="text" class="validate form-control" placeholder="Nexmo <?=lang('api_secret')?>" value="<?= $settings->nexmo_api_secret ?>">
                                     <input name="sms_caller_id" id="sms_caller_id" type="text" class="validate form-control" placeholder="<?=lang('sms_caller_id');?>" value="<?= $settings->sms_caller_id; ?>">
                                  </div>
                               </div>
                               <div class="col-lg-3 twilio-info radio-sms" <?php if($settings->usesms == 2 ) echo 'style="opacity: 1;"'; ?>>
                                  <label>
                                  <input type="radio" id="twilio" name="usesms" value="2" <?php if($settings->usesms == 2 ) echo 'checked'; ?> />
                                  <img style="width: 48%" src="<?= site_url(); ?>assets/images/twilio.jpg">
                                  </label>
                                  <div class="form-group">
                                     <label class="title">
                                     <?=lang('twilio');?>
                                     </label>
                                     <select name="t_mode" id="t_mode" data-num="1" class="form-control m-bot15" style="width: 100%">
                                        <option <?php if($settings->twilio_mode == 'sandbox' ) echo 'selected'; ?>>sandbox</option>
                                        <option <?php if($settings->twilio_mode == 'prod' ) echo 'selected'; ?>>prod</option>
                                     </select>
                                     <input name="t_account_sid" id="t_account_sid" type="text" class="validate form-control" placeholder="<?=lang('sid');?>" value="<?= $settings->twilio_account_sid; ?>">
                                     <input name="t_token" id="t_token" type="text" class="validate form-control" placeholder="<?=lang('token');?>" value="<?= $settings->twilio_auth_token; ?>">
                                     <input name="t_number" id="t_number" type="text" class="validate form-control" placeholder="Twilio <?=lang('number');?>" value="<?= $settings->twilio_number; ?>">
                                  </div>
                               </div>
                               <div class="col-lg-3 smsgateway-info radio-sms" <?php if($settings->usesms == 3 ) echo 'style="opacity: 1;"'; ?>>
                                  <label>
                                  <input type="radio" id="smsgateway" name="usesms" value="3" <?php if($settings->usesms == 3 ) echo 'checked'; ?> />
                                  <img style="width: 48%" src="<?= site_url(); ?>assets/images/smsgateway.jpg">
                                  </label>
                                  <div class="form-group">
                                     <label class="title">
                                     <?=lang('smsgateway');?>
                                     </label>
                                     <input name="smsgateway_device_id" id="device_id" type="text" class="validate form-control" placeholder="<?=lang('smsgateway_device_id');?>" value="<?= $settings->smsgateway_device_id; ?>">
                                     <input name="smsgateway_token" id="token" type="text" class="validate form-control" placeholder="<?=lang('smsgateway_token');?>" value="<?= $settings->smsgateway_token; ?>">
                                  </div>
                               </div>
                               <div class="col-lg-3 http_api-info radio-sms" <?php if($settings->usesms == 4 ) echo 'style="opacity: 1;"'; ?>>
                                  <label>
                                  <input type="radio" id="http_api" name="usesms" value="4" <?php if($settings->usesms == 4 ) echo 'checked'; ?> />
                                  <img style="width: 48%" src="<?= site_url(); ?>assets/images/http_api.png">
                                  </label>
                                  <div class="form-group">
                                     <label class="title">
                                     <?=lang('http_api');?>
                                     </label>
                                     <?=form_dropdown('default_http_api', $this->settings_model->getSMSGatewaysDP(), $settings->default_http_api, 'style="width:100%;"');?>
                                  </div>
                               </div>

                               <div class="col-lg-3 message-bird-info radio-sms" <?php if($settings->usesms == 5 ) echo 'style="opacity: 1;"'; ?>>
                                  <label>
                                  <input type="radio" id="message-bird" name="usesms" value="5" <?php if($settings->usesms == 5 ) echo 'checked'; ?> />
                                  <img style="width: 48%" src="<?= site_url(); ?>assets/images/message-bird.png">
                                  </label>
                                  <div class="form-group">
                                     <label class="title">
                                        <?=lang('message_bird');?>
                                     </label>
                                     <input name="message_bird_access_key" id="message_bird_access_key" type="text" class="validate form-control" placeholder="<?=lang('message_bird_access_key');?>" value="<?= $settings->message_bird_access_key; ?>">
                                  </div>
                               </div>
                           </div>
                            <div class="row">

                  

                                <div class="col-lg-12">

                                      <fieldset class="scheduler-border">
                        <legend class="scheduler-border"><?= lang('email') ?></legend>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="protocol"><?= lang('email_protocol'); ?></label>

                                <div class="controls"> <?php
                                    $popt = ['mail' => 'PHP Mail Function', 'sendmail' => 'Send Mail', 'smtp' => 'SMTP',  'mailchimp' => 'mailchimp transactional'];
                                    echo form_dropdown('protocol', $popt, $settings->protocol, 'class="form-control tip skip" id="protocol"  style="width:100%;" required="required"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row" id="sendmail_config" style="display: none;">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="mailpath"><?= lang('mailpath'); ?></label>

                                        <?= form_input('mailpath', $settings->mailpath, 'class="form-control tip" id="mailpath"'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row" id="mailchimp_config" style="display: none;">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="mailchimp_api_key"><?= lang('mailchimp_api_key'); ?></label>

                                        <?= form_input('mailchimp_api_key', $settings->mailchimp_api_key, 'class="form-control tip" id="mailchimp_api_key"'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row" id="smtp_config" style="display: none;">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="smtp_host"><?= lang('smtp_host'); ?></label>

                                        <?= form_input('smtp_host', $settings->smtp_host, 'class="form-control tip" id="smtp_host"'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="smtp_user"><?= lang('smtp_user'); ?></label>

                                        <?= form_input('smtp_user', $settings->smtp_user, 'class="form-control tip" id="smtp_user"'); ?> </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="smtp_pass"><?= lang('smtp_pass'); ?></label>

                                        <?= form_password('smtp_pass', $settings->smtp_pass, 'class="form-control tip" id="smtp_pass"'); ?> </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="smtp_port"><?= lang('smtp_port'); ?></label>

                                        <?= form_input('smtp_port', $settings->smtp_port, 'class="form-control tip" id="smtp_port"'); ?> </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"
                                               for="smtp_crypto"><?= lang('smtp_crypto'); ?></label>

                                        <div class="controls"> <?php
                                            $crypto_opt = ['' => lang('none'), 'tls' => 'TLS', 'ssl' => 'SSL'];
                                            echo form_dropdown('smtp_crypto', $crypto_opt, $settings->smtp_crypto, 'class="form-control tip" id="smtp_crypto"');
                                            ?> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>


                                </div>  
                               </div>
                               </div>


                            <div role="tabpanel" class="tab-pane active" id="general">
                               <h3><?=lang('general_settings_title');?></h3>
                               <div class="row">
                               <div class="col-lg-12">
                                  <div class="form-group">
                                     <?=lang('company_title', 'title');?>
                                      <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa  fa-quote-left"></i></span>
                                          </div>
                                        <input id="title" name="title" type="text" class="validate form-control" value="<?= $settings->title; ?>">
                                     </div>
                                  </div>
                               </div>
                               <div class="col-lg-4">
                                  <div class="form-group">
                                     <?=lang('language', 'language');?>
                                     <?php $scanned_lang_dir = array_map(function ($path) {
                                        return basename($path);
                                        }, glob(APPPATH . 'language/*', GLOB_ONLYDIR));
                                        ?>
                                     <select id="language" name="language" data-num="1" class="form-control m-bot15" style="width: 100%">
                                        <?php foreach ($scanned_lang_dir as $dir):
                                           $language = basename($dir); ?>
                                        <option value="<?= $language; ?>" <?= ($language == $settings->language) ? 'selected' : '' ?>><?= $language; ?></option>
                                        <?php endforeach; ?>
                                     </select>
                                  </div>
                               </div>
                               <div class="col-lg-4">
                                  <div class="form-group">
                                     <?=lang('currency', 'currency');?>
                                     <input id="currency" name="currency" type="text" class="validate form-control" value="site.settings.currency">
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="control-label" for="product_discount"><?= lang("product_level_discount"); ?></label>
                                     <div class="controls">
                                        <?php
                                           echo form_dropdown('product_discount', $ps, $settings->product_discount, 'id="product_discount" class="form-control tip" required="required" style="width:100%;"');
                                           ?>
                                     </div>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="control-label"
                                        for="purchase_prefix"><?= lang("purchase_prefix"); ?></label>
                                     <?= form_input('purchase_prefix', $settings->purchase_prefix, 'class="form-control tip" id="purchase_prefix"'); ?>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="control-label"
                                        for="reference_format"><?= lang("reference_format"); ?></label>
                                     <div class="controls">
                                        <?php
                                           $ref = array(1 => lang('prefix_year_no'), 2 => lang('prefix_month_year_no'), 3 => lang('sequence_number'));
                                           echo form_dropdown('reference_format', $ref, $settings->reference_format, 'class="form-control tip" required="required" id="reference_format" style="width:100%;"');
                                           ?>
                                     </div>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="control-label" for="decimals"><?= lang("decimals"); ?></label>
                                     <div class="controls"> <?php
                                        $decimals = array(0 => lang('disable'), 1 => '1', 2 => '2', 3 => '3', 4 => '4');
                                        echo form_dropdown('decimals', $decimals, $settings->decimals, 'class="form-control tip" id="decimals"  style="width:100%;" required="required"');
                                        ?>
                                     </div>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="control-label" for="qty_decimals"><?= lang("qty_decimals"); ?></label>
                                     <div class="controls"> <?php
                                        $qty_decimals = array(0 => lang('disable'), 1 => '1', 2 => '2', 3 => '3', 4 => '4');
                                        echo form_dropdown('qty_decimals', $qty_decimals, $settings->qty_decimals, 'class="form-control tip" id="qty_decimals"  style="width:100%;" required="required"');
                                        ?>
                                     </div>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <?= lang("product_tax", "tax_rate"); ?>
                                     <?php $tr['0'] = lang("disable");
                                        foreach ($tax_rates as $rate) {
                                            $tr[$rate['id']] = $rate['name'];
                                        }
                                        echo form_dropdown('tax_rate', $tr, $settings->default_tax_rate, 'class="form-control tip" id="tax_rate" required="required" style="width:100%;"');
                                        ?>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <?= lang("invoice_tax", "tax_rate2"); ?>
                                     <?php $tr['0'] = lang("disable");
                                        foreach ($tax_rates as $rate) {
                                            $tr[$rate['id']] = $rate['name'];
                                        }
                                        echo form_dropdown('tax_rate2', $tr, $settings->default_tax_rate2, 'id="tax_rate2" class="form-control tip" required="required" style="width:100%;"'); ?>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <?= lang('update_cost_with_purchase', 'update_cost'); ?>
                                     <?= form_dropdown('update_cost', $wm, $settings->update_cost, 'class="form-control" id="update_cost" required="required"'); ?>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="control-label" for="bc_fix"><?= lang("bc_fix"); ?></label>
                                     <?= form_input('bc_fix', $settings->bc_fix, 'class="form-control tip" required="required" id="bc_fix"'); ?>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="control-label" for="disable_editing"><?= lang("disable_editing"); ?></label>
                                     <?= form_input('disable_editing', $settings->disable_editing, 'class="form-control tip" id="disable_editing" required="required"'); ?>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="control-label" for="model_based_search"><?= lang("model_based_search"); ?></label>
                                     <?= form_dropdown('model_based_search', $wm, $settings->model_based_search, 'class="form-control" id="model_based_search" required="required"'); ?>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="control-label" for="image_size"><?= lang("image_size"); ?> (Width :
                                     Height) *</label>
                                     <div class="row">
                                        <div class="col-xs-6">
                                           <?= form_input('iwidth', $settings->iwidth, 'class="form-control tip" id="iwidth" placeholder="image width" required="required"'); ?>
                                        </div>
                                        <div class="col-xs-6">
                                           <?= form_input('iheight', $settings->iheight, 'class="form-control tip" id="iheight" placeholder="image height" required="required"'); ?>
                                        </div>
                                     </div>
                                     <div class="clearfix"></div>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="control-label" for="thumbnail_size"><?= lang("thumbnail_size"); ?>
                                     (Width : Height) *</label>
                                     <div class="row">
                                        <div class="col-xs-6">
                                           <?= form_input('twidth', $settings->twidth, 'class="form-control tip" id="twidth" data-parsley-type="number" placeholder="thumbnail width" required="required"'); ?>
                                        </div>
                                        <div class="col-xs-6">
                                           <?= form_input('theight', $settings->theight, 'class="form-control tip" id="theight" data-parsley-type="number" placeholder="thumbnail height" required="required"'); ?>
                                        </div>
                                     </div>
                                     <div class="clearfix"></div>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <?= lang('watermark', 'watermark'); ?>
                                     <?php
                                        echo form_dropdown('watermark', $wm, (isset($_POST['watermark']) ? $_POST['watermark'] : $settings->watermark), 'class="tip form-control" required="required" id="watermark" style="width:100%;"');
                                        ?>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <?php
                                        $rows_per_page = array(
                                            -1 => "All",
                                            10 => "10",
                                            25 => "25",
                                            50 => "50",
                                            100 => "100",
                                        ); 
                                        
                                        ?>
                                     <label class="control-label" for="rows_per_page"><?= lang("rows_per_page"); ?></label>
                                     <?= form_dropdown('rows_per_page', $rows_per_page,$settings->rows_per_page, 'class="form-control tip" id="rows_per_page" required="required"'); ?>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <?= lang('enable_overselling', 'enable_overselling'); ?>
                                     <?= form_dropdown('enable_overselling', $wm, $settings->enable_overselling, 'class="form-control" id="enable_overselling" required="required"'); ?>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <?= lang('enable_recaptcha', 'enable_recaptcha'); ?>
                                     <?= form_dropdown('enable_recaptcha', $wm, $settings->enable_recaptcha, 'class="form-control" id="enable_recaptcha" required="required"'); ?>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <?=lang('google_site_key', 'google_site_key');?>
                                     <input name="google_site_key" id="google_site_key" type="text" class="validate form-control" value="<?= $settings->google_site_key; ?>">
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <?=lang('google_secret_key', 'google_secret_key');?>
                                     <input name="google_secret_key" id="google_secret_key" type="text" class="validate form-control" value="<?= $settings->google_secret_key; ?>">
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <?=lang('google_api_key', 'google_api_key');?>
                                     <input name="google_api_key" id="google_api_key" type="text" class="validate form-control" value="<?= $settings->google_api_key; ?>">
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="form-group">
                                     <label class="control-label" for="dateformat"><?php echo lang('dateformat'); ?></label>
                                     <div class="controls">
                                        <?php
                                           foreach ($date_formats as $date_format) {
                                               $dt[$date_format->id] = $date_format->js;
                                           }
                                           echo form_dropdown('dateformat', $dt, $settings->dateformat, 'id="dateformat" class="form-control tip" style="width:100%;" required="required"');
                                           ?>
                                     </div>
                                  </div>
                               </div>
                               <?php 
                                  $templates = array(
                                      1 => lang('BasicTemplate'),
                                      2 => lang('ProTemplate'),
                                      3 => lang('RecieptTemplate'),
                                      4 => lang('minimal_template'),
                                  );
                                  ?>
                               <div class="col-lg-4">
                                  <div class="form-group">
                                     <?=lang('invoice_template', 'invoice_template');?>
                                     <?= form_dropdown('invoice_template', $templates, $settings->invoice_template, 'class="form-control m-bot15" style="width: 100%"'); ?>
                                  </div>
                               </div>
                               <?php 
                                  $templates = array(
                                      1 => lang('BasicTemplate'),
                                      2 => lang('ProTemplate'),
                                      3 => lang('RecieptTemplate'),
                                      4 => lang('minimal_template'),
                                      5 => lang('template5') ? lang('template5') : 'Template 5',
                                  );
                                  ?>
                               <div class="col-lg-4">
                                  <div class="form-group">
                                     <?=lang('report_template', 'report_template');?>
                                     <?= form_dropdown('report_template', $templates, $settings->report_template, 'class="form-control m-bot15" style="width: 100%"'); ?>
                                  </div>
                               </div>
                               <div class="col-lg-4">
                                  <div class="form-group">
                                     <?=lang('show_settings_menu', 'show_settings_menu');?>
                                     <?= form_dropdown('show_settings_menu', $wm, $settings->show_settings_menu, 'class="form-control m-bot15" style="width: 100%"'); ?>
                                  </div>
                               </div>
                               </div>

                            </div>

                            <button id='submit' class='btn btn-success'><i class="fa fa-save"></i>
                                <?= lang('save'); ?>
                            </button>
                       
                    </div>
                 </form>
              </div>
              <!-- /.card -->
            </div>





<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h3> <?= lang('logo_upload_title'); ?> </h3>
        <div class="form-group">
            <div class="col-lg-12 well">
                <img id="preview_logo" width="120px" src="<?= base_url(); ?>assets/uploads/logos/<?= $settings->logo;?>">
            </div>
            <div class="col-lg-12">
                <label id="error_message"></label>
                    <span><?= lang('upload_label'); ?></span>
                <div class="input-group logo_upload">
                    <form name="uploadImage" id="uploadimage" action="<?=site_url('panel/settings/upload_image');?>" method="post" enctype="multipart/form-data">   
                        <input id="logo_upload" type="file" data-browse-label="Browse" name="logo_upload" data-show-upload="false" data-show-preview="false" accept="image/*" class="form-control file">
                        <input type="submit" value="<?= lang('upload_label'); ?>" class="submit" style="display: none;">
                    </form>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>



  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h3> <?= lang('background_upload_title'); ?> </h3>
            <div class="form-group">
                <?php if($settings->background) :?>
                    <div class="col-lg-12 well">
                            <img id="preview_background" width="120px" src="<?= base_url(); ?>assets/uploads/backgrounds/<?= $settings->background;?>">
                    </div>
                <?php endif; ?>

                <div class="col-lg-12">
                        <label id="error_message"></label>
                                <span><?= lang('upload_label'); ?></span>
                        <div class="input-group background_upload">
                                <form name="uploadBackground" id="uploadBackground" action="<?=site_url('panel/settings/upload_background');?>" method="post" enctype="multipart/form-data">
                                        <input id="background_upload" type="file" data-browse-label="Browse" name="background_upload" data-show-upload="false" data-show-preview="false" accept="image/*" class="form-control file">
                                        <input type="submit" value="<?= lang('upload_label'); ?>" class="submit" style="display: none;">
                                </form>
                        </div>
                </div>
            </div>
      </div>
  </div>
