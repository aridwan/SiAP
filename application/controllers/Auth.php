<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Xlsx;

class Auth extends CI_Controller {

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

	public function login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$this->db->where('username',$username);
		$this->db->where('password',hash('ripemd160', $password));
		$session = $this->db->get('users')->result_array();
		if (isset($session[0])){
			$this->session->set_userdata(array('username'=>$session[0]));
				$query = $this->db->query('SELECT * FROM access_point');
				$data['hasil'] = $query->result_array();
				$this->load->view('dashboard',$data);
		} else {
			$data['error'] = 'Invalid Account';
			$this->load->view('login_page',$data);
		}
	}

	public function logout(){
		$this->session->unset_userdata('username');
		redirect('auth');
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

	public function change_password(){
		$this->load->view('change_password_page');
	}

	public function update_password(){
		if ($_POST['new_password_repeat'] == $_POST['new_password']){
			$this->db->where('username',$_POST['username']);
			$this->db->where('password',hash('ripemd160', $_POST['old_password']));
			$user = $this->db->get('users')->row_array();
			if (isset($user)){
				$this->db->reset_query();
				$this->db->where('id',$user['id']);
				// print_r($user['password']);
				// echo "<br>";
				// print_r(hash('ripemd160', $_POST['old_password']));
				$data = array(
					'password' => hash('ripemd160', $_POST['new_password'])
				);
				$this->db->update('users',$data);
				redirect('auth',$data);
			} else {
				$data['error'] = 'Username tidak ditemukan atau Password salah';
				$this->load->view('change_password_page',$data);
			}
		} else {
			$data['error'] = 'Ulangi password tidak sama';
			$this->load->view('change_password_page',$data);
		}
	}

	public function filtered() {
			$query = $this->db->query('SELECT * FROM access_point WHERE type LIKE \'%'.$_GET['tipe'].'\' AND status_ap LIKE \'%'.$_GET['status_ap'].'%\' AND location_type LIKE \'%'.$_GET['location_type'].'%\'');
			$data['hasil'] = $query->result_array();
			// print_r($data);
			$this->load->view('dashboard',$data);
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
