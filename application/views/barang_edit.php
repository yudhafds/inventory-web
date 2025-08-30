<?php
foreach($mdata->result_array() as $rows){
	$id_barang		= $rows['id_barang'];
	$nama_barang	= $rows['nama_barang'];
	$satuan			= $rows['satuan'];
	$harga_pokok	= $rows['harga_pokok'];
	$harga_jual		= $rows['harga_jual'];
	$keterangan		= $rows['keterangan'];
	$stock_awal		= $rows['jumlah'];
}
?>
 <div class="content-wrapper">
 <section class="content-header">
  <h1>
	<?php echo $subtitle;?>
  </h1>
<ol class="breadcrumb">
	<li><a href="#">Home</a></li>
	<li><a href="#">Barang</a></li>
	<li class="active">Edit</a></li>
  </ol>
</section>
<section class="content">
<!-- SELECT2 EXAMPLE -->
<div class="box box-primary">
<div class="box-header with-border">
	<a href="<?php echo site_url('barang');?>">
		<span class="glyphicon fa fa-mail-reply"></span> <b>Kembali</b>
	</a> 
  <div class="box-tools pull-right">
	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
  </div>
</div>
<div class="box-body">
  <div class="row">
	<div class="col-md-12">
	  <form id="frm" method="post" class="form-horizontal" action="<?php echo site_url('barang/update'); ?>" enctype="multipart/form-data">
		<div class="box-body">
			<div class="form-group">
				<label class="control-label col-sm-2" for="id_barang">ID Barang</label>
				<div class="col-sm-7">
				  <input type="text" class="form-control" id="id_barang" name="id_barang" placeholder="ID Barang" value="<?php echo $id_barang;?>"  readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="nama_barang">Nama Barang</label>
				<div class="col-sm-7">
				  <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang" value="<?php echo $nama_barang;?>"  required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="satuan">Satuan</label>
				<div class="col-sm-7">
				  <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" value="<?php echo $satuan;?>"  required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="harga_pokok">Harga Pokok</label>
				<div class="col-sm-7">
				  <input type="text" class="form-control" id="harga_pokok" name="harga_pokok" placeholder="Harga Pokok" value="<?php echo $harga_pokok;?>"  required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="harga_jual">Harga Jual</label>
				<div class="col-sm-7">
				  <input type="text" class="form-control" id="harga_jual" name="harga_jual" placeholder="Harga Jual" value="<?php echo $harga_jual;?>"  required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="stok_awal">Stok Awal</label>
				<div class="col-sm-7">
				  <input type="text" class="form-control" id="stok_awal" name="stok_awal" placeholder="Stok Awal" value="<?php echo $stock_awal;?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="keterangan">Keterangan</label>
				<div class="col-sm-7">
				  <textarea type="text" rows="3" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan"  required><?php echo $keterangan;?></textarea>
				</div>
			</div>
			<div class="form-group"> 
				<div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" id="btn-update" class="btn btn-md btn-primary">
				  <i class="ace-icon fa fa-save"></i> Update
				  </button>
				  <button type="button" class="btn btn-md btn-danger">
					<i class="ace-icon fa fa-ban"></i> Reset
				  </button>
				</div>
			</div>
		</div>
	  </form>
	</div>
  </div>
</div>
</div>
</section>
</div>
<script>
$(function () {
	$(".select2").select2();
});
</script>