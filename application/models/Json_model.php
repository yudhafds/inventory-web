<?php
Class Json_model extends CI_Model
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
	function login($email=null,$password=null)
	{
		$q=$this->db->query("select * from admin WHERE email='".$email."' AND password='".$password."' AND status='1'");
		return $q;
	}
	function my_akun($userid=null)
	{
		$q=$this->db->query("select * from admin WHERE id_admin='".$userid."'");
		return $q;
	}
	
	function barang_detail($id=null){
		$q=$this->db->query("SELECT a.* FROM barang a WHERE a.id_barang='".$id."'");
		return $q;
	}
	
	function barang_list_keluar(){
		$q=$this->db->query("SELECT a.*,IFNULL(b.jumlah,0) AS stok
							FROM barang a
							LEFT JOIN stok b on b.id_barang=a.id_barang  AND b.id_lokasi='PRIMER'
							LEFT JOIN lokasi c on c.id_lokasi=b.id_lokasi
							ORDER BY a.id_barang ASC");
		return $q;
	}
	
	function barang_list_masuk(){
		$q=$this->db->query("SELECT a.* FROM barang a");
		return $q;
	}
	
	function barang_list_mutasi($lokasi=null){
		$q=$this->db->query("SELECT a.*,IFNULL(b.jumlah,0) AS stok
							FROM barang a
							LEFT JOIN stok b on b.id_barang=a.id_barang AND b.id_lokasi='".$lokasi."'
							LEFT JOIN lokasi c on c.id_lokasi=b.id_lokasi
							ORDER BY a.id_barang ASC");
		return $q;
	}
	
	
	function get_kode_transaksi()
	{
		$prefix	= 'TRN';
		$tahun	= mdate("%y");
		$bulan	= mdate("%m");
		$query = $this->db->query("SELECT max(substring(id_transaksi,8,4)) as lastcode 
								FROM transaksi
								where substring(id_transaksi,4,2)='$tahun' 
								and substring(id_transaksi,6,2)='$bulan'");
		if($query->num_rows()>0){
			foreach($query->result() as $k){
				$tmp = ((int)$k->lastcode)+1;
				$lastcode = sprintf("%04s", $tmp);
				$lastcode = $tahun.$bulan.$lastcode;
			}
		}else{
			$lastcode = $tahun.$bulan."0001";
		}
		return $prefix.$lastcode;
	}
	
	function get_kode_mutasi()
	{
		$prefix	= 'MUT';
		$tahun	= mdate("%y");
		$bulan	= mdate("%m");
		$query = $this->db->query("SELECT max(substring(id_mutasi,8,4)) as lastcode 
								FROM mutasi
								where substring(id_mutasi,4,2)='$tahun' 
								and substring(id_mutasi,6,2)='$bulan'");
		if($query->num_rows()>0){
			foreach($query->result() as $k){
				$tmp = ((int)$k->lastcode)+1;
				$lastcode = sprintf("%04s", $tmp);
				$lastcode = $tahun.$bulan.$lastcode;
			}
		}else{
			$lastcode = $tahun.$bulan."0001";
		}
		return $prefix.$lastcode;
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
		$q=$this->db->query("SELECT a.*,b.nama_barang,b.satuan
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
		$q=$this->db->query("SELECT a.*,b.nama_barang,b.satuan
							FROM mutasi_detail a
							LEFT JOIN barang b on b.id_barang=a.id_barang
							WHERE a.id_mutasi='".$id."'");
		return $q;
	}
	
	function update_stock_out($id=null,$jumlah=null){
		$q=$this->db->query("UPDATE stok SET jumlah=jumlah-".$jumlah." WHERE id_barang='".$id."' AND id_lokasi='PRIMER'");
		return $q;
	}
	
	function update_stock_in($id=null,$jumlah=null){
		$q=$this->db->query("UPDATE stok SET jumlah=jumlah+".$jumlah." WHERE id_barang='".$id."' AND id_lokasi='PRIMER'");
		return $q;
	}
	
	function update_stock_mutasi($id=null,$jumlah=null,$asal=null,$tujuan=null){
		$this->db->query("UPDATE stok SET jumlah=jumlah-".$jumlah." WHERE id_barang='".$id."' AND id_lokasi='".$asal."'");
		if($this->cek_stok_perlokasi($id,$tujuan)){
			$this->db->query("INSERT INTO stok (id_barang,id_lokasi,jumlah) VALUES ('$id','$tujuan','$jumlah')");
		}else{
			$this->db->query("UPDATE stok SET jumlah=jumlah+".$jumlah." WHERE id_barang='".$id."' AND id_lokasi='".$tujuan."'");
		}		
	}
	
	function cek_stok_perlokasi($id=null,$lokasi=null)
	{
		$return=true;
		$query = $this->db->query("SELECT * FROM stok WHERE id_barang='".$id."' AND id_lokasi='".$lokasi."'");
		if($query->num_rows()>0){
			return false;
		}
		return $return;
	}
	
	function cek_stok_result($id=null)
	{
		$query = $this->db->query("SELECT a.*,b.id_barang,b.jumlah
									FROM stok b
									LEFT JOIN lokasi a on a.id_lokasi=b.id_lokasi
									WHERE b.id_barang='".$id."'");
		return $query;
	}
	
}