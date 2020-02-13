<?php
defined('BASEPATH') OR exit('No direct script access allowed');

clASs Jurnal_model extends CI_Model {

	public function jurnal()
	{
        $query = $this->db->get('jurnal');
        return $query->result(); 
	}
	
	public function view_penulisjurnal()
	{
		$query = $this->db->get('view_penulisjurnal');
        return $query->result();  
	}
    
	public function jurnal_save($data)
	{
		$this->db->insert('jurnal', $data);
    }

    public function search($keyword)
	{
		$this->db->SELECT('*');
		$this->db->FROM('jurnal');
		$this->db->like('id_jurnal',$keyword);
		$this->db->or_like('nip',$keyword);
		$this->db->or_like('judul_jurnal',$keyword);
		$this->db->or_like('nama_jurnal',$keyword);
		$this->db->or_like('nama_penulis',$keyword);
		$this->db->or_like('status_penulis',$keyword);
        $this->db->or_like('ISSN',$keyword);
		$this->db->or_like('volume',$keyword);
		$this->db->or_like('nomor',$keyword);
		$this->db->or_like('bulan',$keyword);
		$this->db->or_like('tahun',$keyword);
        $this->db->or_like('penerbit',$keyword);
        $this->db->or_like('DOI',$keyword);
        $this->db->or_like('status',$keyword);
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
    
    public function getJurnal($where = ''){
		return $this->db->query("SELECT * FROM jurnal $where; ");
	}

	public function getJurnalById($key = null, $value = null)
	{
		$query = $this->db->get('jurnal');
		$this->db->where('id_dosen', $key);
		$this->db->select('*');

		return $this->db->result(); 
	}

	public function nilai_delete($id_nilai)
	{
		$this->db->where('id_nilai',$id_nilai);
		$this->db->delete('nilai_jurnal');
	}
	
	public function nilai_jurnal()
	{
        $query = $this->db->get('nilai_jurnal');
        return $query->result(); 
	}
    
	public function nilai_save($data)
	{
		$this->db->insert('nilai_jurnal', $data);
	}
	
	public function getNilaiById(){
		return $this->db->query("SELECT * FROM nilai_jurnal WHERE id=''");
	}

	public function view()
	{
		$query = $this->db->get('view_nilaijurnal');
        return $query->result();  
	}

	public function get_total()
	{
		$sql = "SELECT sum((kelengkapan_isi + ruanglingkup + kecukupan + kelengkapan_unsur)/2) AS total FROM nilai_jurnal ORDER BY id_jurnal";
		$result = $this->db->query($sql);
		return $result->row()->total;
	}

	
	///////////////////////////////////////////////////////////////////////////////////

	public function nilai_save__($data)
	{
		$this->db->SELECT('jurnal.id_jurnal, nilai_jurnal.id_nilai, nilai_jurnal.id_reviewer, nilai_jurnal.stat_reviewer, nilai_jurnal.kelengkapan_isi, nilai_jurnal.ruanglingkup, nilai_jurnal.kecukupan, nilai_jurnal.kelengkapan_unsur');
		$this->db->FROM('jurnal');
		$this->db->join('nilai_jurnal', 'nilai_jurnal.id_jurnal = jurnal.id_jurnal', 'left');
		$query = $this->db->get();
		return $query;
		$this->db->insert('nilai_jurnal', $data);
	}
	
	function TampilNilaiJurnal() 
    {
		$this->db->SELECT('jurnal.id_jurnal, jurnal.judul_jurnal, jurnal.keterangan, nilai_jurnal.id_nilai, nilai_jurnal.id_reviewer, nilai_jurnal.stat_reviewer, nilai_jurnal.kelengkapan_isi, nilai_jurnal.ruanglingkup, nilai_jurnal.kecukupan, nilai_jurnal.kelengkapan_unsur');
		$this->db->from('jurnal');
		$this->db->join('nilai_jurnal', 'nilai_jurnal.id_jurnal = jurnal.id_jurnal', 'left');
		$query = $this->db->get();
		return $query;
	}  
	

}