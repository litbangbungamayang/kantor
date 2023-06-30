<?php

namespace App\Controllers;

use Config\Services;

class C_petak_kebun extends BaseController
{
	public function cekRole($request){
		return $this->m_user->cekRole(array($request));
	}

	public function front(){
		if ($this->session->has('username') == true){
			return view('list_petak');
		} else {
			return redirect('login');
		}
	}

	public function listAllPetakByPegawai(){
		if ($this->session->has('username') == true){
			$params = array(
				"id_pegawai" => session('id_pegawai')
			);
			return json_encode($this->m_petakKebun->listAllPetakByPegawai($params));
		}
	}
}
?>