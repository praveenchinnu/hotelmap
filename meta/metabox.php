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
<h3>Design</h3>
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
       <option value="">Auto</option>
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
       <option value="">Auto</option>
       <option <?php if($hm_currency == 'AED'){ echo 'selected="selected"'; }?> value="AED">AED</option>
       <option <?php if($hm_currency == 'AFN'){ echo 'selected="selected"'; }?> value="AFN">AFN</option>
       <option <?php if($hm_currency == 'ALL'){ echo 'selected="selected"'; }?> value="ALL">ALL</option>
       <option <?php if($hm_currency == 'AMD'){ echo 'selected="selected"'; }?> value="AMD">AMD</option>
       <option <?php if($hm_currency == 'ANG'){ echo 'selected="selected"'; }?> value="ANG">ANG</option>
       <option <?php if($hm_currency == 'AOA'){ echo 'selected="selected"'; }?> value="AOA">AOA</option>
       <option <?php if($hm_currency == 'ARS'){ echo 'selected="selected"'; }?> value="ARS">ARS</option>
       <option <?php if($hm_currency == 'AUD'){ echo 'selected="selected"'; }?> value="AUD">AUD</option>
       <option <?php if($hm_currency == 'AWG'){ echo 'selected="selected"'; }?> value="AWG">AWG</option>
       <option <?php if($hm_currency == 'AZN'){ echo 'selected="selected"'; }?> value="AZN">AZN</option>
       <option <?php if($hm_currency == 'BAM'){ echo 'selected="selected"'; }?> value="BAM">BAM</option>
       <option <?php if($hm_currency == 'BBD'){ echo 'selected="selected"'; }?> value="BBD">BBD</option>
       <option <?php if($hm_currency == 'BDT'){ echo 'selected="selected"'; }?> value="BDT">BDT</option>
       <option <?php if($hm_currency == 'BGN'){ echo 'selected="selected"'; }?> value="BGN">BGN</option>
       <option <?php if($hm_currency == 'BHD'){ echo 'selected="selected"'; }?> value="BHD">BHD</option>
       <option <?php if($hm_currency == 'BIF'){ echo 'selected="selected"'; }?> value="BIF">BIF</option>
       <option <?php if($hm_currency == 'BMD'){ echo 'selected="selected"'; }?> value="BMD">BMD</option>
       <option <?php if($hm_currency == 'BND'){ echo 'selected="selected"'; }?> value="BND">BND</option>
       <option <?php if($hm_currency == 'BOB'){ echo 'selected="selected"'; }?> value="BOB">BOB</option>
       <option <?php if($hm_currency == 'BRL'){ echo 'selected="selected"'; }?> value="BRL">BRL</option>
       <option <?php if($hm_currency == 'BSD'){ echo 'selected="selected"'; }?> value="BSD">BSD</option>
       <option <?php if($hm_currency == 'BTN'){ echo 'selected="selected"'; }?> value="BTN">BTN</option>
       <option <?php if($hm_currency == 'BWP'){ echo 'selected="selected"'; }?> value="BWP">BWP</option>
       <option <?php if($hm_currency == 'BYN'){ echo 'selected="selected"'; }?> value="BYN">BYN</option>
       <option <?php if($hm_currency == 'BZD'){ echo 'selected="selected"'; }?> value="BZD">BZD</option>
       <option <?php if($hm_currency == 'CAD'){ echo 'selected="selected"'; }?> value="CAD">CAD</option>
       <option <?php if($hm_currency == 'CDF'){ echo 'selected="selected"'; }?> value="CDF">CDF</option>
       <option <?php if($hm_currency == 'CHF'){ echo 'selected="selected"'; }?> value="CHF">CHF</option>
       <option <?php if($hm_currency == 'CLP'){ echo 'selected="selected"'; }?> value="CLP">CLP</option>
       <option <?php if($hm_currency == 'CNH'){ echo 'selected="selected"'; }?> value="CNH">CNH</option>
       <option <?php if($hm_currency == 'CNY'){ echo 'selected="selected"'; }?> value="CNY">CNY / CNH</option>
       <option <?php if($hm_currency == 'COP'){ echo 'selected="selected"'; }?> value="COP">COP</option>
       <option <?php if($hm_currency == 'CRC'){ echo 'selected="selected"'; }?> value="CRC">CRC</option>
       <option <?php if($hm_currency == 'CUC'){ echo 'selected="selected"'; }?> value="CUC">CUC</option>
       <option <?php if($hm_currency == 'CUP'){ echo 'selected="selected"'; }?> value="CUP">CUP</option>
       <option <?php if($hm_currency == 'CVE'){ echo 'selected="selected"'; }?> value="CVE">CVE</option>
       <option <?php if($hm_currency == 'CZK'){ echo 'selected="selected"'; }?> value="CZK">CZK</option>
       <option <?php if($hm_currency == 'DJF'){ echo 'selected="selected"'; }?> value="DJF">DJF</option>
       <option <?php if($hm_currency == 'DKK'){ echo 'selected="selected"'; }?> value="DKK">DKK</option>
       <option <?php if($hm_currency == 'DOP'){ echo 'selected="selected"'; }?> value="DOP">DOP</option>
       <option <?php if($hm_currency == 'DZD'){ echo 'selected="selected"'; }?> value="DZD">DZD</option>
       <option <?php if($hm_currency == 'EGP'){ echo 'selected="selected"'; }?> value="EGP">EGP</option>
       <option <?php if($hm_currency == 'ERN'){ echo 'selected="selected"'; }?> value="ERN">ERN</option>
       <option <?php if($hm_currency == 'ETB'){ echo 'selected="selected"'; }?> value="ETB">ETB</option>
       <option <?php if($hm_currency == 'EUR'){ echo 'selected="selected"'; }?> value="EUR">EUR</option>
       <option <?php if($hm_currency == 'FJD'){ echo 'selected="selected"'; }?> value="FJD">FJD</option>
       <option <?php if($hm_currency == 'FKP'){ echo 'selected="selected"'; }?> value="FKP">FKP</option>
       <option <?php if($hm_currency == 'GBP'){ echo 'selected="selected"'; }?> value="GBP">GBP</option>
       <option <?php if($hm_currency == 'GEL'){ echo 'selected="selected"'; }?> value="GEL">GEL</option>
       <option <?php if($hm_currency == 'GGP'){ echo 'selected="selected"'; }?> value="GGP">GGP</option>
       <option <?php if($hm_currency == 'GHS'){ echo 'selected="selected"'; }?> value="GHS">GHS</option>
       <option <?php if($hm_currency == 'GIP'){ echo 'selected="selected"'; }?> value="GIP">GIP</option>
       <option <?php if($hm_currency == 'GMD'){ echo 'selected="selected"'; }?> value="GMD">GMD</option>
       <option <?php if($hm_currency == 'GNF'){ echo 'selected="selected"'; }?> value="GNF">GNF</option>
       <option <?php if($hm_currency == 'GTQ'){ echo 'selected="selected"'; }?> value="GTQ">GTQ</option>
       <option <?php if($hm_currency == 'GYD'){ echo 'selected="selected"'; }?> value="GYD">GYD</option>
       <option <?php if($hm_currency == 'HKD'){ echo 'selected="selected"'; }?> value="HKD">HKD</option>
       <option <?php if($hm_currency == 'HNL'){ echo 'selected="selected"'; }?> value="HNL">HNL</option>
       <option <?php if($hm_currency == 'HRK'){ echo 'selected="selected"'; }?> value="HRK">HRK</option>
       <option <?php if($hm_currency == 'HTG'){ echo 'selected="selected"'; }?> value="HTG">HTG</option>
       <option <?php if($hm_currency == 'HUF'){ echo 'selected="selected"'; }?> value="HUF">HUF</option>
       <option <?php if($hm_currency == 'IDR'){ echo 'selected="selected"'; }?> value="IDR">IDR</option>
       <option <?php if($hm_currency == 'ILS'){ echo 'selected="selected"'; }?> value="ILS">ILS</option>
       <option <?php if($hm_currency == 'IMP'){ echo 'selected="selected"'; }?> value="IMP">IMP</option>
       <option <?php if($hm_currency == 'INR'){ echo 'selected="selected"'; }?> value="INR">INR</option>
       <option <?php if($hm_currency == 'IQD'){ echo 'selected="selected"'; }?> value="IQD">IQD</option>
       <option <?php if($hm_currency == 'IRR'){ echo 'selected="selected"'; }?> value="IRR">IRR</option>
       <option <?php if($hm_currency == 'ISK'){ echo 'selected="selected"'; }?> value="ISK">ISK</option>
       <option <?php if($hm_currency == 'JEP'){ echo 'selected="selected"'; }?> value="JEP">JEP</option>
       <option <?php if($hm_currency == 'JMD'){ echo 'selected="selected"'; }?> value="JMD">JMD</option>
       <option <?php if($hm_currency == 'JOD'){ echo 'selected="selected"'; }?> value="JOD">JOD</option>
       <option <?php if($hm_currency == 'JPY'){ echo 'selected="selected"'; }?> value="JPY">JPY</option>
       <option <?php if($hm_currency == 'KES'){ echo 'selected="selected"'; }?> value="KES">KES</option>
       <option <?php if($hm_currency == 'KGS'){ echo 'selected="selected"'; }?> value="KGS">KGS</option>
       <option <?php if($hm_currency == 'KHR'){ echo 'selected="selected"'; }?> value="KHR">KHR</option>
       <option <?php if($hm_currency == 'KMF'){ echo 'selected="selected"'; }?> value="KMF">KMF</option>
       <option <?php if($hm_currency == 'KPW'){ echo 'selected="selected"'; }?> value="KPW">KPW</option>
       <option <?php if($hm_currency == 'KRW'){ echo 'selected="selected"'; }?> value="KRW">KRW</option>
       <option <?php if($hm_currency == 'KWD'){ echo 'selected="selected"'; }?> value="KWD">KWD</option>
       <option <?php if($hm_currency == 'KYD'){ echo 'selected="selected"'; }?> value="KYD">KYD</option>
       <option <?php if($hm_currency == 'KZT'){ echo 'selected="selected"'; }?> value="KZT">KZT</option>
       <option <?php if($hm_currency == 'LAK'){ echo 'selected="selected"'; }?> value="LAK">LAK</option>
       <option <?php if($hm_currency == 'LBP'){ echo 'selected="selected"'; }?> value="LBP">LBP</option>
       <option <?php if($hm_currency == 'LKR'){ echo 'selected="selected"'; }?> value="LKR">LKR</option>
       <option <?php if($hm_currency == 'LRD'){ echo 'selected="selected"'; }?> value="LRD">LRD</option>
       <option <?php if($hm_currency == 'LSL'){ echo 'selected="selected"'; }?> value="LSL">LSL</option>
       <option <?php if($hm_currency == 'LYD'){ echo 'selected="selected"'; }?> value="LYD">LYD</option>
       <option <?php if($hm_currency == 'MAD'){ echo 'selected="selected"'; }?> value="MAD">MAD</option>
       <option <?php if($hm_currency == 'MDL'){ echo 'selected="selected"'; }?> value="MDL">MDL</option>
       <option <?php if($hm_currency == 'MGA'){ echo 'selected="selected"'; }?> value="MGA">MGA</option>
       <option <?php if($hm_currency == 'MKD'){ echo 'selected="selected"'; }?> value="MKD">MKD</option>
       <option <?php if($hm_currency == 'MMK'){ echo 'selected="selected"'; }?> value="MMK">MMK</option>
       <option <?php if($hm_currency == 'MNT'){ echo 'selected="selected"'; }?> value="MNT">MNT</option>
       <option <?php if($hm_currency == 'MOP'){ echo 'selected="selected"'; }?> value="MOP">MOP</option>
       <option <?php if($hm_currency == 'MRO'){ echo 'selected="selected"'; }?> value="MRO">MRO</option>
       <option <?php if($hm_currency == 'MRU'){ echo 'selected="selected"'; }?> value="MRU">MRU</option>
       <option <?php if($hm_currency == 'MUR'){ echo 'selected="selected"'; }?> value="MUR">MUR</option>
       <option <?php if($hm_currency == 'MVR'){ echo 'selected="selected"'; }?> value="MVR">MVR</option>
       <option <?php if($hm_currency == 'MWK'){ echo 'selected="selected"'; }?> value="MWK">MWK</option>
       <option <?php if($hm_currency == 'MXN'){ echo 'selected="selected"'; }?> value="MXN">MXN</option>
       <option <?php if($hm_currency == 'MYR'){ echo 'selected="selected"'; }?> value="MYR">MYR</option>
       <option <?php if($hm_currency == 'MZN'){ echo 'selected="selected"'; }?> value="MZN">MZN</option>
       <option <?php if($hm_currency == 'NAD'){ echo 'selected="selected"'; }?> value="NAD">NAD</option>
       <option <?php if($hm_currency == 'NGN'){ echo 'selected="selected"'; }?> value="NGN">NGN</option>
       <option <?php if($hm_currency == 'NIO'){ echo 'selected="selected"'; }?> value="NIO">NIO</option>
       <option <?php if($hm_currency == 'NOK'){ echo 'selected="selected"'; }?> value="NOK">NOK</option>
       <option <?php if($hm_currency == 'NPR'){ echo 'selected="selected"'; }?> value="NPR">NPR</option>
       <option <?php if($hm_currency == 'NZD'){ echo 'selected="selected"'; }?> value="NZD">NZD</option>
       <option <?php if($hm_currency == 'OMR'){ echo 'selected="selected"'; }?> value="OMR">OMR</option>
       <option <?php if($hm_currency == 'PAB'){ echo 'selected="selected"'; }?> value="PAB">PAB</option>
       <option <?php if($hm_currency == 'PEN'){ echo 'selected="selected"'; }?> value="PEN">PEN</option>
       <option <?php if($hm_currency == 'PGK'){ echo 'selected="selected"'; }?> value="PGK">PGK</option>
       <option <?php if($hm_currency == 'PHP'){ echo 'selected="selected"'; }?> value="PHP">PHP</option>
       <option <?php if($hm_currency == 'PKR'){ echo 'selected="selected"'; }?> value="PKR">PKR</option>
       <option <?php if($hm_currency == 'PLN'){ echo 'selected="selected"'; }?> value="PLN">PLN</option>
       <option <?php if($hm_currency == 'PYG'){ echo 'selected="selected"'; }?> value="PYG">PYG</option>
       <option <?php if($hm_currency == 'QAR'){ echo 'selected="selected"'; }?> value="QAR">QAR</option>
       <option <?php if($hm_currency == 'RON'){ echo 'selected="selected"'; }?> value="RON">RON</option>
       <option <?php if($hm_currency == 'RSD'){ echo 'selected="selected"'; }?> value="RSD">RSD</option>
       <option <?php if($hm_currency == 'RUB'){ echo 'selected="selected"'; }?> value="RUB">RUB</option>
       <option <?php if($hm_currency == 'RWF'){ echo 'selected="selected"'; }?> value="RWF">RWF</option>
       <option <?php if($hm_currency == 'SAR'){ echo 'selected="selected"'; }?> value="SAR">SAR</option>
       <option <?php if($hm_currency == 'SBD'){ echo 'selected="selected"'; }?> value="SBD">SBD</option>
       <option <?php if($hm_currency == 'SCR'){ echo 'selected="selected"'; }?> value="SCR">SCR</option>
       <option <?php if($hm_currency == 'SDG'){ echo 'selected="selected"'; }?> value="SDG">SDG</option>
       <option <?php if($hm_currency == 'SEK'){ echo 'selected="selected"'; }?> value="SEK">SEK</option>
       <option <?php if($hm_currency == 'SGD'){ echo 'selected="selected"'; }?> value="SGD">SGD</option>
       <option <?php if($hm_currency == 'SHP'){ echo 'selected="selected"'; }?> value="SHP">SHP</option>
       <option <?php if($hm_currency == 'SLL'){ echo 'selected="selected"'; }?> value="SLL">SLL</option>
       <option <?php if($hm_currency == 'SOS'){ echo 'selected="selected"'; }?> value="SOS">SOS</option>
       <option <?php if($hm_currency == 'SRD'){ echo 'selected="selected"'; }?> value="SRD">SRD</option>
       <option <?php if($hm_currency == 'SSP'){ echo 'selected="selected"'; }?> value="SSP">SSP</option>
       <option <?php if($hm_currency == 'STD'){ echo 'selected="selected"'; }?> value="STD">STD</option>
       <option <?php if($hm_currency == 'STN'){ echo 'selected="selected"'; }?> value="STN">STN</option>
       <option <?php if($hm_currency == 'SVC'){ echo 'selected="selected"'; }?> value="SVC">SVC</option>
       <option <?php if($hm_currency == 'SYP'){ echo 'selected="selected"'; }?> value="SYP">SYP</option>
       <option <?php if($hm_currency == 'SZL'){ echo 'selected="selected"'; }?> value="SZL">SZL</option>
       <option <?php if($hm_currency == 'THB'){ echo 'selected="selected"'; }?> value="THB">THB</option>
       <option <?php if($hm_currency == 'TJS'){ echo 'selected="selected"'; }?> value="TJS">TJS</option>
       <option <?php if($hm_currency == 'TMT'){ echo 'selected="selected"'; }?> value="TMT">TMT</option>
       <option <?php if($hm_currency == 'TND'){ echo 'selected="selected"'; }?> value="TND">TND</option>
       <option <?php if($hm_currency == 'TOP'){ echo 'selected="selected"'; }?> value="TOP">TOP</option>
       <option <?php if($hm_currency == 'TRY'){ echo 'selected="selected"'; }?> value="TRY">TRY</option>
       <option <?php if($hm_currency == 'TTD'){ echo 'selected="selected"'; }?> value="TTD">TTD</option>
       <option <?php if($hm_currency == 'TWD'){ echo 'selected="selected"'; }?> value="TWD">TWD</option>
       <option <?php if($hm_currency == 'TZS'){ echo 'selected="selected"'; }?> value="TZS">TZS</option>
       <option <?php if($hm_currency == 'UAH'){ echo 'selected="selected"'; }?> value="UAH">UAH</option>
       <option <?php if($hm_currency == 'UGX'){ echo 'selected="selected"'; }?> value="UGX">UGX</option>
       <option <?php if($hm_currency == 'USD'){ echo 'selected="selected"'; }?> value="USD">USD</option>
       <option <?php if($hm_currency == 'UYU'){ echo 'selected="selected"'; }?> value="UYU">UYU</option>
       <option <?php if($hm_currency == 'UZS'){ echo 'selected="selected"'; }?> value="UZS">UZS</option>
       <option <?php if($hm_currency == 'VEF'){ echo 'selected="selected"'; }?> value="VEF">VEF</option>
       <option <?php if($hm_currency == 'VES'){ echo 'selected="selected"'; }?> value="VES">VES</option>
       <option <?php if($hm_currency == 'VND'){ echo 'selected="selected"'; }?> value="VND">VND</option>
       <option <?php if($hm_currency == 'VUV'){ echo 'selected="selected"'; }?> value="VUV">VUV</option>
       <option <?php if($hm_currency == 'WST'){ echo 'selected="selected"'; }?> value="WST">WST</option>
       <option <?php if($hm_currency == 'YER'){ echo 'selected="selected"'; }?> value="YER">YER</option>
       <option <?php if($hm_currency == 'ZAR'){ echo 'selected="selected"'; }?> value="ZAR">ZAR</option>
       <option <?php if($hm_currency == 'ZMW'){ echo 'selected="selected"'; }?> value="ZMW">ZMW</option>
       <option <?php if($hm_currency == 'ZWL'){ echo 'selected="selected"'; }?> value="ZWL">ZWL</option>
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
  