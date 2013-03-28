<div id="toolbox">
	<h1 class="no-margin">Link for file '<?php echo $file; ?>' <a href="<?php echo base_url($path); ?>" class="close-option">Back</a></h1>
</div> 
<div id="content">

	<textarea id="link-select" readonly rows="1"><?php echo base_url() . 'download/' . $path . $file; ?></textarea>
	
</div>
<script src="<?php echo base_url('assets/js/ZeroClipboard.min.js'); ?>"></script>

