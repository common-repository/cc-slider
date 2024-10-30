<?php
/*
* Exit if accessed directly.
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds admin menu page called 'cc Slider' in the Settings option of dashboard.
 *
 * @since 1.0.0
 */
class ccs_admin{
	function __construct(){
		add_action( 'admin_menu', array($this,'cc_slider_menu_page') );
		add_action('admin_init', array($this,'cc_slider_register_settings') );
		add_action( 'init',  array($this,'cc_slider_init') );
		add_action( 'save_post', array($this,'cc_slider_save_meta_box_data') );
		add_action( 'add_meta_boxes', array($this,'cc_slider_add_meta_box') );
		


	}
	
	/**
	 * Registers menu page for plugin.
	 *
	 * @since 1.0.0
	 */
	function cc_slider_menu_page() {
		add_options_page( 'CC Slider', 'CC Slider', 'administrator', 'cc-slider', array($this,'ccs_slider_custom_function'), '', 6 );
	}

	/**
	 * Registers settings for slider.
	 *
	 * @since 1.0.0
	 */
	function cc_slider_register_settings(){
		//This will save the option in the wp_options table as 'cc_slider_settings'.
		//The third parameter is a function that will validate your input values.
		register_setting('cc_slider_settings', 'cc_slider_settings', '');
	}

	/**
	 * Function displays two tabs, one for slider settings and another one for options. 
	 * Retrives saved settings from the database if settings are saved. Else, displays fresh forms 	 for settings.
	 *
	 * @since 1.0.0
	 */
	function ccs_slider_custom_function() { 
		//Includes slider settings and options file.
		require_once( CC_BASE_PATH .'/admin/section.php');

	}  


	/**
	 * Register a Slider post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	function cc_slider_init() {
		$labels = array(
			'name'               => _x( 'Sliders', 'post type general name', 'cc-slider' ),
			'singular_name'      => _x( 'Slider', 'post type singular name', 'cc-slider' ),
			'menu_name'          => _x( 'Sliders', 'admin menu', 'cc-slider' ),
			'name_admin_bar'     => _x( 'Slider', 'add new on admin bar', 'cc-slider' ),
			'add_new'            => _x( 'Add New', 'Slider', 'cc-slider' ),
			'add_new_item'       => __( 'Add New Slider', 'cc-slider' ),
			'new_item'           => __( 'New Slider', 'cc-slider' ),
			'edit_item'          => __( 'Edit Slider', 'cc-slider' ),
			'view_item'          => __( 'View Slider', 'cc-slider' ),
			'all_items'          => __( 'All Sliders', 'cc-slider' ),
			'search_items'       => __( 'Search Sliders', 'cc-slider' ),
			'parent_item_colon'  => __( 'Parent Sliders:', 'cc-slider' ),
			'not_found'          => __( 'No Sliders found.', 'cc-slider' ),
			'not_found_in_trash' => __( 'No Sliders found in Trash.', 'cc-slider' )
		);

		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Description.', 'cc-slider' ),
	        'menu_icon'			 => 'dashicons-format-gallery',
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'cc-slider' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail')
		);

		register_post_type( 'cc-slider', $args );
	}



/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function cc_slider_add_meta_box() {

    $screens = array( 'cc-slider' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'cc_slider_header_section',
            __( 'Add URL for slider caption', 'cc_slider' ),
            array( $this, 'cc_slider_meta_box_callback' ),
            $screen
        );
    }
}

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function cc_slider_meta_box_callback( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'cc_slider_save_meta_box_data', 'cc_slider_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $url = get_post_meta( $post->ID, 'cc_slider_url', true );
    
    echo '<label for="cc_slider_url">';
    _e( 'Caption URL:', 'wp-cc_slider-map' );
    echo '</label> ';
    echo '<input type="text" id="cc_slider_url" name="cc_slider_url" value="' . esc_url( $url ) . '" size="25"
    /><br><br><hr>';


}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function cc_slider_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['cc_slider_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['cc_slider_meta_box_nonce'], 'cc_slider_save_meta_box_data' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if ( ! isset( $_POST['cc_slider_url'])) {
        return;
    }

    // Sanitize user input.
    $url = sanitize_text_field( $_POST['cc_slider_url'] );
    
    // Update the meta field in the database.
    update_post_meta( $post_id, 'cc_slider_url', $url );
    

}
}
$admin_obj = new ccs_admin();