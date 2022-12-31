

<!-- ============= MODAL MODIFICA supplierI ============= -->
<div class="modal fade" id="smsgatewaymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titsupplieri"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <p class="tips custip"></p>
                        <form class="col s12" id="smsgateway_form" >
                    <div class="row">

                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('smsgateway_name', 'smsgateway_name'); ?>
                                    <input id="smsgateway_name" name="name" type="text" class="validate form-control" required>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('smsgateway_url', 'smsgateway_url'); ?>
                                        <input id="smsgateway_url" name="url" type="text" class="validate form-control" required>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-4 input-field">
                                <div class="form-group">
                                    <?= lang('smsgateway_toname', 'smsgateway_toname'); ?>
                                        <input id="smsgateway_toname" name="to_name" type="text" class="validate form-control" required>
                                </div>
                            </div>


                            <div class="col-md-12 col-lg-4 input-field">
                                <div class="form-group">
                                    <?= lang('smsgateway_messagename', 'smsgateway_messagename'); ?>
                                    <input id="smsgateway_messagename" name="message_name" type="text" class="validate form-control" required>
                                </div>
                            </div>

                            <div class="col-md-12 input-field">
                                <h2><?=lang('additional_post_data');?></h2>
                                <table id="additional_post_data" class="table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="col-md-5"><?=lang('parameter_name');?></th>
                                            <th class="col-md-6"><?=lang('parameter_value');?></th>
                                            <th class="col-md-1"><i class="fa fa-times"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" placeholder="<?=lang('parameter_name');?>" class="form-control" name="postdata[name][]"></td>
                                            <td><input type="text" placeholder="<?=lang('parameter_value');?>" class="form-control" name="postdata[value][]"></td>
                                            <td><i id="remove_field" class="fa fa-times"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>

                                <button class="btn btn-default" id="add_additional_field"><?=lang('add_additional_field');?></button>
                            </div>

                            <div class="col-md-12 col-lg-12 input-field">
                                <div class="form-group">
                                    <?= lang('smsgateway_notes', 'smsgateway_notes'); ?>
                                    <textarea class="form-control" id="smsgateway_notes" name="notes"></textarea>
                                </div>
                            </div>
                </div>
                        </form>
            </div>
            <div class="modal-footer" id="footersmsgateway">
                  <!--    -->
            </div>
        </div>
    </div>
</div>
</div>

<button href="#smsgatewaymodal" class="add_smsgateway btn btn-primary">
    <i class="fa fa-plus-circle"></i> <?= lang('add').' '.lang('sms_gateway'); ?>
</button>
<!-- Main content -->



<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
                <table class="display compact table table-bordered table-striped" id="dynamic-table">
                    <thead>
                        <tr>
                            <th><?= lang('name'); ?></th>
                            <th><?= lang('message'); ?></th>
                            <th><?= lang('actions'); ?></th>
                        </tr>
                    </thead>
            
                    <tfoot>
                        <tr>
                            <th><?= lang('name'); ?></th>
                            <th><?= lang('message'); ?></th>
                            <th><?= lang('actions'); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?=$assets;?>dist/js/page/sms_gateways.js"></script>