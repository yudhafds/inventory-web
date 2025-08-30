 <div class="content-wrapper">
 <section class="content-header">
  <h1>
	<?php echo $subtitle;?>
  </h1>
<ol class="breadcrumb">
	<li><a href="#">Home</a></li>
	<li><a href="#">Admin</a></li>
	<li class="active">Tambah</a></li>
  </ol>
</section>
<section class="content">
<div class="box box-primary">
<div class="box-header with-border">
	<a href="<?php echo site_url('lokasi');?>">
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
	  <form id="frm" method="post" class="form-horizontal" action="<?php echo site_url('lokasi/save'); ?>" enctype="multipart/form-data">
		<div class="box-body">

			<div class="form-group">
				<label class="control-label col-sm-2" for="nama_lokasi">Nama Lokasi</label>
				<div class="col-sm-7">
				  <input type="text" class="form-control" id="nama_lokasi" name="nama_lokasi" placeholder="Nama Lokasi" required>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-sm-2" for="tipe">Tipe Lokasi</label>
				<div class="col-sm-7">
					<select name="tipe" class="form-control select2" id="tipe" required>
					  <option value="">--Pilih Tipe--</option>
					  <?php
						  foreach($mtipe as $val => $key){
							  echo'<option value="'.$val.'">'.$key.'</option>';
						  }
					  ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="keterangan">Keterangan</label>
				<div class="col-sm-7">
				  <textarea type="text" rows="3" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan"  required></textarea>
				</div>
			</div>
			<div class="form-group"> 
				<div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" id="btn-save" class="btn btn-md btn-primary">
				  <i class="ace-icon fa fa-save"></i> Save
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