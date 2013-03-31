<?php
class MY_Zip extends CI_Zip 
{   
    function read_dir_including_empty($path, $preserve_filepath = TRUE, $root_path = NULL, $parent = NULL)
	{
		if ( ! $fp = @opendir($path))
		{
			return FALSE;
		}

		// Set the original directory root for child dir's to use as relative
		if ($root_path === NULL)
		{
			$root_path = dirname($path).'/';
		}
		$i = 0;
		while (FALSE !== ($file = readdir($fp)))
		{
			$i++;
			if (substr($file, 0, 1) == '.')
			{
				continue;
			}
			if (@is_dir($path.$file))
			{
				
				$this->read_dir_including_empty($path.$file."/", $preserve_filepath, $root_path, $path);
				
			}
			else
			{
				if (FALSE !== ($data = file_get_contents($path.$file)))
				{
					$name = str_replace("\\", "/", $path);

					if ($preserve_filepath === FALSE)
					{
						$name = str_replace($root_path, '', $name);
					}

					$this->add_data($name.$file, $data);
				}
			}
		}
		if ($i == 2)
		{
			if ($preserve_filepath === FALSE)
			{
				$name = str_replace($root_path, '', str_replace("\\", "/", $path));
			}

			$this->add_dir($name);
		}
		
		return TRUE;

	}
        
}

/* End of file MY_Zip.php */
/* Location: ./application/libraries/MY_Zip.php */
