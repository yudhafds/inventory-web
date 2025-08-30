<style>
.borderless td, .borderless th {
    border: none;
}
</style>
<div class="content-wrapper">
<section class="content">
<!-- SELECT2 EXAMPLE -->
<div class="box box-primary">
<div class="box-header with-border">
<strong>
	<?php echo $subtitle;?>
</strong>
<div class="box-tools pull-right">
	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
</div>
</div>
<div class="box-body">
  <div class="row">
	<div class="col-md-12">
		<?php
		foreach($mheader->result_array() as $rows){		
		?>
		<table class="table borderless">
			<tbody>
			  <tr>
				<td width="15%">ID Transaksi</td>
				<td class="text-center" width="5%">:</td>
				<td><?php echo $rows['id_mutasi'];?></td>
			  </tr>
			  <tr>
				<td width="15%">Tanggal</td>
				<td class="text-center" width="5%">:</td>
				<td><?php echo tgl_indo($rows['tanggal']);?></td>
			  </tr>
			  <tr>
				<td width="15%">Waktu</td>
				<td class="text-center" width="5%">:</td>
				<td><?php echo $rows['waktu'];?></td>
			  </tr>
			   <tr>
				<td width="15%">Lokasi Asal</td>
				<td class="text-center" width="5%">:</td>
				<td><?php echo $rows['lokasi_asal'];?></td>
			  </tr>
			   <tr>
				<td width="15%">Lokasi Tujuan</td>
				<td class="text-center" width="5%">:</td>
				<td><?php echo $rows['lokasi_tujuan'];?></td>
			  </tr>
			  <tr>
				<td width="15%">Keterangan</td>
				<td class="text-center" width="5%">:</td>
				<td><?php echo $rows['keterangan'];?></td>
			  </tr>
			  <tr>
				<td width="15%">Admin</td>
				<td class="text-center" width="5%">:</td>
				<td><?php echo $rows['nama'];?></td>
			  </tr>
			</tbody>
		</table>
		<table id="user" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
			<thead>
			  <tr>
				<th>No</th>
				<th>IDBarang</th>
				<th>Nama Barang</th>
				<th class="text-right">Jumlah</th>
			  </tr>
			</thead>
			<tbody>
			<?php
			if($mdetail->num_rows()>0){
				$no=1;
				foreach($mdetail->result_array() as $rows){
					echo '<tr>';
					echo '<td>'.$no.'</td>';
					echo '<td>'.$rows['id_barang'].'</td>';
					echo '<td>'.$rows['nama_barang'].'</td>';
					echo '<td class="text-right">'.number_format($rows['jumlah']).'</td>';
					echo '</tr>';
					$no++;
				}
			}
			?>
			</tbody>
		</table>
		<a href="<?php echo site_url('mutasi');?>" type="button" class="btn btn-sm pull-right btn-danger">
			<i class="ace-icon fa fa-ban"></i> Tutup
		</a>
	  <?php } ?>
	</div>
  </div>
</div>
</div>
</section>
</div>