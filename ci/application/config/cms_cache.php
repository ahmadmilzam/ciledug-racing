<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['cache_dir'] = APPPATH.'cache/';

$config['cache_default_expires'] = 3600;


// Make sure all the folders exist
is_dir($config['cache_dir']) OR mkdir($config['cache_dir'], 0777, true);