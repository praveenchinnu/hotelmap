<?php
/*
Plugin Name: Hotel Maps Pro
Plugin URI: https://www.hotelmapspro.com/
Description: Hotel Maps Pro allows you to add an unlimited number of maps to your website to help your attendees find nearby hotels and accommodation at the best prices.
Version: 1.0.13
Author: Hotel Maps Pro
Author URI: https://www.hotelmapspro.com/
Update Server: 
Min WP Version: 3.2.1
Max WP Version: 
*/


define('HM_PRO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

class HM_pro {
    /**
     * Construct the plugin object
     */
    public function __construct() {
          /*
            Including required files
          */
          add_action('plugins_loaded', array($this, 'hm_include_files'));
    }

    /*
      Including required files
    */
   public function hm_include_files(){

		// create new post type slug - hotelmap
		require HM_PRO_PLUGIN_DIR . 'admin/hm-posttype.php';
		$hm_posttype = new HMPosttype();
		// contains helper funciton for hotelmap
		include_once HM_PRO_PLUGIN_DIR . 'admin/hm-helper-functions.php';
		// meta function - hotelmap    
		include_once HM_PRO_PLUGIN_DIR . 'admin/hm-meta-functions.php';
		// shortcode function - hotelmap pro
		require HM_PRO_PLUGIN_DIR . 'admin/hm-shortcode.php';
		new HMProShortcode();          
   }

}

$HM_pro = new HM_pro();
?>