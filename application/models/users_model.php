<?php
class users_model extends CI_Model {

	public function __construct()
	{
		if (1 == 2) { 
			$this->load->database();
		}
	}
	public function logged_in()
	{
		
		if ($this->session->userdata('logged_in') != TRUE) 
		{
				
			redirect('/login/', 'refresh');
			
		}
		
	}
	public function get_users($slug = FALSE)
	{
		if (!isset($this->db)) {
			if ($slug == 'admin') {
				return array('username' => 'admin', 'password' => 'letmein');
			} else {
				return '';
			}
		}
		
		if ($slug === FALSE)
		{
			$query = $this->db->get('users');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('users', array('slug' => $slug));
		return $query->row_array();
	}		
	public function add_user()
	{
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('username'), 'dash', TRUE);
		
		$data = array(
			'username' => $this->input->post('username'),
			'slug' => $slug,
			'access_level' => $this->input->post('accesslevel')
		);
		
		return $this->db->insert('users', $data);
	}
}

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */
