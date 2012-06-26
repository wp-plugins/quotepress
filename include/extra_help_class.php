<?php

/***********************************************************************
* Class: QUOTEPRESS_Extra_Help
*
* The QuotePress plugin helpers.
*
* This handles the metabox display and editing.
*
* See http://codex.wordpress.org/Plugin_API/Action_Reference
*
************************************************************************/

if (! class_exists('QUOTEPRESS_Extra_Help')) {
    class QUOTEPRESS_Extra_Help {


            /*************************************
             * The Constructor
             */
            function __construct($params) {
                foreach ($params as $name => $value) {
                    $this->$name = $value;
                }

                $this->add_options_packages();
            }

            /**************************************
             ** function: add_options_packages
             **
             ** This is where add-on initializations go.
             ** If you add something other than the propack
             ** create a method for it, then hook it in here.
             **
             **/
            function add_options_packages() {
                $this->configure_propack();
            }

            /**************************************
             ** function: configure_propack
             **
             ** Configure the Pro Pack.
             ** Requires parent to be passed in the constructor.
             ** Parent is set to the instantiated WPCSL object.
             **
             ** USE THIS (it checks to see if the license is enabled first)...
             ** Pro Pack Enabled : after forcing a retest of the license:
             ** $quotepress_plugin->license->packages['Pro Pack']->isenabled_after_forcing_recheck()
             **
             ** Pro Pack Version 2.4 is licensed (version is cast to 0 padded int)
             ** $quotepress_plugin->license->packages['Pro Pack']->isenabled &&
             ** $quotepress_plugin->license->packages['Pro Pack']->active_version >= 200400
             **
             **/
            function configure_propack() {
               global $quotepress_plugin;
               $quotepress_plugin->propack_enabled = true;
            }
    }
}


