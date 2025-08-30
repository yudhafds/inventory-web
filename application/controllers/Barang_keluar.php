<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Barang_keluar extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();		
		$this->load->model(array('app_model'));
		$this->id		=$this->session->userdata('id');
		$this->nama		=$this->session->userdata('nama');
		$this->email	=$this->session->userdata('email');
		$this->level	=$this->session->userdata('level');
		$this->foto		=$this->session->userdata('foto');
		if($this->id==''){redirect();}
	}

	function index()
	{
		$data = array();
		$data["title"] 		= "INVENTORY";
		$data["subtitle"] 	= "BARANG KELUAR";
		$data['pages'] 		= 'barang_keluar_list';
		$data['mdata'] 		= $this->app_model->transaksi_list('OUT');
		$this->load->view('index',$data);
	}

	function detail($id=null)
	{
		$id = base64_decode($id);	
		$data = array();
		$data["title"] 		= "INVENTORY";
		$data["subtitle"] 	= "DETAIL BARANG KELUAR";
		$data['pages'] 		= 'barang_keluar_detail';
		$data['mheader'] 	= $this->app_model->transaksi_header($id);	
		$data['mdetail'] 	= $this->app_model->transaksi_detail($id);	
		$this->load->view('index',$data);
	}	

}
