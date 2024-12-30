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
            if ($this->input->post('tanggal')) {
                $tanggal = filter_string($this->input->post('tanggal',TRUE)).' '.date("H:i:s");
            } else {
                $tanggal = date("Y-m-d H:i:s");
            }
            
            if ($jenis_transaksi == 'masuk') {
                $insert = array(
                    'id_siswa'   => $id_siswa,
                    'tanggal'    => $tanggal,
                    'masuk'      => $nominal,
                    'keluar'     => 0,
                    'saldo'      => $saldo_baru + $nominal,
                    'keterangan' => $this->input->post('keterangan')
                );
            } else {
                $insert = array(
                    'id_siswa'   => $id_siswa,
                    'tanggal'    => $tanggal,
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

    public function Hapus($id, $id_siswa){
		$this->M_General->delete($this->table,'id',$id);
        $this->db->select_sum('masuk');
        $masuk = $this->db->get_where('jajan', array('id_siswa' => $id_siswa))->row('masuk');
        $this->db->select_sum('keluar');
        $keluar = $this->db->get_where('jajan', array('id_siswa' => $id_siswa))->row('masuk');
        $total_saldo = $masuk - $keluar;
        $this->db->where('id_siswa', $id_siswa);
        $this->db->update('jajan', array('saldo' => $total_saldo));
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

    public function print(){
        $tanggal = $this->input->post("tanggal");
        $id_siswa = $this->input->post("id_siswa");

        $this->db->select('j.id, id_siswa, j.tanggal, j.masuk, j.keluar, j.saldo, j.keterangan');
        $this->db->from($this->table . ' j');
        $this->db->where('j.id_siswa', $id_siswa);
        $this->db->where('j.tanggal', $tanggal);
        $this->db->order_by('j.tanggal', 'DESC');
        $data =  $this->db->get()->result();

        // Load library PDF
        $this->load->library('pdf');
		
		$pdf = new FPDF('p', 'mm', array(60, 300));
		$pdf->AddPage();
		
		// Header
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(0, 2, 'KWITANSI UANG JAJAN', 0, 1, 'C');
		$pdf->SetFont('Arial', '',7);
		$pdf->Cell(0, 10, 'PONDOK PESANTREN MODERN AL-MUHAJIRIN', 0, 1, 'C');
		$pdf->Ln(2);
		// Header Tabel

        $pdf->setFont('Arial','', 6);
        $pdf->Cell(1, 5, 'No', 0, 0, 'R');
        $pdf->Cell(14, 5, 'Masuk', 0, 0, 'L');
        $pdf->Cell(14, 5, 'Keluar', 0, 0, 'L');
        $pdf->Cell(15, 5, 'Saldo', 0, 1, 'C');
        $pdf->Ln(2);
        $saldo = 0;
        foreach ($data as $key => $value) {
            if ($value->masuk != 0) {
                $saldo += $value->masuk;
            } else {
                $saldo -= $value->keluar;
            }
            $pdf->Cell(1, 5, $key+1, 0, 0, 'R');
            $pdf->Cell(14, 5, "Rp ". number_format($value->masuk,0,'','.'), 0, 0, 'L');
            $pdf->Cell(14, 5, "Rp ". number_format($value->keluar,0,'','.'), 0, 0, 'L');
            $pdf->Cell(15, 5, "Rp ". number_format($saldo,0,'','.'), 0, 1, 'C');
            $pdf->Ln(0); 
        }
		
		$pdf->Ln(10);
		
		// Tanda tangan
		$pdf->Cell(48, 5, 'Petugas', 0, 1, 'R');
		$pdf->Ln(4);
		$pdf->Cell(48, 5, 'Ustdzh Neng Fitri Zihan Noviana', 0, 1, 'R');
		

		$pdf->Output();  
    }

}
