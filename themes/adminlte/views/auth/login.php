<link rel="stylesheet" href="<?=base_url();?>panel/misc/css/login">


<div class="login-box">
  <div class="login-logo">
    <img style="width: 100%" src="<?= base_url(); ?>assets/uploads/logos/<?= $settings->logo; ?>">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><?php echo lang('login_subheading');?></p>

       <?php if(strip_tags($message)):?>
        <div class="alert alert-info" id="infoMessage"><?php echo strip_tags($message);?></div>
      <?php endif; ?>




          <?php echo form_open("panel/login", 'id="login_form"');?>
        <div class="input-group mb-3">
          <?php echo form_input($identity, '', "class='form-control'");?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <?php echo form_input($password, '', "class='form-control'");?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

         <div class="row">
           <?php if ($this->mSettings->enable_recaptcha): ?>
              <center>
                <?= $this->recaptcha->create_box(array('data-size'=>'compact')); ?>
                </center>
                <br>
            <?php endif; ?>
        </div>



         <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
                <label for="remember">
                    <?php echo lang('login_remember_label');?>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-primary btn-block"');?>
            </div>
            <!-- /.col -->
          </div>
        <?php echo form_close();?>
          


    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<script type="text/javascript" src="<?=base_url();?>panel/misc/js/auth"></script>
