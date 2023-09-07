<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/amelia/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>.:: e-Agenda ::.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
	

	<link rel="shortcut icon" href="https://simpeg.wonosobokab.go.id/e_agenda/upload/wonosobo.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>aset/css/bootstrap.css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url(); ?>aset/css/jquery.fancybox.css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url(); ?>aset/css/jquery.fancybox.min.css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url(); ?>aset/hovernav/honernav.css" media="screen">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="../bower_components/bootstrap/assets/js/html5shiv.js"></script>
    <script src="../bower_components/bootstrap/assets/js/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>aset/js/jquery/jquery-ui.css" />
    <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>aset/css/datatables.min.css"/>-->
    <script src="<?php echo base_url(); ?>aset/js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>aset/js/jquery/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>aset/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>aset/js/notificationFx.js" type="text/javascript"></script>
	<!--<script src="<?php echo base_url(); ?>aset/honernav/hovernav.js"></script>-->
    <script src="<?php echo base_url(); ?>aset/js/bootswatch.js"></script>
	<script src="<?php echo base_url(); ?>aset/js/jquery.fancybox.js"></script>
	<script src="<?php echo base_url(); ?>aset/js/jquery.fancybox.min.js"></script>

	
	<script src="<?php echo base_url(); ?>aset/js/datatables.min.js" type="text/javascript"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').DataTable({"bSort":false});
			} );
			$(document).ready(function() {
				$('#example1').DataTable({"bSort":false});
			} );
			$(document).ready(function() {
				$('#example2').DataTable({"bSort":false});
			} );
			$(document).ready(function() {
				$('#example3').DataTable({"bSort":false});
			} );
			$.fn.dataTable.ext.errMode = 'none';
		</script>
  <body style="">
    <div class="navbar navbar-inverse navbar-fixed-top"  >
      <div class="container">
        <div class="navbar-header">
          <span class="navbar-brand"><strong style="font-family: verdana; margin-left: -50px; font-size: 24px;color:#ffffff;"><i>Agenda Kegiatan Badan Kepegawaian Daerah</i> </strong></span>
		  <span>
		 	  
          
        </div>

      </div>
    </div>

<?php echo $this->session->flashdata("k");?>
<div class="container">
<br>
<div class="row">
<div class="col-md-14 col-md-offset-0">
<?php echo $this->session->flashdata("k");?>
<!--<div class="fresh-table">
    Available colors for the full background: full-color-blue, full-color-azure, full-color-green, full-color-red, full-color-orange
                        Available colors only for the toolbar: toolbar-color-blue, toolbar-color-azure, toolbar-color-green, toolbar-color-red, toolbar-color-orange
              
   <div class="toolbar">
  <button id="alertBtn" class="btn btn-default">Alert</button>
    </div>
    -->
<br><br>
<table id="example3" class="table table-bordered table-hover">
	<thead>
		<tr>
			<th width="3%">No.</th>
			<!-- <th width="4%">Tahun</th> -->
			<th width="25%">Kegiatan / Acara</th>
			<th width="10%">Waktu</th>
			<th width="15%">Tempat<br>Jam</th>
			<th width="15%">Pelaksana</th>
		</tr>
	</thead>
	
	<tbody>
		<?php 
		if (empty($data2)) {
			echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
			foreach ($data2 as $b) {
		?>
		<tr>
			<td align="center"><?php echo $no;?></td>
			<!--<td align="center">< ?=$b->tahun;?></td>-->
		<?php	
			echo	"<td>".$b->isi_keg;
			if($b->file_){
				echo	"<br><a href='".base_URL()."upload/kegiatan/".$b->file_."' target='_blank' class='btn-sm btn-default active' role='button' aria-pressed='true'>Cek File</a>";
			}
		?>
			</td><td align="center"><?=$b->tgl_keg_;?><br><i>s.d</i><br><?=$b->tgl_keg_end_;?></td>
			<td><?=$b->tempat;?><br><?=$b->jam."-".$b->jam_end;?></td>
			<td align="center"><?=$b->pegawai;?></td>

		</tr>
		<?php 
			$no++;
			}
		}
		?>
	</tbody>
</table>
</div>
</div>
<!--<center><ul class="pagination"><?php// echo $pagi; ?></ul></center>-->
</div>
</body>
</html>