<?php
/**
* Plugin Name: CC Slider
* Description: Easy to use slider with awesome animation as well as features. Multiple fields is available as layer for each of the slide. It includes all the required settings for slider control. 
* Plugin URI: 
* Author:  cyclonetheme    
* Author URI:  
* Version:     1.0
* License: GPL2
* Text Domain: cc-slider
* Domain Path: /languages
*
* @package  cc Slider
*/

/*
* Exit if accessed directly.
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin base URL.
define( "CC_BASE_URL", plugin_dir_url( __FILE__ ) );
// Plugin base path.
define( "CC_BASE_PATH", dirname( __FILE__ ) );

/**
* Class which includes all the methods and files.
*
* @since 1.0.0
*/
class ccs_slider{
	function __construct(){
		$this->includes();
		add_action( 'init', array($this,'ccs_slider_image_sizes') );
		add_action( 'plugins_loaded', array($this,'cc_slider_load_textdomain') );
		add_action( 'wp_enqueue_scripts', array($this,'cc_slider_load_slider_css') );
		add_shortcode('cc-slider-sc', array($this,'custom_cc_slider') );
		add_action( 'admin_enqueue_scripts', array($this,'cc_slider_load_plugin_css') );
		add_action('wp_head',array($this,'ccs_generate_dynamic_style'));
	}

	/**
	* Adding new image size for plugin.
	*
	* @since 1.0.0
	*/
	function ccs_slider_image_sizes() {
		add_image_size( 'cc-feature', 1600, 650, true );
	}

	/**
	* Load plugin textdomain.
	*
	* @since 1.0.0
	*/
	function cc_slider_load_textdomain() {
		load_plugin_textdomain( 'cc-slider', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
	}

	/**
	* Enqueue slider style and scripts.
	*
	* @since 1.0.0
	*/
	function cc_slider_load_slider_css(){

		wp_enqueue_script( 'owl-carousel', CC_BASE_URL . 'assets/js/owl.carousel.js', array('jquery'),'',true);
		wp_enqueue_script( 'cc-slider-custom-slider', CC_BASE_URL . 'assets/js/custom.js', array('jquery'),'',true);
		wp_enqueue_style( 'owl-theme-css', CC_BASE_URL . 'assets/css/owl.theme.css');	

		wp_enqueue_style( 'owl-transitions-css', CC_BASE_URL . 'assets/css/owl.transitions.css');

		wp_enqueue_style( 'owl-carousel-css', CC_BASE_URL . 'assets/css/owl.carousel.css');	

		wp_enqueue_style( 'owl-custom-css', CC_BASE_URL . 'assets/css/custom.css');	

		wp_enqueue_style( 'owl-responsive-css', CC_BASE_URL . 'assets/css/responsive.css');	

		$options = get_option( 'cc_slider_settings' ); 
		$direction= $options['direction'];
		$control= $options['control'];
		$hover= $options['hover'];
		
		
		if($direction=='true')
		{
			$direction='1';
		}
		else{
		$direction='0';
		}
		
		if($control=='true')
		{
			$control='1';
		}
		else{
		$control='0';
		}
		
		if($hover=='true')
		{
			$hover='1';
		}
		else{
		$hover='0';
		}
		
		//Localize slider options for using them in slider control.
		wp_localize_script( 'cc-slider-custom-slider', 'phpInfo', array(
			'effect' => $options['animation'],
			'hover' => $hover,
			'pauseTime' => $options['slideshow']*1000,
			'directionNav' => $direction,
			'controlNav' => $control,
			));
	}


	/**
	* Generates shortcode for slider.
	*
	* @param object $query Global variable to filter the posts on archives page.
	* @since 1.0.0
	*/		
	function custom_cc_slider() { ?>

	<div id="owl-demo" class="owl-carousel owl-theme">
	<?php
	$ccs_slides = get_option('cc_slider_settings');
	global $post;
	$args = array( 		
	'posts_per_page' => $ccs_slides['slides'],  // Limit to selected number of posts.		
	'post_type' => 'cc-slider',  // Query for the 'slider' Post type. 		
	);
		$cc_query = new WP_Query( $args );
		
		if ( $cc_query->have_posts() ) {
			while ( $cc_query->have_posts() ) {
				$cc_query->the_post(); 
				if ( has_post_thumbnail() ) {
					$img_id = get_post_thumbnail_id();
					$img_url = wp_get_attachment_image_src($img_id,'cc-feature', true);
					$caption_url = get_post_meta($post->ID,'cc_slider_url',true);
					?>
					<div class="item">
					<?php
					if(!isset($ccs_slides['caption'])){ ?>
						<div class="ccs-caption">
							<div class="ccs-bg-overlay"></div>
							<div class="cc-caption-text">
							<h2><a class="caption-link" href="<?php echo esc_url($caption_url);?>" target="_blank"><?php the_title();?></a></h2>
							<p><?php echo get_the_content();  ?></p></div>
						</div>
					<?php } ?>
					<img src="<?php echo esc_url($img_url[0]); ?>" height="650" width="1600"/>
					
					</div>

					<?php 
				} 
			} 
			wp_reset_postdata();
		}
		?>

	</div>

	<?php }
	
	/**
	* Enqueue plugin style and scripts.
	*
	* @since 1.0.0
	*/
	function cc_slider_load_plugin_css($hook_suffix){

		wp_enqueue_style( 'plugin-css', CC_BASE_URL . 'assets/css/plugin.css');	
		wp_enqueue_style( 'wp-color-picker' );
    	wp_enqueue_script( 'ccs-script-handle', CC_BASE_URL. 'assets/js/ccs-script.js', array( 'wp-color-picker' ), false, true );

	}	

	/**
	* Includes dynamic styles.
	*
	* @since 1.0.0
	*/
	function ccs_generate_dynamic_style(){
		require_once( CC_BASE_PATH .'/assets/php/dynamic.php');
	}

	/**
	 * Includes the required files.
	 * @return void
	 */
	function includes(){
		// Admin section included.
		if( is_admin() ){
			require_once( CC_BASE_PATH .'/admin/cc-admin.php');
		}
		
	}
}
$object = new ccs_slider(); //Object for class.
