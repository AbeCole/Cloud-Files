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
			
				$this->session->set_flashdata('errors', $this->upload->display_errors());
				redirect('/' . $dest, 'refresh');
			
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
	public function multi($file = '') 
	{	
	
		$files = $this->input->post('multi-file');
		$folders = $this->input->post('multi-folder');
		$path = $this->input->post('path');
		$multi_all = $this->input->post('multi-all');
		
		if ($this->input->post('cancel') == 'Cancel')
		{
			redirect($path, 'refresh');
		} 
		else if (empty($files) && empty($folders) && $multi_all != 'All' )
		{
			$this->session->set_flashdata('errors', 'No files or folders were selected');
			redirect('/' . $path, 'refresh');
		}
		else if ($multi_all == 'All') 
		{
			$contents = $this->file_model->get_folder_contents($path);
			$files = $contents['files'];
			$folders = $contents['folders'];
		}
		
		if ($this->input->post('multi-delete') == 'Delete Multiple')
		{
			$this->multi_delete($path, $files, $folders);
		}
		else if ($this->input->post('confirm-delete') == 'Confirm')
		{
			$this->multi_delete($path, $files, $folders, TRUE);
		}
		else if ($this->input->post('multi-download') == 'Download Multiple')
		{
			$this->multi_download($path, $files, $folders, TRUE);	
		}
		
	}
	private function multi_delete($path = '', $files = array(), $folders = array(), $confirmed = FALSE)
	{
		if ($confirmed == TRUE) 
		{
			if (($return = $this->file_model->delete_multiple($path, $files, $folders)) == 'success') 
			{
				redirect($path, 'refresh');
			} 
			else 
			{
				
				$this->session->set_flashdata('errors', $return);
				redirect('/' . $path, 'refresh');
				
			}
		}
		
		$data['title'] = 'Delete Multiple';
		$data['path'] = $path;
		$data['folders'] = $folders;
		$data['files'] = $files;
		
		$this->load->helper('form');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/delete-multi', $data);
		$this->load->view('templates/footer', $data);
		
	}
	private function multi_download($path = '', $files = array(), $folders = array())
	{
		
		$this->load->library('zip');
			
		if ( ! empty($folders))
		{
			for ($i = 0; $i < count($folders); $i++) 
			{
			
				$folder_info = $this->file_model->get_folder_info($path . $folders[$i] . '/');
				
				if (is_array($folder_info)) 
				{
					
					$this->zip->read_dir_including_empty($folder_info['absolute_path'], FALSE);
					
				} 
				else 
				{
				
					$errors[] = $folder_info;
					
				}
				
			}
		}
			
		if ( ! empty($files))
		{
			for ($i = 0; $i < count($files); $i++) 
			{
				$file_info = $this->file_model->get_file_info($path . $files[$i]);
			
				if (is_array($file_info)) 
				{
					
					$this->zip->read_file($file_info['location']);
	
				} 
				else 
				{
				
					$errors[] = $file_info;
					
				}
			}
		}
			
		$name = url_title($this->config->item('cloud_name')) . '-' . date("Y-m-d-H-i", time()) . '.zip';
		$this->zip->download($name);
		
		if (isset($errors)) 
		{
			$this->session->set_flashdata('errors', $errors);
			redirect($path, 'refresh');
		}
		
	}
}

/* End of file file.php */
/* Location: ./application/controllers/file.php */
