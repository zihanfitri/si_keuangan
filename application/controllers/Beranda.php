<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {

	private $parents = 'Beranda';
	private $icon	 = 'fa fa-dashboard';
	var $table 		 = '';

	function __construct(){
		parent::__construct();

		is_login();
		get_breadcrumb();
		$this->load->library('form_validation');

	}

	public function index(){

		$this->breadcrumb->append_crumb('SI Keuangan','Beranda');
		$this->breadcrumb->append_crumb($this->parents,$this->parents);

		$data['title']	= $this->parents.' | SI Keuangan';
		$data['judul']	= $this->parents;
		$data['icon']	= $this->icon;
		$data['umum']   = $this->db->select('(saldo_awal + kas_masuk - kas_keluar) as total_saldo')->order_by('id', DESC)->from('laporan')->get()->row()->total_saldo;
		$jajan = $this->db->select('SUM(masuk) as total_masuk, SUM(keluar) as total_keluar')->from('jajan')->get()->row();
		$data['jajan'] = $jajan->total_masuk - $jajan->total_keluar;
		$sisa_nominal = $this->db->select('SUM(CASE WHEN status = 1 THEN nominal ELSE 0 END) - SUM(CASE WHEN status = 2 THEN nominal ELSE 0 END) AS sisa_nominal')->from('tabungan')->get()->row()->sisa_nominal;
		$data['tabungan'] = $sisa_nominal;

	$this->template->views('v_'.$this->parents,$data);
	}

	public function cariSantri(){
		$cari = $this->input->post('cari');
		$this->db->select('siswa.*, kelas.nama, (SELECT saldo FROM jajan WHERE id_siswa = siswa.id ORDER BY id DESC LIMIT 1) as saldo_jajan, (SELECT saldo FROM tabungan WHERE id_siswa = siswa.id ORDER BY id DESC LIMIT 1) as saldo_tabungan');
		$this->db->from('siswa');
		$this->db->join('kelas', 'siswa.kelas = kelas.id');
		$this->db->like('siswa.name', $cari);
		$data = $this->db->get()->result();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function detailSantri($id){
		$data['santri'] = $this->db->get_where('siswa', array('id' => $id))->row();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
		
	}
	function SimpanJajan(){
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
                                       ->get('jajan')
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
            $this->M_General->insert('jajan', $insert);
			$id = $this->db->insert_id();
			$saldo = $this->db->get_where('jajan', array('id' => $id))->row('saldo');
        }
			$this->session->set_flashdata("pesan", "data berhasil disimpan, saldo anda Rp". number_format($saldo, 0, ',', '.'));
			redirect("Beranda");
	}

	function SimpanTabungan(){
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
									   ->get('tabungan')
									   ->row();
			
			$saldo_baru = $saldo_terakhir ? $saldo_terakhir->saldo : 0;
			
			if ($jenis_transaksi == 'masuk') {
				$insert = array(
					'id_siswa'   => $id_siswa,
					'tanggal'    => date("Y-m-d"),
					'status'      => 1,
					'nominal'     => $nominal,
					'saldo'      => $saldo_baru + $nominal,
				);
			} else {
				$insert = array(
					'id_siswa'   => $id_siswa,
					'tanggal'    => date("Y-m-d"),
					'status'      => 2,
					'nominal'     => $nominal,
					'saldo'      => $saldo_baru - $nominal,
				);
			}

			$proses = $this->M_General->insert('tabungan', $insert);
			$id = $this->db->insert_id();
			$saldo = $this->db->get_where('tabungan', array('id' => $id))->row('saldo');
        }
			$this->session->set_flashdata("pesan", "data berhasil disimpan, saldo anda Rp ". number_format($saldo, 0, ',', '.'));
			redirect("Beranda");
	}

	function SimpanSpp(){
		$id_siswa = $this->input->post('id_siswa',TRUE);
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
	                    'id_siswa'	=> $id_siswa,
	                    'time'	   => waktu(),
	                    'bulan'		=> $bln,
	                    'nominal'	=> $total
	                );
	        $this->M_General->insert('spp',$insert);
	        $id = $this->db->insert_id();
	        $nominal = base64_encode($spp.'-'.$makan.'-'.$air);
			
	        $this->M_General->update_kas('kas_masuk',$total);
    	}
		redirect('Beranda/LoadReceipt/'.$id.'?n='.$nominal, 'refresh');
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
}

/* End of file Beranda.php */
/* Location: ./application/controllers/Beranda.php */