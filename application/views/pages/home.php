<div id="toolbox">
	<h1>Welcome, <?php echo $username; ?> <a href="<?php echo base_url("logout"); ?>" id="logout">Logout</a></h1>
	<div id="tools">
		<a href="<?php echo base_url('file/upload'); ?>" id="upload-file">Upload File</a>
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
			<th>Edit</th>
		</thead>
		<?php if (isset($parent)) : ?>
 		<tr class="folder parent odd">
			<td class="order"><img src="<?php echo base_url('/assets/images/parentfolder.svg'); ?>" width="15" height="15" /></td>
			<td><a href="<?php echo $parent; ?>">View Parent Directory</a></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php endif; ?>
		<?php $i = 0; $f = 0; $folderstring = ''; $filestring = ''; 
			  foreach ($files as $name => $child) :
			  	if (isset($child['name'])) : 
			  	
					$i++;
			  		$type = get_mime_by_extension($child['name']);
			  		$filestring .= '<tr class="' . ($i % 2 == 0 ? 'odd' : 'even') . '">
						<td class="order">' . $i . '</td>
						<td><a class="file-link" href="' . (isset($parent) ? str_replace('home','download',$parent) . $current : base_url() . 'download') . '/' . rawurlencode($child['name']) . '">' . $child['name'] . '</a></td>
						<td>' . ($type == '' ? substr($child['name'],-3) : $type) . '</td>
						<td>' . byte_format($child['size']) . '</td>
						<td>' . date("d/m/Y", $child['date']) . '</td>
						<td><a href="" class="edit-file"><img src="' . base_url('/assets/images/edit.svg') . '" width="15" height="15" /></a></td>
					</tr>
					<tr class="' . ($i % 2 == 0 ? 'odd' : 'even') . ' edit-row">
						<td class="order"></td>
						<td colspan="5">';
							
							if (isset($parent)) {
								$filestring .= '<a href="' . str_replace('home','file/move',$parent) . $current . '/' . rawurlencode($child['name']) . '" class="move-file">Move</a>
									<a href="' . str_replace('home','file/rename',$parent) . $current . '/' . rawurlencode($child['name']) . '" class="rename-file">Rename</a>
									<a href="' . str_replace('home','file/delete',$parent) . $current . '/' . rawurlencode($child['name']) . '" class="delete-file">Delete</a>';
							} else {
								$filestring .= '
									<a href="' . base_url() . 'file/move' . '/' . rawurlencode($child['name']) . '" class="move-file">Move</a>
									<a href="' . base_url() . 'file/rename' . '/' . rawurlencode($child['name']) . '" class="rename-file">Rename</a>
									<a href="' . base_url() . 'file/delete' . '/' . rawurlencode($child['name']) . '" class="delete-file">Delete</a>';
							}
							
					$filestring .= '</td>
					</tr>';
					
				else : 
					
					$f++;
					$folderstring .= '<tr class="' . ($f % 2 == 0 ? 'odd' : 'even') . ' folder">
						<td class="order"><img src="' . base_url('/assets/images/folder.svg') . '" width="15" height="15" /></td>
						<td><a href="' . (isset($parent) ? $parent : base_url()) . $current . rawurlencode($name) . '">' . $name . '</a></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr class="' . ($f % 2 == 0 ? 'odd' : 'even') . ' folder edit-row">
						<td class="order"></td>
						<td colspan="5">';
							
							if (isset($parent)) {
								$folderstring .= '<a href="' . str_replace('home','folder/move',$parent) . $current . '/' . rawurlencode($name) . '" class="move-folder">Move</a>
									<a href="' . str_replace('home','folder/rename',$parent) . $current . '/' . rawurlencode($name) . '" class="rename-folder">Rename</a>
									<a href="' . str_replace('home','folder/delete',$parent) . $current . '/' . rawurlencode($name) . '" class="delete-folder">Delete</a>';
							} else {
								$folderstring .= '
									<a href="' . base_url() . 'folder/move' . '/' . rawurlencode($name) . '" class="move-folder">Move</a>
									<a href="' . base_url() . 'folder/rename' . '/' . rawurlencode($name) . '" class="rename-folder">Rename</a>
									<a href="' . base_url() . 'folder/delete' . '/' . rawurlencode($name) . '" class="delete-folder">Delete</a>';
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