<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$idp		= $datpil->id;
	$kode		= $datpil->kode;
	$nama		= $datpil->nama;
	$uraian		= $datpil->uraian;
} else {
	$act		= "act_add";
	$idp		= "";
	$kode		= "";
	$nama		= "";
	$uraian		= "";
}
?>
<div class="navbar navbar-inverse">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Klasifikasi Surat (PERBUP WONOSOBO NO. 24 Tahun 2007)
</a>
		</div>
	</div><!-- /.container -->
</div><!-- /.navbar -->

<?php echo $this->session->flashdata("k_passwod");?>
	
<form action="<?=base_URL()?>admin/klas_surat/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input type="hidden" name="idp" value="<?php echo $idp; ?>">
	<table width="100%" class="table-form">
	<tr><td width="20%">Kode Surat</td><td><b><input type="text" name="kode" required value="<?php echo $kode; ?>" style="width: 400px" class="form-control"></b></td></tr>
	<tr><td width="20%">Nama</td><td><b><input type="text" name="nama" required value="<?php echo $nama; ?>" style="width: 400px" class="form-control"></b></td></tr>
	<tr><td width="20%">Uraian</td><td><b><textarea name="uraian" required style="width: 600px; height: 200px" class="form-control"><?php echo $uraian; ?></textarea></b></td></tr>		
	<tr><td colspan="2">
	<br><button type="submit" class="btn btn-primary">Simpan</button>
	<button type="reset" class="btn btn-info">Reset</button>
	<a href="<?=base_URL()?>admin/klas_surat" class="btn btn-success">Kembali</a>
	</td></tr>
	</table>
</form>