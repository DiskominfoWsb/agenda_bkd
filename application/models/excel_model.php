<?php
class excel_model extends CI_Model {

	function getAgendaSuratMasuk() {
	$this->db->select('*');
	$this->db->from('t_surat_masuk');
	$this->db->order_by('id','DESC');
	$getData = $this->db->get();
	if($getData->num_rows() > 0)
	return $getData->result_array();
	else
	return null;
	}
//query for get all data
	function toExcelAll() {
	$this->db->select('*');
	$this->db->from('t_surat_masuk');
	$this->db->order_by('id','desc');
	$getData = $this->db->get();
	if($getData->num_rows() > 0)
	return $getData->result_array();
	else
	return null;
	}
	}
?>