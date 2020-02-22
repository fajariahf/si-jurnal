<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal_model extends CI_Model {

	public function jurnal()
	{
        $query = $this->db->get('jurnal');
        return $query->result(); 
	}
	
	public function view_jurnal()
	{
		$query = $this->db->get('view_jurnal');
        return $query->result();  
    }
    
	public function jurnal_save($data)
	{
		$this->db->insert('jurnal', $data);
    }

    public function penulis_save($data)
	{
		$this->db->insert('penulis_jurnal', $data);
    }

    public function getJurnal($where = ''){
		return $this->db->query("SELECT * FROM view_jurnal $where; ");
    }
    

    public function search($keyword)
	{
		$this->db->SELECT('*');
		$this->db->FROM('view_jurnal');
		$this->db->like('id_jurnal',$keyword);
		$this->db->or_like('id_user',$keyword);
		$this->db->or_like('nip_penulis',$keyword);
		$this->db->or_like('judul_jurnal',$keyword);
		$this->db->or_like('bukti_fisik',$keyword);
        $this->db->or_like('keterangan',$keyword);
		return $this->db->get()->result();
	}

    public function jurnal_delete($id_jurnal)
	{
		$this->db->where('id_jurnal',$id_jurnal);
		$this->db->delete('jurnal');
	}

    public function updatedata($tabel, $data, $where)
	{
		return $this->db->update($tabel, $data, $where);	
	}
    
    // public function getIdJurnal()
    // {
	// 	$this->db->where('id_jurnal', $id_jurnal);
    //     $query = $this->db->get('jurnal');
    //     return $query->result(); 
	// }

    function get_Penulis()
    {
        $this->db->SELECT('jurnal.id_jurnal, jurnal.judul_jurnal, jurnal.stat_penulis, user.id_user, user.nip');
		$this->db->from('jurnal');
		$this->db->join('user', 'user.id_user = jurnal.id_user', 'left');
        $this->db->group_by('id_jurnal');
		$query = $this->db->get();
		return $query;
    }

    public function countUser()//Menjumlah Total Penulis
    {
        $sql = ("SELECT count(id_user) as jml_penulis FROM jurnal GROUP BY id_jurnal");
        $result = $this->db->query($sql);
        return $result->row()->jml_penulis;
    }

    function input_data($data,$table){
		$this->db->insert($table,$data);
    }
    
    function edit_data($where,$table){		
		return $this->db->get_where($table,$where);
	}
 
	function update_data($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}	
    
	///////////////////////////////////////////////////////////////////////////////////
    
	// //PACKAGE = JURNAL, PRODUCT = USER//

	// GET USER
	function get_Dosen()
	{
		$this->db->where('role_name', 'Dosen');
        $query = $this->db->get('user');
        return $query->result(); 
	}

	//GET USER BY JURNAL ID
	function get_user_by_jurnal($id_jurnal)
	{
        $this->db->select('user.id_user, user.nip');
        $this->db->from('user');
        $this->db->join('penulis_jurnal', 'pj_id_user=id_user');
        $this->db->join('jurnal', 'id_jurnal=pj_id_jurnal');
        $this->db->where('id_jurnal',$id_jurnal);
        $query = $this->db->get();
        return $query;
	}

    
    
    // UPDATE
    function update_jurnal($id,$jurnal,$user)
    {
        $this->db->trans_start();
            //UPDATE TO JURNAL
            $data  = array(
                'judul_jurnal' => $jurnal
            );
            $this->db->where('id_jurnal',$id);
            $this->db->update('jurnal', $data);
             
            //DELETE DETAIL JURNAL
            $this->db->delete('penulis_jurnal', array('pj_id_jurnal' => $id));
 
            $result = array();
                foreach($user AS $key => $val){
                     $result[] = array(
                      'pj_id_jurnal'    => $id,
                      'pj_id_user'      => $_POST['user_edit'][$key]
                     );
                }      
            //MULTIPLE INSERT TO DETAIL TABLE
            $this->db->insert_batch('penulis_jurnal', $result);
        $this->db->trans_complete();
    }
      
 
	
 	

}