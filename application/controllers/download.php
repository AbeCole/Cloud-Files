<?php
class Download extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('file_model'));
		$this->load->library('session');
		$this->load->helper('url');
		
		$this->users_model->logged_in();
	}
	public function index($file = '')
	{
	
		$data['title'] = 'Download';
		
		$file_info = $this->file_model->get_file_path(uri_string());
		
		if (is_array($file_info)) {
			
			if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}
			
			$this->output
				->set_content_type('application/force-download') // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
				->set_output(file_get_contents($file_info['location']));
			
		} else {
			
			echo 'There was an error: <br />' . $file_info;
			
		}
	
	}
}

/* End of file download.php */
/* Location: ./application/controllers/download.php */
