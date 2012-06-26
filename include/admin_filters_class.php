<?php

/***********************************************************************
* Class: QUOTEPRESS_Admin_Filters
*
* The admin panel filters.
*
* The methods in here are normally called from an filters hook that is
* called via the WordPress filter stack.
*
* See http://codex.wordpress.org/Plugin_API/Action_Reference
*
************************************************************************/

if (! class_exists('QUOTEPRESS_Admin_Filters')) {
    class QUOTEPRESS_Admin_Filters {

        /******************************
         * PUBLIC PROPERTIES & METHODS
         ******************************/

        /*************************************
         * The Constructor
         */
        function __construct($params) {
        }

        /*************************************
         * method: quotepress_ad_columns
         */
        function quotepress_quote_columns($columns) {
            return
                array(
                    'cb'            => '<input type="checkbox" />',
                    'id'            => __('ID', QUOTEPRESS_PREFIX)          ,
                    'shorthand'     => __('Shorthand', QUOTEPRESS_PREFIX)  ,
                    'title'         => __('Name', QUOTEPRESS_PREFIX)       ,
                    'quote_author'  => __('Author',QUOTEPRESS_PREFIX),
                    'source'        => __('Source', QUOTEPRESS_PREFIX),
                    'status'        => __('Status', QUOTEPRESS_PREFIX),
                    'date'          => __('Date', QUOTEPRESS_PREFIX)
                );
        }
    }
}


