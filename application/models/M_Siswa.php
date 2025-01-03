<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Siswa extends CI_Model {

	function getAllData($kls = ''){
		$this->datatables->select('id,name,nis,status,sex,wali, dispen, foto');
		$this->datatables->from('siswa');
		$this->datatables->add_column('view','<center><a href="javascript:void(0)" onclick="Ubah($1)" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Ubah</a></center> ','id');
		if ($kls != '') {
			# code...
			$this->datatables->where('kelas',$kls);
		}
		$this->datatables->edit_column('status','<span class="label label-success control-label">$1</span>','status');
		return $this->datatables->generate();
	}
	
	public function getByID($tables,$pk,$id,$type){
        $this->db->order_by($pk,$type);
        $this->db->where($pk,$id);
        return $this->db->get($tables);
    }
	

}