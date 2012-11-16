<?php

/**
 * We need the generic WPCSL plugin class, since that is the
 * foundation of much of our plugin.  So here we make sure that it has
 * not already been loaded by another plugin that may also be
 * installed, and if not then we load it.
 */
if (defined('QUOTEPRESS_PLUGINDIR')) {
    if (class_exists('wpCSL_plugin__quotepress') === false) {
        require_once(QUOTEPRESS_PLUGINDIR.'WPCSL-generic/classes/CSL-plugin.php');
    }

    /**
     * This section defines the settings for the admin menu.
     */
    global $quotepress_plugin;
    $quotepress_plugin = new wpCSL_plugin__quotepress(
        array(
            'prefix'                => QUOTEPRESS_PREFIX,
            'name'                  => 'QuotePress',
            'sku'                   => 'QUOTEPRESS',

            'url'                   => 'http://www.charlestonsw.com/product/quotepress/',
            'support_url'           => 'http://www.charlestonsw.com/product/quotepress/',

            'basefile'              => QUOTEPRESS_BASENAME,
            'plugin_path'           => QUOTEPRESS_PLUGINDIR,
            'plugin_url'            => QUOTEPRESS_PLUGINURL,
            'cache_path'            => QUOTEPRESS_PLUGINDIR . 'cache',

            // We don't want default wpCSL objects, let's set our own
            //
            'use_obj_defaults'      => false,

            'cache_obj_name'        => 'none',
            'products_obj_name'     => 'none',

            'helper_obj_name'       => 'default',
            'notifications_obj_name'=> 'default',
            'settings_obj_name'     => 'default',

            // Licensing and Packages
            //
            'license_obj_name'      => 'none',
            'url'                   => 'http://www.charlestonsw.com/product/quotepress/',
            'support_url'           => 'http://wordpress.org/support/plugin/quotepress',
            'purchase_url'          => 'http://www.charlestonsw.com/product/quotepress/',
            'has_packages'          => false,


            // Themes and CSS
            //
            'display_settings'      => false,
            'themes_obj_name'       => 'none',
            'themes_enabled'        => false,
            'css_prefix'            => 'csl_themes',
            'css_dir'               => QUOTEPRESS_PLUGINDIR . 'css/',
            'no_default_css'        => true,

            // Custom Config Settings
            //
            'display_settings_collapsed'=> false,
            'show_locale'               => false,
            'uses_money'                => false,

            'driver_type'           => 'none',
            'driver_args'           => array(
                    ),
        )
    );

    // Setup our optional packages
    //
    require_once(QUOTEPRESS_PLUGINDIR . 'include/extra_help_class.php');
    $quotepress_plugin->extrahelper = new QUOTEPRESS_Extra_Help(
        array(
            'parent' => $quotepress_plugin
            )
        );
}

