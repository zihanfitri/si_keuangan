<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jajan extends CI_Controller {

    private $parents = 'Jajan';
    private $icon    = 'fa fa-money';
    var $table       = 'jajan';

    function __construct(){
        parent::__construct();

        is_login();
        get_breadcrumb();
        $this->load->library('form_validation');
        $this->load->library('Datatables');
        $this->load->model('M_'.$this->parents,'mod');
    }

    public function index(){
        $this->breadcrumb->append_crumb('SI Keuangan', 'Beranda');
        $this->breadcrumb->append_crumb('Kas '.$this->parents, $this->parents);

        $data['title'] = 'Kas '.$this->parents.' | SI Keuangan';
        $data['judul'] = 'Kas '.$this->parents;
        $data['icon']  = $this->icon;
        $data['siswa'] = $this->M_General->getAll('siswa', 'id', 'DESC')->result();

        $this->template->views('Backend/'.$this->parents.'/v_'.$this->parents, $data);
    }

    function getData(){
        header('Content-Type:application/json');
		echo $this->mod->getAllData();
    }

    function Simpan(){
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');
        $this->form_validation->set_rules('jenis_transaksi', 'Jenis Transaksi', 'required');
        
        if($this->form_validation->run() == FALSE){
            $data['status'] = FALSE;
            $data['errors'] = validation_errors();
        }else{
            $jenis_transaksi = $this->input->post('jenis_transaksi');
            $nominal = $this->input->post('nominal');
            $id_siswa = $this->input->post('id_siswa');            
            // Ambil saldo terakhir siswa
            $saldo_terakhir = $this->db->select('saldo')
                                       ->where('id_siswa', $id_siswa)
                                       ->order_by('id', 'DESC')
                                       ->limit(1)
                                       ->get($this->table)
                                       ->row();
            
            $saldo_baru = $saldo_terakhir ? $saldo_terakhir->saldo : 0;
            
            if ($jenis_transaksi == 'masuk') {
                $insert = array(
                    'id_siswa'   => $id_siswa,
                    'tanggal'    => date('Y-m-d'),
                    'masuk'      => $nominal,
                    'keluar'     => 0,
                    'saldo'      => $saldo_baru + $nominal,
                    'keterangan' => $this->input->post('keterangan')
                );
            } else {
                $insert = array(
                    'id_siswa'   => $id_siswa,
                    'tanggal'    => date('Y-m-d'),
                    'masuk'      => 0,
                    'keluar'     => $nominal,
                    'saldo'      => $saldo_baru - $nominal,
                    'keterangan' => $this->input->post('keterangan')
                );
            }

            $this->M_General->insert($this->table, $insert);
            
            $data['status'] = TRUE;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function Update(){
        $id = $this->input->post('id');

        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if($this->form_validation->run() == FALSE){
            $data['status'] = FALSE;
            $data['errors'] = validation_errors();
        }
        else{
            $update = array(
                'tanggal'    => $this->input->post('tanggal'),
                'nominal'    => $this->input->post('nominal'),
                'keterangan' => $this->input->post('keterangan')
            );

            $this->M_General->update($this->table, $update, 'id', $id);
            
            $data['status'] = TRUE;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function Detail($id_siswa) {
        $this->breadcrumb->append_crumb('SI Keuangan', base_url());
        $this->breadcrumb->append_crumb('Jajan', base_url('Jajan'));
        $this->breadcrumb->append_crumb('Detail Jajan', 'DetailJajan');

        $data['title'] = 'Detail Jajan Siswa | SI Keuangan';
        $data['judul'] = 'Detail Jajan Siswa';
        $data['icon'] = $this->icon;
        $data['id_siswa'] = $id_siswa;

        $this->template->views('Backend/'.$this->parents.'/v_Detail', $data);
    }

    function getDetail($id_siswa) {
        $data = $this->mod->getDetail($id_siswa);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

}
