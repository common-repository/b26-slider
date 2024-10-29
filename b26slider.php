<?php

/* 
Plugin Name: B26 Slider
Plugin URI: http://sumonhasan.com/plugins/b26-slider/
Description: A simple wordpress image slider plugin. A responsive jQuery slideshow with beautiful panning effects plugin. It's very easy to use with a simple shortcode.
Version: 1.1.1
Author: Sumon Hasan
Author URI: http://www.sumonhasan.com
*/



// Start plugin custom post and others 
function bitm26slider_theme_setup()
{
	add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'bitm26slider_theme_setup');
/**
 *  Filter for widget
 */
add_filter('widget_text', 'do_shortcode');
/**
 *  Latest jquery callback from wordpress
 */
function b26_slider_latest_jquery()
{
	wp_enqueue_script('jquery');
}
add_action('init', 'b26_slider_latest_jquery');
/**
 *  B26 Slider style and script set up
 */

	function bitm26_style_script_setup()
	{
		wp_enqueue_style('bitm26-slider-css', plugins_url('/css/smoothslides.theme.css', __FILE__));	

		wp_enqueue_script('bitm26-slider-js', plugins_url('/js/smoothslides-2.2.1.min.js', __FILE__), array(
			'jquery'
		));
	}
	add_action('wp_enqueue_scripts', 'bitm26_style_script_setup');
// B26 slider options
function b26slider_options_panel()  
{  
	add_submenu_page('edit.php?post_type=b26slider_post','Settings', 'Settings', 'manage_options', 'b26slider-settings','b26slider_options_framwrork');  
}  
add_action('admin_menu', 'b26slider_options_panel');

// Default options values
$b26slider_options = array(
	'slidewidthc' => '1170',
	'slideheightc' => '500',
	'effectDurationv' => '6000',
	'transitionDurationv' => '500',
	'captionsv' =>  'true',
	'navigationv' =>  'true',
	'paginationv' =>  'true',
	'matchImageSizev' =>  'true',
	

);

if ( is_admin() ) : // Load only if we are viewing an admin page

function b26slider_settings_register() {
	// Register settings and call sanitation functions
	register_setting( 'b26slider_p_options', 'b26slider_options', 'b26slider_validate_options' );
}

add_action( 'admin_init', 'b26slider_settings_register' );

// Function to generate options page
function b26slider_options_framwrork() {
	global $b26slider_options;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap">

	<h2>B26 Slides Settings</h2>

	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
	<?php endif; ?>

	<form method="post" action="options.php">

	<?php $settings = get_option( 'b26slider_options', $b26slider_options ); ?>
	
	<?php settings_fields( 'b26slider_p_options' ); ?>

	
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="slidewidthc">Slider Crop Image Width</label></th>
			<td>
				<input id="slidewidthc" type="text" name="b26slider_options[slidewidthc]" value="<?php echo stripslashes($settings['slidewidthc']); ?>" class="my-color-field" /><p class="description">Insert your slider image width for cropping according to pixel.</p>
			</td>
		</tr>		
		<tr valign="top">
			<th scope="row"><label for="slideheightc">Slider Crop Image Height</label></th>
			<td>
				<input id="slideheightc" type="text" name="b26slider_options[slideheightc]" value="<?php echo stripslashes($settings['slideheightc']); ?>" class="my-color-field" /><p class="description">Insert your slider image height for cropping according to pixel.</p>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><label for="effectDurationv">Effect Duration</label></th>
			<td>
				<input id="effectDurationv" type="text" name="b26slider_options[effectDurationv]" value="<?php echo stripslashes($settings['effectDurationv']); ?>" class="my-color-field" /><p class="description">Length of time in milliseconds for the effect.</p>
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row"><label for="transitionDurationv">Transition Duration</label></th>
			<td>
				<input id="transitionDurationv" type="text" name="b26slider_options[transitionDurationv]" value="<?php echo stripslashes($settings['transitionDurationv']); ?>" class="my-color-field" /><p class="description">Length of time in milliseconds for the fade between slides.</p>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><label for="captionsv">Slider Captions</label></th>
			<td>
				<input type="radio" id="captionsv" name="b26slider_options[captionsv]" <?php if($settings['captionsv'] == 'true') echo 'checked="checked"'; ?> value="true" />Yes
				<input type="radio" id="captionsv" name="b26slider_options[captionsv]" <?php if($settings['captionsv'] == 'false') echo 'checked="checked"'; ?> value="false" />No
				<p class="description">Whether or not to display captions using the slider title. </p>
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row"><label for="navigationv">Slider Navigation</label></th>
			<td>
				<input type="radio" id="navigationv" name="b26slider_options[navigationv]" <?php if($settings['navigationv'] == 'true') echo 'checked="checked"'; ?> value="true" />Yes
				<input type="radio" id="navigationv" name="b26slider_options[navigationv]" <?php if($settings['navigationv'] == 'false') echo 'checked="checked"'; ?> value="false" />No
				<p class="description"> Whether or not to display previous/next buttons. </p>
			</td>
		</tr>
				
		<tr valign="top">
			<th scope="row"><label for="paginationv">Slider Paginationv</label></th>
			<td>
				<input type="radio" id="paginationv" name="b26slider_options[paginationv]" <?php if($settings['paginationv'] == 'true') echo 'checked="checked"'; ?> value="true" />Yes
				<input type="radio" id="paginationv" name="b26slider_options[paginationv]" <?php if($settings['paginationv'] == 'false') echo 'checked="checked"'; ?> value="false" />No<p class="description">Whether or not to display dots representing each slide. </p>
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row"><label for="matchImageSizev">Slider Match Image Size</label></th>
			<td>
				<input type="radio" id="matchImageSizev" name="b26slider_options[matchImageSizev]" <?php if($settings['matchImageSizev'] == 'true') echo 'checked="checked"'; ?> value="true" />Yes
				<input type="radio" id="matchImageSizev" name="b26slider_options[matchImageSizev]" <?php if($settings['matchImageSizev'] == 'false') echo 'checked="checked"'; ?> value="false" />No<p class="description"> 	True sets a maximum width based on your image sizes. False allows width to be greater than image size, scaling up the images. </p>
			</td>
		</tr>


	</table>
	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

	</form>
	</div>

	<?php
}

function b26slider_validate_options( $input ) {
	global $b26slider_options;

	$settings = get_option( 'b26slider_options', $b26slider_options );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS

	$input['effectDurationv'] = wp_filter_post_kses( $input['effectDurationv'] );
	$input['transitionDurationv'] = wp_filter_post_kses( $input['transitionDurationv'] );
	$input['captionsv'] = wp_filter_post_kses( $input['captionsv'] );
	$input['paginationv'] = wp_filter_post_kses( $input['paginationv'] );
	$input['navigationv'] = wp_filter_post_kses( $input['navigationv'] );
	$input['matchImageSizev'] = wp_filter_post_kses( $input['matchImageSizev'] );
	$input['slidewidthc'] = wp_filter_post_kses( $input['slidewidthc'] );
	$input['slideheightc'] = wp_filter_post_kses( $input['slideheightc'] );
	

	return $input;
}

endif;  // EndIf is_admin()


function active_b26slider() {?>

<?php global $b26slider_options; $b26slider_settings = get_option( 'b26slider_options', $b26slider_options ); ?>
	<script type="text/javascript">
		jQuery(window).load( function() {
			jQuery(document).smoothSlides({
			duration: <?php echo $b26slider_settings['effectDurationv']; ?>,
			transitionDuration: <?php echo $b26slider_settings['transitionDurationv']; ?>,
			captions: '<?php echo $b26slider_settings['captionsv']; ?>',
			navigation: '<?php echo $b26slider_settings['navigationv']; ?>',
			pagination: '<?php echo $b26slider_settings['paginationv']; ?>',
			
			});
		});
	</script>
<?php


}

add_action('wp_footer', 'active_b26slider');

// Image crop

 global $b26slider_options; $b26slider_settings = get_option( 'b26slider_options', $b26slider_options );

$slidewidthcv =  $b26slider_settings['slidewidthc'];
$slideheightcv =  $b26slider_settings['slideheightc'];
add_image_size( 'custom_crop', $slidewidthcv, $slideheightcv, array( 'center', 'center' ) );

// custom post


add_action('init', 'bitm26_ctm_post');
function bitm26_ctm_post()
{
	register_post_type('b26slider_post', array(
		'labels' => array(
			'name' => __('B26 Slider'),
			'singular_name' => __('B26 Slider'),
			'add_new_item' => __('Add New Slide'),
			'edit_item' => __('Edit Slider'),
			'view_item' => __('View Slider'),
			'featured_image' => __('Select your image for slider'),
			'set_featured_image' => __('Click here to set the slider image'),
			'remove_featured_image' => __('Remove slider image'),
			'use_featured_image' => __('Use as slider image')
			
		),
		'public' => true,
		'supports' => array(
			'title',
			'thumbnail'
		),
		'has_archive' => true,
		'menu_icon' => 'dashicons-tickets-alt',
		'rewrite' => array(
			'slug' => 'b26-slider-item'
		)
	));
	register_taxonomy('bitm_post_cat', //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
		'b26slider_post', //post type name
		array(
		'hierarchical' => true,
		'label' => 'Category', //Display name
		'query_var' => true,
		'rewrite' => array(
			'slug' => 'b26-slider-category', // This controls the base slug that will display before each term
			'with_front' => true // Don't display the category base before
			
		),
		'show_admin_column' => true  
	));

}

/**
 *  B26 Slider Shortcode Query
 */

function b26_slider_shortcode($atts)
{
	extract(shortcode_atts(array(
		'count' => '',
		'posttype' => 'b26slider_post',
		'category' => '',
	), $atts, 'wishlist'));
	
	$q = new WP_Query(array(
		'posts_per_page' => $count,
		'post_type' => $posttype,
		'bitm_post_cat' => $category
	));
	
	
	$list = '<div class="ss-slides">';
	while ($q->have_posts()):
		$q->the_post();
		global $post, $crop_image_url, $key_1, $key_2, $ver1, $ver2;
		$idd = get_the_ID();
		
		// Custom link condition
		$key_1 = get_post_meta( get_the_ID(), 'metalink', true );
		$key_2 = get_permalink();

		if (!empty($key_1)) {
			$ver1 = $key_1;
		}
		else{
			$ver2 = $key_2;
		}

		if (has_post_thumbnail()) {
			$crop_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'custom_crop');
		}

		$list .= '
	    <div class="ss-slide" title="' .get_the_title(). '">
	       <a href="'.$ver1.''.$ver2.'"><img src="' . $crop_image_url[0] . '" alt="' .get_the_title(). '"/> </a>
	    </div>';
	endwhile;
	$list .= '</div>';
	wp_reset_query();
	return $list;
}
add_shortcode('b26slider', 'b26_slider_shortcode');
/**
 *  Featured image metabox customise
 */

add_action('do_meta_boxes', 'b26slider_image_box');
function b26slider_image_box()
{
	global $img_width, $img_height;


	remove_meta_box('postimagediv', 'b26slider_post', 'side');
	add_meta_box('postimagediv', __('Select your image for '. $img_width .'x'. $img_height .' B26 slider'), 'post_thumbnail_meta_box', 'b26slider_post', 'normal', 'high');
}
$img_width =  $b26slider_settings['slidewidthc'];
$img_height =  $b26slider_settings['slideheightc'];


// Add meta box to the post edit screen.
function b26_custom_meta() {

	// Will display on the top right of the edit post page
	add_meta_box( 
		
		'b26_meta_id', 
		'Slide Custom Link:', 
		'b26_meta_callback', 
		'b26slider_post',
		'normal',
		'low'
	); 

} // end b26_custom_meta

add_action( 'add_meta_boxes', 'b26_custom_meta' );

// Output meta box content
function b26_meta_callback( $post ) {

	// Verify meta content
	wp_nonce_field( basename( __FILE__ ), 'b26_nonce' );
	$example_stored_meta = get_post_meta( $post->ID );
	
	?>
	<p><!-- meta text input -->
		<label for="metalink" class="example-row-title"></label>
		<input placeholder="http://" type="text" name="metalink" id="metalink" value="<?php echo ( isset( $example_stored_meta['metalink'] ) ? $example_stored_meta['metalink'][0] : '' ); ?>" />
	</p>
	
	<?php

} // end meta callback function


// Save custom meta input
function b26_meta_save( $post_id ) {

	// Check save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = (isset($_POST[ 'b26_nonce' ] ) && wp_verify_nonce( $_POST[ 'b26_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	
	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
	
		return;
	
	}
	
	// Checks for and sanitizes text input, saves if needed
	// For text input
	if (isset( $_POST['metalink'] ) ) {
	
		update_post_meta( $post_id, 'metalink', sanitize_text_field( $_POST['metalink'] ) );
	}
	
} // end b26_meta_save function

add_action( 'save_post', 'b26_meta_save' );

include_once('widget.php');