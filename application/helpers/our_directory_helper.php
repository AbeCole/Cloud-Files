<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('build_directory_map'))
{
	function build_directory_map($source_dir, $directory_depth = 0, $hidden = FALSE, $relative_parent = '')
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
					$filedata[$file] = build_directory_map($source_dir.$file.DIRECTORY_SEPARATOR, $new_depth, $hidden, $relative_parent . '/' . $file);
				}
				else
				{
					$filedata[$file] = array('name' => $file, 'relative_path' => $relative_parent . '/', 'absolute_path' => $source_dir, 'size' => filesize($source_dir.$file), 'date' => filemtime($source_dir.$file));
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
	function build_folder_dropdown($folders = array(), $parents = '', $excludes = array(), $select = '') {

		if ( ! is_array($excludes))
		{
			$excludes = array($excludes);
		}

		$return = '';
		foreach ($folders as $name => $children) 
		{
			
			$value = $parents . rawurlencode($name) . '/';
			
			if ( ! in_array($value, $excludes) )
			{
				$return .= '<option value="' . $value . '"' . ($select == $value ? ' selected' : '') . '>' . rawurldecode($parents) . $name . '</option>';
			
				if (count($children) > 0)
				{
					$return .= build_folder_dropdown($children, $parents . rawurlencode($name) . '/', $excludes, $select);
				}
			}
			
		}
		
		return $return;
		
	}
	function reverse_filter_uri($str)
	{
		// Convert entities to programatic characters
		$good	= array('$',		'(',		')',		'%28',		'%29',		' ',	'%');
		$bad	= array('&#36;',	'&#40;',	'&#41;',	'&#40;',	'&#41;',	'%20',	'%25');

		return str_replace($bad, $good, $str);
	}
	function prep_cloud_url($str) {
		$str = rawurlencode(reverse_filter_uri($str));
		
		return $str;
	}
	function prep_path($str)
	{
		if (substr($str, 0, 9) == 'download/')
		{
			$str = substr($str, 9);
		}
		if (substr($str, 0, 5) == 'home/') 
		{
			$str = substr($str, 5);
		}
	
		return rawurldecode($str);	
	}
}

/* End of file our_directory.php */
/* Location: ./application/helpers/our_directory.php */