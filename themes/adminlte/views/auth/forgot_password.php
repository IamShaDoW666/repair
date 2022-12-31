<link rel="stylesheet" href="<?=base_url();?>panel/misc/css/login">
<div class="login-box">
  <div class="login-logo">
    <img style="width: 100%" src="<?= base_url(); ?>assets/uploads/logos/<?= $settings->logo; ?>">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
    <p class="login-box-msg"><?php echo lang('forgot_password_heading');?>
      <br><small><?=sprintf(lang('forgot_password_subheading'), 'email');?></small></p>
      <div class="alert alert-info">
        <?php echo $message;?>
      </div>

      <?php echo form_open("panel/login/forgot_password");?>
          <?php $label = (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?>
          <div class="form-group has-feedback">
            <?php echo form_input($identity, '', "class='form-control' placeholder='".$label."'");?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
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
