<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Xlsx;

class Laporan extends CI_Controller {

	public function index(){
		$data['allApCount'] = $this->getAPCount();
		$data['ciscoSummary'] = $this->getSummaryCisco();
		$data['huaweiSummary'] = $this->getSummaryHuawei();
		$this->load->view('laporan_page',$data);
	}

	private function getAPCount(){
		$dataCisco = $this->db->query('SELECT COUNT(id) FROM access_point WHERE merk="CISCO" AND location_type="Store"',FALSE)->result_array();
		$this->db->reset_query();
		$dataHuawei = $this->db->query('SELECT COUNT(id) FROM access_point WHERE merk="HUAWEI" AND location_type="Store"',FALSE)->result_array();
		$allAPCount['cisco'] = $dataCisco[0]['COUNT(id)'];
		$allAPCount['huawei'] = $dataHuawei[0]['COUNT(id)'];
		return $allAPCount;
	}

	private function getSummaryCisco(){
		$dataBaik = $this->db->query('SELECT COUNT(id) FROM access_point WHERE merk="CISCO" AND status_ap="Baik" AND location_type="Store"')->result_array();
		$this->db->reset_query();
		$dataRusak = $this->db->query('SELECT COUNT(id) FROM access_point WHERE merk="CISCO" AND status_ap="Rusak" AND location_type="Store"')->result_array();
		$this->db->reset_query();
		$dataUnknown = $this->db->query('SELECT COUNT(id) FROM access_point WHERE merk="CISCO" AND status_ap="Unknown" AND location_type="Store"')->result_array();

		$data['baik'] = $dataBaik[0]['COUNT(id)'];
		$data['rusak'] = $dataRusak[0]['COUNT(id)'];
		$data['unknown'] = $dataUnknown[0]['COUNT(id)'];

		return $data;
	}

	private function getSummaryHuawei(){
		$dataBaik = $this->db->query('SELECT COUNT(id) FROM access_point WHERE merk="HUAWEI" AND status_ap="Baik" AND location_type="Store"')->result_array();
		$this->db->reset_query();
		$dataRusak = $this->db->query('SELECT COUNT(id) FROM access_point WHERE merk="HUAWEI" AND status_ap="Rusak" AND location_type="Store"')->result_array();
		$this->db->reset_query();
		$dataUnknown = $this->db->query('SELECT COUNT(id) FROM access_point WHERE merk="HUAWEI" AND status_ap="Unknown" AND location_type="Store"')->result_array();

		$data['baik'] = $dataBaik[0]['COUNT(id)'];
		$data['rusak'] = $dataRusak[0]['COUNT(id)'];
		$data['unknown'] = $dataUnknown[0]['COUNT(id)'];

		return $data;	
	}
}
