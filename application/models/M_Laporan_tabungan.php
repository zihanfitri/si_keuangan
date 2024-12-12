<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Laporan_tabungan extends CI_Model {

	function getAllData(){
		$this->datatables->select('id,tanggal, 
                            SUM(CASE WHEN status = 1 THEN nominal ELSE 0 END) AS masuk, 
                            SUM(CASE WHEN status = 2 THEN nominal ELSE 0 END) AS keluar, 
                            (SUM(CASE WHEN status = 1 THEN nominal ELSE 0 END) - SUM(CASE WHEN status = 2 THEN nominal ELSE 0 END)) AS saldo_akhir');
        $this->datatables->group_by('tanggal');
        $this->datatables->order_by('tanggal', 'ASC');
        $this->datatables->from('tabungan');
		return $this->datatables->generate();
	}

    function getDataForReport($awal, $akhir){
        $this->db->select('id,tanggal, 
                            SUM(CASE WHEN status = 1 THEN nominal ELSE 0 END) AS masuk, 
                            SUM(CASE WHEN status = 2 THEN nominal ELSE 0 END) AS keluar, 
                            (SUM(CASE WHEN status = 1 THEN nominal ELSE 0 END) - SUM(CASE WHEN status = 2 THEN nominal ELSE 0 END)) AS saldo');
        $this->db->where('tanggal >=',$awal);
        $this->db->where('tanggal <=',$akhir);
        $this->db->group_by('tanggal');
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get('tabungan')->result();
    }
    

}