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

	function hapus($id){
		$this->mod->hapus($id);
		redirect('Tabungan');
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
}

