<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<?php echo $subtitle;?>
  </h1>
<ol class="breadcrumb">
	<li><a href="#">Home</a></li>
	<li><a href="#">Stok Kontrol</a></li>
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
						<th>Lokasi</th>
						<th>Barang</th>
						<th>Stok</th>
					  </tr>
					</thead>
					<tbody>
					<?php
					if($mdata->num_rows()>0){
						$no=1;
						foreach($mdata->result_array() as $rows){
							echo '<tr>';
							echo '<td>'.$no.'</td>';
							echo '<td>'.$rows['id_lokasi'].' - '.$rows['nama_lokasi'].'</td>';						
							echo '<td>'.$rows['id_barang'].' - '.$rows['nama_barang'].'</td>';
							echo '<td>'.number_format($rows['jumlah']).'</td>';
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
            "targets": [ 3 ],
            "orderable": true,
            "class": "text-right",
			"targets": 3,
        },
        ],
    });
});
</script>