<script>
  window.js_base_url = "<? echo base_url(); ?>" + "/index.php/";
  var id_pegawai = "<? echo session("id_pegawai"); ?>";
  var nm_jabatan = "<? echo session("nm_jabatan"); ?>";
  var lv_jabatan = "<? echo session("level_jabatan"); ?>";
  var no_unit = "<? echo session("no"); ?>";
  var id_divisi = "<? echo session("id_divisi"); ?>";
  
  const bulan = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGT", "SEP", "OKT", "NOV", "DES"];

  const formatOptions = {maximumFractionDigits: 2, minimumFractionDigits: 2};
  const formatting = new Intl.NumberFormat('id-UK', formatOptions);

  /******* COMPONENT DECLARATIONS ********/
  var $cbxAsalDokumen, cbxAsalDokumen;
  var $cbxSubAsalDokumen, cbxSubAsalDokumen;
  var $cbxJenisDokumen, cbxJenisDokumen;
  var $cbxTujuanDokumen, cbxTujuanDokumen;
  var $cbxTujuanDispo, cbxTujuanDispo;
  var $cbxDispoSurat, cbxDispoSurat;
  var $cbxDispoTurun, cbxDispoTurun;
  var $inputSubmitFlag = $("#status_submit");
  var $btnSubmit = $("#btnSubmit");
  var $catatanDispo = $("#catatan_dispo_turun");
  var $formDispo = $("#form_dispo");
  var $formErrMsg = $("#form_err_msg");
  //var lv_tujuan = ((lv_jabatan == "BOD-1") ? "BOD-2" : "BOD-3");
  var lv_tujuan = "";
  switch(lv_jabatan) {
    case "BOD-1":
      lv_tujuan = "BOD-2";
      break;
    case "BOD-2":
      lv_tujuan = "BOD-3";
      break;
  }
  var valResultDispoSurat = $("#res_dispo_surat");
  var valResultDispoTurun = $("#res_dispo_turun");
  var valArrTujuanDispo = $("#arr_tujuan_dispo");
  var btnViewSurat = $("#btn_view_surat");

  
  function defaultLoad(){
    //set status surat menjadi process saat berhasil di-buka
    setDispoStatus();
    loadDataSurat();
  }
  
  function setDispoStatus(){
    var status_disposisi = $("#status_disposisi");
    if(status_disposisi.val() === "1"){
      $.ajax({
        url: js_base_url + "set_status_disposisi",
        type: 'post',
        dataType: 'json',
        data: {
          id_disposisi: $("#id_disposisi").val(),
          status: 2
        },
        success: function(msg){
          $("#newmail_count").text(msg);
        }
      })
    }
  }

  $btnSubmit.on("click", function (evt){
    evt.preventDefault();
    var valTujuanDispo = $cbxTujuanDispo.val();
    var valDispo = $cbxDispoTurun.val();
    var valCatatanDispo = $catatanDispo.val();
    var idSurat = $("#id_surat").val();
    var idDisposisi = $("#id_disposisi").val();
    var arrSubmitDispo = new Array();
    var errMsg = "";
    if(valTujuanDispo.length < 1 || valDispo.length < 1){
      $formErrMsg.css('display', '');
      if(valTujuanDispo.length < 1) errMsg = "<li>Tujuan disposisi harus ada!</li>";
      if(valDispo.length < 1 ) errMsg = errMsg + "<li>Disposisi harus ada!</li>";
      $formErrMsg.empty();
      $formErrMsg.append(errMsg);
    } else {
      $formErrMsg.empty();
      $formErrMsg.css('display', 'none');
      //---BUAT ARRAY UNTUK MASING2 TUJUAN DISPOSISI --//
      valTujuanDispo.forEach(function(item, index, arr){
        let dispo = {
          id_surat: idSurat,
          tujuan_dispo: item,
          dispo: JSON.stringify(valDispo),
          catatan_dispo: valCatatanDispo,
          id_disposisi: idDisposisi
        }
        arrSubmitDispo.push(dispo);
      })
      var postData = JSON.stringify(arrSubmitDispo);
      $.ajax({
        url: js_base_url + "dispo_baru",
        type: "post",
        dataType: "json",
        data: {formData: postData},
        success: function(msg){
          if(msg == "SUCCESS"){
            alert("Disposisi telah tersimpan.");
            window.location.href = js_base_url + "surat_masuk";
          }
        }
      })
    }
  })

  
  function loadDataSurat(){
    //console.log(JSON.parse(valArrTujuanDispo.val()));
    //console.log(valResultDispoSurat.val());
  }

  $.ajax({
    url: js_base_url + 'C_mail/tujuan_disposisi',
    type: 'GET',
    data: {'level_jabatan': lv_tujuan, 'unit':no_unit, 'id_divisi' : id_divisi},
    dataType: 'json',
    success: function(response){
      $cbxTujuanDispo = $("#tujuan_dispo").selectize({
        valueField: 'id_pegawai',
        labelField: 'label_opsi',
        sortField: 'label_opsi',
        searchField: 'label_opsi',
        create: false,
        maxItems: null,
        placeholder: 'Pilih tujuan disposisi..',
        options: response
      })
      cbxTujuanDispo = $cbxTujuanDispo[0].selectize;
      let arr_dispo = JSON.parse(valArrTujuanDispo.val());
      if(arr_dispo.length > 0){
        cbxTujuanDispo.setValue(arr_dispo);
      }
    }
  })

  $.ajax({
    url: js_base_url + 'C_mail/list_disposisi',
    type: 'GET',
    dataType: 'json',
    success: function(response){
      $cbxDispoSurat = $("#dispo_surat").selectize({
        valueField: 'id_list_disposisi',
        labelField: 'nm_disposisi',
        sortField: 'nm_disposisi',
        searchField: 'nm_disposisi',
        create: false,
        maxItems: null,
        placeholder: 'Pilih disposisi..',
        options: response
      })
      cbxDispoSurat = $cbxDispoSurat[0].selectize;
      let arr_tujuan_dispo = JSON.parse(valArrTujuanDispo.val());
      let arr_dispo = JSON.parse(valResultDispoSurat.val());
      if(arr_tujuan_dispo.length > 0){
        cbxTujuanDispo.setValue(arr_tujuan_dispo);
      }
      if(arr_dispo.length > 0){
        cbxDispoSurat.setValue(arr_dispo);
      }
    }
  })

  $.ajax({
    url: js_base_url + 'C_mail/list_disposisi',
    type: 'GET',
    dataType: 'json',
    success: function(response){
      $cbxDispoTurun = $("#dispo_turun").selectize({
        valueField: 'id_list_disposisi',
        labelField: 'nm_disposisi',
        sortField: 'nm_disposisi',
        searchField: 'nm_disposisi',
        create: false,
        maxItems: null,
        placeholder: 'Pilih disposisi..',
        options: response
      })
      cbxDispoTurun = $cbxDispoTurun[0].selectize;
      if(valResultDispoSurat.val() !== ""){
        cbxDispoTurun.setValue(JSON.parse(valResultDispoTurun.val()));
      }
    }
  })

/*
  $.ajax({
    url: js_base_url + "C_mail/getAsalDokumen",
    type: 'GET',
    dataType: 'json',
    success: function(response){
      //console.log(response);
      var isian = response;
      $cbxAsalDokumen = $("#asal_dokumen").selectize({
        valueField: "id_asal_dokumen",
        labelField: "nm_asal_dokumen",
        sortField: "id_asal_dokumen",
        searchField: "nm_asal_dokumen",
        maxItems: 1,
        create: false,
        placeholder: "Pilih asal dokumen..",
        options: isian,
        onChange: function(value){
          cbxSubAsalDokumen.disable();
          cbxSubAsalDokumen.clear();
          cbxSubAsalDokumen.clearOptions();
          $.ajax({
            url: js_base_url + 'C_mail/getSubAsalDokumen',
            type: 'GET',
            dataType: 'json',
            data: 'id_asal=' + value,
            success: function(response){
              //console.log(response);
              cbxSubAsalDokumen.enable();
              cbxSubAsalDokumen.load(function (callback){
                callback(response);
              })
            }
          })
        }
      })
      cbxAsalDokumen = $cbxAsalDokumen[0].selectize;
      cbxSubAsalDokumen.disable();
      loadDataSurat();
    }
  })
*/

  function convertArrayToNumber(arrToConvert){
    if (Array.isArray(arrToConvert)){
      var arrResult = [];
      for (var i = 0; i < arrToConvert.length; i++){
        if (arrToConvert[i] !== null){
          arrResult[i] = parseFloat(parseFloat(arrToConvert[i]).toFixed(2));
        } else {
          arrResult[i] = null;
        }
      }
      return arrResult;
    } else {
      return null;
    }
  }
</script>

<script>
  function appendLeadingZeroes(n){
    if (n <= 9){
      return "0" + n;
    }
    return n;
  }
</script>
