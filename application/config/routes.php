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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['logout'] = 'auth/logout';
$route['con'] = 'contoh';
$route['con/ad'] = 'contoh/admin';

$route['dashboard'] = 'admin/home';
$route['dashboard/siswa'] = 'admin/home/siswa';
$route['dashboard/siswa/hapus/(:num)'] = 'admin/home/hapus_siswa/$1';

$route['dashboard/kelas'] = 'admin/home/kelas';
$route['dashboard/kelas/tambah'] = 'admin/home/tambah_kelas';
$route['dashboard/kelas/(:num)'] = 'admin/home/detail_kelas/$1';

$route['dashboard/materi'] = 'admin/materi';
$route['dashboard/materi/tambah'] = 'admin/materi/tambah_materi';
$route['dashboard/materi/edit/(:any)'] = 'admin/edmat/index/$1';

$route['dashboard/profile'] = 'admin/profile/index';
$route['dashboard/profile/(:any)'] = 'admin/profile/index/$1';

$route['dashboard/invite'] = 'admin/invite/index';
$route['dashboard/invite/edit/(:any)'] = 'admin/invite/edit/$1';

$route['dashboard/users'] = 'admin/users/index';
$route['dashboard/users/(:any)'] = 'admin/users/index/$1';

$route['dashboard/kelola_kelas'] = 'admin/kelasm/index';
$route['dashboard/manage_link'] = 'admin/kelasm/link_kelas';
$route['dashboard/manage_link/tambah'] = 'admin/kelasm/tambah_linkkelas';

$route['dashboard/settings'] = 'admin/settings/index';

$route['materi/(:any)'] = 'materi/index/$1';
$route['materi/(:any)/(:num)'] = 'materi/open_materi/$2';
