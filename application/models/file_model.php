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
	public function get_file_path($file_path = '')
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
			
			return array('location' => $path, 'size' => filesize($path));
			
		}
		
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
			
			return 'The file requested could not be found';
			
		} 
		else 
		{
			
			if (unlink($path))
			{
				return 'success';
			}
			else 
			{
				return 'There was an error deleting the file';
			}
			
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
			
			return 'The folder requested could not be found';
			
		} 
		else 
		{
			
			if ($this->delete_directory($path))
			{
				return 'success';
			}
			else 
			{
				return 'There was an error deleting the folder';
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
