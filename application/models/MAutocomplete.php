<?php
class MAutocomplete extends Model{
 
    function __construct(){
        parent::Model();
    }
     
    function get_unit_pengolah($keyword){
        $this->db->select('*')->from('t_unit_pengolah');
        $this->db->like('unit_pengolah',$keyword,'after');
        $query = $this->db->get();   
         
        return $query->result();
    }
}
?>