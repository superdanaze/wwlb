<?php
/**
 * 
 *
 *
 * Template Name: Custom Page
 *
 */

//	custom header atts
$header_style = get_field('header_color_scheme');
$has_logo = get_field('show_logo');


add_filter( 'body_class', 'ela_custom_body_class' );
/**
 * Adds landing page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function ela_custom_body_class( $classes ) {
	//	custom header atts
	global $header_style;
	global $has_logo;

	$classes[] = 'wwlb-page';
	$classes[] = $header_style;

	if ( !$has_logo ) $classes[] = 'no-logo';

	return $classes;

}


//	get logo
if ( $has_logo ) get_template_part( E_TEMPLATES , 'logo-select', array( 'header_style' => $header_style ) );

//  remove post title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

//  remove main wrapper
add_filter( 'genesis_markup_content', '__return_null' );

//	remove content sidebar wrapper
add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );


//  custom hero area
// if ( $custom_hero ) get_template_part( E_TEMPLATES . '-hero', $hero_type );

//	if ACF flexible content
// if ( have_rows( 'sections' ) ) get_template_part( E_TEMPLATE, 'acf-flexible' );


// Runs the Genesis loop.
genesis();