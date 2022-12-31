<!DOCTYPE html>
<html>
	<head>
	  	<meta charset="utf-8">
	  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="pragma" content="no-cache">

	  	<title><?php echo $page_title; ?></title>
	  	<!-- Tell the browser to be responsive to screen width -->
	  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  	


		  <!-- Google Font: Source Sans Pro -->
		  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		  <!-- Ionicons -->
		  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

		  <link rel="stylesheet" href="<?=base_url();?>panel/misc/css/head">


		  <!-- Font Awesome -->
		  <link rel="stylesheet" href="<?= $assets ?>plugins/fontawesome-free/css/all.min.css">
		  <!-- Tempusdominus Bootstrap 4 -->
		  <link rel="stylesheet" href="<?= $assets ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
			

  		<!-- Select2 -->
	  	<link rel="stylesheet" href="<?= $assets ?>plugins/select2/css/select2.min.css">
	  	<link rel="stylesheet" href="<?= $assets ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">



		  <!-- Theme style -->
		  <link rel="stylesheet" href="<?= $assets ?>dist/css/adminlte.min.css">
		  <!-- overlayScrollbars -->
		  <link rel="stylesheet" href="<?= $assets ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
		  <!-- Daterange picker -->
		  <link rel="stylesheet" href="<?= $assets ?>plugins/daterangepicker/daterangepicker.css">
		  <!-- summernote -->
		  <link rel="stylesheet" href="<?= $assets ?>plugins/summernote/summernote-bs4.min.css">
		  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css">








		<!-- iCheck for checkboxes and radio inputs -->
  		<link rel="stylesheet" href="<?= $assets ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  		<link rel="stylesheet" href="<?= $assets ?>plugins/icheck/skins/all.css">



		 <!-- DataTables -->
	  	<link rel="stylesheet" href="<?= $assets ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	  	<link rel="stylesheet" href="<?= $assets ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	  	<link rel="stylesheet" href="<?= $assets ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">




		<!-- bootstrap color picker -->
	  	<link rel="stylesheet" href="<?= $assets ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
	  	<!-- Toastr -->
	  	<link rel="stylesheet" href="<?= $assets ?>plugins/toastr/toastr.min.css">
	  	<!-- Custom CSS -->
	  	<link rel="stylesheet" href="<?= $assets ?>plugins/parsley/parsley.css">


		<!-- jQuery -->
		<script src="<?= $assets ?>plugins/jquery/jquery.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="<?= $assets ?>plugins/jquery-ui/jquery-ui.min.js"></script>

		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<!-- Bootstrap 4 -->
		<script src="<?= $assets ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

		<script src="<?= $assets ?>plugins/bootstrap-switch/js/bootstrap-switch.js"></script>

		<script src="<?= $assets ?>plugins/select2/js/select2.full.min.js"></script>


		<!-- Tempusdominus Bootstrap 4 -->
		<script src="<?= $assets ?>plugins/moment/moment.min.js"></script>
		<script src="<?= $assets ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>


	  	<!-- daterange picker -->
		<script src="<?= $assets ?>plugins/daterangepicker/daterangepicker.js"></script>



		<script src="<?= $assets ?>plugins/toastr/toastr.min.js"></script>

		<script src="<?= $assets ?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>



		
		<!-- DataTables -->
		<script src="<?= $assets ?>plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?= $assets ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
		<script src="<?= $assets ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
		<script src="<?= $assets ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
		<script src="<?= $assets ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
		<script src="<?= $assets ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
		<script src="<?= $assets ?>plugins/jszip/jszip.min.js"></script>
		<script src="<?= $assets ?>plugins/pdfmake/pdfmake.min.js"></script>
		<script src="<?= $assets ?>plugins/pdfmake/vfs_fonts.js"></script>
		<script src="<?= $assets ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
		<script src="<?= $assets ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
		<script src="<?= $assets ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>




		

		<!-- Bootbox.js -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
		<!-- Bootstrap Validator -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>
		

		<script src="<?=base_url();?>panel/misc/js/variables"></script>

		<!-- Custom -->
		<script src="<?= $assets ?>plugins/custom/core.js"></script>
		<script src="<?= $assets ?>plugins/parsley/parsley.min.js"></script>
		<link rel="stylesheet" href="<?= $assets ?>plugins/bootstrap-fileinput/css/fileinput.min.css">

		<!-- _Underscore.js -->
		<script src="<?= $assets ?>plugins/custom/underscore.js"></script>
		<!-- Accounting.js -->
		<script src="<?= $assets ?>plugins/custom/accounting.min.js"></script>




		<script src="<?= $assets ?>plugins/bootstrap-fileinput/js/fileinput.min.js"></script>
		<script src="<?= $assets ?>plugins/typeahead.bundle.js"></script>


	  	<link rel="stylesheet" href="<?= $assets ?>dist/css/custom/custom.css">

	  	<?php if($settings->language == 'arabic'): ?>
	  		<link rel="stylesheet" href="<?= $assets ?>dist/css/adminlte-rtl.css">
	  	<?php endif;?>



		<script src="<?= $assets ?>plugins/custom/custom.js"></script>


		<script type="text/javascript" src="<?=$assets;?>plugins/renderjson.js"></script>
		<script src="<?= $assets;?>/plugins/patternlock/patternLock.min.js"></script>
		<script src="<?=$assets;?>plugins/jSignature/jSignature.min.js"></script>


		<script src="https://maps.googleapis.com/maps/api/js?key=<?= $settings->google_api_key?>&libraries=places&callback=initAutocomplete"
		async defer></script>

		  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		  <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		  <![endif]-->
		 
	</head>
	<?php if($settings->use_topbar): ?>
		<body class="<?php echo $body_class; ?> layout-top-nav">
	<?php else:?>
		<body class="<?php echo $body_class; ?> skin-custom <?= $this->session->userdata('main_sidebar_state'); ?>">
	<?php endif;?>

	<div id='loadingmessage' class="loader" style="display: none;"></div>
