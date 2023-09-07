      <div class="clearfix">

		<div class="alert alert-dismissable alert-danger">
		 <button type="reset" class="btn btn-danger">Perhatian!! Entry agenda hanya boleh dilakukan bagi admin yang berhak </button>
			<strong><?php //echo $this->session->userdata('admin_nama'); ?></strong><br>
			
			<br>
			<ul>
			<li>Entry agenda harus diinput lengkap, kecuali file pendukung</li>
			<li>Agenda yang tidak ada tombol Cek File berarti tidak ada file pendukung</li>
			<hr>
			
			Ketentuan Agenda yang ditampilkan di halaman muka adalah agenda hari ini dan yang akan datang
			<li>Jam 00.00  sd 16.00 ditampilkan agenda hari ini dan yang akan datang</li>
			<li>Jam 16.00  sd 23.59 hanya ditampilkan agenda yang akan datang</li>
			
			</ul>
			
		</div>
			
      </div>
