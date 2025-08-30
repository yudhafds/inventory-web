<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Barang extends CI_Controller 
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
		$data["subtitle"] 	= "DATA BARANG";
		$data['pages'] 		= 'barang_list';
		$data['mdata'] 		= $this->app_model->master("barang");
		$this->load->view('index',$data);
	}

	
	function add()
	{
		$data = array();
		$data["title"] 		= "INVENTORY";
		$data["subtitle"] 	= "TAMBAH BARANG";
		$data["id_barang"]	=$this->app_model->get_kode_barang();
		$data['pages'] 		= 'barang_add';
		$this->load->view('index',$data);
	}

	function save() 
	{
		$in["id_barang"]		=$this->input->post('id_barang');
		$in["nama_barang"]		=$this->input->post('nama_barang');
		$in["satuan"]			=$this->input->post('satuan');
		$in["harga_pokok"]		=$this->input->post('harga_pokok');
		$in["harga_jual"]		=$this->input->post('harga_jual');
		$in["keterangan"]		=$this->input->post('keterangan');
		$stok					=$this->input->post('stok_awal');
		$this->app_model->simpan("barang",$in);
		$this->app_model->simpan_stok($in["id_barang"],$stok);
		$this->session->set_flashdata('info','<p><div class="alert alert-warning">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>data berhasil disimpan !</strong>
									</div>');
		redirect('barang');
	}

	function edit($id=null)
	{
		$id = base64_decode($id);	
		$data = array();
		$data["title"] 		= "INVENTORY";
		$data["subtitle"] 	= "EDIT BARANG";
		$data['pages'] 		= 'barang_edit';
		$data['mdata'] 		= $this->app_model->barang_edit($id);	
		$this->load->view('index',$data);
	}	

	function update() 
	{
		$in["id_barang"]		=$this->input->post('id_barang');
		$in["nama_barang"]		=$this->input->post('nama_barang');
		$in["satuan"]			=$this->input->post('satuan');
		$in["harga_pokok"]		=$this->input->post('harga_pokok');
		$in["harga_jual"]		=$this->input->post('harga_jual');
		$in["keterangan"]		=$this->input->post('keterangan');
		$stok					=$this->input->post('stok_awal');
		$this->app_model->update("barang",$in,"id_barang");
		$this->app_model->simpan_stok($in["id_barang"],$stok);	
		$this->session->set_flashdata('info','<p><div class="alert alert-warning">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
											<strong>Data berhasil diupdate !</strong>
										</div>');
		redirect('barang');
	}
	
	function delete($id=null)
	{
		$id = base64_decode($id);
		$this->app_model->hapus($id,"id_barang","barang");
		$this->app_model->hapus($id,"id_barang","stok");
		$this->session->set_flashdata('info','<p><div class="alert alert-warning">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>Data berhasil dihapus !</strong>
									</div>');
		redirect('barang');
	}
	
}
