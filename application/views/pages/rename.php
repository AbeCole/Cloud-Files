<?php echo form_open('file/rename'); ?>
<div id="toolbox">
	<h1>Rename file '<?php echo $file; ?>' <a href="<?php echo base_url($path); ?>" class="close-option">Back</a></h1>
	<label for="name">Enter new name</label>
</div> 
<div id="content">

	<input type="text" value="<?php echo $file; ?>" name="name" />
	<input type="submit" value="Confirm" />
	
	<input type="hidden" value="<?php echo $file; ?>" name="oldname" />
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	
</div>
<?php echo form_close(); ?>

