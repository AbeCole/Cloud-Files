<?php
class file_model extends CI_Model {

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
		if (!is_dir($path)) {
			return 'The cloud location is invalid';
		}
		if ($parent != FALSE) {
			$path .= $parent;
		}
		$files = build_directory_map($path);

		return $files;
	}
	public function get_file_path($file = '')
	{
		$path = $this->config->item('cloud_path');
		if (!is_dir($path)) {
			return 'The cloud location is invalid';
		}
		if ($file == '') {
			return 'The file requested is invalid';
		}
		
		if (substr($file, 0, 9) == 'download/') {
			$file = substr($file, 9);
		}			
		$path .= $file;
		
		if (!is_file($path)) {
			
			return 'The file requested could not be found';
			
		} else {
			
			return array('location' => $path, 'size' => filesize($path));
			
		}
	}
	public function del_file($file = '')
	{
		$path = $this->config->item('cloud_path');
		if (!is_dir($path)) {
			return 'The cloud location is invalid';
		}
		if ($file == '') {
			return 'The file requested is invalid';
		}
			
		$path .= $file;
		
		if (!is_file($path)) {
			
			return 'The file requested could not be found';
			
		} else {
			
			unlink($path);
			return 'success';
			
		}
	}
	public function rename_file($oldfile = '', $newfile = '')
	{
		$path = $this->config->item('cloud_path');
		if (!is_dir($path)) {
			return 'The cloud location is invalid';
		}
		if ($oldfile == '') {
			return 'The file requested is invalid';
		}
		
		if (!is_file($path . $oldfile)) {
			
			return 'The file requested could not be found' . $path . '--';
			
		} else {
			
			rename($path . $oldfile, $path . $newfile);
			return 'success';
			
		}
	}
	public function get_folders($exclude = FALSE)
	{
		$path = $this->config->item('cloud_path');
		if (!is_dir($path)) {
			return 'The cloud location is invalid';
		}
		
		$files = build_directory_structure($path, 0, FALSE, $exclude);

		return $files;
	}
	public function move_file($file = '', $location = '', $dest = '')
	{
		$path = $this->config->item('cloud_path');
		if (!is_dir($path)) {
			return 'The cloud location is invalid';
		}
		if (($file == '') || ($dest == '')) {
			return 'The file requested is invalid';
		}
		
		if (!is_file($path . $location . $file)) {
			
			return 'The file requested could not be found' . $path . $location . '--';
			
		} else {
			
			rename($path . $location . $file, $path . $dest . '/' . $file);
			return 'success';
			
		}
	}
	public function upload_file($file = '', $dest = '') 
	{
		$path = $this->config->item('cloud_path');
		if (!is_dir($path)) {
			return 'The cloud location is invalid';
		}
		if ($dest == '') {
			return 'The request destination is invalid';
		}
		
		$config['upload_path'] = $path . $dest;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($file))
		{
			$error = array('error' => $this->upload->display_errors());

			return $error;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			return 'success';
		}
		
	}
	public function del_folder($folder = '')
	{
		$path = $this->config->item('cloud_path');
		if (!is_dir($path)) {
			return 'The cloud location is invalid';
		}
		if ($folder == '') {
			return 'The file requested is invalid';
		}
			
		$path .= $folder;
		
		if (!is_dir($path)) {
			
			return 'The folder requested could not be found ' . $path;
			
		} else {
			
			$this->deleteDirectory($path);
			return 'success';
			
		}
	}
	public function rename_folder($oldfolder = '', $newfolder = '')
	{
		$path = $this->config->item('cloud_path');
		if (!is_dir($path)) {
			return 'The cloud location is invalid';
		}
		if ($oldfolder == '') {
			return 'The folder requested is invalid';
		}
		
		if (!is_dir($path . $oldfolder)) {
			
			return 'The file requested could not be found';
			
		} elseif (is_dir($path . $newfolder)) {
		
			return 'There is already a folder with this name';
			
		} else {
			
			rename($path . $oldfolder, $path . $newfolder);
			return 'success';
			
		}
	}
	public function move_folder($folder = '', $location = '', $dest = '')
	{
		$path = $this->config->item('cloud_path');
		if (!is_dir($path)) {
			return 'The cloud location is invalid';
		}
		if (($folder == '') || ($dest == '')) {
			return 'The folder requested is invalid';
		}
		
		if (!is_dir($path . $location . $folder)) {
			
			return 'The folder requested could not be found' . $path . $location;
			
		} else {
			
			rename($path . $location . $folder, $path . $dest . '/' . $folder);
			return 'success';
			
		}
	}
	public function create_folder($file = '', $dest = '') 
	{
		$path = $this->config->item('cloud_path');
		if (!is_dir($path)) {
			return 'The cloud location is invalid';
		}
		if ($dest == '') {
			return 'The request destination is invalid';
		}
		
		$config['upload_path'] = $path . $dest;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($file))
		{
			$error = array('error' => $this->upload->display_errors());

			return $error;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			return 'success';
		}
		
	}
	public function deleteDirectory($dir) { 
	    if (!file_exists($dir)) return true; 
	    if (!is_dir($dir) || is_link($dir)) return unlink($dir); 
        foreach (scandir($dir) as $item) { 
            if ($item == '.' || $item == '..') continue; 
            if (!$this->deleteDirectory($dir . "/" . $item)) { 
                chmod($dir . "/" . $item, 0777); 
                if (!$this->deleteDirectory($dir . "/" . $item)) return false; 
            }; 
        } 
        return rmdir($dir); 
	}
}