<?php
/**
 * Helper function for generate navigation menu from database with twitter bootstrap
 * @param  array  	$array_menu data array of menu
 * @param  boolean 	$child      param to indicate menu_array is containt parent menu or child menu
 * @return string              	html
 */
function get_menu($array_menu, $child = FALSE)
{
	$CI =& get_instance();
	$string = '';

	if(count($array_menu))
	{
		//kalo menu punya tidak punya anak, maka echo open tag ul dengan class nav biasa
		//kalo menu punya anak, maka echo ul dengan class dropdown agar anak nya dapat di loop dalam div dropdown content
		$string .= $child == FALSE ? '<ul class="nav">' . PHP_EOL : '<ul class="dropdown">' . PHP_EOL;

		foreach($array_menu as $item)
		{
			$active = $CI->uri->segment(1) == $item['slug'] ? TRUE : FALSE;

			if(isset($item['children']) && count($item['children']))
			{
				$string .= $active ? '<li class="dropdown active">' : '<li class="dropdown">' . PHP_EOL;
				$string .= '<a class="dropdown-toggle" data-toggle=="dropdown" href="'.base_url($item['slug']).'">' . PHP_EOL;
				$string .= $item['title'] . PHP_EOL;
				$string .= '<i class="caret"></i>' . PHP_EOL;
				$string .= '</a>' . PHP_EOL;
				$string .= get_menu($item['children'], $child = TRUE);
			}
			else
			{
				$string .= $active ? '<li class="active">' : '<li>' . PHP_EOL;
				$string .= '<a href="'.base_url($item['slug']).'">' . $item['title'] . '</a>' . PHP_EOL;
			}

			$string .= '</li>' . PHP_EOL;
		}

		$string .= '</ul>' . PHP_EOL;
	}

	return $string;
}