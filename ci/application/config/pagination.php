<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['use_page_numbers'] = TRUE;
// By default, the URI segment will use the starting index for the items you are paginating. If you prefer to show the the actual page number, set this to TRUE.

$config['full_tag_open'] = '<ul class="pagination">';
$config['full_tag_close'] = '</ul>';

$config['first_link'] = TRUE;
$config['first_link'] = '<i class="fa fa-backward"></i>';
// The text you would like shown in the "first" link on the left. If you do not want this link rendered, you can set its value to FALSE.
$config['first_tag_open'] = '<li>';
// The opening tag for the "first" link.
$config['first_tag_close'] = '</li>';
// The closing tag for the "first" link.

$config['last_link'] = TRUE;
$config['last_link'] = '<i class="fa fa-forward"></i>';
// The text you would like shown in the "last" link on the right. If you do not want this link rendered, you can set its value to FALSE.
$config['last_tag_open'] = '<li></li>';
// The opening tag for the "last" link.
$config['last_tag_close'] = '</li>';
// The closing tag for the "last" link.

$config['prev_link'] = '<i class="fa fa-caret-left"></i>';
$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';

$config['next_link'] = '<i class="fa fa-caret-right"></i>';
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="active"><a href="#">';
$config['cur_tag_close'] = '</a></li>';

$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';