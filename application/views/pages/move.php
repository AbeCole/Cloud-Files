<?php echo form_open('file/move'); ?>
<div id="toolbox">
	<h1>Move file '<?php echo $file; ?>' <a href="<?php echo base_url($path); ?>" class="close-option">Back</a></h1>
	<label for="name">Select destination directory</label>
</div> 
<div id="content">
	<select name="destination">
		<?php if ($path != 'home/') : ?><option value="home/">home</option><?php endif; ?>
		<?php echo build_folder_dropdown($folders, 'home/', rtrim($path, '/')); ?>
	</select>
	<input type="submit" value="Confirm" />
	<input type="submit" name="cancel" value="Cancel" />
	
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	<input type="hidden" value="<?php echo $file; ?>" name="file" />
	
</div>
<?php echo form_close(); ?>