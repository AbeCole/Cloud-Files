<?php
class Folder extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('file_model'));
		$this->load->library('session');
		$this->load->helper(array('url','number'));
		
		$this->users_model->logged_in();
	}
	public function delete($folder = '') 
	{
		$segs = $this->uri->segment_array();
		
		$parent = '';
		for ($i = 3; $i < count($segs); $i++)
		{
		    $parent .= $segs[$i] . '/';
		}
		$path = $parent . $segs[$i];
	
		if (($return = $this->file_model->del_folder(rawurldecode($path))) == 'success') {
			redirect('/home/' . $parent, 'refresh');
		} else {
			echo 'qweqwe' . $return;
		}
	}
	public function rename($folder = '') 
	{
		if (($name = $this->input->post('name', TRUE)) != '') {
		
			$path = $this->input->post('path', TRUE);
			if (($return = $this->file_model->rename_folder($path . $this->input->post('oldname', TRUE), $path . $name)) == 'success') {
				redirect('/home/' . $path, 'refresh');
			} else {
				echo 'qweqwe' . $return;
			}
			
		}
		$segs = $this->uri->segment_array();
		
		$parent = '';
		for ($i = 3; $i < count($segs); $i++)
		{
		    $parent .= $segs[$i] . '/';
		}
		$path = $parent . $segs[$i];
		
		$data['path'] = rawurldecode($parent);
		$data['folder'] = rawurldecode($segs[$i]);
		$data['title'] = 'Rename Folder';
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/rename-folder', $data);
		$this->load->view('templates/footer', $data);
	}
	public function move($folder = '') 
	{
		if (($dest = str_replace(' -> ','/',$this->input->post('destination', TRUE))) != '') {
		
			$path = $this->input->post('path', TRUE);
			$folder = $this->input->post('folder', TRUE);
			if (($return = $this->file_model->move_folder($folder, $path, $dest)) == 'success') {
				redirect('/home/' . $dest, 'refresh');
			} else {
				echo $return;
			}
			
		}
		$segs = $this->uri->segment_array();
		
		$parent = '';
		for ($i = 3; $i < count($segs); $i++)
		{
		    $parent .= $segs[$i] . '/';
		}
		$path = $parent . $segs[$i];
		
		$data['path'] = $parent;
		$data['title'] = 'Move Folder';
		$data['folder'] = $segs[$i];
		$data['folders'] = $this->file_model->get_folders();
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/move-folder', $data);
		$this->load->view('templates/footer', $data);
	}
	public function upload($dest = '') 
	{
		if (($dest = str_replace(' -> ','/',$this->input->post('destination', TRUE))) != '') {
			
			if ($dest == '/') $dest = '';
			
			$file = $this->input->post('userfile', TRUE);
				
			$path = $this->config->item('cloud_path');
			$config['upload_path'] = $path . $dest;
			$config['allowed_types'] = '*';
	
			$this->load->library('upload', $config);
	
			if ( ! $this->upload->do_upload())
			{
				$error = array('error' => $this->upload->display_errors());
	
				print_r($error);
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
	
				echo 'success' . $config['upload_path'];
			}
			
		}
		
		$data['title'] = 'Upload File';
		$data['folders'] = $this->file_model->get_folders();
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/upload', $data);
		$this->load->view('templates/footer', $data);
	}
	
	
}