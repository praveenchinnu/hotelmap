<?php
// create custom plugin settings menu

add_action('admin_menu', 'hm_option_menu');

function hm_option_menu() {

  global $wpdb;
  
  //create new top-level menu
  $hm_plugin_path = plugins_url( 'asset', plugin_basename( dirname( __FILE__ ) ) );  
  add_menu_page('HotelMap', 'HotelMap', 'administrator', 'hotelmap', 'hotelmap_option_page', $hm_plugin_path .'/images/hm-icon.png');
  add_submenu_page('hotelmap', 'HM Pro Dashboard', 'Dashboard', 'administrator', 'hotelmap' );  

  if(get_option('hm_client_id')) {  
    add_submenu_page( 'hotelmap', 'HM Create New Map', 'Create New Map', 'administrator', 'post-new.php?post_type=hotelmap' );
    add_submenu_page( 'hotelmap', 'Hotel Map List', 'Map List', 'administrator', 'edit.php?post_type=hotelmap' );
  }

  //call register settings function
  add_action( 'admin_init', 'hotelmap_option_page_feilds' );
}

function hotelmap_option_page_feilds() {
  //register our settings
  register_setting( 'hm_settings_group', 'hm_client_id' );
  register_setting( 'hm_settings_group', 'hm_bg_color_default' );
  register_setting( 'hm_settings_group', 'hm_font_color_default' );
  register_setting( 'hm_settings_group', 'hm_map_height_default' );
  register_setting( 'hm_settings_group', 'hm_map_width_default' );
}


function hotelmap_option_page() {
global $wpdb;
?>
<div class="wrap">
<h3 style="text-align: right;"><a href="" title="Plugin Support">Plugin Support</a></h3>
<h2 style="text-align: center;">Welcome to HotelMapsPro.</h2>
<div style="text-align: center;">
  <a class="new-map-cta" href="<?php echo get_site_url(); ?>/wp-admin/post-new.php?post_type=hotelmap" title="Create new map">CREATE NEW MAP</a>
</div>
<form method="post" action="options.php">
<?php settings_fields( 'hm_settings_group' ); ?>
<?php do_settings_sections( 'hm_settings_group' ); ?>
  
<?php if(get_option('hm_client_id')) { ?>
  <h4 style="text-align: center;">Your client ID below.</h4>
  <h4 style="text-align: center;">
    <span class="hm-cid"><strong>Client ID:</strong> <?php echo esc_attr( get_option('hm_client_id') ); ?></span> 
  </h4>
<?php } ?>

<div style="<?php if(get_option('hm_client_id')) { echo "display: none"; } ?>">
  <h4 style="text-align: center;">To start using this plugin please create a client ID below.</h4>
  <div class="hm_col_group">
      <div class="hm_col_full" style="width: 320px; margin: 0 auto 25px; text-align: center;">          
          <p><input type="text" name="hm_client_id" placeholder="Client ID" id="hm_client_id" class="hm_client_id" value="<?php echo esc_attr( get_option('hm_client_id') ); ?>" /></p> 
          <small>Please avoid characters that can disrupt an URL such as & . ' " # % > < / _ (we use underscore/low dashes for our own internal tracking. Feel free to use normal dashes).</small>               
      </div>
  </div>
</div>

<!-- Client ID -->

<div class="truefalsedisplay"><b>Default settings</b>
    <label class="switch">
      <input class="truefalsebtn" type="checkbox" checked="checked">
      <span class="slider round"></span>
    </label>

    <div class="truefalsepanel" style="display: block;">
         <?php include_once HM_PRO_PLUGIN_DIR . 'admin/hm-optionpage.php'; ?>
    </div>
</div>
  <?php submit_button(); ?>
  </form>
</div>
<?php } ?>