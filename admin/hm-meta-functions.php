<?php
/**
 * Add meta box
 *
 * @param post $post The post object
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */

add_action( 'add_meta_boxes', 'hm_meta_box_add' );

function hm_meta_box_add()
{
    add_meta_box( 'hotelmap-box-setupid', 'Setup Box', 'hotelmap_meta_box_cb', 'hotelmap', 'normal', 'high' );
    add_meta_box("hotelmap-box-shortcode", "Shortcode", "hm_shortcodebox", "hotelmap", "side", "default");
}

function hotelmap_meta_box_cb()
{
    // $post is already set, and contains an object: the WordPress post
     include_once HM_PRO_PLUGIN_DIR . './meta/metabox.php';
  
}

function hm_shortcodebox($post_id){
  global $post;
  //echo $post->ID;
  echo '<div class="hmshortcodebox">[hotel_maps_pro id="'.$post->ID.'"]</div>';
}

/* HM Save meta details */

add_action( 'save_post', 'hm_meta_box_save' );

function hm_meta_box_save( $post_id )
{

    global $post;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post->ID;
    }

    $fields = [
        'hm_venue_detail_name',
        'hm_venue_detail',
        'hm_latitude',
        'hm_longitude',
        'hm_start_event_date',
        'hm_end_event_date',
        'first_featured_img',
        'second_featured_img',
        'hm_language',
        'hm_currency',
        'hm_pricing',
        'hm_bg_color',
        'hm_font_color',
        'hm_map_height',
        'hm_map_width',
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
        }
     }

    $chkboxfields = [
        'hm_display_onlybookcom',
        'hm_disable_hotel',
        'hm_disable_airbnb',
        'hm_disable_travel_serv',
    ];
    if($_POST){
      foreach ( $chkboxfields as $chkboxfield ) {
          update_post_meta( $post_id, $chkboxfield, sanitize_text_field( $_POST[$chkboxfield] ) );
       }
     }

}

function hm_include_script() {
  /*
   * I recommend to add additional conditions just to not to load the scipts on each page
   * like:
   * if ( !in_array('post-new.php','post.php') ) return;
   */
  if ( ! did_action( 'wp_enqueue_media' ) ) {
    wp_enqueue_media();
  }

  $hm_plugin_path = plugins_url( 'asset', plugin_basename( dirname( __FILE__ ) ) );
 
  wp_enqueue_script( 'jquery-ui-datepicker' );
  wp_enqueue_style( 'wp-color-picker');
  wp_enqueue_script( 'wp-color-picker');  
  wp_enqueue_script( 'hmuploadscript', $hm_plugin_path .'/js/script.js', array('jquery'), null, false );
  wp_register_style('jquery-hm-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
  wp_enqueue_style( 'jquery-hm-ui-style' );  
  wp_enqueue_style( 'jquery-hm-main-style', $hm_plugin_path .'/css/main.css');   
}
 
add_action( 'admin_enqueue_scripts', 'hm_include_script' );
?>