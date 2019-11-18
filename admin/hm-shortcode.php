<?php
if(!class_exists('HMProShortcode'))
{
    class HMProShortcode
    {
        
         /**
    	 * The Constructor
    	 */
    	public function __construct()
    	{
            // register hotel map pro shortcode
         add_action('init', array($this, 'hm_register_shortcode'));
    
      } // END public function __construct())

          // Register Hotel map Post Type
        function hm_register_shortcode() {

          add_shortcode('hotel_maps_pro', array($this,'hm_shortcode_view'));        

        } 

        function hm_shortcode_view($atts, $content = null){
          $attribute = shortcode_atts(array( 'id' => '' ), $atts);
          $hm_map_id = $attribute['id'];
          if($hm_map_id){

            $hm_venue_detail_name = get_post_meta( $hm_map_id, 'hm_venue_detail_name', true );
            $hm_venue_detail = get_post_meta( $hm_map_id, 'hm_venue_detail', true );
            $hm_start_event_date = get_post_meta( $hm_map_id, 'hm_start_event_date', true );
            $hm_end_event_date = get_post_meta( $hm_map_id, 'hm_end_event_date', true );
            $hm_latitude = get_post_meta( $hm_map_id, 'hm_latitude', true );
            $hm_longitude = get_post_meta( $hm_map_id, 'hm_longitude', true );            
            $hm_bg_color = get_post_meta( $hm_map_id, 'hm_bg_color', true );            
            $hm_font_color = get_post_meta( $hm_map_id, 'hm_font_color', true );            
            $hm_map_height = get_post_meta( $hm_map_id, 'hm_map_height', true );            
            $hm_map_width = get_post_meta( $hm_map_id, 'hm_map_width', true );
            $first_featured_img = get_post_meta( $hm_map_id, 'first_featured_img', true );
            $second_featured_img = get_post_meta( $hm_map_id, 'second_featured_img', true );
            $hm_language = get_post_meta( $hm_map_id, 'hm_language', true );
            $hm_currency = get_post_meta( $hm_map_id, 'hm_currency', true );
            $hm_pricing = get_post_meta( $hm_map_id, 'hm_pricing', true );
            $hm_disable_hotel = get_post_meta( $hm_map_id, 'hm_disable_hotel', true );
            $hm_disable_airbnb = get_post_meta( $hm_map_id, 'hm_disable_airbnb', true );
            $hm_disable_travel_serv = get_post_meta( $hm_map_id, 'hm_disable_travel_serv', true );
            $hm_display_onlybookcom = get_post_meta( $hm_map_id, 'hm_display_onlybookcom', true );

            $hm_bg_color = str_replace('#', '', $hm_bg_color);
            $hm_font_color = str_replace('#', '', $hm_font_color);
            $hm_start_event_date = strtotime($hm_start_event_date);
            $hm_end_event_date = strtotime($hm_end_event_date);

            $hm_disable_hotel = ($hm_disable_hotel == 'yes') ? 'true' : 'false';
            $hm_disable_airbnb = ($hm_disable_airbnb == 'yes') ? 'true' : 'false';

            /* $hm_disable_travel_serv = ($hm_disable_travel_serv == 'yes') ? 'true' : 'false';
            $hm_display_onlybookcom = ($hm_display_onlybookcom == 'yes') ? 'true' : 'false'; */

            //echo $first_featured_img;
            $first_featured_url_full = false;
            if( $first_featured_url = wp_get_attachment_image_src( $first_featured_img, 'full' ) ) { 
              $first_featured_url_full = $first_featured_url[0];
            }
            $second_featured_url_full = false;
            if( $second_featured_url = wp_get_attachment_image_src( $second_featured_img, 'full' ) ) { 
              $second_featured_url_full = $second_featured_url[0];
            }

            $hm_plugin_path = plugins_url( 'asset', plugin_basename( dirname( __FILE__ ) ) );
            $hmdefaultimage = $hm_plugin_path .'/images/hmp-default-marker-pin.png';

            $hm_markerimage = $first_featured_url_full ? $first_featured_url_full : $hmdefaultimage;
            $hm_navimage = $second_featured_url_full ? $second_featured_url_full : $hmdefaultimage;            

            $html='';
            $settings22 =  array('width' => $hm_map_width, 'height' => $hm_map_height );
            $hm_client_id = esc_attr( get_option('hm_client_id') );
            $hmaid = 'hotelmapspro-'. $hm_client_id .'-'. $hm_map_id .'';
            $s22obj =  array(
              'aid' => $hmaid,
              'venue' => $hm_venue_detail_name,
              'address' => $hm_venue_detail,
              'lat' => $hm_latitude,
              'lng' => $hm_longitude,
              'eventstart' => $hm_start_event_date,
              'eventend' => $hm_end_event_date,
              'maincolor' => $hm_bg_color,
              'fontcolor' => $hm_font_color,
              'height' => $hm_map_height,
              'markerimage' => $hm_markerimage,
              'navimage' => $hm_navimage,
              'ljs' => $hm_language,
              'currency' => $hm_currency,
              'priceper' => $hm_pricing,
              'disablehotels' => $hm_disable_hotel,
              'disablerentals' => $hm_disable_airbnb,
              'hidebrandlogo' => 'true',
              'hideenlargemap' => 'true',
              'hideshare' => 'true',
              'openmenu' => 'null' );

              if(!$hm_display_onlybookcom){
                $s22obj['hotelapi'] = 'hotelscombined';
              }

              $params22 = ''; 
              foreach($s22obj as $key => $key_value){
                if ($params22){
                  $params22.="&";
                }
                $params22.= $key."=". $key_value;
              }

              $html = '<iframe id="hm-pro-widget" width="'.$hm_map_width.'" height="'.$hm_map_height.'" src="https://www.stay22.com/embed/gm?'.$params22.'" frameborder="0"></iframe>';
             
              return $html;

          } else {  // Map ID
            return 'Map ID missing';
          }
        }          


  }
    
}