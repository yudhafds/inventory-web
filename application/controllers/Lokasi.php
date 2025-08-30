<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lokasi extends CI_Controller 
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
		$data["subtitle"] 	= "DATA LOKASI";
		$data['pages'] 		= 'lokasi_list';
		$data['mdata'] 		= $this->app_model->master("lokasi");
		$this->load->view('index',$data);
	}

	function add()
	{
		$data = array();
		$data["title"] 		= "INVENTORY";
		$data["subtitle"] 	= "TAMBAH LOKASI";
		$data['mtipe'] 		= array("PENYIMPANAN"=>"PENYIMPANAN");
		$data['pages'] 		= 'lokasi_add';
		$this->load->view('index',$data);
	}

	function save() 
	{
		$in["id_lokasi"]	=$this->app_model->get_kode_lokasi();
		$in["nama_lokasi"]	=$this->input->post('nama_lokasi');
		$in["tipe"]			=$this->input->post('tipe');
		$in["keterangan"]	=$this->input->post('keterangan');
		$this->app_model->simpan("lokasi",$in);
		$this->session->set_flashdata('info','<p><div class="alert alert-warning">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>data berhasil disimpan !</strong>
									</div>');
		redirect('lokasi');
	}

	function edit($id=null)
	{
		$id = base64_decode($id);	
		$data = array();
		$data["title"] 		= "INVENTORY";
		$data["subtitle"] 	= "EDIT LOKASI";
		$data['pages'] 		= 'lokasi_edit';
		$data['mtipe'] 		= array("PENYIMPANAN"=>"PENYIMPANAN");
		$data['mdata'] 		= $this->app_model->edit("lokasi","id_lokasi='".$id."'");	
		$this->load->view('index',$data);
	}	

	function update() 
	{
		$in["id_lokasi"]	=$this->input->post('id');
		$in["nama_lokasi"]	=$this->input->post('nama_lokasi');
		$in["keterangan"]	=$this->input->post('keterangan');
		$in["tipe"]			=$this->input->post('tipe');
		$this->app_model->update("lokasi",$in,"id_lokasi");
		$this->session->set_flashdata('info','<p><div class="alert alert-warning">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
											<strong>Data berhasil diupdate !</strong>
										</div>');
		redirect('lokasi');
	}

	function delete($id=null)
	{
		$id = base64_decode($id);
		$this->app_model->hapus($id,"id_lokasi","lokasi");
		$this->session->set_flashdata('info','<p><div class="alert alert-warning">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>Data berhasil dihapus !</strong>
									</div>');
		redirect('lokasi');
	}
}
