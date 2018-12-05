<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Xlsx;

class Excel extends CI_Controller {

	public function exportToServer()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');
		
		$writer = new Xlsx($spreadsheet);

		$filename = 'testing.xlsx';

		$writer->save($filename);

	}

	public function export()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Merk');
		$sheet->setCellValue('C1', 'Tipe');
		$sheet->setCellValue('D1', 'Serial Number');
		$sheet->setCellValue('E1', 'Mac Address');
		$sheet->setCellValue('F1', 'Status AP');			
		$sheet->setCellValue('G1', 'Paket AP');
		$sheet->setCellValue('H1', 'Location Type');
		$sheet->setCellValue('I1', 'Customer');
		$sheet->setCellValue('J1', 'Alamat');
		$sheet->setCellValue('K1', 'Skema Bisnis');
		$sheet->setCellValue('L1', 'SSID');
		$sheet->setCellValue('M1', 'Posisi AP');
		$sheet->setCellValue('N1', 'Tahun Aktif');
		$sheet->setCellValue('O1', 'Bulan Aktif');
		$sheet->setCellValue('P1', 'STO');
		$sheet->setCellValue('Q1', 'No Inet');
		$sheet->setCellValue('R1', 'Last Update');

		$sheet->setCellValue('A'.'2','testing');

		$accessPoints = $this->db->get('access_point')->result_array();
		
		for($i=1;$i<=count($accessPoints);$i++){
			$z=$i+1;

			$sheet->setCellValue('A'.$z,$accessPoints[$i-1]['id']);
			$sheet->setCellValue('B'.$z,$accessPoints[$i-1]['merk']);
			$sheet->setCellValue('C'.$z,$accessPoints[$i-1]['type']);
			$sheet->setCellValue('D'.$z,$accessPoints[$i-1]['sn']);
			$sheet->setCellValue('E'.$z,$accessPoints[$i-1]['mac_address']);			
			$sheet->setCellValue('F'.$z,$accessPoints[$i-1]['status_ap']);
			$sheet->setCellValue('G'.$z,$accessPoints[$i-1]['site_id']);
			$sheet->setCellValue('H'.$z,$accessPoints[$i-1]['location_type']);
			$sheet->setCellValue('I'.$z,$accessPoints[$i-1]['customer']);
			$sheet->setCellValue('J'.$z,$accessPoints[$i-1]['alamat']);
			$sheet->setCellValue('K'.$z,$accessPoints[$i-1]['skema_bisnis']);
			$sheet->setCellValue('L'.$z,$accessPoints[$i-1]['ssid']);
			$sheet->setCellValue('M'.$z,$accessPoints[$i-1]['keterangan']);
			$sheet->setCellValue('N'.$z,$accessPoints[$i-1]['tanggal_aktif']);
			$sheet->setCellValue('O'.$z,$accessPoints[$i-1]['no_order']);
			$sheet->setCellValue('P'.$z,$accessPoints[$i-1]['sto']);
			$sheet->setCellValue('Q'.$z,$accessPoints[$i-1]['no_inet']);
			$sheet->setCellValue('R'.$z,$accessPoints[$i-1]['last_update']);

		}
		
		$writer = new Xlsx($spreadsheet);

		$filename = 'Data_acces_point_'.date("d-m-Y").'_'.date("h:i:sa");

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		
		$writer->save('php://output');

	}

	public function importPage(){
		if(isset($_SESSION['username'])){
			$this->load->view('import_page');
		} else {
			$this->load->view('forbidden_page');
		}
	}

	public function upload(){

		$date = new DateTime();


		$config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'xls|xlsx|csv';
        $config['max_size']             = 2048;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $config['file_name']			= $date->getTimestamp();
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('import_page', $error);
        }
        else
        {
        	$inputFileType = 'Xlsx';
        	$inputFileName = './uploads/'.$config['file_name'].'.xlsx';

        	$reader = IOFactory::createReader($inputFileType);
        	$reader->setReadDataOnly(true);
        	$spreadsheet = $reader->load($inputFileName);

        	$sheetData = $spreadsheet->getActiveSheet()->toArray(null,true);
        	$shifted = array_shift($sheetData);
        	// print_r($sheetData);
        	// print_r($shifted);
				$last_row=$this->db->select('id')->order_by('id',"desc")->limit(1)->get('access_point')->row();
				$last_id = 0;
				if(isset($last_row)){
					$last_id = $last_row->id+1;
				} else {
					$last_id = 1;
				}
        		// print_r($last_id);
        	// insert to DB
        		$data_batch = array();
        	for($i=0;$i<count($sheetData);$i++){
				$data_batch[] = array(
							'id' => $last_id,
							'merk' => $sheetData[$i][1],
							'type' => $sheetData[$i][2],
							'sn' => $sheetData[$i][3],
							'mac_address' => $sheetData[$i][4],
							'status_ap' => $sheetData[$i][5],
							'site_id' => $sheetData[$i][6],
							'location_type' => $sheetData[$i][7],
							'customer' => $sheetData[$i][8],
							'alamat' => $sheetData[$i][9],
							'skema_bisnis' => $sheetData[$i][10],
							'ssid' => $sheetData[$i][11],
							'keterangan' => $sheetData[$i][12],
							'tanggal_aktif' => $sheetData[$i][13],
							'no_order' => $sheetData[$i][14],
							'sto' => $sheetData[$i][15],
							'no_inet' => $sheetData[$i][16],
						);
				$last_id++;
        	}
        	// print_r($data_batch);
        	
        	$ex = $this->db->insert_batch('access_point',$data_batch);
        	
        	// print_r($ex);
        	redirect('auth');
        }
	}
}
