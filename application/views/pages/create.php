<?php echo form_open('folder/create'); ?>
<div id="toolbox">
	<h1>Create folder in '<?php echo $name; ?>'</h1>
	<a href="<?php echo base_url($path); ?>" class="close-option">Back</a>
	<label for="name">Enter name</label>
</div> 
<div id="content">

	<input type="text" size="100" value="" name="name" />
	<input type="submit" value="Confirm" />
	<input type="submit" name="cancel" value="Cancel" />
	
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	
</div>
<?php echo form_close(); ?>

