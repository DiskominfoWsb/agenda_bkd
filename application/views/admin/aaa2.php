	
<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/amelia/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <head>
	<title>.:: Diklat <?=base64_decode($this->config->item('twoo')); ?></title>
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
	
	</style>
    <link rel="stylesheet" href="<?php echo base_url(); ?>aset/css/bootstrap.css" media="screen">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../bower_components/bootstrap/assets/js/html5shiv.js"></script>
      <script src="../bower_components/bootstrap/assets/js/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>aset/js/jquery/jquery-ui.css" />
  
    <script src="<?php echo base_url(); ?>aset/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>aset/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>aset/js/bootswatch.js"></script>
	<script src="<?php echo base_url(); ?>aset/js/jquery/jquery-ui.js"></script>
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
         <!--<span class="navbar-brand"><strong style="font-family: verdana;"><i>Diklat</i></strong></span>-->
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav navbar-right">	
			<li><a href="<?php echo base_url(); ?>admin"><i class="icon-home icon-white"> </i> Beranda</a></li>
            <li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-th-list icon-white"></i> Referensi<span class="caret"></span></a>
				<ul class="dropdown-menu" aria-labelledby="themes">
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/klas_surat"><i class="icon-th-large icon-red"></i> Klasifikasi Surat</a></li>
				</ul>
            </li>
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-random icon-white"> </i> Agenda Surat <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/surat_masuk"><i class="icon-file icon-red"></i> Surat Masuk</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/surat_keluar"><i class="icon-file icon-red"></i> Surat Keluar</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/tanda_terima"><i class="icon-file icon-red"></i> Tanda Terima</a></li>
              </ul>
            </li>
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-briefcase icon-white"> </i> &nbsp;SK & Nota Dinas <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/surat_keputusan"><i class="icon-file icon-red"></i> Surat Keputusan</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/notadinas_keluar"><i class="icon-file icon-red"></i> Nota Dinas Keluar</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/notadinas_masuk"><i class="icon-file icon-red"></i> Nota Dinas Masuk</a></li>
              </ul>
            </li>
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-briefcase icon-white"> </i> &nbsp; Diklat<span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/surat_konsul"><i class="icon-file icon-red"></i> Konsultasi Ibel</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/surat_ibel"><i class="icon-file icon-red"></i> Ijin Belajar</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/surat_skmi"><i class="icon-file icon-red"></i> SKMI</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/surat_skb"><i class="icon-file icon-red"></i> SKB</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/surat_tubel"><i class="icon-file icon-red"></i> Tugas Belajar</a></li>
              </ul>
            </li>
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-file icon-white"> </i> Rekap Agenda <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/agenda_surat_masuk"><i class="icon-barcode icon-red"></i> Surat Masuk</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/agenda_surat_keluar"><i class="icon-barcode icon-red"></i> Surat Keluar</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/agenda_surat_keputusan"><i class="icon-barcode icon-red"></i> Surat Keputusan</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/agenda_nodin_keluar"><i class="icon-barcode icon-red"></i> Nota Dinas Keluar</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/agenda_nodin_masuk"><i class="icon-barcode icon-red"></i> Nota Dinas Masuk</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/toExcelAll"><i class="icon-barcode icon-red"></i> toExcelAll</a></li>
              </ul>
            </li>
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-file icon-white"> </i> Excel <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/agenda_surat_masuk2"><i class="icon-barcode icon-red"></i> Surat Masuk</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/agenda_surat_keluar2"><i class="icon-barcode icon-red"></i> Surat Keluar</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/agenda_surat_keputusan2"><i class="icon-barcode icon-red"></i> Surat Keputusan</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/agenda_nodin_keluar2"><i class="icon-barcode icon-red"></i> Nota Dinas Keluar</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/agenda_nodin_masuk2"><i class="icon-barcode icon-red"></i> Nota Dinas Masuk</a></li>
              </ul>
            </li>
			<?php
			if ($this->session->userdata('admin_level') == "Super Admin") {
			?>
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-wrench icon-white"> </i> Setting <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/pengguna"><i class="icon-home icon-red"></i>&nbsp;&nbsp;Instansi Pengguna</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/manage_admin"><i class="icon-user icon-red"></i>&nbsp;&nbsp;Manajemen Admin</a></li>
				<li><a tabindex="-1" href="<?php echo base_url(); ?>admin/backup"><i class="icon-th-list icon-red"></i>&nbsp;&nbsp;Backup Database</a></li>
              </ul>
            </li>
			<?php 
			}
			?>
          
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-user icon-white"></i> Administrator <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/passwod"><i class="icon-pencil icon-red"></i>&nbsp;&nbsp;Rubah Password</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>admin/logout"><i class="icon-off icon-red"></i>&nbsp;&nbsp;Logout</a></li>
                <li><a tabindex="-1" href="http://orpegsetda.wonosobokab.go.id" target="_blank">Help</a></li>
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

     <br><br>

		<?php $this->load->view('admin/'.$page); ?>
	  
	  <div class="span12 well well-sm">
		
		<h6>&copy;  2014. Waktu Eksekusi : {elapsed_time}, Penggunaan Memori : {memory_usage}</h6>
	  </div>
 
    </div>

  
</body></html>