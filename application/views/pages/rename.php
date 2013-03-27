<h1>Rename file '<?php echo $file; ?>'</h1>

<?php echo form_open('file/rename'); ?>
	<label for="name">New name</label>
	<input type="text" value="<?php echo $file; ?>" name="name" />
	
	<input type="hidden" value="<?php echo $file; ?>" name="oldname" />
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	
	<input type="submit" value="Confirm" />
<?php echo form_close(); ?>