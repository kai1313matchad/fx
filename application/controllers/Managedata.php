<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Managedata extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_crud','crud');
	}

	public function add_bank()
	{
		$this->_validate_addbank();
		$table = 'admin_bank';
	    $data = array(
	            'bank_acc' => $this->input->post('add_bankacc'),
	            'bank_name' => $this->input->post('add_bankname'),
	            'bank_accname' => $this->input->post('add_bankaccname')
	        );
	    $insert = $this->crud->save($table,$data);	    
		echo json_encode(array("status" => TRUE));
	}

	public function update_bank()
	{
		$this->_validate_editbank();
		$table = 'admin_bank';
	    $data = array(
	            'bank_acc' => $this->input->post('edit_bankacc'),
	            'bank_name' => $this->input->post('edit_bankname'),
	            'bank_accname' => $this->input->post('edit_bankaccname')
	        );
	    $update = $this->crud->update($table,$data,array('bank_id' => $this->input->post('bank_id')));
		echo json_encode(array("status" => TRUE));
	}

	public function del_bank($id)
	{
	    $this->crud->delete_by_id('admin_bank',array('bank_id' => $id));
        echo json_encode(array("status" => TRUE));
	}

	public function add_curr()
	{
		$this->_validate_addcurr();
		$table = 'currency_rate';
	    $data = array(
	            'curr_name' => $this->input->post('curr_name'),
	            'curr_logo' => $this->input->post('curr_logo'),
	            'curr_rate' => $this->input->post('curr_rate')
	        );
	    $insert = $this->crud->save($table,$data);	    
		echo json_encode(array("status" => TRUE));
	}

	public function update_curr()
	{
		$this->_validate_editcurr();
		$table = 'currency_rate';
	    $data = array(
	            'curr_name' => $this->input->post('edit_name'),
	            'curr_logo' => $this->input->post('edit_logo'),
	            'curr_rate' => $this->input->post('edit_rate')
	        );
	    $update = $this->crud->update($table,$data,array('curr_id' => $this->input->post('curr_id')));
		echo json_encode(array("status" => TRUE));
	}

	public function del_curr($id)
	{
	    $this->crud->delete_by_id('currency_rate',array('curr_id' => $id));
        echo json_encode(array("status" => TRUE));
	}

	public function add_exc()
	{
		$this->_validate_addexc();
		$table = 'exchanger';
	    $data = array(
	            'exc_name' => $this->input->post('exc_name'),
	            'exc_phone' => $this->input->post('exc_phone'),
	            'exc_wa' => $this->input->post('exc_wa'),
	            'exc_bbm' => $this->input->post('exc_bbm'),
	            'exc_email' => $this->input->post('exc_email'),
	            'exc_site' => $this->input->post('exc_site'),
	            'exc_sts' => '1'
	        );
	    $insert = $this->crud->save($table,$data);	    
		echo json_encode(array("status" => TRUE));
	}

	public function update_exc()
	{
		$this->_validate_editexc();
		$table = 'exchanger';
	    $data = array(
	            'exc_name' => $this->input->post('edit_name'),
	            'exc_phone' => $this->input->post('edit_phone'),
	            'exc_wa' => $this->input->post('edit_wa'),
	            'exc_bbm' => $this->input->post('edit_bbm'),
	            'exc_email' => $this->input->post('edit_email'),
	            'exc_site' => $this->input->post('edit_site')
	        );
	    $update = $this->crud->update($table,$data,array('exc_id' => $this->input->post('exc_id')));
		echo json_encode(array("status" => TRUE));
	}

	public function del_exc($id)
	{
	    $this->crud->delete_by_id('exchanger',array('exc_id' => $id));
        echo json_encode(array("status" => TRUE));
	}

	public function add_pck()
	{
		$this->_validate_addpck();
		$table = 'package';
	    $data = array(
	            'pc_name' => $this->input->post('pc_name'),
	            'pc_info' => $this->input->post('pc_info'),
	            'pc_lvrg' => $this->input->post('pc_lvrg'),
	            'pc_depo' => $this->input->post('pc_depo'),
	            'pc_dtsts' => '1'
	        );
	    $insert = $this->crud->save($table,$data);	    
		echo json_encode(array("status" => TRUE));
	}

	public function update_pck()
	{
		$this->_validate_editpck();
		$table = 'package';
	    $data = array(
	            'pc_name' => $this->input->post('edit_name'),
	            'pc_info' => $this->input->post('edit_info'),
	            'pc_lvrg' => $this->input->post('edit_lvrg'),
	            'pc_depo' => $this->input->post('edit_depo'),
	        );
	    $update = $this->crud->update($table,$data,array('pc_id' => $this->input->post('pc_id')));
		echo json_encode(array("status" => TRUE));
	}

	public function del_pck($id)
	{
	    $this->crud->delete_by_id('package',array('pc_id' => $id));
        echo json_encode(array("status" => TRUE));
	}

	//validations
	public function _validate_addbank()
	{
		$data = array();
	        $data['error_string'] = array();	        
	        $data['status'] = TRUE;
	 
	        if($this->input->post('add_bankname') == '')
	        {
	            $data['inputerror'][] = 'add_bankname';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('add_bankacc') == '')
	        {
	            $data['inputerror'][] = 'add_bankacc';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('add_bankaccname') == '')
	        {
	            $data['inputerror'][] = 'add_bankaccname';
	            $data['status'] = FALSE;
	        }

	        if($data['status'] === FALSE)
	        {
	            echo json_encode($data);
	            exit();
	        }
	}

	public function _validate_editbank()
	{
		$data = array();
	        $data['error_string'] = array();	        
	        $data['status'] = TRUE;
	 
	        if($this->input->post('edit_bankname') == '')
	        {
	            $data['inputerror'][] = 'edit_bankname';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('edit_bankacc') == '')
	        {
	            $data['inputerror'][] = 'edit_bankacc';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('edit_bankaccname') == '')
	        {
	            $data['inputerror'][] = 'edit_bankaccname';
	            $data['status'] = FALSE;
	        }

	        if($data['status'] === FALSE)
	        {
	            echo json_encode($data);
	            exit();
	        }
	}

	public function _validate_addcurr()
	{
		$data = array();
	        $data['error_string'] = array();	        
	        $data['status'] = TRUE;
	 
	        if($this->input->post('curr_name') == '')
	        {
	            $data['inputerror'][] = 'curr_name';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('curr_logo') == '')
	        {
	            $data['inputerror'][] = 'curr_logo';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('curr_rate') == '')
	        {
	            $data['inputerror'][] = 'curr_rate';
	            $data['status'] = FALSE;
	        }

	        if($data['status'] === FALSE)
	        {
	            echo json_encode($data);
	            exit();
	        }
	}

	public function _validate_editcurr()
	{
		$data = array();
	        $data['error_string'] = array();	        
	        $data['status'] = TRUE;
	 
	        if($this->input->post('edit_name') == '')
	        {
	            $data['inputerror'][] = 'edit_name';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('edit_logo') == '')
	        {
	            $data['inputerror'][] = 'edit_logo';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('edit_rate') == '')
	        {
	            $data['inputerror'][] = 'edit_rate';
	            $data['status'] = FALSE;
	        }

	        if($data['status'] === FALSE)
	        {
	            echo json_encode($data);
	            exit();
	        }
	}

	public function _validate_addexc()
	{
		$data = array();
	        $data['error_string'] = array();	        
	        $data['status'] = TRUE;
	 
	        if($this->input->post('exc_name') == '')
	        {
	            $data['inputerror'][] = 'exc_name';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('exc_phone') == '')
	        {
	            $data['inputerror'][] = 'exc_phone';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('exc_wa') == '')
	        {
	            $data['inputerror'][] = 'exc_wa';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('exc_bbm') == '')
	        {
	            $data['inputerror'][] = 'exc_bbm';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('exc_email') == '')
	        {
	            $data['inputerror'][] = 'exc_email';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('exc_site') == '')
	        {
	            $data['inputerror'][] = 'exc_site';
	            $data['status'] = FALSE;
	        }

	        if($data['status'] === FALSE)
	        {
	            echo json_encode($data);
	            exit();
	        }
	}

	public function _validate_editexc()
	{
		$data = array();
	        $data['error_string'] = array();	        
	        $data['status'] = TRUE;
	 
	        if($this->input->post('edit_name') == '')
	        {
	            $data['inputerror'][] = 'edit_name';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('edit_phone') == '')
	        {
	            $data['inputerror'][] = 'edit_phone';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('edit_wa') == '')
	        {
	            $data['inputerror'][] = 'edit_wa';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('edit_bbm') == '')
	        {
	            $data['inputerror'][] = 'edit_bbm';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('edit_email') == '')
	        {
	            $data['inputerror'][] = 'edit_email';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('edit_site') == '')
	        {
	            $data['inputerror'][] = 'edit_site';
	            $data['status'] = FALSE;
	        }

	        if($data['status'] === FALSE)
	        {
	            echo json_encode($data);
	            exit();
	        }
	}

	public function _validate_addpck()
	{
		$data = array();
	        $data['error_string'] = array();	        
	        $data['status'] = TRUE;
	 
	        if($this->input->post('pc_name') == '')
	        {
	            $data['inputerror'][] = 'pc_name';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('pc_info') == '')
	        {
	            $data['inputerror'][] = 'pc_info';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('pc_lvrg') == '')
	        {
	            $data['inputerror'][] = 'pc_lvrg';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('pc_depo') == '')
	        {
	            $data['inputerror'][] = 'pc_depo';
	            $data['status'] = FALSE;
	        }

	        if($data['status'] === FALSE)
	        {
	            echo json_encode($data);
	            exit();
	        }
	}

	public function _validate_editpck()
	{
		$data = array();
	        $data['error_string'] = array();	        
	        $data['status'] = TRUE;
	 
	        if($this->input->post('edit_name') == '')
	        {
	            $data['inputerror'][] = 'edit_name';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('edit_info') == '')
	        {
	            $data['inputerror'][] = 'edit_info';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('edit_lvrg') == '')
	        {
	            $data['inputerror'][] = 'edit_lvrg';
	            $data['status'] = FALSE;
	        }

	        if($this->input->post('edit_depo') == '')
	        {
	            $data['inputerror'][] = 'edit_depo';
	            $data['status'] = FALSE;
	        }

	        if($data['status'] === FALSE)
	        {
	            echo json_encode($data);
	            exit();
	        }
	}
}
