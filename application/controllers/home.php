<?php
class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('users_model','file_model'));
		$this->load->library('session');
		$this->load->helper(array('url','number'));
		
		if ($this->session->userdata('logged_in') != TRUE) {
			
			redirect('/login', 'refresh');
			
		}
	}
	public function index()
	{
		$data['title'] = 'Home';
		$data['username'] = $this->session->userdata('username');
		$data['current'] = '';
				
		$data['files'] = $this->file_model->get_files();
	
		$this->load->view('templates/header', $data);
		$this->load->view('pages/home', $data);
		$this->load->view('templates/footer', $data);
	
	}
	public function view($directory = '')
	{
		$data['page'] = 'home-view';
		$data['title'] = 'Home';
		$data['username'] = $this->session->userdata('username');
		
		$segs = $this->uri->segment_array();
		
		$data['parent'] = base_url();
		for ($i = 1; $i < count($segs); $i++)
		{
		    $data['parent'] .= $segs[$i] . '/';
		}
		$data['current'] = $segs[$i] . '/';
		
		$directory = str_replace('home/','',uri_string());
		
		$data['files'] = $this->file_model->get_files(urldecode($directory));
	
		$this->load->view('templates/header', $data);
		$this->load->view('pages/home', $data);
		$this->load->view('templates/footer', $data);
	
	}
}
?>