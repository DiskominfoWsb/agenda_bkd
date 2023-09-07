	
<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/amelia/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <head>
	<title>.:: e-Agenda <?=base64_decode($this->config->item('one')); ?></title>
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
			
		$(function() {
			$( "#tgl_surat" ).datepicker({
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
	
   setTimeout(function () {
        // create the notification
        var notification = new NotificationFx({
          message: '<span>Input Data Sukses!</span>',
          layout: 'attached',
          effect: 'bouncyflip',
          ttl: 4000,
          wrapper: document.getElementById("alert"),
          type: 'success', // notice, warning, success or error
        });
		notification.show();

      }, 1200);

	
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
          <ul class="nav navbar-nav navbar-right">	
			<li><a href="<?php echo base_url(); ?>admin"><i class="icon-home icon-white"> </i> Beranda</a></li>
          	<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/kegiatan"><i class="icon-file icon-red"></i> Agenda Kegiatan</a></li>
            
			
			
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-wrench icon-white"> </i> Setting<span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
			  <?php
			if ($this->session->userdata('admin_level') == "Super Admin") {
			?>
			
			  <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/klas_surat"><i class="icon-th-large icon-red"></i> Klasifikasi Surat</a></li>
              <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/pengguna"><i class="icon-home icon-red"></i>&nbsp;&nbsp;Instansi Pengguna</a></li>
              <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/manage_admin"><i class="icon-user icon-red"></i>&nbsp;&nbsp;Manajemen Admin</a></li>
			      
           
			<?php 
			}
			?>
			<li class="dropdown-header"><h5>BackUp</h5></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/toExcelAll"><i class="icon-barcode icon-red"></i> toExcelAll</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/backup"><i class="icon-th-list icon-red"></i>&nbsp;&nbsp;Database</a></li>
				
				</ul>
				</li>
          
         
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
		<h5 style="font-weight: bold">e-Agenda BKD WONOSOBO <a href="http://bkd.wonosobokab.go.id" target="_blank"></a></h5>
		<h6>&copy;  2021. Waktu Eksekusi : {elapsed_time}, Penggunaan Memori : {memory_usage}</h6>
	  </div>
 
    </div>

 
</body></html>