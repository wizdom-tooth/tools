<?php

function output_contents(array $sitemap)
{
	$html = '';
	foreach ($sitemap as $page_id => $page_info)
	{
		if ( ! is_array($page_info['children']))
		{
			$html .= '<li>';
			$html .= '<a href="'.$page_info['url'].'">'.$page_info['title'].'</a>';
			$html .= '</li>';
		}
		else
		{
			if ($page_info['url'] === NULL)
			{
				$html .= '<li>'.$page_info['title'];
				$html .= '<ol>';
				$html .= output_contents($page_info['children']);
				$html .= '</ol>';
				$html .= '</li>';
			}
			else
			{
				$html .= '<li>';
				$html .= '<a href="'.$page_info['url'].'">'.$page_info['title'].'</a>';
				$html .= '<ol>';
				$html .= output_contents($page_info['children']);
				$html .= '</ol>';
				$html .= '</li>';
			}
		}
	}
	return $html;
}
