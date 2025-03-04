<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lainnya extends CI_Controller {

	private $parents = 'Lainnya';
	private $icon	 = 'fa fa-money';
	var $table 		 = 'lainnya';

	function __construct(){
		parent::__construct();

		is_login();
		get_breadcrumb();
		$this->load->model('M_'.$this->parents,'mod');
		$this->load->library('form_validation');
		$this->load->library('Datatables'); 
	}

	public function index(){

		$this->breadcrumb->append_crumb('SI Keuangan ','Beranda');
		$this->breadcrumb->append_crumb('Pemasukan Uang '.$this->parents,$this->parents);
		$data['siswa'] = $this->db->get('siswa')->result();

		$data['title']	= 'Pemasukan '.$this->parents.' | SI Keuangan ';
		$data['judul']	= 'Pemasukan '.$this->parents;
		$data['icon']	= $this->icon;

	$this->template->views('Backend/'.$this->parents.'/v_'.$this->parents,$data);
	}

	function getData (){
		header('Content-Type:application/json');
		echo $this->mod->getAllData();
	}

	function getDetail(){

		header('Content-Type:application/json');
		$id = $this->input->post('tgl');
		echo $this->mod->getDetailData($id);
	}

		function Detail(){
		$this->breadcrumb->append_crumb('SI Keuangan ',base_url());
		$this->breadcrumb->append_crumb($this->parents,base_url('Lainnya'));
		$this->breadcrumb->append_crumb('Detail Pemasukan Lainnya',$this->parents);

		$data['title']	= 'Detail Pemasukan '.$this->parents.' | SI Keuangan ';
		$data['judul']	= 'Detail Pemasukan '.$this->parents;
		$data['icon']	= $this->icon;
	$this->template->views('Backend/'.$this->parents.'/v_Detail',$data);

	}

	function Simpan(){
		$total = filter_string($this->input->post('nominal',TRUE));

		$insert = array(
			'nominal'	 => $total,
			'sekarang'	 => sekarang(),
			'time'	     => waktu(),
			'id_siswa'   => filter_string($this->input->post('id_siswa',TRUE)),
			'jenis'      => filter_string($this->input->post('jenis',TRUE)),
			'keterangan' => filter_string($this->input->post('keterangan',TRUE))
		);

		$insert = $this->M_General->insert($this->table,$insert);
		$data['id'] = $this->db->insert_id();
		$this->M_General->update_kas('kas_masuk',$total);
		$data['status'] = TRUE;

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function hapus($id){
		$this->M_General->delete($this->table,'id',$id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function print($id, $tanggal = ''){
            $this->db->select("id,id_siswa,sekarang,jenis,keterangan,DATE_FORMAT(s.tanggal,'%d-%m-%Y') AS Tgl, Sum(s.nominal) AS total");
            $this->db->from($this->table . ' s');
            $this->db->where('s.id', $id);
            // $this->db->where('tanggal', $tanggal);
            $data =  $this->db->get()->result();
			$siswa = $this->db->get_where('siswa', ['id' => $data[0]->id_siswa])->row();
			$kelas = $this->db->get_where('kelas', ['id' => $siswa->kelas])->row('nama');
    
		// Load library PDF
		$this->load->library('pdf');
		
		$pdf = new FPDF('p', 'mm', 'A5');
		$pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 10, 'KWITANSI PEMBAYARAN Lainnya', 0, 1, 'C');
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(0, 10, 'PONDOK PESANTREN MODERN AL-MUHAJIRIN', 0, 1, 'C');
		$pdf->Ln(10);
		
		// Informasi Pembayaran
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(40, 7, 'No. Kwitansi', 0);
		$pdf->Cell(5, 7, ':', 0);
		$pdf->Cell(0, 7, $data[0]->id, 0, 1);
		
		$pdf->Cell(40, 7, 'Tanggal', 0);
		$pdf->Cell(5, 7, ':', 0);
		$pdf->Cell(0, 7, date('d-M-Y', strtotime($data[0]->Tgl)), 0, 1);
		
		$pdf->Cell(40, 7, 'Nama Siswa', 0);
		$pdf->Cell(5, 7, ':', 0);
		$pdf->Cell(0, 7, $siswa->name, 0, 1);
		
		$pdf->Cell(40, 7, 'Kelas', 0);
		$pdf->Cell(5, 7, ':', 0);
		$pdf->Cell(0, 7, $kelas, 0, 1);
		
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(40, 7, 'Untuk Pembayaran', 0);
		$pdf->Cell(5, 7, ':', 0,1);
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(40, 7, $data[0]->jenis, 0);
		$pdf->Cell(5, 7, ':', 0);
		$pdf->Cell(0, 7, number_format($data[0]->total, 0, ',', '.'), 0, 1);
		
		$pdf->Ln(10);
		
		// Tanda tangan
		$pdf->Cell(0, 7, 'Petugas', 0, 1, 'R');
		$pdf->Ln(15);
		$pdf->Cell(0, 7, 'Ustdzh Neng Fitri Zihan Noviana', 0, 1, 'R');
		

		$pdf->Output();  
    }

}