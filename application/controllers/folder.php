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
	public function move($folder = '') 
	{

		if (($dest = $this->input->post('destination')) != '') 
		{
		
			$path = $this->input->post('path');
			if ($this->input->post('cancel') == 'Cancel') 
			{
				
				redirect($path, 'refresh');
			
			}
			
			$name = $this->input->post('current-name', TRUE);
			if (($return = $this->file_model->move_folder($name, $path, $dest)) == 'success') 
			{
				redirect($dest, 'refresh');
			} 
			else 
			{
				$this->session->set_flashdata('errors', $return);
				redirect($dest, 'refresh');
			}
			
		}
				
		$segs = $this->uri->segment_array();
		$parent = '';
		for ($i = 3; $i < count($segs); $i++)
		{
		    $parent .= prep_cloud_url($segs[$i]) . '/';
		}
		
		$data['title'] = 'Move Folder';
		$data['path'] = $parent;
		$data['current_name'] = prep_cloud_url($segs[$i]);
		$data['folders'] = $this->file_model->get_folders();
		$data['type'] = 'folder';
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/move', $data);
		$this->load->view('templates/footer', $data);		
		
	}
	public function rename($folder = '') 
	{
	
		if (($name = $this->input->post('name', TRUE)) != '') 
		{
		
			$path = $this->input->post('path');
			if ($this->input->post('cancel') == 'Cancel') 
			{
				
				redirect($path, 'refresh');
			
			}
			
			$oldname = $this->input->post('oldname', TRUE);
			if (($return = $this->file_model->rename_folder($path, $oldname, $name)) == 'success') 
			{
				redirect($path, 'refresh');
			} 
			else 
			{
				$this->session->set_flashdata('errors', $return);
				redirect('/folder/rename/' . $path . $oldname . '/', 'refresh');
			}
			
		}
		
		$segs = $this->uri->segment_array();
		$parent = '';
		for ($i = 3; $i < count($segs); $i++)
		{
		    $parent .= prep_cloud_url($segs[$i]) . '/';
		}
		
		$data['title'] = 'Rename Folder';
		$data['path'] = $parent;
		$data['current_name'] = rawurldecode($segs[$i]);
		$data['type'] = 'folder';
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/rename', $data);
		$this->load->view('templates/footer', $data);
	}
	public function delete($folder = '') 
	{
		
		if (($folder = $this->input->post('name', TRUE)) != '') 
		{
		
			$path = $this->input->post('path');
			if ($this->input->post('cancel') == 'Cancel') 
			{
				
				redirect($path, 'refresh');
			
			}
			
			if (($return = $this->file_model->delete_folder($path, $folder)) == 'success') 
			{
				redirect($path, 'refresh');
			} 
			else 
			{
				$this->session->set_flashdata('errors', $return);
				redirect($path, 'refresh');
			}
			
		}
		
		$segs = $this->uri->segment_array();
		$parent = '';
		for ($i = 3; $i < count($segs); $i++)
		{
		    $parent .= prep_cloud_url($segs[$i]) . '/';
		}
		
		$data['title'] = 'Delete Folder';
		$data['path'] = $parent;
		$data['name'] = rawurldecode($segs[$i]);
		$data['type'] = 'folder';
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/delete', $data);
		$this->load->view('templates/footer', $data);		
		
	}
	public function link($folder = '') 
	{
		if ($this->input->post('cancel') == 'Cancel') 
		{
		
			$path = $this->input->post('path');
			redirect($path, 'refresh');
			
		}
		
		$segs = $this->uri->segment_array();
		$parent = '';
		for ($i = 3; $i < count($segs); $i++)
		{
		    $parent .= prep_cloud_url($segs[$i]) . '/';
		}
		
		$data['title'] = 'Link for ' . $segs[$i];
		$data['path'] = $parent . prep_cloud_url($segs[$i]) . '/';
		$data['name'] = rawurldecode($segs[$i]);
		$data['type'] = 'folder';
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/link', $data);
		$this->load->view('templates/footer', $data);
		
	}
	public function create($dest = '') 
	{
		
		if ($this->input->post('cancel') == 'Cancel') 
		{
		
			$path = $this->input->post('path');
			redirect($path, 'refresh');
			
		}
		
		if (($path = $this->input->post('path')) != '') {

			$name = $this->input->post('name', TRUE);
			
			if (($return = $this->file_model->create_folder($path, $name)) == 'success') 
			{
				redirect($path, 'refresh');
			} 
			else 
			{
				$this->session->set_flashdata('errors', $return);
				redirect('/folder/create/' . $path, 'refresh');
			}

		}
		
		$segs = $this->uri->segment_array();
		$parent = '';
		for ($i = 3; $i < count($segs); $i++)
		{
		    $parent .= prep_cloud_url($segs[$i]) . '/';
		}
		
		$data['title'] = 'Create folder';
		$data['name'] = $segs[$i];
		$data['path'] = $parent . prep_cloud_url($segs[$i]) . '/';
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/create', $data);
		$this->load->view('templates/footer', $data);
	}
	
	
}