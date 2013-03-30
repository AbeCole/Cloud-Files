<?php echo form_open($type . '/move'); ?>
<div id="toolbox">
	<h1>Move <?php echo $type; ?> '<?php echo $current_name; ?>'</h1>
	<a href="<?php echo base_url($path); ?>" class="close-option">Back</a>
	<label for="name">Select destination directory</label>
</div> 
<div id="content">
	<select name="destination">
		<?php if ($path != 'home/') : ?><option value="home/">home</option><?php endif; ?>
		<?php if ($type == 'file') : 
				echo build_folder_dropdown($folders, 'home/', array() ); 
			  else :
			  	echo build_folder_dropdown($folders, 'home/', array($path, $path . $current_name . '/') ); 
		endif;?>
	</select>
	<input type="submit" value="Confirm" />
	<input type="submit" name="cancel" value="Cancel" />
	
	<input type="hidden" value="<?php echo $path; ?>" name="path" />
	<input type="hidden" value="<?php echo $current_name; ?>" name="current-name" />
	
</div>
<?php echo form_close(); ?>