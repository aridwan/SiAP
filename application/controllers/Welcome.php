<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Xlsx;

class Welcome extends CI_Controller {

	public function index(){
		if (isset($_SESSION['username'])){
			// if ($_SESSION['username'] == 'admin'){
				// $this->session->set_userdata(array('username'=>$username));
				$query = $this->db->query('SELECT * FROM access_point');
				$data['hasil'] = $query->result_array();
				$this->load->view('dashboard',$data);
			// } else {
			// 	$data['error'] = 'Invalid Account';
			// 	$this->load->view('login_page',$data);
			// }
		}
		else {
			$this->load->view('login_page');
		}
	}

	public function saveToServer()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');
		
		$writer = new Xlsx($spreadsheet);

		$filename = 'testing.xlsx';

		$writer->save($filename);

	}

	public function download()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');
		
		$writer = new Xlsx($spreadsheet);

		$filename = 'testing';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		
		$writer->save('php://output');

	}
}
