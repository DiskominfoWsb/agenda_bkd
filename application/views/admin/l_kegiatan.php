<div class="clearfix">
<div class="row">
  <div class="col-lg-12">
	
	<div class="navbar navbar-inverse" style="background-color:#40ccbf;">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Agenda Kegiatan</a>
			</div>
		<div class="navbar-collapse collapse navbar-inverse-collapse" style="margin-right: -20px">
			<ul class="nav navbar-nav">
				<li><a href="<?php echo base_URL(); ?>admin/kegiatan/add" class="btn-info"><i class="icon-plus-sign icon-white"> </i> Tambah Data</a></li>
				
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

  </div>
</div>

<?php echo $this->session->flashdata("k");?>

<table id="example3" class="table table-bordered table-hover">
	<thead>
		<tr>
			<th width="5%">No.</th>
			<!-- <th width="4%">Tahun</th> -->
			<th width="25%">Kegiatan / Acara</th>
			<th width="10%">Waktu</th>
			<th width="15%">Tempat<br>Jam</th>
			<th width="15%">Pelaksana</th>
			<th width="20%">Catatan Disposisi</th>
			<th width="15%">Aksi</th>
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
			<td><?php echo $no;?></td>
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
			<td align="center"><?=$b->disp;?></td>
			<td class="ctr">

				<div class="btn-group">
					<a href="<?=base_URL()?>admin/kegiatan/edt/<?=$b->id?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Edit</a>
					<a href="<?=base_URL()?>admin/kegiatan/del/<?=$b->id?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda Yakin..?')"><i class="icon-trash icon-white"> </i> Hapus</a>
	<!--			<a href="<?=base_URL()?>admin/pengantar_cetak/<?=$b->id?>" class="btn btn-info btn-sm" target="_blank" title="Cetak LP" ><i class="icon-print icon-white"> </i> Ctk LP</a>
					<a href="<?//=base_URL()?>admin/surat_pengantar/<?//=$b->id?>/edt/<?//=$b->id?>" class="btn btn-default btn-sm" title="Edit LP" disable=""><i class="icon-edit icon-white" > </i>Edt.LP</a>-->
				</div>	

			</td>
		</tr>
		<?php 
			$no++;
			}
		}
		?>
	</tbody>
</table>
<!--<center><ul class="pagination"><?php// echo $pagi; ?></ul></center>-->
</div>
