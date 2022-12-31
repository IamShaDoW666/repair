<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header">
              <h3 class="card-title"><?= lang('db_title_page'); ?></h3>
          </div>
      <!-- /.card-header -->
      <div class="card-body">
		<p>
			<a href="<?= base_url(); ?>panel/utilities/backup_db" class="btn btn-primary"><?=lang('backup_current_db');?></a>
		</p>

		<table class="table table-striped table-hover table-bordered">
			<tbody>
				<tr>
					<th><?=lang('version');?></th>
					<th><?=lang('file_path');?></th>
					<th><?=lang('actions');?></th>
				</tr>
				<?php if($backup_sql_files) { ?>
				<?php foreach ($backup_sql_files as $file): ?>
				<tr>
					<td>
						<?php
							$datetime = explode('_', str_replace('.sql', '', $file));
							echo '<b>'.$datetime[0].'</b> '.str_replace('-', ':', $datetime[1]);
						?>
					</td>
					<td><?php echo FCPATH.'sql/backup/'.$file; ?></td>
					<td>
						<a href="<?= base_url();?>panel/utilities/restore_db/<?php echo $file; ?>" class="btn btn-primary"><?=lang('restore_btn');?></a>
						<a href="<?= base_url();?>panel/utilities/remove_db/<?php echo $file; ?>" class="btn btn-danger"><?=lang('delete');?></a>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php }else{ ?>
					<tr><td colspan=3 class="text-center"><?=lang('no_backup_now');?></td></tr>
				<?php } ?>
			</tbody>
		</table>
      </div>
  </div>
</div>

