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
		$data['title'] = 'Home';
		$data['username'] = $this->session->userdata('username');
		
		$segs = $this->uri->segment_array();
		
		$data['parent'] = '';
		for ($i = 1; $i < count($segs); $i++)
		{
		    $data['parent'] .= rawurlencode(reverse_filter_uri($segs[$i])) . '/';
		}
		$data['current'] = rawurlencode(reverse_filter_uri($segs[$i])) . '/';
		
		$directory = uri_string();
		
		$data['files'] = $this->file_model->get_files(urldecode($directory));
	
		$this->load->view('templates/header', $data);
		$this->load->view('pages/home', $data);
		$this->load->view('templates/footer', $data);
	
	}
	public function error() {
		$data['title'] = "Sorry, we couldn't find the page you were looking for";
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/error', $data);
		$this->load->view('templates/footer', $data);
	}
}
?>