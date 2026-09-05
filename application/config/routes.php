<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth & User Routes
$route['auth/register'] = 'Auth/register';
$route['auth/login'] = 'Auth/login';
$route['auth/logout'] = 'Auth/logout';
$route['daftar-akun'] = 'Auth/register';
$route['login'] = 'Auth/login';
$route['logout'] = 'Auth/logout';

$route['dashboard'] = 'User/dashboard';
$route['user/biodata'] = 'User/biodata';

// Frontend Routes
$route['pendaftaran'] = 'Registration';
$route['pendaftaran/submit'] = 'Registration/submit';
$route['pendaftaran/berhasil/(:any)'] = 'Registration/success/$1';
$route['pendaftaran/pdf/(:any)'] = 'Registration/generate_pdf/$1';
$route['cek-status'] = 'Status';
$route['cek-status/hasil'] = 'Status/check';

// Admin Routes
$route['admin'] = 'admin/Dashboard';
$route['admin/login'] = 'admin/Auth/login';
$route['admin/login/process'] = 'admin/Auth/process';
$route['admin/logout'] = 'admin/Auth/logout';
$route['admin/dashboard'] = 'admin/Dashboard';
$route['admin/pendaftar'] = 'admin/Applicants';
$route['admin/pendaftar/detail/(:num)'] = 'admin/Applicants/detail/$1';
$route['admin/pendaftar/update-status'] = 'admin/Applicants/update_status';
$route['admin/pendaftar/delete/(:num)'] = 'admin/Applicants/delete/$1';
$route['admin/pendaftar/pdf/(:num)'] = 'admin/Applicants/generate_pdf/$1';
$route['admin/divisi'] = 'admin/Divisions';
$route['admin/divisi/tambah'] = 'admin/Divisions/add';
$route['admin/divisi/edit/(:num)'] = 'admin/Divisions/edit/$1';
$route['admin/divisi/delete/(:num)'] = 'admin/Divisions/delete/$1';
$route['admin/divisi/toggle/(:num)'] = 'admin/Divisions/toggle/$1';
$route['admin/export'] = 'admin/Applicants/export';
$route['admin/export/csv'] = 'admin/Applicants/export_csv';
$route['admin/organisasi'] = 'admin/Organization';
$route['admin/organisasi/tambah'] = 'admin/Organization/add';
$route['admin/organisasi/edit/(:num)'] = 'admin/Organization/edit/$1';
$route['admin/organisasi/delete/(:num)'] = 'admin/Organization/delete/$1';
$route['admin/organisasi/toggle/(:num)'] = 'admin/Organization/toggle/$1';

// Program Kerja Routes
$route['program-kerja'] = 'ProgramKerja';
$route['admin/program-kerja'] = 'admin/ProgramKerja';
$route['admin/program-kerja/add'] = 'admin/ProgramKerja/add';
$route['admin/program-kerja/edit/(:num)'] = 'admin/ProgramKerja/edit/$1';
$route['admin/program-kerja/delete/(:num)'] = 'admin/ProgramKerja/delete/$1';
$route['admin/program-kerja/upload-dokumentasi/(:num)'] = 'admin/ProgramKerja/upload_dokumentasi/$1';
$route['admin/program-kerja/delete-dokumentasi/(:num)'] = 'admin/ProgramKerja/delete_dokumentasi/$1';
$route['admin/program-kerja/update-status/(:num)'] = 'admin/ProgramKerja/update_status/$1';

// Pengajuan Proposal Routes
$route['pengajuan-proposal'] = 'PengajuanProposal';
$route['pengajuan-proposal/tambah'] = 'PengajuanProposal/tambah';
$route['pengajuan-proposal/edit/(:num)'] = 'PengajuanProposal/edit/$1';
$route['pengajuan-proposal/delete/(:num)'] = 'PengajuanProposal/delete/$1';
$route['pengajuan-proposal/pdf/(:num)'] = 'PengajuanProposal/generate_pdf/$1';

$route['admin/pengajuan-proposal'] = 'admin/PengajuanProposal';
$route['admin/pengajuan-proposal/add'] = 'admin/PengajuanProposal/add';
$route['admin/pengajuan-proposal/edit/(:num)'] = 'admin/PengajuanProposal/edit/$1';
$route['admin/pengajuan-proposal/update-status/(:num)'] = 'admin/PengajuanProposal/update_status/$1';
$route['admin/pengajuan-proposal/delete/(:num)'] = 'admin/PengajuanProposal/delete/$1';
$route['admin/pengajuan-proposal/pdf/(:num)'] = 'admin/PengajuanProposal/pdf/$1';


