<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Xlsx;

class Laporan extends CI_Controller {

	public function index(){
		$data['allApCount'] = $this->getAPCount();
		$data['ciscoSummary'] = $this->getSummaryCisco();
		$data['huaweiSummary'] = $this->getSummaryHuawei();
		$allAP = $this->db->query("SELECT * from access_point where location_type='Store' and status_ap='Baik'")->result_array();
		$data['Cisco1'] = 0;
		$data['Cisco2'] = 0;
		$data['Cisco3'] = 0;
		$data['Cisco4'] = 0;
		$data['Cisco5'] = 0;
		$data['Huawei1'] = 0;
		$data['Huawei2'] = 0;
		$data['null'] = 0;
		foreach ($allAP as $row) {
			if ($row['type'] == "AIR-AP1832I-F-K9"){
				$data['Cisco1']++;
			} else if ($row['type'] == "AIR-CAP3502I-C-K9"){
				$data['Cisco2']++;
			} else if ($row['type'] == "AIR-CAP1602I-C-K9"){
				$data['Cisco3']++;
			} else if ($row['type'] == "AIR-CAP3502E-C-K9"){
				$data['Cisco4']++;
			} else if ($row['type'] == "AIR-CAP1602E-C-K9"){
				$data['Cisco5']++;
			} else if ($row['type'] == "WA201DK-NE"){
				$data['Huawei1']++;
			} else if ($row['type'] == "WA251DT-NE"){
				$data['Huawei2']++;
			} else {
				$data['null']++;
			}
		}
		$this->load->view('laporan_page',$data);
	}

	private function getAPCount(){
		$dataCisco = $this->db->query('SELECT COUNT(id) FROM access_point WHERE merk="CISCO" AND location_type="Store"',FALSE)->result_array();
		$this->db->reset_query();
		$dataHuawei = $this->db->query('SELECT COUNT(id) FROM access_point WHERE merk="HUAWEI" AND location_type="Store"',FALSE)->result_array();
		$this->db->reset_query();
		$dataAllInstalled = $this->db->query('SELECT COUNT(id) FROM access_point WHERE location_type="Installed"',FALSE)->result_array();
		$this->db->reset_query();
		$dataAllProgress = $this->db->query('SELECT COUNT(id) FROM access_point WHERE location_type="Progress"',FALSE)->result_array();
		$this->db->reset_query();
		$dataAllUnknown = $this->db->query('SELECT COUNT(id) FROM access_point WHERE location_type="Unknown"',FALSE)->result_array();
		$this->db->reset_query();
		$dataAllTechnician = $this->db->query('SELECT COUNT(id) FROM access_point WHERE location_type="Carried by Technician"',FALSE)->result_array();
		$this->db->reset_query();
		$dataAll = $this->db->query('SELECT COUNT(id) FROM access_point',FALSE)->result_array();
		$allAPCount['cisco'] = $dataCisco[0]['COUNT(id)'];
		$allAPCount['huawei'] = $dataHuawei[0]['COUNT(id)'];
		$allAPCount['allInstalled'] = $dataAllInstalled[0]['COUNT(id)'];
		$allAPCount['allExisting'] = $dataAll[0]['COUNT(id)'];
		$allAPCount['allProgress'] = $dataAllProgress[0]['COUNT(id)'];
		$allAPCount['allUnknown'] = $dataAllUnknown[0]['COUNT(id)'];
		$allAPCount['allTechnician'] = $dataAllTechnician[0]['COUNT(id)'];
		
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

	public function investasi(){
		$data = $this->db->get('access_point')->result_array();
		$hasil['pt1'] = 0;
		$hasil['pt2'] = 0;
		$hasil['pt3'] = 0;
		$hasil['pt4'] = 0;
		foreach ($data as $row) {
			if($row['lme'] == 'pt1'){
				$hasil['pt1'] += intval($row['investasi']);
			}
			else if($row['lme'] == 'pt2'){
				$hasil['pt2'] += intval($row['investasi']);
			}
			else{
				$hasil['pt3'] += intval($row['investasi']);
			}
		}
		$this->load->view('laporan_investasi_page',$hasil);
	}

}
