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
		$bulanLaporan = $this->request->getPost('bulan');
		//var_dump($this->m_user->getReportPresensi($bulanLaporan));
		//return $this->m_user->getReportPresensi($bulanLaporan);
		$spreadsheed = new Spreadsheet();
		$sheet = $spreadsheed->getActiveSheet();
		//$objResult = json_decode($this->m_user->getReportPresensi($bulanLaporan));
		//var_dump($objResult);
	}
}
?>