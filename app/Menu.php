<?php

namespace App;

class Menu
{
	public static function render()
	{
		$menu = '<ul class="list-unstyled">';

		foreach (config('menu') as $properties) :

			$parent_active = self::checkActive($properties['url']);

			$child_active = '';

			if ( ! empty($properties['childs'])) {
				foreach ($properties['childs'] as $url => $title) {

					$child_active = self::checkActive($url);

					if ('active' == $child_active) {
						$child_active = 'child-active';
						break;
					}
				}
			}
						
			$menu .= '<li class="' . $parent_active . ' ' . $child_active . '"><a href="' . url($properties['url']) . '">';
			
			if ($properties['icon'])
				$menu .= '<i class="' . $properties['icon'] . '"></i>';
			
			$menu .= $properties['title'];

			if ( ! empty($properties['childs'])) {
                $menu .= '<span class="caret pull-right"></span>';
	            
	            if ( $parent_active === 'active' || $child_active === 'child-active' ) :
	                $menu .= '<ul class="list-unstyled">';

	                foreach($properties['childs'] as $url => $title) :

		                $menu .= '<li class="' . self::checkActive($url) . '">
		                    <a href="' . url($url) . '">' . $title . '</a>
		                </li>';

	                endforeach;
	                $menu .= '</ul>';
	           	endif;
           }

			$menu .= '</a></li>';

		endforeach;

		return $menu . '</ul>';
	}

	public static function checkActive($url)
	{
		$current_path = app('request')->path();
		
		if ($current_path === $url)
			return 'active';

		return '';
	}

	public static function back()
	{
	
	}
}