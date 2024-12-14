<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Tabungan extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllData($kelas = '')
    {
        $this->datatables->select('s.id, t.tanggal, s.name,s.foto, COALESCE(t.saldo, 0) as nominal');
        $this->datatables->from('siswa s');
        $this->datatables->join('(SELECT id_siswa, MAX(id) as max_id FROM tabungan GROUP BY id_siswa) tm', 's.id = tm.id_siswa', 'left');
        $this->datatables->join('tabungan t', 'tm.max_id = t.id', 'left');
        $this->datatables->order_by('s.name', 'ASC');
        $this->datatables->add_column('view','<center><a href="javascript:void(0)" onclick="detail($1)" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Detail</a>','id');

        if ($kelas !== null) {
            $this->datatables->where('s.kelas', $kelas);
        }
    return $this->datatables->generate();
    }

    public function getSiswa()
    {
        $this->db->select('*');
        $this->db->from('siswa');
        $query = $this->db->get();
        return $query->result();
    }

    public function insertBatch($data)
    {
        $this->db->insert_batch('tabungan', $data);
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tabungan');
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tabungan', $data);
    }
    public function getDetail($id_siswa)
    {
        $this->db->select('tanggal, nominal, status, saldo');
        $this->db->from('tabungan');
        $this->db->where('id_siswa', $id_siswa);
        $this->db->order_by('tanggal', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
}

