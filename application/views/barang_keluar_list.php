<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<?php echo $subtitle;?>
  </h1>
<ol class="breadcrumb">
	<li><a href="#">Home</a></li>
	<li><a href="#">Barang Keluar</a></li>
	<li class="active">List</a></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	<?php
		if ($this->session->flashdata('info'))
		{  
			echo $this->session->flashdata('info');
		}
	?>
	 <div class="box box-primary">
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
	</div>
  </div>
</section>
</div>
<script type="text/javascript">
var user;
$(document).ready(function() {
    user = $('#user').DataTable({
		dom: "Bfrtip",
		buttons: [
			{extend: "print", text: "<span class='glyphicon glyphicon-print'></span> Print"},          
			{extend: "excelHtml5", text: "<span class='glyphicon glyphicon-th-list'></span> Excel"},
			{extend: "pdfHtml5", text: "<span class='glyphicon glyphicon-save'></span> PDF", title: "Filename"}
		],
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