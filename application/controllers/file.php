<?php
class File extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('file_model'));
		$this->load->library('session');
		$this->load->helper(array('url','number'));
		
		$this->users_model->logged_in();
	}
	public function move($file = '') 
	{
		if (($dest = $this->input->post('destination')) != '') 
		{
		
			$path = $this->input->post('path');
			if ($this->input->post('cancel') == 'Cancel') 
			{
				
				redirect($path, 'refresh');
			
			}
			
			$file = $this->input->post('current-name', TRUE);
			if (($return = $this->file_model->move_file($file, $path, $dest)) == 'success') 
			{
				redirect($dest, 'refresh');
			} 
			else 
			{
				echo $return;
			}
			
		}
				
		$segs = $this->uri->segment_array();
		$parent = '';
		for ($i = 3; $i < count($segs); $i++)
		{
		    $parent .= prep_cloud_url($segs[$i]) . '/';
		}
		
		$data['title'] = 'Move File';
		$data['path'] = $parent;
		$data['current_name'] = rawurldecode($segs[$i]);
		$data['folders'] = $this->file_model->get_folders();
		$data['type'] = 'file';
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/move', $data);
		$this->load->view('templates/footer', $data);
	}
	public function rename($file = '') 
	{
		if (($name = $this->input->post('name', TRUE)) != '') 
		{
		
			$path = $this->input->post('path');
			if ($this->input->post('cancel') == 'Cancel') 
			{
				
				redirect($path, 'refresh');
			
			}
			
			if (($return = $this->file_model->rename_file($path, $this->input->post('oldname', TRUE), $name)) == 'success') 
			{
				redirect($path, 'refresh');
			} 
			else 
			{
				echo $return;
			}
			
		}
		
		$segs = $this->uri->segment_array();
		$parent = '';
		for ($i = 3; $i < count($segs); $i++)
		{
		    $parent .= prep_cloud_url($segs[$i]) . '/';
		}
		
		$data['title'] = 'Rename File';
		$data['path'] = $parent;
		$data['current_name'] = rawurldecode($segs[$i]);
		$data['type'] = 'file';
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/rename', $data);
		$this->load->view('templates/footer', $data);
	}
	public function delete($file = '') 
	{
		if (($file = $this->input->post('name', TRUE)) != '') 
		{
		
			$path = $this->input->post('path');
			if ($this->input->post('cancel') == 'Cancel') 
			{
				
				redirect($path, 'refresh');
			
			}
			
			if (($return = $this->file_model->delete_file($path, $file)) == 'success') 
			{
				redirect($path, 'refresh');
			} 
			else 
			{
				echo $return;
			}
			
		}
		
		$segs = $this->uri->segment_array();
		$parent = '';
		for ($i = 3; $i < count($segs); $i++)
		{
		    $parent .= prep_cloud_url($segs[$i]) . '/';
		}
		
		$data['title'] = 'Delete File';
		$data['path'] = $parent;
		$data['name'] = rawurldecode($segs[$i]);
		$data['type'] = 'file';
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/delete', $data);
		$this->load->view('templates/footer', $data);
		
	}
	public function link($file = '') 
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
		$data['path'] = $parent;
		$data['name'] = rawurldecode($segs[$i]);
		$data['type'] = 'file';
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/link', $data);
		$this->load->view('templates/footer', $data);
		
	}
	public function upload($dest = '') 
	{
	
		if ($this->input->post('cancel') == 'Cancel') 
		{
		
			$path = $this->input->post('path');
			redirect($path, 'refresh');
			
		}	
		
		if (($dest = $this->input->post('destination')) != '') {

			$file = $this->input->post('userfile', TRUE);

			$path = $this->config->item('cloud_path');
			$config['upload_path'] = $path . prep_path($dest);
			$config['allowed_types'] = '*';
			
			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload() )
			{
			
				echo $this->upload->display_errors();
			
			}
			else
			{
				
				$this->session->set_flashdata('upload', $this->upload->data()['file_name']);
				redirect('/' . $dest, 'refresh');
				
			}

		}	
		
		$segs = $this->uri->segment_array();
		$parent = '';
		for ($i = 3; $i <= count($segs); $i++)
		{
		    $parent .= prep_cloud_url($segs[$i]) . '/';
		}
		
		$data['title'] = 'Upload File';
		$data['path'] = $parent;
		$data['folders'] = $this->file_model->get_folders();
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/upload', $data);
		$this->load->view('templates/footer', $data);
		
	}
		
}

/* End of file file.php */
/* Location: ./application/controllers/file.php */
