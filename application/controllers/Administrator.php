<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Administrator extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_crud','crud');
		$this->load->model('dtb/Dt_admaccprc','acc');
		$this->load->model('dtb/Dt_admdepo','depo');
		$this->load->model('dtb/Dt_admwd','wd');
		$this->load->model('dtb/Dt_admbank','bank');
		$this->load->model('dtb/Dt_admcurr','curr');
		$this->load->model('dtb/Dt_admexc','exc');
		$this->load->model('dtb/Dt_admpck','pck');
		$this->load->model('dtb/Dt_admuser','user');
		$this->load->model('dtb/Dt_admsubsc','subsc');
		$this->load->model('dtb/Dt_admuseracc','useracc');
	}

	public function index()
	{
		$this->load->view('administrator/menu/adminlogin');
	}

	public function dashboard()
	{		
		// $this->load->view('administrator/menu/tes');
		$data['menu']='dashboard';
		$data['menulist']='';
		$data['content']='administrator/menu/dashboard';
		$this->load->view('administrator/layout/wrapper',$data);
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
			$this->simple_login->adminlogin($username,$password);
		}		
	}

	public function logout()
	{
		$this->simple_login->logoutadm();
	}

	public function accountpurchase()
	{		
		// $this->load->view('administrator/menu/tes');
		$data['menu']='mng_trx';
		$data['menulist']='accprc';
		$data['content']='administrator/menu/accpurchase';
		$this->load->view('administrator/layout/wrapper',$data);
	}

	public function deposit()
	{		
		// $this->load->view('administrator/menu/tes');
		$data['menu']='mng_trx';
		$data['menulist']='depo';
		$data['content']='administrator/menu/deposit';
		$this->load->view('administrator/layout/wrapper',$data);
	}

	public function withdraw()
	{		
		// $this->load->view('administrator/menu/tes');
		$data['menu']='mng_trx';
		$data['menulist']='wd';
		$data['content']='administrator/menu/withdraw';
		$this->load->view('administrator/layout/wrapper',$data);
	}

	public function bank()
	{		
		// $this->load->view('administrator/menu/tes');
		$data['menu']='mng_adm';
		$data['menulist']='bank';
		$data['content']='administrator/menu/bank_list';
		$this->load->view('administrator/layout/wrapper',$data);
	}

	public function currency()
	{		
		// $this->load->view('administrator/menu/tes');
		$data['menu']='mng_adm';
		$data['menulist']='curr';
		$data['content']='administrator/menu/currency_list';
		$this->load->view('administrator/layout/wrapper',$data);
	}

	public function exchanger()
	{		
		// $this->load->view('administrator/menu/tes');
		$data['menu']='mng_adm';
		$data['menulist']='exc';
		$data['content']='administrator/menu/exchanger_list';
		$this->load->view('administrator/layout/wrapper',$data);
	}

	public function package()
	{		
		// $this->load->view('administrator/menu/tes');
		$data['menu']='mng_adm';
		$data['menulist']='pack';
		$data['content']='administrator/menu/package_list';
		$this->load->view('administrator/layout/wrapper',$data);
	}

	public function userdata()
	{		
		// $this->load->view('administrator/menu/tes');
		$data['menu']='mng_user';
		$data['menulist']='user_data';
		$data['content']='administrator/menu/user_list';
		$this->load->view('administrator/layout/wrapper',$data);
	}

	public function useracc()
	{		
		// $this->load->view('administrator/menu/tes');
		$data['menu']='mng_user';
		$data['menulist']='user_acc';
		$data['content']='administrator/menu/useracc_list';
		$this->load->view('administrator/layout/wrapper',$data);
	}

	public function subscribe()
	{		
		// $this->load->view('administrator/menu/tes');
		$data['menu']='mng_user';
		$data['menulist']='subscribe';
		$data['content']='administrator/menu/subscribe_list';
		$this->load->view('administrator/layout/wrapper',$data);
	}

	//ajax dashboard
	public function ajax_accprc()
	{
		$list = $this->acc->get_datatables();
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
			$row[] = '<a href="javascript:void(0)" title="Show Data" class="btn btn-sm btn-info btn-responsive" onclick="show_acc('."'".$dat->PRC_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a>';
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->acc->count_all(),
						"recordsFiltered" => $this->acc->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_depo()
	{
		$list = $this->depo->get_datatables();
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
			$row[] = '<a href="javascript:void(0)" title="Show Data" class="btn btn-sm btn-info btn-responsive" onclick="show_depo('."'".$dat->DEPO_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a>';
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->depo->count_all(),
						"recordsFiltered" => $this->depo->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_wd()
	{
		$list = $this->wd->get_datatables();
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
			$row[] = '<a href="javascript:void(0)" title="Show Data" class="btn btn-sm btn-info btn-responsive" onclick="show_wd('."'".$dat->WD_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a>';
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->wd->count_all(),
						"recordsFiltered" => $this->wd->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	//ajax data management
	public function ajax_bank()
	{
		$list = $this->bank->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dat) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dat->BANK_ACC;
			$row[] = $dat->BANK_NAME;
			$row[] = $dat->BANK_ACCNAME;
			$row[] = '<a href="javascript:void(0)" title="Show Data" class="btn btn-sm btn-info btn-responsive" onclick="show_bank('."'".$dat->BANK_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a> <a href="javascript:void(0)" title="Delete Data" class="btn btn-sm btn-danger btn-responsive" onclick="del_bank('."'".$dat->BANK_ID."'".')"><span class="glyphicon glyphicon-remove"></span> </a>';
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->bank->count_all(),
						"recordsFiltered" => $this->bank->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_curr()
	{
		$list = $this->curr->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dat) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dat->CURR_NAME;
			$row[] = $dat->CURR_LOGO;
			$row[] = $dat->CURR_RATE;
			$row[] = '<a href="javascript:void(0)" title="Show Data" class="btn btn-sm btn-info btn-responsive" onclick="show_curr('."'".$dat->CURR_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a> </a> <a href="javascript:void(0)" title="Delete Data" class="btn btn-sm btn-danger btn-responsive" onclick="del_curr('."'".$dat->CURR_ID."'".')"><span class="glyphicon glyphicon-remove"></span> </a>';
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->curr->count_all(),
						"recordsFiltered" => $this->curr->count_filtered(),
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
			$row[] = $dat->EXC_WA;
			$row[] = $dat->EXC_BBM;
			$row[] = $dat->EXC_EMAIL;
			$row[] = $dat->EXC_SITE;
			$row[] = '<a href="javascript:void(0)" title="Show Data" class="btn btn-sm btn-info btn-responsive" onclick="show_exc('."'".$dat->EXC_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a> <a href="javascript:void(0)" title="Delete Data" class="btn btn-sm btn-danger btn-responsive" onclick="del_exc('."'".$dat->EXC_ID."'".')"><span class="glyphicon glyphicon-remove"></span> </a>';
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

	public function ajax_pck()
	{
		$list = $this->pck->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dat) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dat->PC_NAME;
			$row[] = $dat->PC_LVRG;
			$row[] = $dat->PC_DEPO;
			$row[] = $dat->PC_INFO;
			$row[] = '<a href="javascript:void(0)" title="Show Data" class="btn btn-sm btn-info btn-responsive" onclick="show_pck('."'".$dat->PC_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a> <a href="javascript:void(0)" title="Delete Data" class="btn btn-sm btn-danger btn-responsive" onclick="del_pck('."'".$dat->PC_ID."'".')"><span class="glyphicon glyphicon-remove"></span> </a>';
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pck->count_all(),
						"recordsFiltered" => $this->pck->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	//ajax user management
	public function ajax_admuser()
	{
		$list = $this->user->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dat) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dat->USERNAME;
			$row[] = $dat->UDT_NAME;
			$row[] = $dat->UDT_ADDRESS.','.$dat->UDT_CITY.','.$dat->UDT_PROVINCE.','.$dat->UDT_POSTAL;
			$row[] = $dat->UDT_IDNUMBER;
			$row[] = '<a href="javascript:void(0)" title="Show Data" class="btn btn-sm btn-info btn-responsive" onclick="show_userdata('."'".$dat->USER_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a>';
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->user->count_all(),
						"recordsFiltered" => $this->user->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_admuseracc()
	{
		$list = $this->useracc->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dat) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dat->USERNAME;
			$row[] = $dat->UDT_NAME;
			$row[] = $dat->UACC_CODE;
			if($dat->UACC_STS == '0')
			{
				$status = '<button class="btn btn-info">Waiting Fund</button>';
			}
			if($dat->UACC_STS == '1')
			{
				$status = '<button class="btn btn-info">Pending</button>';
			}
			if($dat->UACC_STS == '2')
			{
				$status = '<button class="btn btn-success">Active</button>';
			}
			$row[] = $status;
			$row[] = $dat->UACC_SALDO;
			$row[] = '<a href="javascript:void(0)" title="Show Data" class="btn btn-sm btn-info btn-responsive" onclick="show_useracc('."'".$dat->UACC_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a>';
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->useracc->count_all(),
						"recordsFiltered" => $this->useracc->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_admsubsc()
	{
		$list = $this->subsc->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dat) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dat->SUBS_NAME;
			$row[] = $dat->SUBS_EMAIL;			
			$row[] = '<a href="javascript:void(0)" title="Show Data" class="btn btn-sm btn-info btn-responsive" onclick="show_subscriber('."'".$dat->SUBS_ID."'".')"><span class="glyphicon glyphicon-upload"></span> </a> <a href="javascript:void(0)" title="Show Data" class="btn btn-sm btn-danger btn-responsive" onclick="del_subscriber('."'".$dat->SUBS_ID."'".')"><span class="glyphicon glyphicon-remove"></span> </a>';
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->useracc->count_all(),
						"recordsFiltered" => $this->useracc->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	//get data
	public function get_accprc($id)
	{
		$data = $this->crud->get_by_id('acc_purchase',array('prc_id' => $id));
        echo json_encode($data);
	}

	public function get_depo($id)
	{
		$data = $this->crud->get_by_id('deposit',array('depo_id' => $id));
        echo json_encode($data);
	}

	public function get_wd($id)
	{
		$data = $this->crud->get_by_id('withdraw',array('wd_id' => $id));
        echo json_encode($data);
	}

	public function get_uacc($id)
	{
		$data = $this->crud->get_by_id('user_account',array('uacc_id' => $id));
        echo json_encode($data);
	}

	public function get_admbank($id)
	{
		$data = $this->crud->get_by_id('admin_bank',array('bank_id' => $id));
        echo json_encode($data);
	}

	public function get_curr($id)
	{
		$data = $this->crud->get_by_id('currency_rate',array('curr_id' => $id));
        echo json_encode($data);
	}

	public function get_exc($id)
	{
		$data = $this->crud->get_by_id('exchanger',array('exc_id' => $id));
        echo json_encode($data);
	}

	public function get_pck($id)
	{
		$data = $this->crud->get_by_id('package',array('pc_id' => $id));
        echo json_encode($data);
	}

	public function get_subscriber($id)
	{
		$data = $this->crud->get_by_id('subscriber',array('subs_id' => $id));
        echo json_encode($data);
	}
}
