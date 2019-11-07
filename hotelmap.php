<?php
/*
Plugin Name: HotelMap
Plugin URI: http://www.HotelMaps.com/
Description: Dynamic Generate your maps and shortcodes.
Version: 1.0.0
Author: HotelMaps Developer
Author URI: http://www.HotelMaps.com/
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