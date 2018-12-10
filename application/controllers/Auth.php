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

	public function ajaxDashboard(){
		$this->load->model('AjaxModel');  
        $fetch_data = $this->AjaxModel->make_datatables($_POST['type'],$_POST['status_ap'],$_POST['location_type']);  
        $data = array();  
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();  
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->id.'</a>';  
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->merk.'</a>';  
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->type.'</a>'; 
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->sn.'</a>'; 
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->mac_address.'</a>'; 
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->status_ap.'</a>';  
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->location_type.'</a>';
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->last_update_by.'</a>';
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->last_update.'</a>'; 
            $sub_array[] = 	'<button type="button" name="update" id="'.$row->id.'" class="btn btn-primary btn-sm">Ubah</button>'.
            				'&nbsp'.
            				'<button type="button" name="update" id="'.$row->id.'" data-toggle="modal" data-target="#myModal'.$row->id.'"class="btn btn-danger btn-sm">Hapus</button>'.
	            				'<div class="modal fade" id="myModal'.$row->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	                        <div class="modal-dialog" role="document">
	                          <div class="modal-content">
	                            <div class="modal-header">
	                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                              <h4 class="modal-title" id="myModalLabel">Peringatan</h4>
	                            </div>
	                            <div class="modal-body">
	                              Apakah anda yakin akan menghapus data tersebut ?
	                            </div>
	                            <div class="modal-footer">
	                              <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
	                              <a href="'.base_url('index.php/crud/delete/'.$row->id).'"><button type="button" class="btn btn-danger">Hapus</button></a>
	                            </div>
	                          </div>
	                        </div>
	                      </div>'.
	                      '<div class="modal fade bs-example-modal-lg" id="detailModal'.$row->id.'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">Detail Access Point</h4>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Merk</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->merk.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Tipe</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->type.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Serial Number</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->sn.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Mac Address</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->mac_address.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Status AP</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->status_ap.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Paket AP</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->site_id.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Location Type</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->location_type.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Customer</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->customer.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->alamat.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Skema Bisnis</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->skema_bisnis.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">SSID</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->ssid.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Posisi AP</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->keterangan.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Tahun Aktif</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->tanggal_aktif.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Bulan Aktif</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->no_order.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">STO</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->sto.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">No Inet</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->no_inet.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">LME</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->lme.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Investasi</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->investasi.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Last Update By</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->last_update_by.'
                                </div>
                              </div>
                            </div>

                            <div class="modal-footer">
                              
                            </div>
                          </div>
                        </div>
                      </div>';  
            // $sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs">Delete</button>';  
            $data[] = $sub_array;  
        }  
        $output = array(  
            "draw"              =>     intval($_POST["draw"]),  
            "recordsTotal"      =>      $this->AjaxModel->get_all_data(),  
            "recordsFiltered"   =>     $this->AjaxModel->get_filtered_data($_POST['type'],$_POST['status_ap'],$_POST['location_type']),  
            "data"              =>     $data  
        );  
        echo json_encode($output);  
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
