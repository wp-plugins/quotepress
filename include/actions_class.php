<?php

/***********************************************************************
* Class: QUOTEPRESS_Actions
*
* The action hooks and helpers.
*
* The methods in here are normally called from an action hook that is
* called via the WordPress action stack.
*
* See http://codex.wordpress.org/Plugin_API/Action_Reference
*
************************************************************************/

if (! class_exists('QUOTEPRESS_Actions')) {
    class QUOTEPRESS_Actions {

        /******************************
         * PUBLIC PROPERTIES & METHODS
         ******************************/

        /*************************************
         * The Constructor
         */
        function __construct($params) {
        }


        /**************************************
         ** method: init()
         **
         ** Called when the WordPress init action is processed.
         **
         ** WordPress builtin post types:
         **
         ** post - WordPress built-in post type
         ** page - WordPress built-in post type
         ** mediapage - WordPress built-in post type
         ** attachment - WordPress built-in post type
         ** revision - WordPress built-in post type
         ** nav_menu_item - WordPress built-in post type (Since 3.0)
         ** custom post type - any custom post type (Since 3.0)
         **
         **/
        function init() {

            // Register Store Pages Custom Type
            register_post_type( QUOTEPRESS_PREFIX . '_quote',
                array(
                    'labels' => array(
                        'name'              => __( 'QuotePress',QUOTEPRESS_PREFIX ),
                        'singular_name'     => __( 'QuotePress Quote', QUOTEPRESS_PREFIX ),
                        'add_new_item'      => __('Create New Quote', QUOTEPRESS_PREFIX),
                        'edit_item'         => __('Edit Quote', QUOTEPRESS_PREFIX),
                        'view_item'         => __('View Quote', QUOTEPRESS_PREFIX),
                        'search_items'      => __('Search Quotes', QUOTEPRESS_PREFIX),
                        'not_found'         => __('No quotes found.', QUOTEPRESS_PREFIX),
                        'not_found_in_trash'=> __('No quotes found in trash.', QUOTEPRESS_PREFIX),
                        'all_items'         => __('List Quotes', QUOTEPRESS_PREFIX),
                    ),
                'public'            => true,
                'exclude_from_search' => false,
                'has_archive'       => true,
                'description'       => __('QuotePress quotes.',QUOTEPRESS_PREFIX),
                'menu_postion'      => 20,
                'menu_icon'         => QUOTEPRESS_PLUGINURL . '/images/quotepress_menuicon_16x16.png',
                'capability_type'   => 'page',
                'supports'          =>
                    array(
                            'title',
                            'revisions',
                            'thumbnail',
                            'editor'
                        ),
                )
            );

            // Register quote categories
            register_taxonomy(
                    'quote_category',
                    QUOTEPRESS_PREFIX . '_quote',
                    array (
                        'hierarchical'  => true,
                        'show_ui'       => true,
                        'query_var'     => true,
                        'rewrite'       => array('slug'),
                        'labels'        =>
                            array(
                                    'name' => __( 'Categories', QUOTEPRESS_PREFIX ),
                                    'singular_name' => __( 'Category', QUOTEPRESS_PREFIX ),
                                    'search_items' =>  __( 'Search Categories', QUOTEPRESS_PREFIX ),
                                    'all_items' => __( 'All Categories', QUOTEPRESS_PREFIX ),
                                    'parent_item' => __( 'Main Category', QUOTEPRESS_PREFIX ),
                                    'parent_item_colon' => __( 'Main Category:', QUOTEPRESS_PREFIX ),
                                    'edit_item' => __( 'Edit Category', QUOTEPRESS_PREFIX ),
                                    'update_item' => __( 'Update Category', QUOTEPRESS_PREFIX ),
                                    'add_new_item' => __( 'Add Category', QUOTEPRESS_PREFIX ),
                                    'new_item_name' => __( 'New Category Name', QUOTEPRESS_PREFIX ),
                                 )
                        )
                );

            // Register quote tags
            register_taxonomy(
                'quote_tag',
                QUOTEPRESS_PREFIX . '_quote',
                array (
                    'hierarchical'  => false,
                    'show_ui'       => true,
                    'query_var'     => true,
                    'rewrite'       => array('slug'),
                    'labels'        =>
                    array(
                        'name' => __( 'Tags', QUOTEPRESS_PREFIX ),
                        'singular_name' => __( 'Tag', QUOTEPRESS_PREFIX ),
                        'search_items' =>  __( 'Search Tags', QUOTEPRESS_PREFIX ),
                        'popular_items' => __( 'Popular Tags', QUOTEPRESS_PREFIX ),
                        'all_items' => __( 'All Tags', QUOTEPRESS_PREFIX ),
                        'parent_item' => null,
                        'parent_item_colon' => null,
                        'edit_item' => __( 'Edit Tags', QUOTEPRESS_PREFIX ),
                        'update_item' => __( 'Update Tag', QUOTEPRESS_PREFIX ),
                        'add_new_item' => __( 'Add New Tag', QUOTEPRESS_PREFIX ),
                        'new_item_name' => __( 'New Tag', QUOTEPRESS_PREFIX ),
                        'separate_items_with_commas' => __( 'Separate Tags With Commas', QUOTEPRESS_PREFIX ),
                        'add_or_remove_items' => __( 'Add or Remove Tags', QUOTEPRESS_PREFIX ),
                        'choose_from_most_used' => __( 'Choose From Most Used Tags', QUOTEPRESS_PREFIX )
                    )
                )
            );
        }
    }
}


