<div class="modal-content">
	<div class="modal-header">
        <h5 class="modal-title" id="myModalLabel"><?php echo lang('edit_group_heading');?>
        <small><?php echo lang('edit_group_subheading');?></small></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="<?= lang('close'); ?>"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">

			<?php echo form_open(current_url());?>

		      <p>
		            <?php echo lang('edit_group_name_label', 'group_name');?> <br />
		            <?php echo form_input($group_name);?>
		      </p>

		      <p>
		            <?php echo lang('edit_group_desc_label', 'description');?> <br />
		            <?php echo form_input($group_description);?>
		      </p>

		      <p><?php echo form_submit('submit', lang('edit_group_submit_btn'), 'class="form-control"');?></p>
			      
			<?php echo form_close();?>
      </div>	
</div>
