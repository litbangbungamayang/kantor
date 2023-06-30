<?php

namespace App\Models;

use CodeIgniter\Model;

class M_PetakKebun extends Model{

  private $buma_env = "http://simpgbuma.ptpn7.com/index.php/api_bcn/";
  private $cima_env = "http://simpgcima.ptpn7.com/index.php/api_bcn/";
  private $lokal = "http://localhost/simpgbuma/api_bcn/";


  public function getServer($pg){
    $server_pg = null;
    switch($pg){
      case "buma":
        $server_pg = $this->buma_env;
        break;
      case "cima":
        $server_pg = $this->cima_env;
        break;
      case "lokal":
        $server_pg = $this->lokal;
        break;
    }
    return $server_pg;
  }

  public function getDataLuas($request){
    $pg = $request["pg"];
    $kepemilikan = $request["tstr"];
    $tahun_giling = $request["tahun_giling"];
    $query = "select sum(ptk.luas_ha) as luas from tbl_petak ptk where mature=? and kepemilikan=? and kode_plant=?";
    $arg = [$tahun_giling, $kepemilikan, $pg];
    //var_dump($request); die();
    return json_encode($this->db->query($query, $arg)->getResult());
  }

  public function getGroupingLuas($tahun_giling){
    $query = "select kode_plant, kepemilikan, sum(luas_ha) as luas from tbl_petak
              where mature=? group by kode_plant, kepemilikan";
    return json_encode($this->db->query($query, [$tahun_giling])->getResult());
  }

  public function getUnit($params){
    $tahun_giling = $params["tahun_giling"];
    $comp_code = $params["comp_code"];
    $query = "select kode_plant from tbl_petak where mature=? and company_code=? group by kode_plant";
    $arg = [$tahun_giling, $comp_code];
    return json_encode($this->db->query($query, $arg)->getResult());
  }

  public function getAllPetak($params){
    $tahun_giling = $params["tahun_giling"];
    $pg = $params["pg"];
    $query = "select
      id_field, ptk.kode_blok, kode_plant, divisi, deskripsi_blok,
      FORMAT(luas_tanam,2) as luas_tanam, periode, status_blok, vart.nama_varietas, ptk.kepemilikan, ptk.mature
      from tbl_petak ptk
      	join tbl_varietas vart on ptk.kode_varietas = vart.id_varietas
      where ptk.mature=? and kode_plant like ?";
    $arg = [$tahun_giling, "%".$pg."%"];
    return json_encode($this->db->query($query, $arg)->getResult());
  }

  public function getDetailPetak($params){
    $query = "select
      id_field, ptk.kode_blok, kode_plant, divisi, deskripsi_blok, divisi,
      luas_tanam, periode, status_blok, vart.nama_varietas, ptk.kepemilikan,
      ptk.mature,
      (case
          when ptk.kepemilikan = 'TS-HG' then mid(ptk.kode_blok,9,1)
          when ptk.kepemilikan = 'TR-KR' then 'TR'
          else divisi
      end) as wilayah,
      (case
        when kode_plant = '7TK1' then 'BUNGAMAYANG'
        else 'CINTA MANIS'
      end) as nama_unit
      from tbl_petak ptk
      	join tbl_varietas vart on ptk.kode_varietas = vart.id_varietas
      where ptk.kode_blok=?";
    $arg = [$params["kode_blok"]];
    return json_encode($this->db->query($query, $arg)->getResult());
  }

  public function getAnalisaKemasakanFromKodePetak($params){
    $query = "
      select
        ankem.kode_petak,
        ankem.ronde,
        ankem.tgl_analisa,
        avg(ankem.rata_panjang) as panjang,
        avg(ankem.rata_ruas) as ruas,
        avg(ankem.rata_diameter) as diameter,
        avg(ankem.kg_per_meter) as kgPerMeter,
        avg(ankem.fk) as fk,
        avg(ankem.kp) as kp,
        avg(ankem.kdt) as kdt
      from tbl_ltb_dataankem ankem
      join tbl_petak ptk on ankem.kode_petak = ptk.kode_blok
      where ptk.kode_blok=?
      group by ankem.ronde, ankem.kode_petak
      order by ankem.ronde
    ";
    $arg = [$params["kode_blok"]];
    return json_encode($this->db->query($query, $arg)->getResult());
  }

  public function getTaksasiFromKodePetak($params){
    $query = "select
        ptk.kode_blok, taks.jenis_taksasi, taks.taksasi_ton_tebu, taks.taksasi_protas,
        taks.tgl_taksasi
      from tbl_taksasi_kebun taks
        join tbl_petak ptk on taks.kode_blok = ptk.kode_blok
      where ptk.kode_blok = ?";
    $arg = [$params["kode_blok"]];
    return json_encode($this->db->query($query, $arg)->getResult());
  }

  public function getPekerjaanFromKodePetak($params){
    $query =
    "
      select
      	ptk.kode_blok, ptk.deskripsi_blok, subpk.nama_pekerjaan, trs.kuanta_pekerjaan,
        trs.tanggal_input, trs.tanggal_pekerjaan, trs.kode_sub_pekerjaan
      from tbl_transaksi_pekerjaan trs
      	join tbl_petak ptk on trs.kode_blok = ptk.kode_blok
          join tbl_sub_pekerjaan subpk on subpk.kode_pekerjaan = trs.kode_sub_pekerjaan
      where ptk.kode_blok=?
    ";
    $arg = [$params["kode_blok"]];
    return json_encode($this->db->query($query, $arg)->getResult());
  }

  function getDataProduksiPetak($params){
    $pg = "";
    switch (substr($params,0,4)){
      case "7TK1":
        $pg = "buma";
        break;
      case "7TK2":
        $pg = "cima";
        break;
    }
    return ($this->getCurl(array("db_server"=>$this->getServer($pg), "url"=>"getDataTebangPetak?kode_blok=".$params)));
  }

  function getCurl($request){
    $db_server = $request["db_server"];
    $url = str_replace(" ", "", $request["url"]);
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $db_server.$url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache"
      ),
    ));
    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);
    return $response; // output as json encoded
  }

  function serverRequest($pg,$req){
    $server_pg = null;
    switch($pg){
      case "buma":
        $server_pg = $this->buma_env;
        break;
      case "cima":
        $server_pg = $this->cima_env;
        break;
      case "lokal":
        $server_pg = $this->lokal;
        break;
    }
    $request = array("db_server"=>$server_pg, "url"=>$req);
    return ($this->getCurl($request));
  }

}
