<?php

define( 'MIN_MAP_WIDTH', 500 );
define( 'MIN_MAP_HEIGHT', 300 );


/**
 * Handler creating the options page
 */
function breadcrumbs_admin_menu_handler() {
	add_options_page( 'Breadcrumbs GPS', 'Breadcrumbs GPS', 'manage_options', 'breadcrumbs', 'breadcrumbs_options_page');
}


/**
 * Handler registering the settings, sections and fields
 */
function breadcrumbs_admin_init_handler() {
	register_setting( 'breadcrumbs_gps_options', 'breadcrumbs_gps_options', 'breadcrumbs_validate_options' );
	add_settings_section('breadcrumbs_properties_section', __('Map Properties', 'breadcrumbs'), 'breadrumbs_properties_section_description', 'breadcrumbs');
	add_settings_field('breadcrumbs_width_field', __('Map Width', 'breadcrumbs'), 'breadcrumbs_width_input', 'breadcrumbs', 'breadcrumbs_properties_section');
	add_settings_field('breadcrumbs_height_field', __('Map Height', 'breadcrumbs'), 'breadcrumbs_height_input', 'breadcrumbs', 'breadcrumbs_properties_section');
	add_settings_field('breadcrumbs_type_field', __('Map Type', 'breadcrumbs'), 'breadcrumbs_type_input', 'breadcrumbs', 'breadcrumbs_properties_section');
	add_settings_field('breadcrumbs_showmedia_field', __('Show Media', 'breadcrumbs'), 'breadcrumbs_showmedia_input', 'breadcrumbs', 'breadcrumbs_properties_section');
	add_settings_field('breadcrumbs_showplayback_field', __('Show Playback Toolbar', 'breadcrumbs'), 'breadcrumbs_showplayback_input', 'breadcrumbs', 'breadcrumbs_properties_section');
	add_settings_field('breadcrumbs_showstatsbar_field', __('Show Statistics', 'breadcrumbs'), 'breadcrumbs_showstatsbar_input', 'breadcrumbs', 'breadcrumbs_properties_section');
        add_settings_field('breadcrumbs_showchartinfo_field', __('Show Chart Info', 'breadcrumbs'), 'breadcrumbs_showchartinfo_input', 'breadcrumbs', 'breadcrumbs_properties_section');
	add_settings_field('breadcrumbs_unit_field', __('Unit', 'breadcrumbs'), 'breadcrumbs_unit_input', 'breadcrumbs', 'breadcrumbs_properties_section');	
}


/**
 * Print the description for the map properties section
 */
function breadrumbs_properties_section_description() {
	echo "<p>" . __('Enter the default map properties here.', 'breadcrumbs') . "<br/>";
	echo  __('You can override these defaults by using the appropriate attributes in each shortcode.', 'breadcrumbs') . "</p>";
}


/** Draw the input fields **/


function breadcrumbs_width_input() {
	$options = get_option( 'breadcrumbs_gps_options' );
	$width = $options['width'];
	echo "<input id='breadcrumbs_width_field' name='breadcrumbs_gps_options[width]' type='text' value='$width' size='4'/> px";
}


function breadcrumbs_height_input() {
	$options = get_option( 'breadcrumbs_gps_options' );
	$height = $options['height'];
	echo "<input id='breadcrumbs_height_field' name='breadcrumbs_gps_options[height]' type='text' value='$height' size='4'/> px";
}


function breadcrumbs_type_input() {
	$options = get_option( 'breadcrumbs_gps_options' );
	$type = $options['type'];
	printf( "<select id='breadcrumbs_type_field' name='breadcrumbs_gps_options[type]'>" );	
	printf( "	<option value='%s' %s>%s</option>", 'map', $type == 'map' ? 'selected' : '', __('Map', 'breadcrumbs') );
	printf( "	<option value='%s' %s>%s</option>", 'satellite', $type == 'satellite' ? 'selected' : '', __('Satellite', 'breadcrumbs') );
	printf( "	<option value='%s' %s>%s</option>", 'hybrid', $type == 'hybrid' ? 'selected' : '', __('Hybrid', 'breadcrumbs') );
	printf( "	<option value='%s' %s>%s</option>", 'terrain', $type == 'terrain' ? 'selected' : '', __('Terrain', 'breadcrumbs') );
	printf( "</select>" );
}



function breadcrumbs_unit_input() {
	$options = get_option( 'breadcrumbs_gps_options' );
	$unit = $options['unit'];
	printf( "<select id='breadcrumbs_unit_field' name='breadcrumbs_gps_options[unit]'>" );	
	printf( "	<option value='%s' %s>%s</option>", 'km', $unit == 'km' ? 'selected' : '', __('km', 'breadcrumbs') );
	printf( "	<option value='%s' %s>%s</option>", 'miles', $unit == 'miles' ? 'selected' : '', __('Miles', 'breadcrumbs') );
	printf( "</select>" );
}

function breadcrumbs_showmedia_input() {
	$options = get_option( 'breadcrumbs_gps_options' );
	$showmedia = $options['showmedia'];
	printf( "<input id='breadcrumbs_extended_field' name='breadcrumbs_gps_options[showmedia]' type='checkbox' value='1' %s />", $showmedia == '1' ? 'checked=\'checked\'' : '' );
}

function breadcrumbs_showplayback_input() {
	$options = get_option( 'breadcrumbs_gps_options' );
	$showplayback = $options['showplayback'];
	printf( "<input id='breadcrumbs_extended_field' name='breadcrumbs_gps_options[showplayback]' type='checkbox' value='1' %s />", $showplayback == '1' ? 'checked=\'checked\'' : '' );
}

function breadcrumbs_showstatsbar_input() {
	$options = get_option( 'breadcrumbs_gps_options' );
	$showstatsbar = $options['showstatsbar'];
	printf( "<input id='breadcrumbs_extended_field' name='breadcrumbs_gps_options[showstatsbar]' type='checkbox' value='1' %s />", $showstatsbar == '1' ? 'checked=\'checked\'' : '' );
}

function breadcrumbs_showchartinfo_input() {
	$options = get_option( 'breadcrumbs_gps_options' );
	$showchartinfo = $options['showchartinfo'];
	printf( "<input id='breadcrumbs_extended_field' name='breadcrumbs_gps_options[showchartinfo]' type='checkbox' value='1' %s />", $showchartinfo == '1' ? 'checked=\'checked\'' : '' );
}

/**
 * Validate user input
 * @param array $input Array containing the user input fields
 * @return array Array containing validated fields
 */
function breadcrumbs_validate_options($input) {
	
	$valid['width'] = preg_replace( '/[^0-9]/', '', $input['width'] );
	if( $valid['width'] != $input['width'] ) {
		add_settings_error(
			'breadcrumbs_width_field',
			'breadcrumbs_error_notanumber',
			sprintf( __('<i>%s</i> – You must enter a number!', 'breadcrumbs'), __('Map Width', 'breadcrumbs') ),
			'error'
		);		
	}
	if( (int) $input['width'] < MIN_MAP_WIDTH) {
		$valid['width'] = MIN_MAP_WIDTH;
		add_settings_error(
			'breadcrumbs_width_field',
			'breadcrumbs_error_tosmall',
			sprintf( __('<i>%s</i> – This value should be at least %s!', 'breadcrumbs'), __('Map Width', 'breadcrumbs'), MIN_MAP_WIDTH ),
			'error'
		);
	}
	
	$valid['height'] = preg_replace( '/[^0-9]/', '', $input['height'] );
	if( $valid['height'] != $input['height'] ) {
		add_settings_error(
			'breadcrumbs_height_field',
			'breadcrumbs_error_notanumber',
			sprintf( __('<i>%s</i> – You must enter a number!', 'breadcrumbs'), __('Map Height', 'breadcrumbs') ),
			'error'
		);		
	}
	if( (int) $input['height'] < MIN_MAP_HEIGHT) {
		$valid['height'] = MIN_MAP_HEIGHT;
		add_settings_error(
			'breadcrumbs_height_field',
			'breadcrumbs_error_tosmall',
			sprintf( __('<i>%s</i> – This value should be at least %s!', 'breadcrumbs'), __('Map Height', 'breadcrumbs'), MIN_MAP_HEIGHT ),
			'error'
		);
	}
	
	$valid['type'] = $input['type'];
	$valid['extended'] = $input['extended'];
	$valid['unit'] = $input['unit'];
        $valid['showmedia'] = $input['showmedia'];
        $valid['showplayback'] = $input['showplayback'];
        $valid['showstatsbar'] = $input['showstatsbar'];	
        $valid['showchartinfo'] = $input['showchartinfo'];
	return $valid;
}


/**
 * Add default options to the db on plugin activation. Don't overwrite existing options.
 */
function breadcrumbs_default_options() {
	$options = get_option('breadcrumbs_gps_options');
	$tmp = $options;
	if( !isset( $options['width'] ) ) $tmp['width'] = 500;
	if( !isset( $options['height'] ) ) $tmp['height'] = 400;
	if( !isset( $options['type'] ) ) $tmp['type'] = 'terrain';
	if( !isset( $options['unit'] ) ) $tmp['unit'] = 'km';
	if( !isset( $options['extended'] ) ) $tmp['extended'] = '1';
        if( !isset( $options['showmedia'] ) ) $tmp['showmedia'] = '1';
        if( !isset( $options['showplayback'] ) ) $tmp['showplayback'] = '1';
        if( !isset( $options['showstatsbar'] ) ) $tmp['showstatsbar'] = '1';
        if( !isset( $options['showchartinfo'] ) ) $tmp['showchartinfo'] = '1';
	update_option( 'breadcrumbs_gps_options', $tmp );
}



/**
 * Draw the plugin options page
 */
function breadcrumbs_options_page() {
	
	?>
	
	<div class="wrap">
	
	<?php screen_icon(); ?>
	<h2><?php _e('Breadcrumbs GPS Settings', 'breadcrumbs'); ?></h2>
	
	<form action="options.php" method="post">
	<?php settings_fields('breadcrumbs_gps_options'); ?>
	<?php do_settings_sections('breadcrumbs'); ?>
	<p class="submit"><input name="Submit" type="submit" value="<?php _e('Save Changes', 'breadcrumbs'); ?>" class="button-primary" /></p>
	</form>
	
	</div>
	
	<?php 
	
} 

?>