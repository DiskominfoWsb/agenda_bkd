<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();
		//function excel_model() {
		$this->load->model('excel_model');//load the model
		$this->load->library('pagination');
	}
	
	//function to get the data from t_surat_masuk
	function getAgendaSuratMasuk() {
	$data['title'] = 'menampilkan isi';
	$data['detail'] = $this->excel_model->getAgendaSuratMasuk();//call the model and save the result in $detail
	$this->load->view('admin/agenda_surat_masuk2', $data);
	}
	//function to export to excel
	//function toExcelAll() {
	//$query['data1'] = $this->excel_model->ToExcelAll(); 
	//$this->load->view('admin/agenda_nodin_masuk2',$query);
	//}
	
	public function index() {
		
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		$a['page']	= "d_amain";
		$this->load->view('admin/aaa', $a);
	}

		
	public function klas_surat() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM ref_klasifikasi")->num_rows();
		$per_page		= 15;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/klas_surat/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$nama					= addslashes($this->input->post('nama'));
		$uraian					= addslashes($this->input->post('uraian'));
	
		$cari					= addslashes($this->input->post('q'));

		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM ref_klasifikasi WHERE nama LIKE '%$cari%' OR uraian LIKE '%$cari%' ORDER BY id ASC")->result();
			$a['page']		= "l_klas_surat";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_klas_surat";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM ref_klasifikasi WHERE id = '$idu'")->row();	
			$a['page']		= "f_klas_surat";
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE ref_klasifikasi SET kode = '$kode', nama = '$nama', uraian = '$uraian' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/klas_surat');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM ref_klasifikasi LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_klas_surat";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	
	public function surat_masuk() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_surat_masuk")->num_rows();
		$per_page		= 20;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_masuk/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		$cari					= addslashes($this->input->post('q'));
		//------------//
		$a['thn']=date('Y');
		$a['nextagenda']		= $this->db->query("SELECT * FROM t_surat_masuk where tahun='$a[thn]'  ")->num_rows()+1;
		

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_masuk';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_surat_masuk WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_masuk');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_surat_masuk WHERE isi_ringkas LIKE '%$cari%' or dari LIKE '%$cari%' or tahun LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_masuk";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_masuk";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_surat_masuk WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_masuk";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_surat_masuk VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_surat_masuk VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert1\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/surat_masuk');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_surat_masuk SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_surat_masuk SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
				
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_masuk');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_surat_masuk order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data2']		= $this->db->query("SELECT * FROM t_surat_masuk where tahun =$a[thn]  order by no_agenda DESC ")->result();
			$a['page']		= "l_surat_masuk";
		}
		
		$this->load->view('admin/aaa', $a);
	}


	public function surat_keluar() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_surat_keluar")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_keluar/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));
		//-------
		$a['thn']=date('Y');
		$a['nextagenda']		= $this->db->query("SELECT * FROM t_surat_keluar where tahun='$a[thn]' ")->num_rows()+1;

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$isi_ringkas			= addslashes($this->input->post('isi_ringkas'));
		$tujuan					= addslashes($this->input->post('tujuan'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$ket					= addslashes($this->input->post('ket'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_keluar';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_surat_keluar WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_keluar');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_surat_keluar WHERE isi_ringkas LIKE '%$cari%' or tujuan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_keluar";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_keluar";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_surat_keluar WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_keluar";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_surat_keluar VALUES (NULL, '$kode', '$no_agenda', '$tahun', '$isi_ringkas', '$tujuan', '$tgl_surat', NOW(), '$unit_pengolah', '$ket', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_surat_keluar VALUES (NULL, '$kode', '$no_agenda', '$tahun', '$isi_ringkas', '$tujuan', '$tgl_surat', NOW(), '$unit_pengolah', '$ket', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_keluar');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_surat_keluar SET kode = '$kode', no_agenda = '$no_agenda', tahun = '$tahun', isi_ringkas = '$isi_ringkas', tujuan = '$tujuan', tgl_surat = '$tgl_surat', unit_pengolah = '$unit_pengolah', keterangan = '$ket', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_surat_keluar SET kode = '$kode', no_agenda = '$no_agenda', tahun = '$tahun', isi_ringkas = '$isi_ringkas', tujuan = '$tujuan', tgl_surat = '$tgl_surat', unit_pengolah = '$unit_pengolah', keterangan = '$ket', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_keluar');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_surat_keluar order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data2']		= $this->db->query("SELECT * FROM t_surat_keluar where tahun=$a[thn] order by no_agenda DESC ")->result();
			$a['page']		= "l_surat_keluar";
		}
		
		$this->load->view('admin/aaa', $a);
	}

	public function surat_disposisi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(4);
		$idu1					= $this->uri->segment(3);
		$idu2					= $this->uri->segment(5);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$id_surat				= addslashes($this->input->post('id_surat'));
		$kpd_yth				= addslashes($this->input->post('kpd_yth'));
		$isi_disposisi			= addslashes($this->input->post('isi_disposisi'));
		$sifat					= addslashes($this->input->post('sifat'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$catatan				= addslashes($this->input->post('catatan'));
		
		$cari					= addslashes($this->input->post('q'));
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_disposisi WHERE id_surat = '$idu1'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_disposisi/".$idu1."/p");
		
		$a['judul_surat']	= gval("t_surat_masuk", "id", "isi_ringkas", $idu1);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_disposisi WHERE id = '$idu2'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_disposisi/'.$idu2);
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi WHERE isi_disposisi LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_disposisi";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_disposisi";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_disposisi WHERE id = '$idu2'")->row();	
			$a['page']		= "f_surat_disposisi";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_disposisi VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_disposisi/'.$idu2);
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE t_disposisi SET kpd_yth = '$kpd_yth', isi_disposisi = '$isi_disposisi', sifat = '$sifat', batas_waktu = '$batas_waktu', catatan = '$catatan' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/surat_disposisi/'.$idu2);
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi WHERE id_surat = '$idu1' LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_surat_disposisi";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	//Disposisi konsul
	public function surat_disposisi_konsul() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(4);
		$idu1					= $this->uri->segment(3);
		$idu2					= $this->uri->segment(5);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$id_surat				= addslashes($this->input->post('id_surat'));
		$kpd_yth				= addslashes($this->input->post('kpd_yth'));
		$isi_disposisi			= addslashes($this->input->post('isi_disposisi'));
		$sifat					= addslashes($this->input->post('sifat'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$catatan				= addslashes($this->input->post('catatan'));
		
		$cari					= addslashes($this->input->post('q'));
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_disposisi_konsul WHERE id_surat = '$idu1'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_disposisi_konsul/".$idu1."/p");
		
		$a['judul_surat']	= gval("t_suratm_konsul", "id", "isi_ringkas", $idu1);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_disposisi_konsul WHERE id = '$idu2'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_disposisi_konsul/'.$idu2);
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_konsul WHERE isi_disposisi LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_disposisi_konsul";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_disposisi_konsul";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_disposisi_konsul WHERE id = '$idu2'")->row();	
			$a['page']		= "f_surat_disposisi_konsul";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_disposisi_konsul VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_disposisi_konsul/'.$idu2);
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE t_disposisi_konsul SET kpd_yth = '$kpd_yth', isi_disposisi = '$isi_disposisi', sifat = '$sifat', batas_waktu = '$batas_waktu', catatan = '$catatan' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/surat_disposisi_konsul/'.$idu2);
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_konsul WHERE id_surat = '$idu1' LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_surat_disposisi_konsul";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	//**disposisi_ipg
	public function surat_disposisi_ipg() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(4);
		$idu1					= $this->uri->segment(3);
		$idu2					= $this->uri->segment(5);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$id_surat				= addslashes($this->input->post('id_surat'));
		$kpd_yth				= addslashes($this->input->post('kpd_yth'));
		$isi_disposisi			= addslashes($this->input->post('isi_disposisi'));
		$sifat					= addslashes($this->input->post('sifat'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$catatan				= addslashes($this->input->post('catatan'));
		
		$cari					= addslashes($this->input->post('q'));
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_disposisi_ipg WHERE id_surat = '$idu1'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_disposisi_ipg/".$idu1."/p");
		
		$a['judul_surat']	= gval("t_suratm_ipg", "id", "isi_ringkas", $idu1);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_disposisi_ipg WHERE id = '$idu2'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_disposisi_ipg/'.$idu2);
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_ipg WHERE isi_disposisi LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_disposisi_ipg";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_disposisi_ipg";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_disposisi_ipg WHERE id = '$idu2'")->row();	
			$a['page']		= "f_surat_disposisi_ipg";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_disposisi_ipg VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_disposisi_ipg/'.$idu2);
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE t_disposisi_ipg SET kpd_yth = '$kpd_yth', isi_disposisi = '$isi_disposisi', sifat = '$sifat', batas_waktu = '$batas_waktu', catatan = '$catatan' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/surat_disposisi_ipg/'.$idu2);
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_ipg WHERE id_surat = '$idu1' LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_surat_disposisi_ipg";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	//**disposisi_ibel
	public function surat_disposisi_ibel() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(4);
		$idu1					= $this->uri->segment(3);
		$idu2					= $this->uri->segment(5);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$id_surat				= addslashes($this->input->post('id_surat'));
		$kpd_yth				= addslashes($this->input->post('kpd_yth'));
		$isi_disposisi			= addslashes($this->input->post('isi_disposisi'));
		$sifat					= addslashes($this->input->post('sifat'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$catatan				= addslashes($this->input->post('catatan'));
		
		$cari					= addslashes($this->input->post('q'));
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_disposisi_ibel WHERE id_surat = '$idu1'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_disposisi_ibel/".$idu1."/p");
		
		$a['judul_surat']	= gval("t_suratm_ibel", "id", "isi_ringkas", $idu1);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_disposisi_ibel WHERE id = '$idu2'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_disposisi_ipg/'.$idu2);
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_ibel WHERE isi_disposisi LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_disposisi_ibel";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_disposisi_ibel";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_disposisi_ibel WHERE id = '$idu2'")->row();	
			$a['page']		= "f_surat_disposisi_ibel";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_disposisi_ibel VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_disposisi_ibel/'.$idu2);
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE t_disposisi_ibel SET kpd_yth = '$kpd_yth', isi_disposisi = '$isi_disposisi', sifat = '$sifat', batas_waktu = '$batas_waktu', catatan = '$catatan' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/surat_disposisi_ibel/'.$idu2);
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_ibel WHERE id_surat = '$idu1' LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_surat_disposisi_ibel";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	
	//**disposisi_skmi
	public function surat_disposisi_skmi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(4);
		$idu1					= $this->uri->segment(3);
		$idu2					= $this->uri->segment(5);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$id_surat				= addslashes($this->input->post('id_surat'));
		$kpd_yth				= addslashes($this->input->post('kpd_yth'));
		$isi_disposisi			= addslashes($this->input->post('isi_disposisi'));
		$sifat					= addslashes($this->input->post('sifat'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$catatan				= addslashes($this->input->post('catatan'));
		
		$cari					= addslashes($this->input->post('q'));
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_disposisi_skmi WHERE id_surat = '$idu1'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_disposisi_skmi/".$idu1."/p");
		
		$a['judul_surat']	= gval("t_suratm_skmi", "id", "isi_ringkas", $idu1);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_disposisi_skmi WHERE id = '$idu2'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_disposisi_ipg/'.$idu2);
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_skmi WHERE isi_disposisi LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_disposisi_skmi";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_disposisi_skmi";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_disposisi_skmi WHERE id = '$idu2'")->row();	
			$a['page']		= "f_surat_disposisi_skmi";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_disposisi_skmi VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_disposisi_skmi/'.$idu2);
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE t_disposisi_skmi SET kpd_yth = '$kpd_yth', isi_disposisi = '$isi_disposisi', sifat = '$sifat', batas_waktu = '$batas_waktu', catatan = '$catatan' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/surat_disposisi_skmi/'.$idu2);
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_skmi WHERE id_surat = '$idu1' LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_surat_disposisi_skmi";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	
	//**disposisi_skb
	public function surat_disposisi_skb() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(4);
		$idu1					= $this->uri->segment(3);
		$idu2					= $this->uri->segment(5);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$id_surat				= addslashes($this->input->post('id_surat'));
		$kpd_yth				= addslashes($this->input->post('kpd_yth'));
		$isi_disposisi			= addslashes($this->input->post('isi_disposisi'));
		$sifat					= addslashes($this->input->post('sifat'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$catatan				= addslashes($this->input->post('catatan'));
		
		$cari					= addslashes($this->input->post('q'));
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_disposisi_skb WHERE id_surat = '$idu1'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_disposisi_skb/".$idu1."/p");
		
		$a['judul_surat']	= gval("t_suratm_skb", "id", "isi_ringkas", $idu1);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_disposisi_skb WHERE id = '$idu2'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_disposisi_skb/'.$idu2);
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_skb WHERE isi_disposisi LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_disposisi_skb";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_disposisi_skb";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_disposisi_skb WHERE id = '$idu2'")->row();	
			$a['page']		= "f_surat_disposisi_skb";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_disposisi_skb VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_disposisi_skb/'.$idu2);
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE t_disposisi_skb SET kpd_yth = '$kpd_yth', isi_disposisi = '$isi_disposisi', sifat = '$sifat', batas_waktu = '$batas_waktu', catatan = '$catatan' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/surat_disposisi_skb/'.$idu2);
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_skb WHERE id_surat = '$idu1' LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_surat_disposisi_skb";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	
	//**disposisi_tubel
	public function surat_disposisi_tubel() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(4);
		$idu1					= $this->uri->segment(3);
		$idu2					= $this->uri->segment(5);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$id_surat				= addslashes($this->input->post('id_surat'));
		$kpd_yth				= addslashes($this->input->post('kpd_yth'));
		$isi_disposisi			= addslashes($this->input->post('isi_disposisi'));
		$sifat					= addslashes($this->input->post('sifat'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$catatan				= addslashes($this->input->post('catatan'));
		
		$cari					= addslashes($this->input->post('q'));
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_disposisi_tubel WHERE id_surat = '$idu1'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_disposisi_tubel/".$idu1."/p");
		
		$a['judul_surat']	= gval("t_suratm_tubel", "id", "isi_ringkas", $idu1);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_disposisi_tubel WHERE id = '$idu2'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_disposisi_tubel/'.$idu2);
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_tubel WHERE isi_disposisi LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_disposisi_tubel";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_disposisi_tubel";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_disposisi_tubel WHERE id = '$idu2'")->row();	
			$a['page']		= "f_surat_disposisi_tubel";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_disposisi_tubel VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_disposisi_tubel/'.$idu2);
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE t_disposisi_tubel SET kpd_yth = '$kpd_yth', isi_disposisi = '$isi_disposisi', sifat = '$sifat', batas_waktu = '$batas_waktu', catatan = '$catatan' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/surat_disposisi_tubel/'.$idu2);
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_tubel WHERE id_surat = '$idu1' LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_surat_disposisi_tubel";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	
	//**disposisi_pensiun
	public function surat_disposisi_pensiun() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(4);
		$idu1					= $this->uri->segment(3);
		$idu2					= $this->uri->segment(5);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$id_surat				= addslashes($this->input->post('id_surat'));
		$kpd_yth				= addslashes($this->input->post('kpd_yth'));
		$isi_disposisi			= addslashes($this->input->post('isi_disposisi'));
		$sifat					= addslashes($this->input->post('sifat'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$catatan				= addslashes($this->input->post('catatan'));
		
		$cari					= addslashes($this->input->post('q'));
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_disposisi_pensiun WHERE id_surat = '$idu1'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_disposisi_pensiun/".$idu1."/p");
		
		$a['judul_surat']	= gval("t_suratm_pensiun", "id", "isi_ringkas", $idu1);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_disposisi_pensiun WHERE id = '$idu2'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_disposisi_pensiun/'.$idu2);
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_pensiun WHERE isi_disposisi LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_disposisi_pensiun";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_disposisi_pensiun";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_disposisi_pensiun WHERE id = '$idu2'")->row();	
			$a['page']		= "f_surat_disposisi_pensiun";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_disposisi_pensiun VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_disposisi_pensiun/'.$idu2);
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE t_disposisi_pensiun SET kpd_yth = '$kpd_yth', isi_disposisi = '$isi_disposisi', sifat = '$sifat', batas_waktu = '$batas_waktu', catatan = '$catatan' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/surat_disposisi_pensiun/'.$idu2);
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_pensiun WHERE id_surat = '$idu1' LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_surat_disposisi_pensiun";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	//disposisi cuti//
	//Disposisi cuti
	public function surat_disposisi_cuti() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(4);
		$idu1					= $this->uri->segment(3);
		$idu2					= $this->uri->segment(5);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$id_surat				= addslashes($this->input->post('id_surat'));
		$kpd_yth				= addslashes($this->input->post('kpd_yth'));
		$isi_disposisi			= addslashes($this->input->post('isi_disposisi'));
		$sifat					= addslashes($this->input->post('sifat'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$catatan				= addslashes($this->input->post('catatan'));
		
		$cari					= addslashes($this->input->post('q'));
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_disposisi_cuti WHERE id_surat = '$idu1'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_disposisi_cuti/".$idu1."/p");
		
		$a['judul_surat']	= gval("t_suratm_cuti", "id", "isi_ringkas", $idu1);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_disposisi_cuti WHERE id = '$idu2'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_disposisi_cuti/'.$idu2);
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_cuti WHERE isi_disposisi LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_disposisi_cuti";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_disposisi_cuti";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_disposisi_cuti WHERE id = '$idu2'")->row();	
			$a['page']		= "f_surat_disposisi_cuti";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_disposisi_cuti VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_disposisi_cuti/'.$idu2);
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE t_disposisi_cuti SET kpd_yth = '$kpd_yth', isi_disposisi = '$isi_disposisi', sifat = '$sifat', batas_waktu = '$batas_waktu', catatan = '$catatan' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/surat_disposisi_cuti/'.$idu2);
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_disposisi_cuti WHERE id_surat = '$idu1' LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_surat_disposisi_cuti";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	
	//**lembar pengantar keluar//
	
	public function surat_pengantar() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(4);
		$idu1					= $this->uri->segment(3);
		$idu2					= $this->uri->segment(5);
		$idu3                   = $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$id_surat				= addslashes($this->input->post('id_surat'));
		$kpd_yth				= addslashes($this->input->post('kpd_yth'));
		$isi_disposisi			= addslashes($this->input->post('isi_disposisi'));
		$sifat					= addslashes($this->input->post('sifat'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$catatan				= addslashes($this->input->post('catatan'));
		$cari					= addslashes($this->input->post('q'));
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_pengantar WHERE id_surat = '$idu1'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_pengantar/".$idu1."/p");
		
		$a['kode_surat']	= gval("t_surat_keluar", "id", "kode", $idu1);
		$a['no_surat']	    = gval("t_surat_keluar", "id", "no_agenda", $idu1);
		$a['tgl_surat']	    = gval("t_surat_keluar", "id", "tgl_surat", $idu1);
		$a['judul_surat']	= gval("t_surat_keluar", "id", "isi_ringkas", $idu1);
		$a['tujuan_surat']	= gval("t_surat_keluar", "id", "tujuan", $idu1);
		$a['pengolah']	    = gval("t_surat_keluar", "id", "unit_pengolah", $idu1);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_pengantar WHERE id = '$idu2'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_pengantar/'.$idu2);
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_pengantar WHERE isi_disposisi LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_pengantar";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_pengantar";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_pengantar WHERE id = '$idu2'")->row();	
			$a['page']		= "f_surat_pengantar";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_pengantar VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_pengantar/'.$idu2);
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE t_pengantar SET kpd_yth = '$kpd_yth', isi_disposisi = '$isi_disposisi', sifat = '$sifat', batas_waktu = '$batas_waktu', catatan = '$catatan' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/surat_pengantar/'.$idp);
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_pengantar WHERE id_surat = '$idu1' LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_surat_pengantar";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	//**lembar pengantar nodin//
	
	public function surat_pengantar_nodin() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(4);
		$idu1					= $this->uri->segment(3);
		$idu2					= $this->uri->segment(5);
		$idu3                   = $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$id_surat				= addslashes($this->input->post('id_surat'));
		$kpd_yth				= addslashes($this->input->post('kpd_yth'));
		$isi_disposisi			= addslashes($this->input->post('isi_disposisi'));
		$sifat					= addslashes($this->input->post('sifat'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$catatan				= addslashes($this->input->post('catatan'));
		$cari					= addslashes($this->input->post('q'));
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_pengantar WHERE id_surat = '$idu1'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_pengantar_nodin/".$idu1."/p");
		
		$a['kode_surat']	= gval("t_surat_keluar", "id", "kode", $idu1);
		$a['no_surat']	    = gval("t_surat_keluar", "id", "no_agenda", $idu1);
		$a['tgl_surat']	    = gval("t_surat_keluar", "id", "tgl_surat", $idu1);
		$a['judul_surat']	= gval("t_surat_keluar", "id", "isi_ringkas", $idu1);
		$a['tujuan_surat']	= gval("t_surat_keluar", "id", "tujuan", $idu1);
		$a['pengolah']	    = gval("t_surat_keluar", "id", "unit_pengolah", $idu1);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_pengantar WHERE id = '$idu2'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_pengantar_nodin/'.$idu2);
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_pengantar WHERE isi_disposisi LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_pengantar_nodin";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_pengantar_nodin";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_pengantar WHERE id = '$idu2'")->row();	
			$a['page']		= "f_surat_pengantar_nodin";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_pengantar VALUES (NULL, '$id_surat', '$kpd_yth', '$isi_disposisi', '$sifat', '$batas_waktu', '$catatan')");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_pengantar_nodin/'.$idu2);
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE t_pengantar SET kpd_yth = '$kpd_yth', isi_disposisi = '$isi_disposisi', sifat = '$sifat', batas_waktu = '$batas_waktu', catatan = '$catatan' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/surat_pengantar_nodin/'.$idp);
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_pengantar WHERE id_surat = '$idu1' LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_surat_pengantar_nodin";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	public function pengguna() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		
		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$nama					= addslashes($this->input->post('nama'));
		$alamat					= addslashes($this->input->post('alamat'));
		$kepala					= addslashes($this->input->post('kepala'));
		$nip_kepala				= addslashes($this->input->post('nip_kepala'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('logo')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE tr_instansi SET nama = '$nama', alamat = '$alamat', kepala = '$kepala', nip_kepala = '$nip_kepala', logo = '".$up_data['file_name']."' WHERE id = '$idp'");

			} else {
				$this->db->query("UPDATE tr_instansi SET nama = '$nama', alamat = '$alamat', kepala = '$kepala', nip_kepala = '$nip_kepala' WHERE id = '$idp'");
			}		

			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('admin/pengguna');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM tr_instansi WHERE id = '1' LIMIT 1")->row();
			$a['page']		= "f_pengguna";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	
	public function agenda_surat_masuk() {
		$a['page']	= "f_config_cetak_agenda";
		$this->load->view('admin/aaa', $a);
	}
	
	public function agenda_surat_keluar() {
		$a['page']	= "f_config_cetak_agenda";
		$this->load->view('admin/aaa', $a);
	}
	
	public function agenda_surat_keputusan() {
		$a['page']	= "f_config_cetak_agenda";
		$this->load->view('admin/aaa', $a);
	}
	
	public function agenda_nodin_keluar() {
		$a['page']	= "f_config_cetak_agenda";
		$this->load->view('admin/aaa', $a);
	}
	
	public function agenda_nodin_masuk() {
		$a['page']	= "f_config_cetak_agenda";
		$this->load->view('admin/aaa', $a);
	}
	
	public function cetak_agenda() {
		$jenis_surat	= $this->input->post('tipe');
		$tgl_start		= $this->input->post('tgl_start');
		$tgl_end		= $this->input->post('tgl_end');
		
		$a['tgl_start']	= $tgl_start;
		$a['tgl_end']	= $tgl_end;		

		if ($jenis_surat == "agenda_surat_masuk") {	
			$a['data']	= $this->db->query("SELECT * FROM t_surat_masuk WHERE tgl_diterima >= '$tgl_start' AND tgl_diterima <= '$tgl_end' ORDER BY tahun, no_agenda ASC")->result();
			$this->load->view('admin/agenda_surat_masuk', $a);
			//$this->load->view('admin/agenda_surat_masuk2', $a);
		} else if ($jenis_surat == "agenda_surat_keluar") {
			$a['data']	= $this->db->query("SELECT * FROM t_surat_keluar WHERE tgl_catat >= '$tgl_start' AND tgl_catat <= '$tgl_end' ORDER BY tahun, no_agenda ASC")->result();
			$this->load->view('admin/agenda_surat_keluar', $a);
			//$this->load->view('admin/agenda_surat_keluar2', $a);
		} else if ($jenis_surat == "agenda_surat_keputusan") {
			$a['data']	= $this->db->query("SELECT * FROM t_surat_keputusan WHERE tgl_surat >= '$tgl_start' AND tgl_surat <= '$tgl_end' ORDER BY tgl_surat, nomor ASC")->result();
			$this->load->view('admin/agenda_surat_keputusan', $a);
			//$this->load->view('admin/agenda_surat_keputusan2', $a);
		} else if ($jenis_surat == "agenda_nodin_keluar"){
			$a['data']	= $this->db->query("SELECT * FROM t_notadinas_keluar WHERE tgl_naik >= '$tgl_start' AND tgl_naik <= '$tgl_end' ORDER BY tgl_naik, no_notadinas ASC")->result();
			$this->load->view('admin/agenda_nodin_keluar', $a);
			//$this->load->view('admin/agenda_nodin_keluar2', $a);
		} else {
			$a['data']	= $this->db->query("SELECT * FROM t_notadinas_masuk WHERE tgl >= '$tgl_start' AND tgl <= '$tgl_end' ORDER BY tgl, no_agenda ASC")->result();
			$this->load->view('admin/agenda_nodin_masuk', $a);
			//$this->load->view('admin/agenda_nodin_masuk2', $a);
		}
	}
	
	/*cetak excel*/
	public function agenda_surat_masuk2() {
		$a['page']	= "f_config_cetak_agenda_excel";
		$this->load->view('admin/aaa', $a);
	}
	
	public function agenda_surat_keluar2() {
		$a['page']	= "f_config_cetak_agenda_excel";
		$this->load->view('admin/aaa', $a);
	}
	
	public function agenda_surat_keputusan2() {
		$a['page']	= "f_config_cetak_agenda_excel";
		$this->load->view('admin/aaa', $a);
	}
	
	public function agenda_nodin_keluar2() {
		$a['page']	= "f_config_cetak_agenda_excel";
		$this->load->view('admin/aaa', $a);
	}
	
	public function agenda_nodin_masuk2() {
		$a['page']	= "f_config_cetak_agenda_excel";
		$this->load->view('admin/aaa', $a);
	}
	
	public function cetak_agenda_excel() {
		$jenis_surat	= $this->input->post('tipe');
		$tgl_start		= $this->input->post('tgl_start');
		$tgl_end		= $this->input->post('tgl_end');
		
		$a['tgl_start']	= $tgl_start;
		$a['tgl_end']	= $tgl_end;		

		if ($jenis_surat == "agenda_surat_masuk2") {	
			$a['data']	= $this->db->query("SELECT * FROM t_surat_masuk WHERE tgl_diterima >= '$tgl_start' AND tgl_diterima <= '$tgl_end' ORDER BY tahun, no_agenda ASC")->result();
			$this->load->view('admin/agenda_surat_masuk2', $a);
		} else if ($jenis_surat == "agenda_surat_keluar2") {
			$a['data']	= $this->db->query("SELECT * FROM t_surat_keluar WHERE tgl_catat >= '$tgl_start' AND tgl_catat <= '$tgl_end' ORDER BY tahun, no_agenda ASC")->result();
			$this->load->view('admin/agenda_surat_keluar2', $a);
		} else if ($jenis_surat == "agenda_surat_keputusan2") {
			$a['data']	= $this->db->query("SELECT * FROM t_surat_keputusan WHERE tgl_surat >= '$tgl_start' AND tgl_surat <= '$tgl_end' ORDER BY tgl_surat, nomor ASC")->result();
			$this->load->view('admin/agenda_surat_keputusan2', $a);
		} else if ($jenis_surat == "agenda_nodin_keluar2"){
			$a['data']	= $this->db->query("SELECT * FROM t_notadinas_keluar WHERE tgl_naik >= '$tgl_start' AND tgl_naik <= '$tgl_end' ORDER BY tgl_naik, no_notadinas ASC")->result();
			$this->load->view('admin/agenda_nodin_keluar2', $a);
		} else {
			$a['data']	= $this->db->query("SELECT * FROM t_notadinas_masuk WHERE tgl >= '$tgl_start' AND tgl <= '$tgl_end' ORDER BY tgl, no_agenda ASC")->result();
			$this->load->view('admin/agenda_nodin_masuk2', $a);
		}
	}
	
	public function toExcelAll() {
		$a['page']	= "f_config_cetak_toExcelAll";
		$this->load->view('admin/aaa', $a);
	}
	
	public function cetak_toExcelAll() {
		$jenis_surat	= $this->input->post('tipe3');
		$tgl_start		= $this->input->post('tgl_start');
		$tgl_end		= $this->input->post('tgl_end');
		
		$a['tgl_start']	= $tgl_start;
		$a['tgl_end']	= $tgl_end;

		if ($jenis_surat = "toExcelAll") {	
			$a['data']	= $this->db->query("SELECT * FROM t_surat_masuk WHERE tgl_diterima >= '$tgl_start' AND tgl_diterima <= '$tgl_end' ORDER BY id")->result(); 
			$this->load->view('admin/agenda_surat_masuk2', $a);
			$a['data']	= $this->db->query("SELECT * FROM t_surat_keluar WHERE tgl_catat >= '$tgl_start' AND tgl_catat <= '$tgl_end' ORDER BY id")->result();
			$this->load->view('admin/agenda_surat_keluar2', $a);
			$a['data']	= $this->db->query("SELECT * FROM t_surat_keputusan WHERE tgl_surat >= '$tgl_start' AND tgl_surat <= '$tgl_end' ORDER BY id")->result();
			$this->load->view('admin/agenda_surat_keputusan2', $a);
			$a['data']	= $this->db->query("SELECT * FROM t_notadinas_keluar WHERE tgl_naik >= '$tgl_start' AND tgl_naik <= '$tgl_end' ORDER BY id")->result();
			$this->load->view('admin/agenda_nodin_keluar2', $a);
			$a['data']	= $this->db->query("SELECT * FROM t_notadinas_masuk WHERE tgl >= '$tgl_start' AND tgl <= '$tgl_end' ORDER BY id")->result();
			$this->load->view('admin/agenda_nodin_masuk2', $a);
		} else {

		}
	}
	
	public function tanda_terima() {
		$a['page']	= "f_config_cetak_tandaterima";
		$this->load->view('admin/aaa', $a);
	}
	
	public function cetak_tandaterima() {
		$jenis_surat	= $this->input->post('tipe2');
		$unit_pengolah	= $this->input->post('unit_pengolah');
		$a['unit_pengolah']	= $unit_pengolah;	

		if ($jenis_surat = "tanda_terima") {	
			$a['data']	= $this->db->query("SELECT * FROM t_surat_masuk WHERE unit_pengolah = '$unit_pengolah' AND distribusi = 'Belum' ORDER BY id")->result(); 
			$this->load->view('admin/tanda_terima', $a);
			$a['data']	= $this->db->query("SELECT * FROM t_surat_keluar WHERE unit_pengolah = '$unit_pengolah' AND distribusi = 'Belum' ORDER BY id")->result();
			$this->load->view('admin/tanda_terima2', $a);
			$a['data']	= $this->db->query("SELECT * FROM t_surat_keputusan WHERE keterangan = '$unit_pengolah' AND distribusi = 'Belum' ORDER BY id")->result();
			$this->load->view('admin/tanda_terima3', $a);
			$a['data']	= $this->db->query("SELECT * FROM t_notadinas_keluar WHERE unit_pengolah = '$unit_pengolah' AND distribusi = 'Belum' ORDER BY id")->result();
			$this->load->view('admin/tanda_terima4', $a);
			$a['data']	= $this->db->query("SELECT * FROM t_notadinas_masuk WHERE unit_pengolah = '$unit_pengolah' AND distribusi = 'Belum' ORDER BY id")->result();
			$this->load->view('admin/tanda_terima5', $a);
		} else {

		}
	}
	
	/*code Surat Keputusan*/
	
	public function surat_keputusan() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_surat_keputusan")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_keputusan/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$nomor					= addslashes($this->input->post('nomor'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$tentang				= addslashes($this->input->post('tentang'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$ket					= addslashes($this->input->post('ket'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_keputusan';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_surat_keputusan WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_keputusan');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_surat_keputusan WHERE tentang LIKE '%$cari%' or keterangan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_keputusan";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_keputusan";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_surat_keputusan WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_keputusan";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_surat_keputusan VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_surat_keputusan VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_keputusan');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_surat_keputusan SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_surat_keputusan SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_keputusan');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_surat_keputusan order by tahun DESC, nomor DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_surat_keputusan order by tahun DESC, nomor DESC")->result();
			$a['data2']		= $this->db->query("SELECT * FROM t_surat_keputusan order by tahun DESC, nomor DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_surat_keputusan";
		}
		
		$this->load->view('admin/aaa', $a);
	}	
	
	/*code Nota Dinas Keluar*/
	
	public function notadinas_keluar() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_notadinas_keluar")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/notadinas_keluar/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));
		$a['thn']				= date('Y');
		$a['nextagenda']		= $this->db->query("SELECT * FROM t_notadinas_keluar where tahun='$a[thn]' ")->num_rows()+1;

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$no_notadinas			= addslashes($this->input->post('no_notadinas'));
		$tgl_nodin              = addslashes($this->input->post('tgl_nodin'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$tgl_naik				= addslashes($this->input->post('tgl_naik'));
		$tgl_turun				= addslashes($this->input->post('tgl_turun'));
		$perihal				= addslashes($this->input->post('perihal'));
		$disposisi				= addslashes($this->input->post('disposisi'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/notadinas_keluar';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_notadinas_keluar WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/notadinas_keluar');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_notadinas_keluar WHERE perihal LIKE '%$cari%' or pejabat LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_notadinas_keluar";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_notadinas_keluar";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_notadinas_keluar WHERE id = '$idu'")->row();	
			$a['page']		= "f_notadinas_keluar";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_notadinas_keluar VALUES (NULL, '$kode', '$no_notadinas','$tgl_nodin', '$tahun', '$pejabat', '$tgl_naik', '$tgl_turun', '$perihal', '$disposisi', '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_notadinas_keluar VALUES (NULL, '$kode', '$no_notadinas','$tgl_nodin', '$tahun', '$pejabat', '$tgl_naik', '$tgl_turun', '$perihal', '$disposisi', '$unit_pengolah', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/notadinas_keluar');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_notadinas_keluar SET kode = '$kode', no_notadinas = '$no_notadinas',tgl_nodin='$tgl_nodin', tahun = '$tahun', pejabat = '$pejabat', tgl_naik = '$tgl_naik', tgl_turun = '$tgl_turun', perihal = '$perihal', disposisi = '$disposisi', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_notadinas_keluar SET kode = '$kode', no_notadinas = '$no_notadinas',tgl_nodin='$tgl_nodin', tahun = '$tahun', pejabat = '$pejabat', tgl_naik = '$tgl_naik', tgl_turun = '$tgl_turun', perihal = '$perihal', disposisi = '$disposisi', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/notadinas_keluar');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_notadinas_keluar order by id DESC, no_notadinas DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_notadinas_keluar order by id DESC, no_notadinas DESC")->result();
			$a['data2']     = $this->db->query("SELECT * FROM t_notadinas_keluar where tahun=$a[thn] order by id DESC, no_notadinas DESC ")->result();
			$a['page']		= "l_notadinas_keluar";
		}
		
		$this->load->view('admin/aaa', $a);
	}	
	
	/*code Nota Dinas Masuk*/
	
	public function notadinas_masuk() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_notadinas_masuk")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/notadinas_masuk/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));
		$a['thn']				= date('Y');
		$a['nextagenda']		= $this->db->query("SELECT * FROM t_notadinas_masuk where tahun='$a[thn]' ")->num_rows()+1;
		 

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$no_nodin_masuk			= addslashes($this->input->post('no_nodin_masuk'));
		$tgl					= addslashes($this->input->post('tgl'));
		$tgl_agenda				= addslashes($this->input->post('tgl_agenda'));
		$perihal				= addslashes($this->input->post('perihal'));
		$disposisi				= addslashes($this->input->post('disposisi'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/notadinas_masuk';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_notadinas_masuk WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/notadinas_masuk');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_notadinas_masuk WHERE perihal LIKE '%$cari%' or pejabat LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_notadinas_masuk";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_notadinas_masuk";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_notadinas_masuk WHERE id = '$idu'")->row();	
			$a['page']		= "f_notadinas_masuk";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_notadinas_masuk VALUES (NULL, '$kode', '$no_agenda', '$tahun', '$pejabat', '$no_nodin_masuk', '$tgl', '$tgl_agenda', '$perihal', '$disposisi', '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_notadinas_masuk VALUES (NULL, '$kode', '$no_agenda', '$tahun', '$pejabat', '$no_nodin_masuk', '$tgl', '$tgl_agenda', '$perihal', '$disposisi', '$unit_pengolah', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/notadinas_masuk');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_notadinas_masuk SET kode = '$kode', no_agenda = '$no_agenda', tahun = '$tahun', pejabat = '$pejabat', no_nodin_masuk = '$no_nodin_masuk', tgl = '$tgl', tgl_agenda = '$tgl_agenda', perihal = '$perihal', disposisi = '$disposisi', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_notadinas_masuk SET kode = '$kode', no_agenda = '$no_agenda', tahun = '$tahun', pejabat = '$pejabat', no_nodin_masuk = '$no_nodin_masuk', tgl = '$tgl', tgl_agenda = '$tgl_agenda', perihal = '$perihal', disposisi = '$disposisi', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/notadinas_masuk');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_notadinas_masuk order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_notadinas_masuk order by tahun DESC, no_agenda DESC")->result();
			$a['data2']		= $this->db->query("SELECT * FROM t_notadinas_masuk where tahun='$a[thn]' order by tahun DESC, no_agenda DESC ")->result();
			$a['page']		= "l_notadinas_masuk";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	
	/*s_konsul*/
	public function surat_konsul() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_konsul")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_konsul/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$nomor					= addslashes($this->input->post('nomor'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$tentang				= addslashes($this->input->post('tentang'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$ket					= addslashes($this->input->post('ket'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_konsul';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_konsul WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Konsul has been deleted </div>");
			redirect('admin/surat_konsul');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_konsul WHERE tentang LIKE '%$cari%' or keterangan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_konsul";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_konsul";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_konsul WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_konsul";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_konsul VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_konsul VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_konsul');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_konsul SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_konsul SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Konsul has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_konsul');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_konsul order by tahun DESC, nomor DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_konsul order by tahun DESC, nomor DESC")->result();
			$a['page']		= "l_surat_konsul";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	
	/*surat_ibel*/
	public function surat_ibel() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_ibel")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_ibel/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$nomor					= addslashes($this->input->post('nomor'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$tentang				= addslashes($this->input->post('tentang'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$ket					= addslashes($this->input->post('ket'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_ibel';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_ibel WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Ibel has been deleted </div>");
			redirect('admin/surat_ibel');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_ibel WHERE tentang LIKE '%$cari%' or keterangan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_ibel";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_ibel";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_ibel WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_ibel";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_ibel VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_ibel VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_ibel');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_ibel SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_ibel SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Ibel has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_ibel');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_ibel order by tahun DESC, nomor DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_ibel order by tahun DESC, nomor DESC")->result();
			$a['page']		= "l_surat_ibel";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	
	/*surat_SKMI*/
	public function surat_skmi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_skmi")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_skmi/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$nomor					= addslashes($this->input->post('nomor'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$tentang				= addslashes($this->input->post('tentang'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$ket					= addslashes($this->input->post('ket'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_skmi';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_skmi WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data SKMI has been deleted </div>");
			redirect('admin/surat_skmi');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_skmi WHERE tentang LIKE '%$cari%' or keterangan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_skmi";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_skmi";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_skmi WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_skmi";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_skmi VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_skmi VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data SKMI has been added</div>");
			redirect('admin/surat_skmi');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_skmi SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_skmi SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data SKMI has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_skmi');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_skmi order by tahun DESC, nomor DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_skmi order by tahun DESC, nomor DESC")->result();
			$a['page']		= "l_surat_skmi";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	
	/*surat_SKB*/
	
	public function surat_skb() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_skb")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_skb/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$nomor					= addslashes($this->input->post('nomor'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$tentang				= addslashes($this->input->post('tentang'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$ket					= addslashes($this->input->post('ket'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_skb';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_skb WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data SKB has been deleted </div>");
			redirect('admin/surat_skb');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_skb WHERE tentang LIKE '%$cari%' or keterangan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_skb";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_skb";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_skb WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_skb";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_skb VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_skb VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data SKB has been added</div>");
			redirect('admin/surat_skb');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_skb SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_skb SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data SKB has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_skb');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_skb order by tahun DESC, nomor DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_skb order by tahun DESC, nomor DESC")->result();
			$a['page']		= "l_surat_skb";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	
	/*surat_Tubel*/
	
public function surat_tubel() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_tubel")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_tubel/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$nomor					= addslashes($this->input->post('nomor'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$tentang				= addslashes($this->input->post('tentang'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$ket					= addslashes($this->input->post('ket'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_tubel';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_tubel WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Tubel has been deleted </div>");
			redirect('admin/surat_skb');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_tubel WHERE tentang LIKE '%$cari%' or keterangan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_tubel";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_tubel";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_tubel WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_tubel";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_tubel VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_tubel VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Tubel has been added</div>");
			redirect('admin/surat_tubel');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_tubel SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_tubel SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Tubel has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_tubel');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_tubel order by tahun DESC, nomor DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_tubel order by tahun DESC, nomor DESC")->result();
			$a['page']		= "l_surat_tubel";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	//surat_ipg//
	public function surat_ipg() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_ipg")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_ipg/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$nomor					= addslashes($this->input->post('nomor'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$tentang				= addslashes($this->input->post('tentang'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$ket					= addslashes($this->input->post('ket'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_ipg';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_ipg WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data ipg has been deleted </div>");
			redirect('admin/surat_skb');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_ipg WHERE tentang LIKE '%$cari%' or keterangan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_ipg";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_ipg";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_ipg WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_ipg";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_ipg VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_ipg VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data ipg has been added</div>");
			redirect('admin/surat_ipg');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_ipg SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_ipg SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data ipg has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_ipg');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_ipg order by tahun DESC, nomor DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_ipg order by tahun DESC, nomor DESC")->result();
			$a['page']		= "l_surat_ipg";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	//**surat_masuk konsul**//
public function suratm_konsul()
{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_suratm_konsul")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/suratm_konsul/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));
        $a['thn']=date('Y');
		$a['nextagenda']		= $this->db->query("SELECT * FROM t_suratm_konsul where tahun='$a[thn]' ")->num_rows()+1;
		//upload config 
		$config['upload_path'] 		= './upload/suratm_konsul';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_suratm_konsul WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/suratm_konsul');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_konsul WHERE isi_ringkas LIKE '%$cari%' or dari LIKE '%$cari%' or tahun LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_suratm_konsul";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_suratm_konsul";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_suratm_konsul WHERE id = '$idu'")->row();	
			$a['page']		= "f_suratm_konsul";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_suratm_konsul VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_suratm_konsul VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/suratm_konsul');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_suratm_konsul SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_suratm_konsul SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/suratm_konsul');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_suratm_konsul order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_konsul order by tahun DESC, no_agenda DESC")->result();
			$a['data2']		= $this->db->query("SELECT * FROM t_suratm_konsul where tahun=$a[thn] ORDER BY no_agenda DESC ")->result();
			$a['page']		= "l_suratm_konsul";
		}
		
		$this->load->view('admin/aaa', $a);
	}
//**surat_masuk ibel**//
public function suratm_ibel()
{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_suratm_ibel")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/suratm_ibel/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/suratm_ibel';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_suratm_ibel WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/suratm_ibel');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_ibel WHERE isi_ringkas LIKE '%$cari%' or dari LIKE '%$cari%' or tahun LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_suratm_ibel";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_suratm_ibel";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_suratm_ibel WHERE id = '$idu'")->row();	
			$a['page']		= "f_suratm_ibel";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_suratm_ibel VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_suratm_ibel VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/suratm_ibel');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_suratm_ibel SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_suratm_ibel SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/suratm_ibel');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_suratm_ibel order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_ibel order by tahun DESC, no_agenda DESC")->result();
			$a['page']		= "l_suratm_ibel";
		}
		
		$this->load->view('admin/aaa', $a);
	}

//skmi//
public function suratm_skmi()
{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_suratm_skmi")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/suratm_skmi/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/suratm_skmi';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_suratm_skmi WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/suratm_skmi');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_skmi WHERE isi_ringkas LIKE '%$cari%' or dari LIKE '%$cari%' or tahun LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_suratm_skmi";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_suratm_skmi";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_suratm_skmi WHERE id = '$idu'")->row();	
			$a['page']		= "f_suratm_skmi";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_suratm_skmi VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_suratm_skmi VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/suratm_skmi');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_suratm_skmi SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_suratm_skmi SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/suratm_skmi');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_suratm_skmi order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_skmi order by tahun DESC, no_agenda DESC")->result();
			$a['page']		= "l_suratm_skmi";
		}
		
		$this->load->view('admin/aaa', $a);
	}
//surat masuk SKB//
public function suratm_skb()
{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_suratm_skb")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/suratm_skb/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/suratm_skb';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_suratm_skb WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/suratm_skb');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_skb WHERE isi_ringkas LIKE '%$cari%' or dari LIKE '%$cari%' or tahun LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_suratm_skb";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_suratm_skb";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_suratm_skb WHERE id = '$idu'")->row();	
			$a['page']		= "f_suratm_skb";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_suratm_skb VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_suratm_skb VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/suratm_skb');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_suratm_skb SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_suratm_skb SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/suratm_skb');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_suratm_skb order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_skb order by tahun DESC, no_agenda DESC")->result();
			$a['page']		= "l_suratm_skb";
		}
		
		$this->load->view('admin/aaa', $a);
	}
//**surat masuk Tubel//
public function suratm_tubel()
{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_suratm_tubel")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/suratm_tubel/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/suratm_tubel';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_suratm_tubel WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/suratm_tubel');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_tubel WHERE isi_ringkas LIKE '%$cari%' or dari LIKE '%$cari%' or tahun LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_suratm_tubel";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_suratm_tubel";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_suratm_tubel WHERE id = '$idu'")->row();	
			$a['page']		= "f_suratm_tubel";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_suratm_tubel VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_suratm_tubel VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/suratm_tubel');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_suratm_tubel SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_suratm_tubel SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/suratm_tubel');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_suratm_tubel order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_tubel order by tahun DESC, no_agenda DESC")->result();
			$a['page']		= "l_suratm_tubel";
		}
		
		$this->load->view('admin/aaa', $a);
	}	
	//**surat masuk ipg//
public function suratm_ipg()
{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_suratm_ipg")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/suratm_ipg/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/suratm_ipg';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_suratm_ipg WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/suratm_ipg');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_ipg WHERE isi_ringkas LIKE '%$cari%' or dari LIKE '%$cari%' or tahun LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_suratm_ipg";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_suratm_ipg";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_suratm_ipg WHERE id = '$idu'")->row();	
			$a['page']		= "f_suratm_ipg";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_suratm_ipg VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_suratm_ipg VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/suratm_ipg');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_suratm_ipg SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_suratm_ipg SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/suratm_ipg');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_suratm_ipg order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_ipg order by tahun DESC, no_agenda DESC")->result();
			$a['page']		= "l_suratm_ipg";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	//*SK CPNS*//
public function surat_skcpns() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_surat_skcpns")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_skcpns/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));
		$a['thn']=date('Y');
		$a['nextagenda']		= $this->db->query("SELECT * FROM t_surat_skcpns where tahun='$a[thn]' ")->num_rows()+1;

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$nomor					= addslashes($this->input->post('nomor'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$tentang				= addslashes($this->input->post('tentang'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$ket					= addslashes($this->input->post('ket'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_skcpns';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_surat_skcpns WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_skcpns');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_surat_skcpns WHERE tentang LIKE '%$cari%' or keterangan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_skcpns";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_skcpns";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_surat_skcpns WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_skcpns";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_surat_skcpns VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_surat_skcpns VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_skcpns');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_surat_skcpns SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_surat_skcpns SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_skcpns');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_surat_skcpns order by tahun DESC, nomor DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_surat_skcpns order by tahun DESC, nomor DESC")->result();
			$a['page']		= "l_surat_skcpns";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	
		
	//*SK PNS*//
public function surat_skpns() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_surat_skpns")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_skpns/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$nomor					= addslashes($this->input->post('nomor'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$tentang				= addslashes($this->input->post('tentang'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$ket					= addslashes($this->input->post('ket'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_skpns';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_surat_skpns WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_skpns');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_surat_skpns WHERE tentang LIKE '%$cari%' or keterangan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_skpns";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_skpns";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_surat_skpns WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_skpns";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_surat_skpns VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_surat_skpns VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_skpns');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_surat_skpns SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_surat_skpns SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_skpns');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_surat_skpns order by tahun DESC, nomor DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_surat_skpns order by tahun DESC, nomor DESC")->result();
			$a['page']		= "l_surat_skpns";
		}
		
		$this->load->view('admin/aaa', $a);
	}	
			
	//*SK Fungsional//
	public function surat_fungsional() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_surat_fungsional")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_fungsional/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$nomor					= addslashes($this->input->post('nomor'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$tentang				= addslashes($this->input->post('tentang'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$ket					= addslashes($this->input->post('ket'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_fungsional';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_surat_fungsional WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_fungsional');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_surat_fungsional WHERE tentang LIKE '%$cari%' or keterangan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_fungsional";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_fungsional";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_surat_fungsional WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_fungsional";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_surat_fungsional VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_surat_fungsional VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_fungsional');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_surat_fungsional SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_surat_fungsional SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_fungsional');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_surat_fungsional order by tahun DESC, nomor DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_surat_fungsional order by tahun DESC, nomor DESC")->result();
			$a['page']		= "l_surat_fungsional";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	//* Aktif TB//
	public function surat_aktif_tb() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_surat_aktif_tb")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_aktif_tb/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$nomor					= addslashes($this->input->post('nomor'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$tentang				= addslashes($this->input->post('tentang'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$ket					= addslashes($this->input->post('ket'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_aktif_tb';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_surat_aktif_tb WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/surat_aktif_tb');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_surat_aktif_tb WHERE tentang LIKE '%$cari%' or keterangan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_aktif_tb";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_aktif_tb";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_surat_aktif_tb WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_aktif_tb";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_surat_aktif_tb VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_surat_aktif_tb VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/surat_aktif_tb');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_surat_aktif_tb SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_surat_aktif_tb SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_aktif_tb');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_surat_aktif_tb order by tahun DESC, nomor DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_surat_aktif_tb order by tahun DESC, nomor DESC")->result();
			$a['page']		= "l_surat_aktif_tb";
		}
		
		$this->load->view('admin/aaa', $a);
	}	
	
	//surat_kp//subag_PKPP
	public function surat_kp() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_kenaikan_pangkat")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/surat_kp/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$nomor					= addslashes($this->input->post('nomor'));
		$tahun					= addslashes($this->input->post('tahun'));
		$pejabat				= addslashes($this->input->post('pejabat'));
		$tentang				= addslashes($this->input->post('tentang'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$ket					= addslashes($this->input->post('ket'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_kp';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_kenaikan_pangkat WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data SK KP has been deleted </div>");
			redirect('admin/surat_skb');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_kenaikan_pangkat WHERE tentang LIKE '%$cari%' or keterangan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_surat_kp";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_surat_kp";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_kenaikan_pangkat WHERE id = '$idu'")->row();	
			$a['page']		= "f_surat_kp";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_kenaikan_pangkat VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_kenaikan_pangkat VALUES (NULL, '$kode', '$nomor', '$tahun', '$pejabat', '$tentang', '$tgl_surat', '$ket', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data SK KP has been added</div>");
			redirect('admin/surat_kp');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_kenaikan_pangkat SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_kenaikan_pangkat SET kode = '$kode', nomor = '$nomor', tahun = '$tahun', pejabat = '$pejabat', tentang = '$tentang', tgl_surat = '$tgl_surat', keterangan = '$ket', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data SK KP has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/surat_kp');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_kenaikan_pangkat order by tahun DESC, nomor DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_kenaikan_pangkat order by tahun DESC, nomor DESC")->result();
			$a['page']		= "l_surat_kp";
		}
		$this->load->view('admin/aaa', $a);
		}
		//*surat cerai//
		public function suratm_cerai()
{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_suratm_cerai")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/suratm_cerai/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));
		

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/suratm_cerai';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_suratm_cerai WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/suratm_cerai');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_cerai WHERE isi_ringkas LIKE '%$cari%' or dari LIKE '%$cari%' or tahun LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_suratm_cerai";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_suratm_cerai";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_suratm_cerai WHERE id = '$idu'")->row();	
			$a['page']		= "f_suratm_cerai";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_suratm_cerai VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_suratm_cerai VALUES (NULL, '$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/suratm_cerai');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_suratm_cerai SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_suratm_cerai SET kode = '$kode', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/suratm_cerai');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_suratm_cerai order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_cerai order by tahun DESC, no_agenda DESC")->result();
			$a['page']		= "l_suratm_cerai";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	//*surat kartu2//
		public function suratm_kartu()
{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_suratm_kartu")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/suratm_kartu/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));
		$a['thn']=date('Y');
		$a['nextagenda']		= $this->db->query("SELECT * FROM t_suratm_kartu where tahun='$a[thn]' ")->num_rows()+1;

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$jen_kartu              = addslashes($this->input->post('jen_kartu'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/suratm_kartu';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_suratm_kartu WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/suratm_kartu');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_kartu WHERE isi_ringkas LIKE '%$cari%' or dari LIKE '%$cari%' or tahun LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_suratm_kartu";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_suratm_kartu";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_suratm_kartu WHERE id = '$idu'")->row();	
			$a['page']		= "f_suratm_kartu";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_suratm_kartu VALUES (NULL,'$jen_kartu','$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_suratm_kartu VALUES (NULL,'$jen_kartu','$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/suratm_kartu');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_suratm_kartu SET kode = '$kode',jen_kartu='$jen_kartu', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_suratm_kartu SET kode = '$kode',jen_kartu='$jen_kartu', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/suratm_kartu');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_suratm_kartu order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_kartu order by tahun DESC, no_agenda DESC")->result();
			$a['page']		= "l_suratm_kartu";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	
	//*surat cuti//
		public function suratm_cuti()
{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_suratm_cuti")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/suratm_cuti/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));
		$a['thn']=date('Y');
		$a['nextagenda']		= $this->db->query("SELECT * FROM t_suratm_cuti where tahun='$a[thn]' ")->num_rows()+1;

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$jen_cuti               = addslashes($this->input->post('jen_cuti'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/suratm_cuti';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_suratm_cuti WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/suratm_cuti');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_cuti WHERE isi_ringkas LIKE '%$cari%' or dari LIKE '%$cari%' or tahun LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_suratm_cuti";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_suratm_cuti";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_suratm_cuti WHERE id = '$idu'")->row();	
			$a['page']		= "f_suratm_cuti";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_suratm_cuti VALUES (NULL,'$jen_cuti','$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_suratm_cuti VALUES (NULL,'$jen_cuti','$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/suratm_cuti');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_suratm_cuti SET kode = '$kode',jen_cuti='$jen_cuti', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_suratm_cuti SET kode = '$kode',jen_cuti='$jen_cuti', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/suratm_cuti');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_suratm_cuti order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_cuti order by tahun DESC, no_agenda DESC")->result();
			$a['page']		= "l_suratm_cuti";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	
//*surat pensiun//
		public function suratm_pensiun()
{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_suratm_pensiun")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/suratm_pensiun/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));
		$a['thn']=date('Y');
		$a['nextagenda']		= $this->db->query("SELECT * FROM t_suratm_pensiun where tahun='$a[thn]' ")->num_rows()+1;

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$jen_pens				= addslashes($this->input->post('jen_pens'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$indek_berkas			= addslashes($this->input->post('indek_berkas'));
		$dari					= addslashes($this->input->post('dari'));
		$no_surat				= addslashes($this->input->post('no_surat'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$uraian					= addslashes($this->input->post('uraian'));
		$ket					= addslashes($this->input->post('ket'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/suratm_pensiun';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_suratm_pensiun WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/suratm_pensiun');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_pensiun WHERE isi_ringkas LIKE '%$cari%' or dari LIKE '%$cari%' or tahun LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_suratm_pensiun";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_suratm_pensiun";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_suratm_pensiun WHERE id = '$idu'")->row();	
			$a['page']		= "f_suratm_pensiun";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_suratm_pensiun VALUES (NULL,'$jen_pens','$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_suratm_pensiun VALUES (NULL,'$jen_pens','$kode', '$tahun', '$no_agenda', '$indek_berkas', '$uraian', '$dari', '$no_surat', '$tgl_surat', NOW(), '$ket', '$unit_pengolah', '$distribusi', '', '".$this->session->userdata('admin_id')."')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('admin/suratm_pensiun');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
							
				$this->db->query("UPDATE t_suratm_pensiun SET kode = '$kode',jen_pensiun='$jen_pens', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_suratm_pensiun SET kode = '$kode',jen_pensiun='$jen_pens', tahun = '$tahun', no_agenda = '$no_agenda', indek_berkas = '$indek_berkas', isi_ringkas = '$uraian', dari = '$dari', no_surat = '$no_surat', tgl_surat = '$tgl_surat', keterangan = '$ket', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
			redirect('admin/suratm_pensiun');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_suratm_pensiun order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_suratm_pensiun order by tahun DESC, no_agenda DESC")->result();
			$a['page']		= "l_suratm_pensiun";
		}
		
		$this->load->view('admin/aaa', $a);
	}	
	
		//*SPPD*/
		public function sppd() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_sppd")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/sppd/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));
		//-------
		$a['thn']=date('Y');
		$a['nextagenda']		= $this->db->query("SELECT * FROM t_sppd where tahun='$a[thn]' ")->num_rows()+1;

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$kode					= addslashes($this->input->post('kode'));
		$no_agenda				= addslashes($this->input->post('no_agenda'));
		$tahun					= addslashes($this->input->post('tahun'));
		$tgl_surat				= addslashes($this->input->post('tgl_surat'));
		$tujuan					= addslashes($this->input->post('tujuan'));
		$pegawai                = addslashes($this->input->post('pegawai'));
		$isi_ringkas			= addslashes($this->input->post('isi_ringkas'));
		$tgl_tugas              = addslashes($this->input->post('tgl_tugas'));
		$tgl_tugas_end          = addslashes($this->input->post('tgl_tugas_end'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$distribusi				= addslashes($this->input->post('distribusi'));
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_sppd';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_sppd WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/sppd');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_sppd WHERE isi_ringkas LIKE '%$cari%' or tujuan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_sppd";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_sppd";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_sppd WHERE id = '$idu'")->row();	
			$a['page']		= "f_sppd";
		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO t_sppd VALUES (NULL, '$kode','$no_agenda','$tahun','$tgl_surat','$tujuan','$pegawai','$isi_ringkas','$tgl_tugas','$tgl_tugas_end',NOW(), '$unit_pengolah', '$distribusi', '".$up_data['file_name']."', '".$this->session->userdata('admin_id')."')");
			} else {
				$this->db->query("INSERT INTO t_sppd VALUES (NULL, '$kode','$no_agenda','$tahun','$tgl_surat','$tujuan','$pegawai','$isi_ringkas','$tgl_tugas','$tgl_tugas_end',NOW(), '$unit_pengolah', '$distribusi','', '".$this->session->userdata('admin_id')."')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/sppd');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE t_sppd SET kode = '$kode', no_agenda = '$no_agenda', tahun = '$tahun', tgl_surat = '$tgl_surat',tujuan = '$tujuan', pegawai= '$pegawai',isi_ringkas = '$isi_ringkas', tgl_tugas='$tgl_tugas', unit_pengolah = '$unit_pengolah',  distribusi = '$distribusi', file = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_sppd SET kode = '$kode', no_agenda = '$no_agenda', tahun = '$tahun', tgl_surat = '$tgl_surat',tujuan = '$tujuan', pegawai= '$pegawai',isi_ringkas = '$isi_ringkas',tgl_tugas='$tgl_tugas', tgl_tugas_end='$tgl_tugas_end', unit_pengolah = '$unit_pengolah', distribusi = '$distribusi' WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/sppd');
		} else {
			//$a['data']		= $this->db->query("SELECT * FROM t_sppd order by tahun DESC, no_agenda DESC LIMIT $awal, $akhir ")->result();
			$a['data']		= $this->db->query("SELECT * FROM t_sppd order by tahun DESC, no_agenda DESC")->result();
			$a['data2']		= $this->db->query("SELECT * FROM t_sppd where tahun=$a[thn] order by no_agenda DESC ")->result();
			$a['page']		= "l_sppd";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	//*kegiatan*/
		public function kegiatan() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_kegiatan")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/kegiatan/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));
		//-------
		$a['thn']=date('Y');
		$a['nextagenda']		= $this->db->query("SELECT * FROM t_kegiatan where tahun='$a[thn]' ")->num_rows()+1;

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$disp					= addslashes($this->input->post('disp'));
		$file_surat				= addslashes($this->input->post('file_surat'));
		$kode					= addslashes($this->input->post('kode'));
		$no_keg					= addslashes($this->input->post('no_keg'));
		$tempat					= addslashes($this->input->post('tempat'));
		$pegawai                = addslashes($this->input->post('pegawai'));
		$isi_keg				= addslashes($this->input->post('isi_keg'));
		$tgl_kegiatan           = date("Y-m-d", strtotime($this->input->post('tgl_kegiatan')));
		$tgl_kegiatan_end       = date("Y-m-d", strtotime($this->input->post('tgl_kegiatan_end')));
		$jam 					= addslashes($this->input->post('jam'));
		$jam_end 				= addslashes($this->input->post('jam_end'));
		$unit_pengolah			= addslashes($this->input->post('unit_pengolah'));
		$cari					= addslashes($this->input->post('q'));
		$tahun					= substr($tgl_kegiatan ,0,4);
		//upload config 
		$config['upload_path'] 		= './upload/kegiatan';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '50000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_kegiatan WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/kegiatan');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_kegiatan WHERE isi_ringkas LIKE '%$cari%' or tujuan LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_kegiatan";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_kegiatan";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_kegiatan WHERE id = '$idu'")->row();	
			$a['page']		= "f_kegiatan";

		} else if ($mau_ke == "act_add") {	
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				$this->db->query("INSERT INTO t_kegiatan VALUES (NULL, '$kode','$no_keg','$tahun','$tempat','$pegawai',$isi_keg',','$tgl_kegiatan','$tgl_kegiatan_end','$jam','$jam_end',NOW(),'$disp','$unit_pengolah','".$this->session->userdata('admin_id')."',file_ = '".$up_data['file_name']."')");
			} else {
				$this->db->query("INSERT INTO t_kegiatan VALUES (NULL, '$kode','$no_keg','$tahun','$tempat','$pegawai','$isi_keg','$tgl_kegiatan','$tgl_kegiatan_end','$jam','$jam_end',NOW(),'$disp', '$unit_pengolah','".$this->session->userdata('admin_id')."','')");
			}		
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data telah ditambah</div>");
			redirect('admin/kegiatan');
		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				$this->db->query("UPDATE t_kegiatan SET kode = '$kode', no_keg= '$no_keg', tahun = '$tahun', tempat = '$tempat',pegawai= '$pegawai',isi_keg= '$isi_keg',  tgl_keg='$tgl_kegiatan', tgl_keg_end='$tgl_kegiatan_end',jam='$jam',jam_end='$jam_end',disp='$disp',unit_pengolah = '$unit_pengolah',file_ = '".$up_data['file_name']."' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_kegiatan SET kode = '$kode', no_keg = '$no_keg', tahun = '$tahun', tempat= '$tempat',pegawai= '$pegawai', isi_keg= '$isi_keg',tgl_keg='$tgl_kegiatan', tgl_keg_end='$tgl_kegiatan_end',jam='$jam',jam_end='$jam_end',disp='$disp', unit_pengolah = '$unit_pengolah'  WHERE id = '$idp'");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated ".$this->upload->display_errors()."</div>");			
			redirect('admin/kegiatan');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_kegiatan order by tgl_keg DESC, no_keg DESC LIMIT $awal, $akhir ")->result();
			$a['data2']		= $this->db->query("SELECT a.* ,date_format(a.tgl_keg,'%d-%m-%Y') as tgl_keg_, date_format(a.tgl_keg_end,'%d-%m-%Y') as tgl_keg_end_ FROM t_kegiatan a where tahun='$a[thn]' order by tgl_keg DESC ")->result();
			$a['page']		= "l_kegiatan";
		}
		
		$this->load->view('admin/aaa', $a);
	}
		
		
		
	/*back up database*/
	public function backup() {
     $this->load->dbutil();
     $prefs = array(
         'tables'      => array('ref_klasifikasi', 'tr_instansi', 't_admin2', 't_disposisi', 't_instansi', 't_notadinas_keluar', 't_notadinas_masuk', 't_pejabat', 't_surat_keluar', 't_surat_keputusan', 't_surat_masuk', 't_unit_pengolah'),  
         'ignore'      => array(),          
         'format'      => 'txt',           
         'filename'    => 'mybackup.sql',    
         'add_drop'    => TRUE,              
         'add_insert'  => TRUE,              
         'newline'     => "\n"              
     );
     // Backup your entire database and assign it to a variable
     $backup =& $this->dbutil->backup($prefs);
 
     // Load the file helper and write the file to your server
     $this->load->helper('file');
     $file_name = 'diklat.sql';
     write_file('/'.$file_name, $backup);
 
     // Load the download helper and send the file to your desktop
     $this->load->helper('download');
     force_download($file_name, $backup);
	}
	
	public function manage_admin() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_admin2")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/manage_admin/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$username				= addslashes($this->input->post('username'));
		$password				= md5(addslashes($this->input->post('password')));
		$nama					= addslashes($this->input->post('nama'));
		$nip					= addslashes($this->input->post('nip'));
		$level					= addslashes($this->input->post('level'));
		
		$cari					= addslashes($this->input->post('q'));

		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_admin2 WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('admin/manage_admin');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_admin2 WHERE nama LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_manage_admin";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_manage_admin";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_admin2 WHERE id = '$idu'")->row();	
			$a['page']		= "f_manage_admin";
		} else if ($mau_ke == "act_add") {	
			$this->db->query("INSERT INTO t_admin2 VALUES (NULL, '$username', '$password', '$nama', '$nip', '$level')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('admin/manage_admin');
		} else if ($mau_ke == "act_edt") {
			if ($password = md5("-")) {
				$this->db->query("UPDATE t_admin2 SET username = '$username', nama = '$nama', nip = '$nip', level = '$level' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_admin2 SET username = '$username', password = '$password', nama = '$nama', nip = '$nip', level = '$level' WHERE id = '$idp'");
			}
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated </div>");			
			redirect('admin/manage_admin');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_admin2 LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_manage_admin";
		}
		
		$this->load->view('admin/aaa', $a);
	}

	public function get_klasifikasi() {
		$kode 				= $this->input->post('kode',TRUE);
		
		$data 				=  $this->db->query("SELECT id, kode, nama FROM ref_klasifikasi WHERE kode LIKE '%$kode%' ORDER BY id ASC")->result();
		
		$klasifikasi 		=  array();
        foreach ($data as $d) {
			$json_array				= array();
            $json_array['value']	= $d->kode;
			$json_array['label']	= $d->kode." - ".$d->nama;
			$klasifikasi[] 			= $json_array;
		}
		
		echo json_encode($klasifikasi);
	}
	
	public function get_instansi_lain() {
		$kode 				= $this->input->post('kode',TRUE);
		
		$data 				=  $this->db->query("SELECT nama_instansi FROM t_instansi WHERE nama_instansi LIKE '%$kode%' GROUP BY id ASC")->result();
		
		$klasifikasi 		=  array();
        foreach ($data as $d) {
			$json_array				= array();
            $json_array['value']	= $d->nama_instansi;
			$json_array['label']	= $d->nama_instansi;
			$klasifikasi[] 			= $json_array;
			//$klasifikasi[] 	= $d->dari;
		}
		
		echo json_encode($klasifikasi);
	}
	
	public function get_pejabat_sk() {
		$kode 				= $this->input->post('kode',TRUE);
		
		$data 				=  $this->db->query("SELECT pejabat FROM t_pejabat WHERE pejabat LIKE '%$kode%' GROUP BY id")->result();
		
		$klasifikasi 		=  array();
        foreach ($data as $d) {
			$json_array				= array();
            $json_array['value']	= $d->pejabat;
			$json_array['label']	= $d->pejabat;
			$klasifikasi[] 			= $json_array;
			//$klasifikasi[] 	= $d->pejabat;
		}
		
		echo json_encode($klasifikasi);
	}
	
	public function get_pejabat_lain() {
		$kode 				= $this->input->post('kode',TRUE);
		
		$data 				=  $this->db->query("SELECT pejabat FROM t_pejabat WHERE pejabat LIKE '%$kode%' GROUP BY id")->result();
		
		$klasifikasi 		=  array();
        foreach ($data as $d) {
			$json_array				= array();
            $json_array['value']	= $d->pejabat;
			$json_array['label']	= $d->pejabat;
			$klasifikasi[] 			= $json_array;
			//$klasifikasi[] 	= $d->pejabat;
		}
		
		echo json_encode($klasifikasi);
	}
	
	public function get_unit_pengolah() {
		$kode 				= $this->input->post('kode',TRUE);
		
		$data 				=  $this->db->query("SELECT unit_pengolah FROM t_unit_pengolah WHERE unit_pengolah LIKE '%$kode%' GROUP BY id")->result();
		
		$klasifikasi 		=  array();
        foreach ($data as $d) {
			$json_array				= array();
            $json_array['value']	= $d->unit_pengolah;
			$json_array['label']	= $d->unit_pengolah;
			$klasifikasi[] 			= $json_array;
			//$klasifikasi[] 	= $d->unit_pengolah;
		}
		
		echo json_encode($klasifikasi);
	}
	
	public function disposisi_cetak() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_surat_masuk WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_disposisi WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_disposisi', $a);
	} 
	public function disposisi_cetaknodin() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_notadinas_masuk WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_notadinas_masuk WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_disposisi', $a);
	}
	public function disposisi_cetakkonsul() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_suratm_konsul WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_disposisi_konsul WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_disposisi', $a);
	}
	public function disposisi_cetakibel() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_suratm_ibel WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_disposisi_ibel WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_disposisi', $a);
	}
	public function disposisi_cetakipg() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_suratm_ipg WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_disposisi_ipg WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_disposisiipg', $a);
	}
	public function disposisi_cetakskmi() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_suratm_skmi WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_disposisi_skmi WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_disposisiskmi', $a);
	}
	public function disposisi_cetakskb() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_suratm_skb WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_disposisi_skb WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_disposisiskb', $a);
	}	
	public function disposisi_cetaktubel() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_suratm_tubel WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_disposisi_tubel WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_disposisitubel', $a);	
	}
	public function disposisi_cetakpensiun() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_suratm_pensiun WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_disposisi_pensiun WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_disposisipensiun', $a);	
	}
	public function disposisi_cetakcerai() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_suratm_tubel WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_disposisi_tubel WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_disposisicerai', $a);	
	}
	public function disposisi_cetakcuti() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_suratm_cuti WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_disposisi_cuti WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_disposisicuti', $a);	
	}
	public function disposisi_cetakkartu() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_suratm_kartu WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_disposisi_kartu WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_disposisikartu', $a);	
	}
	public function pengantar_cetak() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_surat_keluar WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_pengantar WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_pengantar', $a);
	}
	public function pengantar_nodin_cetak() {
		$idu = $this->uri->segment(3);
		$a['datpil1']	= $this->db->query("SELECT * FROM t_notadinas_keluar WHERE id = '$idu'")->row();	
		$a['datpil2']	= $this->db->query("SELECT * FROM t_notadinas_keluar WHERE id = '$idu'")->result();	
		$this->load->view('admin/f_pengantar_nodin', $a);
	}
	public function passwod() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("admin/login");
		}
		
		$ke				= $this->uri->segment(3);
		$id_user		= $this->session->userdata('admin_id');
		
		//var post
		$p1				= md5($this->input->post('p1'));
		$p2				= md5($this->input->post('p2'));
		$p3				= md5($this->input->post('p3'));
		
		if ($ke == "simpan") {
			$cek_password_lama	= $this->db->query("SELECT password FROM t_admin2 WHERE id = $id_user")->row();
			//echo 
			
			if ($cek_password_lama->password != $p1) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Lama tidak sama'.$this->db->last_query().'-'.$cek_password_lama->p.'-'.$p1.'</div>');
				redirect('admin/passwod');
			} else if ($p2 != $p3) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Baru 1 dan 2 tidak cocok</div>');
				redirect('admin/passwod');
			} else {
				$this->db->query("UPDATE t_admin2 SET password = '$p3' WHERE id = '1'");
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-success">Password berhasil diperbaharui</div>');
				redirect('admin/passwod');
			}
		} else {
			$a['page']	= "f_passwod";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	
	//login
	public function login() {
		$total_row		= $this->db->query("SELECT * FROM t_kegiatan")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/kegiatan/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));
		//-------
		$a['thn']=date('Y');
		$a['nextagenda']		= $this->db->query("SELECT * FROM t_kegiatan where tahun='$a[thn]' ")->num_rows()+1;

		$mau_ke					= $this->uri->segment(3);
		$a['thn'] = date('Y');
		$a['jam'] = date('H');
		$next	="";
		if($a['jam'] >= '16'){
			$next	= ">";
		}else{
			$next	= ">=";
		}
		if($mau_ke	== "lengkap"){
		$a['data2']		= $this->db->query("SELECT a.* ,date_format(a.tgl_keg,'%d-%m-%Y') as tgl_keg_, date_format(a.tgl_keg_end,'%d-%m-%Y') as tgl_keg_end_ FROM t_kegiatan a order by tgl_keg DESC ")->result();
		$this->load->view('admin/l_kegiatan2',$a);
		}else{
		//$a['nextagenda']= $this->db->query("SELECT * FROM t_kegiatan where tahun='$a[thn]' ")->num_rows()+1;
		//$a['data']	= $this->db->query("SELECT * FROM t_kegiatan order by no_keg DESC ")->result();
		$a['data2']	= $this->db->query("SELECT a.* ,date_format(a.tgl_keg,'%Y-%m-%d') as tgl_keg_, date_format(a.tgl_keg_end,'%d-%m-%Y') as tgl_keg_end_ FROM t_kegiatan a where a.tgl_keg $next CURDATE() order by tgl_keg ASC ")->result();		
		$a['data1']	= $this->db->query("SELECT DISTINCT date_format(tgl_keg,'%Y-%m-%d') as tgl_keg1 FROM t_kegiatan where tgl_keg $next CURDATE() order by tgl_keg ASC")->result();
		$this->load->view('admin/login',$a);
		}
		
	}
	
	public function do_login() {
		$u 		= $this->security->xss_clean($this->input->post('u'));
		$ta 	= $this->security->xss_clean($this->input->post('ta'));
        $p 		= md5($this->security->xss_clean($this->input->post('p')));
         
		$q_cek	= $this->db->query("SELECT * FROM t_admin2 WHERE username = '".$u."' AND password = '".$p."'");
		$j_cek	= $q_cek->num_rows();
		$d_cek	= $q_cek->row();
		//echo $this->db->last_query();
		
        if($j_cek == 1) {
            $data = array(
                    'admin_id' => $d_cek->id,
                    'admin_user' => $d_cek->username,
                    'admin_nama' => $d_cek->nama,
                    'admin_ta' => $ta,
                    'admin_level' => $d_cek->level,
					'admin_valid' => true
                    );
            $this->session->set_userdata($data);
            redirect('admin');
        } else {	
			$this->session->set_flashdata("k", "<div id=\"alert\" class=\"alert alert-error\">username or password is not valid</div>");
			redirect('admin/login');
		}
	}
	
	public function logout(){
        $this->session->sess_destroy();
		redirect('admin/login');
    }
}