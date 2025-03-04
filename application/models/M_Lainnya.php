<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Lainnya extends CI_Model {

	function getAllData(){
		$this->datatables->select("id,jenis, DATE_FORMAT(s.tanggal,'%d-%m-%Y') AS tanggal, nominal, keterangan, (Select name from siswa where id = s.id_siswa) as siswa");
		$this->datatables->from('lainnya as s');
		// $this->datatables->group_by("DATE_FORMAT(s.tanggal,'%Y-%m-%d')");
		$this->datatables->add_column('view','<center><a href="javascript:void(0)" onclick="Hapus($1)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a> <a href="'.base_url('lainnya/print/').'$1" target="_blank" rel="noopener noreferrer" class="btn btn-success btn-xs"><i class="fa fa-print"></i> Print</a>','id');

		return $this->datatables->generate();
	}

	function getDetailData($detail =''){
		$this->datatables->select("id,DATE_FORMAT(s.tanggal,'%d-%m-%Y - %H:%m:%s WIB') AS Tgl,nominal,jenis,keterangan");
		$this->datatables->from('lainnya as s');
		$this->datatables->where('sekarang',$detail);
		return $this->datatables->generate();
	}
	

}

/* End of file m_Menu_1.php */
/* Location: ./application/models/m_Menu_1.php */