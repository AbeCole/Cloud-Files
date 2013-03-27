<h1>Rename folder '<?php echo $folder; ?>'</h1>

<?php echo form_open('folder/rename'); ?>
	<label for="name">New name</label>
	<input type="text" value="<?php echo $folder; ?>" name="name" />
	
	<input type="hidden" value="<?php echo $folder; ?>" name="oldname" />
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	
	<input type="submit" value="Confirm" />
<?php echo form_close(); ?>