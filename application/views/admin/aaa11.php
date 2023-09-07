	
<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/amelia/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <head>
	<title>.:: SIMPEL</title>
	<!-- @font-face {
	  font-weight: 400;
	  src: local('Cabin Regular'), local('Cabin-Regular'), url(< ?php echo base_url(); ?>aset/font/satu.woff) format('woff');
	}
	@font-face {
	  font-family: 'Cabin';
	  font-style: normal;
	  font-weight: 700;
	  src: local('Cabin Bold'), local('Cabin-Bold'), url(< ?php echo base_url(); ?>aset/font/dua.woff) format('woff');
	}
	@font-face {
	  font-family: 'Lobster';
	  font-style: normal;
	  font-weight: 400;
	  src: local('Lobster'), url(< ?php echo base_url(); ?>aset/font/tiga.woff) format('woff');
	} -->
	
	
	<link rel=”icon” href=”logo4.jpg”>
    <link rel="stylesheet" href="<?php echo base_url(); ?>aset/css/bootstrap.css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url(); ?>aset/hovernav/honernav.css" media="screen">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../bower_components/bootstrap/assets/js/html5shiv.js"></script>
      <script src="../bower_components/bootstrap/assets/js/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>aset/js/jquery/jquery-ui.css" />
    <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>aset/css/datatables.min.css"/>-->
    <script src="<?php echo base_url(); ?>aset/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>aset/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>aset/honernav/hovernav.js"></script>
    <script src="<?php echo base_url(); ?>aset/js/bootswatch.js"></script>
	<script src="<?php echo base_url(); ?>aset/js/jquery/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>aset/js/datatables.min.js"></script>
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
		</script>
	<script type="text/javascript">
	// <![CDATA[
	$(document).ready(function () {
		$(function () {
			$( "#kode_surat" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_klasifikasi'); ?>",
						data: { kode: $("#kode_surat").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
		
		$(function () {
			$( "#dari" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_instansi_lain'); ?>",
						data: { kode: $("#dari").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
		
		//Fungsi json get pejabat pembuat sk (menampilkan list data yang sudah ada pada database)
		$(function () {
			$( "#pejabat2" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_pejabat_sk'); ?>",
						data: { kode: $("#pejabat2").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
		
			$(function () {
			$( "#jabatan2" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_jabfungum'); ?>",
						data: { kode: $("#jabatan2").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
		
		$(function () {
			$( "#pegawai" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_pegawai'); ?>",
						data: { kode: $("#pegawai").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
			$(function () {
			$( "#unit_kerja2" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_skpd'); ?>",
						data: { kode: $("#unit_kerja2").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
		$(function () {
			$( "#pejabat" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_pejabat_lain'); ?>",
						data: { kode: $("#pejabat").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
		$(function () {
			$( "#verifikasi" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_ver'); ?>",
						data: { kode: $("#verifikasi").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
		$(function () {
			$( "#unit_pengolah" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_unit_pengolah'); ?>",
						data: { kode: $("#unit_pengolah").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
		$(function () {
			$( "#jam_uji" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_jam'); ?>",
						data: { kode: $("#jam_uji").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
			
		$(function () {
			$( "#jam_uji2" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_jam'); ?>",
						data: { kode: $("#jam_uji2").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});	
		$(function () {
			$( "#tkpendid2" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_tkpendid'); ?>",
						data: { kode: $("#tkpendid2").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});	
		
		$(function () {
			$( "#jurusan2" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('admin/get_jurusan'); ?>",
						data: { kode: $("#jurusan2").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
		
		$(function() {
			$( "#tgl_surat" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd-mm-yy'
			});
		});
		$(function() {
			$( "#tgl_uji" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd-mm-yy'
			});
		});
		$(function() {
			$( "#tgl_surat1" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd-mm-yy'
			});
		});
		
		$(function() {
			$( "#tgl_surat2" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd-mm-yy'
			});
		});
		
	});
	// ]]>
	</script>
	</head>
	
  <body style="">
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
         <span class="navbar-brand"><strong style="font-family: verdana;"><i></i></strong></span>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav navbar-left">	
			<li><a href="<?php echo base_url(); ?>admin"><i class="icon-home icon-white"> </i> Beranda</a></li>
          
		  <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-random icon-white"> </i> &nbsp; Data <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/data_pegawai"><i class="icon-file icon-red"></i> Data Pegawai</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/peta_jabatan"><i class="icon-file icon-red"></i> Peta Jabatan</a></li>
               
			</ul>
            </li>
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-random icon-white"> </i> &nbsp; Persyaratan <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/persyaratan"><i class="icon-file icon-red"></i> Detail Persyaratan</a></li>
          
			</ul>
            </li>
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-random icon-white"> </i> &nbsp;Usulan Mutasi <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/mutasi_kelas"><i class="icon-file icon-red"></i> Mutasi Kelas Jabatan</a></li>
               
			</ul>
            </li>
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-random icon-white"> </i> &nbsp;Download <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/cetak_pegawai"><i class="icon-file icon-red"></i> Data Pegawai</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/cetak_usul"><i class="icon-file icon-red"></i> Daftar Usulan</a></li>

               
			</ul>
            </li>
			 <?php
			if ($this->session->userdata('admin_level') == "Super Admin") {
			?>
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-wrench icon-white"> </i> Setting<span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
			  <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/pengguna"><i class="icon-home icon-red"></i>&nbsp;&nbsp;Instansi Pengguna</a></li>
              <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/manage_admin"><i class="icon-user icon-red"></i>&nbsp;&nbsp;Manajemen Admin</a></li>
           
				<li class="dropdown-header"><h5>BackUp</h5></li>
			 	<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/agenda_mutasi_kelas2"><i class="icon-barcode icon-red"></i> Mutasi Kelas</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/toExcelAll"><i class="icon-barcode icon-red"></i> toExcelAll</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/backup"><i class="icon-th-list icon-red"></i>&nbsp;&nbsp;Database</a></li>
				
				</ul>
				</li>
          
         <?php 
			}
			?>
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-user icon-white"></i> User<span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/passwod"><i class="icon-pencil icon-red"></i>&nbsp;&nbsp;Ubah Password</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/logout"><i class="icon-off icon-red"></i>&nbsp;&nbsp;Logout</a></li>
				
				
          
                <li><a tabindex="-1" href="http://bkd.wonosobokab.go.id" target="_blank">Help</a></li>
              </ul>
            </li>
          </ul>

        </div>
      </div>
    </div>

	<?php 
	$q_instansi	= $this->db->query("SELECT * FROM tr_instansi LIMIT 1")->row();
	echo $this->session->userdata('admin_level');
	?>
    <div class="container">

      <!--<div class="page-header" id="banner">
        <div class="row">
          <div class="" style="padding: 15px 15px 0 15px;">
			<div class="well well-sm">
				<img src="<?php// echo base_url(); ?>upload/<?php //echo $q_instansi->logo; ?>" class="thumbnail span3" style="display: inline; float: left; margin-right: 20px; width: 100px; height: 100px">
                <h2 style="margin: 15px 0 10px 0; color: #000;"><?php //echo $q_instansi->nama; ?></h2>
                <div style="color: #000; font-size: 16px; font-family: Tahoma" class="clearfix"><b>Alamat : <?php //echo $q_instansi->alamat; ?></b></div>
             </div>
          </div>
        </div>
      </div>--->
<br><br>
		<?php $this->load->view('admin/'.$page); ?>
	  
	  <div class="span12 well well-sm">
		<h5 style="font-weight: bold">SIMPEL by BKD KABUPATEN WONOSOBO<a href="http://bkd.wonosobokab.go.id" target="_blank"> </a></h5>
		<h6>&copy;  2021. Waktu Eksekusi : {elapsed_time}, Penggunaan Memori : {memory_usage}</h6>
	  </div>
 
    </div>

  
</body></html>