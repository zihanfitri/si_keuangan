<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SPP extends CI_Controller {

	private $parents = 'SPP';
	private $icon	 = 'fa fa-money';
	var $table 		 = 'spp';

	function __construct(){
		parent::__construct();

		is_login();
		get_breadcrumb();
		$this->load->model('M_General','mod');
		$this->load->library('form_validation');
		$this->load->library('Datatables'); 
	}

	public function index(){

		$this->breadcrumb->append_crumb('SI Keuangan ','Beranda');
		$this->breadcrumb->append_crumb('Uang '.$this->parents,$this->parents);

		$data['title']	= 'Pembayaran Uang '.$this->parents.' | SI Keuangan ';
		$data['judul']	= 'Pembayaran Uang '.$this->parents;
		$data['icon']	= $this->icon;

	$this->template->views('Backend/'.$this->parents.'/v_'.$this->parents,$data);
	}

	function getData (){
		header('Content-Type:application/json');
		$kls = $this->input->post('is_kelas');
		echo $this->M_General->getSiswa($kls);
	}

	function getSPP($id){
		header('Content-Type:application/json');
		$dispen = $this->db->query("SELECT dispen FROM siswa WHERE id = '$id'")->row('dispen');
		$spp = $this->db->query("SELECT nominal FROM pembayaran WHERE id = 1")->row_array();
		$makan = $this->db->query("SELECT nominal FROM pembayaran WHERE id = 7")->row_array();
		$air = $this->db->query("SELECT nominal FROM pembayaran WHERE id = 8")->row_array();
		echo json_encode(['dispen' => $dispen, 'spp' => $spp['nominal'], 'makan' => $makan['nominal'], 'air' => $air['nominal']]);
	}

	function Detail($id){
		$this->breadcrumb->append_crumb('SI Keuangan ',base_url());
		$this->breadcrumb->append_crumb($this->parents,base_url('SPP'));
		$this->breadcrumb->append_crumb('Detail Pembayaran SPP',$this->parents);

		$data['title']	= 'Pembayaran Uang '.$this->parents.' | SI Keuangan ';
		$data['judul']	= 'Pembayaran Uang '.$this->parents;
		$data['icon']	= $this->icon;
		$data['isi']	= $this->mod->getByID('spp','id_siswa',$id,'DESC')->result();

	$this->template->views('Backend/'.$this->parents.'/v_Detail',$data);

	}

	function Simpan(){

		$id = $this->input->post('id',TRUE);
		$bln = filter_string($this->input->post('bulan',TRUE));
		$cek = $this->db->query("SELECT id FROM spp WHERE id_siswa = '$id' AND bulan = '$bln' ")->num_rows();

		if ($cek > 0){
			$data['status'] = FALSE;
    	}
    	else{
			$spp = filter_string($this->input->post('spp',TRUE));
			$makan = filter_string($this->input->post('makan',TRUE));
			$air = filter_string($this->input->post('air',TRUE));
    		$total = $spp + $makan + $air;
    		$insert = array(
	                    'id_siswa'	=> $id,
	                    'time'	   => waktu(),
	                    'bulan'		=> $bln,
	                    'nominal'	=> $total,
	                    'spp'	=> $spp,
	                    'makan'	=> $makan,
	                    'air'	=> $air
	                );
	        $insert = $this->M_General->insert($this->table,$insert);
	        $data['id'] = $this->db->insert_id();
	        $data['nominal'] = base64_encode($spp.'-'.$makan.'-'.$air);
			
	        $this->M_General->update_kas('kas_masuk',$total);
	        $data['status'] = TRUE;
    		
    	}
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function edit(){
		$id = $this->input->post('id',TRUE);
		$tanggal = $this->input->post('tanggal',TRUE);
		$this->db->update($this->table,['tanggal' => $tanggal],['id' => $id]);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function LoadReceipt($id_pembayaran) {
		$pembayaran = $this->M_General->getByID('spp', 'id', $id_pembayaran, 'DESC')->row_array();

		
		// Ambil data siswa
		$siswa = $this->M_General->getByID('siswa', 'id', $pembayaran['id_siswa'], 'DESC')->row_array();
		$nominal = $_GET['n'];
		$nominal = explode('-', base64_decode($nominal));
		$spp = $nominal[0];
		$makan = $nominal[1];
		$air = $nominal[2];
		if (empty($spp)) {
			$spp = '-';
		} else {
			$spp = 'Rp ' . number_format($spp, 0, ',', '.');
		}
		if (empty($makan)) {
			$makan = '-';
		} else {
			$makan = 'Rp ' . number_format($makan, 0, ',', '.');
		}
		if (empty($air)) {
			$air = '-';
		} else {
			$air = 'Rp ' . number_format($air, 0, ',', '.');
		}
		// Load library PDF
         $this->load->library('pdf');
		
		$pdf = new FPDF('p', 'mm', 'A5');
		$pdf->AddPage();
		
		// Header
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 10, 'KWITANSI PEMBAYARAN SPP', 0, 1, 'C');
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(0, 10, 'PONDOK PESANTREN MODERN AL-MUHAJIRIN', 0, 1, 'C');
		$pdf->Ln(10);
		
		// Informasi Pembayaran
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(40, 7, 'No. Kwitansi', 0);
		$pdf->Cell(5, 7, ':', 0);
		$pdf->Cell(0, 7, $pembayaran['id'], 0, 1);
		
		$pdf->Cell(40, 7, 'Tanggal', 0);
		$pdf->Cell(5, 7, ':', 0);
		$pdf->Cell(0, 7, date('d-M-Y', strtotime($pembayaran['time'])), 0, 1);
		
		$pdf->Cell(40, 7, 'Nama Siswa', 0);
		$pdf->Cell(5, 7, ':', 0);
		$pdf->Cell(0, 7, $siswa['name'], 0, 1);
		
		$pdf->Cell(40, 7, 'Kelas', 0);
		$pdf->Cell(5, 7, ':', 0);
		$pdf->Cell(0, 7, $siswa['kelas'], 0, 1);
		
		$pdf->Cell(40, 7, 'Bulan', 0);
		$pdf->Cell(5, 7, ':', 0);
		$pdf->Cell(0, 7, $pembayaran['bulan'], 0, 1);
		
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(40, 7, 'Untuk Pembayaran', 0);
		$pdf->Cell(5, 7, ':', 0,1);
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(40, 7, 'Iuran SPP', 0);
		$pdf->Cell(5, 7, ':', 0);
		$pdf->Cell(0, 7, $spp, 0, 1);
		$pdf->Cell(40, 7, 'Uang Makan', 0);
		$pdf->Cell(5, 7, ':', 0);
		$pdf->Cell(0, 7, $makan, 0, 1);
		$pdf->Cell(40, 7, 'Uang Air', 0);
		$pdf->Cell(5, 7, ':', 0);
		$pdf->Cell(0, 7, $air, 0, 1);
		
		$pdf->Ln(10);
		
		// Tanda tangan
		$pdf->Cell(0, 7, 'Petugas', 0, 1, 'R');
		$pdf->Ln(15);
		$pdf->Cell(0, 7, 'Ustdzh Neng Fitri Zihan Noviana', 0, 1, 'R');
		

		$pdf->Output();  


	}
	public function Hapus($id){
		$this->M_General->delete($this->table,'id',$id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

}