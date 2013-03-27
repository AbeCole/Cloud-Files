<h1>Move folder '<?php echo rawurldecode($folder); ?>'</h1>

<?php echo form_open('folder/move'); ?>
	<label for="name">Select destination</label>
	<select name="destination">
		<option value="/">Home</option>
		<?php echo build_folder_dropdown($folders, '', $path . rawurldecode($folder)); ?>
	</select>
	
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	<input type="hidden" value="<?php echo $folder; ?>" name="folder" />
	
	<input type="submit" value="Confirm" />
<?php echo form_close(); ?>