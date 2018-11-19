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
		$sheet->setCellValue('F1', 'Drop');			
		$sheet->setCellValue('G1', 'Tanggal Drop');
		$sheet->setCellValue('H1', 'Status AP');
		$sheet->setCellValue('I1', 'Location Type');
		$sheet->setCellValue('J1', 'Customer');
		$sheet->setCellValue('K1', 'Alamat');
		$sheet->setCellValue('L1', 'Skema Bisnis');
		$sheet->setCellValue('M1', 'SSID');
		$sheet->setCellValue('N1', 'Posisi AP');
		$sheet->setCellValue('O1', 'Tahun Aktif');
		$sheet->setCellValue('P1', 'Bulan Aktif');
		$sheet->setCellValue('Q1', 'STO');
		$sheet->setCellValue('R1', 'No Inet');
		$sheet->setCellValue('S1', 'Last Update');

		$sheet->setCellValue('A'.'2','testing');

		$accessPoints = $this->db->get('access_point')->result_array();
		
		for($i=1;$i<=count($accessPoints);$i++){
			$z=$i+1;

			$sheet->setCellValue('A'.$z,$accessPoints[$i-1]['id']);
			$sheet->setCellValue('B'.$z,$accessPoints[$i-1]['merk']);
			$sheet->setCellValue('C'.$z,$accessPoints[$i-1]['type']);
			$sheet->setCellValue('D'.$z,$accessPoints[$i-1]['sn']);
			$sheet->setCellValue('E'.$z,$accessPoints[$i-1]['mac_address']);
			$sheet->setCellValue('F'.$z,$accessPoints[$i-1]['drop_from']);
			$sheet->setCellValue('G'.$z,$accessPoints[$i-1]['tgl_drop']);
			$sheet->setCellValue('H'.$z,$accessPoints[$i-1]['status_ap']);
			$sheet->setCellValue('I'.$z,$accessPoints[$i-1]['location_type']);
			$sheet->setCellValue('J'.$z,$accessPoints[$i-1]['customer']);
			$sheet->setCellValue('K'.$z,$accessPoints[$i-1]['alamat']);
			$sheet->setCellValue('L'.$z,$accessPoints[$i-1]['skema_bisnis']);
			$sheet->setCellValue('M'.$z,$accessPoints[$i-1]['ssid']);
			$sheet->setCellValue('N'.$z,$accessPoints[$i-1]['posisi_ap']);
			$sheet->setCellValue('O'.$z,$accessPoints[$i-1]['tahun_aktif']);
			$sheet->setCellValue('P'.$z,$accessPoints[$i-1]['bulan_aktif']);
			$sheet->setCellValue('Q'.$z,$accessPoints[$i-1]['sto']);
			$sheet->setCellValue('R'.$z,$accessPoints[$i-1]['no_inet']);
			$sheet->setCellValue('S'.$z,$accessPoints[$i-1]['last_update']);

		}
		
		$writer = new Xlsx($spreadsheet);

		$filename = 'Data_acces_point_'.date("d-m-Y").'_'.date("h:i:sa");

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		
		$writer->save('php://output');

	}

	public function importPage(){
		$this->load->view('import_page');
	}

	public function upload(){

		$date = new DateTime();


		$config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'xls|xlsx|csv';
        $config['max_size']             = 2000;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $config['file_name']			= $date->getTimestamp();
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
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
							'drop_from' => $sheetData[$i][5],
							'tgl_drop' => $sheetData[$i][6],
							'status_ap' => $sheetData[$i][7],
							'location_type' => $sheetData[$i][8],
							'customer' => $sheetData[$i][9],
							'alamat' => $sheetData[$i][10],
							'skema_bisnis' => $sheetData[$i][11],
							'ssid' => $sheetData[$i][12],
							'posisi_ap' => $sheetData[$i][13],
							'tahun_aktif' => $sheetData[$i][14],
							'bulan_aktif' => $sheetData[$i][15],
							'sto' => $sheetData[$i][16],
							'no_inet' => $sheetData[$i][17],
						);
				$last_id++;
        	}
        	// var_dump($data_batch);
        	$this->db->insert_batch('access_point',$data_batch);
        	// redirect('auth');
        }
	}
}