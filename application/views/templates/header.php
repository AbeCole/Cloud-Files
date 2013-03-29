<html>
<head>
	<title><?php echo $title ?></title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400,300,600,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet/less" href="<?php echo $this->config->base_url('/assets/css/style.less'); ?>">
	<script src="<?php echo $this->config->base_url('/assets/js/less-1.3.3.min.js'); ?>"></script>
	<script src="<?php echo $this->config->base_url('/assets/js/jquery.js'); ?>"></script>
	<script src="<?php echo $this->config->base_url('/assets/js/modernizr.js'); ?>"></script>
</head>
<body>
	<?php if ( $this->session->flashdata('error') != '' ) { ?>
		<div id="message-box" class="error">
			<p><img src="<?php echo base_url('assets/images/error.png'); ?>" alt="There was an error" /> <?php echo $this->session->flashdata('error'); ?></p>
		</div>
	<?php } ?>
	<div id="page-container">