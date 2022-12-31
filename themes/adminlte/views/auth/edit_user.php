<div class="row">
    <div class="col-12">
        <div class="card">  
            <div class="card-header">
                <h3 class="card-title"><?php echo lang('edit_user_heading');?></h3>
                <small><?php echo lang('edit_user_subheading');?></small>
            </div>

          <!-- /.card-header -->
          <div class="card-body">
             <?= validation_errors('<div class="alert alert-warning">', '</div>'); ?>

             
              <?php echo form_open_multipart(uri_string());?>

                    <p>
                          <?php echo lang('edit_user_fname_label', 'first_name');?> <br />
                          <?php echo form_input($first_name);?>
                    </p>

                    <p>
                          <?php echo lang('edit_user_lname_label', 'last_name');?> <br />
                          <?php echo form_input($last_name);?>
                    </p>

                    <p>
                          <?php echo lang('edit_user_company_label', 'company');?> <br />
                          <?php echo form_input($company);?>
                    </p>

                    <p>
                          <?php echo lang('edit_user_phone_label', 'phone');?> <br />
                          <?php echo form_input($phone);?>
                    </p>

                    <p>
                          <?php echo lang('edit_user_email_label', 'email');?> <br />
                          <?php echo form_input($email);?>
                    </p>
                    <div class="form-group">
                      <label for="user_image"><?php echo lang('user_image_upload'); ?></label> 
                      <center><div style="image image-responsive"><img height="60px" src="<?= base_url(); ?>assets/uploads/members/<?= $image; ?>"></div>    </center>                   

                      <input id="user_image" type="file" name="user_image" data-show-upload="false" data-show-preview="false" accept="image/*" class="form-control file">
                  </div>
                    <p>
                          <?php echo lang('edit_user_password_label', 'password');?> <br />
                          <?php echo form_input($password);?>
                    </p>

                    <p>
                          <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
                          <?php echo form_input($password_confirm);?>
                    </p>

                    <div class="checkbox">
                      <?php if ($this->ion_auth->is_admin()): ?>

                        <h3><?php echo lang('edit_user_groups_heading');?></h3>
                        <?php foreach ($groups as $group):?>
                            <label class="checkbox" class="form-control">
                            <?php
                                $gID=$group['id'];
                                $checked = null;
                                $item = null;
                                foreach($currentGroups as $grp) {
                                    if ($gID == $grp->id) {
                                        $checked= ' checked="checked"';
                                    break;
                                    }
                                }
                            ?>
                            <input type="radio" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                            <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                            </label>
                        <?php endforeach?>

                    <?php endif ?>
                    </div>

                    <?php echo form_hidden('id', $user->id);?>
                    <?php echo form_hidden($csrf); ?>

                    <p><?php echo form_submit('submit', lang('edit_user_submit_btn'), 'class="form-control"');?></p>

              <?php echo form_close();?>
          </div>
        </div>
      </div>
    </div>