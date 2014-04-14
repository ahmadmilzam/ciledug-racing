<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$default_controller                         = "page";//contoh controller helo
$controller_exceptions                      = array('admin','user', 'media');

$route['default_controller']                = $default_controller;
$route['404_override']                      = '';

// custom route
$route["^((?!\b".implode('\b|\b', $controller_exceptions)."\b).*)$"] = $default_controller.'/$1';
// $route['admin']                                                      = 'admin/index';
$route['admin/([a-zA-Z0-9_-]+)']                                     = '$1/admin/index';
$route['admin/([a-zA-Z0-9_-]+)/(:any)']                              = '$1/admin/$2';
$route['admin/([a-zA-Z_-]+)/form']                                   = '$1/admin/form';
$route['admin/([a-zA-Z_-]+)/form/(:any)']                            = '$1/admin/form/$2';

/* End of file routes.php */
/* Location: ./application/config/routes.php */