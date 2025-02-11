<?php
/**
 * SmartMag Child Theme functions.php
 *
 * Please refer to smart-mag/functions.php and smart-mag/inc/theme.php for framework setup.
 */

/**
 * Enqueue the CSS. Please note the CSS order is as follows:
 *
 *  - smart-mag/style.css
 *  - smart-mag/css/skin-XYZ.css
 *  - smart-mag-child/style.css
 *  - Inline Custom CSS from Customize
 */
function my_enqueue_child_style() {
	wp_enqueue_style(
		'smart-mag-child', 
		get_stylesheet_uri(),
		['smartmag-core'],
		'1.0'
	);
}

// Enqueue child theme CSS after parent is registered.
add_action('bunyad_register_assets', 'my_enqueue_child_style');

// Alternatively, you may use:
// add_action('wp_enqueue_style', 'my_enqueue_child_style', 11);

// OR, to enqueue after Customizer Additional CSS:
// add_action('wp_head', 'my_enqueue_child_style', 110);
