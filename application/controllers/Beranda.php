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
}

/* End of file Beranda.php */
/* Location: ./application/controllers/Beranda.php */