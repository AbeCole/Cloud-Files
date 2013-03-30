<?php echo form_open('file/multi'); ?>
<div id="toolbox">
	<h1>Delete Multiple</h1>
	<a href="<?php echo base_url($path); ?>" class="close-option">Back</a>
	<label for="name">Are you sure you want to delete the following?</label> <small>(This cannot be undone)</small>
</div> 
<div id="content">

	<?php if (is_array($folders)) { ?>
		<div class="section">
			<h2>Folders</h2>
			<?php for ($i = 0; $i < count($folders); $i++) { ?>
			<p>
				<?php echo $folders[$i]; ?>
				<input type="hidden" name="multi-folder[]" value="<?php echo $folders[$i]; ?>" />
			</p>
			<?php } ?>
		</div>
	<?php } ?>
	
	<?php if (is_array($files)) { ?>
		<div class="section">
			<h2>Files</h2>
			<?php for ($i = 0; $i < count($files); $i++) { ?>
			<p>
				<?php echo $files[$i]; ?>
				<input type="hidden" name="multi-file[]" value="<?php echo $files[$i]; ?>" />
			</p>
			<?php } ?>
		</div>
	<?php } ?>

	<input type="submit" name="confirm-delete" value="Confirm" />
	<input type="submit" name="cancel" value="Cancel" />
	
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	
</div>
<?php echo form_close(); ?>

