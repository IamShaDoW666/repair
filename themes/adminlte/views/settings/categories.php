<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= form_open('panel/settings/category_actions', 'id="action-form"') ?>
<div class="row">
  <div class="col-12">
    <div class="card">

    <div class="card-header d-flex p-0">
        <h3 class="card-title p-3"><?= lang('categories'); ?></h3>
        <ul class="nav nav-pills ml-auto p-2">
            <li class="dropdown dropleft">
                    <div class="btn-group dropleft" style="list-style-type: none;">
                        <a data-toggle="dropdown" class="dropdown-toggle btn-round btn btn-default" href="#" >
                            <i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i> 
                        </a>
                        <ul class="dropdown-menu  tasks-menus" role="menu" aria-labelledby="dLabel">
                           
                                <a class="dropdown-item" href="<?php echo base_url('panel/settings/add_category'); ?>" data-toggle="modal" data-target="#myModal">
                                    <i class="fas fa-plus"></i> <?= lang('add_category') ?>
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url('panel/settings/import_categories'); ?>" data-toggle="modal" data-target="#myModal">
                                    <i class="fas fa-plus"></i> <?= lang('import_categories') ?>
                                </a>
                            
                            
                                <a class="dropdown-item" href="#" id="excel" data-action="export_excel">
                                    <i class="fas fa-file-excel"></i> <?= lang('export_to_excel') ?>
                                </a>
                            
                            
                                <a class="dropdown-item" href="#" id="excel" data-action="export_pdf">
                                    <i class="fas fa-file-pdf"></i> <?= lang('export_to_pdf') ?>
                                </a>
                            
                            
                                <a class="dropdown-item" href="#" id="delete" data-action="delete">
                                    <i class="fas fa-trash"></i> <?= lang('delete_categories') ?>
                                </a>
                                
                        </ul>
                    </div>
            </li>
        </ul>
    </div>
      <div class="card-body">
 <!-- Single button -->
                    
                            <table id="CategoryTable" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th style="min-width:30px; width: 30px; text-align: center;">
                                            <input class="checkbox checkth" type="checkbox" name="check"/>
                                        </th>
                                        <th style="min-width:40px; width: 40px; text-align: center;">
                                            <?= lang("image"); ?>
                                        </th>
                                        <th><?= lang("category_code"); ?></th>
                                        <th><?= lang("category_name"); ?></th>
                                        <th><?= lang("parent_category"); ?></th>
                                        <th style="width:100px;"><?= lang("actions"); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="dataTables_empty">
                                            <?= lang('loading_data_from_server') ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                       

                </div>
            </div>
        </div>
<div style="display: none;">
    <input type="hidden" name="form_action" value="" id="form_action"/>
    <?= form_submit('submit', 'submit', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
<script src="<?=base_url();?>panel/misc/js/categories"></script>


