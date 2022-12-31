<div class="row">
    <div class="col-12">
        <div class="card">  
            <div class="card-header">
                <h3 class="card-title"><?php echo lang('create_user_heading');?></h3>
                <small><?php echo lang('create_user_subheading');?></small>
            </div>

          <!-- /.card-header -->
          <div class="card-body">


      <?= validation_errors('<div class="alert alert-warning">', '</div>'); ?>
        <?php echo form_open_multipart("panel/auth/create_user", 'id="form_default"');?>
          <p>
                <?php echo lang('create_user_fname_label', 'first_name');?> <br />
                <?php echo form_input($first_name);?>
          </p>
          <p>
                <?php echo lang('create_user_lname_label', 'last_name');?> <br />
                <?php echo form_input($last_name);?>
          </p>
          <?php
          if($identity_column!=='email') {
              echo '<p>';
              echo lang('create_user_identity_label', 'identity');
              echo '<br />';
              echo form_error('identity');
              echo form_input($identity);
              echo '</p>';
          }
          ?>
          <div class="form-group">
            <label for="user_image"><?php echo lang('user_image_upload'); ?></label>
            <input id="user_image" type="file" name="user_image" data-show-upload="false" data-show-preview="false" accept="image/*" class="form-control file">
          </div>
          <p>
                <?php echo lang('create_user_company_label', 'company');?> <br />
                <?php echo form_input($company);?>
          </p>
          <p>
                <?php echo lang('create_user_email_label', 'email');?> <br />
                <?php echo form_input($email);?>
          </p>
          <p>
                <?php echo lang('create_user_phone_label', 'phone');?> <br />
                <?php echo form_input($phone);?>
          </p>
          <p>
                <?php echo lang('create_user_password_label', 'password');?> <br />
                <?php echo form_input($password);?>
          </p>
          <p>
                <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
                <?php echo form_input($password_confirm);?>
          </p>
          <p><?php echo form_submit('submit', lang('create_user_submit_btn'), 'class="form-control"');?></p>
        <?php echo form_close();?>
      </div>
      <!-- /.box-body -->


       </div>
      </div>
    </div>