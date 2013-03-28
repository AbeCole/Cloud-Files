<?php echo form_open('file/delete'); ?>
<div id="toolbox">
	<h1>Delete file '<?php echo $file; ?>' <a href="<?php echo base_url($path); ?>" class="close-option">Back</a></h1>
	<label for="name">Are you sure you want to delete this file?</label> <small>(This cannot be undone)</small>
</div> 
<div id="content">

	<input type="submit" value="Confirm" />
	<input type="submit" name="cancel" value="Cancel" />
	
	<input type="hidden" value="<?php echo $file; ?>" name="file" />
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	
</div>
<?php echo form_close(); ?>

