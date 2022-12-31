<div class="wrapper">
	<?php if(!$settings->use_topbar): ?>
		<?php $this->load->view($this->theme . '_partials/navigation'); ?>
	<?php else: ?>
		<?php $this->load->view($this->theme . '_partials/navigation_top'); ?>
	<?php endif; ?>
	<?php // Left side column. contains the logo and sidebar ?>
	<?php if(!$settings->use_topbar): ?>
	<aside class="main-sidebar">
		<section class="sidebar">
			  <div class="user-panel">
		        <div class="pull-left image">
		          <img src="<?= base_url(); ?>assets/uploads/members/<?= $user->image; ?>" class="img-circle" alt="User Image">
		        </div>
		        <div class="pull-left info">
		          <p><?= $user->first_name.' '.$user->last_name; ?></p>
		          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
		        </div>
		      </div>
			<?php // (Optional) Add Search box here ?>
			<?php $this->load->view($this->theme . '_partials/sidemenu'); ?>
		</section>
	</aside>
	<?php endif;?>

	<?php // Right side column. Contains the navbar and content of the page ?>

	<div class="content-wrapper">

		 <!-- Content Header (Page header) -->
	    <div class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-1">
	         
	        </div><!-- /.row -->
	      </div><!-- /.container-fluid -->
	    </div>
	    <!-- /.content-header -->


	      <!-- Main content -->
		    <section class="content">
		      <div class="container-fluid">

		      	<?php if ($this->session->flashdata('message')) {?>
		      			<div class="alert alert-success">
		                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                  <?= strip_tags($this->session->flashdata('message')); ?>
		                </div>
				  <?php } ?>

		      	<?php if ($this->session->flashdata('error')) {?>
				  	<div class="alert alert-danger">
		                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                  <?= strip_tags($this->session->flashdata('error')); ?>
		                </div>
				  <?php } ?>
		      	<?php if ($this->session->flashdata('warning')) {?>
				  	<div class="alert alert-warning">
		                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                  <?= strip_tags($this->session->flashdata('warning')); ?>
		                </div>

				  <?php } ?>

					<?php $this->load->view($this->theme . $inner_view); ?>
		        <!-- /.row (main row) -->
		      </div><!-- /.container-fluid -->
		    </section>
		    <!-- /.content -->
	</div>

	<?php $this->load->view($this->theme . 'client_js');?>

	<?php // Footer ?>
	<?php $this->load->view($this->theme . '_partials/footer'); ?>

</div>