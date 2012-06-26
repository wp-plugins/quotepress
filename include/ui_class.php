<?php

/***********************************************************************
* Class: QUOTEPRESS_UserInterface
*
* User Interface hooks and helpers.
*
* The shortcode and widget rendering.
*
************************************************************************/

if (! class_exists('QUOTEPRESS_UserInterface')) {
    class QUOTEPRESS_UserInterface {

        /******************************
         * PUBLIC PROPERTIES & METHODS
         ******************************/

        /*************************************
         * The Constructor
         */
        function __construct($params) {
        }

        // Render a single quote via ID
        function render_quote($id) {
            // Post type is not an quotepress quote - get out
            if (get_post_type($id) != QUOTEPRESS_PREFIX . '_quote') { return; }

            // Merge our post info and our custom fields
            $details = array_merge(get_post($id, ARRAY_A), get_post_custom($id) );

            return
                "<strong>" . $details['post_title'] . "</strong></br>" .
                "\"<em>" . $details['post_content'] . "</em>\"" .
                "<br> -- " . $details[QUOTEPRESS_PREFIX . '-quote_author'][0]
                . "</br></br>";
                ;
        }

        /*************************************
         * method: render_shortcode
         *
         * Allows attributes:
         *
         *  id = numeric, the ID number of the quote to display
         *  shorthand = string, the shorthand id of the quote to display
         *  list = boolean, whether or not to show a list of quotes
         *
         */
        function render_shortcode($params=null) {
            global $quotepress_plugin;

            $quotepress_plugin->shortcode_was_rendered = true;

            // Set the attributes, default or passed in shortcode
            //
            $shortcode_atts = shortcode_atts(
                array(
                    'id'        => null,
                    'shorthand' => null,
                    'list'      => true,
                    'maxreturn' => $quotepress_plugin->settings->get_item('maxreturn',10),
                    'orderby'   => $quotepress_plugin->settings->get_item('orderby', 'post_date'),
                ),
                $params
            );

            if (!is_null($shortcode_atts['shorthand']) || !is_null($shortcode_atts['id'])) {
                $shortcode_atts['list'] = false;
            }

            // Our default lookup attributes
            $lookup_atts = array (
                'post_type' => QUOTEPRESS_PREFIX . '_quote',
                'numberposts' => $shortcode_atts['maxreturn'],
                'orderby' => $shortcode_atts['orderby'],
                'order' => 'DESC',
                'post_status' => 'publish'
            );

            // Do a generic lookup if ID is not set
            if (is_null($shortcode_atts['id']) || $shortcode_atts['id'] == '') {

                // Search via the shorthand name if available
                if (!is_null($shortcode_atts['shorthand']) || $shortcode_atts['shorthand'] != '') {
                    $lookup_atts['name'] = $shortcode_atts['shorthand'];
                    $lookup_atts['numberposts'] = 1;
                }

                $postInfo = get_posts($lookup_atts);

                // Set the ID if we're not rendering a list
                if (!(bool)$shortcode_atts['list']) {
                    $shortcode_atts['id'] = $postInfo[0]->ID;
                }
            }

            $output = '';

            // Display everything for a list
            if ((bool)$shortcode_atts['list']) {
                foreach ($postInfo as $post) {
                    $output .= QUOTEPRESS_UserInterface::render_quote($post->ID);
                }
            } else {
                // Otherwise, we should have an ID and we can render just that
                $output .= QUOTEPRESS_UserInterface::render_quote($shortcode_atts['id']);
            }

            return $output;

        }
    }
}


