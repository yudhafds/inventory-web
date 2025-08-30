<?php
Class App_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function manualQuery($q)
	{
		return $this->db->query($q);
	}

	function master($master)
	{
		$q=$this->db->query("select * from $master");
		return $q;
	}

	function simpan($tabel,$data)
	{
		$s=$this->db->insert($tabel,$data);
		return $s;
	}

	function edit($tabel,$seleksi)
	{
		$query=$this->db->query("select * from $tabel where $seleksi");
		return $query;
	}

	function update($tabel,$isi,$seleksi)
	{
		$this->db->where($seleksi,$isi[$seleksi]);
		$this->db->update($tabel,$isi);
	}

	function hapus($id,$seleksi,$tabel)
	{
		$this->db->where($seleksi,$id);
		$this->db->delete($tabel);
	}

	function total($tabel)
	{
		$q=$this->db->query("select * from $tabel");
		return $q;
	}

	function view_data($tabel,$id)
	{
		$q=$this->db->query("select * from ".$tabel." order by ".$id." ASC");
		return $q;
	}

	function CekID($tbl,$field,$id)
	{
		$CResult=$this->db->query("SELECT $field FROM $tbl WHERE $field='$id'");
		if(count($CResult->result_array())>0){	
			return false;
		}else{
			return true;
		}
	}

	function getCount($tbl,$field)
	{ 	
		$query = $this->db->query("select count($field) as jumlah from $tbl");	
		foreach($query->result() as $k)
		{
			$jumlah =$k->jumlah;
		}
		
		return $jumlah;
	}
		

	function login($email,$password)
	{
		$query=$this->db->query("SELECT a.* FROM admin a WHERE a.email='$email' AND a.password='$password' and a.level='admin'");
		return $query;
	}

	function email_cek($email){
		$cek_result=$this->db->query("select * from admin WHERE email='$email'");
		if($cek_result->num_rows()>0){	
			return false;
		}
		else{
			return true;
		}
	}

	function stok_list($param=null){
		$q=$this->db->query("SELECT a.*,b.nama_lokasi,c.nama_barang
							FROM stok a
							LEFT JOIN lokasi b on b.id_lokasi=a.id_lokasi
							LEFT JOIN barang c on c.id_barang=a.id_barang
							ORDER BY  a.id_lokasi,a.id_barang ASC");
		return $q;
	}
	
	function transaksi_list($param=null){
		$q=$this->db->query("SELECT a.*,DATE(a.waktu) as tanggal,TIME(a.waktu) as jam,b.nama
							FROM transaksi a
							LEFT JOIN admin b on b.id_admin=a.id_admin
							WHERE a.tipe='".$param."'
							ORDER BY  a.id_transaksi DESC");
		return $q;
	}
	
	
	function transaksi_header($id=null){
		$q=$this->db->query("SELECT a.*,DATE(a.waktu) as tanggal,TIME(a.waktu) as jam,b.nama
							FROM transaksi a
							LEFT JOIN admin b on b.id_admin=a.id_admin
							WHERE a.id_transaksi='".$id."'
							LIMIT 1");
		return $q;
	}
	
	function transaksi_detail($id=null){
		$q=$this->db->query("SELECT a.*,b.nama_barang
							FROM transaksi_detail a
							LEFT JOIN barang b on b.id_barang=a.id_barang
							WHERE a.id_transaksi='".$id."'");
		return $q;
	}
	
	
	function mutasi_list($param=null){
		$q=$this->db->query("SELECT a.*,DATE(a.waktu) as tanggal,TIME(a.waktu) as jam,b.nama,c.nama_lokasi as lokasi_asal,d.nama_lokasi as lokasi_tujuan
							FROM mutasi a
							LEFT JOIN admin b on b.id_admin=a.id_admin
							LEFT JOIN lokasi c on c.id_lokasi=a.id_lokasi_asal
							LEFT JOIN lokasi d on d.id_lokasi=a.id_lokasi_tujuan
							ORDER BY  a.id_mutasi DESC");
		return $q;
	}
	
	
	function mutasi_header($id=null){
		$q=$this->db->query("SELECT a.*,DATE(a.waktu) as tanggal,TIME(a.waktu) as jam,b.nama,c.nama_lokasi as lokasi_asal,d.nama_lokasi as lokasi_tujuan
							FROM mutasi a
							LEFT JOIN admin b on b.id_admin=a.id_admin
							LEFT JOIN lokasi c on c.id_lokasi=a.id_lokasi_asal
							LEFT JOIN lokasi d on d.id_lokasi=a.id_lokasi_tujuan
							WHERE a.id_mutasi='".$id."'
							ORDER BY  a.id_mutasi DESC
							LIMIT 1");
		return $q;
	}
	
	function mutasi_detail($id=null){
		$q=$this->db->query("SELECT a.*,b.nama_barang
							FROM mutasi_detail a
							LEFT JOIN barang b on b.id_barang=a.id_barang
							WHERE a.id_mutasi='".$id."'");
		return $q;
	}
	
	
	function get_kode_barang()
	{
		$prefix= 'P';
		$query = $this->db->query("SELECT max(substring(id_barang,2,3)) as lastcode FROM barang");
		if($query->num_rows()>0){
			foreach($query->result() as $k){
				$tmp = ((int)$k->lastcode)+1;
				$lastcode = sprintf("%03s", $tmp);				
			}
		}else{
			$lastcode = "001";
		}
		return $prefix.$lastcode;
	}
	
	function get_kode_lokasi()
	{
		$prefix= 'L';
		$query = $this->db->query("SELECT max(substring(id_lokasi,2,3)) as lastcode FROM lokasi");
		if($query->num_rows()>0){
			foreach($query->result() as $k){
				$tmp = ((int)$k->lastcode)+1;
				$lastcode = sprintf("%03s", $tmp);				
			}
		}else{
			$lastcode = "001";
		}
		return $prefix.$lastcode;
	}
	
	function tot_barang($id=null){
		$q=$this->db->query("SELECT * FROM barang");
		return $q->num_rows();
	}
	
	function tot_barang_masuk()
	{
		$q=$this->db->query("select * from transaksi where tipe='IN'");
		return $q->num_rows();
	}
	function tot_barang_keluar()
	{
		$q=$this->db->query("select * from transaksi where tipe='OUT'");
		return $q->num_rows();
	}
	
	
	function simpan_stok($id=null,$jumlah=null){
		if($this->cek_stok_awal($id)){
			$in["id_lokasi"]	='PRIMER';
			$in["id_barang"]	=$id;
			$in["jumlah"]		=$jumlah;
			$this->simpan("stok",$in);
		}else{
			$this->db->query("UPDATE stok set jumlah='".$jumlah."' WHERE id_lokasi='PRIMER' AND id_barang='".$id."'");
		}
	}
	
	function cek_stok_awal($id=null)
	{
		$return=true;
		$query = $this->db->query("SELECT * FROM stok WHERE id_barang='".$id."' AND id_lokasi='PRIMER'");
		if($query->num_rows()>0){
			return false;
		}
		return $return;
	}
	
	function barang_edit($id=null){
		$q=$this->db->query("SELECT a.*,b.jumlah
							FROM barang a
							LEFT JOIN stok b on b.id_barang=a.id_barang AND b.id_lokasi='PRIMER'
							WHERE a.id_barang='".$id."'
							LIMIT 1");
		return $q;
	}
	
}