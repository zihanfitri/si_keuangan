<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_tabungan extends CI_Controller {

	private $parents = 'Laporan_tabungan';
	private $icon	 = 'fa fa-line-chart';
	var $table 		 = '';

	function __construct(){
		parent::__construct();

		is_login();
		get_breadcrumb();
		$this->load->model('M_'.$this->parents,'mod');
		$this->load->library('form_validation');
		$this->load->library('Datatables'); 
        $this->load->library('pdf');
	}

	public function index(){

		$this->breadcrumb->append_crumb('SI Keuangan','Beranda');
		$this->breadcrumb->append_crumb($this->parents.' Kas',$this->parents);

		$data['title']	= $this->parents.' Kas | SI Keuangan';
		$data['judul']	= $this->parents.' Kas';
		$data['icon']	= $this->icon;

	$this->template->views('/Backend/v_'.$this->parents,$data);
	}

	function getData (){
		header('Content-Type:application/json');
		echo $this->mod->getAllData();
	}

    function Cetak_periode(){

        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');

        
        $a = $this->mod->getDataForReport($awal,$akhir);

        $pdf = new FPDF('p','mm','A4');
        $pdf->AddPage();
       // head
       
       $pdf->Cell(3,5,'',0,1);
       $pdf->Image(base_url().'/assets/dist/img/logo_al_muhajirin.png', 176, 15, 28);
      //  $pdf->Image(base_url().'/assets/dist/img/tut_wuri_handayani.png', 3, 12, 28);
       $pdf->Cell(3,-5,'',0,1);
       $pdf->SetFont('TIMES','B',14);
       $pdf->Cell(189, 5, '', 0, 1, 'C');
       $pdf->Cell(189, 7, '', 0, 1, 'C');
       $pdf->SetFont('TIMES','B',16);
       $pdf->Cell(172, 7, 'PONDOK PESANTREN MODERN AL-MUHAJIRIN', 0, 2, 'C');
       $pdf->SetFont('TIMES','',12);
       $pdf->Cell(169, 5, 'Jl. Cibuntu Cimuncang, Sindangpalay, Kec. Cibeureum, Kab Sukabumi, Jawa Barat 43161', 0, 1, 'C');
       $pdf->Cell(169, 5, 'Telp. 085721632396 / 085797463379', 0, 1, 'C');
       $pdf->Cell(169, 5, 'E-mail : ppmalmuhajirinsukabumi@gmail.com', 0, 1, 'C');
       $pdf->SetLineWidth(1);
       $pdf->Line(9, 46, 203, 46);
       $pdf->SetLineWidth(0);
       $pdf->Line(9, 47, 203, 47);

       $pdf->Cell(3,8,'',0,1);
       $pdf->SetFont('TIMES','',12);
       $pdf->Cell(10, 5, 'Laporan Tabungan Pertanggal : '.tanggal($awal,'bulan').' - '.tanggal($akhir,'bulan'), 0, 1);

       $pdf->Cell(5,5,'',0,1);
       $pdf->SetFont('TIMES','B',11);
       $pdf->Cell(7, 5, 'No', 1, 0,'C');
       $pdf->Cell(40, 5, 'Tanggal', 1, 0,'C');
       $pdf->Cell(35, 5, 'Uang Masuk', 1, 0,'C');
       $pdf->Cell(35, 5, 'Uang keluar', 1, 0,'C');
       $pdf->Cell(35, 5, 'Sisa Saldo', 1, 1,'C');
       
       $pdf->SetFont('TIMES','',10);
       $no = 1;
       foreach ($a as $i){
        // $saldo = $i->saldo_awal + $i->kas_masuk - $i->kas_keluar;
          $pdf->Cell(7, 5,$no++, 1,0,'C');
          $pdf->Cell(40, 5,tanggal($i->tanggal,'bln'), 1, 0,'C');
          $pdf->Cell(35, 5,rupiah($i->masuk), 1, 0,'C');
          $pdf->Cell(35, 5,rupiah($i->keluar), 1, 0,'C');
          $pdf->Cell(35, 5,rupiah($i->saldo), 1, 1,'R');
        //   $pdf->Cell(35, 5,rupiah($saldo), 1, 1,'C');
       }

       $pdf->SetFont('TIMES','',12);
       $pdf->Cell(125, 35, '', 0, 1);
       $pdf->Cell(125, 35, '', 0, 0);
       $pdf->Cell(55, 5, 'Sukabumi, '.  tanggal(waktu(),'bulan'), 0, 1);
       $pdf->Cell(125, 5, '', 0, 0);
       $pdf->Cell(35, 5, 'Pimpinan Ponpes,', 0, 1);
       $pdf->Cell(125, 10, '', 0, 0);
       $pdf->Cell(35, 14, '', 0, 1);
       $pdf->Cell(125, 8, '', 0, 0);
       $pdf->Cell(35, 9, "Ust. H. M. Hasim As'ari, S.E", 0, 0);
       $pdf->Output();  

    }
}

/* End of file Beranda.php */
/* Location: ./application/controllers/Beranda.php */

