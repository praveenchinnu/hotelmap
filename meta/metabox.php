<?php
global $post;

/* HM Get post meta */

$values = get_post_custom( $post->ID );
$hm_venue_detail_name = get_post_meta( $post->ID, 'hm_venue_detail_name', true );
$hm_venue_detail = get_post_meta( $post->ID, 'hm_venue_detail', true );
$hm_start_event_date = get_post_meta( $post->ID, 'hm_start_event_date', true );
$hm_end_event_date = get_post_meta( $post->ID, 'hm_end_event_date', true );
$hm_latitude = get_post_meta( $post->ID, 'hm_latitude', true );
$hm_longitude = get_post_meta( $post->ID, 'hm_longitude', true );
$hm_bg_color = get_post_meta( $post->ID, 'hm_bg_color', true );
$hm_font_color = get_post_meta( $post->ID, 'hm_font_color', true );
$hm_map_height = get_post_meta( $post->ID, 'hm_map_height', true );
$hm_map_width = get_post_meta( $post->ID, 'hm_map_width', true );
$hm_language = get_post_meta( $post->ID, 'hm_language', true );
$hm_currency = get_post_meta( $post->ID, 'hm_currency', true );
$hm_pricing = get_post_meta( $post->ID, 'hm_pricing', true );
$hm_disable_hotel = get_post_meta( $post->ID, 'hm_disable_hotel', true );
$hm_disable_airbnb = get_post_meta( $post->ID, 'hm_disable_airbnb', true );
$first_featured_img = get_post_meta( $post->ID, 'first_featured_img', true );
$second_featured_img = get_post_meta( $post->ID, 'second_featured_img', true );
$hm_disable_travel_serv = get_post_meta( $post->ID, 'hm_disable_travel_serv', true );
$hm_display_onlybookcom = get_post_meta( $post->ID, 'hm_display_onlybookcom', true );


/* HM default values */

$hm_bg_color_default = esc_attr( get_option('hm_bg_color_default') );
$hm_font_color_default = esc_attr( get_option('hm_font_color_default') );
$hm_map_width_default = esc_attr( get_option('hm_map_width_default') );
$hm_map_height_default = esc_attr( get_option('hm_map_height_default') );

$hm_bg_color = $hm_bg_color ? $hm_bg_color : $hm_bg_color_default;
$hm_font_color = $hm_font_color ? $hm_font_color : $hm_font_color_default;
$hm_map_height = $hm_map_height ? $hm_map_height : $hm_map_height_default;
$hm_map_width = $hm_map_width ? $hm_map_width : $hm_map_width_default;

/* HM image view function */

function hm_image_uploader_field( $name, $value = '') {
    $image = ' button">Upload image';
    $image_size = array('120','120'); // it would be better to use thumbnail size here (150x150 or so)
    $display = 'none'; // display state ot the "Remove image" button
 
    if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {
        $image = '"><img src="' . $image_attributes[0] . '" style="max-width:95%;display:block;" />';
        $display = 'inline-block';
    } 
 
    return '
    <div>
        <a href="#" class="hm_upload_image_button' . $image . '</a>
        <input type="hidden" name="' . $name . '" id="' . $name . '" value="' . esc_attr( $value ) . '" />
        <a href="#" class="hm_remove_image_button" style="display:inline-block;display:' . $display . '">Remove image</a>
    </div>';
}

// We'll use this nonce field later on when saving.
//wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
wp_nonce_field( basename(__FILE__), 'hotelmap_meta_box_cb' );
?>

<h1>Basic Settings</h1>
<p><label for="hm_venue_detail_name"><b>Venue Name</b></label></p>
<p>
    <input type="text" name="hm_venue_detail_name" placeholder="Madison Square Garden" id="hm_venue_detail_name" value="<?php echo $hm_venue_detail_name; ?>" />
</p>
<p><label for="hm_venue_detail"><b>Venue Address</b></label></p>
	<p>
    <div>Please be as accurate as possible (street address, city, country) so that we can locate the venue. If you experience problems you can provide the latitude and and longitude instead by visiting <a href="https://www.gps-coordinates.net/" target="_blank">https://www.gps-coordinates.net/</a></div>
    <input type="text" name="hm_venue_detail" placeholder="Madison Square Garden" id="hm_venue_detail" value="<?php echo $hm_venue_detail; ?>" />
</p>
<div class="truefalsedisplay"><b>Use Latitude / Longitude?</b>
    <label class="switch">
       <?php if($hm_latitude && $hm_longitude){ $chk_latlong = 'checked="checked"'; } else { $chk_latlong = ''; } ?>
      <input class="truefalsebtn" type="checkbox" <?php echo $chk_latlong; ?>>
      <span class="slider round"></span>
    </label>

    <div class="truefalsepanel" style="<?php if($hm_latitude && $hm_longitude){ echo 'display: block;'; } ?>">
        <div class="hm_col_group">
            <div class="hm_col_1">
                <p><label for="hm_latitude">Latitude</label></p>
                <p><input type="text" name="hm_latitude" id="hm_latitude" value="<?php echo $hm_latitude; ?>" /></p>                
            </div>
            <div class="hm_col_2">
                <p><label for="hm_longitude">Longitude</label></p>
                <p><input type="text" name="hm_longitude" id="hm_longitude" value="<?php echo $hm_longitude; ?>" /></p>                 
            </div>
        </div>
    </div>
</div> <!-- HM latitude/longitude -->

<h3>Event Date</h3>

<div class="hm_col_group">
    <div class="hm_col_1">
      <p><label for="hm_start_event_date">Event Start date</label></p>
      <p><input type="text" name="hm_start_event_date" class="hm_event_date"  id="hm_start_event_date" value="<?php echo $hm_start_event_date; ?>" /></p>             
    </div>
    <div class="hm_col_2">
      <p><label for="hm_end_event_date">Event End date</label></p>
      <p><input type="text" name="hm_end_event_date" class="hm_event_date"  id="hm_end_event_date" value="<?php echo $hm_end_event_date; ?>" /></p>                 
    </div>
</div> <!-- HM Event date and time -->

<h1>Advanced Settings</h1>
<h3>Desing</h3>
<div class="hm_col_group">
    <div class="hm_col_1">
        <p><label for="hm_bg_color">Default Background Colour</label></p>
        <p><input type="text" name="hm_bg_color" class="hm_bg_color" value="<?php echo $hm_bg_color; ?>" /></p>                
    </div>
    <div class="hm_col_2">
        <p><label for="hm_font_color">Default Font Colour</label></p>
        <p><input type="text" name="hm_font_color" class="hm_font_color" value="<?php echo $hm_font_color; ?>" /></p>                 
    </div>
</div> <!-- HM Background and font color -->

<div class="hm_col_group">
    <div class="hm_col_1">
        <p><label for="hm_map_height">Map Height</label></p>
        <p><input type="text" name="hm_map_height" id="hm_map_height" value="<?php echo $hm_map_height; ?>" /></p>                
    </div>
    <div class="hm_col_2">
        <p><label for="hm_map_width">Map Width</label></p>
        <p><input type="text" name="hm_map_width" id="hm_map_width" value="<?php echo $hm_map_width; ?>" /></p>                 
    </div>
</div>  <!-- HM Map height and width -->

<div class="hm_col_group">
<div class="truefalsedisplay"><b>Use Custom Marker?</b>
    <label class="switch">
      <?php if($first_featured_img){ $chk_marker = 'checked="checked"'; } else { $chk_marker = ''; } ?>
      <input class="truefalsebtn" type="checkbox" <?php echo $chk_marker; ?>>
      <span class="slider round"></span>
    </label>

    <div class="truefalsepanel" style="<?php if($first_featured_img){ echo 'display: block;'; } ?>" >
        <div style="margin-bottom: 15px;">For best results, use a square icon no bigger than 128 x 128 pixels</div>
        <?php echo hm_image_uploader_field( 'first_featured_img', $first_featured_img ); ?>
    </div>
</div>
</div> <!-- HM Customer marker -->

<div class="truefalsedisplay"><b>Use Custom Logo?</b>
    <label class="switch">
       <?php if($second_featured_img){ $chk_logo = 'checked="checked"'; } else { $chk_logo = ''; } ?>
      <input class="truefalsebtn" type="checkbox" <?php echo $chk_logo; ?>>
      <span class="slider round"></span>
    </label>

    <div class="truefalsepanel" style="<?php if($second_featured_img){ echo 'display: block;';  } ?>">
        <div style="margin-bottom: 15px;">For best results, use a square icon no bigger than 128 x 128 pixels</div>
        <?php echo hm_image_uploader_field( 'second_featured_img', $second_featured_img ); ?>
    </div>
</div> <!-- HM Custom logo -->

<h3>Localisation</h3>

<p><label for="hm_language"><b>We automatically detect the user's language, but if you wish to force it, we support these languages:</b></label>
   <select name="hm_language" class="hm_language">
       <option value="">auto</option>
       <option <?php if($hm_language == 'en'){ echo 'selected="selected"'; }?> value="en">English</option>
       <option <?php if($hm_language == 'fr'){ echo 'selected="selected"'; }?> value="fr">Français</option>
       <option <?php if($hm_language == 'es'){ echo 'selected="selected"'; }?> value="es">Español</option>
       <option <?php if($hm_language == 'de'){ echo 'selected="selected"'; }?> value="de">Deutsch</option>
       <option <?php if($hm_language == 'pt'){ echo 'selected="selected"'; }?> value="pt">Português</option>
       <option <?php if($hm_language == 'it'){ echo 'selected="selected"'; }?> value="it">Italiano</option>
       <option <?php if($hm_language == 'nl'){ echo 'selected="selected"'; }?> value="nl">Dutch</option>
       <option <?php if($hm_language == 'pl'){ echo 'selected="selected"'; }?> value="pl">Polskie</option>
       <option <?php if($hm_language == 'zh'){ echo 'selected="selected"'; }?> value="zh">中文 (简体)</option>
       <option <?php if($hm_language == 'zh-tw'){ echo 'selected="selected"'; }?> value="zh-tw">中文 (繁體)</option>
       <option <?php if($hm_language == 'ja'){ echo 'selected="selected"'; }?> value="ja">日本語</option>
   </select>
</p> <!-- HM User Language -->

<p><label for="hm_currency"><b>We automatically detect the user's currency, but if you wish to force it, we support all currencies.</b></label>
   <select name="hm_currency" class="hm_currency">
       <option value="">auto</option>
       <option <?php if($hm_currency == 'USD'){ echo 'selected="selected"'; }?> value="USD">USD</option>
       <option <?php if($hm_currency == 'GBP'){ echo 'selected="selected"'; }?> value="GBP">GBP</option>
   </select>
</p> <!-- HM User currency -->

<h3>Accommodation, Search & Pricing Options</h3>

<div class="truefalsedisplay"><b>Disable Hotels</b>
    <label class="switch">
      <?php if($hm_disable_hotel == "yes"){ $chk_disable_hotel = 'checked="checked"'; } else { $chk_disable_hotel = ''; } ?>
      <input class="truefalsebtn" name="hm_disable_hotel" value="yes" <?php echo $chk_disable_hotel; ?> type="checkbox">
      <span class="slider round"></span>
    </label>

    <div class="truefalsepanel">
    </div>
</div> <!-- HM Disable Hotels -->

<div class="truefalsedisplay"><b>Only Display Booking.com</b>
    <label class="switch">
      <?php if($hm_display_onlybookcom == "yes"){ $chk_display_bookcom = 'checked="checked"'; } else { $chk_display_bookcom = ''; } ?>
      <input class="truefalsebtn" type="checkbox" name="hm_display_onlybookcom" value="yes" <?php echo $chk_display_bookcom; ?> >
      <span class="slider round"></span>
    </label>
    <p>85% of customers choose to book their accommodation with Booking.com over other hotel companies due to high levels of consumer confidence, please activate this setting if you would like to hide other hotel companies and only display hotel results from Booking.com</p>
    <div class="truefalsepanel">
    </div>
</div> <!-- HM Display Booking.com -->

<div class="truefalsedisplay"><b>Disable Airbnb</b>
    <label class="switch">
      <?php
      if($hm_disable_airbnb){ $chk_disable_airbnb = 'checked="checked"'; } else { $chk_disable_airbnb = ''; } ?>
      <input class="truefalsebtn" name="hm_disable_airbnb" value="yes" <?php echo $chk_disable_airbnb; ?> type="checkbox">
      <span class="slider round"></span>
    </label>

    <div class="truefalsepanel">
    </div>
</div> <!-- HM Disable Airbnb -->

<div class="truefalsedisplay"><b>Disable Travel Services</b>
    <label class="switch">
      <?php if($hm_disable_travel_serv == "yes"){ $chk_disable_travel_serv = 'checked="checked"'; } else { $chk_disable_travel_serv = ''; } ?>
      <input class="truefalsebtn" name="hm_disable_travel_serv" value="yes" <?php echo $chk_disable_travel_serv; ?> type="checkbox">
      <span class="slider round"></span>
    </label>
    <p>In addition to accommodation your event attendees can search for local experiences, restaurants, car rentals and parking using HotelMapsPro. Please activate this setting if you would prefer to only display accommodation results to your visitors.</p>
    <div class="truefalsepanel">
    </div>
</div> <!-- HM Disable Travel Services -->

<p><label for="hm_pricing"><b>Pricing Display</b></label>
   <select name="hm_pricing">
       <option <?php if($hm_pricing == 'nightly'){ echo 'selected="selected"'; }?> value="nightly">Per Night</option>
       <option <?php if($hm_pricing == 'total'){ echo 'selected="selected"'; }?> value="total">Total</option>
   </select>
</p> <!-- HM Pricing Display -->
  