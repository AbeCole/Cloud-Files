<?php echo form_open($type . '/rename'); ?>
<div id="toolbox">
	<h1>Rename <?php echo $type; ?> '<?php echo $current_name; ?>'</h1>
	<a href="<?php echo base_url($path); ?>" class="close-option">Back</a>
	<label for="name">Enter new name</label>
</div> 
<div id="content">

	<input type="text" size="100" value="<?php echo $current_name; ?>" name="name" />
	<input type="submit" value="Confirm" />
	<input type="submit" name="cancel" value="Cancel" />
	
	<input type="hidden" value="<?php echo $current_name; ?>" name="oldname" />
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	
</div>
<?php echo form_close(); ?>

