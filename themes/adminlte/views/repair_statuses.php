
<div class="row">
  <div class="col-12">
    <div class="card">
<div class="card-header ui-sortable-handle" style="cursor: move;">
	  <h3 class="card-title"><?= lang('repair_statuses'); ?></h3>
	</div>
	<div class="card-body">
	  <ul class="todo-list ui-sortable">
	  	<?php foreach ($statuses as $status): ?>
	  		<li status-id="id_<?= $status->id; ?>">
				<span class="handle ui-sortable-handle">
					<i class="fa fa-ellipsis-v"></i>
					<i class="fa fa-ellipsis-v"></i>
				</span>
		     	<span class="text"><span class="label" style="font-size: 14px;background-color: <?= $status->bg_color; ?>; color: <?= $status->fg_color; ?>"><?= $status->label; ?></span></span>
		      	<div class="tools">
		        	<i data-dismiss="modal" id="modify_status" href="#status_modal" data-toggle="modal" data-num="<?= $status->id; ?>" class="fa fa-edit"></i>
		        	<i id="delete" data-num="<?= $status->id; ?>" class="fas fa-trash"></i>
		      	</div>
			</li>
	  	<?php endforeach; ?>
	  </ul>
	</div>
	<!-- /.box-body -->
	<div class="card-footer clearfix no-border">
	  <button type="button" class="btn btn-default pull-right" id="add_status"><i class="fa fa-plus"></i> <?= lang('add_status'); ?></button>
	</div>
	</div>
</div>
</div>


<!-- ============= MODAL MODIFICA CLIENTI ============= -->
<div class="modal fade" id="status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titrstat"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <p class="tips custip"></p>
                        <form id="status_form" class="col s12">
                    <div class="row">

                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                	<label><?= lang('label'); ?></label>
                                    <input id="label" name="label" type="text" class="validate form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-3 input-field">
                                <div class="form-group">
					                <label><?= lang('bg_color'); ?>:</label>
					                <input type="text" name="bg_color" id="bg_color" class="form-control my-colorpicker1 colorpicker-element" required>
					              </div>
                            </div>
                            <div class="col-md-12 col-lg-3 input-field">
                                <div class="form-group">
					                <label><?= lang('fg_color'); ?></label>
					                <input type="text" name="fg_color" id="fg_color" class="form-control my-colorpicker1 colorpicker-element" required>
					              </div>
                            </div>
	                        <div class="input-field col-lg-12">
	                            <div class="form-group">
				                  <div class="checkbox">
				                    <label>
				                      <input name="send_email" id="send_email" type="checkbox">
				                      <?= lang('send_mail'); ?>
				                    </label>
				                  </div>
				                  <div class="checkbox">
				                    <label>
				                      <input name="send_sms" id="send_sms" type="checkbox">
				                      <?= lang('send_sms'); ?>
				                    </label>
				                  </div>
				                  <div class="checkbox">
				                    <label>
				                      <input name="completed" type="hidden" value="0">
				                      <input name="completed" id="completed_status" type="checkbox" value="1">
				                      <?= lang('mark_as_completed'); ?>
				                    </label>
				                  </div>
				                </div>

	                        </div>

	                        <div style="display: none;" class="email_area input-field col-lg-6">
	                        	<h3><?=lang('email_templating');?></h3>
                                <div class="well">
                                    <dl class="dl-horizontal">
                                      <dt>%businessname% :</dt>
                                      <dd><?= lang('company_name'); ?></dd>

                                      <dt>%model% :</dt>
                                      <dd><?= lang('device_model'); ?></dd>

                                      <dt>%customer% :</dt>
                                      <dd><?= lang('client_name'); ?></dd>

                                      <dt>%site_url% :</dt>
                                      <dd><?= lang('hosted_url'); ?></dd>

                                      <dt>%statuscode% :</dt>
                                      <dd><?= lang('reparation_code'); ?></dd>

                                      <dt>%businesscontact% :</dt>
                                      <dd><?= lang('company_contact'); ?></dd>

                                      <dt>%id% :</dt>
                                      <dd><?= lang('rID'); ?></dd>
                                    </dl>
                                </div>
                                <div class="form-group">
	                            	<label><?= lang('email_subject');?></label>
	                            	<input type="text" name="email_subject" id="email_subject" class="form-control">
	                            </div>
	                            <div class="form-group">
	                            	<label><?= lang('email_text');?></label>
	                                <textarea class="form-control summernote" name="email_text" id="email_text" rows="6"></textarea>
	                            </div>
	                        </div>
	                        <div style="display: none;" class="sms_area input-field col-lg-6">
	                        	<div class="col-lg-12">
		                            <h3><?=lang('sms_templating');?></h3>
		                            <div class="well">
                                    <dl class="dl-horizontal">
	                                      <dt>%businessname% :</dt>
	                                      <dd><?= lang('company_name'); ?></dd>

	                                      <dt>%model% :</dt>
	                                      <dd><?= lang('device_model'); ?></dd>

	                                      <dt>%customer% :</dt>
	                                      <dd><?= lang('client_name'); ?></dd>

	                                      <dt>%site_url% :</dt>
	                                      <dd><?= lang('hosted_url'); ?></dd>

	                                      <dt>%statuscode% :</dt>
	                                      <dd><?= lang('reparation_code'); ?></dd>

	                                      <dt>%id% :</dt>
	                                      <dd><?= lang('rID'); ?></dd>
	                                    </dl>
	                                </div>
		                        </div>
	                            <div class="form-group">
	                            	<label><?= lang('sms_text');?></label>
	                                <textarea class="form-control" name="sms_text" id="sms_text" rows="6"></textarea>
	                            </div>
	                        </div>
                </div>
                        </form>
            </div>
            <div class="modal-footer" id="footerrStat">
                  <!--    -->
            </div>
        </div>
    </div>
</div>
</div>
