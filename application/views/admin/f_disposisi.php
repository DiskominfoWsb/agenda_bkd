<?php 
$q_instansi	= $this->db->query("SELECT * FROM tr_instansi LIMIT 1")->row();
?>

<html>
<head>
<style type="text/css" media="print">
	table {border: solid 1px #000; border-collapse: collapse; width: 100%}
	tr { border: solid 1px #000}
	td { padding: 5px 3px}
	h3 { margin-bottom: -20px}
	h2 { margin-bottom: 0px }
</style>
<style type="text/css" media="screen">
	table {border: solid 1px #000; border-collapse: collapse; width: 60%}
	tr { border: solid 1px #000}
	td { padding: 5px 3px}
	h3 { margin-bottom: -20px }
	h2 { margin-bottom: 0px }
</style>
</head>

<body onload="window.print()">
<table>
	<tr><td style="height: 40px" valign="top" colspan="0">
	<img src="<?php echo base_url(); ?>upload/<?php echo $q_instansi->logo; ?>" valign="bottom" style="display: inline; float: right; margin-right: 70px; width: 75px; height: 80px">
	</b></td><td valign="top" width="200%" style="border-left: solid 0px">
	<h3 align="center">P E M E R I N T A H &nbsp;&nbsp; K A B U P A T E N &nbsp;&nbsp; W O N O S O B O</h3>
	<h2 align="center"><?php echo $q_instansi->nama; ?></h2>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alamat : <?php echo $q_instansi->alamat; ?>
	</td>
	</tr>
	<tr><td colspan="3" align="center" style="padding: 10px 0"><b style="font-size: 18px;">LEMBAR DISPOSISI</b></td></tr>
	<tr><td width="25%"><b>No. Agenda</b></td><td width="50%">: <?php echo $datpil1->kode."/".$datpil1->no_agenda; ?> </td></tr>
	<tr><td><b>Asal Surat</b></td><td colspan="2">: <?php echo $datpil1->dari; ?></td></tr>
	<tr><td width="25%"><b>Nomor Surat</b></td><td colspan="2">: <?php echo $datpil1->no_surat; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Tanggal : </b><?php echo tgl_jam_sql($datpil1->tgl_surat); ?></td></tr>
	<tr><td><b>Isi Ringkas</b></td><td colspan="4" style="border-left: solid 0px" align="justify"> : <?php echo $datpil1->isi_ringkas; ?></td></tr>
	<tr><td><b>Diterima Tanggal</b></td><td colspan="2">: <?php echo tgl_jam_sql2($datpil1->tgl_diterima); ?></td></tr>
	<tr><td style="height: 200px" valign="top" colspan="1">
	<b><u>Ditujukan kepada : </u></b>
	<br>1. Sekretaris BKD[...]
	      <br>1.1 Umpeg
		  <br>1.2 PPEP		  
	<br>2. Ka.Bid. Perencanaan dan Penatausahaan Kepeg.[....]
	      <br>2.1 Subbid Perenc.
		  <br>2.2 Subbid Penata.Ush.Kepeg
	<br>3. Ka.Bid. Diklat dan Pengembangan Karier[....]
	      <br>3.1 Subbid Diklat
		  <br>3.2 Subbid Pengemb.Karier
	<br>4. Ka.Bid. Pemb. dan Penil. Kinerja Aparatur[....]
	      <br>4.1 Subbid Disiplin
		  <br>4.2 Subbid Kinerja
	
	
	</b></td><td valign="top" width="80%" style="border-left: solid 1px" >
	<b>Isi Disposisi :</b>

	</td></tr>
	<!-- <tr><td colspan="3" style="line-height: 4px; font-size=2pt; " align="right" font="8pt">&copy;bkd_wonosobo<br>
	<!-- Kepada : ........................................................................................................................................<br>
	Tanggal : ........................................................................................................................................<br> -->
	</td></tr>
</table>
</body>
</html>