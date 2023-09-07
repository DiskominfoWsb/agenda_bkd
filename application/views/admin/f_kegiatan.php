<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act			= "act_edt";
	$idp			= $datpil->id;
	$kode			= $datpil->kode;
	$no_keg			= $datpil->no_keg;
	$tahun			= $datpil->tahun;
	$tempat			= $datpil->tempat;
	$pegawai		= $datpil->pegawai;
	$isi_keg		= $datpil->isi_keg;
	$tgl_kegiatan	= $datpil->tgl_keg;
	$tgl_kegiatan_end= $datpil->tgl_keg_end;
	$jam			= $datpil->jam;
	$disp			= $datpil->disp;
	$jam_end		= $datpil->jam_end;
	$unit_pengolah	= $datpil->unit_pengolah;
		
} else {
	$act			= "act_add";
	$idp			= "";
	$kode			= "";
	$no_keg			= "";
	$tahun			= "";
	$tempat			= "";
	$pegawai        = "";
	$isi_keg		= "";
	$tgl_kegiatan   = "";
	$tgl_kegiatan_end  = "";
	$disp			="";
	$jam			="";
	$jam_end		="";
	$unit_pengolah	= ""; 
	
}
?>
<div class="navbar navbar-inverse" style="background-color:#40ccbf;">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Agenda Kegiatan</a>
			</div>
		<div class="navbar-collapse collapse navbar-inverse-collapse" style="margin-right: -20px">
			<ul class="nav navbar-nav">
				
				<li><a href="<?=base_URL()?>admin/kegiatan"><i class="icon-share icon-white"></i>Kembali</a></li>
			</ul>
			
			<!--<ul class="nav navbar-nav navbar-right">
				<form class="navbar-form navbar-left" method="post" action="<?//=base_URL()?>admin/kegiatan/cari">
					<input type="text" class="form-control" name="q" style="width: 200px" placeholder="Kata kunci pencarian ..." required>
					<button type="submit" class="btn btn-danger"><i class="icon-search icon-white"> </i> Cari</button>
				</form>
			</ul>-->
		</div><!-- /.nav-collapse -->
		</div><!-- /.container -->
	</div><!-- /.navbar -->
	
	<form action="<?=base_URL()?>admin/kegiatan/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	
	<input type="hidden" name="idp" value="<?php echo $idp; ?>">
	
	<div class="row-fluid well" style="overflow: hidden">
	
	<div class="col-lg-6">
		<table width="100%" class="table-form">

		<tr><td width="20%">Kegiatan / Acara</td><td colspan="3"><textarea name="isi_keg" required style="width: 400px; height: 80px" class="form-control"><?php echo $isi_keg; ?></textarea></td></tr>
		<tr><td width="20%">Tempat</td><td colspan="3"><input type="text" name="tempat" required value="<?php echo $tempat; ?>" id="dari" style="width: 400px" class="form-control" placeholder="instansi dan kota"></td></tr>
		<tr><td width="20%">Tanggal Mulai</td><td><input type="text" name="tgl_kegiatan" required value="<?php echo $tgl_kegiatan; ?>" id="tgl_surat1" style="width: 140px" class="form-control"></td><td><center>s.d</center></td><td>
        <input type="text" name="tgl_kegiatan_end" required value="<?php echo $tgl_kegiatan_end; ?>" id="tgl_surat2" style="width: 140px" class="form-control"></td></tr>
        <tr><td width="20%">Jam</td><td><input type="text" name="jam" required value="<?php echo $jam; ?>" id="" style="width: 140px" class="form-control"></td><td><center>s.d</center></td><td>
        <input type="text" name="jam_end" required value="<?php echo $jam_end; ?>" id="" style="width: 140px" class="form-control"></td></tr>		
		<tr><td width="20%">Pelaksana</td><td colspan="3"><textarea name="pegawai"   style="width: 400px" class="form-control"><?php echo $pegawai; ?></textarea></td></tr>
		<tr><td width="20%">Unit Pengolah</td><td colspan="3"><input type="text" name="unit_pengolah" id="unit_pengolah" required value="<?php echo $unit_pengolah; ?>" style="width: 400px" class="form-control"></td></tr>
		<tr><td width="20%">Catatan/Disposisi</td><td colspan="3"><textarea name="disp"  style="width: 400px" class="form-control"><?php echo $disp; ?></textarea> </td></tr>		
		<tr><td width="20%">Dokumen</td><td><b><input type="file" name="file_surat" class="form-control" style="width: 200px"></b></td></tr>
		<tr><td></td><td colspan="3"><button type="submit" class="btn btn-primary">Simpan</button>
		<button type="Reset" class="btn btn-info">Reset</button>
		
		</td></tr>
		
		</table>
	</div>
	</form>
	<div class="col-lg-6">	
		<table width="100%" class="table-form">
			
			
			
		
		</table>
	</div>
	
	</div>
	
	