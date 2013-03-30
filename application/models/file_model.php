<?php
class File_model extends CI_Model {

	public function __construct()
	{
		if (1 == 2) { 
			$this->load->database();
		}
		$this->load->helper(array('file','directory','our_directory'));
	}
	public function get_files($parent = FALSE)
	{
	
		$path = $this->config->item('cloud_path');
		if ($parent != FALSE)
		{
		
			$path .= prep_path($parent);
			
			if ( ! is_dir($path)) 
			{
				return 'The directory requested is invalid';
			}
			
		}
		$files = build_directory_map($path);

		return $files;
		
	}
	public function get_file_info($file_path = '')
	{
	
		if ($file_path == '') 
		{
			return 'The file requested is invalid';
		}
		
		$path = $this->config->item('cloud_path') . prep_path($file_path);
		
		if ( ! is_file($path)) 
		{
			
			return 'The file requested could not be found';
			
		} 
		else 
		{
			
			return array('location' => $path, 'name' => basename($path), 'size' => filesize($path));
			
		}
		
	}
	public function get_folder_info($folder = '')
	{
	
		if ($folder == '') 
		{
			return 'The folder requested is invalid';
		}
		
		$path = $this->config->item('cloud_path') . prep_path($folder);
		
		if ( ! is_dir($path)) 
		{
			
			return 'The folder requested could not be found';
			
		} 
		else 
		{
		
			$fp = opendir($path);
			$empty = FALSE;
			if (FALSE === ($file = readdir($fp))) $empty = TRUE;
			closedir($fp);
			
			return array('name' => $folder, 'absolute_path' => $path, 'is_empty' => $empty);
			
		}
		
	}
	public function get_flat_files_array($parent = FALSE)
	{
		
		return $this->create_flat_array($this->get_files($parent));	
		
	}
	private function create_flat_array($files)
	{
		$file_array = array();
		foreach ($files as $file)
		{
			if (isset($file['name']) && isset($file['absolute_path']))
			{
				$file_array[] = $file;
			}
			else 
			{
				$file_array = array_merge($file_array, $this->create_flat_array($file));
			}
		}
		return $file_array;
	}
	public function get_folders($exclude = FALSE)
	{
		$path = $this->config->item('cloud_path');
		if ( ! is_dir($path)) 
		{
			return 'The cloud location is invalid';
		}
		
		$files = build_directory_structure($path, 0, FALSE, $exclude);

		return $files;
	}
	public function move_file($file = '', $location = '', $dest = '')
	{
		$path = $this->config->item('cloud_path');
		if ($file == '' || $dest == '' || $location == '') 
		{
			return 'The file requested is invalid';
		}
		$current_location = $path . prep_path($location) . $file;
		$new_destination = $path . prep_path($dest);
		
		if ( ! is_file($current_location)) 
		{
			
			return 'The file requested could not be found';
			
		} 
		elseif ( ! is_dir($new_destination)) 
		{
			
			return 'The destination is invalid';
				
		}
		else 
		{
			
			if (rename($current_location, $new_destination . $file))
			{
				return 'success';
			}
			else
			{
				return 'There was an error moving the file';
			}
			
		}
	}
	public function rename_file($location = '', $oldname = '', $newname = '')
	{
		$path = $this->config->item('cloud_path');
		if ($location == '' || $oldname == '' || $newname == '') 
		{
		
			return 'The file requested is invalid or the new name is empty';
		
		}
		
		$current_location = $path . prep_path($location) . $oldname;
		$the_new_name = $path . prep_path($location) . $newname;
		
		if ( ! is_file($current_location)) 
		{
			
			return 'The file requested could not be found';
			
		} 
		elseif (is_file($the_new_name)) 
		{
			
			return 'There is already a file with this name';
			
		}
		else 
		{
			
			if (rename($current_location, $the_new_name))
			{
				return 'success';
			}
			else 
			{
				return 'There was an error renaming the file';
			}
			
		}
	}
	public function delete_file($location = '', $file = '')
	{
		$path = $this->config->item('cloud_path');
		if ($file == '' || $location == '') {
			return 'The file requested is invalid';
		}
			
		$path .= prep_path($location) . $file;
		
		if ( ! is_file($path)) 
		{
			
			return 'The file "' . $file . '" could not be found';
			
		} 
		else 
		{
			
			if (unlink($path))
			{
				return 'success';
			}
			else 
			{
				return 'There was an error deleting the file "' . $file . '"';
			}
			
		}
	}
	public function delete_multiple($location = '', $files = array(), $folders = array())
	{
	
		if ( ( ! is_array($files) && ! is_array($folders) ) || $location == '') 
		{
			return 'The files or folders requested are invalid';
		}
		
		if ( is_array($files) ) 
		{
			for ($i = 0; $i < count($files); $i++)
			{
			
				if (($return = $this->delete_file($location, $files[$i])) != 'success')
				{
					$errors[] = $return;
				}
					
			}
		}
		
		if ( is_array($folders) ) 
		{
			for ($i = 0; $i < count($folders); $i++)
			{
			
				if (($return = $this->delete_folder($location, $folders[$i])) != 'success')
				{
					$errors[] = $return;
				}
					
			}
		}	
			
		if (isset($errors))
		{
			return $errors;
		}
		else 
		{
			return 'success';
		}
		
	}
	public function delete_files($location = '', $files = array())
	{
	
		$path = $this->config->item('cloud_path');
		if ( ! is_array($files) || $location == '') {
			return 'The files requested are invalid';
		}
		
		$path .= prep_path($location);
		for ($i = 0; $i < count($files); $i++)
		{
		
			$file_loc = $path . $files[$i];
			
			if ( ! is_file($file_loc)) 
			{
				
				$errors[] = 'The file "' . $files[$i] . '" could not be found';
				
			} 
			else 
			{
				
				if ( ! unlink($file_loc))
				{
					$errors[] = 'There was an error while deleting the file "' . $files[$i] . '"';
				}
				
			}
				
		}	
			
		if (isset($errors))
		{
			return $errors;
		}
		else 
		{
			return 'success';
		}
		
	}
	public function move_folder($name = '', $location = '', $dest = '')
	{
		$path = $this->config->item('cloud_path');
		if ($name == '' || $dest == '' || $location == '') 
		{
		
			return 'The folder requested is invalid';
		
		}
		$current_location = $path . prep_path($location) . $name;
		$new_destination = $path . prep_path($dest);
		
		if ( ! is_dir($current_location)) 
		{
			
			return 'The folder requested could not be found';
			
		} 
		else if ( ! is_dir($new_destination)) 
		{
			
			return 'The destination is invalid';
				
		}
		else 
		{
			
			if (rename($current_location, $new_destination . $name))
			{
				return 'success';
			}
			else
			{
				return 'There was an error moving the folder';
			}
			
		}
	}
	public function rename_folder($location = '', $oldname = '', $newname = '')
	{
		$path = $this->config->item('cloud_path');
		if ($location == '' || $oldname == '' || $newname == '') 
		{
		
			return 'The folder requested is invalid';
		
		}
		
		$current_location = $path . prep_path($location) . $oldname;
		$the_new_name = $path . prep_path($location) . $newname;
		
		if ( ! is_dir($current_location)) 
		{
			
			return 'The file requested could not be found';
			
		} 
		elseif (is_dir($the_new_name)) 
		{
		
			return 'There is already a folder with this name';
			
		} 
		else 
		{
			
			if (rename($current_location, $the_new_name))
			{
				return 'success';
			}
			else 
			{
				return 'There was an error renaming the folder';
			}
			
		}
	}
	public function delete_folder($location = '', $folder = '')
	{
		$path = $this->config->item('cloud_path');
		if ($folder == '' || $location == '') 
		{
		
			return 'The folder requested is invalid';
		
		}
			
		$path .= prep_path($location) . $folder;
		
		if ( ! is_dir($path)) 
		{
			
			return 'The folder "' . $folder . '" could not be found';
			
		} 
		else 
		{
			
			if ($this->delete_directory($path))
			{
				return 'success';
			}
			else 
			{
				return 'There was an error deleting the folder "' . $folder . '"';
			}
			
		}
	}
	public function create_folder($location = '', $name = '') 
	{
		$path = $this->config->item('cloud_path');
		if ($location == '' || $name == '') 
		{
		
			return 'The destination or folder name is invalid';
		
		}
		
		$path .= prep_path($location);

		if ( ! is_dir($path))
		{
			
			return 'The destination is invalid';
			
		}
		else if ( strpbrk($name, "\\/?%*:|\"<>") !== FALSE)
		{
			
			return 'The folder name is invalid: ' . $name;
			
		}
		else
		{
		
			if (mkdir($path . $name))
			{
				return 'success';	
			}
			else 
			{
				return 'There was an error creating the folder';
			}
			
		}
		
	}
	public function delete_directory($dir) 
	{ 
	
	    if ( ! file_exists($dir)) return true; 
	    if ( ! is_dir($dir) || is_link($dir)) return unlink($dir); 
	    
        foreach (scandir($dir) as $item) 
        { 
        
            if ($item == '.' || $item == '..') continue;
             
            if ( ! $this->delete_directory($dir . "/" . $item)) 
            { 
            
                chmod($dir . "/" . $item, 0777); 
                if ( ! $this->delete_directory($dir . "/" . $item)) return false; 
                
            }
            
        } 
        
        return rmdir($dir); 
        
	}
}

/* End of file file_model.php */
/* Location: ./application/models/file_model.php */
