<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Email extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_crud','crud');
	}

	public function email_conf()
	{
		$config = array (
				'protocol'  => 'smtp',
			    'smtp_host' => 'ssl://smtp.gmail.com',
			    'smtp_port' => 465,
			    'smtp_user' => 'kolokolobablo2017@gmail.com',
			    'smtp_pass' => 'kolo1234567890?',
			    'mailtype'  => 'html',
			    'charset'   => 'utf-8'
			);
		$this->email->initialize($config);	
	}

	public function email_content($from,$to,$subj,$content)
	{		
		$this->email->set_newline("\r\n");
		$this->email->to($to);
		$this->email->from($from);
		$this->email->subject($subj);
		$this->email->message($content);
	}

	public function regemail()
	{
		$this->email_conf();
		$from = 'Liquidity Provider Market';
		$to = $this->input->post('email');
		$subj = 'Registration Data';
		$content = 'Your Login Data <br>username: '.$this->input->post('email');
		$this->email_content($from,$to,$subj,$content);
		$data=array();
		if(!$this->email->send())
		{
			$data['errorstring'] = $this->email->print_debugger();
			$data['status'] = FALSE;
			echo json_encode($data);
		}
		else
		{
			$data['status'] = TRUE;
			$data['error'] = $from;
			echo json_encode($data);
		}
	}

	public function sendmail()
	{
		$this->email_conf();
		$from = $this->input->post('Email').'-'.$this->input->post('Name');
		$to = 'kolokolobablo2017@gmail.com';
		$subj = 'Contact Us';
		$content = $this->input->post('Message');
		$this->email_content($from,$to,$subj,$content);
		$data=array();
		if(!$this->email->send())
		{
			$data['errorstring'] = $this->email->print_debugger();
			$data['status'] = FALSE;
			echo json_encode($data);
		}
		else
		{
			$data['status'] = TRUE;
			$data['error'] = $from;
			echo json_encode($data);
		}
	}
}
