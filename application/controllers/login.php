<?php
class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		
	}
	public function index()
	{
		$data['title'] = $this->config->item('cloud_name') . ' - Welcome, please login';
		
		$this->load->helper('form');
		$this->load->model('users_model');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$data['user'] = $this->input->post('username',TRUE);
			$data['pass'] = $this->input->post('password',TRUE);
			$user = $this->users_model->get_users($data['user']);
			
			if (is_array($user)) 
			{
				if ($data['pass'] == $user['password']) 
				{
					$userdata = array(
	                   'username'  => $data['user'],
	                   'logged_in' => TRUE
	                );
	                	
	                $this->load->library('session');
	               	$this->session->set_userdata($userdata);
					redirect('/', 'refresh');
				} 
				else 
				{
					$data['error'] = "Sorry, We couldn't find a user with those details";
				}
			} 
			else 
			{
				$data['error'] = "Sorry, We couldn't find a user with those details";
			}			
		}
		$this->load->view('templates/header', $data);
		$this->load->view('pages/login', $data);
		$this->load->view('templates/footer', $data);
	
	}
	public function logout()
	{
	    $this->load->library('session');
		$this->session->unset_userdata(array('logged_in' => '','username' => ''));
		redirect('/', 'refresh');	
	}
}
?>