<?php
/*
Plugin Name: Breadcrumbs GPS map
Plugin URI: http://www.gobreadcrumbs.com/en/learn/articles/share/breadcrumbs_gps_wordpress_plugin
Description: Breadcrumbs allows you to manage, organize and share your GPS tracks and associated photos/videos. This plugin lets you embed your GPS tracks stored on Breadcrumbs in a easy and flexible way.
Version: 0.2
Text Domain: breadcrumbs
Author: Breadcrumbs <admin@gobreadcrumbs.com>
Author URI: http://www.gobreadcrumbs.com
*/

/*  This plugin is based on the Xmap plugin by Mathias Scheidl

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



// i18n
load_plugin_textdomain( 'breadcrumbs', false, basename(dirname(__FILE__)) . '/languages/' );

// Includes
include_once 'includes/helpers.php';
include_once 'includes/options.php';
include_once 'includes/shortcodes.php';

// Actions
add_action( 'admin_menu', 'breadcrumbs_admin_menu_handler');
add_action('admin_init', 'breadcrumbs_admin_init_handler');

// Hooks
register_activation_hook(__FILE__, 'breadcrumbs_activation_handler');
register_uninstall_hook(__FILE__, 'breadcrumbs_uninstall_handler');



/**
 * Plugin activation handler
 */
function breadcrumbs_activation_handler() {
	breadcrumbs_default_options();
}


/**
 * Plugin uninstall handler
 */
function breadcrumbs_uninstall_handler() {
	delete_option('breadcrumbs_gps_options');
}


?>