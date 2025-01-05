<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Jajan extends CI_Model {

    private $table = 'jajan';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getAllData($kelas = null) {
        $this->datatables->select('s.id, s.name, s.foto, j.tanggal, SUM(j.masuk) AS total_masuk, SUM(j.keluar) AS total_keluar, SUM(j.masuk) - SUM(j.keluar) AS saldo, (SELECT keterangan FROM jajan j2 WHERE j2.id_siswa = s.id ORDER BY id DESC LIMIT 1) AS keterangan');
        $this->datatables->from('siswa s');
        $this->datatables->join('jajan j', 's.id = j.id_siswa', 'right');
        $this->datatables->group_by('s.id');
        $this->datatables->order_by('s.name', 'ASC');
        $this->datatables->add_column('view','<center><a href="javascript:void(0)" onclick="detail($1)" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Detail</a>','id');

        if ($kelas !== null) {
            $this->datatables->where('s.kelas', $kelas);
        }
        return $this->datatables->generate();
    }

    public function getDetail($id_siswa) {
        $this->db->select('j.id, id_siswa, j.tanggal, j.masuk, j.keluar, j.saldo, j.keterangan');
        $this->db->from($this->table . ' j');
        $this->db->where('j.id_siswa', $id_siswa);
        $this->db->order_by('j.tanggal', 'ASC');
        return $this->db->get()->result();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function getTotalJajanByDate($tanggal) {
        $this->db->select_sum('nominal');
        $this->db->where('DATE(waktu)', $tanggal);
        $query = $this->db->get($this->table);
        return $query->row()->nominal;
    }
}
