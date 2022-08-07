<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'home';

// $route['(:any)'] = function ($param) {
//   $reserved = ['admin', 'manager', 'signUp', 'accessKey', 'forgotPassword', 'migrate'];
//   if (in_array($param, $reserved)) {
//     return $param;
//   }

//   return 'profile/index/' . $param;
// };

$route['404_override'] = 'home/error';

$route['translate_uri_dashes'] = FALSE;