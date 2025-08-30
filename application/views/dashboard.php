<div class="content-wrapper">
<section class="content-header">
  <h1>
	Dashboard
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Dashboard</li>
  </ol>
</section>
<section class="content"> 
	  <div class="row">
		<div class="col-lg-4 col-xs-4">
		  <div class="small-box bg-green">
			<div class="inner">
			  <h3><?php echo $tot_barang;?></h3>
			  <p>BARANG</p>
			</div>
			<div class="icon">
			  <i class="fa fa-md fa-fw fa-cube"></i>
			</div>
			<a href="<?php echo site_url('barang');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
		</div>
		<div class="col-lg-4 col-xs-4">
		  <div class="small-box bg-yellow">
			<div class="inner">
			  <h3><?php echo $tot_barang_masuk;?><sup style="font-size: 20px"></sup></h3>
			  <p>BARANG MASUK</p>
			</div>
			<div class="icon">
			  <i class="fa fa-md fa-fw fa-user"></i>
			</div>
			<a href="<?php echo site_url('barang_masuk');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
		</div>
		<div class="col-lg-4 col-xs-4">
		  <div class="small-box bg-red">
			<div class="inner">
			  <h3><?php echo $tot_barang_keluar;?><sup style="font-size: 20px"></sup></h3>
			  <p>BARANG KELUAR</p>
			</div>
			<div class="icon">
			  <i class="fa fa-md fa-fw fa-users"></i>
			</div>
			<a href="<?php echo site_url('barang_keluar');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
		</div>
		
	  </div>
	<div class="box box-primary">
		<div class="box-header with-border">
			<b>HISTORY BARANG KELUAR TERAKHIR</b>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table id="user" class="display table-bordered table-striped table-hover" cellspacing="0" width="100%">
					<thead>
					  <tr>
						<th>No</th>
						<th>IdTransaksi</th>
						<th>Tanggal</th>
						<th>Waktu</th>
						<th>Keterangan</th>
						<th>Admin</th>
						<th>#</th>
					  </tr>
					</thead>
					<tbody>
					<?php
					if($mdata->num_rows()>0){
						$no=1;
						foreach($mdata->result_array() as $rows){
							echo '<tr>';
							echo '<td>'.$no.'</td>';
							echo '<td>'.$rows['id_transaksi'].'</td>';
							echo '<td>'.tgl_indo($rows['tanggal']).'</td>';						
							echo '<td>'.$rows['jam'].'</td>';
							echo '<td>'.$rows['keterangan'].'</td>';
							echo '<td>'.$rows['nama'].'</td>';
							echo '<td>
									<a title="detail" class="btn btn-sm btn-primary" href="'.site_url('barang_keluar/detail/'.trim(base64_encode($rows['id_transaksi']),'=').'').'">
										<i class="fa fa-file-text" aria-hidden="true"></i>
									</a>							
								 </td>';
							echo '</tr>';
							$no++;
						}
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	  </div>
</section>
</div>
<script type="text/javascript">
var user;
$(document).ready(function() {
    user = $('#user').DataTable({ 	
        "oLanguage": {
		"sProcessing": "<img src='<?php echo asset_url('admin/core/img/loader.gif')?>'>"
		},
		"processing": true, 
        "serverSide": false, 
        "order": [], 
        "columnDefs": [
        { 
            "targets": [ 0 ],
            "orderable": true,
			"width": "5%",
			"targets": 0,
        },
		{ 
            "targets": [ 6 ],
            "orderable": false,
            "class": "text-center",
			"width": "5%",
			"targets": 6,
        },
        ],
    });
});
</script>
