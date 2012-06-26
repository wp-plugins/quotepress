<?php

/***********************************************************************
* Class: QUOTEPRESS_Admin_Actions
*
* The action hooks and helpers.
*
* The methods in here are normally called from an action hook that is
* called via the WordPress action stack.
*
* See http://codex.wordpress.org/Plugin_API/Action_Reference
*
************************************************************************/

if (! class_exists('QUOTEPRESS_Admin_Actions')) {
    class QUOTEPRESS_Admin_Actions {

        /******************************
         * PUBLIC PROPERTIES & METHODS
         ******************************/

        /*************************************
         * The Constructor
         */
        function __construct($params) {
        }

        /*************************************
         * method: admin_init
         */
        function admin_init() {
            global $quotepress_plugin;

            // Only Do This For Our Admin Page
            //
            if ($quotepress_plugin->isOurAdminPage) {
                $ProPackMsg =
                  (
                      $quotepress_plugin->propack_enabled ?
                      '':
                     __(' A Pro Pack feature.',QUOTEPRESS_PREFIX)
                      );

                // Add sections to our QuotePress Plugin
                // *should we check we are on quotepress settings page first?*
                //
                $quotepress_plugin->settings->add_section(
                    array(
                        'name'              => __('Info', QUOTEPRESS_PREFIX),
                        'description'       => __(
                            $quotepress_plugin->helper->get_string_from_phpexec(QUOTEPRESS_PLUGINDIR.'how_to_use.txt'),QUOTEPRESS_PREFIX),
                        'start_collapsed'   => false,
                    )
                );


                // Default Settings Section
                //
                $quotepress_plugin->settings->add_section(
                    array(
                        'name'              =>
                            __('Default Settings', QUOTEPRESS_PREFIX),
                        'description'       =>
                            __('Set the default values for shortcodes and widgets.  These settings are optional.',QUOTEPRESS_PREFIX),
                        'start_collapsed'   => false,
                    )
                );

                $quotepress_plugin->settings->add_item(
                        __('Default Settings', QUOTEPRESS_PREFIX),
                        __('Max Quotes to Return', QUOTEPRESS_PREFIX),
                        'maxreturn',
                        'text',
                        false,
                        __('This is the maximum number of quotes that will be returned in a list unless otherwise specified.', QUOTEPRESS_PREFIX) .  $ProPackMsg,
                        null,
                        null,
                        false
               );

                $quotepress_plugin->settings->add_item(
                        __('Default Settings', QUOTEPRESS_PREFIX),
                        __('Sort Method', QUOTEPRESS_PREFIX),
                        'orderby',
                        'list',
                        false,
                        __('This is how quotes will be sorted by default.', QUOTEPRESS_PREFIX) .  $ProPackMsg,
                        array(
                            'Date' => 'post_date',
                            'Title' => 'title',
                            'Random' => 'rand',
                        ),
                        null,
                        !$quotepress_plugin->propack_enabled
               );
            }

            // QuotePress Quote Interface Extra Data
            // *should we check we are on quotepress create quote page first?*
            //
            add_meta_box('render_content_area_ui', __('Quote Information',QUOTEPRESS_PREFIX),
                array('QUOTEPRESS_Quote_EditUI','render_content_area_ui')  ,
                QUOTEPRESS_PREFIX . '_quote', 'normal', 'high'
                );

            // WordPress Built-In Image Box
            add_meta_box('postimagediv', __('Quote Graphic',QUOTEPRESS_PREFIX),
                'post_thumbnail_meta_box',
                QUOTEPRESS_PREFIX . '_quote', 'normal', 'core');
        }



        /*************************************
         * method: admin_print_styles
         */
        function admin_print_styles() {
            global $quotepress_plugin, $post;
            if (
                ($quotepress_plugin->isOurAdminPage ||
                    (isset($post) && ($post->post_type == QUOTEPRESS_PREFIX . '_quote'))
                ) &&
                file_exists(QUOTEPRESS_PLUGINDIR.'css/admin.css')
                ) {
                    wp_enqueue_style('csl_quotepress_admin_css', QUOTEPRESS_PLUGINURL .'/css/admin.css');
            }
        }

        /*************************************
         * method: manage_posts_custom_column
         */
        function manage_posts_custom_column($column)
        {
            global $post;
            switch ($column) {
                case 'id':
                    echo $post->ID;
                    break;
                case 'shorthand':
                    echo $post->post_name;
                    break;
                case 'status':
                    echo $post->post_status;
                    break;
                case 'graphic':
                    echo get_the_post_thumbnail( $post->ID);
                    break;
                default:
                    echo QUOTEPRESS_Admin_Actions::getMetaValue($post->ID,$column);
            }
        }

        /*************************************
         * method: save_post
         */
        function save_post($post_id)
        {

            // User is not allowed to edit pages - skip this
            //
            if (!current_user_can( 'edit_page', $post_id )) {
                return;
            }


            // Save Ads
            //
            if (isset($_POST['post_type'])  && (QUOTEPRESS_PREFIX . '_quote' == $_POST['post_type']))  {
                QUOTEPRESS_Quote_EditUI::save_post();
            }
        }

        //------------------------------------------
        // HELPERS
        //------------------------------------------


        /*************************************
         * method: getMetaValue
         *
         * returns the value of a meta field for a given postID
         */
        function getMetaValue($postid,$name) {
            $custom = get_post_custom($postid);
            return (isset($custom[QUOTEPRESS_PREFIX.'-'.$name])?$custom[QUOTEPRESS_PREFIX.'-'.$name][0]:'');
        }

    }
}



/***********************************************************************
* Class: QUOTEPRESS_Quote_EditUI
*
* The QuotePress Ad Editor Management
*
* This handles the metabox display and editing.
*
* See http://codex.wordpress.org/Plugin_API/Action_Reference
*
************************************************************************/

if (! class_exists('QUOTEPRESS_Quote_EditUI')) {
    class QUOTEPRESS_Quote_EditUI {

        /*************************************
         * method: render_content_area_ui
         */
        function render_content_area_ui() {
            global $quotepress_plugin, $post;

            // The JS to open the more info button
            //
            echo
            '<script type="text/javascript">' .
                'jQuery(document).ready(function($) {' .
                    "$('.".$quotepress_plugin->css_prefix."-moreicon').click(function(){".
                        "$(this).siblings('.".$quotepress_plugin->css_prefix."-moretext').toggle();".
                        '});'.
                    '});'.
            '</script>'
            ;

            // The input boxes
            //
            print '<div class="'.$quotepress_plugin->css_prefix.'-metabox-parent">';
            QUOTEPRESS_Quote_EditUI::render_meta_input(
                'id',
                __('Quote ID', QUOTEPRESS_PREFIX),
                sprintf(
                    __('The quote ID, you can use this or the permalink shorthand to display quotes. [quotepress id="%s"]', QUOTEPRESS_PREFIX),
                    $post->ID
                    ),
                false,
                $post->ID
                );
            QUOTEPRESS_Quote_EditUI::render_meta_input(
                'shorthand',
                __('Quote Shorthand', QUOTEPRESS_PREFIX),
                sprintf(
                    __('The quote shorthand. You can use this or the quote id to display quotes. [quotepress shorthand="%s"]', QUOTEPRESS_PREFIX),
                    $post->post_name
                    ),
                false,
                $post->post_name
                );
            QUOTEPRESS_Quote_EditUI::render_meta_input(
                'quote_author',
                __('Author', QUOTEPRESS_PREFIX),
                __('The author', QUOTEPRESS_PREFIX)
            );
            QUOTEPRESS_Quote_EditUI::render_meta_input(
                'source',
                __('Source', QUOTEPRESS_PREFIX),
                __('The source', QUOTEPRESS_PREFIX)
            );
            QUOTEPRESS_Quote_EditUI::render_meta_input(
                'asin',
                __('ASIN', QUOTEPRESS_PREFIX),
                __('Amazon product code', QUOTEPRESS_PREFIX)
            );

            print '</div>';
        }

        /*************************************
         * method: save_post
         */
        function save_post() {
            update_post_meta($_POST['ID'], QUOTEPRESS_PREFIX.'-'.'quote_author', $_POST[QUOTEPRESS_PREFIX.'-'.'quote_author']);
            update_post_meta($_POST['ID'], QUOTEPRESS_PREFIX.'-'.'source', $_POST[QUOTEPRESS_PREFIX.'-'.'source']);
            update_post_meta($_POST['ID'], QUOTEPRESS_PREFIX.'-'.'asin', $_POST[QUOTEPRESS_PREFIX.'-'.'asin']);
        }

        /*************************************
         * method: render_meta_input
         */
       function render_meta_input($name,$label,$description,$enabled=true,$value=null) {
            global $quotepress_plugin, $post;
            $custom = get_post_custom($post->ID);
            if ($value == null) {
                $value = (isset($custom[QUOTEPRESS_PREFIX.'-'.$name])?$custom[QUOTEPRESS_PREFIX.'-'.$name][0]:'');
            }
            print
                '<div class="'.$quotepress_plugin->css_prefix.'-metabox">'.
                '<div class="'.$quotepress_plugin->css_prefix.'-input' . ($enabled?'':'-disabled').'">' .
                    '<label>'.$label.'</label>' .
                    '<input type="text" name="'.QUOTEPRESS_PREFIX.'-'.$name.'" value="'.$value.'" '. ($enabled?'':'disabled="disabled"').'/>' .
                    '</div>' .
                    '<div class="'.$quotepress_plugin->css_prefix.'-moreicon" title="click for more info"><br/></div>' .
                    '<div class="'.$quotepress_plugin->css_prefix.'-moretext">' .
                        $description .
                    '</div>' .
                '</div>'
                ;

         }

    }
}


