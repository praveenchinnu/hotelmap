<?php
if(!class_exists('HMPosttype'))
{
    class HMPosttype
    {
        
         /**
    	 * The Constructor
    	 */
    	public function __construct()
    	{
    		// register hooks
            add_action( 'init', array($this,'hm_custom_post_type' ));
            add_action( 'manage_hotelmap_posts_custom_column' , array($this,'custom_hm_column'), 10, 2 );
            add_filter( 'manage_hotelmap_posts_columns', array($this,'set_custom_edit_book_columns') );
    
        } // END public function __construct())

          // Register Hotel map Post Type
        function hm_custom_post_type() {

                    $labels = array(
                      'name'               => 'HotelMap',
                      'singular_name'      => 'hotelmap',
                      'add_new'            => 'Add New',
                      'add_new_item'       => 'Create new hotel',
                      'edit_item'          => 'Edit HotelMap',
                      'new_item'           => 'New HotelMap',
                      'all_items'          => 'Hotels',
                      'view_item'          => 'View HotelMap',
                      'search_items'       => 'Search HotelMap',
                      'not_found'          =>  'No hotel found',
                      'not_found_in_trash' => 'No hotel found in Trash',
                      'parent_item_colon'  => '',
                      'menu_name'          => 'HotelMap'
                    );
                   
                    $args = array(
                      'labels'             => $labels,
                      'public'             => false,
                      'publicly_queryable' => false,
                      'show_ui'            => true,
                      'show_in_menu'       => false,
                      //'show_in_menu'       => true,
                      'query_var'          => true,
                      'rewrite'            => array( 'slug' => 'hotelmap' ),
                      'capability_type'    => 'post',
                      'has_archive'        => false,
                      'hierarchical'       => false,
                      'menu_position'      => 66,
                      'show_in_nav_menus'  => false,
                      'capability_type' => 'post',
                        'capabilities' => array(
                          'read' => 'do_not_allow', // false < WP 4.5, credit @Ewout
                        ),
                        'map_meta_cap' => true, // Set to `false`, if users are not allowed to edit/delete existing posts                      
                      'supports'           => array( 'title' )
                    );
                   
                    register_post_type( 'hotelmap', $args );                    

            }

        // Add the custom columns to the HM post type:
       
        function set_custom_edit_book_columns($columns) {
            $columns['hm_shortcode'] = __( 'Shortcode', 'hm_plugin' );
            return $columns;
        }

        // Add the data to the custom columns for the HM post type:
        
        function custom_hm_column( $column, $post_id ) {
            switch ( $column ) {

              case 'hm_shortcode':
                echo '<pre>[hotel_maps_pro id="'.$post_id.'"]</pre>';
                break;

            }
        }            


  }
    
}