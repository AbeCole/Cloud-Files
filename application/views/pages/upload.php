<h1>Upload file</h1>

<?php echo form_open_multipart('file/upload'); ?>
	<label for="name">Select destination</label>
	<select name="destination">
		<option value="/">Home</option>
		<?php echo build_folder_dropdown($folders); ?>
	</select> <br />
	
	<input type="file" name="userfile" />
	
	<input type="submit" value="Upload" />
<?php echo form_close(); ?>