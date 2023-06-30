<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('login', 'C_login::index');
$routes->get('logout', 'C_login::logout');
$routes->post('login_process', 'C_login::logging_in');
$routes->get('login_process', 'C_login::logging_in');
$routes->get('upload', 'C_login::tes_upload');
$routes->get('surat_masuk', 'C_user::inbox');
$routes->get('daftar_surat_masuk', 'C_user::inbox_list');
$routes->get('upload_surat', 'C_user::upload_mail');
$routes->post('new_mail', 'C_mail::new_mail');
$routes->get('new_mail', 'C_mail::new_mail');
$routes->post('dispo_baru', 'C_mail::dispo_baru');
$routes->get('dispo_baru', 'C_mail::dispo_baru');
$routes->post('set_status_surat', 'C_mail::set_mail_status');
$routes->get('set_status_surat', 'C_mail::set_mail_status');
$routes->post('set_status_disposisi', 'C_mail::set_dispo_status');
$routes->get('set_status_disposisi', 'C_mail::set_dispo_status');
$routes->get('cek_inbox', 'C_mail::cek_inbox');
$routes->get('cek_inbox_dir', 'C_mail::cek_inbox_dir');
$routes->get('cek_inbox/jml', 'C_mail::cek_jml_inbox');
$routes->get('cek_disposisi', 'C_mail::cek_disposisi');
$routes->get('baca/(:num)', 'C_mail::baca_surat/$1');
$routes->get('baca/disposisi/(:num)', 'C_mail::baca_disposisi/$1');
$routes->get('lihat_dokumen', 'C_mail::lihat_surat');
$routes->get('presensi', 'C_user::presensi');
$routes->get('profil', 'C_user::profil');
$routes->add('detail/buma', 'C_detail::onfarm/buma');
$routes->add('detail/cima', 'C_detail::onfarm/cima');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
