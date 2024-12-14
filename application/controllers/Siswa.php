<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

	private $parents = 'Siswa';
	private $icon	 = 'fa fa-users';
	var $table 		 = 'siswa';
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

	$this->template->views('Backend/'.$this->parents.'/v_'.$this->parents,$data);
	}

	function getData (){
		header('Content-Type:application/json');
		$kelas = $this->input->post('is_kelas');
		echo $this->mod->getAllData($kelas);
	}


	public function edit($id){
		$data = $this->M_General->getByID($this->table,'id',$id,'id')->row();
		echo json_encode($data);
	}

	function import(){

		$upload = $this->M_General->upload_file($this->filename);
	
		if ($upload['status'] == true){
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx');
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
			$data = array();
			$numrow = 1;
			foreach($sheet as $row){
				if($numrow > 1){
					// Kita push (add) array data ke variabel data
					array_push($data, array(
						'name'=>$row['A'],
						'nis'=>$row['B'],
						'tempat'=>$row['C'],
						'tanggal'=>$row['D'],
						'sex'=>$row['E'],
						'wali'=>$row['F'],
						'alamat'=>$row['G'],
						'status'=>$row['H'],
						'kelas'=>$row['I'],
					));
				}
				
				$numrow++;
			}
			$this->M_General->insert_multiple($data);
			
			$data['status'] = TRUE;
			$this->M_General->delete('siswa','kelas','0');
    	}
    	else{
    		$data['status'] = FALSE;
    	}
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function Simpan(){
		$config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['max_size']             = 1000000;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
		
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('foto')) {
            $data['error'] = array('error' => $this->upload->display_errors());
			$data['status'] = false;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $dataFoto = $this->upload->data();
			$namafile = $this->input->post('nama').$dataFoto['file_ext'];
			$namaFoto = str_replace(" ", "_", $namafile);
			rename($dataFoto['full_path'], $config['upload_path'] . $namaFoto);

 
        
        $insert = array(
                    'name'  	=> filter_string(ucwords($this->input->post('nama'),TRUE)),
                    'sex'		=> $this->input->post('gender',TRUE),
                    'nis' 		=> $this->input->post('nis',TRUE),
                    'kelas' 	=> $this->input->post('kelas',TRUE),
                    'tempat'	=> filter_string($this->input->post('tempat',TRUE)),
                    'tanggal'	=> filter_string($this->input->post('tanggal',TRUE)),
                    'alamat'	=> filter_string($this->input->post('alamat',TRUE)),
                    'status'	=> filter_string($this->input->post('status',TRUE)),
                    'wali'		=> filter_string($this->input->post('wali',TRUE)),
                    'dispen'		=> filter_string($this->input->post('dispen',TRUE)),
					'foto'		=> $namaFoto,
                );

        $insert = $this->M_General->insert($this->table,$insert);
        $data['status'] = TRUE;
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
			}
	}

	function Ubah(){
			$id_siswa = $this->input->post('id');
			$this->db->select('foto');
            $this->db->where('id', $id_siswa);
            $query = $this->db->get('siswa');
            $gambar_lama = $query->row()->foto;
            if ($gambar_lama != '') {
                unlink('./uploads/' . $gambar_lama);
            }
			$config['upload_path']          = './uploads/';
			$config['allowed_types']        = 'gif|jpg|jpeg|png';
			$config['max_size']             = 1000000;
			// $config['max_width']            = 1024;
			// $config['max_height']           = 768;
			
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('foto')) {
				$data['error'] = array('error' => $this->upload->display_errors());
				$data['status'] = false;
				$this->output->set_content_type('application/json')->set_output(json_encode($data));
			} else {
				$dataFoto = $this->upload->data();
				$namafile = $this->input->post('nama').$dataFoto['file_ext'];
				$namaFoto = str_replace(" ", "_", $namafile);
				rename($dataFoto['full_path'], $config['upload_path'] . $namaFoto);
			}

        $insert = array(
                    'name'  	=> filter_string(ucwords($this->input->post('nama'),TRUE)),
                    'sex'		=> $this->input->post('gender',TRUE),
                    'nis' 		=> $this->input->post('nis',TRUE),
                    'tempat'	=> filter_string($this->input->post('tempat',TRUE)),
                    'tanggal'	=> filter_string($this->input->post('tanggal',TRUE)),
                    'alamat'	=> filter_string($this->input->post('alamat',TRUE)),
                    'status'	=> filter_string($this->input->post('status',TRUE)),
                    'wali'		=> filter_string($this->input->post('wali',TRUE)),
                    'dispen'		=> filter_string($this->input->post('dispen',TRUE)),
					'foto'		=> $namaFoto,
                );
        $insert = $this->M_General->update($this->table,$insert,'id',$id_siswa);
        $data['status'] = TRUE;
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	function detail($id){
		$this->breadcrumb->append_crumb('SI Keuangan ',base_url());
		$this->breadcrumb->append_crumb($this->parents,base_url('SPP'));
		$this->breadcrumb->append_crumb('Detail Pembayaran SPP',$this->parents);

		$data['title']	= 'Pembayaran Uang '.$this->parents.' | SI Keuangan ';
		$data['judul']	= 'Pembayaran Uang '.$this->parents;
		$data['icon']	= $this->icon;
		$data['spp']	= $this->M_General->getByID('spp','id_siswa',$id,'DESC')->result();
		$data['jajan']	= $this->M_General->getByID('jajan','id_siswa',$id,'DESC')->result();
		$data['tabungan']	= $this->M_General->getByID('tabungan','id_siswa',$id,'DESC')->result();

		$this->template->views('Backend/'.$this->parents.'/v_Detail',$data);
	}
}