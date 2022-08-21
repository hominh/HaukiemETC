<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CadproETC - Hậu kiểm</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/core/libraries/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/core/libraries/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/core/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/core/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/core/css/custom.css">

	<!--<link rel="stylesheet" href="/vendor/core/libraries/bootstrap-datepicker/css/bootstrap-datepicker.min.css">!-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/core/libraries/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
	<!--<link rel="stylesheet" href="/vendor/core/libraries/bootstrap-daterangepicker/daterangepicker.css">!-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/core/core/table/table.css">
	<link href="<?php echo base_url(); ?>assets/vendor/core/css/select2/select2.min.css" rel="stylesheet" />

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

	<script src="<?php echo base_url(); ?>assets/vendor/core/libraries/jquery/dist/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/core/libraries/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/core/libraries/bootstrap/js/bootstrap.min.js"></script>
	<!--<script src="/vendor/core/libraries/bootstrap-daterangepicker/daterangepicker.js"></script>!-->
	<script src="<?php echo base_url(); ?>assets/vendor/core/libraries/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/core/libraries/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/core/libraries/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/core/libraries/fastclick/lib/fastclick.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/core/js/adminlte.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/core/js/select2/select2.min.js"></script>

</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<!--@include('haukiem-base::partials/header')
		@include('haukiem-base::partials/sidebar')
		@yield('page')!-->
		<?php $this->load->view('layout/partials/header');?>
		<?php $this->load->view('layout/partials/sidebar');?>
		<?php echo $this->load->view($subview); ?>
	</div>
	<div class="loader"></div>
</body>
<script>
    $(function() {
        var url = window.location;
        $('ul.sidebar-menu a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');
        $('ul.treeview-menu a').filter(function() {
            return this.href == url;
        }).closest('.treeview').addClass('active');
    })
</script>
</html>
