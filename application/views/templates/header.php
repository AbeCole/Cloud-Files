<html>
<head>
	<title><?php echo $title ?></title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400,300,600,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet/less" href="<?php echo $this->config->base_url('/assets/css/style.less'); ?>">
	<script src="<?php echo $this->config->base_url('/assets/js/less-1.3.3.min.js'); ?>"></script>
	<script src="<?php echo $this->config->base_url('/assets/js/jquery.js'); ?>"></script>
	<script src="<?php echo $this->config->base_url('/assets/js/modernizr.js'); ?>"></script>
</head>
<body<?php if (isset($login)) echo ' class="login"'; ?>>
	<?php if ( isset($this->session) ) {
		if ( ($errors = $this->session->flashdata('errors')) != '' ) { ?>
		<div id="message-box" class="error">
		
			<?php if ( is_array($errors) ) { 
				for ($i = 0; $i < count($errors); $i++) { ?>
				
				<p<?php if ($i == ( count($errors) - 1 ) ) echo ' class="last"'; ?>><img src="<?php echo base_url('assets/images/error.png'); ?>" alt="There was an error" /> <?php echo $errors[$i]; ?></p>
				
			<?php }
			} else { ?>
			
				<p><img src="<?php echo base_url('assets/images/error.png'); ?>" alt="There was an error" /> <?php echo $this->session->flashdata('errors'); ?></p>
				
			<?php } ?>
		</div>
	<?php } 
	} ?>
	<div id="page-container">