<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if($this->Admin || $GP['auth-create_group']): ?>
<div class="btn-group">
  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addGroup">
    <i class="fa fa-plus"></i> <?= lang('add_group') ?>
  </button>
</div>
<?php endif; ?>
<div class="row">
    <div class="col-12">
        <div class="card">

          <!-- /.card-header -->
          <div class="card-body">
                <table id="GPData" class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th><?php echo  $this->lang->line("group_id"); ?></th>
                        <th><?php echo  $this->lang->line("group_name"); ?></th>
                        <th><?php echo  $this->lang->line("group_description"); ?></th>
                        <?php if($this->Admin || ($GP['auth-permissions'] || $GP['auth-edit_group'] || $GP['auth-delete_group'])): ?>
                            <th style="width:45px;"><?php echo $this->lang->line("actions"); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($groups) {
                    foreach ($groups as $group) {
                        ?>
                        <tr>
                            <td><?php echo $group->id; ?></td>
                            <td><?php echo $group->name; ?></td>
                            <td><?php echo $group->description; ?></td>
                            <?php if($this->Admin || ($GP['auth-permissions'] || $GP['auth-edit_group'] || $GP['auth-delete_group'])): ?>
                                <td style="text-align:center;">
                                    <?php 
                                    $actions = '';
                                    if($this->Admin || $GP['auth-permissions']){
                                        $actions .= '<a class="tip" title="' . "Change Permissions" . '" href="'.base_url().'panel/auth/permissions/'.$group->id.'"><i class="fa fa-tasks"></i></a> ';
                                    }
                                    if($this->Admin || $GP['auth-edit_group']){
                                        $actions .= '<a class="tip" title="' . $this->lang->line("edit_group") . '" data-toggle="modal" data-target="#myModal" href="' . site_url('panel/auth/edit_group/' . $group->id) . '"><i class="fa fa-edit"></i></a> ';
                                    }
                                    if($this->Admin || $GP['auth-delete_group']){
                                        $actions .= '<a href="#" class="tip po" title="' . $this->lang->line("delete_group") . '" data-content="<p>' . lang('r_u_sure') . '</p><a class=\'btn btn-danger\' href=\'' . site_url('panel/auth/delete_group/' . $group->id) . '\'>' . lang('i_m_sure') . '</a> <button class=\'btn po-close\'>' . lang('no') . '</button>"><i class="fa fa-trash-o"></i></a>';
                                    }
                                    echo $actions;
                                    ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php
                    }}
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->




<!-- Modal -->
<div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel"><?php echo lang('create_group_heading');?>
        <small><?php echo lang('create_group_subheading');?></small></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="<?= lang('close'); ?>"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <?php echo form_open("panel/auth/create_group", 'id="add_group_form"');?>
            <p>
                <?php echo lang('create_group_name_label', 'group_name');?> <br />
                <?php echo form_input($group_name);?>
            </p>
            <p>
                <?php echo lang('create_group_desc_label', 'description');?> <br />
                <?php echo form_input($description);?>
            </p>
        <?php echo form_close();?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close'); ?></button>
        <button class="btn btn-primary" type="submit" form="add_group_form"><?= lang('save'); ?></button>
      </div>
    </div>
  </div>
</div>


