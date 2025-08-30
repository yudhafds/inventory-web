<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('app_model'));
		$this->id		=$this->session->userdata('id');
		$this->nama		=$this->session->userdata('nama');
		$this->email	=$this->session->userdata('email');
		$this->level	=$this->session->userdata('level');
		$this->foto		=$this->session->userdata('foto');
	}
	
	function index()
	{	
		$data=array();
		$data["title"] = "INVENTORY";
		if($this->id!=""){
			$data["pages"] 				= 'dashboard';
			$data['tot_barang'] 		= $this->app_model->tot_barang();			
			$data['tot_barang_masuk'] 	= $this->app_model->tot_barang_masuk();			
			$data['tot_barang_keluar'] 	= $this->app_model->tot_barang_keluar();
			$data['mdata'] 				= $this->app_model->transaksi_list('OUT');
			$this->load->view('index',$data);
		}else{
			$this->load->view('login',$data);
		}
	}

}
