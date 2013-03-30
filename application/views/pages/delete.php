<?php echo form_open($type . '/delete'); ?>
<div id="toolbox">
	<h1>Delete <?php echo $type; ?> '<?php echo $name; ?>'</h1>
	<a href="<?php echo base_url($path); ?>" class="close-option">Back</a>
	<label for="name">Are you sure you want to delete this <?php echo $type; ?>?</label> <small>(This cannot be undone)</small>
</div> 
<div id="content">

	<input type="submit" value="Confirm" />
	<input type="submit" name="cancel" value="Cancel" />
	
	<input type="hidden" value="<?php echo $name; ?>" name="name" />
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	
</div>
<?php echo form_close(); ?>

