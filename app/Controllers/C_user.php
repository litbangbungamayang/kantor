<?php

namespace App\Controllers;
require 'vendor/autoload.php';

use Config\Services;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_user extends BaseController
{
	public function cekRole($request){
		return $this->m_user->cekRole(array($request));
	}

	public function presensi(){
		//module_id = 1
		if ($this->session->has('username') == true){
			return view('presensi');
		} else {
			return redirect('login');
		}
	}

	public function inbox(){
		if ($this->session->has('username') == true){
			$unread = $this->m_surat->cek_unread();
			$this->session->set('inbox_count', $unread);
			return view('inbox');
		} else {
			return redirect('login');
		}
	}

	public function inbox_list(){
		if ($this->session->has('username') == true){
			return view('inbox_list');
		} else {
			return redirect('login');
		}
	}

	public function upload_mail(){
		if ($this->session->has('username') == true){
			return view('upload_mail');
		} else {
			return redirect('login');
		}
	}

	public function profil(){
		if($this->session->has('username') == true){
			return view('profil');
		} else {
			return redirect('login');
		}
	}

	public function cekLokasi(){
		$lat = $this->request->getGet('lat');
		$lon = $this->request->getGet('lon');
		$acc = $this->request->getGet('acc');
		$dl = $this->request->getGet('dl');
		return json_encode($this->m_user->cekLokasi(array('lat'=>$lat, 'lon'=>$lon, 'kdunit'=>session('kd_unit'), 'acc'=>$acc, 'dl'=>$dl)));
	}

	public function cekPresensi(){
		$id_pegawai = session('id_pegawai');
		$tgl_absen = date('Y-m-d');
		$request = array(
			'id_pegawai'=>$id_pegawai,
			'tgl_absen'=>$tgl_absen
		);
		return json_encode($this->m_user->cekPresensi($request));
	}

	private function tanggal_bulan($month, $year){
		$num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$dates_month = array();

		for ($i = 1; $i <= $num; $i++) {
			$mktime = mktime(0, 0, 0, $month, $i, $year);
			$date = date("Y-m-d", $mktime);
			$dates_month[$i] = $date;
		}

		return $dates_month;
	}

	public function getReportPresensi(){
		$bulanLaporan = $this->request->getGet('bulan');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$objResult = json_decode($this->m_user->getReportPresensi($bulanLaporan));
		/*
		$jmlBaris = sizeof($objResult);
		$jmlKolom = sizeof((array)$objResult[0]);
		for($kolom = 1; $kolom <= $jmlKolom; $kolom++){
			for($baris = 1; $baris <= $jmlBaris; $baris++){
				$arKolom = (array)$objResult[$baris-1];
				$sheet->setCellValue([$kolom, $baris],($arKolom[$kolom-1]));
			}
		}
		$sheet->setCellValue('A1', 'HORE');
		$writer = new Xlsx($spreadsheet);
		$writer->save('Laporan.xlsx');
		*/
		
		$data = (array)$objResult;
		$data_kolom = (array)$objResult[0];
		// (3) SET CELL VALUE
		// set header
		for($i = 0; $i < sizeof($data_kolom); $i++){
		$nama_kolom = array_keys($data_kolom);
		$sheet->setCellValueByColumnAndRow($i+1, 1, $nama_kolom[$i]);
		}
		//set isi
		for($baris = 0; $baris < sizeof($data); $baris++){
			for($kolom = 0; $kolom < sizeof($data_kolom); $kolom++){
				$nama_kolom = array_keys($data_kolom);
				$isi = ((array)$data[$baris]);
				$sheet->setCellValueByColumnAndRow($kolom+1,$baris+2,$isi[$nama_kolom[$kolom]]);
			}
		}
		//$temp_file = tempnam(sys_get_temp_dir(), 'GeneratedFile');
		$temp_file = tempnam(WRITEPATH.'uploads/', 'LaporanPresensi_');
		$temp_file = $temp_file.'.xlsx';
		$writer = new Xlsx($spreadsheet);
		$writer->save($temp_file);
		header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($temp_file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($temp_file));
        ob_clean();
        flush();
        readfile($temp_file);
		/*
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$temp_file.'"');
		header('Cache-Control: max-age=0');
		ob_clean();
		flush();
		readfile($temp_file);
		*/
		//return json_encode('Laporan OK');
		exit;
	}
}
?>