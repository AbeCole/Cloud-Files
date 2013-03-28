<?php
class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('file_model'));
		$this->load->library('session');
		$this->load->helper(array('url','number'));
		
		$this->users_model->logged_in();
	}
	public function index()
	{
	
		$data['username'] = $this->session->userdata('username');
		$data['breadcrumb'] = $this->uri->segment_array();	
		
		$crumbs = count($data['breadcrumb']);
		$i = 1;
		if ($crumbs > 1)
		{
			$data['parent'] = '';
			for ($i = 1; $i < $crumbs; $i++)
			{
			    $data['parent'] .= prep_url($data['breadcrumb'][$i]) . '/';
			}
		}
		
		$data['current'] = prep_url($data['breadcrumb'][$i]);
		$data['title'] = ucfirst(reverse_filter_uri($data['breadcrumb'][$i]));
		
		$data['files'] = $this->file_model->get_files(uri_string() . '/');
				
		$this->load->view('templates/header', $data);
		$this->load->view('pages/home', $data);
		$this->load->view('templates/footer', $data);
	
	}
	public function error() 
	{
	
		$data['title'] = "Sorry, we couldn't find the page you were looking for";
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/error', $data);
		$this->load->view('templates/footer', $data);
		
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
