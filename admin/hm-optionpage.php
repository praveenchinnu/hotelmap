<?php
/**
 * Add option feilds
 *
 * @param post $post The post object
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */

$hm_bg_color_default = esc_attr( get_option('hm_bg_color_default') );
$hm_font_color_default = esc_attr( get_option('hm_font_color_default') );
$hm_map_width_default = esc_attr( get_option('hm_map_width_default') );
$hm_map_height_default = esc_attr( get_option('hm_map_height_default') );


/* HM default values */

$hm_bg_color_default = $hm_bg_color_default ? $hm_bg_color_default : '#6442ff';
$hm_font_color_default = $hm_font_color_default ? $hm_font_color_default : '#ffffff';
$hm_map_height_default = $hm_map_height_default ? $hm_map_height_default : '600px';
$hm_map_width_default = $hm_map_width_default ? $hm_map_width_default : '100%';

?>

<div class="hm_col_group">
    <div class="hm_col_1">
        <p><label for="hm_bg_color_default">Default Background Colour</label></p>
        <p><input type="text" name="hm_bg_color_default" class="hm_bg_color" value="<?php echo $hm_bg_color_default; ?>" /></p>                
    </div>
    <div class="hm_col_2">
        <p><label for="hm_font_color_default">Default Font Colour</label></p>
        <p><input type="text" name="hm_font_color_default" class="hm_font_color" value="<?php echo $hm_font_color_default; ?>" /></p>                 
    </div>
</div>
<div class="hm_col_group">
    <div class="hm_col_1">
        <p><label for="hm_map_height_default">Map Height</label></p>
        <p><input type="text" name="hm_map_height_default" id="hm_map_height_default" value="<?php echo $hm_map_height_default; ?>" /></p>                
    </div>
    <div class="hm_col_2">
        <p><label for="hm_map_width_default">Map Width</label></p>
        <p><input type="text" name="hm_map_width_default" id="hm_map_width_default" value="<?php echo $hm_map_width_default; ?>" /></p>                 
    </div>
</div>