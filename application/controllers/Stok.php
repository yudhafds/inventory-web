<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stok extends CI_Controller 
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
		$data["subtitle"] 	= "KARTU STOK";
		$data['pages'] 		= 'stok_list';
		$data['mdata'] 		= $this->app_model->stok_list();
		$this->load->view('index',$data);
	}	

}
