<?php
/*
Plugin Name: QuotePress
Plugin URI: http://www.charlestonsw.com/product/quotepress/
Description: Manage and display quotes.
Version: 0.2
Author: Charleston Software Associates
Author URI: http://www.charlestonsw.com
License: GPL3

Copyright 2012  Charleston Software Associates (info@charlestonsw.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/


// Globals
global $quotepress_plugin;

// Drive Path Defines
//
if (defined('QUOTEPRESS_PLUGINDIR') === false) {
    define('QUOTEPRESS_PLUGINDIR', plugin_dir_path(__FILE__));
}
if (defined('QUOTEPRESS_ICONDIR') === false) {
    define('QUOTEPRESS_ICONDIR', QUOTEPRESS_PLUGINDIR . 'images/icons/');
}

// URL Defines
//
if (defined('QUOTEPRESS_PLUGINURL') === false) {
    define('QUOTEPRESS_PLUGINURL', plugins_url('',__FILE__));
}
if (defined('QUOTEPRESS_ICONURL') === false) {
    define('QUOTEPRESS_ICONURL', QUOTEPRESS_PLUGINURL . 'images/icons/');
}
if (defined('QUOTEPRESS_ADMINPAGE') === false) {
    define('QUOTEPRESS_ADMINPAGE', admin_url() . 'admin.php?page=' . QUOTEPRESS_PLUGINDIR );
}

// The relative path from the plugins directory
//
if (defined('QUOTEPRESS_BASENAME') === false) {
    define('QUOTEPRESS_BASENAME', plugin_basename(__FILE__));
}

// Our product prefix
//
if (defined('QUOTEPRESS_PREFIX') === false) {
    define('QUOTEPRESS_PREFIX', 'csl-quotepress');
}


// Include our needed files
//
include_once(QUOTEPRESS_PLUGINDIR . 'include/config.php'   );

require_once(QUOTEPRESS_PLUGINDIR . 'include/actions_class.php');
require_once(QUOTEPRESS_PLUGINDIR . 'include/admin_actions_class.php');
require_once(QUOTEPRESS_PLUGINDIR . 'include/admin_filters_class.php');
require_once(QUOTEPRESS_PLUGINDIR . 'include/ui_class.php');
require_once(QUOTEPRESS_PLUGINDIR . 'include/widget_class.php');


// Regular Actions
//
add_action('init'                       ,array('QUOTEPRESS_Actions','init')                            );
//add_action('wp_enqueue_scripts'         ,array('QUOTEPRESS_Actions','wp_enqueue_scripts')              );
add_action('widgets_init'               ,create_function( '', 'register_widget( "quotepressWidget" );'));
//add_action('shutdown'                 ,array('QUOTEPRESS_Actions','shutdown')                        );

// Admin Actions
//
add_action('admin_init'                 ,array('QUOTEPRESS_Admin_Actions','admin_init')                );
add_action('admin_print_styles'         ,array('QUOTEPRESS_Admin_Actions','admin_print_styles')        );
add_action('manage_posts_custom_column' ,array('QUOTEPRESS_Admin_Actions','manage_posts_custom_column'));
add_action('save_post'                  ,array('QUOTEPRESS_Admin_Actions','save_post')                 );

// Admin Filters
//
add_filter('manage_edit-' . QUOTEPRESS_PREFIX . '_quote_columns',array('QUOTEPRESS_Admin_Filters', 'quotepress_quote_columns'));

// Short Codes
//
add_shortcode('quote'        ,array('QUOTEPRESS_UserInterface','render_shortcode')  );
add_shortcode('Quote'        ,array('QUOTEPRESS_UserInterface','render_shortcode')  );
add_shortcode('QUOTE'        ,array('QUOTEPRESS_UserInterface','render_shortcode')  );
add_shortcode('quotepress'   ,array('QUOTEPRESS_UserInterface','render_shortcode')  );
add_shortcode('QUOTEPRESS'   ,array('QUOTEPRESS_UserInterface','render_shortcode')  );
add_shortcode('Quotepress'   ,array('QUOTEPRESS_UserInterface','render_shortcode')  );
add_shortcode('Quotepress'   ,array('QUOTEPRESS_UserInterface','render_shortcode')  );

// Text Domains
//
load_plugin_textdomain(QUOTEPRESS_PREFIX, false, QUOTEPRESS_BASENAME . '/languages/');
