<link rel="stylesheet" href="<?=base_url();?>panel/misc/css/login">

<div class="login-box">
  <div class="login-logo">
    <img style="width: 100%" src="<?= base_url(); ?>assets/uploads/logos/<?= $settings->logo; ?>">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
    <p class="login-box-msg"><?php echo lang('reset_password_heading');?></p>


        <div class="alert alert-info" id="infoMessage"><?php echo $message ? $message : $error;?></div>
    

        <?php echo form_open('panel/login/reset_password/' . $code);?>
          <div class="form-group has-feedback">

            <?php echo form_input($new_password, '', "class='form-control' placeholder='".sprintf(lang('reset_password_new_password_label'), $min_password_length)."'");?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

          </div>

          <div class="form-group has-feedback">
            <?php echo form_input($new_password_confirm, '', "class='form-control' placeholder='".lang('reset_password_new_password_confirm_label')."'");?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

          </div>

            <?php echo form_input($user_id);?>
             <?php echo form_hidden($csrf); ?>

          <div class="row">
            <?php if ($this->mSettings->enable_recaptcha): ?>
              <center>
                <?= $this->recaptcha->create_box(array('data-size'=>'compact')); ?>
                </center>
                <br>
            <?php endif; ?>


             <div class="row">
              <div class="col-4 ">
                <?php echo form_submit('submit', lang('forgot_password_submit_btn'), 'class="btn btn-primary btn-block "');?>
              </div>
              <!-- /.col -->
            </div>

            
          </div>
      <?php echo form_close();?>


        
    

      <p class="mb-0">
        <a href="<?=base_url();?>/panel/login"> &larr; <?=lang('back_to_login');?></a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>


<script type="text/javascript" src="<?=base_url();?>panel/misc/js/auth"></script>