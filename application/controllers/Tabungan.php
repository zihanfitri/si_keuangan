<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabungan extends CI_Controller {

	private $parents = 'Tabungan';
	private $icon	 = 'fa fa-money';
	var $table 		 = 'tabungan';
	private $filename = "import_data"; 

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
		$this->breadcrumb->append_crumb($this->parents,$this->parents);

		$data['title']	= $this->parents.' | SI Keuangan ';
		$data['judul']	= $this->parents;
		$data['icon']	= $this->icon;
        $siswa = $this->mod->getSiswa();
        $data['siswa'] = $siswa;

	$this->template->views('Backend/'.$this->parents.'/v_'.$this->parents,$data);
	}

	function getData (){
		header('Content-Type:application/json');
		$kelas = $this->input->post('is_kelas');
		echo $this->mod->getAllData($kelas);
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
					'status'      => 1,
					'nominal'     => $nominal,
					'saldo'      => $saldo_baru + $nominal,
				);
			} else {
				$insert = array(
					'id_siswa'   => $id_siswa,
					'tanggal'    => $tanggal,
					'status'      => 2,
					'nominal'     => $nominal,
					'saldo'      => $saldo_baru - $nominal,
				);
			}

			$this->M_General->insert($this->table, $insert);
			
			$data['status'] = TRUE;
		}
        $this->output->set_content_type('application/json')->set_output(json_encode($data));

	}

	public function edit($id){
		$data = $this->M_General->getByID($this->table,'id',$id,'id')->row();
		echo json_encode($data);
	}

	function import(){

		$upload = $this->M_General->upload_file($this->filename);
	
		if ($upload['status'] == true){
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';

			$objReader = PHPExcel_IOFactory::createReaderForFile($upload['file']['file_path']);
			$objReader->setReadDataOnly(true);
			$objWorksheet = $objReader->load($upload['file']['file_path']);
			$objWorksheet = $objReader->getActiveSheet();

			$cellIterator = $objWorksheet->getRowIterator()->getIterator();
			$cellData = array();
			foreach ($cellIterator as $row) {
				$cellIterator = $row->getCellIterator();
				$rowData = array();
				foreach ($cellIterator as $cell) {
					$rowData[] = $cell->getValue();
				}
				$cellData[] = $rowData;
			}

			$import = array();
			$no = 1;
			foreach ($cellData as $row) {
				if ($no > 1) {
					$import[] = array(
						'nis' => $row[0],
						'nama' => $row[1],
						'kelas' => $row[2],
						'jumlah' => $row[3],
						'tanggal' => $row[4],
					);
				}
				$no++;
			}

			$this->mod->insertBatch($import);
			redirect('Tabungan');
		}
	}

	function ubah($id){
		$data = $this->mod->getByID($this->table,'id',$id,'id')->row();
		echo json_encode($data);
	}

	function update(){
		$id = $this->input->post('id');
		$data = array(
			'nis' => $this->input->post('nis'),
			'nama' => $this->input->post('nama'),
			'kelas' => $this->input->post('kelas'),
			'jumlah' => $this->input->post('jumlah'),
			'tanggal' => $this->input->post('tanggal'),
		);
		$this->mod->update($id,$data);
		redirect('Tabungan');
	}

    function Detail($id_siswa) {
        $this->breadcrumb->append_crumb('SI Keuangan', 'Beranda');
        $this->breadcrumb->append_crumb('Kas Tabungan', 'Tabungan');
        $this->breadcrumb->append_crumb('Detail Tabungan', 'Detail Tabungan');

        $data['title'] = 'Detail Tabungan | SI Keuangan';
        $data['judul'] = 'Detail Tabungan';
        $data['icon']  = 'fa fa-money';
        $data['id_siswa'] = $id_siswa;

        $this->template->views('Backend/Tabungan/v_Detail', $data);
    }
    function getDetail($id_siswa) {
        $data = $this->mod->getDetail($id_siswa);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

	public function Hapus($id, $id_siswa){
		$this->M_General->delete('tabungan','id',$id);
        $this->db->select_sum('nominal');
        $masuk = $this->db->get_where('tabungan', array('id_siswa' => $id_siswa, 'status' => 1))->row('nominal');
        $this->db->select_sum('nominal');
        $keluar = $this->db->get_where('tabungan', array('id_siswa' => $id_siswa, 'status' =>  2))->row('nominal');
        $total_saldo = $masuk - $keluar;
        $this->db->where('id_siswa', $id_siswa);
        $this->db->update('tabungan', array('saldo' => $total_saldo));
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function print(){
        $tanggal = $this->input->post("tanggal");
        $id_siswa = $this->input->post("id_siswa");

        $this->db->select('t.id, id_siswa, t.tanggal, t.nominal, t.saldo, t.status');
        $this->db->from($this->table . ' t');
        $this->db->where('t.id_siswa', $id_siswa);
        $this->db->like('t.tanggal', $tanggal);
        $this->db->order_by('t.tanggal', 'DESC');
        $data =  $this->db->get()->result();

        // Load library PDF
        $this->load->library('pdf');
		
		$pdf = new FPDF('p', 'mm', array(60, 300));
		$pdf->AddPage();
		
		// Header
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(0, 2, 'KWITANSI UANG TABUNGAN', 0, 1, 'C');
		$pdf->SetFont('Arial', '',7);
		$pdf->Cell(0, 10, 'PONDOK PESANTREN MODERN AL-MUHAJIRIN', 0, 1, 'C');
		$pdf->Cell(0,9, date('d-m-Y', $tanggal),0, 1, 'L');
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
			if ($value->status == 1) {
				$masuk = $value->nominal;
				$keluar = '-';
			}else{
				$masuk = '-';
				$keluar = $value->nominal;
			}
            if ($masuk != '-') {
                $saldo += $masuk;
            } else {
                $saldo -= $keluar;
            }
            $pdf->Cell(1, 5, $key+1, 0, 0, 'R');
            $pdf->Cell(14, 5, "Rp ". number_format($masuk,0,'','.'), 0, 0, 'L');
            $pdf->Cell(14, 5, "Rp ". number_format($keluar,0,'','.'), 0, 0, 'L');
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

