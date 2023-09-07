
<!DOCTYPE html>
<!-- saved from url=(0029)http://bootswatch.com/amelia/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>.:: e-Agenda ::.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
	<style type="text/css">
	@font-face {
	  font-family: 'Cabin';
	  font-style: normal;
	  font-weight: 400;
	  src: local('Cabin Regular'), local('Cabin-Regular'), url(<?php echo base_url(); ?>aset/font/satu.woff) format('woff');
	}
	@font-face {
	  font-family: 'Cabin';
	  font-style: normal;
	  font-weight: 700;
	  src: local('Cabin Bold'), local('Cabin-Bold'), url(<?php echo base_url(); ?>aset/font/dua.woff) format('woff');
	}
	@font-face {
	  font-family: 'Lobster';
	  font-style: normal;
	  font-weight: 400;
	  src: local('Lobster'), url(<?php echo base_url(); ?>aset/font/tiga.woff) format('woff');
	}	
	
	</style>
    <link rel="stylesheet" href="<?php echo base_url(); ?>aset/css/bootstrap.css" media="screen">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../bower_components/bootstrap/assets/js/html5shiv.js"></script>
      <script src="../bower_components/bootstrap/assets/js/respond.min.js"></script>
    <![endif]-->
  

    <script src="<?php echo base_url(); ?>aset/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>aset/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>aset/js/bootswatch.js"></script>
    <script src="<?php echo base_url(); ?>aset/js/jquery.chained.js"></script>
	<script src="<?php echo base_url(); ?>aset/js/jquery/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>aset/js/datatables.min.js"></script>
	<script>
	$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})
	
		
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
  <body style="">
    <div class="navbar navbar-inverse navbar-fixed-top" style="background-color:#a84b9d;">
      <div class="container">
        <div class="navbar-header">
          <span class="navbar-brand"><strong style="font-family: verdana; margin-left: -50px; font-size: 24px"><i>e-Agenda</i> </strong>Badan Kepegawaian Daerah</span>
		  <span>
		 	  
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
         <div class="navbar-collapse collapse" id="navbar-main">
		  <ul class="nav navbar-nav navbar-right">
		  <li >
		<a href="#" data-toggle="modal" data-target="#exampleModal"><i class="icon-user icon-white"></i> Login</a>
             
           </li>
				
		  </ul>
		 </div>
		 
		 

      </div>
    </div>
<div class="container">
<br><br><br>
<div class="row">
  <div class="col-lg-12">
		


<?php echo $this->session->flashdata("k");?>

<table id="example3" class="table table-bordered table-hover">
	<thead>
		<tr>
			<th width="10%">No.Kegiatan</th>
			<!-- <th width="4%">Tahun</th> -->
			<th width="25%">Tema Kegiatan</th>
			<th width="10%">Waktu</th>
			<th width="15%">Tempat</th>
			<th width="15%">Peserta</th>
			
		</tr>
	</thead>
	
	<tbody>
		<?php 
		if (empty($data)) {
			echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
			foreach ($data2 as $b) {
		?>
		<tr>
			<td><?php echo $b->kode."/".$b->no_keg;?></td>
			<!--<td align="center">< ?=$b->tahun;?></td>-->
			<td><?=$b->isi_keg;?></td>
			<td align="center"><?=$b->tgl_keg;?><br><i>s.d</i><br><?=$b->tgl_keg_end;?></td>
			<td><?=$b->tempat;?></td>
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
<!--<center><ul class="pagination"><?php// echo $pagi; ?></ul></center>-->
</div>



	  

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Login</h4>
      </div>
      <div class="modal-body"><?=$this->session->flashdata("k")?>
        <form action="<?=base_URL()?>admin/do_login" method="post">
          <div class="form-group">
            <label for="recipient-name" class="control-label">User:</label>
            <input type="text" name="u" class="form-control" required autofocus>
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Password:</label>
            <input type="password" name="p" class="form-control" required>
          </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">OK</button>
      </div>
	   </form>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <center style="margin-top: -15px;">&copy; <a href="">2014</a> |<a href="http://bkd.wonosobokab.go.id">Badan Kepegawaian Daerah Kab.Wonosobo</a>
	</center>
	</div>
	</div>	
</div>	
<!--/.fluid-container-->	
	<script type="text/javascript">
	$(document).ready(function(){
		$(" #alert" ).fadeOut(6000);
	});
	</script>
	  
    
  
</body></html>
