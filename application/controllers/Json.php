<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Json extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();		
		$this->load->model('json_model');
	}
	
	function login()
	{
		$a = array();
		$b = array();
		if($this->input->post('email')){
			$email	=$this->input->post('email');
			$pass	=$this->input->post('password');
			$hasil 	=$this->json_model->login($email,$pass);
			if ($hasil->num_rows()>0){
				foreach($hasil->result_array() as $row){
					$a['userid']  		=$row['id_admin'];
					$a['nama']			=$row['nama'];
					$a['telepon']		=$row['telepon'];
					$a['email']			=$row['email'];
					$a['level']			=$row['level'];
					$a['status']		='sukses';
					array_push($b,$a);
				}
			}else{
				$a['status']='gagal';
				array_push($b,$a);
			}
			echo json_encode($b);
		}
	}
	
	
	function myakun()
	{
		$a = array();
		$b = array();
		$userid=$this->input->post('userid');
		$mprofile=$this->json_model->my_akun($userid);
		if($mprofile->num_rows()>0){
			foreach($mprofile->result_array() as $row){
				$b['nama']		=$row['nama'];
				$b['telepon']	=$row['telepon'];
				$b['email']		=$row['email'];
				array_push($a,$b);	
			}
		}
		echo json_encode($a);		
	}

	function myakun_update()
	{
		$a = array();
		$b = array();
		if($this->input->post('userid')){
			$date_now	=date('YmdHis');
			$email		=$this->input->post('email');
			$newpass	=$this->input->post('password');
			if($newpass!=''){
				$in['password']=$newpass;
			}	
			$in['id_admin']		=$this->input->post('userid');
			$in['nama']			=$this->input->post('nama');
			$in['telepon']		=$this->input->post('telepon');
			$in['email']		=$this->input->post('email');
			$this->json_model->update("admin",$in,"id_admin");
			$a["status"] = 'sukses';
			array_push($b,$a);
			echo json_encode($b);
		}
	}
	function barang_list_keluar()
	{
		$a = array();
		$b = array();
		$mdata =$this->json_model->barang_list_keluar();
		if($mdata->num_rows()>0){
			foreach($mdata->result_array() as $row){
				$a['id']		= $row['id_barang'];
				$a['nama']		= $row['nama_barang'];
				$a['satuan']	= $row['satuan'];
				$a['harga']		= $row['harga_jual'];
				$a['stok']		= $row['stok'];
				$a['keterangan']= $row['keterangan'];
				array_push($b,$a);
			}			
		}
		echo json_encode($b);
	}
	
	
	function barang_list_masuk()
	{
		$a = array();
		$b = array();
		$mdata =$this->json_model->barang_list_masuk();
		if($mdata->num_rows()>0){
			foreach($mdata->result_array() as $row){
				$a['id']		= $row['id_barang'];
				$a['nama']		= $row['nama_barang'];
				$a['satuan']	= $row['satuan'];
				$a['harga']		= $row['harga_jual'];
				$a['keterangan']= $row['keterangan'];
				array_push($b,$a);
			}			
		}
		echo json_encode($b);
	}
	
	function barang_list_mutasi()
	{
		$a = array();
		$b = array();
		$lokasi=$this->input->post('lokasi');
		$mdata =$this->json_model->barang_list_mutasi($lokasi);
		if($mdata->num_rows()>0){
			foreach($mdata->result_array() as $row){
				$a['id']		= $row['id_barang'];
				$a['nama']		= $row['nama_barang'];
				$a['satuan']	= $row['satuan'];
				$a['harga']		= $row['harga_jual'];
				$a['stok']		= $row['stok'];
				$a['keterangan']= $row['keterangan'];
				array_push($b,$a);
			}			
		}
		echo json_encode($b);
	}
	
	/*transaksi barang keluar */
	function barang_keluar_simpan()
	{
		$a = array();
		$b = array();
		if($this->input->post('param_cart')){
			$idtransaksi		=$this->json_model->get_kode_transaksi();
			$in['id_transaksi']	=$idtransaksi;
			$in['keterangan']	=$this->input->post('param_keterangan');
			$in['tipe']			='OUT';
			$in['waktu']		=date("Y-m-d H:i:s");
			$in['id_admin']		=$this->input->post('param_admin');
			$this->json_model->simpan("transaksi",$in);
			
			$cartdata=json_decode($this->input->post('param_cart'));
			foreach($cartdata as $val) {
				$ins['id_transaksi']=$idtransaksi;;
				$ins['id_barang']	=$val->id;
				$ins['jumlah']		=$val->jumlah;
				$this->json_model->simpan("transaksi_detail",$ins);
				$this->json_model->update_stock_out($val->id,$val->jumlah);
			}
			$a["status"]	= 'sukses';
			array_push($b,$a);
			echo json_encode($b);
		}
	}
	
	
	function barang_keluar_history()
	{
		$a = array();
		$b = array();
		$mdata =$this->json_model->transaksi_list("OUT");
		if($mdata->num_rows()>0){
			foreach($mdata->result_array() as $row){
				$a['id']		= $row['id_transaksi'];
				$a['tanggal']	= tgl_indo($row['tanggal']);
				$a['waktu']		= $row['jam'];
				$a['admin']		= $row['nama'];
				$a['keterangan']= $row['keterangan'];
				array_push($b,$a);
			}			
		}
		echo json_encode($b);
	}
	
	function barang_keluar_history_detail()
	{
		$a = array();
		$b = array();
		$id=$this->input->post('id');
		$mdata =$this->json_model->transaksi_detail($id);
		if($mdata->num_rows()>0){
			foreach($mdata->result_array() as $row){
				$a['id']		= $row['id_barang'];
				$a['nama']		= $row['nama_barang'];
				$a['satuan']	= $row['satuan'];
				$a['jumlah']	= $row['jumlah'];
				array_push($b,$a);
			}			
		}
		echo json_encode($b);
	}
	
	
	/*transaksi barang masuk */
	function barang_masuk_simpan()
	{
		$a = array();
		$b = array();
		if($this->input->post('param_cart')){
			$idtransaksi		=$this->json_model->get_kode_transaksi();
			$in['id_transaksi']	=$idtransaksi;
			$in['keterangan']	=$this->input->post('param_keterangan');
			$in['tipe']			='IN';
			$in['waktu']		=date("Y-m-d H:i:s");
			$in['id_admin']		=$this->input->post('param_admin');
			$this->json_model->simpan("transaksi",$in);
			
			$cartdata=json_decode($this->input->post('param_cart'));
			foreach($cartdata as $val) {
				$ins['id_transaksi']=$idtransaksi;;
				$ins['id_barang']	=$val->id;
				$ins['jumlah']		=$val->jumlah;
				$this->json_model->simpan("transaksi_detail",$ins);
				$this->json_model->update_stock_out($val->id,$val->jumlah);
			}
			$a["status"]	= 'sukses';
			array_push($b,$a);
			echo json_encode($b);
		}
	}
	
	
	function barang_masuk_history()
	{
		$a = array();
		$b = array();
		$mdata =$this->json_model->transaksi_list("IN");
		if($mdata->num_rows()>0){
			foreach($mdata->result_array() as $row){
				$a['id']		= $row['id_transaksi'];
				$a['tanggal']	= tgl_indo($row['tanggal']);
				$a['waktu']		= $row['jam'];
				$a['admin']		= $row['nama'];
				$a['keterangan']= $row['keterangan'];
				array_push($b,$a);
			}			
		}
		echo json_encode($b);
	}
	
	function barang_masuk_history_detail()
	{
		$a = array();
		$b = array();
		$id=$this->input->post('id');
		$mdata =$this->json_model->transaksi_detail($id);
		if($mdata->num_rows()>0){
			foreach($mdata->result_array() as $row){
				$a['id']		= $row['id_barang'];
				$a['nama']		= $row['nama_barang'];
				$a['satuan']	= $row['satuan'];
				$a['jumlah']	= $row['jumlah'];
				array_push($b,$a);
			}			
		}
		echo json_encode($b);
	}

	/*transaksi mutasi barang */
	function gudang_list()
	{
		$a = array();
		$b = array();
		$mdata =$this->json_model->master("lokasi");
		if($mdata->num_rows()>0){
			foreach($mdata->result_array() as $row){
				$a['id']		= $row['id_lokasi'];
				$a['nama']		= $row['nama_lokasi'];
				array_push($b,$a);
			}			
		}
		echo json_encode($b);
	}
	
	function barang_mutasi_simpan()
	{
		$a = array();
		$b = array();
		if($this->input->post('param_cart')){
			$idmutasi				=$this->json_model->get_kode_mutasi();
			$in['id_mutasi']		=$idmutasi;
			$in['id_lokasi_asal']	=$this->input->post('param_asal');
			$in['id_lokasi_tujuan']	=$this->input->post('param_tujuan');
			$in['keterangan']		=$this->input->post('param_keterangan');
			$in['waktu']			=date("Y-m-d H:i:s");
			$in['keterangan']		=$this->input->post('param_catatan');
			$in['id_admin']			=$this->input->post('param_admin');
			$this->json_model->simpan("mutasi",$in);
			$cartdata=json_decode($this->input->post('param_cart'));
			foreach($cartdata as $val) {
				$ins['id_mutasi']	=$idmutasi;
				$ins['id_barang']	=$val->id;
				$ins['jumlah']		=$val->jumlah;
				$this->json_model->simpan("mutasi_detail",$ins);
				$this->json_model->update_stock_mutasi($val->id,$val->jumlah,$in['id_lokasi_asal'],$in['id_lokasi_tujuan']);
			}
			$a["status"]	= 'sukses';
			array_push($b,$a);
			echo json_encode($b);
		}
	}
	
	
	function barang_mutasi_history()
	{
		$a = array();
		$b = array();
		$mdata =$this->json_model->mutasi_list();
		if($mdata->num_rows()>0){
			foreach($mdata->result_array() as $row){
				$a['id']		= $row['id_mutasi'];
				$a['asal']		= $row['lokasi_asal'];
				$a['tujuan']	= $row['lokasi_tujuan'];
				$a['tanggal']	= tgl_indo($row['tanggal']);
				$a['waktu']		= $row['waktu'];
				$a['admin']		= $row['nama'];
				$a['keterangan']= $row['keterangan'];
				array_push($b,$a);
			}			
		}
		echo json_encode($b);
	}
	
	function barang_mutasi_history_detail()
	{
		$a = array();
		$b = array();
		$id=$this->input->post('id');
		$mdata =$this->json_model->mutasi_detail($id);
		if($mdata->num_rows()>0){
			foreach($mdata->result_array() as $row){
				$a['id']		= $row['id_barang'];
				$a['nama']		= $row['nama_barang'];
				$a['satuan']	= $row['satuan'];
				$a['jumlah']	= $row['jumlah'];
				array_push($b,$a);
			}			
		}
		echo json_encode($b);
	}
	
	function cek_stok()
	{
		$a = array();
		$b = array();
		$barcode=$this->input->post('barcode');
		$mdata =$this->json_model->barang_detail($barcode);
		if($mdata->num_rows()>0){
			foreach($mdata->result_array() as $row){
				$a['id']		= $row['id_barang'];
				$a['nama']		= $row['nama_barang'];
				$a['satuan']	= $row['satuan'];
				$a['status']	= "sukses";
				array_push($b,$a);
			}			
		}
		echo json_encode($b);
	}
	
	function cek_stok_result()
	{
		$a = array();
		$b = array();
		$id=$this->input->post('id');
		$mdata =$this->json_model->cek_stok_result($id);
		if($mdata->num_rows()>0){
			foreach($mdata->result_array() as $row){
				$a['id']		= $row['id_lokasi'];
				$a['nama']		= $row['nama_lokasi'];
				$a['jumlah']	= $row['jumlah'];
				array_push($b,$a);
			}			
		}
		echo json_encode($b);
	}
	
	
	
	

}
