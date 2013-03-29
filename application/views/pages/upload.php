<?php echo form_open_multipart('file/upload'); ?>
<div id="toolbox">
	<h1>Upload file</h1>
	<a href="<?php echo base_url($path); ?>" class="close-option">Back</a>
	<label for="destination">Select destination directory</label>
</div> 
<div id="content">

	<select name="destination">
		<option value="home/"<?php if ($path == 'home/') echo ' selected'; ?>>home</option>
		<?php echo build_folder_dropdown($folders, 'home/', array(), $path); ?>
	</select><br /><br />
	<input type="file" name="userfile" /><br /><br />
	<input type="submit" value="Upload File" />
	<input type="submit" name="cancel" value="Cancel" />
	
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	
</div>
<?php echo form_close(); ?>