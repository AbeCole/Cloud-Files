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
	
		$data['username'] = $this->session->userdata('username');
		$data['breadcrumb'] = $this->uri->segment_array();
		$data['title'] = 'Home';
		$data['current'] = 'home';
				
		$data['files'] = $this->file_model->get_files();
	
		$this->load->view('templates/header', $data);
		$this->load->view('pages/home', $data);
		$this->load->view('templates/footer', $data);
	
	}
	public function view($directory = '')
	{
	
		$data['username'] = $this->session->userdata('username');
		$data['breadcrumb'] = $this->uri->segment_array();	
	
		$data['parent'] = '';
		for ($i = 1; $i < count($data['breadcrumb']); $i++)
		{
		    $data['parent'] .= prep_url($data['breadcrumb'][$i]) . '/';
		}
		$data['current'] = prep_url($data['breadcrumb'][$i]) . '/';
		$data['title'] = ucfirst(reverse_filter_uri($data['breadcrumb'][$i]));
		
		$data['files'] = $this->file_model->get_files(rawurldecode(str_replace('home/','',uri_string())));
	
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