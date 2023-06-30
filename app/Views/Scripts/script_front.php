<script>
  window.js_base_url = "<? echo base_url(); ?>" + "/index.php/";
  
  const bulan = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGT", "SEP", "OKT", "NOV", "DES"];

  const formatOptions = {maximumFractionDigits: 2, minimumFractionDigits: 2};
  const formatting = new Intl.NumberFormat('id-UK', formatOptions);

  var data_dokumen = '';
  var data_disposisi = '';


  

  var tbl = $("#tbl_petak").DataTable({
    'select' : 'single',
    'data': '',
    columns : [
      {
        data: "kode_blok",
      },
      {
        data:"",
        render: function(data, type, row, meta){
          /*
          status_dokumen = '';
          if(typeof row['id_disposisi'] !== 'undefined'){
            switch(row['status_disposisi']){
              case '1':
                status_dokumen = icon_unread + " Belum dibaca";
                break;
              case '2':
                status_dokumen = icon_read + " Sudah dibaca";
                break;
              case '3':
                status_dokumen = icon_disposisi + " Sudah terdisposisi";
                break;
            }
          } else {
            switch(row['status_dokumen']){
              case '1':
                status_dokumen = icon_unread + " Belum dibaca";
                break;
              case '2':
                status_dokumen = icon_read + " Sudah dibaca";
                break;
              case '3':
                status_dokumen = icon_disposisi + " Sudah terdisposisi";
                break;
            }
          }
          */
          return row['deskripsi_blok'];
        }
      },
      {
        data: "",
        render: function(data, type, row, meta){
          $ktg = row['mature'] - 1;
          return $ktg+'/'+row['mature'];
        }
      }
    ],
    'ordering' : false
  });

  /*
  tbl_inbox.on('select', function(e, dt, type, indexes){
    if (type == 'row'){
      var data = tbl_inbox.rows(indexes).data()[0];
      //console.log(data);
      if (data['id_disposisi'] != null){
        window.location.href = window.js_base_url + "baca/disposisi/" + data['id_disposisi'];
      } else {
        window.location.href = window.js_base_url + "baca/" + data['id_surat'];
      }
    }
  });
  */

  $('tbody').css('cursor', 'pointer');
  
  function defaultLoad(){
    /*
    $.getJSON(js_base_url + 'cek_inbox', function(response){
      //console.log(response);
      data_dokumen = response;
      $.getJSON(js_base_url + 'cek_disposisi', function(response){
        console.log(response);
        data_disposisi = response;
        tbl.clear();
        tbl.rows.add(data_dokumen);
        tbl.rows.add(data_disposisi);
        tbl.draw();
        return false;
      })
      return false;
    })
    */
    $.getJSON(js_base_url + 'getAllPetakByPegawai', function(response){
      console.log(response);
      data_petak = response;
      tbl.clear();
      tbl.rows.add(data_petak);
      tbl.draw();
      return false;
    })
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
