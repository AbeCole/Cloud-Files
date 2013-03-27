<h1>Move file '<?php echo $file; ?>'</h1>

<?php echo form_open('file/move'); ?>
	<label for="name">Select destination</label>
	<select name="destination">
		<option value="/">Home</option>
		<?php echo build_folder_dropdown($folders); ?>
	</select>
	
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	<input type="hidden" value="<?php echo $file; ?>" name="file" />
	
	<input type="submit" value="Confirm" />
<?php echo form_close(); ?>