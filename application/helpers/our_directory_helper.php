<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('build_directory_map'))
{
	function build_directory_map($source_dir, $directory_depth = 0, $hidden = FALSE)
	{
		if ($fp = @opendir($source_dir))
		{
			$filedata	= array();
			$new_depth	= $directory_depth - 1;
			$source_dir	= rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

			while (FALSE !== ($file = readdir($fp)))
			{
				// Remove '.', '..', and hidden files [optional]
				if ( ! trim($file, '.') OR ($hidden == FALSE && $file[0] == '.'))
				{
					continue;
				}

				if (($directory_depth < 1 OR $new_depth > 0) && @is_dir($source_dir.$file))
				{
					$filedata[$file] = build_directory_map($source_dir.$file.DIRECTORY_SEPARATOR, $new_depth, $hidden);
				}
				else
				{
					$filedata[$file] = array('name' => $file, 'relative_path' => $source_dir, 'size' => filesize($source_dir.$file), 'date' => filemtime($source_dir.$file));
				}
			}

			closedir($fp);
			return $filedata;
		}

		return FALSE;
	}
	function build_directory_structure($source_dir, $directory_depth = 0, $hidden = FALSE)
	{
		if ($fp = @opendir($source_dir))
		{
			$filedata	= array();
			$new_depth	= $directory_depth - 1;
			$source_dir	= rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

			while (FALSE !== ($file = readdir($fp)))
			{
				// Remove '.', '..', and hidden files [optional]
				if ( ! trim($file, '.') OR ($hidden == FALSE && $file[0] == '.'))
				{
					continue;
				}

				if (($directory_depth < 1 OR $new_depth > 0) && @is_dir($source_dir.$file))
				{
					$filedata[$file] = build_directory_structure($source_dir.$file.DIRECTORY_SEPARATOR, $new_depth, $hidden);
				}
			}

			closedir($fp);
			return $filedata;
		}

		return FALSE;
	}
	function build_folder_dropdown($folders = array(), $parent = '', $exclude = FALSE) {

		$return = '';
		foreach ($folders as $name => $children) : 
			
			if ($exclude == FALSE || $parent . $name != $exclude) :
				$return .= '<option>' . $parent . $name . '</option>';
				
				if (count($children) > 0) : 
					$return .= build_folder_dropdown($children, $parent . $name . ' -> ', $exclude);
				endif;
			endif;
		endforeach;
		
		return $return;
		
	}
	function reverse_filter_uri($str)
	{
		// Convert entities to programatic characters
		$good	= array('$',		'(',		')',		'%28',		'%29',		' ');
		$bad	= array('&#36;',	'&#40;',	'&#41;',	'&#40;',	'&#41;',	'%20');

		return str_replace($bad, $good, $str);
	}
	function prep_url($str) {
		$str = rawurlencode(reverse_filter_uri($str));
		
		return $str;
	}
}


/* End of file our_directory.php */
/* Location: ./application/helpers/our_directory.php */