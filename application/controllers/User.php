<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_crud','crud');
		$this->load->model('dtb/Dt_account','acc');
		$this->load->model('dtb/Dt_accprc','accprc');
		$this->load->model('dtb/Dt_deposit','depo');
		$this->load->model('dtb/Dt_wd','wd');
		$this->load->model('dtb/Dt_exchanger','exc');
	}

	public function index()
	{
		$data['menu']='dashboard';
		$data['menulist']='';
		$data['content']='user/menu/dashboard';
		$this->load->view('user/layout/wrapper',$data);
	}

	public function logout()
	{
		$this->simple_login->logout();
	}

	public function userinfo()
	{
		$data['menu']='user';
		$data['menulist']='';
		$data['content']='user/menu/userinfo';
		$this->load->view('user/layout/wrapper',$data);
	}

	public function ajax_acc2($id)
	{
		$list = $this->acc->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dat) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dat->UACC_CODE;
			$row[] = $dat->PC_NAME;
			if($dat->UACC_STS == '0')
			{
				$status = '<button class="btn btn-warning">Waiting Fund</button>';
			}
			if($dat->UACC_STS == '1')
			{
				$status = '<button class="btn btn-info">Pending</button>';
			}
			if($dat->UACC_STS == '2')
			{
				$status = '<button class="btn btn-success">Paid</button>';
			}
			$row[] = $status;
			$row[] = '<a href="javascript:void(0)" title="Upload" class="btn btn-sm btn-info btn-responsive" onclick="upload_acc('."'".$dat->UACC_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a>';
				$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->acc->count_all(),
						"recordsFiltered" => $this->acc->count_filtered($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_acc($id)
	{
		$list = $this->accprc->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dat) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dat->PRC_CODE;
			$row[] = $dat->UACC_CODE;
			$row[] = $dat->PRC_DATE;
			$row[] = $dat->PRC_AMOUNT;
			if($dat->PRC_STS == '0')
			{
				$status = '<button class="btn btn-warning">Waiting Fund</button>';
			}
			if($dat->PRC_STS == '1')
			{
				$status = '<button class="btn btn-info">Pending</button>';
			}
			if($dat->PRC_STS == '2')
			{
				$status = '<button class="btn btn-success">Paid</button>';
			}
			$row[] = $status;
			$row[] = '<a href="javascript:void(0)" title="Upload" class="btn btn-sm btn-info btn-responsive" onclick="upload_acc('."'".$dat->PRC_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a>';
				$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->accprc->count_all(),
						"recordsFiltered" => $this->accprc->count_filtered($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_depo($id)
	{
		$list = $this->depo->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dat) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dat->DEPO_CODE;
			$row[] = $dat->UACC_CODE;
			$row[] = $dat->DEPO_DATE;
			$row[] = $dat->DEPO_AMOUNT;
			if($dat->DEPO_STS == '0')
			{
				$status = '<button class="btn btn-warning">Waiting Fund</button>';
			}
			if($dat->DEPO_STS == '1')
			{
				$status = '<button class="btn btn-info">Pending</button>';
			}
			if($dat->DEPO_STS == '2')
			{
				$status = '<button class="btn btn-success">Paid</button>';
			}
			$row[] = $status;
			$row[] = '<a href="javascript:void(0)" title="Upload" class="btn btn-sm btn-info btn-responsive" onclick="upload('."'".$dat->DEPO_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a>';
				$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->depo->count_all(),
						"recordsFiltered" => $this->depo->count_filtered($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_wd($id)
	{
		$list = $this->wd->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dat) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dat->WD_CODE;
			$row[] = $dat->UACC_CODE;
			$row[] = $dat->WD_DATE;
			$row[] = $dat->WD_AMOUNT;
			if($dat->WD_STS == '0')
			{
				$status = '<button class="btn btn-info">Processing</button>';
			}
			if($dat->WD_STS == '1')
			{
				$status = '<button class="btn btn-info">Pending</button>';
			}
			if($dat->WD_STS == '2')
			{
				$status = '<button class="btn btn-success">Paid</button>';
			}
			if($dat->WD_STS == '3')
			{
				$status = '<button class="btn btn-warning">Insuficient Fund</button>';
			}
			$row[] = $status;
			// $row[] = '<a href="javascript:void(0)" title="Upload" class="btn btn-sm btn-info btn-responsive" onclick="upload('."'".$dat->WD_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a>';
				$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->wd->count_all(),
						"recordsFiltered" => $this->wd->count_filtered($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_exc()
	{
		$list = $this->exc->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dat) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dat->EXC_NAME;
			$row[] = $dat->EXC_PHONE;
			$row[] = $dat->EXC_EMAIL;
			$row[] = $dat->EXC_SITE;
			$row[] = '<a href="javascript:void(0)" title="Show" class="btn btn-sm btn-info btn-responsive" onclick="showexc('."'".$dat->EXC_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a>';
				$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->exc->count_all(),
						"recordsFiltered" => $this->exc->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function request()
	{
		$data['menu']='req';
		$data['menulist']='acc_req';
		$data['content']='user/menu/request';
		$this->load->view('user/layout/wrapper',$data);
	}

	public function acc_depo()
	{
		$data['menu']='req';
		$data['menulist']='acc_depo';
		$data['content']='user/menu/request_depo';
		$this->load->view('user/layout/wrapper',$data);
	}

	public function getuserdata($id)
	{
		$data = $this->crud->get_by_id('user_data',array('user_id' => $id));
        echo json_encode($data);
	}

	public function getacc($id)
	{
		$data = $this->crud->get_by_id2('user_account','package','package.pc_id = user_account.pc_id',array('user_id' => $id));
        echo json_encode($data);
	}

	public function getpck()
	{
		$data = $this->crud->get_pck();
        echo json_encode($data);
	}

	public function getpckdata($id)
	{
		$data = $this->crud->get_by_id('package',array('pc_id' => $id));
        echo json_encode($data);
	}

	public function deposit()
	{
		$data['menu']='deposit';
		$data['menulist']='local_depo';
		$data['content']='user/menu/deposit_local';
		$this->load->view('user/layout/wrapper',$data);
	}

	public function getadmdt()
	{
		$data = $this->crud->get_by_id('admin_data', array('adt_access' => 'administrator'));
		echo json_encode($data);
	}

	public function getbank()
	{
		$data = $this->crud->get_bank();
		echo json_encode($data);
	}

	public function getcurr()
	{
		$data = $this->crud->get_curr();
		echo json_encode($data);
	}

	public function getbankdt($id)
	{
		$data = $this->crud->get_by_id('admin_bank', array('bank_id' => $id));
		echo json_encode($data);
	}

	public function getimgdepo($id)
	{
		$data = $this->crud->get_by_id('deposit', array('depo_id' => $id));
		echo json_encode($data);
	}

	public function getimgacc($id)
	{
		$data = $this->crud->get_by_id('acc_purchase', array('prc_id' => $id));
		echo json_encode($data);
	}

	public function getcurrdt($id)
	{
		$data = $this->crud->get_by_id('currency_rate',array('curr_id' => $id));
        echo json_encode($data);
	}

	public function getexc($id)
	{
		$data = $this->crud->get_by_id('exchanger',array('exc_id' => $id));
        echo json_encode($data);
	}

	public function exchanger_depo()
	{
		$data['menu']='deposit';
		$data['menulist']='exchange_depo';
		$data['content']='user/menu/exchanger_local';
		$this->load->view('user/layout/wrapper',$data);
	}

	public function withdraw()
	{
		$data['menu']='withdraw';
		$data['menulist']='local_withdraw';
		$data['content']='user/menu/withdraw_local';
		$this->load->view('user/layout/wrapper',$data);
	}

	public function exchanger_withdraw()
	{
		$data['menu']='withdraw';
		$data['menulist']='exchange_withdraw';
		$data['content']='user/menu/exchanger_local';
		$this->load->view('user/layout/wrapper',$data);
	}

	//CRUD
	public function userdata_save()
	{
		$this->_validate_usdt();
	    $table = 'user_data';
	    $data = array(
	    		'udt_name' => $this->input->post('name'),
	            'udt_address' => $this->input->post('address'),
	            'udt_city' => $this->input->post('city'),
	            'udt_province' => $this->input->post('state'),
	            'udt_postal' => $this->input->post('postal'),
	            'udt_idnumber' => $this->input->post('idnumb')
	            );
	   	$update = $this->crud->update($table,$data,array('udt_id' => $this->input->post('udtid')));
	    echo json_encode(array("status" => TRUE));
	}

	public function user_passchg($id)
	{
		$this->_validate_user_passchg($id);
	    $table = 'user';
	    $data = array(	    		
	            'password' => $this->input->post('newpass')
	            );
	   	$update = $this->crud->update($table,$data,array('user_id' => $id ));
	    echo json_encode(array("status" => TRUE));
	}

	public function user_pinchg()
	{
		$idacc = $this->input->post('acc');
		$this->_validate_user_pinchg($idacc);
	    $table = 'user_account';
	    $data = array(	    		
	            'uacc_pin' => $this->input->post('newpin')
	            );
	   	$update = $this->crud->update($table,$data,array('uacc_id' => $idacc ));
	    echo json_encode(array("status" => TRUE));
	}

	public function req_acc()
	{
		$this->_validate_req();
	    $table = 'user_account';
	    $data = array(
	            'pc_id' => $this->input->post('pck'),
	            'user_id' => $this->input->post('user_id'),
	            'uacc_code' => 'TBD-'.$this->input->post('username'),
	            'uacc_pin' => '12345',
	            'uacc_saldo' => 0,
	            'uacc_sts' => '0'
	        );
	    $insert = $this->crud->save($table,$data);
	    echo json_encode(array("status" => TRUE));
	}

	public function depo_save()
	{
		$this->_validate_depo();
	    $table = 'deposit';
	    $data = array(	            
	            'curr_id' => $this->input->post('curr'),
	            'uacc_id' => $this->input->post('acc'),
	            'user_id' => $this->input->post('user_id'),
	            'bank_id' => $this->input->post('adm_bankid'),
	            'depo_code' => 'DEPO/'.date('dm').'/'.random_string('nozero','5'),
	            'depo_bankaccname' => $this->input->post('acc_name2'),
	            'depo_bankname' => $this->input->post('bank_name2'),
	            'depo_bankacc' => $this->input->post('acc2'),
	            'depo_amount' => $this->input->post('amount'),
	            'depo_date' => date('Y-m-d'),
	            'depo_sts' => '0',
	            'depo_prove' => '0',
	            'depo_unique' => random_string('nozero','5')
	        );
	    $insert = $this->crud->save($table,$data);
	    echo json_encode(array("status" => TRUE));	
	}

	public function acc_depo_save()
	{
		$this->_validate_prc();
	    $table = 'acc_purchase';
	    $data = array(	            
	            'curr_id' => $this->input->post('curr'),
	            'user_id' => $this->input->post('user_id'),
	            'uacc_id' => $this->input->post('acc'),
	            'bank_id' => $this->input->post('adm_bankid'),
	            'prc_code' => 'ACC/'.date('dm').'/'.random_string('nozero','5'),
	            'prc_bankaccname' => $this->input->post('acc_name2'),
	            'prc_bankname' => $this->input->post('bank_name2'),
	            'prc_bankacc' => $this->input->post('acc2'),
	            'prc_amount' => $this->input->post('amount'),
	            'prc_date' => date('Y-m-d'),
	            'prc_prove' => '0',
	            'prc_sts' => '0'
	        );
	    $insert = $this->crud->save($table,$data);
	    echo json_encode(array("status" => TRUE));	
	}

	public function wd_save()
	{
		$this->_validate_wd();
	    $table = 'withdraw';
	    $data = array(	            
	            'curr_id' => $this->input->post('curr'),
	            'uacc_id' => $this->input->post('acc'),
	            'user_id' => $this->input->post('user_id'),
	            'wd_code' => 'WD/'.date('dm').'/'.random_string('nozero','5'),
	            'wd_bankaccname' => $this->input->post('acc_name2'),
	            'wd_bankname' => $this->input->post('bank_name2'),
	            'wd_bankacc' => $this->input->post('acc2'),
	            'wd_amount' => $this->input->post('amount'),
	            'wd_date' => date('Y-m-d'),
	            'wd_sts' => '0',
	            'wd_unique' => random_string('nozero','5')
	        );
	    $insert = $this->crud->save($table,$data);
	    echo json_encode(array("status" => TRUE));	
	}

	public function img_conf()
	{
		$nmfile='img_'.time();
		$config['upload_path']='./assets/up_img/';
		$config['allowed_types']='jpg|jpeg|png';
		$config['max_size']='2000';
		$config['file_name']=$nmfile;
		$this->upload->initialize($config);
	}

	public function uploadimg()
	{
		//upload file
        $data = array();
        $data['error_string'] = '';
        $data['status'] = TRUE;
        if (isset($_FILES['file']['name'])) {
            if (0 < $_FILES['file']['error']) {
                $data['error_string'] = 'Error during file upload' . $_FILES['file']['error'];
            } else {
                    $this->img_conf();
                    if (!$this->upload->do_upload('file')) {
                        $data['error_string'] = $this->upload->display_errors();
                    } else {
                    	$imgpath = $this->input->post('imgpath');
                    	$fileinfo=$this->upload->data();
                    	$path='/assets/up_img/'.$fileinfo['file_name'];
                    	$table = 'deposit';
					    $dt = array(
					    		'depo_prove' => $path,
					    		'depo_sts' => '1'
					            );
					   	$update = $this->crud->update($table,$dt,array('depo_id' => $this->input->post('ids')));
                        $data['error_string'] = 'File successfully uploaded : ' . $fileinfo['file_name'];
                        @unlink('.'.$imgpath);
                    }                
            }
        } else {
            $data['error_string'] = 'Please choose a file';
        }
    	echo json_encode($data);
	}

	public function uploadimg2()
	{
		//upload file
        $data = array();
        $data['error_string'] = '';
        $data['status'] = TRUE;
        if (isset($_FILES['file']['name'])) {
            if (0 < $_FILES['file']['error']) {
                $data['error_string'] = 'Error during file upload' . $_FILES['file']['error'];
            } else {
                    $this->img_conf();
                    if (!$this->upload->do_upload('file')) {
                        $data['error_string'] = $this->upload->display_errors();
                    } else {
                    	$imgpath = $this->input->post('imgpath');
                    	$fileinfo=$this->upload->data();
                    	$path='/assets/up_img/'.$fileinfo['file_name'];
                    	$table = 'acc_purchase';
					    $dt = array(
					    		'prc_prove' => $path,
					    		'prc_sts' => '1'
					            );
					   	$update = $this->crud->update($table,$dt,array('prc_id' => $this->input->post('idsa')));
                        $data['error_string'] = 'File successfully uploaded : ' . $fileinfo['file_name'];
                        @unlink('.'.$imgpath);
                    }                
            }
        } else {
            $data['error_string'] = 'Please choose a file';
        }
    	echo json_encode($data);
	}

	public function _validate_usdt()
	{
		$data = array();
	    $data['error_string'] = array();
	    $data['inputerror'] = array();
	    $data['status'] = TRUE;

	    if($this->input->post('name') == '')
	    {
	        $data['inputerror'][] = 'name';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('address') == '')
	    {
	        $data['inputerror'][] = 'address';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('city') == '')
	    {
	        $data['inputerror'][] = 'city';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('state') == '')
	    {
	        $data['inputerror'][] = 'state';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('postal') == '')
	    {
	        $data['inputerror'][] = 'postal';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('idnumb') == '')
	    {
	        $data['inputerror'][] = 'idnumb';
	        $data['status'] = FALSE;
	    }

	    if($data['status'] === FALSE)
	    {
	        echo json_encode($data);
	        exit();
	    }
	}

	public function _validate_user_passchg($id)
	{
		$data = array();
	    $data['error_string'] = array();
	    $data['inputerror'] = array();
	    $data['status'] = TRUE;
	 
	    $getold = $this->crud->get_by_id('user',array('user_id' => $id));
	    $old = $getold->PASSWORD;

	    if($this->input->post('oldpass') != $old)
	    {
	        $data['inputerror'][] = 'oldpass';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('newpass') != $this->input->post('conpass'))
	    {
	        $data['inputerror'][] = 'conpass';	        
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('oldpass') == '')
	    {
	        $data['inputerror'][] = 'oldpass';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('newpass') == '')
	    {
	        $data['inputerror'][] = 'newpass';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('conpass') == '')
	    {
	        $data['inputerror'][] = 'conpass';
	        $data['status'] = FALSE;
	    }	    

	    if($data['status'] === FALSE)
	    {
	        echo json_encode($data);
	        exit();
	    }
	}

	public function _validate_user_pinchg($id)
	{
		$data = array();
	    $data['error_string'] = array();
	    $data['inputerror'] = array();
	    $data['status'] = TRUE;
	 
	    if($this->input->post('acc') == '')
	    {
	        $data['inputerror'][] = 'acc';
	        $data['status'] = FALSE;
	    }

	    $getold = $this->crud->get_by_id('user_account',array('uacc_id' => $id));
	    $old = $getold->UACC_PIN;

	    if($this->input->post('oldpin') != $old)
	    {
	        $data['inputerror'][] = 'oldpin';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('newpin') != $this->input->post('conpin'))
	    {
	        $data['inputerror'][] = 'conpin';	        
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('oldpin') == '')
	    {
	        $data['inputerror'][] = 'oldpin';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('newpin') == '')
	    {
	        $data['inputerror'][] = 'newpin';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('conpin') == '')
	    {
	        $data['inputerror'][] = 'conpin';
	        $data['status'] = FALSE;
	    }	    

	    if($data['status'] === FALSE)
	    {
	        echo json_encode($data);
	        exit();
	    }
	}

	public function _validate_req()
	{
		$data = array();
	    $data['error_string'] = array();
	    $data['inputerror'] = array();
	    $data['status'] = TRUE;

	    if($this->input->post('pck') == '')
	    {
	        $data['inputerror'][] = 'pck';
	        $data['status'] = FALSE;
	    }


	    if($data['status'] === FALSE)
	    {
	        echo json_encode($data);
	        exit();
	    }
	}

	public function _validate_depo()
	{
		$data = array();
	    $data['error_string'] = array();
	    $data['inputerror'] = array();
	    $data['status'] = TRUE;

	    // if($this->input->post('admbank') == '')
	    // {
	    //     $data['inputerror'][] = 'admbank';
	    //     $data['status'] = FALSE;
	    // }

	    if($this->input->post('acc') == '')
	    {
	        $data['inputerror'][] = 'acc';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('acc2') == '')
	    {
	        $data['inputerror'][] = 'acc2';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('acc_name2') == '')
	    {
	        $data['inputerror'][] = 'acc_name2';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('bank_name2') == '')
	    {
	        $data['inputerror'][] = 'bank_name2';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('curr') == '')
	    {
	        $data['inputerror'][] = 'curr';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('amount') == '')
	    {
	        $data['inputerror'][] = 'amount';
	        $data['status'] = FALSE;
	    }

	    if($data['status'] === FALSE)
	    {
	        echo json_encode($data);
	        exit();
	    }
	}

	public function _validate_wd()
	{
		$data = array();
	    $data['error_string'] = array();
	    $data['inputerror'] = array();
	    $data['status'] = TRUE;

	    if($this->input->post('acc') == '')
	    {
	        $data['inputerror'][] = 'acc';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('acc2') == '')
	    {
	        $data['inputerror'][] = 'acc2';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('acc_name2') == '')
	    {
	        $data['inputerror'][] = 'acc_name2';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('bank_name2') == '')
	    {
	        $data['inputerror'][] = 'bank_name2';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('curr') == '')
	    {
	        $data['inputerror'][] = 'curr';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('amount') == '')
	    {
	        $data['inputerror'][] = 'amount';
	        $data['status'] = FALSE;
	    }

	    if($data['status'] === FALSE)
	    {
	        echo json_encode($data);
	        exit();
	    }
	}

	public function _validate_prc()
	{
		$data = array();
	    $data['error_string'] = array();
	    $data['inputerror'] = array();
	    $data['status'] = TRUE;

	    if($this->input->post('acc') == '')
	    {
	        $data['inputerror'][] = 'acc';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('acc2') == '')
	    {
	        $data['inputerror'][] = 'acc2';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('acc_name2') == '')
	    {
	        $data['inputerror'][] = 'acc_name2';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('bank_name2') == '')
	    {
	        $data['inputerror'][] = 'bank_name2';
	        $data['status'] = FALSE;
	    }

	    if($this->input->post('curr') == '')
	    {
	        $data['inputerror'][] = 'curr';
	        $data['status'] = FALSE;
	    }

	    if($data['status'] === FALSE)
	    {
	        echo json_encode($data);
	        exit();
	    }
	}
}