<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Laporan_jajan extends CI_Model {

	function getAllData(){
		$this->datatables->select("id,SUM(masuk) as masuk, SUM(keluar) as keluar, tanggal, (SUM(masuk) - SUM(keluar)) as saldo_akhir");
		$this->datatables->group_by('tanggal');
		$this->datatables->order_by('tanggal', 'ASC');
		$this->datatables->from('jajan');
		return $this->datatables->generate();
	}

    function getDataForReport($awal, $akhir){
        $this->db->select('SUM(masuk) as masuk, SUM(keluar) as keluar, tanggal, (SUM(masuk) - SUM(keluar)) as saldo');
        $this->db->where('tanggal >=',$awal);
        $this->db->where('tanggal <=',$akhir);
        $this->db->group_by('tanggal');
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get('jajan')->result();
    }
    

}