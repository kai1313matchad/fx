<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transactions extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_crud','crud');
	}

	public function submit_accprc()
	{
		$status = $this->input->post('accprc_sts');
		if ($status == '2')
		{
			$table = 'acc_purchase';
		    $data = array(
		    		'prc_sts' => $status
		            );
		   	$update = $this->crud->update($table,$data,array('prc_id' => $this->input->post('trx_id')));
		   	$table2 = 'user_account';
		    $data2 = array(
		    		'uacc_sts' => $status,
		    		'uacc_saldo' => $this->input->post('from_amount')
		            );
		   	$update2 = $this->crud->update($table2,$data2,array('uacc_id' => $this->input->post('uacc_id')));
		    echo json_encode(array("status" => TRUE));
		}
		else 
		{
			$table = 'acc_purchase';
		    $data = array(
		    		'prc_sts' => $status
		            );
		   	$update = $this->crud->update($table,$data,array('prc_id' => $this->input->post('trx_id')));
		   	$table2 = 'user_account';
		    $data2 = array(
		    		'uacc_sts' => $status,
		    		'uacc_saldo' => 0
		            );
		   	$update2 = $this->crud->update($table2,$data2,array('uacc_id' => $this->input->post('uacc_id')));
		    echo json_encode(array("status" => TRUE));
		}
	}

	public function submit_depo()
	{
		$status = $this->input->post('accprc_sts');
		if ($status == '2')
		{
			$table = 'deposit';
		    $data = array(
		    		'depo_sts' => $status
		            );
		   	$update = $this->crud->update($table,$data,array('depo_id' => $this->input->post('trx_id')));
		   	$dt = $this->crud->get_by_id('user_account',array('uacc_id' => $this->input->post('uacc_id')));
		   	$old = $dt->UACC_SALDO;
		   	$curr = $old + $this->input->post('from_amount');
		   	$table2 = 'user_account';
		    $data2 = array(
		    		'uacc_sts' => $status,
		    		'uacc_saldo' => $curr
		            );
		   	$update2 = $this->crud->update($table2,$data2,array('uacc_id' => $this->input->post('uacc_id')));
		    echo json_encode(array("status" => TRUE));
		}
	}

	//validations
	public function _validate_()
	{
		$data = array();
	        $data['error_string'] = array();
	        $data['inputerror'] = array();
	        $data['status'] = TRUE;
	 
	        if($this->input->post('code') == '')
	        {
	            $data['inputerror'][] = 'code';
	            $data['status'] = FALSE;
	        }

	        if($data['status'] === FALSE)
	        {
	            echo json_encode($data);
	            exit();
	        }
	}
}
