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
// $route['default_controller'] = 'alumni';
$route['default_controller'] = 'dashboard';
$route['404_override'] = 'errors/page_not_found';
$route['translate_uri_dashes'] = FALSE;

// Alumni routes
$route['alumni/create'] = 'alumni/create';
$route['alumni/save'] = 'alumni/save';
$route['alumni/edit/(:num)'] = 'alumni/edit/$1';
$route['alumni/update/(:num)'] = 'alumni/update/$1';
$route['alumni/get_kabupaten_ajax'] = 'alumni/get_kabupaten_ajax';

// Dashboard route
$route['dashboard'] = 'Dashboard';

// Admin routes
$route['admin/dashboard'] = 'admin/Dashboard';
$route['admin/alumni'] = 'admin/Alumni';
$route['admin/alumni/(:num)'] = 'admin/Alumni/detail/$1';
$route['admin/alumni/edit/(:num)'] = 'admin/Alumni/edit/$1';
$route['admin/alumni/delete/(:num)'] = 'admin/Alumni/delete/$1';
$route['admin/pages'] = 'admin/Pages';
$route['admin/pages/create'] = 'admin/Pages/create';
$route['admin/pages/edit/(:num)'] = 'admin/Pages/edit/$1';
$route['admin/pages/delete/(:num)'] = 'admin/Pages/delete/$1';
$route['admin/news'] = 'admin/News';
$route['admin/news/create'] = 'admin/News/create';
$route['admin/news/edit/(:num)'] = 'admin/News/edit/$1';
$route['admin/news/delete/(:num)'] = 'admin/News/delete/$1';
$route['admin/counter'] = 'admin/Counter';
