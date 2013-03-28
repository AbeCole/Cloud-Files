<div id="toolbox">
	<h1>Welcome <?php echo $username; ?> <a href="<?php echo base_url("logout"); ?>" class="close-option">Logout</a></h1>
	<p id="breadcrumb">Current location: 
		<?php 
		$url = '';
		for ($i = 1; $i <= count($breadcrumb); $i++) : 
			$url .= prep_url($breadcrumb[$i]) . '/';
			if ($i > 1) echo ' -> ';
			?>
			<a href="<?php echo base_url() . $url; ?>"><?php echo ucfirst(rawurldecode($breadcrumb[$i])); ?></a>
			<?php
		endfor; 
		?>
	</p>
	<div id="tools">
		<a href="<?php echo base_url('file/upload' . (isset($parent) ? '/' . $parent . $current : '/')); ?>" id="upload-file">Upload File</a>
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
			<th class="edit-col"><span>Edit</span></th>
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
			  		$filestring .= '<tr class="' . ($i % 2 == 0 ? 'odd' : 'even') . '">
						<td class="order">' . $i . '</td>
						<td><a class="file-link" href="' . base_url() . 'download/' . (isset($parent) ? $parent . $current : $current) . '/' . rawurlencode($child['name']) . '">' . $child['name'] . '</a></td>
						<td>' . ($type == '' ? substr($child['name'],-3) : $type) . '</td>
						<td>' . byte_format($child['size']) . '</td>
						<td>' . date("d/m/Y", $child['date']) . '</td>
						<td class="edit-col"><a href=""><img src="' . base_url('/assets/images/edit.svg') . '" width="15" height="15" /></a></td>
					</tr>
					<tr class="' . ($i % 2 == 0 ? 'odd' : 'even') . ' edit-row">
						<td class="order"></td>
						<td colspan="5">';
							
							if (isset($parent)) {
								$filestring .= '<a href="' . base_url() . 'file/move/' . $parent . $current . '/' . rawurlencode($child['name']) . '" class="move-file">Move</a>
									<a href="' . base_url() . 'file/rename/' . $parent . $current . '/' . rawurlencode($child['name']) . '" class="rename-file">Rename</a>
									<a href="' . base_url() . 'file/delete/' . $parent . $current . '/' . rawurlencode($child['name']) . '" class="delete-file">Delete</a>
									<a href="' . base_url() . 'file/link/' . $parent . $current . '/' . rawurlencode($child['name']) . '" class="link-file">Get Link</a>';
							} else {
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
						<td class="edit-col"><a href=""><img src="' . base_url('/assets/images/edit.svg') . '" width="15" height="15" /></a></td>
					</tr>
					<tr class="' . ($f % 2 == 0 ? 'odd' : 'even') . ' folder edit-row">
						<td class="order"></td>
						<td colspan="5">';
							
							if (isset($parent)) {
								$folderstring .= '<a href="' . base_url() . 'folder/move/' . $parent . $current . rawurlencode($name) . '" class="move-folder">Move</a>
									<a href="' . base_url() . 'folder/rename/' . $parent . $current . rawurlencode($name) . '" class="rename-folder">Rename</a>
									<a href="' . base_url() . 'folder/delete/' . $parent . $current . rawurlencode($name) . '" class="delete-folder">Delete</a>';
							} else {
								$folderstring .= '
									<a href="' . base_url() . 'folder/move/home/' . rawurlencode($name) . '" class="move-folder">Move</a>
									<a href="' . base_url() . 'folder/rename/home/' . rawurlencode($name) . '" class="rename-folder">Rename</a>
									<a href="' . base_url() . 'folder/delete/home/' . rawurlencode($name) . '" class="delete-folder">Delete</a>';
							}
							
					$folderstring .= '</td>
					</tr>';
					
				endif; ?>
		<?php endforeach;
		if ($f % 2 != 0) {
			$filestring = str_replace(array('odd','even','eve2'),array('eve2','odd','even'),$filestring);
			
		}
		echo $folderstring . $filestring; ?>
		
	</table>
</div>
<iframe id="downloadFrame"></iframe>