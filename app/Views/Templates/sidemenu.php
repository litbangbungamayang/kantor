<!-- side menu -->
<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark hide" id="navbar-to-hide">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark">
      <a href=".">
        <img src="<?php echo base_url('public/assets/logo-white.png');?>" width="220" height="64" alt="Tabler" class="navbar-brand-image">
      </a>
    </h1>
    <div id="test1"></div>
    <? 
      $moduleuser = (session('module_user'));
      $role_md_surat = [];
      foreach($moduleuser as $modul){
        if($modul["nm_module"] === "md_surat"){
          $role_md_surat =  json_decode($modul["role"]);
        }
      }
    ?>
    <h4 id="company_name">PT Buma Cima Nusantara</h4>
    <div class="collapse navbar-collapse" id="navbar-menu">
      <ul class="navbar-nav pt-lg-3">
        <li class="nav-item">
          <a class="nav-link" href="<? echo site_url('/profil'); ?>" >
            <span class="nav-link-title">
              <? echo session('nm_pegawai'); ?>
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url(''); ?>" >
            <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
            </span>
            <span class="nav-link-title">
              Home
            </span>
          </a>
        </li>
        <li class="nav-item" style="">
          <a class="nav-link" href="<?php echo site_url('/presensi');?>" >
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                <rect x="9" y="3" width="6" height="4" rx="2" />
                <path d="M9 17v-5" />
                <path d="M12 17v-1" />
                <path d="M15 17v-3" />
              </svg>
            </span>
            <span class="nav-link-title">
              Presensi 
            </span>
          </a>
        </li>
        <li class="nav-item" style="<? echo session('id_pegawai') != ('7002093' || '7003306') ? 'display:none' : '';?>">
          <a class="nav-link" href="<?php echo site_url('/surat_masuk');?>" >
            <span class="nav-link-icon d-md-echo none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <rect x="3" y="5" width="18" height="14" rx="2" />
                <polyline points="3 7 12 13 21 7" />
              </svg>
            </span>
            <span class="nav-link-title">
              Surat Masuk 
            </span><span class="badge bg-red" style="" id="newmail_count"><? echo session('inbox_count'); ?></span>
          </a>
        </li>
        <li class="nav-item" style="<? echo array_search("operator", $role_md_surat) !== false ? "" : "display:none";?>">
          <a class="nav-link" href="<?php echo site_url('/upload_surat');?>" >
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <line x1="10" y1="14" x2="21" y2="3" />
                <path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" />
              </svg>
            </span>
            <span class="nav-link-title">
              Upload Surat
            </span>
          </a>
        </li>
        <li class="nav-item" style="<? echo array_search("operator", $role_md_surat) !== false ? "" : "display:none";?>">
          <a class="nav-link" href="<?php echo site_url('/daftar_surat_masuk');?>" >
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M9 6l11 0"></path>
                <path d="M9 12l11 0"></path>
                <path d="M9 18l11 0"></path>
                <path d="M5 6l0 .01"></path>
                <path d="M5 12l0 .01"></path>
                <path d="M5 18l0 .01"></path>
              </svg>
            </span>
            <span class="nav-link-title">
              Daftar Surat Masuk
            </span>
          </a>
        </li>
        <li class="nav-item" style="<? echo session('id_pegawai') != 'blabla' ? 'display:none' : 'display:none';?>">
          <a class="nav-link" href="<?php echo site_url('/upload');?>" >
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                <rect x="9" y="3" width="6" height="4" rx="2" />
                <path d="M9 17v-5" />
                <path d="M12 17v-1" />
                <path d="M15 17v-3" />
              </svg>
            </span>
            <span class="nav-link-title">
              Upload
            </span>
          </a>
        </li>
        <li class="nav-item" style="">
          <a class="nav-link" href="<?php echo site_url('/logout');?>" >
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
              </svg>
            </span>
            <span class="nav-link-title">
              Logout
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</aside>
