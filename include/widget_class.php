<?php

/***********************************************************************
* Class: quotepressWidget
*
* The custom quotepress widget.
*
*
* See http://codex.wordpress.org/Widgets_API
*
************************************************************************/

class quotepressWidget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		QUOTEPRESS_PREFIX.'_widget', // Base ID
			__('QuotePress Quote',QUOTEPRESS_PREFIX), // Name
			array(
			    'description' => __( 'Add an QuotePress quote to any widget box location.', QUOTEPRESS_PREFIX ),
			    )
		);
	}

 	public function form( $instance ) {
 	    print __('Enter the ID or shorthand code for a quote.', QUOTEPRESS_PREFIX);
		print $this->formatFormEntry($instance, 'id'        , __( 'Quote ID:', QUOTEPRESS_PREFIX)           ,'');
		print $this->formatFormEntry($instance, 'shorthand' , __( 'Quote Shorthand:', QUOTEPRESS_PREFIX)    ,'');
    }

	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	public function widget( $args, $instance ) {
		print QUOTEPRESS_UserInterface::render_shortcode($instance);
	}

	private function formatFormEntry($instance, $id,$label,$default) {
	    $fldID = $this->get_field_id( $id );
	    $content= '<p>'.
            '<label for="'.$fldID.'">'.$label.'</label>'.
            '<input class="widefat" type="text" '.
                'id="'      .$fldID                                                     .'" '.
                'name="'    .$this->get_field_name( $id )                               .'" '.
                'value="'   .esc_attr( isset($instance[$id])?$instance[$id]:$default )  .'" '.
                '/>'.
             '</p>';
        return $content;
	}

}
