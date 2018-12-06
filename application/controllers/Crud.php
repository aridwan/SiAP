<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Xlsx;

class Crud extends CI_Controller {

	public function index(){
		
	}

	public function create(){
		if(isset($_SESSION['username'])){
			$this->load->view('create_page');
		} else {
			$this->load->view('forbidden_page');
		}
	}

	public function insert(){
		$count_sn = count($this->db->query('SELECT * FROM access_point WHERE sn="'.$_POST['serial_number'].'"')->result_array());
		if ($count_sn > 0){
			$error['error'] = "Serial number sudah digunakan." ;
			$this->load->view('create_page',$error);
		} else {
			$last_row=$this->db->select('id')->order_by('id',"desc")->limit(1)->get('access_point')->row();
			$data = array(
						'id' => $last_row->id+1,
						'merk' => $_POST['merk'],
						'type' => $_POST['tipe'],
						'sn' => $_POST['serial_number'],
						'mac_address' => $_POST['mac_address'],
						'status_ap' => $_POST['status_ap'],
						'site_id' => $_POST['site_id'],
						'location_type' => $_POST['location_type'],
						'customer' => $_POST['customer'],
						'alamat' => $_POST['alamat'],
						'skema_bisnis' => $_POST['skema_bisnis'],
						'ssid' => $_POST['ssid'],
						'keterangan' => $_POST['keterangan'],
						'tanggal_aktif' => $_POST['tanggal_aktif'],
						'no_order' => $_POST['no_order'],
						'sto' => $_POST['sto'],
						'no_inet' => $_POST['no_inet'],
						'lme' => $_POST['lme'],
						'investasi' => $_POST['investasi']
					);
			$this->db->insert('access_point',$data);
			redirect('auth/index');
		}
	}

	public function edit($id){
		if(isset($_SESSION['username'])){
			$this->db->where('id',$id);
			$data = $this->db->get('access_point')->row();
			$this->load->view('edit_page',$data);
		} else {
			$this->load->view('forbidden_page');
		}
	}

	public function update($id){
			$this->db->where('id',$id);
			$timestamps = new DateTime();
			$data = array(
						'merk' => $_POST['merk'],
						'type' => $_POST['tipe'],
						'sn' => $_POST['serial_number'],
						'mac_address' => $_POST['mac_address'],
						'status_ap' => $_POST['status_ap'],
						'site_id' => $_POST['site_id'],
						'location_type' => $_POST['location_type'],
						'customer' => $_POST['customer'],
						'alamat' => $_POST['alamat'],
						'skema_bisnis' => $_POST['skema_bisnis'],
						'ssid' => $_POST['ssid'],
						'keterangan' => $_POST['keterangan'],
						'tanggal_aktif' => $_POST['tanggal_aktif'],
						'no_order' => $_POST['no_order'],
						'sto' => $_POST['sto'],
						'no_inet' => $_POST['no_inet'],
						'lme' => $_POST['lme'],
						'investasi' => $_POST['investasi'],
						'last_update_by' => $_SESSION['username']['nama'],
						'last_update' => $timestamps->format('d-m-Y H:i:s')
					);
			$this->db->update('access_point',$data);
			redirect('auth/index');
	}

	public function delete($id)
	{
		
		$this->db->where('id',$id);
		$this->db->delete('access_point');
		redirect('auth/index');
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
