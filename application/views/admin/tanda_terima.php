<html>
<head>
<style type="text/css" media="print">
	table {border: solid 1px #000; border-collapse: collapse; width: 100%}
	tr { border: solid 1px #000; page-break-inside: avoid;}
	td { border: solid 1px #000; padding: 7px 5px; font-size: 10px}
	th {
		font-family:Arial;
		color:black;
		font-size: 11px;
		background-color:lightgrey;
	}
	thead {
		display:table-header-group;
	}
	tbody {
		display:table-row-group;
	}
	h3 { margin-bottom: -17px }
	h2 { margin-bottom: 0px }
</style>
<style type="text/css" media="screen">
	table {border: solid 1px #000; border-collapse: collapse; width: 100%}
	tr { border: solid 1px #000}
	th {
		font-family:Arial;
		color:black;
		font-size: 11px;
		background-color: #999;
		padding: 8px 0;
	}
	td { border: solid 1px #000; padding: 7px 5px;font-size: 10px}
	h3 { margin-bottom: -17px }
	h2 { margin-bottom: 0px }
</style>
<title>Tanda Terima</title>
</head>

<body onload="window.print()">
	<center><b align="center" style="font-size: 17px">TANDA TERIMA SURAT BAGIAN ORGANISASI DAN KEPEGAWAIAN</b><br>
	<b>(&nbsp;&nbsp;<u><?php echo $unit_pengolah."</u>&nbsp;&nbsp;)</b>"; ?>
	</center>
	<b style="font-size: 15px">SURAT MASUK</b><br>
	
	<table>
		<thead>
			<tr>
				<th width="3%">No</td>
				<th width="8%">No. Agenda</td>
				<th width="25%">Isi Ringkas</td>
				<th width="10%">Dari</td>
				<th width="12%">Nomor Surat</td>
				<th width="6%">Tgl. Surat</td>
				<th width="10%">Unit Pengolah</td>
				<th width="8%">Admin</td>
				<!-- <th width="6%">Tgl, Paraf</td> -->
			</tr>
		</thead>
		<tbody>
			<?php 
			if (!empty($data)) {
				$no = 0;
				foreach ($data as $d) {
					$no++;
			?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $d->kode." / ".$d->no_agenda." / ".$d->tahun?></td>
				<td><?php echo $d->isi_ringkas; ?></td>
				<td><?php echo $d->dari; ?></td>
				<td><?php echo $d->no_surat; ?></td>
				<td align="center"><?php echo tgl_jam_sql($d->tgl_surat); ?></td>
				<td><?php echo $d->unit_pengolah; ?></td>
				<td><?php echo gval("t_admin", "id", "nama", $d->pengolah); ?></td>
				<!-- <td align="center">< ?php echo tgl_jam_sql2($d->tgl_diterima); ?></td> -->
			</tr>
			<?php 
				}
			} else {
				echo "<tr><td style='text-align: center' colspan='9'>Tidak ada data</td></tr>";
			}
			?>
		</tbody>
	</table>
</body>
</html>

