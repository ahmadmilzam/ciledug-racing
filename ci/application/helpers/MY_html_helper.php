<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function button_edit($uri, $confirm = FALSE, $type = 'btn')
	{
    $attr = array('class'=>$type.' '. $type.'-info');
    if($confirm)
    {
      $attr = array('class'=>$type.' '. $type.'-info js-confirm');
    }
		return anchor($uri, '<i class="fa fa-pencil-square-o left"></i>', $attr);
	}
	function button_delete($uri, $confirm = TRUE, $type = 'btn')
	{
    $attr = array('class'=>$type.' '. $type.'-danger');
    if($confirm)
    {
      $attr = array('class'=>$type.' '. $type.'-danger js-confirm-delete');
    }
		return anchor($uri, '<i class="fa fa-trash-o"></i>', $attr);
	}

	/**
   * userdata
   * Get curent userdata from session
   * @return object
   * @author Ahmad Milzam
   **/
  function userdata($param)
  {
  	$CI =& get_instance();
    return $CI->session->userdata($param);
  }

  /**
   * Build the html for a tree view
   *
   * @param array $items  An array of items that may or may not have children (under a key named `children` for each appropriate array entry).
   * @param string $sub  A string that use as mark for the child.
   * @param string $type  A string that use as mark category type, product or post.
   *
   */
  function simple_tree_builder($items, $sub = '', $type='')
  {
    $output = '';

    if( isset($items) && (is_array($items)) )
    {
      $output .= '<ul class="nav nav-stacked simple-tree">' . PHP_EOL;
      foreach ($items as $item){
        $output .= '<li>'. PHP_EOL;
        $output .= '<strong>'.$sub.$item['name'].'</strong>' . PHP_EOL;
        $output .= '<div class="tree-link-action pull-right text-right">' . PHP_EOL;
        $output .= button_edit(base_url('admin/category/form/'.$type.'/'.$item['id_category']), $confirm = FALSE, 'label') . PHP_EOL;
        $output .= button_delete(base_url('admin/category/delete/'.$item['id_category']), $confirm = TRUE, 'label') . PHP_EOL;
        $output .= '</div>'. PHP_EOL;
        $output .= '</li>'. PHP_EOL;
        if (isset($item['children']) && count($item['children']) > 0)
        {
          $sub2 = str_replace('<i class="fa fa-long-arrow-right"></i>', '&nbsp;', $sub);
          $sub2 .=  '&nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-long-arrow-right"></i> &nbsp;';
          $output .= simple_tree_builder($item['children'], $sub2, $type);
        }
      }
      $output .= '</ul>' . PHP_EOL;
    }

    return $output;

  }