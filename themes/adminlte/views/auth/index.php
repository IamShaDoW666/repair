<div class="row">
  	<div class="col-12">
	    <div class="card">
	      <div class="card-header">
		    	 <h3 class="card-title"><?php echo lang('index_heading');?> <small><?php echo lang('index_subheading');?></small></h3>

	    	 	<div class="card-tools">
                 <a class="btn btn-default" href="<?= base_url('panel/auth/create_user'); ?>"><?= lang('index_create_user_link'); ?></a>
                </div>

          </div>
	      <!-- /.card-header -->
	      <div class="card-body">

              <table cellpadding=0 cellspacing=10 class="table table-hover">
					<thead>
						<tr>
							<th><?php echo lang('index_fname_th');?></th>
							<th><?php echo lang('index_lname_th');?></th>
							<th><?php echo lang('index_email_th');?></th>
							<th><?php echo lang('index_groups_th');?></th>
							<th><?php echo lang('index_status_th');?></th>
							<th><?php echo lang('index_action_th');?></th>
						</tr>
					</thead>
					<?php foreach ($users as $user):?>
						<tr>
				            <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
				            <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
				            <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
							<td>
								<?php foreach ($user->groups as $group):?>
									<?php echo anchor("panel/auth/permissions/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
				                <?php endforeach?>
							</td>

							<td>
								<?php if(($user->active)): ?>
				            		<?php if($this->ion_auth->user()->row()->id !== $user->id): ?>
						            	<a class='activate_toggle_po' title="<?= lang('index_inactive_link'); ?>" data-content="<a class='btn btn-danger activate_toggle' href='<?= base_url();?>panel/auth/deactivate/<?= $user->id ?>'>Yes</a> <button class='btn activate_toggle_po-close'>No</button>" href="<?= base_url();?>panel/auth/deactivate/<?= $user->id ?>"><span class="badge badge-success"><i class="fa fa-check"></i> <?= lang('index_active_link')?></span></a>
						            <?php else: ?>
						            	<span class="badge badge-success"><i class="fa fa-check"></i> <?= lang('index_active_link')?></span>
						            <?php endif; ?>
						        <?php else: ?>
						        	<a href="<?= base_url();?>panel/auth/activate/<?= $user->id ?>"><span class="badge badge-danger"><i class="fa fa-check"></i> <?= lang('index_inactive_link')?></span></a>
						        <?php endif; ?>
							</td>

							<td><?php echo anchor("panel/auth/edit_user/".$user->id, '<i class="fa fa-edit"></i>', 'class="btn btn-sm btn-default"') ;?>
								<?php if($this->ion_auth->user()->row()->id !== $user->id): ?>
					              <a href="<?= base_url(); ?>panel/auth/delete_user/<?= $user->id; ?>" type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
					            <?php endif; ?>
							</td>
						</tr>
					<?php endforeach;?>
				</table>
	      </div>
	  </div>
	</div>
</div>

