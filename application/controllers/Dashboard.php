<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_crud','crud');
	}

	public function index()
	{
		$data['content']='dashboard/menu/home';
		$this->load->view('dashboard/layout/wrapper',$data);
	}

	public function subscribe()
	{
	    $table = 'subscribe';
	    $data = array(
	            'SUBS_NAME' => $this->input->post('name'),
	            'SUBS_EMAIL' => $this->input->post('email'),
	            'SUBS_STS' => '1'
	        );
	    $insert = $this->crud->save($table,$data);
	    echo json_encode(array("status" => TRUE));
	}

	public function login()
	{
		$this->load->view('dashboard/menu/login');
	}

	public function loggedin()
	{
		$valid = $this->form_validation;
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$valid->set_rules('username','Username','required');
		$valid->set_rules('password','Password','required');
		if($valid->run())
		{
			$this->simple_login->login($username,$password);
		}		
	}

	public function register()
	{		
		$this->load->view('dashboard/menu/register');		
	}	

	public function validate_reg()
	{
		$data = array();
	    $data['error_string'] = array();
	    $data['inputerror'] = array();
	    $data['status'] = TRUE;
	 
	    if($this->input->post('password') != $this->input->post('password2'))
	    {
	        $data['inputerror'][] = 'password2';	        
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('fullname') == '')
	    {
	        $data['inputerror'][] = 'fullname';	        
	        $data['status'] = FALSE;
	    }

	    $this->form_validation->set_rules('email', 'Email', 'valid_email');
	    if($this->form_validation->run() == FALSE)
	    {
	        $data['inputerror'][] = 'email';	        
	        $data['status'] = FALSE;
	    }

	    $this->form_validation->set_rules('email', 'Email', 'is_unique[user.USERNAME]');
	    if($this->form_validation->run() == FALSE)
		{
		    $data['inputerror'][] = 'email';
		    $data['status'] = FALSE;
		}

	    if($this->input->post('email') == '')
	    {
	        $data['inputerror'][] = 'email';	        
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('password') == '')
	    {
	        $data['inputerror'][] = 'password';	        
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('password2') == '')
	    {
	        $data['inputerror'][] = 'password2';	        
	        $data['status'] = FALSE;
	    }

	    if($data['status'] === FALSE)
	    {
	        echo json_encode($data);
	        exit();
	    }
	}

	public function registration()
	{
		$this->validate_reg();
		$data = array(
	            'username' => $this->input->post('email'),
	            'password' => $this->input->post('password'),
	            'user_sts' => '1',
	            'user_acc' => 'user'
	        );
	    $insert = $this->crud->save('user',$data);
	    $insertId = $this->db->insert_id();
	    $data2 = array(
	    		'user_id' => $insertId,
	    		'udt_name' => $this->input->post('fullname')
	    	);
	    $insert = $this->crud->save('user_data',$data2);
		echo json_encode(array("status" => TRUE));
	}
}
