

<!-- Main content -->
    <section class="content">

<?=form_open();?>
<div class="card collapsed-card">
      <div class="card-header ui-sortable-handle" style="cursor: move;">
        <h3 class="card-title"><i class="fa-fw fa fa-plus"></i><?= lang('filter_results'); ?></h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body" style="display: none;">
            <div class="form-group row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><?= lang('time_period'); ?></label>
                        <input type="text" name="date" value="<?=set_value('date');?>" class="daterange form-control">
                        <input type="hidden" name="start_date" id="start_date" value="<?=set_value('start_date', date('Y-m-d'));?>">
                        <input type="hidden" name="end_date" id="end_date" value="<?=set_value('end_date', date('Y-m-d'));?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><?= lang('customer'); ?></label>
                        <?php 
                            $m = [];
                            $m[] = lang('please_select');
                            if ($clients){
                                foreach ($clients as $client){
                                    $m[$client->id] = $client->name;
                                }
                            }
                        ?>
                        <?= form_dropdown('client_id', $m, set_value('client_id'), 'class="form-control" style="width:100% !important"'); ?>
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="form-group">
                        <label><?= lang('manufacturer'); ?></label>
                        <?php 
                            $m = [];
                            $m[] = lang('please_select');
                            if ($manufacturers){
                                foreach ($manufacturers as $manufacturer){
                                    $m[$manufacturer->name] = $manufacturer->name;
                                }
                            }
                        ?>
                        <?= form_dropdown('manufacturer', $m, set_value('manufacturer'), 'class="form-control" style="width:100% !important"'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><?= lang('model'); ?></label>
                        <?php 
                            $m = [];
                            $m[] = lang('please_select');
                            if ($models){
                                foreach ($models as $model){
                                    $m[$model->name] = $model->name;
                                }
                            }
                        ?>
                        <?= form_dropdown('model', $m, set_value('model'), 'class="form-control" style="width:100% !important"'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><?= lang('has_warranty'); ?></label>
                        <?php $wm = array('' => lang('please_select'), '1' => lang('in_warranty'), '2' => lang('out_warranty')); ?>
                        <?= form_dropdown('has_warranty', $wm, set_value('has_warranty'), 'class="form-control" style="width:100% !important"'); ?>
                    </div>
                </div>

<div class="col-md-4">
                    <div class="form-group">
                        <label><?= lang('reparation_imei'); ?></label>
                        <?= form_input('imei', set_value('imei'), 'class="form-control" style="width:100% !important"'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><?= lang('reparation_status'); ?></label>
                        <?php 

                            $st[] = lang('please_select');

                            foreach ($statuses as $status){
                            $st[$status->id] = $status->label;
                        }?>
                        <?= form_dropdown('status', $st, set_value('status'), 'class="form-control" style="width:100% !important"'); ?>
                    </div>
                </div>

            </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer" style="display: none;">
                        <input type="submit" value="<?=lang('filter_results');?>" class="btn btn-primary">
      </div>
      <!-- /.card-footer-->
    </div>

        <?=form_close();?>




        <?php if($this->Admin || $GP['repair-add']): ?>
            <button href="#reparationmodal" class="add_reparation btn btn-primary">
                <i class="fa fa-plus-circle"></i> <?= lang('add'); ?> <?= lang('reparation_title'); ?>
            </button>
        <?php endif; ?>


        <a class="pull-right btn btn-primary" href="<?=base_url();?>panel/reparation/export?<?=http_build_query($_POST);?>"><i class="fa fa-file-excel"></i></a> 
        <a class="pull-right btn btn-primary" href="<?=base_url();?>panel/reparation/export/0/1?<?=http_build_query($_POST);?>"><i class="fa fa-file-pdf"></i></a> 

        <br>
        <br>

<div class="card">
  <div class="card-header ui-sortable-handle" style="cursor: move;">
    <h3 class="card-title">
      <i class="fas fa-chart-pie mr-1"></i>
      <?=lang('repair_table');?>
    </h3>
    <div class="card-tools">
      <ul class="nav nav-pills ml-auto">
        <li class="nav-item">
          <a class="nav-link " href="#CompletedRepairs" data-table="completed" data-toggle="tab"><?=lang('completed_repairs');?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#PendingRepairs" data-table="pending" data-toggle="tab"><?=lang('pending_repairs');?></a>
        </li>

         <li class="nav-item dropdown dropleft">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Status</a>
            <div class="dropdown-menu">
                <?php foreach ($statuses as $status): ?>
                    <a data-table="<?=$status->id;?>" data-toggle="tab" class="dropdown-item" href="#"><?=$status->label;?></a>
                <?php endforeach;?>
            </div>
          </li>


      </ul>
    </div>
  </div><!-- /.card-header -->
  <div class="card-body">
    <div class="tab-content p-0">
      <div class="tab-pane active" id="PendingRepairs" style="">
        <div class="table-responsive">
                    
                        <table class="table table-bordered table-sm table-striped" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th><?= lang('id'); ?></th>
                                    <th><?= lang('reparation_code'); ?></th>
                                    <th><?= lang('reparation_name'); ?></th>
                                    <th><?= lang('reparation_imei'); ?></th>
                                    <th><?= lang('client_telephone'); ?></th>
                                    <th><?= lang('reparation_defect'); ?></th>
                                    <th><?= lang('manufacturer'); ?></th>
                                    <th><?= lang('reparation_model'); ?></th>
                                    <th><?= lang('reparation_opened_at'); ?></th>
                                    <th><?= lang('date_closing'); ?></th>
                                    <th><?= lang('reparation_status'); ?></th>
                                    <th><?= lang('assigned_to'); ?></th>
                                    <th><?= lang('added_by'); ?></th>
                                    <th><?= lang('last_modified_by'); ?></th>
                                    <th><?= lang('reparation_attachements_count'); ?></th>
                                    <th><?= lang('grand_total'); ?></th>
                                    <th><?= lang('paid'); ?></th>
                                    <th><?= lang('actions'); ?></th>
                                </tr>
                            </thead>
                    
                            <tfoot>
                                <tr>
                                     <th><?= lang('id'); ?></th>
                                    <th><?= lang('reparation_code'); ?></th>
                                    <th><?= lang('reparation_name'); ?></th>
                                    <th><?= lang('reparation_imei'); ?></th>
                                    <th><?= lang('client_telephone'); ?></th>
                                    <th><?= lang('reparation_defect'); ?></th>
                                    <th><?= lang('manufacturer'); ?></th>
                                    <th><?= lang('reparation_model'); ?></th>
                                    <th><?= lang('reparation_opened_at'); ?></th>
                                    <th><?= lang('date_closing'); ?></th>
                                    <th><?= lang('reparation_status'); ?></th>
                                    <th><?= lang('assigned_to'); ?></th>
                                    <th><?= lang('added_by'); ?></th>
                                    <th><?= lang('last_modified_by'); ?></th>
                                    <th><?= lang('reparation_attachements_count'); ?></th>
                                    <th><?= lang('grand_total'); ?></th>
                                    <th><?= lang('paid'); ?></th>
                                    <th><?= lang('actions'); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

      </div>

    </div>
  </div><!-- /.card-body -->
  </div><!-- /.card-body -->
</div>


<script src="<?=base_url();?>panel/misc/js/reparation"></script>
