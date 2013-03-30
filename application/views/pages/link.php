<div id="toolbox">
	<h1 class="no-margin">Link for <?php echo $type; ?> '<?php echo $name; ?>'</h1>
	<a href="<?php echo base_url($path); ?>" class="close-option">Back</a>
</div> 
<div id="content">

	<?php echo form_open($type . '/link'); ?>
	<textarea id="link-select" readonly rows="1"><?php echo base_url() . ($type == 'file' ? 'download/' . $path . $name : $path); ?></textarea>
	
	<input type="submit" name="cancel" value="Cancel" />
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	<?php echo form_close(); ?>
	
</div>
<script src="<?php echo base_url('assets/js/ZeroClipboard.min.js'); ?>"></script>

