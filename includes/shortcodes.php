<?php

add_shortcode( 'breadcrumbs', 'breadcrumbs_shortcode_handler' );


/**
 * Processes the shortcodes
 * @param array $atts Associative Array containing the attributes of the shortcode
 */
function breadcrumbs_shortcode_handler($atts, $content, $code) {
	
	$options = get_option('breadcrumbs_gps_options');
	
	extract( shortcode_atts( array(
			'type' => $options['type'],
			'track' => '',
			'extended' => $options['extended'] == '1' ? 'true' : 'false',
			'unit' => $options['unit'],
			'width' => $options['width'],
			'height' => $options['height'],
                        'showtoolbar' => $options['showplayback'] == '1' ? 'show' : 'hide',
                        'showmedia' => $options['showmedia'] == '1' ? 'show' : 'hide',
			'showchartinfo' => $options['showchartinfo'] == '1' ? 'show' : 'hide',
                        'showstatsbar' => $options['showstatsbar'] == '1' ? 'show' : 'hide'
		        
		), $atts ) );

		
		if($track == '') return;
		
		
		# $dir = $user != '' ? "user/$user" : "route/$route";
		$maptype = breadcrumbs_maptype_id($type);

		# $src = "http://$domain/$dir/widget?width=$width&amp;height=$height&amp;extended=$extended&amp;maptype=$maptype&amp;unit=$unit&amp;redirect=no";
		$src = "http://www.gobreadcrumbs.com/plugins/map_widget_wordpress/$track?width=$width&amp;height=$height&amp;maptype=$maptype&amp;unit=$unit&amp;showmedia=$showmedia&amp;showtoolbar=$showtoolbar&amp;showstatsbar=$showstatsbar&amp;showchartinfo=$showchartinfo";
                $height = $showstatsbar == 'show' ? $height + 37 : $height;
                $height = $showmedia == 'show' ? $height + 83 : $height;
                $height = $showtoolbar == 'show' ? $height + 30 : $height;
                $height = $showchartinfo== 'show' ? $height + 180 : $height;
		return breadcrumbs_print_map($src, (int) $width, $height);
}


/**
 * Generates the HTML replacement for the shortcode
 * @param string $src the source of the map to be embedded in an iframe
 * @param integer $width The width of the map in pixels
 * @param integer $height The height of the map in pixels
 * @return string
 */
function breadcrumbs_print_map($src, $width, $height) {
	$out = '';
	
	$out .= sprintf("<div style='width:%spx; height:%spx;font: 12px Arial, Helvetica, sans-serif; line-height: 14px; padding: 0; margin: 0;'>", $width, $height + 30);
	$out .= sprintf("<iframe src='%s' width='%spx' height='%spx' scrolling='no' frameborder='0'></iframe>", $src, $width, $height);
	$out .= sprintf('</div>');
	
	return $out;
	
}

?>