<?php echo form_open('file/multi'); ?>
<div id="toolbox">
	<h1>Welcome <?php echo $username; ?></h1>
	<a href="<?php echo base_url("logout"); ?>" class="close-option">Logout</a>
	<p id="breadcrumb">Current location: 
		<?php 
		$url = '';
		for ($i = 1; $i <= count($breadcrumb); $i++) : 
			$url .= prep_cloud_url($breadcrumb[$i]) . '/';
			if ($i > 1) echo ' -> ';
			?>
			<a href="<?php echo base_url() . $url; ?>"><?php echo ucfirst(rawurldecode($breadcrumb[$i])); ?></a>
			<?php
		endfor; 
		?>
	</p>
	<div id="tools">
		<a href="<?php echo base_url('folder/create/' . (isset($parent) ? $parent . $current : 'home')); ?>/" id="create-folder">Create Folder</a>
		<a href="<?php echo base_url('file/upload/' . (isset($parent) ? $parent . $current : 'home')); ?>/" id="upload-file">Upload File</a>
		<a href="<?php echo base_url('folder/link/' . (isset($parent) ? $parent . $current : 'home')); ?>/" class="link-folder">Get Link</a>
		<input type="submit" value="Delete Multiple" name="multi-delete" />
		<input type="submit" value="Download Multiple" name="multi-download" />
	</div>
</div> 
<div id="cloudbrowser">
	<table>
		<thead>
			<th width="3%"></th>
			<th width="50%">Name</th>
			<th width="25%">Type</th>
			<th width="12%">Size</th>
			<th>Date</th>
			<th class="edit-col" width="5%"><input type="checkbox" value="All" name="multi-all" /></th>
		</thead>
		<?php if (isset($parent)) : ?>
 		<tr class="folder parent odd">
			<td class="order"><img src="<?php echo base_url('/assets/images/parentfolder.svg'); ?>" width="15" height="15" /></td>
			<td><a href="<?php echo base_url() . $parent; ?>">View Parent Directory</a></td>
			<td></td>
			<td></td>
			<td></td>
			<td class="edit-col"></td>
		</tr>
		<?php endif; ?>
		<?php $i = 0; $f = 0; $folderstring = ''; $filestring = ''; 
			  foreach ($files as $name => $child) :
			  	if (isset($child['name'])) : 
			  	
					$i++;
			  		$type = get_mime_by_extension($child['name']);
			  		
			  		$filestring .= '<tr class="' . ($i % 2 == 0 ? 'odd' : 'even') . ($this->session->flashdata('upload') == $child['name'] ? ' new-upload' : '') . '">
						<td class="order">' . $i . '</td>
						<td><a class="file-link" href="' . base_url() . 'download/' . (isset($parent) ? $parent . $current : $current) . '/' . rawurlencode($child['name']) . '">' . $child['name'] . '</a></td>
						<td>' . ($type == '' ? substr($child['name'],-3) : $type) . '</td>
						<td>' . byte_format($child['size']) . '</td>
						<td>' . date("d/m/Y", $child['date']) . '</td>
						<td class="edit-col">
							<img src="' . base_url('/assets/images/edit.svg') . '" width="15" height="15" />
							<input type="checkbox" value="' . $child['name'] . '" name="multi-file[]" />
						</td>
					</tr>
					<tr class="' . ($i % 2 == 0 ? 'odd' : 'even') . ' edit-row">
						<td class="order"></td>
						<td colspan="5">';
							
							if (isset($parent)) 
							{
								$filestring .= '<a href="' . base_url() . 'file/move/' . $parent . $current . '/' . rawurlencode($child['name']) . '" class="move-file">Move</a>
									<a href="' . base_url() . 'file/rename/' . $parent . $current . '/' . rawurlencode($child['name']) . '" class="rename-file">Rename</a>
									<a href="' . base_url() . 'file/delete/' . $parent . $current . '/' . rawurlencode($child['name']) . '" class="delete-file">Delete</a>
									<a href="' . base_url() . 'file/link/' . $parent . $current . '/' . rawurlencode($child['name']) . '" class="link-file">Get Link</a>';
							} 
							else 
							{
								$filestring .= '
									<a href="' . base_url() . 'file/move/home/' . rawurlencode($child['name']) . '" class="move-file">Move</a>
									<a href="' . base_url() . 'file/rename/home/' . rawurlencode($child['name']) . '" class="rename-file">Rename</a>
									<a href="' . base_url() . 'file/delete/home/' . rawurlencode($child['name']) . '" class="delete-file">Delete</a>
									<a href="' . base_url() . 'file/link/home/' . rawurlencode($child['name']) . '" class="link-file">Get Link</a>';
							}
							
					$filestring .= '</td>
					</tr>';
					
				else : 
					
					$f++;
					$folderstring .= '<tr class="' . ($f % 2 == 0 ? 'odd' : 'even') . ' folder">
						<td class="order"><img src="' . base_url('/assets/images/folder.svg') . '" width="15" height="15" /></td>
						<td><a href="' . base_url() . (isset($parent) ? $parent . $current : $current) . '/' . rawurlencode($name) . '/">' . $name . '</a></td>
						<td></td>
						<td></td>
						<td></td>
						<td class="edit-col">
							<img src="' . base_url('/assets/images/edit.svg') . '" width="15" height="15" />
							<input type="checkbox" value="' . $name . '" name="multi-folder[]" />
						</td>
					</tr>
					<tr class="' . ($f % 2 == 0 ? 'odd' : 'even') . ' folder edit-row">
						<td class="order"></td>
						<td colspan="5">';
							
							if (isset($parent)) 
							{
								$folderstring .= '<a href="' . base_url() . 'folder/move/' . $parent . $current . '/' . rawurlencode($name) . '/" class="move-folder">Move</a>
									<a href="' . base_url() . 'folder/rename/' . $parent . $current . '/' . rawurlencode($name) . '/" class="rename-folder">Rename</a>
									<a href="' . base_url() . 'folder/delete/' . $parent . $current . '/' . rawurlencode($name) . '/" class="delete-folder">Delete</a>
									<a href="' . base_url() . 'folder/link/' . $parent . $current . '/' . rawurlencode($name) . '/" class="link-folder">Get Link</a>';
							} 
							else 
							{
								$folderstring .= '
									<a href="' . base_url() . 'folder/move/home/' . rawurlencode($name) . '/" class="move-folder">Move</a>
									<a href="' . base_url() . 'folder/rename/home/' . rawurlencode($name) . '/" class="rename-folder">Rename</a>
									<a href="' . base_url() . 'folder/delete/home/' . rawurlencode($name) . '/" class="delete-folder">Delete</a>
									<a href="' . base_url() . 'folder/link/home/' . rawurlencode($name) . '" class="link-folder">Get Link</a>';
							}
							
					$folderstring .= '</td>
					</tr>';
					
				endif; ?>
		<?php endforeach;
		if ($f % 2 != 0) 
		{
		
			$filestring = str_replace(array('odd','even','eve2'),array('eve2','odd','even'),$filestring);
			
		}
		echo $folderstring . $filestring; ?>
		
	</table>
</div>
<input type="hidden" name="path" value="<?php echo (isset($parent) ? $parent . $current : $current) . '/'; ?>" />
<?php echo form_close(); ?>
<iframe id="downloadFrame"></iframe>