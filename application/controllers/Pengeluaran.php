<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {

	private $parents = 'Pengeluaran';
	private $icon	 = 'fa fa-cart-plus';
	var $table 		 = 'pengeluaran';

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
		$this->breadcrumb->append_crumb($this->parents.' Lainnya',$this->parents);

		$data['title']	= $this->parents.' Lainnya | SI Keuangan ';
		$data['judul']	= $this->parents.' Lainnya';
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
		$this->breadcrumb->append_crumb($this->parents,base_url('Pengeluaran'));
		$this->breadcrumb->append_crumb('Detail Pengeluaran Lainnya',$this->parents);

		$data['title']	= 'Detail '.$this->parents.' Lainnya | SI Keuangan ';
		$data['judul']	= 'Detail '.$this->parents.' Lainnya';
		$data['icon']	= $this->icon;
	$this->template->views('Backend/'.$this->parents.'/v_Detail',$data);

	}

	function Simpan(){
		$total = filter_string($this->input->post('nominal',TRUE));
		if ($this->input->post('tanggal')) {
			$tanggal = filter_string($this->input->post('tanggal',TRUE)).' '.date("H:i:s");
		} else {
			$tanggal = date("Y-m-d H:i:s");
		}

		$insert = array(
			'nominal'	 => $total,
			'sekarang'	 => sekarang(),
			'time'	     => waktu(),
			'jenis'      => filter_string($this->input->post('jenis',TRUE)),
			'keterangan' => filter_string($this->input->post('keterangan',TRUE)),
			'tanggal'	 => $tanggal
		);

		$insert = $this->M_General->insert($this->table,$insert);
		$this->M_General->update_kas('kas_keluar',$total);
		$data['status'] = TRUE;

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function Hapus($id){
		$this->M_General->delete($this->table,'id',$id);
        // $this->db->select_sum('masuk');
        // $masuk = $this->db->get_where('jajan', array('id_siswa' => $id_siswa))->row('masuk');
        // $this->db->select_sum('keluar');
        // $keluar = $this->db->get_where('jajan', array('id_siswa' => $id_siswa))->row('masuk');
        // $total_saldo = $masuk - $keluar;
        // $this->db->where('id_siswa', $id_siswa);
        // $this->db->update('jajan', array('saldo' => $total_saldo));
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

}