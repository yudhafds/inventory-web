<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller 
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
		$data["subtitle"] 	= "DATA ADMIN";
		$data['pages'] 		= 'admin_list';
		$data['mdata'] 		= $this->app_model->manualQuery("select * from admin where id_admin!='".$this->id."'");
		$this->load->view('index',$data);
	}

	function add()
	{
		$data = array();
		$data["title"] 		= "INVENTORY";
		$data["subtitle"] 	= "TAMBAH ADMIN";
		$data['mlevel'] 	= array("admin"=>"SUPER ADMIN","user"=>"GENERAL ADMIN");
		$data['pages'] 		= 'admin_add';
		$this->load->view('index',$data);
	}

	function save() 
	{
		$in["nama"]			=$this->input->post('nama');
		$in["level"]		=$this->input->post('level');
		$in["telepon"]		=$this->input->post('telepon');
		$in["email"]		=$this->input->post('email');
		$in["password"]		=$this->input->post('password');
		$in["foto"]			='avatar.png';
		if($this->app_model->email_cek($in["email"])){
			$this->app_model->simpan("admin",$in);
			$this->session->set_flashdata('info','<p><div class="alert alert-warning">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
											<strong>data berhasil disimpan !</strong>
										</div>');
			redirect('admin');
		}else{
			$this->session->set_flashdata('info','<p><div class="alert alert-warning">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
											<strong>kesalahan, username telah terdaftar !</strong>
										</div>');
			redirect('admin/add');
		}
	}

	function edit($id=null)
	{
		$id = base64_decode($id);	
		$data = array();
		$data["title"] 		= "INVENTORY";
		$data["subtitle"] 	= "EDIT ADMIN";
		$data['pages'] 		= 'admin_edit';
		$data['mlevel'] 	= array("admin","user");
		$data['mdata'] 		= $this->app_model->edit("admin","id_admin='".$id."'");	
		$this->load->view('index',$data);
	}	

	function update() 
	{
		$in["id_admin"]		=$this->input->post('id');
		$in["nama"]			=$this->input->post('nama');
		$in["level"]		=$this->input->post('level');
		$in["telepon"]		=$this->input->post('telepon');
		$in["email"]		=$this->input->post('email');
		$newpassword		=$this->input->post('newpassword');
		if($newpassword!=''){
			$in["password"]	=$newpassword;
		}
		$this->app_model->update("admin",$in,"id_admin");
		$this->session->set_flashdata('info','<p><div class="alert alert-warning">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
											<strong>Data berhasil diupdate !</strong>
										</div>');
		redirect('admin');
	}

	function delete($id=null)
	{
		$id = base64_decode($id);
		$this->app_model->hapus($id,"id_admin","admin");
		$this->session->set_flashdata('info','<p><div class="alert alert-warning">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>Data berhasil dihapus !</strong>
									</div>');
		redirect('admin');
	}
	

	function aktivasi($id=null)
	{
		$in["id_admin"]		=base64_decode($id);
		$in["status"]		='1';
		$this->app_model->update("admin",$in,"id_admin");
		$this->session->set_flashdata('info','<p><div class="alert alert-warning">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>Data berhasil diaktivasi !</strong>
									</div>');
		redirect('admin');
	}
	

	function suspend($id=null)
	{
		$in["id_admin"]		=base64_decode($id);
		$in["status"]		='2';
		$this->app_model->update("admin",$in,"id_admin");	
		$this->session->set_flashdata('info','<p><div class="alert alert-warning">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>Data berhasil disuspend !</strong>
									</div>');
		redirect('admin');
	}
}
