<?php
class File extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('file_model'));
		$this->load->library('session');
		$this->load->helper(array('url','number'));
		
		if ($this->session->userdata('logged_in') != TRUE) {
			
			redirect('/', 'refresh');
			
		}
	}
	public function delete($file = '') 
	{
		$segs = $this->uri->segment_array();
		
		$parent = '';
		for ($i = 3; $i < count($segs); $i++)
		{
		    $parent .= $segs[$i] . '/';
		}
		$path = $parent . $segs[$i];
	
		if (($return = $this->file_model->del_file($path)) == 'success') {
			redirect('/' . $parent, 'refresh');
		} else {
			echo $return;
		}
	}
	public function rename($file = '') 
	{
		if (($name = $this->input->post('name', TRUE)) != '') {
		
			$path = $this->input->post('path', TRUE);
			if (($return = $this->file_model->rename_file($path . $this->input->post('oldname', TRUE), $path . $name)) == 'success') {
				redirect('/' . rawurlencode(substr($path,0,-1)), 'refresh');
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
		
		$data['path'] = rawurldecode($parent);
		$data['file'] = rawurldecode($segs[$i]);
		$data['title'] = 'Rename File';
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/rename', $data);
		$this->load->view('templates/footer', $data);
	}
	public function move($file = '') 
	{
		if (($dest = str_replace(' -> ','/',$this->input->post('destination', TRUE))) != '') {
		
			$path = $this->input->post('path', TRUE);
			$file = $this->input->post('file', TRUE);
			if (($return = $this->file_model->move_file($file, $path, $dest)) == 'success') {
				redirect('/' . $dest, 'refresh');
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
		$data['title'] = 'Move File';
		$data['file'] = rawurldecode($segs[$i]);
		$data['folders'] = $this->file_model->get_folders();
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/move', $data);
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
	
			if ( ! $this->upload->do_upload() )
			{
				$error = array('error' => $this->upload->display_errors());
	
				print_r($error);
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());

				redirect('/' . $dest, 'refresh');
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